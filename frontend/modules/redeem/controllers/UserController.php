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
        $mobile = $this->_request('mobile');
        $verifycode = intval($this->_request('verifycode'));
        //验证手机格式
        $pattern = '/^1[3|5|7|8][0-9]{9}$/';
        if(!preg_match($pattern, $mobile)){
            $this->_json(-20001, '手机号格式不正确');
        }
        lg($mobile);
        //验证验证码
        $verifycode = 1;
        if(0){
            $this->_json(-20002, '验证码不正确');
        }
        //验证手机号和openid是否合法
        $user = new User();
        $user->mobile = $mobile;
        $user->wechat_openid = $opend_id;
        if(!$user->validate()){
            $error = $user->errors;
            $msg = current($error)[0];//获取错误信息
            return ['code' =>  -20003, 'msg' => $msg];
        }
        if(!$user->save()){
            return ['code' =>  -20004, 'msg' => '保存失败'];
        }

        return ['code' =>  20000, 'msg' => '保存成功'];

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
