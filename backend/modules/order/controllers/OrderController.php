<?php

namespace backend\modules\order\controllers;

use frontend\modules\personal\models\Goods;
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
            'ajax-delete',
            'ajax-change-status',
        ];
    }

    /**
     * 订单列表
     * @return type
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 订单数据
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
        if ($search) {
            if (isset($search['uptimeStart'])) //时间范围
            {
                $query = $query->andWhere(['>', 'update_at', strtotime($search['uptimeStart'])]);
            }
            if (isset($search['uptimeEnd'])) //时间范围
            {
                $query = $query->andWhere(['<', 'update_at', strtotime($search['uptimeEnd'])]);
            }
            if (isset($search['goods_id'])) //商品编号
            {
                $query = $query->andWhere(['goods_id' => $search['goods_id']]);
            }
            if (isset($search['order_status'])) //订单状态
            {
                $query = $query->andWhere(['order_status' => $search['order_status']]);
            }
            if (isset($search['goods_name'])) //商品名称
            {
                $query = $query->andWhere(['like', 'goods_name', $search['goods_name']]);
            }
            if (isset($search['buyer_name'])) //购买者名称
            {
                $query = $query->andWhere(['like', 'buyer_name', $search['buyer_name']]);
            }
            if (isset($search['buyer_phone'])) //购买者手机
            {
                $query = $query->andWhere(['buyer_phone' => $search['buyer_phone']]);
            }
        }

        //只能是上架，或者下架的产品
        $query->andWhere(['is_deleted' => $mdl::NO_DELETE]);
        $_order_by = 'oid DESC';
        $query_count = clone($query);
        $orderArr = $query
            ->with('address')
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $count = $query_count->count();
        $orderList = ArrayHelper::toArray($orderArr, [
            'common\models\Order' => [
                'oid',
                'gid',
                'goods_id',
                'goods_name',
                'buyer_phone',
                'buyer_name',
                'order_status',
                'status_name' => function ($m) {
                    return Order::_get_order_status($m->order_status);
                },
                'address' => function ($m) {
                    return _value($m['address']['detail']);
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
     * 添加订单
     * @return array
     */
    function actionAdd()
    {
        if(!$this->isAjax()){
            return $this->render('add');
        }
        $order = $this->_request('order', []);
        if(isset($order['oid'])){
            unset($order['oid']);
        }
        $mdl = new Order();
        $res = $mdl->_save_order($order);
        $this->_json($res['code'], $res['msg']);
    }

    /**
     * 添加订单
     * @return array
     */
    function actionUpdate()
    {
        $oid = intval($this->_request('oid'));
        $mdl = new Order();
        //检验参数是否合法
        if (empty($oid)) {
            $this->_json(-20001, '订单序号oid不能为空');
        }

        //检验订单是否存在
        $order = $mdl->_get_info(['oid' => $oid]);
        if (!$order) {
            $this->_json(-20002, '订单信息不存在');
        }
        $_data = [
            'order' => $order,
            'status_list' => $mdl::_get_status_list(),
        ];
        return $this->render('update', $_data);
    }

    /**
     * 改变订单状态
     * @return array
     */
    function actionAjaxSave()
    {
        $oid = intval($this->_request('oid'));
        $order_info = $this->_request('order', []);

        $mdl = new Order();
        //检验参数是否合法
        if (empty($oid)) {
            $this->_json(-20001, '订单序号oid不能为空');
        }
        if(empty($order_info['order_status'])){
            $this->_json(-20002, '订单状态不能为空');
        }

        //检验订单是否存在
        $order = $mdl->_get_info(['oid' => $oid]);
        if (!$order) {
            $this->_json(-20002, '订单信息不存在');
        }
        $res = $mdl->_save([
            'oid' => $oid,
            'order_status' => intval($order_info['order_status']),
        ]);
        if(!$res){
            $this->_json(-20003, '保存失败');
        }

        //保存
        $this->_json(20000, '保存成功');
    }

    /**
     * 改变订单状态
     * @return array
     */
    function actionAjaxDelete()
    {
        $oid = intval($this->_request('oid'));

        $mdl = new Order();
        //检验参数是否合法
        if (empty($oid)) {
            $this->_json(-20001, '订单序号oid不能为空');
        }

        //检验订单是否存在
        $order = $mdl->_get_info(['oid' => $oid]);
        if (!$order) {
            $this->_json(-20002, '订单信息不存在');
        }

        $res = $mdl->_save([
            'oid' => $oid,
            'is_deleted' => $mdl::IS_DELETE,
        ]);
        if(!$res){
            $this->_json(-20003, '删除失败');
        }
        $this->_json(20000, '删除成功');
    }


}
