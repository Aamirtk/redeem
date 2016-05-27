<?php

namespace backend\modules\trust\models;

use Yii;

/**
 * This is the model class for table "vso_trust_base".
 *
 * @property integer $id
 * @property integer $base_point_min
 * @property integer $base_point_max
 * @property integer $base_point_interval
 * @property integer $base_identity
 * @property integer $base_recent_record
 * @property integer $base_history_record
 * @property integer $base_behavior
 * @property integer $base_social
 * @property integer $created_at
 * @property integer $updated_at
 */
class TrustBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_trust_base';
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
            [['base_point_min', 'base_point_max', 'base_point_interval', 'base_identity', 'base_recent_record', 'base_history_record', 'base_behavior', 'base_social', 'created_at', 'updated_at'], 'integer'],
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
            'base_point_min' => '分值范围最小值',
            'base_point_max' => '分值范围最大值',
            'base_point_interval' => '分值浮动范围',
            'base_identity' => '身份特征权重',
            'base_recent_record' => '近期履约权重',
            'base_history_record' => '历史履约权重',
            'base_behavior' => '行为偏好权重',
            'base_social' => '社交关系权重',
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
     * 获取基础配置数据
     * @return type
     */
    public static function getBaseConfig()
    {
        $baseConfig=  self::find()->select('base_point_min,base_point_max,base_point_interval,'
                . 'base_identity,base_recent_record,base_history_record,base_behavior,base_social')
                ->orderBy(' id desc')->asArray()->one();
        return $baseConfig;
    }
    /**
     * 后台全局规则配置
     * @return type
     */
    public static function getTrustConfig()
    {
        //基础配置
        $trustConfig['baseConfig']=  self::getBaseConfig();
        //身份特征设置
        $trustConfig['identityConfig']=  TrustIdentity::getIdentityConfig();
        //近期履约设置
        $trustConfig['recentRecordConfig']= TrustRecord::getRecordConfig(1);
        $trustConfig['recentRecordConfig']['record_amount_config']=  TrustRangePointConfig::getRangePointConfig(1);
        $trustConfig['recentRecordConfig']['record_count_config']=  TrustRangePointConfig::getRangePointConfig(2);
        //历史履约设置
        $trustConfig['historyRecordConfig']= TrustRecord::getRecordConfig(2);
        $trustConfig['historyRecordConfig']['record_amount_config']=  TrustRangePointConfig::getRangePointConfig(3);
        $trustConfig['historyRecordConfig']['record_count_config']=  TrustRangePointConfig::getRangePointConfig(4);
        //行为偏好设置
        $trustConfig['behaviorConfig']= TrustBehavior::getBehaviorConfig();
        $trustConfig['behaviorConfig']['behavior_deposit_config']=  TrustRangePointConfig::getRangePointConfig(5);
        //行为偏好设置
        $trustConfig['socialConfig']= TrustSocialGrowth::getSocialConfig();
        $trustConfig['socialConfig']['social_growth_level_config']=  TrustRangePointConfig::getRangePointConfig(6);
        $trustConfig=  self::setTrustConfigKey($trustConfig);
        return $trustConfig;
    }
    /**
     * 设置规则子配置到总配置
     * @param type $tconfig
     * @param type $children
     * @return type
     */
    public static function setTrustConfigKey($tconfig)
    {
        foreach ($tconfig as $ck=>$children)
        {
            $pre='';
            if($ck=='recentRecordConfig')
            {
                $pre='recent_';
            }
            if($ck=='historyRecordConfig')
            {
                $pre='history_';
            }
            foreach ($children as $key => $value)
            {
                $trustConfig[$pre.$key]=$value;
            }

        }
        return $trustConfig;
    }
}
