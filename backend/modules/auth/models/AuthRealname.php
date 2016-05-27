<?php

namespace backend\modules\auth\models;

use Yii;

/**
 * This is the model class for table "{{%auth_realname}}".
 *
 * @property integer $auth_realname_id
 * @property integer $uid
 * @property string $username
 * @property string $realname
 * @property string $id_card
 * @property string $id_pic
 * @property string $id_pic_2
 * @property double $cash
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $auth_status
 */
class AuthRealname extends AuthItem
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_realname}}';
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
            [['uid', 'start_time', 'end_time', 'auth_status'], 'integer'],
            [['cash'], 'number'],
            [['username', 'realname', 'id_card'], 'string', 'max' => 50],
            [['id_pic', 'id_pic_2'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auth_realname_id' => '实名认证编号',
            'uid' => '用户编号',
            'username' => '用户名',
            'realname' => '真实姓名',
            'id_card' => '身份证',
            'id_pic' => '身份证复印件',
            'id_pic_2' => '身份证复印件',
            'cash' => '认证金额',
            'start_time' => '认证开始时间',
            'end_time' => '认证结束时间',
            'auth_status' => '认证状态（0=>待审核，1=>已通过，2=>未通过）',
        ];
    }

    /**
     * 获取用户的实名认证状态
     * @param $username 用户名
     * @return int 认证状态
     */
    public static function getUserAuthStatus($username)
    {
        if (empty($username))
        {
            return self::STATUS_WAIT;
        }
        $record = self::findOne(['username' => $username]);
        if (!empty($record))
        {
            return $record->auth_status;
        }
        return self::STATUS_WAIT;
    }

    /**
     * 用户是否通过实名认证
     * @param $username 用户名
     * @return bool（true=>通过，false=>未通过）
     */
    public static function isUserAuthRealname($username)
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
}
