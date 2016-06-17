<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\User;
use common\models\Goods;
use common\models\CartGoods;


class CartController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;


    /**
     * 生成订单
     * @return type
     */
    public function actionList()
    {
        return $this->render('list');
    }

    /**
     * 兑换
     * @return type
     */
    public function actionPay()
    {
        return $this->render('pay');
    }

    /**
     * 添加商品
     * @return type
     */
    public function actionAddGoods()
    {
        $gid = intval($this->_request('gid'));
        $count = intval($this->_request('num'));

        $cg_mdl = new CartGoods();
        //参数校验
        $res = $cg_mdl->_add_goods(['gid' => $gid, 'count' => $count]);
        $_list = $cg_mdl->_get_list_all();
        $_data = [
            'cart_goods' => $_list
        ];
        return $this->render('list', $_data);
    }








}
