<?php

namespace backend\modules\point\models;

use Yii;

/**
 * This is the model class for table "vso_point_channel".
 *
 * @property integer $chid
 * @property string $channelkey
 * @property string $channelname
 * @property integer $available
 * @property double $distribute
 * @property integer $created_at
 * @property integer $updated_at
 */
class PointChannel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_point_channel';
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
            [['available', 'created_at', 'updated_at'], 'integer'],
            [['distribute'], 'number'],
            [['channelkey', 'channelname'], 'string', 'max' => 20],
            [['channelkey'], 'unique'],
            [['channelkey'], 'match', 'pattern' => '/^[a-z]\w*$/i'],
            [['created_at'], 'default', 'value' => time()],
            [['distribute'], 'default', 'value' => 0]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'chid' => '频道ID',
            'channelkey' => '频道标识 唯一KEY',
            'channelname' => '频道名称名称',
            'available' => '是否启用 0：不启用 1：启用',
            'distribute' => 'Distribute',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
}
