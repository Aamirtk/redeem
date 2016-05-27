<?php

namespace backend\modules\opportunity\controllers;

use backend\modules\industry\models\KekeWitkeyIndustry;
use backend\modules\opportunity\models\OpportunityTask;
use backend\modules\task\models\Task;
use common\models\UserModel;
use yii;
use app\base\CommonWebController;

class TaskController extends CommonWebController
{
    public $_line_breaks = "\r\n";
    public $_file_name_prefix = "opp_task_";

    public function limitActions()
    {
        return ['list', 'list-data', 'export', 'get-task-info'];
    }

    public function actionList()
    {
        return $this->render('list');
    }

    public function actionListData()
    {
        $page = $this->getHttpParam('page', false, 0);
        $pageSize = $this->getHttpParam('pageSize', false, 10);
        $offset = $page * $pageSize;
        $search = $this->getHttpParam('search', false, null);

        $queryCondition = $this->getQueryBySearchArr($search);
        // 查询对象
        $query = $queryCondition['query'];
        // 排序
        $order_by = $queryCondition['order_by'];
        // 总条数
        $count = $query->count();
        // 列表
        $list = $query
            ->with('task')
            ->orderBy($order_by)
            ->offset($offset)
            ->limit($pageSize)
            ->asArray()
            ->all();

        // 补全页面显示字段，避免联表查询
        foreach ($list as $k => $v)
        {
            $task = $v['task'];
            // 发布人昵称
            $list[$k]['nickname'] = UserModel::getUserNicknameByUsername($task['username']);
            // 行业一级分类
            $list[$k]['indus_pid_name'] = KekeWitkeyIndustry::getIndusNameById($task['indus_pid']);
            // 行业二级分类
            $list[$k]['indus_id_name'] = KekeWitkeyIndustry::getIndusNameById($task['indus_id']);
            // 任务类型
            $list[$k]['model_name'] = Task::getTaskModelName($task['model_id']);
            // 任务状态
            $list[$k]['task_status_alias'] = Task::getTaskStatusArr($task['task_status']);
        }

        $this->printSuccess(['list' => $list, 'totalCount' => $count]);
    }

    /**
     * 任务推送记录导出CSV
     * 数据范围为实际搜索结果
     */
    public function actionExport()
    {
        set_time_limit(0);
        // 搜索条件
        $search = [
            'task_id' => trim(yii::$app->request->get('task_id')),
            'task_wid' => trim(yii::$app->request->get('task_wid')),
            'created_range_start' => yii::$app->request->get('created_range_start'),
            'created_range_end' => yii::$app->request->get('created_range_end'),
            'order_key' => yii::$app->request->get('order_key'),
            'order_direction' => yii::$app->request->get('order_direction')
        ];

        $queryCondition = $this->getQueryBySearchArr($search);
        $query = $queryCondition['query'];
        $order_by = $queryCondition['order_by'];

        $list = $query
            ->with('task')
            ->orderBy($order_by)
            ->asArray()
            ->all();

        $dataStr = '';
        // 补全页面显示字段，避免联表查询
        foreach ($list as $k => $v)
        {
            $task = $v['task'];
            $row = [
                'id' => $v['id'], // ID
                'task_title' => UserModel::iconvGbkToUtf8($task['task_title']), // 任务名称
                'username' => $task['username'], // 发布人
                'nickname' => UserModel::iconvGbkToUtf8(UserModel::getUserNicknameByUsername($task['username'])), // 发布人昵称
                'indus_pid_name' => UserModel::iconvGbkToUtf8(KekeWitkeyIndustry::getIndusNameById($task['indus_pid'])), // 行业一级分类
                'indus_id_name' => UserModel::iconvGbkToUtf8(KekeWitkeyIndustry::getIndusNameById($task['indus_id'])), // 行业二级分类
                'start_time' => UserModel::timestampFormat($task['start_time']), // 发布日期
                'model_name' => UserModel::iconvGbkToUtf8(Task::getTaskModelName($task['model_id'])), // 任务类型
                'end_time' => UserModel::timestampFormat($task['end_time']), // 截止日期
                'task_status_alias' => UserModel::iconvGbkToUtf8(Task::getTaskStatusArr($task['task_status'])), // 任务状态
                'created_at' => UserModel::timestampFormat($v['created_at']) // 推送时间
            ];

            $dataStr .= implode(',', $row) . $this->_line_breaks;
        }

        $this->exportCsv($dataStr);
    }

