<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\User;
use common\models\Points;
use common\models\PointsRecord;


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
        $uid = $this->_request('uid');
        $u_mdl = new User();

        //判断用户是否手机认证
        if(empty($uid)){
            $this->redirect('/redeem/user/reg');
            exit();
        }
        $user = $u_mdl->_get_info(['uid' => $uid]);
        if(empty($user)){
            $this->redirect('/redeem/user/reg');
            exit();
        }
        $_data = [
            'user' => $user
        ];
        return $this->render('index', $_data);
    }

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
        $uid = $this->_request('uid');
        $u_mdl = new User();
        //判断用户是否手机认证
        if(empty($uid)){
            $this->redirect('/redeem/user/reg');
            exit();
        }
        $user = $u_mdl->_get_info(['uid' => $uid]);
        if(empty($user)){
            $this->redirect('/redeem/user/reg');
            exit();
        }

        $pr_mdl = new PointsRecord();
        $record_list = $pr_mdl->_get_list(['>', 'id', 0], 'id DESC');
        $_data = [
            'user' => $user,
            'record_list' => $record_list
        ];
        return $this->render('points', $_data);
    }



}
