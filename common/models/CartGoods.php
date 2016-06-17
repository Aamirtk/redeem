<?php

namespace common\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "{{%cart_goods}}".
 *
 * @property integer $id
 * @property integer $cart_id
 * @property integer $gid
 * @property integer $count
 * @property integer $create_at
 */
class CartGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cart_goods}}';
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
            [['cart_id', 'gid', 'count', 'create_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '购物车商品ID',
            'cart_id' => '购物车ID',
            'gid' => '商品ID',
            'count' => '商品数量',
            'create_at' => '创建时间',
        ];
    }

    /**
     * 关联表-hasOne
     **/
    public function getUser() {
        return $this->hasOne(User::className(), ['uid' => 'uid']);
    }

    /**
     * 关联表-hasMany
     **/
    public function getGoods() {
        return $this->hasOne(Goods::className(), ['gid' => 'gid']);
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

        if(!empty($order)){
            $_obj->orderBy($order);
        }

        if (!empty($limit)) {
            $offset = max(($page - 1), 0) * $limit;
            $_obj->offset($offset)->limit($limit);
        }
        return $_obj->asArray(true)->all();
    }

    /**
     * 获取列表
     * @param $where array
     * @param $order string
     * @return array|boolean
     */
    public function _get_list_all($where = [], $order = '', $page = 1, $limit = 0) {
        $_obj = self::find();
        if (isset($where['sql']) || isset($where['params'])) {
            $_obj->where($where['sql'], $where['params']);
        } else if (is_array($where)) {
            $_obj->where($where);
        }

        if(!empty($order)){
            $_obj->orderBy($order);
        }

        if (!empty($limit)) {
            $offset = max(($page - 1), 0) * $limit;
            $_obj->offset($offset)->limit($limit);
        }
        return $_obj->with('user')->with('goods')->asArray(true)->all();
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
    public function _add($data) {
        if (!empty($data) && !empty($data['username'])) {
            try {
                $_mdl = new self;

                foreach ($data as $k => $v) {
                    $_mdl->$k = $v;
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
                if (!empty($data['id'])) {//修改
                    $id = $data['id'];
                    $ret = $_mdl->updateAll($data, ['id' => $id]);
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
     * 添加商品
     * @param $data array
     * @return array|boolean
     */
    public function _add_goods($data)
    {
        $g_mdl = new Goods();
        $c_mdl = new self();
        //gid
        if(empty($data['gid'])){
            return [-20001, '商品id为空'];
        }
        $gid = $data['gid'];
        $goods = $g_mdl->_get_info(['gid' => $gid, 'goods_status' => $g_mdl::STATUS_UPSHELF]);
        if(!$goods){
            return [-20002, '商品不存在'];
        }
        $uid = $goods['uid'];
        //count
        if(empty($data['count']) || intval($data['count']) <= 0){
            return [-20003, '商品数量必须为正'];
        }
        $count = intval($data['count']);

        $cart_id = User::_get_cart($uid);;
        if(!$cart_id){
            return [-20004, '购物车不存在'];
        }

        $res = $c_mdl->_save([
            'cart_id' => $cart_id,
            'gid' => $gid,
            'count' => $count,
            'update_at' => time(),
        ]);
        if(!$res){
            return [-20005, '保存失败'];
        }
        return [20000, '保存成功'];
    }
}
