<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\User;
use common\models\Order;
use common\models\PointsRecord;
use common\models\Address;


class MyController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;

    /**
     * 个人中心
     * @return type
     */
    public function actionIndex()
    {

        $_data = [
            'user' => $this->user
        ];
        return $this->render('index', $_data);
    }


    /**
     * 我的地址
     * @return type
     */
    public function actionAddress()
    {

        $a_mdl = new Address();
        $list = $a_mdl->_get_list(['uid' => $this->uid, 'is_deleted' => $a_mdl::NO_DELETE]);
        if(!empty($list)){
            foreach($list as $key => $val){
                $list[$key]['type_name'] = $a_mdl::_get_address_type_name($val['type']);
            }
        }
        $_data = [
            'list' => $list,
            'uid' => $this->uid,
        ];
        return $this->render('address', $_data);
    }

    /**
     * 我的积分
     * @return type
     */
    public function actionPoints()
    {
        $pr_mdl = new PointsRecord();
        $record_list = $pr_mdl->_get_list(['>', 'id', 0], 'id DESC');
        $_data = [
            'user' => $this->user,
            'record_list' => $record_list
        ];
        return $this->render('points', $_data);
    }

    /**
     * 我的订单
     * @return type
     */
    public function actionOrder()
    {
        $r_mdl = new Order();
        $_order_list = $r_mdl->_get_list();
        $_status_list = $r_mdl::_get_status_list();
        $_data = [
            'order_list' => $_order_list,
            'status_list' => $_status_list,
        ];
        return $this->render('order', $_data);
    }

    /**
     * 异步加载订单
     * @return type
     */
    public function actionAjaxLoadOrder()
    {
        $mdl = new Order();
        $type = trim($this->_request('order_status'));
        lg($this->_request());
        if($type == 'topay'){
            $where = ['order_status' => $mdl::STATUS_PAY];
        }else if($type == 'payed'){
            $where = ['in', 'order_status', [
                $mdl::STATUS_COMMENT,
                $mdl::STATUS_DONE,
                $mdl::STATUS_RECEIVE,
                $mdl::STATUS_SEND,
            ]];
        }else{
            $where = [];
        }
        $_order_list = $mdl->_get_list($where);
        $_status_list = $mdl::_get_status_list();
        foreach($_order_list as $key => $val){
            $_order_list[$key]['time'] = date('Y/m/d', $val['create_at']);
            $_order_list[$key]['status_name'] = getValue($_status_list, [$val['order_status']], '');
        }
        $_data = [
            'order_list' => $_order_list,
        ];
        $this->_json(20000, '获取成功', $_data);
    }


}
