<?php

namespace backend\modules\trust\models;

use Yii;

/**
 * This is the model class for table "{{%trust_2016}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $trust_month
 * @property integer $trust
 * @property integer $identity_type
 * @property integer $negative_count
 * @property integer $negative_point
 * @property integer $created_at
 * @property integer $updated_at
 */
class VsoUserTrust extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%trust_2016}}';
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
            [['trust', 'identity_type', 'negative_count', 'negative_point', 'created_at', 'updated_at'], 'integer'],
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
            'trust' => '信用分',
            'identity_type' => '身份偏向 0：乙方 1：甲方  默认值为0',
            'negative_count' => '负面扣分次数',
            'negative_point' => '负面扣分合计',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 计算用户的总信用分
     * 总信用分 = 分值范围最小值 + 近期履约 + 历史信用 + 身份特征 + 社交关系 + 行为偏好
     * 各子项的信用分为float型，用户最终信用分为int型
     * @param $username 用户名
     * @return int 总信用分
     */
    public static function calcUserTotalTrustPoint($username)
    {
        if (empty($username))
        {
            return 0;
        }
        $total_point = TrustBase::getConfigPctByKey('base_point_min')
            + VsoUserTrustRecord::getUserTotalTrustPoint($username)
            + VsoUserTrustRecord::getUserTotalTrustPoint($username, 2)
            + VsoUserTrustIdentity::getUserTotalTrustPoint($username)
            + VsoUserTrustSocial::getUserTotalTrustPoint($username)
            + VsoUserTrustBehavior::getUserTotalTrustPoint($username);
        return $total_point > 0 ? intval($total_point) : 0;
    }


    /**
     * 获得用户历史记录分值
     *
     * @param $username
     * @return array
     */
    public static function  getUserHisTrustData($username)
    {
        $result = [];
        $query = self::find()->where(['username' => $username]);
        $result['count'] = $query->count();
        $result['historys'] = $query->select(
            [
                'trust',
                'negative_point',
                'created_at'
            ]
        )
        ->orderBy(['created_at' => SORT_DESC])
        ->all();

        return $result;
    }

}
