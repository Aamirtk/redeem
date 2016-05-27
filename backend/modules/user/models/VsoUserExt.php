<?php

namespace backend\modules\user\models;

use backend\modules\point\models\PointConfigLevel;
use backend\modules\point\models\PointConfigRule;
use backend\modules\point\models\PointRecord;
use common\models\UserModel;
use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "{{%ext}}".
 *
 * @property integer $accountid
 * @property string $uid
 * @property string $username
 * @property integer $credit
 * @property string $balance
 * @property integer $status
 * @property integer $type
 * @property integer $total
 * @property integer $warn
 * @property string $warn_status
 * @property integer $up_time
 * @property string $des
 * @property integer $level
 * @property integer $score
 * @property integer $exp
 * @property integer $point
 * @property integer $point_level
 * @property integer $extended
 */
class VsoUserExt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ext}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_uc');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['credit', 'status', 'type', 'total', 'warn', 'up_time', 'level', 'score', 'exp', 'point', 'point_level', 'extended'], 'integer'],
            [['balance'], 'number'],
            [['uid', 'username'], 'string', 'max' => 30],
            [['warn_status', 'des'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'accountid' => 'Accountid',
            'uid' => 'Uid',
            'username' => 'Username',
            'credit' => '创意币',
            'balance' => '人民币',
            'status' => 'Status',
            'type' => 'Type',
            'total' => 'Total',
            'warn' => 'Warn',
            'warn_status' => 'Warn Status',
            'up_time' => 'Up Time',
            'des' => 'Des',
            'level' => '经验等级',
            'score' => '积分',
            'exp' => '经验值',
            'point' => '积分',
            'point_level' => '用户积分等级',
            'extended' => 'Extended',
        ];
    }

    /**
     * 获取用户的积分等级
     * @param $username 用户名
     * @return int
     */
    public static function getUserPointLevel($username)
    {
        if (empty($username))
        {
            return 0;
        }
        $level = self::find()->select('point_level')->where(['username' => $username])->scalar();
        return intval($level);
    }

    /**
     * 获取用户积分值
     * @param $username
     * @return int
     */
    public static function getUserPoint($username)
    {
        if (empty($username))
        {
            return 0;
        }
        $point = self::find()->select('point')->where(['username' => $username])->scalar();
        return intval($point);
    }

    /**
     * 为用户增加积分值，涉及用户积分等级升等
     * 用户等级升等
     * 使用事务处理数据
     * @todo，每天积分上限，目前不考虑
     * @todo，站内信，目前不考虑
     * @param string $username 用户名
     * @param string $action 规则Key
     * @param integer $obj_id 对象编号
     * @param string $obj_type 对象类型
     * @return bool（true=>操作成功，false=>操作失败）
     */
    public static function increaseUserPoint($username, $action, $obj_id, $obj_type)
    {
        $result = false;
        if (empty($username) || empty($action) || empty($obj_id) || empty($obj_type))
        {
            return $result;
        }
        $userExt = self::findOne(['username' => $username]);
        // 获取应该赠送用户的积分值
        $point = PointRecord::getPointToUser($action, $obj_id, $username);

        $trans = self::getDb()->beginTransaction();
        try
        {
            // 数据不存在时插入数据，部分用户在vso_user_ext表中不存在
            if (empty($userExt))
            {
                // 从keke_witkey_space表中取用户的财务数据，初始化vso_user_ext
                $userExt = new VsoUserExt();
                $spaceModel = KekeWitkeySpace::findOne(['username' => $username]);
                $balance = isset($spaceModel->balance) && !empty($spaceModel->balance) ? $spaceModel->balance : 0;
                $credit = isset($spaceModel->credit) && !empty($spaceModel->credit) ? $spaceModel->credit : 0;
                $userExt->setAttributes([
                    'username' => $username,
                    'uid' => UserModel::getUserIdByUsername($username),
                    'create' => $credit,
                    'balance' => $balance,
                    'point' => $point,
                    'up_time' => time()
                ]);
                $result = $userExt->save();
            }
            // 在用户的原有积分上增加$point点
            elseif ($point > 0)
            {
                $userExt->setAttributes([
                    'point' => intval($userExt->point) + $point,
                    'up_time' => time()
                ]);
                $result = $userExt->save();
            }
            // 增加0积分，直接返回
            else
            {
                return true;
            }
            // 操作成功，用户升级&写积分明细
            if ($result)
            {
                // 写积分明细
                $record = new PointRecord();
                $record->setAttributes([
                    'uid' => UserModel::getUserIdByUsername($username),
                    'username' => $username,
                    'rid' => PointConfigRule::getRuleIdByAction($action),
                    'raction' => $action,
                    'chid' => PointConfigRule::getChannelIdByAction($action),
                    'point' => $point,
                    'obj_id' => $obj_id,
                    'obj_type' => $obj_type
                ]);
                $record->save();
                $trans->commit();

                return $result;
            }
            else
            {
                $trans->rollBack();
                return false;
            }
        }
        catch (Exception $e)
        {
            $trans->rollBack();
            return false;
        }
        // 用户升级
        self::increaseUserPointLevel($username);
    }

    /**
     * 用户积分等级升级自动计算
     * 用户当前积分满足升级条件则自动升级，不满足直接返回
     * 升级条件：用户当前积分值 <= 等级表中X等级的积分值（X取最大值），则将用户升级到X级
     * @param $username 用户名
     * @return bool（true=>升级成功，false=>升级失败）
     */
    public static function increaseUserPointLevel($username)
    {
        if (empty($username))
        {
            return false;
        }

        $userExt = self::findOne(['username' => $username]);
        if (empty($userExt))
        {
            return false;
        }
        $old_level = $userExt->point_level;
        $new_level = PointConfigLevel::getLevelByPoint($userExt->point);
        // 符合升级条件
        if ($new_level >= $old_level)
        {
            $userExt->setAttribute('point_level', $new_level);
            return $userExt->save();
        }
        // 不需要升级，直接返回
        else
        {
            return true;
        }
    }
}
