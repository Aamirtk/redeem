<?php

namespace backend\modules\trust\models;

use Yii;

/**
 * This is the model class for table "vso_trust_range_point_config".
 *
 * @property integer $id
 * @property integer $range_type
 * @property integer $min_val
 * @property integer $max_val
 * @property integer $point
 * @property integer $created_at
 * @property integer $updated_at
 */
class TrustRangePointConfig extends \yii\db\ActiveRecord
{
    /**
     * 数据范围类型
     * 1 => 近期完成任务累计金额范围
     * 2 => 近期完成任务累计次数范围
     * 3 => 历史完成任务累计金额范围
     * 4 => 历史完成任务累计次数范围
     * 5 => 保证金托管留存金额范围
     * 6 => 成长等级范围
     */
    const RANGE_TYPE_NEAR_CASH = 1;
    const RANGE_TYPE_NEAR_PUB = 2;
    const RANGE_TYPE_HISTORY_CASH = 3;
    const RANGE_TYPE_HISTORY_PUB = 4;
    const RANGE_TYPE_NET_TRUSTEESHIP = 5;
    const RANGE_TYPE_SOCIAL_LEVEL = 6;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_trust_range_point_config';
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
            [['range_type', 'min_val', 'max_val', 'point', 'created_at', 'updated_at'], 'integer'],
            [['created_at'], 'default', 'value' => time()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增ID',
            'range_type' => '1:近期完成任务累计金额范围 2:近期完成任务累计次数范围 3:历史完成任务累计金额范围 4:历史完成任务累计次数范围 5:保证金托管留存金额范围 6:成长等级范围',
            'min_val' => '范围最小值',
            'max_val' => '范围最大值',
            'point' => '范围对应分值',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取范围配置内，用户应该获得的信用分
     * @param float $value
     * @param int $range_type 数据范围类型
     * @return int 信用分
     */
    public static function getRangePointByValue($value, $range_type = self::RANGE_TYPE_NEAR_CASH)
    {
        $point = self::find()
            ->select("MAX(`point`)")
            ->where(['range_type' => $range_type])
            ->andWhere(['<=', 'min_val', $value])
            ->scalar();
        return intval($point);
    }
    /**
     * 获取范围数据配置
     * @param type $type
     * @return type
     */
    public static function getRangePointConfig($type)
    {
        return self::find()
                ->select('min_val,max_val,point')
                ->where('range_type='.$type)->orderBy(' min_val asc')->asArray()->all();
    }
}
