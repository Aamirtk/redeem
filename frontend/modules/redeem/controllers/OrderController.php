<?php

namespace frontend\modules\redeem\controllers;

use common\models\CartGoods;
use Yii;
use app\base\BaseController;
use common\models\User;
use common\models\Auth;
use common\models\Address;


class OrderController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;


    /**
     * 生成订单
     * @return type
     */
    public function actionAdd()
    {
        $gids = json_decode($this->_request('gids'));
        if(empty($gids)){
            $this->_json(-20001, '没有选择购物车的任何商品');
        }

        $u_mdl = new User();
        $m_mdl = new Address();

        $cg_mdl = new CartGoods();
        $total_points = 0;
        $list = $cg_mdl->_get_list_all(['in' , 'id', $gids]);
        if($list){
            foreach($list as $val){
                $total_points += $val['count'] * getValue($val, 'goods.redeem_pionts', 0);
            }
        }

        //收货地址
        $address = $m_mdl->_get_info([
            'uid' => $this->uid,
            'is_default' => $m_mdl::DEFAULT_YES,
            'is_deleted' => $m_mdl::NO_DELETE
        ]);
        $address['type_name'] = $m_mdl::_get_address_type_name($address['type']);

        $_data = [
            'cart_goods' => $list,
            'total_points' => $total_points,
            'address' => $address,
        ];
        return $this->render('add', $_data);
    }

    /**
     * 生成订单
     * @return type
     */
    public function actionAjaxAdd()
    {
        $gids = json_decode($this->_request('gids'));
        if(empty($gids)){
            $this->_json(-20001, '没有选择购物车的任何商品');
        }

        $u_mdl = new User();

        $cg_mdl = new CartGoods();
        $total_points = 0;
        $list = $cg_mdl->_get_list_all(['in' , 'id', $gids]);
        if($list){
            foreach($list as $val){
                $total_points += $val['count'] * getValue($val, 'goods.redeem_pionts', 0);
            }
        }
        $cart_id = $u_mdl->_get_cart($this->uid);
        $cg_mdl = new CartGoods();
        $this->_json(20000, '保存成功');
    }

    /**
     * 兑换
     * @return type
     */
    public function actionDetail()
    {

        return $this->render('pay');
    }

    /**
     * 兑换
     * @return type
     */
    public function actionPay()
    {
        return $this->render('pay');
    }






}
