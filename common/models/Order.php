<?php

namespace common\models;

use Yii;
use yii\db\Exception;
use common\models\Address;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $oid
 * @property integer $gid
 * @property integer $uid
 * @property string $goods_id
 * @property string $goods_name
 * @property string $points_cost
 * @property integer $order_status
 * @property integer $add_id
 * @property integer $is_deleted
 * @property integer $update_at
 * @property integer $create_at
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * 商品状态
     */
    const STATUS_PAY        = 1;//待付款
    const STATUS_SEND       = 2;//待发货
    const STATUS_RECEIVE    = 3;//待收货
    const STATUS_DONE       = 4;//已完成
    const STATUS_UNDO       = 5;//已撤销
    const STATUS_COMMENT    = 6;//待评论

    /**
     * 是否删除
     */
    const NO_DELETE = 1;//未删除、正常
    const IS_DELETE = 2;//删除


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
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
            [['gid', 'uid', 'order_status', 'points_cost', 'add_id', 'is_deleted', 'update_at', 'create_at'], 'integer'],
            [['goods_id'], 'string', 'max' => 40],
            [['goods_name'], 'string', 'max' => 50],
            [['create_at'], 'default', 'value' => time()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'oid' => '订单ID',
            'gid' => '商品ID',
            'uid' => '用户ID',
            'goods_id' => '商品编号',
            'goods_name' => '商品名称',
            'points_cost' => '所需积分',
            'order_status' => '订单状态（1-待付款；2-待发货；3-待收货；4-已完成；5-已撤销；6-待评论）',
            'add_id' => '地址ID',
            'is_deleted' => '是否删除(1-未删除；2-已删除)',
            'update_at' => '更新时间',
            'create_at' => '创建时间',
        ];
    }

    /**
     * 关联表-hasMany
     **/
    public function getAddress() {
        return $this->hasOne(Address::className(), ['add_id' => 'add_id']);
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

        $obj = self::find();
        return $obj->where($where)
            ->joinWith('address')
            ->asArray(true)
            ->one();
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

        return $_obj->joinWith('address')->asArray(true)->all();
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

                if (!empty($data['oid'])) {//修改
                    $id = $data['oid'];
                    $ret = $_mdl->updateAll($data, ['oid' => $id]);
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

    /**
     * 添加记录
     * @param $gids array
     * @param $uid int
     * @param $add_id int
     * @return array|boolean
     */
    public function _add_orders($uid, $gids, $add_id) {
        //参数验证
        if(empty($uid) ||empty($gids) ||empty($add_id)){
            return ['code' => -20002, 'msg' => '参数不合法'];
        }
        $u_mdl = new User();
        $cg_mdl = new CartGoods();
        $p_mdl = new Points();
        $r_mdl = new self();

        //积分数是否足够
        $user = $u_mdl->_get_info(['uid' => $uid]);
        $points = $user['points'];
        $total_points = 0;
        $list = $cg_mdl->_get_list_all(['in' , 'id', $gids]);
        if($list){
            foreach($list as $val){
                $total_points += $val['count'] * getValue($val, 'goods.redeem_pionts', 0);
            }
        }

        if($points < $total_points){
            return ['code' => -20003, 'msg' => '您的积分数量不够'];
        }


        //开启事务
        $transaction = yii::$app->db->beginTransaction();
        try {

            foreach($gids as $key => $cg_id){
                //生成订单
                $good = $cg_mdl->_get_info_all([$cg_mdl::tableName() . '.id' => $cg_id]);
                if(!$good){
                    $transaction->rollBack();
                    throw new Exception('商品信息不存在或者已经下架');
                }
                $cost_points =  $good['count'] * getValue($good, 'goods.redeem_pionts', 0);
                $_data = [
                    'gid' => $good['gid'],
                    'uid' => $uid,
                    'goods_id' => getValue($good, 'goods.goods_id', ''),
                    'goods_name' => getValue($good, 'goods.goods_name', ''),
                    'add_id' => $add_id,
                    'points_cost' => $cost_points,
                    'order_status' => self::STATUS_SEND,
                    'update_at' => time(),
                ];
                $ret = $r_mdl->_save($_data);
                if(!$ret){
                    $transaction->rollBack();
                    throw new Exception('订单保存失败');
                }

                //更新积分，生成记录
                $res = $p_mdl->_dec_points($uid, $cost_points);
                if($res['code'] < 0){
                    $transaction->rollBack();
                    throw new Exception($res['msg']);
                }
            }

            //执行
            $transaction->commit();

            return ['code' => 20000, 'msg' => '保存成功！', 'data' => ['uid' => $uid]];

        } catch (Exception $e) {
            $transaction->rollBack();
            return ['code' => -20000, 'msg' => $e->getMessage()];
        }

    }

    /**
     * 订单状态
     * @param $status int
     * @return array|boolean
     */
    public static function _get_order_status($status = 1){
        switch(intval($status)){
            case self::STATUS_PAY:
                $_name = '待付款';
                break;
            case self::STATUS_SEND:
                $_name = '待发货';
                break;
            case self::STATUS_RECEIVE:
                $_name = '待收货';
                break;
            case self::STATUS_DONE:
                $_name = '已完成';
                break;
            case self::STATUS_UNDO:
                $_name = '已撤销';
                break;
            case self::STATUS_COMMENT:
                $_name = '待评论';
                break;

            default:
                $_name = '';
                break;
        }
        return $_name;
    }

    /**
     * 订单状态列表
     * @return array|boolean
     */
    public static function _get_status_list(){
        $statusArr = [];
        $statusArr[self::STATUS_PAY]     = '待付款';
        $statusArr[self::STATUS_SEND]    = '待发货';
        $statusArr[self::STATUS_RECEIVE] = '待收货';
        $statusArr[self::STATUS_DONE]    = '已完成';
        $statusArr[self::STATUS_UNDO]    = '已撤销';
        $statusArr[self::STATUS_COMMENT] = '待评论';

        return $statusArr;
    }


}
