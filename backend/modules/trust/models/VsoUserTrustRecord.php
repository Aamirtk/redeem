<?php

namespace backend\modules\trust\models;

use Yii;

/**
 * This is the model class for table "{{%trust_record_2016}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $trust_month
 * @property string $total_point
 * @property integer $record_type
 * @property string $amount_value
 * @property string $amount_point
 * @property integer $count_value
 * @property string $count_point
 * @property string $pay_speed_value
 * @property string $work_happy_value
 * @property string $quality_value
 * @property string $efficiency_value
 * @property string $attitude_value
 * @property string $merit_point
 * @property string $negative_point
 * @property integer $created_at
 * @property integer $updated_at
 */
class VsoUserTrustRecord extends \yii\db\ActiveRecord
{
    const RECORD_TYPE_NEAR = 1;     // 履约类型，近期
    const RECORD_TYPE_HISTORY = 2;  // 履约类型，历史
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%trust_record_2016}}';
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
            [['total_point', 'amount_value', 'amount_point', 'count_point', 'pay_speed_value', 'work_happy_value', 'quality_value', 'efficiency_value', 'attitude_value', 'merit_point', 'negative_point'], 'number'],
            [['record_type', 'count_value', 'created_at', 'updated_at'], 'integer'],
            [['username'], 'string', 'max' => 30],
            [['trust_month'], 'string', 'max' => 6],
            [['username', 'trust_month', 'record_type'], 'unique', 'targetAttribute' => ['username', 'trust_month', 'record_type'], 'message' => 'The combination of 用户名, 信用年月(201601) and 履约类型 1:近期 2:历史 has already been taken.'],
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
            'username' => '用户名',
            'trust_month' => '信用年月(201601)',
            'total_point' => '总信用，根据record_type区分',
            'record_type' => '履约类型 1:近期 2:历史',
            'amount_value' => '累计交易金额',
            'amount_point' => '累计交易金额得分',
            'count_value' => '累计交易次数',
            'count_point' => '累计交易次数得分',
            'pay_speed_value' => '甲方-付款速度值',
            'work_happy_value' => '甲方-合作愉快值',
            'quality_value' => '乙方-完成质量值',
            'efficiency_value' => '乙方-工作时间值',
            'attitude_value' => '乙方-服务态度值',
            'merit_point' => '综合评价得分',
            'negative_point' => '负面影响扣分',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取用户的信用总值：近期履约，历史信用，根据履约类型区分
     * @param string $username 用户名
     * @param integer $record_type 履约类型（1=>近期，2=>历史）
     * @return float 用户信用总值
     */
    public static function getUserTotalTrustPoint($username, $record_type = 1)
    {
        if (empty($username))
        {
            return 0;
        }
        $point = self::find()
            ->select("total_point")
            ->where(['username' => $username, 'record_type' => $record_type, 'trust_month' => date("Ym")])
            ->scalar();
        return $point > 0 ? $point : 0;
    }

    /**
     * 获得用户分项值：近期履约，历史信用，根据履约类型区分
     *
     * @param $username
     * @param int $record_type 履约类型（1=>近期，2=>历史）
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getUserRecents($username, $record_type = 1)
    {
        $recents = self::find()->select(
            [
                'amount_point',
                'count_point',
                'merit_point',
                'negative_point',
                'amount_value',
                'count_value',
            ]
        )
       ->where(['record_type' => $record_type, 'username' => $username, 'trust_month' => date("Ym")])
       ->asArray()
       ->one();

        return $recents;
    }
}
