<?php

namespace backend\modules\trust\models;

use Yii;

/**
 * This is the model class for table "vso_trust_negative_recode_2016".
 *
 * @property integer $id
 * @property string $trust_month
 * @property string $username
 * @property integer $negative_id
 * @property string $negative_content
 * @property integer $negative_point
 * @property string $operator
 * @property integer $created_at
 * @property integer $updated_at
 */
class VsoTrustNegativeRecode extends \yii\db\ActiveRecord
{
    const NEGATIVE_RECORD_PCT = 0.1;    // 负面影响历史数据递减比例
    const MONTH_SECOND = 2592000;       // 一个月的时间，秒

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_trust_negative_recode_2016';
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
            [['negative_id', 'negative_point', 'created_at', 'updated_at'], 'integer'],
            [['trust_month'], 'string', 'max' => 6],
            [['username'], 'string', 'max' => 30],
            [['negative_content'], 'string', 'max' => 255],
            [['operator'], 'string', 'max' => 50],
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
            'trust_month' => '信用年月(201601)',
            'username' => '被扣分用户',
            'negative_id' => '扣分规则关联ID',
            'negative_content' => '负面信息内容,注明：必须填写扣分内容，用于展示。',
            'negative_point' => '扣除分值',
            'operator' => '操作人',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取用户的负面影响信用总值
     * @param string $username 用户名
     * @param integer $start_time 起始时间，时间戳
     * @param integer $end_time 结束时间，时间戳
     * @param integer $record_type 履约类型
     * @return float 负面影响信用分
     */
    public static function getUserNegativeTrustPoint($username, $start_time, $end_time, $record_type)
    {
        if (empty($username))
        {
            return 0;
        }
        $point = 0;
        // 近期负面影响，分值直接计入分数计算，不设权重比例
        if ($record_type == TrustRecord::RECORD_TYPE_NEAR)
        {
            $point = self::find()
                ->select("SUM(`negative_point`)")
                ->where(['username' => $username])
                ->andWhere(['between', 'created_at', $start_time, $end_time])
                ->scalar();
        }
        /**
         * 历史负面影响，每月扣分以10%的幅度递减
         * 如历史数据的取值范围是4-24个月，则负面扣分发生后的第4个月，扣分*90%；扣分第5个月，扣分*80%，....，第13个月，递减至0
         */
        else
        {
            $month_second = self::MONTH_SECOND;
            // 近期数据的时间范围
            $month = TrustRecord::getConfigPctByKey('record_cycle');
            $start_time = strtotime(date("Y-m-01", strtotime("-13 Month")));
            // 历史负面影响的百分比，按月递减
            $pct = "(100 - CEIL( (UNIX_TIMESTAMP() - created_at - {$month_second} * $month) / {$month_second} ) * 10)";
            $point = self::find()
                ->select("SUM(negative_point * {$pct} / 100)")
                ->where(['username' => $username])
                ->andWhere(['between', 'created_at', $start_time, $end_time])
                ->scalar();
        }
        return $point > 0 ? round($point, 2) : 0;
    }


    /**
     * 获得用户所有负面信息
     *
     * @param $username
     * @return array
     */
    public static function getUserNegativeTrust($username,$trust_month=null)
    {
        $result = [];
        $query = self::find()->where(['username' => $username]);
        if($trust_month)
        {
            $query->andWhere(['trust_month'=>$trust_month]);
        }
        $result['count'] = $query->count();
        $result['negatives'] = $query->select(
            [
                'id',
                'username',
                'negative_content',
                'negative_point',
                'created_at',
                'operator'
            ]
        )
         ->orderBy(['created_at' => SORT_DESC])
         ->all();

        return $result;
    }
}