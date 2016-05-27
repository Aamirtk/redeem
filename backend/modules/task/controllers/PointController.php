<?php

namespace backend\modules\task\controllers;

use backend\modules\finance\models\VsoFinance;
use backend\modules\task\models\Task;
use backend\modules\task\models\TaskBid;
use backend\modules\task\models\TaskFile;
use backend\modules\task\models\TaskMarkModel;
use backend\modules\task\models\TaskWork;
use backend\modules\user\models\VsoUserExt;
use yii;
use yii\base\Controller;

/**
 * 任务模块赠送积分
 * 甲方：发布任务（单人&计件&招标），托管，选标，结款，互评
 * 乙方：承接任务，投稿，被选中，互评
 * Class PointController
 * @package backend\modules\task\controllers
 */
class PointController extends Controller
{
    protected $_time = '';

    public function beforeAction($action)
    {
        // 检索数据的起始时间，-1避免sql中的>=
        $this->_time = time() - yii::$app->params['point_task_cycle'] - 1;
        return parent::beforeAction($action);
    }

    /**
     * 任务相关的赠送积分点
     */
    public function actionIndex()
    {
        // 甲方：单人悬赏，计件悬赏
        $this->actionPubTaskReward();
        // 甲方：招标任务（明标）
        $this->actionPubTaskBtenderClear();
        // 甲方：招标任务（暗标）
        $this->actionPubTaskBtenderDark();
        // 甲方：任务托管
        $this->actionTrusteeship();
        // 甲方：任务选标
        $this->actionWorkChoose();
        // 甲方：结款
        $this->actionFinish();
        // 甲方：公示
        $this->actionPublish();
        // 甲方：任务结束互评
        $this->actionTaskMarkA();
        // 乙方：承接任务
        $this->actionUnderTake();
        // 乙方：任务投稿
        $this->actionDelivery();
        // 乙方：稿件被选中
        $this->actionWorkSelected();
        // 乙方：任务结束互评
        $this->actionTaskMarkB();
    }

    /**
     * 甲方：单人悬赏，计件悬赏
     * model_id：1=>单人悬赏，3=>计件悬赏
     */
    public function actionPubTaskReward()
    {
        // 规则Key，对应vso_point_config_rule中的action字段，值唯一且不变
        $action = 'task_a_reward';
        // 检索赠送积分的数据范围
        $list = Task::find()
            ->select('username, task_id')
            ->where(['in', 'model_id', [1, 3]])
            ->andWhere(['>', 'start_time', $this->_time])
            ->asArray()
            ->all();
        if (empty($list))
        {
            return false;
        }
        // 赠送积分
        foreach ($list as $k => $v)
        {
            VsoUserExt::increaseUserPoint($v['username'], $action, $v['task_id'], 'task');
        }
    }

    /**
     * 甲方：招标任务（明标）
     * model_id：12=>招标任务
     * mark：clear=>明标
     */
    public function actionPubTaskBtenderClear()
    {
        $action = 'task_a_btender_clear';
        $list = Task::find()
            ->select('username, task_id')
            ->where(['model_id' => 12, 'mark' => 'clear'])
            ->andWhere(['>', 'start_time', $this->_time])
            ->asArray()
            ->all();
        if (empty($list))
        {
            return false;
        }
        foreach ($list as $k => $v)
        {
            VsoUserExt::increaseUserPoint($v['username'], $action, $v['task_id'], 'task');
        }
    }

    /**
     * 甲方：招标任务（暗标）
     * model_id：12=>招标任务
     * mark：dark=>暗标
     */
    public function actionPubTaskBtenderDark()
    {
        $action = 'task_a_btender_dark';
        $list = Task::find()
            ->select('username, task_id')
            ->where(['model_id' => 12, 'mark' => 'dark'])
            ->andWhere(['>', 'start_time', $this->_time])
            ->asArray()
            ->all();
        if (empty($list))
        {
            return false;
        }
        foreach ($list as $k => $v)
        {
            VsoUserExt::increaseUserPoint($v['username'], $action, $v['task_id'], 'task');
        }
    }

    /**
     * 甲方：任务托管
     */
    public function actionTrusteeship()
    {
        $action = 'task_a_trusteeship';
        $fins_action_arr = ['pub_task', 'pay_warrant'];

        $list = VsoFinance::find()
            ->select('username, obj_id')
            ->where(['fina_type' => 'out'])
            ->andWhere(['>', 'fina_cash', 0])
            ->andWhere(['>', 'fina_time', $this->_time])
            ->andWhere(['in', 'fina_action', $fins_action_arr])
            ->asArray()
            ->all();

        if (empty($list))
        {
            return false;
        }
        foreach ($list as $k => $v)
        {
            VsoUserExt::increaseUserPoint($v['username'], $action, $v['obj_id'], 'finance');
        }
    }

    /**
     * 甲方：任务选标
     * work_status：4=>稿件被选中，6=>合格，计件悬赏使用
     */
    public function actionWorkChoose()
    {
        $action = 'task_a_choose';
        $taskTable = Task::tableName();
        $taskWorkTable = TaskWork::tableName();
        $taskBidTable = TaskBid::tableName();

        $work_status_arr = [
            TaskWork::WORK_STATUS_BID,
            TaskWork::WORK_STATUS_HG
        ];

        $list_other = TaskWork::find()
            ->select(["{$taskTable}.username", "{$taskWorkTable}.task_id", "{$taskWorkTable}.work_id"])
            ->leftJoin($taskTable, "{$taskTable}.task_id={$taskWorkTable}.task_id")
            ->where(['in', "{$taskWorkTable}.work_status", $work_status_arr])
            ->andWhere(['>', "{$taskWorkTable}.work_time", $this->_time])
            ->asArray()
            ->all();
        $list_bid = TaskBid::find()
            ->select(["{$taskBidTable}.username, {$taskBidTable}.task_id, {$taskBidTable}.bid_id"])
            ->leftJoin($taskTable, "{$taskTable}.task_id={$taskBidTable}.task_id")
            ->where(["{$taskBidTable}.bid_status" => TaskBid::BID_STATUS_BID])
            ->andWhere(['>', 'bid_time', $this->_time])
            ->asArray()
            ->all();
        $list = array_merge($list_bid, $list_other);

        if (empty($list))
        {
            return false;
        }
        foreach ($list as $k => $v)
        {
            VsoUserExt::increaseUserPoint($v['username'], $action, $v['task_id'], 'task_work&task_bid');
        }
    }

