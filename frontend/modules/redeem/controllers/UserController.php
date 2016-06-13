<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\api\VsoApi;
use common\models\User;
use common\models\Auth;


class UserController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;


    /**
     * 用户注册
     * @return type
     */
    public function actionRegister()
    {
        return $this->render('register');
    }

    /**
     * 用户登录
     * @return type
     */
    public function actionLogin()
    {
        return $this->render('login');
    }


    /**
     * 用户认证
     * @return type
     */
    public function actionAuth()
    {
        return $this->render('auth');
    }









}
