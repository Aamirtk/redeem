<?php

namespace backend\modules\task\models;

use backend\modules\finance\models\VsoFinance;
use Yii;

/**
 * This is the model class for table "{{%task}}".
 *
 * @property integer $task_id
 * @property string $model_id
 * @property integer $work_count
 * @property double $single_cash
 * @property integer $profit_rate
 * @property integer $task_fail_rate
 * @property integer $task_status
 * @property string $task_title
 * @property integer $task_mark
 * @property string $task_desc
 * @property string $task_file
 * @property string $task_pic
 * @property integer $indus_id
 * @property integer $indus_pid
 * @property integer $uid
 * @property string $username
 * @property integer $start_time
 * @property integer $sub_time
 * @property integer $end_time
 * @property integer $sp_end_time
 * @property string $city
 * @property double $task_cash
 * @property double $real_cash
 * @property integer $task_cash_coverage
 * @property double $cash_cost
 * @property double $credit_cost
 * @property integer $view_num
 * @property integer $work_num
 * @property integer $leave_num
 * @property integer $focus_num
 * @property integer $mark_num
 * @property integer $is_delineas
 * @property integer $kf_uid
 * @property string $pay_item
 * @property string $att_cash
 * @property string $contact
 * @property string $unique_num
 * @property string $ext_desc
 * @property integer $task_union
 * @property integer $alipay_trust
 * @property integer $is_delay
 * @property integer $r_task_id
 * @property integer $is_trust
 * @property string $trust_type
 * @property integer $is_top
 * @property integer $is_auto_bid
 * @property string $point
 * @property string $payitem_time
 * @property string $end_action
 * @property integer $task_fail_rate_more_than_20
 * @property integer $sms_status
 * @property integer $creation_unm
 * @property integer $feedback_unm
 * @property string $mobile
 * @property string $email
 * @property string $qq
 * @property string $linkman
 * @property string $sex
 * @property integer $is_hide
 * @property string $mark
 * @property integer $bid_uid
 * @property string $bid_username
 * @property integer $bid_task_id
 * @property string $bid_modify_num
 * @property integer $msg_status
 * @property string $telephone
 * @property integer $service_charge
 * @property integer $use_vso_online
 * @property string $sitedomain
 * @property integer $cash_timeline
 * @property integer $examine_time
 * @property string $task_wid
 */