    /**
     * 甲方：结款
     * task_status：8=>成功，任务结束
     */
    public function actionFinish()
    {
        $action = 'task_a_finish';
        $list = Task::find()
            ->select('username, task_id')
            ->where(['task_status' => 8])
            ->andWhere(['>', 'end_time', $this->_time])
            ->asArray()
            ->all();
        if (empty($list))
        {
            return false;
        }
        foreach ($list as $k => $v)
        {
            VsoUserExt::increaseUserPoint($v['username'], $action, $v['task_id'], 'task');
        }
    }

    /**
     * 甲方：任务公示
     * task_status：5=>公示中，6=>交付中，8=>成功，任务结束
     */
    public function actionPublish()
    {
        $action = 'task_a_public';
        $list = Task::find()
            ->select('username, task_id')
            ->where(['in', 'task_status', [5, 6, 8]])
            ->andWhere(['>', 'start_time', $this->_time])
            ->asArray()
            ->all();
        if (empty($list))
        {
            return false;
        }
        foreach ($list as $k => $v)
        {
            VsoUserExt::increaseUserPoint($v['username'], $action, $v['task_id'], 'task');
        }
    }

    /**
     * 甲方：任务结束互评
     */
    public function actionTaskMarkA()
    {
        $action = 'task_a_comment';
        $list = TaskMarkModel::find()
            ->select('by_username, mark_id')
            ->where(['mark_type' => TaskMarkModel::MARK_TYPE_SELLER])
            ->andWhere(['>', 'mark_time', $this->_time])
            ->andWhere(['not', ['mark_content' => null]])
            ->asArray()
            ->all();
        if (empty($list))
        {
            return false;
        }
        foreach ($list as $k => $v)
        {
            VsoUserExt::increaseUserPoint($v['by_username'], $action, $v['mark_id'], 'mark');
        }
    }

    /**
     * 乙方：承接任务
     */
    public function actionUnderTake()
    {
        $action = 'task_b_undertake';
        $list = TaskFile::find()
            ->select('username, task_id, id')
            ->where(['>', 'on_time', $this->_time])
            ->asArray()
            ->all();
        if (empty($list))
        {
            return false;
        }
        foreach ($list as $k => $v)
        {
            VsoUserExt::increaseUserPoint($v['username'], $action, $v['task_id'], 'task_file');
        }
    }

    /**
     * 乙方：任务投稿
     */
    public function actionDelivery()
    {
        $action = 'task_b_delivery';
        $list_other = TaskWork::find()
            ->select('username, task_id, work_id AS obj_id')
            ->where(['>', 'work_time', $this->_time])
            ->asArray()
            ->all();
        $list_bid = TaskBid::find()
            ->select('username, task_id, bid_id AS obj_id')
            ->where(['>', 'bid_time', $this->_time])
            ->asArray()
            ->all();
        $list = array_merge($list_bid, $list_other);

        if (empty($list))
        {
            return false;
        }
        foreach ($list as $k => $v)
        {
            VsoUserExt::increaseUserPoint($v['username'], $action, $v['task_id'], 'task_work&task_bid');
        }
    }

    /**
     * 乙方：稿件被选中
     * work_status：4=>稿件被选中，6=>合格，计件悬赏使用
     */
    public function actionWorkSelected()
    {
        $action = 'task_b_selected';
        $work_status_arr = [
            TaskWork::WORK_STATUS_BID,
            TaskWork::WORK_STATUS_HG
        ];

        $list_other = TaskWork::find()
            ->select('username, task_id, work_id')
            ->where(['in', 'work_status', $work_status_arr])
            ->andWhere(['>', 'work_time', $this->_time])
            ->asArray()
            ->all();
        $list_bid = TaskBid::find()
            ->select('username, task_id, bid_id')
            ->where(['bid_status' => TaskBid::BID_STATUS_BID])
            ->andWhere(['>', 'bid_time', $this->_time])
            ->asArray()
            ->all();
        $list = array_merge($list_bid, $list_other);

        if (empty($list))
        {
            return false;
        }
        foreach ($list as $k => $v)
        {
            VsoUserExt::increaseUserPoint($v['username'], $action, $v['task_id'], 'task_work&task_bid');
        }
    }

    /**
     * 乙方：任务结束互评
     */
    public function actionTaskMarkB()
    {
        $action = 'task_b_comment';
        $list = TaskMarkModel::find()
            ->select('by_username, mark_id')
            ->where(['mark_type' => TaskMarkModel::MARK_TYPE_BUYER])
            ->andWhere(['>', 'mark_time', $this->_time])
            ->andWhere(['not', ['mark_content' => null]])
            ->asArray()
            ->all();
        if (empty($list))
        {
            return false;
        }
        foreach ($list as $k => $v)
        {
            VsoUserExt::increaseUserPoint($v['by_username'], $action, $v['mark_id'], 'task_work&task_bid');
        }
    }
}