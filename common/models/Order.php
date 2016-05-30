<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $oid
 * @property integer $gid
 * @property string $goods_id
 * @property string $goods_name
 * @property string $buyer_phone
 * @property string $buyer_name
 * @property integer $order_status
 * @property integer $is_deleted
 * @property integer $update_at
 * @property integer $create_at
 */
class Order extends \yii\db\ActiveRecord
{
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
            [['gid', 'order_status', 'is_deleted', 'update_at', 'create_at'], 'integer'],
            [['goods_id'], 'string', 'max' => 40],
            [['goods_name', 'buyer_name'], 'string', 'max' => 50],
            [['buyer_phone'], 'string', 'max' => 12]
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
            'goods_id' => '商品编号',
            'goods_name' => '商品名称',
            'buyer_phone' => '联系方式',
            'buyer_name' => 'Buyer Name',
            'order_status' => '订单状态（1-待付款；2-待发货；3-待收货；4-已完成；5-已撤销；6-待评论）',
            'is_deleted' => '是否删除(1-未删除；2-已删除)',
            'update_at' => '更新时间',
            'create_at' => '创建时间',
        ];
    }
}
