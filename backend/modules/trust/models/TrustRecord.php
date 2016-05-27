<?php

namespace backend\modules\trust\models;

use backend\modules\task\models\TaskMarkModel;
use Yii;

/**
 * This is the model class for table "vso_trust_record".
 *
 * @property integer $id
 * @property integer $record_type
 * @property integer $record_cycle
 * @property integer $record_amount
 * @property integer $record_count
 * @property integer $record_overall_merit
 * @property integer $pay_speed
 * @property integer $work_happy
 * @property integer $quality
 * @property integer $efficiency
 * @property integer $attitude
 * @property integer $created_at
 * @property integer $updated_at
 */
class TrustRecord extends \yii\db\ActiveRecord
{
    const RECORD_TYPE_NEAR = 1;     // 履约类型，近期
    const RECORD_TYPE_HISTORY = 2;  // 履约类型，历史

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_trust_record';
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
            [['record_type', 'record_cycle', 'record_amount', 'record_count', 'record_overall_merit', 'pay_speed', 'work_happy', 'quality', 'efficiency', 'attitude', 'created_at', 'updated_at'], 'integer'],
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
            'record_type' => '履约类型 1:近期 2:历史',
            'record_cycle' => '数据采集周期(3表示3个月)',
            'record_amount' => '完成任务累计金额权重',
            'record_count' => '完成任务累计次数权重',
            'record_overall_merit' => '完成任务综合评分权重',
            'pay_speed' => '甲方-付款速度占比',
            'work_happy' => '甲方-合作愉快占比',
            'quality' => '乙方-完成质量占比',
            'efficiency' => '乙方-工作时间占比',
            'attitude' => '乙方-服务态度占比',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 根据key获取权重百分比
     * 优先从redis缓存读取数据
     * @param string $key
     * @param int $record_type 履约类型（1=>近期，2=>历史）
     * @return int 百分比，0~100
     */
    public static function getConfigPctByKey($key, $record_type = self::RECORD_TYPE_NEAR)
    {
        if (empty($key))
        {
            return 0;
        }
        $redis_key = "record_type" . $record_type . ":" . $key;
        $pct = yii::$app->redis->GET($redis_key);
        if (!$pct)
        {
            $expire_time = yii::$app->params['trust_config_expire_time'];
            $pct = self::find()
                ->select($key)
                ->where(['record_type' => $record_type])
                ->scalar();
            yii::$app->redis->SETEX($redis_key, $expire_time, $pct);
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
     * @param string $key
     * @param int $record_type 履约类型（1=>近期，2=>历史）
     * @return float 信用分，保留小数点后两位
     */
    public static function getTrustPointByKey($key, $record_type = self::RECORD_TYPE_NEAR)
    {
        $pct = self::getConfigPctByKey($key, $record_type);
        return self::getTrustPointByPct($pct);
    }

    /**
     * 获取范围配置内，用户应该获得的信用分
     * @param float $value
     * @param int $range_type 数据范围类型
     * @return float 信用分
     */
    public static function getRangePointByValue($value, $range_type = TrustRangePointConfig::RANGE_TYPE_NEAR_CASH)
    {
        $range_point = TrustRangePointConfig::getRangePointByValue($value, $range_type);
        // 根据数据范围类型，获取对应的key名称与履约类型
        switch ($range_type)
        {
            case TrustRangePointConfig::RANGE_TYPE_NEAR_CASH:
                $key = 'record_amount';
                $record_type = self::RECORD_TYPE_NEAR;
                break;
            case TrustRangePointConfig::RANGE_TYPE_NEAR_PUB:
                $key = 'record_count';
                $record_type = self::RECORD_TYPE_NEAR;
                break;
            case TrustRangePointConfig::RANGE_TYPE_HISTORY_CASH:
                $key = 'record_amount';
                $record_type = self::RECORD_TYPE_HISTORY;
                break;
            case TrustRangePointConfig::RANGE_TYPE_HISTORY_PUB:
                $key = 'record_count';
                $record_type = self::RECORD_TYPE_HISTORY;
                break;
        }
        $max_point = self::getTrustPointByKey($key, $record_type);
        return $range_point > $max_point ? $max_point : $range_point;
    }

    /**
     * 用户完成任务的综合评分应该获得的信用值
     * @param string $username 用户名
     * @param integer $start_time 起始时间，时间戳
     * @param integer $end_time 结束时间，时间戳
     * @param integer $record_type 履约类型
     * @return float 信用分
     */
    public static function getUserMarkPoint($username, $start_time, $end_time, $record_type)
    {
        if (empty($username))
        {
            return 0;
        }
        // 用户完成任务综合评价总信用分
        $total_point = 0;
        // 用户作为甲方收到的评论
        $taskMarkA = TaskMarkModel::getUserTaskMarkA($username, $start_time, $end_time);
        // 付款速度占比
        $pay_speed = self::getConfigPctByKey('pay_speed', $record_type) / 100;
        // 合作愉快占比
        $work_happy = self::getConfigPctByKey('work_happy', $record_type) / 100;
        foreach ($taskMarkA as $k => $v)
        {
            $aidArr = explode(",", $v['aid_star']);
            // 付款速度信用
            $total_point += isset($aidArr[0]) ? intval($aidArr[0]) * $pay_speed : 0;
            // 合作愉快信用
            $total_point += isset($aidArr[1]) ? intval($aidArr[1]) * $work_happy : 0;
        }
        // 用户作为乙方收到的评论
        $taskMarkB = TaskMarkModel::getUserTaskMarkB($username, $start_time, $end_time);
        // 工作时间占比
        $efficiency = self::getConfigPctByKey('efficiency', $record_type) / 100;
        // 完成质量占比
        $quality = self::getConfigPctByKey('quality', $record_type) / 100;
        // 服务态度占比
        $attitude = self::getConfigPctByKey('attitude', $record_type) / 100;
        foreach ($taskMarkB as $k => $v)
        {
            $aidArr = explode(",", $v['aid_star']);
            // 工作时间信用
            $total_point += isset($aidArr[0]) ? intval($aidArr[0]) * $efficiency : 0;
            // 完成质量信用
            $total_point += isset($aidArr[1]) ? intval($aidArr[1]) * $quality : 0;
            // 服务态度信用
            $total_point += isset($aidArr[2]) ? intval($aidArr[2]) * $attitude : 0;
        }
        // 用户完成任务综合能获得的最大信用分
        $record_overall_merit_point = self::getTrustPointByKey('record_overall_merit', $record_type);
        // 取用户可以获得的信用分
        $result = $total_point > $record_overall_merit_point ? $record_overall_merit_point : $total_point;
        return round($result, 2);
    }

    /**
     * 获取履约配置
     * @param type $type
     * @return type
     */
    public static function getRecordConfig($type)
    {
        return self::find()->select('record_cycle,record_amount,record_count,'
                . 'record_overall_merit,pay_speed,work_happy,quality,efficiency,attitude')
                ->where('record_type='.$type)->orderBy(' id desc')->asArray()->one();
    }
}
