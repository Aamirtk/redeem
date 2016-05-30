<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods}}".
 *
 * @property integer $gid
 * @property string $goods_id
 * @property string $name
 * @property string $thumb
 * @property string $thumb_list
 * @property string $description
 * @property integer $redeem_pionts
 * @property integer $goods_status
 * @property integer $create_at
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods}}';
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
            [['thumb_list', 'description'], 'string'],
            [['redeem_pionts', 'goods_status', 'create_at'], 'integer'],
            [['goods_id'], 'string', 'max' => 40],
            [['name'], 'string', 'max' => 50],
            [['thumb'], 'string', 'max' => 120]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => '商品ID',
            'goods_id' => '商品编号',
            'name' => '商品名称',
            'thumb' => '商品缩略图',
            'thumb_list' => '商品图列表',
            'description' => '商品详情',
            'redeem_pionts' => '兑换积分',
            'goods_status' => '状态（1-上架；2-下架；3-删除）',
            'create_at' => '创建时间',
        ];
    }
}
