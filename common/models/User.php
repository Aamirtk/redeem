<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $uid
 * @property string $nick
 * @property string $name
 * @property string $avatar
 * @property integer $mobile
 * @property string $email
 * @property integer $points
 * @property integer $user_type
 * @property string $wechat_openid
 * @property integer $user_status
 * @property integer $create_at
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile', 'points', 'user_type', 'user_status', 'create_at'], 'integer'],
            [['nick', 'name'], 'string', 'max' => 30],
            [['avatar'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 40],
            [['wechat_openid'], 'string', 'max' => 50]
        ];
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
    public function attributeLabels()
    {
        return [
            'uid' => '用户ID',
            'nick' => '用户微信昵称',
            'name' => '用户真实姓名',
            'avatar' => '用户微信头像',
            'mobile' => '用户手机号码',
            'email' => '用户邮箱',
            'points' => '积分',
            'user_type' => '用户类型（1-普通用户；2-销售；3-家装设计师）',
            'wechat_openid' => '微信Open Id',
            'user_status' => '状态（1-启用；2-禁用）',
            'create_at' => '创建时间',
        ];
    }
}
