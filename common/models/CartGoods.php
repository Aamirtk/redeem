<?php

namespace common\models;

use Yii;

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
}
