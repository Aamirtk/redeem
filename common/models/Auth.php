<?php

namespace common\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "{{%auth}}".
 *
 * @property integer $auth_id
 * @property integer $uid
 * @property string $nick
 * @property string $name
 * @property string $avatar
 * @property integer $mobile
 * @property string $email
 * @property integer $user_type
 * @property string $wechat_openid
 * @property integer $auth_status
 * @property string $reason
 * @property integer $update_at
 * @property integer $create_at
 */
class Auth extends \yii\db\ActiveRecord
{
    /**
     * 用户类型
     */
    const TYPE_COMMON = 1;//普通用户
    const TYPE_SELLER = 2;//销售
    const TYPE_DESIGNER = 3;//家装设计师

    const CHECK_WAITING = 1;//待审核
    const CHECK_PASS = 2;//审核通过
    const CHECK_UNPASS = 2;//审核不通过

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'mobile', 'user_type', 'auth_status', 'create_at', 'update_at'], 'integer'],
            [['auth_status'], 'required'],
            [['nick', 'name'], 'string', 'max' => 30],
            [['avatar'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 40],
            [['wechat_openid'], 'string', 'max' => 50],
            [['reason'], 'string', 'max' => 500],
            [['create_at', 'update_at'], 'default', 'value' => time()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auth_id' => '认证ID',
            'uid' => '用户ID',
            'nick' => '微信昵称',
            'name' => '真实姓名',
            'avatar' => '微信头像',
            'mobile' => '手机号码',
            'email' => '邮箱',
            'user_type' => '用户类型（1-普通用户；2-销售；3-家装设计师）',
            'auth_status' => '认证状态（1-待审核；2-审核通过；3-审核不通过）',
            'reason' => '审核不通过的原因',
            'create_at' => '创建时间',
        ];
    }

    /**
     * 获取信息
     * @param $where array
     * @return array|boolean
     **/
    public function _get_info($where = []) {
        if (empty($where)) {
            return false;
        }

        $obj = self::findOne($where);
        if (!empty($obj)) {
            return $obj->toArray();
        }
        return false;
    }

    /**
     * 获取列表
     * @param $where array
     * @param $order string
     * @return array|boolean
     */
    public function _get_list($where = [], $order = 'created_at desc', $page = 1, $limit = 20) {
        $_obj = self::find();
        if (isset($where['sql']) || isset($where['params'])) {
            $_obj->where($where['sql'], $where['params']);
        } else if (is_array($where)) {
            $_obj->where($where);
        }

        $_obj->orderBy($order);

        if (!empty($limit)) {
            $offset = max(($page - 1), 0) * $limit;
            $_obj->offset($offset)->limit($limit);
        }
        return $_obj->asArray(true)->all();
    }

    //获取总条数
    public function _get_count($where = []) {
        $_obj = self::find();
        if (isset($where['sql']) || isset($where['params'])) {
            $_obj->where($where['sql'], $where['params']);
        } else {
            $_obj->where($where);
        }
        return intval($_obj->count());
    }

    /**
     * 添加记录-返回新插入的自增id
     **/
    public static function _add($data) {
        if (!empty($data) && !empty($data['username'])) {
            try {
                $_mdl = new self;

                foreach ($data as $k => $v) {
                    $_mdl->$k = $v;
                }
                if(!$_mdl->validate()) {//校验数据
                    return false;
                }
                $ret = $_mdl->insert();
                if ($ret !== false) {
                    return self::getDb()->getLastInsertID();
                }
                return false;
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * 保存记录
     * @param $data array
     * @return array|boolean
     */
    public function _save($data) {
        if (!empty($data)) {
            $_mdl = new self();

            try {
                foreach ($data as $k => $v) {
                    $_mdl->$k = $v;
                }
                if(!$_mdl->validate()) {//校验数据
                    return false;
                }

                if (!empty($data['auth_id'])) {//修改
                    $id = $data['auth_id'];
                    $ret = $_mdl->updateAll($data, ['auth_id' => $id]);
                } else {//增加
                    $ret = $_mdl->insert();
                }

                if ($ret !== false) {
                    return true;
                }
                return false;
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * 删除记录
     * @param $where array
     * @return array|boolean
     */
    public static function _delete($where) {
        if (empty($where)) {
            return false;
        }
        try {
            return (new self)->deleteAll($where);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 用户类型
     * @param $type int
     * @return array|boolean
     */
    public static function _get_user_type($type = 1){
        switch(intval($type)){
            case self::TYPE_COMMON:
                $_name = '普通用户';
                break;
            case self::TYPE_SELLER:
                $_name = '销售';
                break;
            case self::TYPE_DESIGNER:
                $_name = '家装设计师';
                break;
            default:
                $_name = '销售';
                break;
        }
        return $_name;
    }
}
