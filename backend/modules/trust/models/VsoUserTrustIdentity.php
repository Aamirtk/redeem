<?php

namespace backend\modules\trust\models;

use Yii;

/**
 * This is the model class for table "{{%trust_identity_2016}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $trust_month
 * @property string $total_point
 * @property integer $realname_value
 * @property string $realname_point
 * @property integer $enterprise_value
 * @property string $enterprise_point
 * @property integer $baseinfo_key
 * @property integer $baseinfo_value
 * @property string $baseinfo_point
 * @property integer $stability_value
 * @property string $stability_point
 * @property integer $created_at
 * @property integer $updated_at
 */
class VsoUserTrustIdentity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%trust_identity_2016}}';
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
            [['total_point', 'realname_point', 'enterprise_point', 'baseinfo_point', 'stability_point'], 'number'],
            [['realname_value', 'enterprise_value', 'baseinfo_key', 'baseinfo_value', 'stability_value', 'created_at', 'updated_at'], 'integer'],
            [['username'], 'string', 'max' => 30],
            [['trust_month'], 'string', 'max' => 6],
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
            'total_point' => '身份特征总信用',
            'realname_value' => '是否实名认证0否1是',
            'realname_point' => '实名认证得分',
            'enterprise_value' => '是否企业认证0否1是',
            'enterprise_point' => '企业认证得分',
            'baseinfo_key' => '基本信息长度',
            'baseinfo_value' => '基本信息完成数量',
            'baseinfo_point' => '基本信息得分',
            'stability_value' => '信息修改次数',
            'stability_point' => '信息稳定性得分',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取用户的身份特征信用总值
     * @param $username 用户名
     * @return float 身份特征信用总值
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
     * 获取用户的身份特征分项值
     * @param $username
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getUserIdentity($username)
    {
        $identity = self::find()->select(
            [
                'realname_point',
                'enterprise_point',
                'baseinfo_point',
                'stability_point',
                'realname_value',
                'enterprise_value',
                'baseinfo_key',
                'baseinfo_value',
                'stability_value',
            ]
        )
        ->where(['username' => $username, 'trust_month' => date("Ym")])
        ->asArray()
        ->one();
        return $identity;
    }

}
