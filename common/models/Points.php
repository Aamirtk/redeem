<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%points}}".
 *
 * @property integer $pid
 * @property string $name
 * @property integer $type
 * @property integer $goods_id
 * @property string $goods_name
 * @property integer $points
 * @property integer $create_at
 */
class Points extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%points}}';
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
            [['type', 'goods_id', 'points', 'create_at'], 'integer'],
            [['name'], 'string', 'max' => 40],
            [['goods_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pid' => 'Pid',
            'name' => '积分规则名称',
            'type' => '积分类型（1-关注；2-认证；3-手机认证；4-每日签到；5-分享微信；6-奖励积分）',
            'goods_id' => '商品编号',
            'goods_name' => '商品名称',
            'points' => '积分数',
            'create_at' => '创建时间',
        ];
    }
}
