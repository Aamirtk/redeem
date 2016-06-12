<?php

namespace common\models;

use Yii;
use yii\console\Exception;

/**
 * This is the model class for table "{{%address}}".
 *
 * @property integer $add_id
 * @property integer $uid
 * @property string $receiver_name
 * @property string $receiver_phone
 * @property integer $province
 * @property integer $city
 * @property integer $county
 * @property string $detail
 * @property integer $receive_time
 * @property integer $type
 * @property integer $is_default
 * @property integer $is_deleted
 * @property integer $create_at
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * 收货时间
     */
    const REC_ALLDAY = 1;//一周七日
    const REC_WORKDAY = 2;//工作日
    const REC_HOLIDAY = 3;//双休及节假

    /**
     * 地址类型
     */
    const ADDR_HOME = 1;//家庭地址
    const ADDR_COMPANY = 2;//公司地址
    const ADDR_OTHER = 3;//其他

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%address}}';
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
            [['uid', 'province', 'city', 'county', 'receive_time', 'type', 'is_default', 'is_deleted', 'create_at'], 'integer'],
            [['detail'], 'required'],
            [['detail'], 'string'],
            [['receiver_name'], 'string', 'max' => 50],
            [['receiver_phone'], 'string', 'max' => 12]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'add_id' => '地址ID',
            'uid' => '用户ID',
            'receiver_name' => '收货人姓名',
            'receiver_phone' => '收货人联系方式',
            'province' => '省ID',
            'city' => '市ID',
            'county' => '县ID',
            'detail' => '详细地址',
            'receive_time' => '收货时间（1-一周七日；2-工作日；3-双休及节假）',
            'type' => '地址类型（1-家庭地址；2-公司地址；3-其他）',
            'is_default' => '是否为默认（1-否；2-是）',
            'is_deleted' => '是否已经删除（1-未删除；2-已经删除）',
            'create_at' => '创建时间',
        ];
    }

    /**
     * 关联表-hasMany
     **/
    public function getCheck() {
        return $this->hasOne(Check::className(), ['id' => 'check_id']);
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

                if (!empty($data['add_id'])) {//修改
                    $id = $data['add_id'];
                    $ret = $_mdl->updateAll($data, ['add_id' => $id]);
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
    public function _delete($where) {
        if (!empty($where)) {
            try {
                return (new self)->deleteAll($where);
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

}
