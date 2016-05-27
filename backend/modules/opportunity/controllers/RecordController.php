<?php

namespace backend\modules\opportunity\controllers;

use common\models\UserModel;
use yii;
use app\base\CommonWebController;
use backend\modules\opportunity\models\OpportunityRecord;

class RecordController extends CommonWebController
{
    public $_line_breaks = "\r\n";
    public $_file_name_prefix = "opp_record_";

    public function limitActions()
    {
        return ['list', 'list-data', 'export'];
    }

    public function actionList()
    {
        $data = [
            'task_id' => $this->getHttpParam('task_id', false),
            'task_wid' => $this->getHttpParam('task_wid', false),
            'username' => $this->getHttpParam('username', false)
        ];
        return $this->render('list', $data);
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
            ->orderBy($order_by)
            ->offset($offset)
            ->limit($pageSize)
            ->asArray()
            ->all();

        $this->printSuccess(['list' => $list, 'totalCount' => $count]);
    }

    /**
     * 推送记录导出CSV
     * 数据范围为实际搜索结果
     */
    public function actionExport()
    {
        set_time_limit(0);
        // 搜索条件
        $search = [
            'task_id' => trim(yii::$app->request->get('task_id')),
            'task_wid' => trim(yii::$app->request->get('task_wid')),
            'username' => trim(yii::$app->request->get('username')),
            'created_range_start' => yii::$app->request->get('created_range_start'),
            'created_range_end' => yii::$app->request->get('created_range_end'),
            'order_key' => yii::$app->request->get('order_key'),
            'order_direction' => yii::$app->request->get('order_direction')
        ];

        $queryCondition = $this->getQueryBySearchArr($search);
        $query = $queryCondition['query'];
        $order_by = $queryCondition['order_by'];

        $list = $query
            ->orderBy($order_by)
            ->asArray()
            ->all();

        $dataStr = '';
        // 补全页面显示字段，避免联表查询
        foreach ($list as $k => $v)
        {
            $row = [
                'id' => $v['id'], // ID
                'task_title' => UserModel::iconvGbkToUtf8($v['task_title']), // 任务名称
                'username' => $v['username'], // 发布人
                'view_status' => UserModel::iconvGbkToUtf8(self::getStatusAlias($v['view_status'])), // 是否已查看
                'view_time' => UserModel::timestampFormat($v['view_time']), // 查看时间
                'contact_status' => UserModel::iconvGbkToUtf8(self::getStatusAlias($v['contact_status'])), // 是否已联系
                'contact_time' => UserModel::timestampFormat($v['contact_time']), // 联系时间
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
            '用户名',
            '是否已查看',
            '查看时间',
            '是否已联系',
            '联系时间',
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
        $query = OpportunityRecord::find();
        $order_by = ['id' => SORT_DESC];

        if (!empty($search))
        {
            // 旧版任务编号筛选
            if (isset($search['task_id']) && !empty($search['task_id']))
            {
                $query->where(['task_id' => $search['task_id']]);
            }
            // 新版任务编号筛选
            if (isset($search['task_wid']) && !empty($search['task_wid']))
            {
                $query->andWhere(['task_wid' => $search['task_wid']]);
            }
            // 用户名筛选
            if (isset($search['username']) && !empty($search['username']))
            {
                $query->andWhere(['like', 'username', $search['username']]);
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
     * 获取状态别名，用于是否已查看，是否已联系
     * @param integer $status 状态值
     * @return string 状态对应的语言包，是or否
     */
    public static function getStatusAlias($status)
    {
        $statusArr = ['否', '是'];
        // 非法状态，下标超出
        if ($status > 1 || $status < 0)
        {
            $status = 0;
        }
        return $statusArr[$status];
    }
}
