<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\api\VsoApi;
use common\models\User;
use common\models\Auth;


class MyController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;


    /**
     * 我的订单
     * @return type
     */
    public function actionOrder()
    {
        return $this->render('order');
    }

    /**
     * 我的地址
     * @return type
     */
    public function actionAddress()
    {
        return $this->render('address');
    }

    /**
     * 我的积分
     * @return type
     */
    public function actionPoints()
    {
        return $this->render('points');
    }



}
