<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\api\VsoApi;
use common\models\User;
use common\models\Auth;


class CartController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;


    /**
     * 生成订单
     * @return type
     */
    public function actionAdd()
    {
        return $this->render('add');
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
