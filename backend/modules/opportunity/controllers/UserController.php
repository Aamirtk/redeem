<?php

namespace backend\modules\opportunity\controllers;

use backend\modules\opportunity\models\OpportunityUser;
use common\models\UserModel;
use yii;
use app\base\CommonWebController;

class UserController extends CommonWebController
{
    public $_line_breaks = "\r\n";
    public $_file_name_prefix = "opp_user_";

    public function limitActions()
    {
        return ['list', 'list-data', 'export', 'get-user-info'];
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
            ->with('privileges')
            ->orderBy($order_by)
            ->offset($offset)
            ->limit($pageSize)
            ->asArray()
            ->all();

        $this->printSuccess(['list' => $list, 'totalCount' => $count]);
    }

    /**
     * 用户推送记录导出CSV
     * 数据范围为实际搜索结果
     */
    public function actionExport()
    {
        set_time_limit(0);
        // 搜索条件
        $search = [
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
            ->with('privileges')
            ->orderBy($order_by)
            ->asArray()
            ->all();

        $dataStr = '';
        // 补全页面显示字段，避免联表查询
        foreach ($list as $k => $v)
        {
            $row = [
                'id' => $v['id'], // ID
                'username' => $v['username'], // 用户名
                'group_name' => UserModel::iconvGbkToUtf8($v['privileges']['group_name']), // 会员级别
                'business_push' => $v['privileges']['business_push'], // 金额上限（万元）
                'recommend_cash' => OpportunityUser::cashFormat($v['recommend_cash']), // 已推送上线（万元）
                'recommend_count' => $v['recommend_count'], // 推送条数
                'view_count' => $v['view_count'], // 已查看
                'contact_count' => $v['contact_count'] // 已联系
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
            '用户名',
            '会员级别',
            '金额上限（万元）',
            '已推送上线（万元）',
            '推送条数',
            '已查看',
            '已联系'
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
        $query = OpportunityUser::find();
        $order_by = ['id' => SORT_DESC];

        if (!empty($search))
        {
            // 用户编号筛选
            if (isset($search['username']))
            {
                if (!empty($search['username']))
                {
                    $query->where(['like', 'username', $search['username']]);
                }
                elseif (empty($search['username']) && $search['username'] === '0')
                {
                    $query->where(['username' => $search['username']]);
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
     * ajax获取会员信息，GET
     * @param string $username 用户名
     */
    public function actionGetUserInfo($username)
    {
        if (empty($username))
        {
            echo json_encode([]);
            exit;
        }
        $user = OpportunityUser::find()
            ->with('privileges')
            ->where(['username' => $username])
            ->asArray()
            ->one();
        if (empty($user))
        {
            echo json_encode([]);
            exit;
        }
        echo json_encode($user);
        exit;
    }
}