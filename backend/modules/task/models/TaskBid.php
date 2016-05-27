<?php

namespace backend\modules\task\models;

use Yii;

/**
 * This is the model class for table "{{%task_bid}}".
 *
 * @property integer $bid_id
 * @property integer $task_id
 * @property integer $uid
 * @property string $username
 * @property string $quote
 * @property integer $cycle
 * @property string $area
 * @property string $message
 * @property integer $bid_status
 * @property integer $bid_time
 * @property integer $hidden_status
 * @property integer $ext_status
 * @property integer $comment_num
 * @property string $mobile
 * @property integer $sign_time
 */
class TaskBid extends \yii\db\ActiveRecord
{
    const BID_STATUS_WAIT = 0;      // 待选
    const BID_STATUS_BID = 4;       // 选中
    const BID_STATUS_OUT = 7;       // 淘汰
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_bid}}';
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
            [['task_id', 'uid', 'cycle', 'bid_status', 'bid_time', 'hidden_status', 'ext_status', 'comment_num', 'sign_time'], 'integer'],
            [['quote'], 'number'],
            [['message'], 'string'],
            [['username', 'area'], 'string', 'max' => 50],
            [['mobile'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bid_id' => '投标编号',
            'task_id' => '任务编号',
            'uid' => '用户编号',
            'username' => '用户名',
            'quote' => '投标周期',
            'cycle' => '投标报价',
            'area' => '投标地区',
            'message' => '投标备注',
            'bid_status' => '投标状态',
            'bid_time' => '投标时间',
            'hidden_status' => '隐藏状态',
            'ext_status' => '扩展状态',
            'comment_num' => '留言次数',
            'mobile' => '用户手机号',
            'sign_time' => '用户签署时间戳',
        ];
    }

    /**
     * 获取用户在某时间段内的招标投稿次数
     * @param string $username 用户名
     * @param integer $start_time 起始时间，时间戳
     * @param integer $end_time 结束时间，时间戳
     * @return int 招标投稿次数
     */
    public static function getUserDeliveryCount($username, $start_time, $end_time)
    {
        if (empty($username))
        {
            return 0;
        }
        $count = self::find()
            ->where(['username' => $username])
            ->andWhere(['between', 'bid_time', $start_time, $end_time])
            ->count();
        return intval($count);
    }

    /**
     * 获取用户在某段时间内的中标次数
     * @param string $username 用户名
     * @param integer $start_time 起始时间，时间戳
     * @param integer $end_time 结束时间，时间戳
     * @return int 中标次数
     */
    public static function getUserTaskBidCount($username, $start_time, $end_time)
    {
        if (empty($username))
        {
            return 0;
        }
        $count = self::find()
            ->where(['username' => $username])
            ->andWhere(['bid_status' => self::BID_STATUS_BID])
            ->andWhere(['between', 'bid_time', $start_time, $end_time])
            ->count();
        return intval($count);
    }
}