    /**
     * 导出CSV文件时获取输出列语言包
     * @return array
     */
    public static function getCsvHeaderLine()
    {
        $headArr = [
            ' ID',
            '任务名称',
            '发布人',
            '发布人昵称',
            '行业一级分类',
            '行业二级分类',
            '发布日期',
            '任务类型',
            '截止日期',
            '状态',
            '推送时间'
        ];
        return UserModel::iconvGbkToUtf8(implode(",", $headArr));
    }

    public function exportCsv($dataStr)
    {
        $fileName = $this->_file_name_prefix . date("YmdHis") . ".csv";
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=" . $fileName);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        echo self::getCsvHeaderLine() . $this->_line_breaks . $dataStr;
    }

    /**
     * 根据搜索条件数组获取查询对象和排序
     * 用于列表展示和导出
     * @param array $search 搜索条件
     * @return yii\db\ActiveQuery
     */
    public function getQueryBySearchArr($search)
    {
        $query = OpportunityTask::find();
        $order_by = ['id' => SORT_DESC];

        if (!empty($search))
        {
            // 旧版任务编号筛选
            if (isset($search['task_id']))
            {
                if (!empty($search['task_id']))
                {
                    $query->where(['task_id' => $search['task_id']]);
                }
                elseif (empty($search['task_id']) && $search['task_id'] === '0')
                {
                    $query->where(['task_id' => $search['task_id']]);
                }
            }
            // 新版任务编号筛选
            if (isset($search['task_wid']))
            {
                if (!empty($search['task_wid']))
                {
                    $query->andWhere(['task_wid' => $search['task_wid']]);
                }
                elseif (empty($search['task_wid']) && $search['task_wid'] === '0')
                {
                    $query->andWhere(['task_wid' => $search['task_wid']]);
                }
            }
            // 推送时间筛选
            if (isset($search['created_range_start']) && !empty($search['created_range_start']))
            {
                $query->andWhere(['>', 'created_at', strtotime($search['created_range_start']) - 1]);
            }
            if (isset($search['created_range_end']) && !empty($search['created_range_end']))
            {
                $query->andWhere(['<', 'created_at', strtotime($search['created_range_end']) + 1]);
            }
            // 排序
            if (isset($search['order_key']))
            {
                if ($search['order_direction'] == 'desc')
                {
                    $order_by = [$search['order_key'] => SORT_DESC];
                }
                else
                {
                    $order_by = [$search['order_key'] => SORT_ASC];
                }
            }
        }
        return ['query' => $query, 'order_by' => $order_by];
    }

    /**
     * ajax获取任务信息，GET
     * @param integer $task_id 任务编号
     */
    public function actionGetTaskInfo()
    {
        $task_id = yii::$app->request->get('task_id');
        if (empty($task_id))
        {
            echo json_encode([]);
            exit;
        }
        $record = OpportunityTask::find()
            ->with('task')
            ->where(['task_id' => $task_id])
            ->asArray()
            ->one();
        if (empty($record))
        {
            echo json_encode([]);
            exit;
        }
        $task = $record['task'];
        $record['nickname'] = UserModel::getUserNicknameByUsername($task['username']);
        // 行业一级分类
        $record['indus_pid_name'] = KekeWitkeyIndustry::getIndusNameById($task['indus_pid']);
        // 行业二级分类
        $record['indus_id_name'] = KekeWitkeyIndustry::getIndusNameById($task['indus_id']);
        // 任务类型
        $record['model_name'] = Task::getTaskModelName($task['model_id']);
        // 任务状态
        $record['task_status_alias'] = Task::getTaskStatusArr($task['task_status']);
        echo json_encode($record);
        exit;
    }
}