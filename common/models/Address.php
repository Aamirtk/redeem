<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%address}}".
 *
 * @property integer $mid
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
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%address}}';
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
            'mid' => '地址ID',
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
}
