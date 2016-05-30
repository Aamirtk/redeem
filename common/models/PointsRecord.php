<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%points_record}}".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $point_id
 * @property integer $points
 * @property string $pionts_name
 * @property integer $create_at
 */
class PointsRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%points_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'uid', 'point_id', 'points', 'create_at'], 'integer'],
            [['pionts_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '积分赠送记录ID',
            'uid' => '用户ID',
            'point_id' => '赠送积分ID',
            'points' => '赠送积分数',
            'pionts_name' => '积分赠送名称',
            'create_at' => '创建时间',
        ];
    }
}
