<?php

namespace backend\modules\trust\models;

use Yii;

/**
 * This is the model class for table "{{%trust_social_2016}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $trust_month
 * @property string $total_point
 * @property integer $level_value
 * @property string $level_point
 * @property integer $created_at
 * @property integer $updated_at
 */
class VsoUserTrustSocial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%trust_social_2016}}';
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
            [['total_point', 'level_point'], 'number'],
            [['level_value', 'created_at', 'updated_at'], 'integer'],
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
            'total_point' => '社交关系总信用',
            'level_value' => '成长等级值',
            'level_point' => '成长等级信用得分',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取用户的社交关系信用总值
     * @param string $username 用户名
     * @return float 社交关系信用总值
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
     * 获取用户的社交关系信用分项值
     *
     * @param $username
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getUserSocials($username)
    {
        $socials = self::find()->select(
            [
                'level_value',
                'level_point'
            ]
        )
         ->where(['username' => $username, 'trust_month' => date("Ym")])
         ->asArray()
         ->one();

        return $socials;
    }

}
