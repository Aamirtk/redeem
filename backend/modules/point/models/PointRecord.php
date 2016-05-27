<?php

namespace backend\modules\point\models;

use Yii;

/**
 * This is the model class for table "vso_point_record".
 *
 * @property integer $rdid
 * @property integer $uid
 * @property string $username
 * @property integer $obj_id
 * @property string $obj_type
 * @property integer $rid
 * @property string $raction
 * @property integer $chid
 * @property integer $point
 * @property integer $created_at
 * @property integer $updated_at
 */
class PointRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_point_record';
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
            [['uid', 'obj_id', 'rid', 'chid', 'point', 'created_at', 'updated_at'], 'integer'],
            [['obj_type'], 'required'],
            [['username'], 'string', 'max' => 30],
            [['obj_type'], 'string', 'max' => 64],
            [['raction'], 'string', 'max' => 20],
            [['created_at'], 'default', 'value' => time()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rdid' => '明细ID',
            'uid' => '用户ID',
            'username' => '用户名',
            'obj_id' => '对象ID',
            'obj_type' => '对象类型',
            'rid' => '规则ID',
            'raction' => '规则key',
            'chid' => '频道ID',
            'point' => '积分值',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 根据规则Key获取对应的对象类型
     * @param $action 规则Key
     * @return string 对象类型
     */
    public static function getObjTypeByAction($action)
    {
        $obj_type = '';
        if (empty($action))
        {
            return $obj_type;
        }
        // 规则Key分隔成数组，数组第一个元素作为obj_type
        $explode_arr = explode("_", $action);
        $obj_type = isset($explode_arr[0]) ? $explode_arr[0] : '';
        return $obj_type;
    }

    /**
     * 获取应该赠送给用户的积分
     * $action与$obj_id组合主键，已经赠送的不再重复赠送
     * @todo，增加积分上限
     * @param $action 规则Key
     * @param $obj_id 对象编号
     * @param string $username
     * @return int 应该赠送给用户的积分值
     */
    public static function getPointToUser($action, $obj_id, $username)
    {
        if (empty($action) || empty($obj_id))
        {
            return 0;
        }
        // 积分明细是否存在
        $query = self::find()->where(['obj_id' => $obj_id, 'raction' => $action]);
        if ($action == 'task_b_delivery')
        {
            $query->andWhere(['username' => $username]);
        }
        $record_exist = $query->count();
        // 已存在的不再赠送
        if ($record_exist)
        {
            return 0;
        }
        // 规则表中取应该赠送给用户的积分值
        return PointConfigRule::getPointByRuleAction($action);
    }
}
