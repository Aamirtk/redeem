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
    public function actionReg()
    {
        $opend_id = $this->_get_openid();
        //加载
        if(!$this->isAjax()){
            return $this->render('reg', ['open_id' => $opend_id]);
        }
        //保存
        $mobile = trim($this->_request('mobile'));
        $verifycode = intval($this->_request('verifycode'));

        //验证验证码
        $verifycode = 1;
        if(0){
            $this->_json(-20002, '验证码不正确');
        }

        $param = [
            'mobile' => $mobile,
            'wechat_openid' => $opend_id,
        ];
        $res = (new User())->_add_user($param);

        $this->_json($res['code'], $res['msg']);
    }

    /**
     * 用户注册
     * @return type
     */
    public function actionAjaxSaveReg()
    {
        $opend_id = $this->open_id;
        $_data = [
            'open_id' => $opend_id
        ];
        return $this->render('reg');
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
