<?php

namespace backend\modules\trust\models;

use Yii;

/**
 * This is the model class for table "vso_trust_identity".
 *
 * @property integer $id
 * @property integer $identity_realname
 * @property integer $identity_enterprise
 * @property integer $identity_baseinfo
 * @property integer $identity_stability
 * @property integer $identity_cycle
 * @property integer $identity__max_modifications
 * @property integer $created_at
 * @property integer $updated_at
 */
class TrustIdentity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_trust_identity';
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
            [['identity_realname', 'identity_enterprise', 'identity_baseinfo', 'identity_stability', 'identity_cycle', 'identity_max_modifications', 'created_at', 'updated_at'], 'integer'],
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
            'identity_realname' => '公安实名认证权重',
            'identity_enterprise' => '工商企业认证权重',
            'identity_baseinfo' => '身份基本信息权重',
            'identity_stability' => '信息稳定性权重',
            'identity_cycle' => '身份信息稳定性周期(1表示1个月)',
            'identity__max_modifications' => '身份信息最多允许修改次数',
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
     * 获取用户对基本信息的修改频次
     * @todo，目前缺乏历史数据支持，待完善
     * @param string $username 用户名
     * @return int
     */
    public static function getUserInfoModifications($username)
    {
        return 0;
    }

    /**
     * 获取用户信息稳定性的信用分
     * @todo，目前缺乏历史数据支持，待完善
     * @param $username 用户名
     * @param integer $value 用户对基本信息的修改频次
     * @return int 信用分
     */
    public static function getUserStabilityPoint($username, $value)
    {
        return 0;
        if (empty($username))
        {
            return 0;
        }
        // 配置中允许的最大修改次数
        $identity_max_modifications = self::getConfigPctByKey('identity_max_modifications');
        if ($value > $identity_max_modifications)
        {
            return 0;
        }
        // 信息稳定性信用分，根据信息稳定性权重计算
        return self::getTrustPointByKey('identity_stability');
    }
    /**
     * 身份特征配置
     * @return type
     */
    public static function getIdentityConfig()
    {
        return self::find()->select('identity_realname,identity_enterprise,identity_baseinfo,'
                . 'identity_stability,identity_cycle,identity_max_modifications')
                ->orderBy(' id desc')->asArray()->one();
    }
}
