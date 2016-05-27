<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "{{%onlinetime}}".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $username
 * @property integer $online_time
 * @property integer $last_day_time
 * @property integer $last_login_time
 * @property integer $last_update_time
 */
class VsoUserOnlinetime extends \yii\db\ActiveRecord
{
    const ONLINE_TIME_MIN = 1800;   // 最低在线时长，秒，用于任务模块统计在线有效次数
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%onlinetime}}';
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
            [['uid', 'online_time', 'last_day_time', 'last_login_time', 'last_update_time'], 'integer'],
            [['username', 'last_login_time'], 'required'],
            [['username'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'username' => 'Username',
            'online_time' => 'Online Time',
            'last_day_time' => 'Last Day Time',
            'last_login_time' => 'Last Login Time',
            'last_update_time' => '记录登录时间，每在线两个小时增加一次抽奖机会',
        ];
    }

    /**
     * 获取用户在某段时间内在线时长满足要求的在线次数
     * @param string $username 用户名
     * @param integer $start_time 起始时间，时间戳
     * @param integer $end_time 结束时间，时间戳
     * @return int 在线次数
     */
    public static function getUserOnlineNumber($username, $start_time, $end_time)
    {
        if (empty($username))
        {
            return 0;
        }
        $count = self::find()
            ->where(['username' => $username])
            ->andWhere(['>', 'online_time', self::ONLINE_TIME_MIN])
            ->andWhere(['between', 'last_login_time', $start_time, $end_time])
            ->count();
        return $count;
    }
}
