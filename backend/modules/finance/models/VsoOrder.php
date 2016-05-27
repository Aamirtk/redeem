<?php

namespace backend\modules\finance\models;

use Yii;

/**
 * This is the model class for table "vso_order".
 *
 * @property string $order_uc_id
 * @property integer $order_trade_id
 * @property string $pay_model
 * @property string $order_name
 * @property double $order_amount
 * @property integer $order_status
 * @property string $order_desc
 * @property integer $order_uid
 * @property string $order_username
 * @property integer $seller_uid
 * @property string $seller_username
 * @property integer $payment_type
 * @property integer $model_id
 * @property integer $deleted
 * @property integer $obj_id
 * @property string $obj_type
 * @property string $token
 * @property integer $userip
 * @property integer $create_time
 * @property string $return_url
 * @property string $notify_url
 * @property string $fina_action
 * @property string $income_account
 * @property string $fina_mem
 */
class VsoOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_order';
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
            [['order_uc_id', 'order_trade_id'], 'required'],
            [['order_trade_id', 'order_status', 'order_uid', 'seller_uid', 'payment_type', 'model_id', 'deleted', 'obj_id', 'userip', 'create_time'], 'integer'],
            [['order_amount'], 'number'],
            [['fina_mem'], 'string'],
            [['order_uc_id'], 'string', 'max' => 25],
            [['pay_model', 'order_username', 'obj_type', 'fina_action'], 'string', 'max' => 20],
            [['order_name', 'order_desc', 'token', 'return_url', 'notify_url'], 'string', 'max' => 200],
            [['seller_username'], 'string', 'max' => 30],
            [['income_account'], 'string', 'max' => 50],
            [['token'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_uc_id' => 'Order Uc ID',
            'order_trade_id' => 'trade生成的订单ID',
            'pay_model' => '支付类型',
            'order_name' => '订单名称',
            'order_amount' => '订单总金额',
            'order_status' => '支付状态默认0未支付 1支付成功',
            'order_desc' => '订单描述',
            'order_uid' => '购买者ID',
            'order_username' => '购买者用户名',
            'seller_uid' => '出售者ID',
            'seller_username' => '出售者用户名',
            'payment_type' => '购买类型：默认1现金 2虚拟币',
            'model_id' => '类型如商品，需求（单人，计件）等',
            'deleted' => '订单状态0 默认没删除  1表示删除',
            'obj_id' => '对象ID',
            'obj_type' => 'Obj Type',
            'token' => 'token标记',
            'userip' => '用户IP',
            'create_time' => '生成时间',
            'return_url' => '同步业务处理地址',
            'notify_url' => '异步业务处理地址',
            'fina_action' => 'Fina Action',
            'income_account' => 'Income Account',
            'fina_mem' => 'Fina Mem',
        ];
    }
}
