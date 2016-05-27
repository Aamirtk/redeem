<?php

namespace backend\modules\task\models;

use Yii;

/**
 * This is the model class for table "{{%task_work}}".
 *
 * @property integer $work_id
 * @property integer $task_id
 * @property integer $uid
 * @property string $username
 * @property string $work_title
 * @property double $work_price
 * @property integer $work_cycle
 * @property string $work_desc
 * @property string $work_file
 * @property string $work_pic
 * @property integer $work_time
 * @property integer $hide_work
 * @property integer $vote_num
 * @property integer $comment_num
 * @property integer $work_status
 * @property string $mobile
 * @property integer $view_status
 * @property integer $msg
 */
class TaskWork extends \yii\db\ActiveRecord
{
    const WORK_STATUS_WAIT = 0;     // 待选
    const WORK_STATUS_BID = 4;      // 选中
    const WORK_STATUS_HG = 6;       // 合格，计件悬赏使用
    const WORK_STATUS_OUT = 7;      // 淘汰

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_work}}';
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
            [['task_id', 'uid', 'work_cycle', 'work_time', 'hide_work', 'vote_num', 'comment_num', 'work_status', 'view_status', 'msg'], 'integer'],
            [['work_price'], 'number'],
            [['work_desc'], 'string'],
            [['username'], 'string', 'max' => 50],
            [['work_title', 'work_file', 'work_pic'], 'string', 'max' => 100],
            [['mobile'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'work_id' => '稿件编号',
            'task_id' => '任务编号',
            'uid' => '用户编号',
            'username' => '用户名',
            'work_title' => '稿件标题',
            'work_price' => '稿件单价',
            'work_cycle' => '工作周期',
            'work_desc' => '稿件描述',
            'work_file' => '稿件附件',
            'work_pic' => '稿件图标',
            'work_time' => '交稿时间',
            'hide_work' => '稿件隐藏',
            'vote_num' => '投票次数',
            'comment_num' => '留言次数',
            'work_status' => '稿件状态',
            'mobile' => '用户手机号',
            'view_status' => '作者对稿件是否浏览 0表示未读 1表示已读',
            'msg' => 'Msg',
        ];
    }

    /**
     * 获取用户在某时间段内的非招标投稿次数
     * @param string $username 用户名
     * @param integer $start_time 起始时间，时间戳
     * @param integer $end_time 结束时间，时间戳
     * @return int 投稿次数
     */
    public static function getUserDeliveryCount($username, $start_time, $end_time)
    {
        if (empty($username))
        {
            return 0;
        }
        $count = self::find()
            ->where(['username' => $username])
            ->andWhere(['between', 'work_time', $start_time, $end_time])
            ->count();
        return intval($count);
    }

    /**
     * 获取用户在某段时间内的中稿次数
     * @param string $username 用户名
     * @param integer $start_time 起始时间，时间戳
     * @param integer $end_time 结束时间，时间戳
     * @return int 中稿次数
     */
    public static function getUserWorkBidCount($username, $start_time, $end_time)
    {
        if (empty($username))
        {
            return 0;
        }
        $work_status_arr = [
            self::WORK_STATUS_BID,
            self::WORK_STATUS_HG
        ];
        $count = self::find()
            ->where(['username' => $username])
            ->andWhere(['in', 'work_status', $work_status_arr])
            ->andWhere(['between', 'work_time', $start_time, $end_time])
            ->count();
        return intval($count);
    }
}
