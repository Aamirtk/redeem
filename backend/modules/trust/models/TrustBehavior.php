<?php

namespace backend\modules\trust\models;

use backend\modules\user\models\VsoUserOnlinetime;
use Yii;

/**
 * This is the model class for table "vso_trust_behavior".
 *
 * @property integer $id
 * @property integer $behavior_cycle
 * @property integer $behavior_activity
 * @property integer $behavior_pub_task
 * @property integer $behavior_bid
 * @property integer $behavior_deposit
 * @property integer $behavior_min_online
 * @property integer $behavior_activity_percent
 * @property integer $behavior_min_tender
 * @property integer $behavior_tender_percent
 * @property integer $behavior_min_bid
 * @property integer $behavior_bid_percent
 * @property integer $created_at
 * @property integer $updated_at
 */
class TrustBehavior extends \yii\db\ActiveRecord
{
    const ONLINE_SECOND_MIN = 1800;     // 行为偏好，每次在线最低时长，秒
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_trust_behavior';
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
            [['behavior_cycle', 'behavior_activity', 'behavior_pub_task', 'behavior_bid', 'behavior_deposit', 'behavior_min_online', 'behavior_activity_percent', 'behavior_min_tender', 'behavior_tender_percent', 'behavior_min_bid', 'behavior_bid_percent', 'created_at', 'updated_at'], 'integer'],
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
            'behavior_cycle' => '行为偏好采集周期(24表示24个月)',
            'behavior_activity' => '用户活跃度权重',
            'behavior_pub_task' => '发标权重',
            'behavior_bid' => '投标权重',
            'behavior_deposit' => '保证金托管权重',
            'behavior_min_online' => '行为偏好最低在线次数',
            'behavior_activity_percent' => '行为偏好得分比例',
            'behavior_min_tender' => '最低发标次数',
            'behavior_tender_percent' => '发标得分比例',
            'behavior_min_bid' => '最低投标次数',
            'behavior_bid_percent' => '投标得分比例',
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
     * 获取用户在采集周期内的在线次数
     * @param string $username 用户名
     * @param $start_time 起始时间，时间戳
     * @param $end_time 结束时间，时间戳
     * @return int 在线次数
     */
    public static function getUserOnlineNumber($username, $start_time, $end_time)
    {
        if (empty($username))
        {
            return 0;
        }
        $count = VsoUserOnlinetime::find()
            ->where(['username' => $username])
            ->andWhere(['>=', 'online_time', self::ONLINE_SECOND_MIN])
            ->andWhere(['between', 'last_login_time', $start_time, $end_time])
            ->count();
        return $count;

    }

    /**
     * 获取用户在线次数获得的信用分
     * 分数 = （3个月内实际符合条件次数 - 平台规定最低符合条件次数） * 得分比例
     * 分数不能大于最大值
     * @param integer $count 在线次数
     * @return float 信用分
     */
    public static function getUserOnlinePoint($count)
    {
        // 最低在线次数
        $min_count = self::getConfigPctByKey('behavior_min_online');
        // 小于最低在线次数，0分
        if ($count < $min_count)
        {
            return 0;
        }
        // 最多可以拿到的信用分，最大值
        $max = self::getTrustPointByKey('behavior_activity');
        // 实际可以拿到的信用分，不能大于最大值
        $actual = ($count - $min_count) * self::getConfigPctByKey('behavior_activity_percent')/100 * $max;
        $actual = round($actual, 2);
        return $actual > $max ? $max : $actual;
    }

    /**
     * 用户发布任务可以获得的信用分
     * 分数 = （3个月内实际发布任务次数 - 平台规定最低发布任务次数）* 得分比例
     * 分数不能大于最大值
     * @param int $count 发布任务次数
     * @return float 信用分
     */
    public static function getUserPubTaskPoint($count = 0)
    {
        // 最低发布次数
        $min_count = self::getConfigPctByKey('behavior_min_tender');
        // 小于最低发布次数，分数为0
        if ($count < $min_count)
        {
            return 0;
        }
        // 最多可以拿到的信用分，最大值
        $max = self::getTrustPointByKey('behavior_pub_task');
        // 实际可以拿到的信用分，不能大于最大值
        $actual = ($count - $min_count) * self::getConfigPctByKey('behavior_tender_percent')/100 * $max;
        $actual = round($actual, 2);
        return $actual > $max ? $max : $actual;
    }

    /**
     * 用户投稿可以获得的信用分
     * 分数 = （3个月内实际投稿次数 - 平台规定最低投稿次数）* 得分比例
     * 分数不能大于最大值
     * @param int $count 投稿次数
     * @return float 信用分
     */
    public static function getUserDeliveryPoint($count = 0)
    {
        // 最低发布次数
        $min_count = self::getConfigPctByKey('behavior_min_bid');
        // 小于最低发布次数，分数为0
        if ($count < $min_count)
        {
            return 0;
        }
        // 最多可以拿到的信用分，最大值
        $max = self::getTrustPointByKey('behavior_bid');
        // 实际可以拿到的信用分，不能大于最大值
        $actual = ($count - $min_count) * self::getConfigPctByKey('behavior_bid_percent')/100 * $max;
        $actual = round($actual, 2);
        return $actual > $max ? $max : $actual;
    }

    /**
     * 获取范围配置内，用户应该获得的信用分
     * @param float $value
     * @param int $range_type 数据范围类型
     * @return float 信用分
     */
    public static function getRangePointByValue($value, $range_type = TrustRangePointConfig::RANGE_TYPE_NET_TRUSTEESHIP)
    {
        $range_point = TrustRangePointConfig::getRangePointByValue($value, $range_type);
        $max_point = self::getTrustPointByKey('behavior_deposit');
        return $range_point > $max_point ? $max_point : $range_point;
    }
    /**
     * 获取行为偏好配置
     * @return type
     */
    public static function getBehaviorConfig()
    {
        return self::find()->select('behavior_cycle,behavior_activity,behavior_pub_task,'
                . 'behavior_bid,behavior_deposit,behavior_min_online,behavior_activity_percent,'
                . 'behavior_min_tender,behavior_tender_percent,behavior_min_bid,behavior_bid_percent')
                ->orderBy(' id desc')->asArray()->one();
    }
}
