<?php

namespace common\models;

use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $uid
 * @property string $nick
 * @property string $name
 * @property string $avatar
 * @property integer $mobile
 * @property string $email
 * @property integer $points
 * @property integer $user_type
 * @property string $wechat_openid
 * @property integer $user_status
 * @property integer $update_at
 * @property integer $create_at
 */
class User extends \yii\db\ActiveRecord
{

    /**
     * 用户类型
     */
    const TYPE_COMMON = 1;//普通用户
    const TYPE_SELLER = 2;//销售
    const TYPE_DESIGNER = 3;//家装设计师

    const NO_DELETE = 1;//启用
    const IS_DELETE = 2;//禁用


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile', 'points', 'user_type', 'user_status', 'update_at', 'create_at'], 'integer'],
            [['nick', 'name'], 'string', 'max' => 30],
            [['avatar'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 40],
            [['wechat_openid'], 'string', 'max' => 50],
            [['create_at', 'update_at'], 'default', 'value' => time()]
        ];
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
    public function attributeLabels()
    {
        return [
            'uid' => '用户ID',
            'nick' => '用户微信昵称',
            'name' => '用户真实姓名',
            'avatar' => '用户微信头像',
            'mobile' => '用户手机号码',
            'email' => '用户邮箱',
            'points' => '积分',
            'user_type' => '用户类型（1-普通用户；2-销售；3-家装设计师）',
            'wechat_openid' => '微信Open Id',
            'user_status' => '状态（1-启用；2-禁用）',
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

    /**
     * 获取总条数
     * @param $where array
     * @return int
     */
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

                if (!empty($data['uid'])) {//修改
                    $id = $data['uid'];
                    $ret = $_mdl->updateAll($data, ['uid' => $id]);
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

    /**
     * 用户状态
     * @param $status int
     * @return array|boolean
     */
    public static function _get_user_status($status = 1){
        switch(intval($status)){
            case self::NO_DELETE:
                $_name = '启用';
                break;
            case self::TYPE_SELLER:
                $_name = '禁用';
                break;
            default:
                $_name = '启用';
                break;
        }
        return $_name;
    }




}
