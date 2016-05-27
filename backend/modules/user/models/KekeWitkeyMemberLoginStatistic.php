<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "{{%member_login_statistic}}".
 *
 * @property integer $s_id
 * @property integer $uid
 * @property string $username
 * @property integer $last_login_time
 * @property string $login_ip
 */
class KekeWitkeyMemberLoginStatistic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member_login_statistic}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_keke');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'last_login_time'], 'integer'],
            [['username', 'last_login_time', 'login_ip'], 'required'],
            [['username'], 'string', 'max' => 50],
            [['login_ip'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            's_id' => '主键编号',
            'uid' => 'uid 用作联合查询索引',
            'username' => '用户名称',
            'last_login_time' => '上次登录时间',
            'login_ip' => '登录ip地址',
        ];
    }

    /**
     * 获取用户在某段时间内的登录次数
     * @param string $username 用户名
     * @param integer $start_time 起始时间，时间戳
     * @param integer $end_time 结束时间，时间戳
     * @return int
     */
    public static function getUserLoginNumber($username, $start_time, $end_time)
    {
        if (empty($username))
        {
            return 0;
        }
        $count = self::find()
            ->where(['username' => $username])
            ->andWhere(['between', 'last_login_time', $start_time, $end_time])
            ->count();
        return $count;
    }
}
