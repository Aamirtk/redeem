<?php

namespace backend\modules\auth\models;

use Yii;

/**
 * This is the model class for table "{{%auth_mobile}}".
 *
 * @property integer $mobile_id
 * @property integer $uid
 * @property string $username
 * @property string $mobile
 * @property string $valid_code
 * @property double $cash
 * @property integer $auth_status
 * @property integer $auth_time
 * @property integer $end_time
 */
class AuthMobile extends AuthItem
{
    const AUTH_CODE = "mobile";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_mobile}}';
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
            [['uid', 'auth_status', 'auth_time', 'end_time'], 'integer'],
            [['cash'], 'number'],
            [['username'], 'string', 'max' => 20],
            [['mobile'], 'string', 'max' => 11],
            [['valid_code'], 'string', 'max' => 6]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mobile_id' => 'Mobile ID',
            'uid' => 'Uid',
            'username' => 'Username',
            'mobile' => 'Mobile',
            'valid_code' => 'Valid Code',
            'cash' => 'Cash',
            'auth_status' => 'auth_status: 1：已审核通过 2：未审核',
            'auth_time' => 'Auth Time',
            'end_time' => 'End Time',
        ];
    }

    /**
     * 获取用户的手机认证状态
     * @param $username 用户名
     * @return int 认证状态
     */
    public static function getUserAuthStatus($username)
    {
        if (empty($username))
        {
            return self::STATUS_WAIT;
        }
        $record = self::findOne(['username' => $username, 'auth_code' => self::AUTH_CODE]);
        if (!empty($record))
        {
            return $record->getAttribute('auth_status');
        }
        return self::STATUS_WAIT;
    }

    /**
     * 用户是否通过手机认证
     * @param $username 用户名
     * @return bool（true=>通过，false=>未通过）
     */
    public static function isUserAuthMobile($username)
    {
        if (empty($username))
        {
            return false;
        }
        $count = self::find()
            ->where(['username' => $username, 'auth_status' => self::STATUS_PASS])
            ->count('username');
        return $count ? true : false;
    }

    /**
     * 手机号是否通过认证
     * @param $mobile
     * @param string $username
     * @return bool（true=>通过，false=>未通过）
     */
    public static function isMobileAuthed($mobile, $username = '')
    {
        if (empty($mobile))
        {
            return false;
        }
        $query = self::find()
            ->where(['mobile' => $mobile, 'auth_status' => self::STATUS_PASS]);
        if (!empty($username))
        {
            $query->andWhere(['<>', 'username', $username]);
        }
        $count = $query->count();
        return $count ? false : true;
    }
}
