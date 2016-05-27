<?php

namespace backend\modules\trust\models;

use Yii;

/**
 * This is the model class for table "vso_trust_social_growth".
 *
 * @property integer $id
 * @property integer $social_growth_level
 * @property integer $created_at
 * @property integer $updated_at
 */
class TrustSocialGrowth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_trust_social_growth';
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
            [['social_growth_level', 'created_at', 'updated_at'], 'integer'],
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
            'social_growth_level' => '成长等级权重',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 根据key获取权重百分比
     * 优先从redis缓存读取数据
     * @param $key
     * @return int 百分比，0~100
     */
    public static function getConfigPctByKey($key)
    {
        if (empty($key))
        {
            return 0;
        }
        $pct = yii::$app->redis->GET($key);
        if (!$pct)
        {
            $expire_time = yii::$app->params['trust_config_expire_time'];
            $pct = self::find()
                ->select($key)
                ->scalar();
            yii::$app->redis->SETEX($key, $expire_time, $pct);
        }
        return intval($pct);
    }

    /**
     * 根据权重百分比获取应该获得的信用分
     * 优先从redis缓存读取数据
     * @param integer $percent 权重百分比，范围0~100
     * @return float 信用分，保留小数点后两位
     */
    public static function getTrustPointByPct($percent)
    {
        // 分值浮动范围
        $key = 'base_point_interval';
        $base_point_interval = yii::$app->redis->GET($key);
        if (!$base_point_interval)
        {
            $expire_time = yii::$app->params['trust_config_expire_time'];
            $base_point_interval = TrustBase::find()
                ->select($key)
                ->scalar();
            yii::$app->redis->SETEX($key, $expire_time, $base_point_interval);
        }
        return round($base_point_interval * $percent / 100, 2);
    }

    /**
     * 根据key获取应该分配给用户的信用分
     * @param $key
     * @return float 信用分，保留小数点后两位
     */
    public static function getTrustPointByKey($key)
    {
        $pct = self::getConfigPctByKey($key);
        return self::getTrustPointByPct($pct);
    }

    /**
     * 获取范围配置内，用户等级应该获得的信用分
     * @param integer $value 用户等级
     * @return float 信用分
     */
    public static function getRangePointByValue($value)
    {
        $range_type = TrustRangePointConfig::RANGE_TYPE_SOCIAL_LEVEL;
        $range_point = TrustRangePointConfig::getRangePointByValue($value, $range_type);
        // 最多能够获得的信用分
        $max_point = self::getTrustPointByKey('social_growth_level');
        return $range_point > $max_point ? $max_point : $range_point;
    }
    /**
     * 获取社会关系配置
     * @return type
     */
    public static function getSocialConfig()
    {
        return self::find()->select('social_growth_level')
                ->orderBy(' id desc')->asArray()->one();
    }
}
