<?php

namespace backend\modules\order\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\Order;
use app\modules\team\models\Team;

class OrderController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;
    public $checker_id = '';

    /**
     * 放置需要初始化的信息
     */
    public function init()
    {
        //后台登录人员ID
        $this->checker_id = Yii::$app->user->identity->uid;
    }

    /**
     * 路由权限控制
     * @return array
     */
    public function limitActions()
    {
        return [
            'list',
            'list-view',
            'add',
            'info',
            'save',
            'update',
            'ajax-save',
            'ajax-change-status',
        ];
    }

    /**
     * 商品列表
     * @return type
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 商品数据
     */
    public function actionList()
    {
        if ($this->isGet()) {
            return $this->render('list');
        }
        $mdl = new Order();
        $query = $mdl::find();
        $search = $this->_request('search');
        $page = $this->_request('page', 0);
        $pageSize = $this->_request('pageSize', 10);
        $offset = $page * $pageSize;
        $memTb = $mdl::tableName();
        $teamTb = Team::tableName();
        if ($search) {
            if (isset($search['uptimeStart'])) //时间范围
            {
                $query = $query->andWhere(['>', $memTb . '.created_at', strtotime($search['uptimeStart'])]);
            }
            if (isset($search['uptimeEnd'])) //时间范围
            {
                $query = $query->andWhere(['<', $memTb . '.created_at', strtotime($search['uptimeEnd'])]);
            }
            if (isset($search['grouptype'])) //时间范围
            {
                $query = $query->andWhere(['group_id' => $search['grouptype']]);
            }
            if (isset($search['filtertype']) && !empty($search['filtercontent'])) {
                if ($search['filtertype'] == 2)//按照商品名称筛选
                {
                    $query = $query->andWhere(['like', $memTb . '.name', trim($search['filtercontent'])]);
                } elseif ($search['filtertype'] == 1)//按照商品ID筛选
                {
                    $query = $query->andWhere([$memTb . '.username' => trim($search['filtercontent'])]);
                }
            }
            if (isset($search['inputer']) && !empty($search['inputer'])) {
                $query = $query->andWhere(['like', $teamTb . '.nickname', trim($search['filtercontent'])]);
            }
            if (isset($search['inputercompany'])) //筛选条件
            {
                $query = $query->andWhere([$teamTb . '.company_id' => $search['inputercompany']]);
            }
            if (isset($search['checkstatus'])) //筛选条件
            {
                $query->andWhere([$memTb . '.check_status' => $search['checkstatus']]);
            }
        }
        //只能是上架，或者下架的产品
        $query->andWhere(['in', 'order_status', [$mdl::STATUS_UPSHELF, $mdl::STATUS_OFFSHELF]]);
        $_order_by = 'gid DESC';
        $query_count = clone($query);
        $userArr = $query
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $count = $query_count->count();
        $orderList = ArrayHelper::toArray($userArr, [
            'common\models\Order' => [
                'gid',
                'order_id',
                'name',
                'thumb',
                'description',
                'redeem_pionts',
                'order_status',
                'status_name' => function ($m) {
                    return Order::_get_order_status($m->order_status);
                },
                'inputer' => function ($m) {
                    return '录入人';
                },
                'checker' => function ($m) {
                    return '审核人';
                },
                'create_at' => function ($m) {
                    return date('Y-m-d h:i:s', $m->create_at);
                },
            ],
        ]);
        $_data = [
            'orderList' => $orderList,
            'totalCount' => $count
        ];
        exit(json_encode($_data));
    }

    /**
     * 添加商品
     * @return array
     */
    function actionAdd()
    {
        if(!$this->isAjax()){
            return $this->render('add');
        }
        $order = $this->_request('order', []);
        if(isset($order['gid'])){
            unset($order['gid']);
        }
        $mdl = new Order();
        $res = $mdl->_save_order($order);
        $this->_json($res['code'], $res['msg']);
    }

    /**
     * 添加商品
     * @return array
     */
    function actionUpdate()
    {
        $gid = intval($this->_request('gid'));
        $order_info = $this->_request('order', []);

        $mdl = new Order();
        //检验参数是否合法
        if (empty($gid)) {
            $this->_json(-20001, '商品序号gid不能为空');
        }

        //检验商品是否存在
        $order = $mdl->_get_info(['gid' => $gid]);
        if (!$order) {
            $this->_json(-20002, '商品信息不存在');
        }

        //加载
        if(!$this->isAjax()){
            $_data = [
                'order' => $order
            ];
            return $this->render('update', $_data);
        }

        //保存
        $order_info['gid'] = $gid;
        $res = $mdl->_save_order($order_info);
        $this->_json($res['code'], $res['msg']);
    }

    /**
     * 改变商品状态
     * @return array
     */
    function actionAjaxChangeStatus()
    {
        $gid = intval($this->_request('gid'));
        $order_status = $this->_request('order_status');

        $mdl = new Order();
        //检验参数是否合法
        if (empty($gid)) {
            $this->_json(-20001, '商品序号gid不能为空');
        }
        if(!in_array($order_status, [$mdl::STATUS_OFFSHELF, $mdl::STATUS_UPSHELF, $mdl::STATUS_DELETE])){
            $this->_json(-20002, '商品状态不正确');
        }

        //检验商品是否存在
        $order = $mdl->_get_info(['gid' => $gid]);
        if (!$order) {
            $this->_json(-20003, '商品信息不存在');
        }

        $res = $mdl->_save([
            'gid' => $gid,
            'order_status' => $order_status,
        ]);
        if(!$res){
            $this->_json(-20003, '商品状态修改失败');
        }
        $this->_json(20000, '保存成功');
    }


}