class Task extends \yii\db\ActiveRecord
{
    const TASK_STATUS_FINISHED = 8;     // 任务状态，完成
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task}}';
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
            [['work_count', 'profit_rate', 'task_fail_rate', 'task_status', 'task_mark', 'indus_id', 'indus_pid', 'uid', 'start_time', 'sub_time', 'end_time', 'sp_end_time', 'task_cash_coverage', 'view_num', 'work_num', 'leave_num', 'focus_num', 'mark_num', 'is_delineas', 'kf_uid', 'task_union', 'alipay_trust', 'is_delay', 'r_task_id', 'is_trust', 'is_top', 'is_auto_bid', 'task_fail_rate_more_than_20', 'sms_status', 'creation_unm', 'feedback_unm', 'is_hide', 'bid_uid', 'bid_task_id', 'msg_status', 'service_charge', 'use_vso_online', 'cash_timeline', 'examine_time'], 'integer'],
            [['single_cash', 'task_cash', 'real_cash', 'cash_cost', 'credit_cost', 'att_cash'], 'number'],
            [['task_desc', 'ext_desc', 'sex'], 'string'],
            [['model_id', 'end_action', 'bid_modify_num'], 'string', 'max' => 10],
            [['task_title', 'task_file', 'task_pic', 'point'], 'string', 'max' => 100],
            [['username', 'pay_item', 'email', 'linkman', 'bid_username'], 'string', 'max' => 50],
            [['city', 'trust_type', 'mobile', 'qq', 'mark'], 'string', 'max' => 20],
            [['contact'], 'string', 'max' => 255],
            [['unique_num'], 'string', 'max' => 8],
            [['payitem_time'], 'string', 'max' => 200],
            [['telephone'], 'string', 'max' => 30],
            [['sitedomain'], 'string', 'max' => 5],
            [['task_wid'], 'string', 'max' => 13]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'task_id' => '任务编号',
            'model_id' => '模型编号',
            'work_count' => '稿件数量',
            'single_cash' => '稿件单价',
            'profit_rate' => '提成比例',
            'task_fail_rate' => '任务失败时的提成比例',
            'task_status' => '任务状态',
            'task_title' => '任务标题',
            'task_mark' => 'Task Mark',
            'task_desc' => '任务描述',
            'task_file' => '任务附件',
            'task_pic' => '任务图片',
            'indus_id' => '行业编号',
            'indus_pid' => '父行业编号',
            'uid' => '用户编号',
            'username' => '用户名',
            'start_time' => '开始时间',
            'sub_time' => '交稿截止时间',
            'end_time' => '任务截止时间',
            'sp_end_time' => '公示截止时间',
            'city' => '城市地区',
            'task_cash' => '任务赏金',
            'real_cash' => '实际金额',
            'task_cash_coverage' => '金额区间',
            'cash_cost' => '金额花费',
            'credit_cost' => '创意币花费',
            'view_num' => '查看次数',
            'work_num' => '投稿次数',
            'leave_num' => '留言次数',
            'focus_num' => '收藏次数',
            'mark_num' => '互评次数',
            'is_delineas' => 'Is Delineas',
            'kf_uid' => '客服UID',
            'pay_item' => '付费项',
            'att_cash' => '增值花费',
            'contact' => '联系方式',
            'unique_num' => '唯一编号',
            'ext_desc' => '扩展描述',
            'task_union' => '联盟任务标识',
            'alipay_trust' => '支付宝托管',
            'is_delay' => '是否延期',
            'r_task_id' => '任务联盟编号',
            'is_trust' => '是否托管',
            'trust_type' => '托管类型',
            'is_top' => '是否置顶',
            'is_auto_bid' => '是否自动选稿',
            'point' => '任务坐标',
            'payitem_time' => '增值项购买时间',
            'end_action' => '自动选稿默认为 split(保证选稿) refund退还',
            'task_fail_rate_more_than_20' => 'Task Fail Rate More Than 20',
            'sms_status' => '给任务发短息  默认为0 无意义 任务结束前 1： 3天发消息  2： 1天发消息 3： 半天发消息',
            'creation_unm' => '创作人数',
            'feedback_unm' => '回应人数',
            'mobile' => '手机号',
            'email' => 'Email',
            'qq' => 'QQ号',
            'linkman' => '联系人姓名',
            'sex' => '用户性别称呼',
            'is_hide' => '雇主发布需求是填写的手机和QQ号是否需要隐藏',
            'mark' => '区别招标，明标还是暗标',
            'bid_uid' => '针对model_id=12的动漫招标，招标结束后进入项目发布页时将项目承接方存入此字段。',
            'bid_username' => '针对model_id=12的动漫招标，招标结束后进入项目发布页时将项目承接方存入此字段。',
            'bid_task_id' => '接model_id=12的招标task_id',
            'bid_modify_num' => '存储项目发布-项目修改量',
            'msg_status' => 'Msg Status',
            'telephone' => '座机电话',
            'service_charge' => '1：收服务费,0：不收服务费',
            'use_vso_online' => 'Use Vso Online',
            'sitedomain' => '二级域名标识位',
            'cash_timeline' => '保证金托管时间',
            'examine_time' => '审核时间',
            'task_wid' => '新增字段，代替task_id，时间戳加三位随机数',
        ];
    }

    /**
     * 获取用户作为甲方完成任务的累计次数
     * 筛选任务结束时间位于某个时间段内的数据
     * @param string $username 用户名
     * @param integer $start_time 起始时间，时间戳
     * @param integer $end_time 结束时间，时间戳
     * @return int 完成任务的次数
     */
    public static function getUserCompleteTaskNumberA($username, $start_time, $end_time)
    {
        if (empty($username))
        {
            return 0;
        }
        $count = Task::find()
            ->where(['task_status' => self::TASK_STATUS_FINISHED, 'username' => $username])
            ->andWhere(['between', 'end_time', $start_time, $end_time])
            ->count();
        return intval($count);
    }

    /**
     * 获取用户作为乙方完成任务的累计次数
     * @todo，待统计
     * 筛选任务结束时间位于某个时间段内的数据
     * @param string $username 用户名
     * @param integer $start_time 起始时间，时间戳
     * @param integer $end_time 结束时间，时间戳
     * @return int 完成任务的次数
     */
    public static function getUserCompleteTaskNumberB($username, $start_time, $end_time)
    {
        if (empty($username))
        {
            return 0;
        }
        $count = 0;
        return intval($count);
    }

    /**
     * 获取用户完成任务的累计次数
     * 用户完成任务的累计次数 = 作为甲方完成任务的累计次数 + 作为乙方完成任务的累计次数
     * 筛选任务结束时间位于某个时间段内的数据
     * @param string $username 用户名
     * @param integer $start_time 起始时间，时间戳
     * @param integer $end_time 结束时间，时间戳
     * @return int 完成任务的次数
     */
    public static function getUserCompleteTaskNumber($username, $start_time, $end_time)
    {
        if (empty($username))
        {
            return 0;
        }
        $count = self::getUserCompleteTaskNumberA($username, $start_time, $end_time)
                + self::getUserCompleteTaskNumberB($username, $start_time, $end_time);
        return intval($count);
    }

    /**
     * 获取用户作为甲方完成任务的累计金额
     * 筛选任务结束时间位于某个时间段内的数据
     * 统计金额字段：task_cash=>招标，real_cash=>交付，定向发布，cash_cost=>单人，计件
     * @param string $username 用户名
     * @param integer $start_time 起始时间，时间戳
     * @param integer $end_time 结束时间，时间戳
     * @return float 完成任务的累计金额
     */
    public static function getUserCompleteTaskTotalCashA($username, $start_time, $end_time)
    {
        if (empty($username))
        {
            return 0;
        }
        /*$sql = "SELECT
                    SUM(
                        CASE model_id
                            WHEN 1 THEN cash_cost
                            WHEN 3 THEN cash_cost
                            WHEN 12 THEN task_cash
                            ELSE real_cash
                        END
                    ) AS cash
                FROM keke_witkey_task
                WHERE task_status = 8
                AND username = '{$username}'
                AND end_time BETWEEN {$start_time} AND {$end_time}";
        $cash = self::getDb()->createCommand($sql)->queryScalar();*/

        $cash = self::find()
            ->select(["SUM(
                        CASE model_id
                            WHEN 1 THEN cash_cost
                            WHEN 3 THEN cash_cost
                            WHEN 12 THEN task_cash
                            ELSE real_cash
                        END
                    ) AS cash"])
            ->where(['task_status' => self::TASK_STATUS_FINISHED, 'username' => $username])
            ->andWhere(['between', 'end_time', $start_time, $end_time])
            ->scalar();
        return $cash > 0 ? $cash : 0;
    }

    /**
     * 获取用户作为乙方完成任务的累计金额
     * 筛选任务结束时间位于某个时间段内的数据
     * 统计金额字段：task_cash=>招标，real_cash=>交付，定向发布，cash_cost=>单人，计件
     * @param string $username 用户名
     * @param integer $start_time 起始时间，时间戳
     * @param integer $end_time 结束时间，时间戳
     * @return float 完成任务的累计金额
     */
    public static function getUserCompleteTaskTotalCashB($username, $start_time, $end_time)
    {
        if (empty($username))
        {
            return 0;
        }
        /**
         * 任务类型筛选
         * task_bid => 任务中标
         * task_bid_in => 项目阶段收入
         * cash_deposit => 项目保证金支付乙方
         */
        $fina_action_arr = [
            'task_bid',
            'task_bid_in',
            'cash_deposit'
        ];
        $cash = VsoFinance::find()
            ->select("SUM(`fina_cash`) AS cash")
            ->where(['username' => $username])
            ->andWhere(['>', 'fina_cash', 0])
            ->andWhere(['in', 'fina_action', $fina_action_arr])
            ->andWhere(['between', 'fina_time', $start_time, $end_time])
            ->scalar();
        return $cash > 0 ? $cash : 0;
    }

    /**
     * 获取用户在某个时间段内完成任务的累计金额
     * 用户完成任务的累计金额 = 作为甲方发布并完成任务的金额 + 作为乙方中标的金额
     * @param string $username 用户名
     * @param integer $start_time 起始时间，时间戳
     * @param integer $end_time 结束时间，时间戳
     * @return float
     */
    public static function getUserCompleteTaskTotalCash($username, $start_time, $end_time)
    {
        if (empty($username))
        {
            return 0;
        }
        $cashA = self::getUserCompleteTaskTotalCashA($username, $start_time, $end_time);
        $cashB = self::getUserCompleteTaskTotalCashB($username, $start_time, $end_time);
        $total = $cashA + $cashB;
        return $total > 0 ? $total : 0;
    }

    /**
     * 获取用户在某个时间段内发布任务的次数
     * @param string $username 用户名
     * @param integer $start_time 起始时间，时间戳
     * @param integer $end_time 结束时间，时间戳
     * @return int 发布任务的次数
     */
    public static function getUserPubTaskNumber($username, $start_time, $end_time)
    {
        if (empty($username))
        {
            return 0;
        }
        $count = self::find()
            ->where(['username' => $username])
            ->andWhere(['between', 'start_time', $start_time, $end_time])
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
    public static function getUserWorkBidNumber($username, $start_time, $end_time)
    {
        if (empty($username))
        {
            return 0;
        }
        $fileBid = TaskBid::getUserTaskBidCount($username, $start_time, $end_time);
        $fileWork = TaskWork::getUserWorkBidCount($username, $start_time, $end_time);
        return intval($fileBid + $fileWork);
    }

    /**
     * 获取用户在某时间段内的总投稿次数
     * @param string $username 用户名
     * @param integer $start_time 起始时间，时间戳
     * @param integer $end_time 结束时间，时间戳
     * @return int
     */
    public static function getUserTaskDeliveryCount($username, $start_time, $end_time)
    {
        if (empty($username))
        {
            return 0;
        }
        $countBid = TaskBid::getUserDeliveryCount($username, $start_time, $end_time);
        $countWork = TaskWork::getUserDeliveryCount($username, $start_time, $end_time);
        return intval($countBid) + intval($countWork);
    }

    /**
     * 获取用户在某段时间内托管任务金额
     * @param string $username 用户名
     * @param integer $start_time 起始时间，时间戳
     * @param integer $end_time 结束时间，时间戳
     * @return int 任务托管金额
     */
    public static function getUserTrusteeship($username, $start_time, $end_time)
    {
        if (empty($username))
        {
            return 0;
        }
        /*
        $fins_action_arr = ['pub_task', 'pay_warrant'];
        $cash = VsoFinance::find()
            ->select("SUM(`fina_cash`)")
            ->where(['fina_type' => 'out', 'username' => $username])
            ->andWhere(['>', 'fina_cash', 0])
            ->andWhere(['in', 'fina_action', $fins_action_arr])
            ->andWhere(['between', 'fina_time', $start_time, $end_time])
            ->scalar();
        */
        $sql = "SELECT SUM(fina_cash) AS cash
                FROM vsoucenter.vso_finance f
                INNER JOIN keke_witkey_utf8.keke_witkey_task t ON t.task_id = f.obj_id
                WHERE f.username = '{$username}'
                AND t.model_id IN (12,13,14)
                AND fina_action IN ('pay_warrant', 'pub_task')
                AND f.fina_time BETWEEN {$start_time} AND {$end_time}";
        $cash = VsoFinance::getDb()->createCommand($sql)->queryScalar();
        return $cash  > 0 ? $cash : 0;
    }

    /**
     * 获取用户在某段时间内保证金托管的留存金额
     * 目前平台上涉及保证金的任务类型有3种，model_id筛选：12=>招标，13=>动漫交付，14=>定向发布
     * 留存保证金 = 托管保证金 - 退还保证金
     * 托管保证金的操作类型：pay_warrant => 招标任务，pub_task => 动漫交付&定向发布
     * 退还保证金的操作类型：return_warrant => 招标任务退还保证金，task_fail => 动漫交付退还保证金
     * @param string $username 用户名
     * @param integer $start_time 起始时间，时间戳
     * @param integer $end_time 结束时间，时间戳
     * @return float 金额
     */
    public static function getUserNetWarrantCash($username, $start_time, $end_time)
    {
        if (empty($username))
        {
            return 0;
        }

        $sql = "SELECT
                    SUM(
                        fina_cash * (
                            CASE
                                WHEN fina_action IN ('pay_warrant', 'pub_task') THEN 1
                                ELSE -1
                            END
                        )
                    ) AS cash
                FROM vsoucenter.vso_finance f
                INNER JOIN keke_witkey_utf8.keke_witkey_task t ON t.task_id = f.obj_id
                WHERE f.username = '{$username}'
                AND t.model_id IN (12,13,14)
                AND fina_action IN ('pay_warrant', 'pub_task', 'return_warrant', 'task_fail')
                AND f.fina_time BETWEEN {$start_time} AND {$end_time}";
        $cash = VsoFinance::getDb()->createCommand($sql)->queryScalar();
        return $cash > 0 ? $cash : 0;
    }

    /**
     * 获取任务类型
     * @param integer $task_status 任务状态
     * @return array
     */
    public static function getTaskModelName($model_id = null)
    {
        $modelArr = [
            '1' => '单人悬赏',
            '3' => '计件悬赏',
            '12' => '招标任务',
            '13' => '动漫交付',
            '14' => '定向发布',
        ];
        if ($model_id != null)
        {
            return isset($modelArr[$model_id]) ? $modelArr[$model_id] : '';
        }
        return $modelArr;
    }

    /**
     * 任务状态语言包
     * @param integer $task_status 任务状态
     * @return array
     */
    public static function getTaskStatusArr($task_status = null)
    {
        $statusArr = [
            '0' => '未付款',
            '1' => '待审核',
            '2' => '投稿中',
            '3' => '选稿中',
            '4' => '投票中',
            '5' => '公示中',
            '6' => '交付',
            '7' => '冻结',
            '8' => '结束',
            '9' => '失败',
            '10' => '审核失败',
            '11' => '仲裁',
            '12' => '担保退款',
            '13' => '交付冻结',
            '14' => '阶段交付完毕，等待质保期过期',
            '15' => '雇主已经支付保证金'
        ];
        if ($task_status != null)
        {
            return isset($statusArr[$task_status]) ? $statusArr[$task_status] : '';
        }
        return $statusArr;
    }
}
