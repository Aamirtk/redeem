<?php

namespace backend\modules\trust\models;

use Yii;

/**
 * This is the model class for table "{{%trust_behavior_2016}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $trust_month
 * @property string $total_point
 * @property integer $activity_value
 * @property string $activity_point
 * @property integer $tender_value
 * @property string $tender_point
 * @property integer $bid_value
 * @property string $bid_point
 * @property string $deposit_value
 * @property string $deposit_point
 * @property integer $created_at
 * @property integer $updated_at
 */
class VsoUserTrustBehavior extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%trust_behavior_2016}}';
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
            [['total_point', 'activity_point', 'tender_point', 'bid_point', 'deposit_value', 'deposit_point'], 'number'],
            [['activity_value', 'tender_value', 'bid_value', 'created_at', 'updated_at'], 'integer'],
            [['username'], 'string', 'max' => 30],
            [['trust_month'], 'string', 'max' => 6],
            [['username', 'trust_month'], 'unique', 'targetAttribute' => ['username', 'trust_month'], 'message' => 'The combination of 用户名 and 信用年月(201601) has already been taken.'],
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
            'total_point' => '行为偏好总信用',
            'activity_value' => '周期内在线次数',
            'activity_point' => '活跃得分',
            'tender_value' => '周期内发标次数',
            'tender_point' => '发标得分',
            'bid_value' => '周期内投标次数',
            'bid_point' => '投标得分',
            'deposit_value' => '周期内保证金托管留存',
            'deposit_point' => '保证金托管留存得分',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取用户的行为偏好信用总值
     * @param $username 用户名
     * @return float 行为偏好信用总值
     */
    public static function getUserTotalTrustPoint($username)
    {
        if (empty($username))
        {
            return 0;
        }
        $point = self::find()
            ->select("total_point")
            ->where(['username' => $username, 'trust_month' => date("Ym")])
            ->scalar();
        return $point > 0 ? $point : 0;
    }

    /**
     * 获取用户的行为偏好信用分项值
     *
     * @param $username
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getUserBehaviors($username)
    {
        $behaviors = self::find()->select(
            [
                'activity_point',
                'tender_point',
                'bid_point',
                'deposit_point',
                'activity_value',
                'tender_value',
                'bid_value',
                'deposit_value',            ]
        )
         ->where(['username' => $username, 'trust_month' => date("Ym")])
         ->asArray()
         ->one();

        return $behaviors;
    }

}
