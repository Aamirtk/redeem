<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%auth}}".
 *
 * @property integer $auth_id
 * @property integer $uid
 * @property string $nick
 * @property string $name
 * @property string $avatar
 * @property integer $mobile
 * @property string $email
 * @property integer $user_type
 * @property integer $auth_status
 * @property string $reason
 * @property integer $create_at
 */
class Auth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'mobile', 'user_type', 'auth_status', 'create_at'], 'integer'],
            [['auth_status'], 'required'],
            [['nick', 'name'], 'string', 'max' => 30],
            [['avatar'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 40],
            [['reason'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auth_id' => '认证ID',
            'uid' => '用户ID',
            'nick' => '微信昵称',
            'name' => '真实姓名',
            'avatar' => '微信头像',
            'mobile' => '手机号码',
            'email' => '邮箱',
            'user_type' => '用户类型（1-普通用户；2-销售；3-家装设计师）',
            'auth_status' => '认证状态（1-待审核；2-审核通过；3-审核不通过）',
            'reason' => '审核不通过的原因',
            'create_at' => '创建时间',
        ];
    }
}
