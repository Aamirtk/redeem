<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\User;
use common\models\Auth;
use common\models\VerifyCode;
use common\lib\Sms;
use common\lib\Wechat;
use common\utils\WechatApp;
use common\utils\WechatAuth;


class UserController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;
//    private $_appId = 'wx4a7032faa3c317cb';
//    private $_appSecret = '38bf39dc2782fc66e98e829101464d17';
//    private $_token = 're123de456m';
//    private $_encodingAesKey = 'dDzF33LN5z5K0FHHfb4AgcbhssEMM6EMhGNr3oENVx9';

    private $_appId = 'wxd67d44974fa6111c';
    private $_appSecret = 'f4793ce52883b15c9da1a11054929bc4';
    private $_token = 're123de456m';
    private $_encodingAesKey = 'je3CZxBIjjPhTpeAUubOXCG6aVqMnygAdwmX6NCyGa0';



    public function init(){
        $this->_uncheck = [
            'reg',
            'send-sms',
            'wechat',
        ];
    }

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

        $param = [
            'mobile' => $mobile,
            'verifycode' => $verifycode,
            'wechat_openid' => $opend_id,
        ];
        $res = (new User())->_add_user($param);
        if($res['code'] < 0 ){
            $this->_json($res['code'], $res['msg']);
        }
        $this->_json($res['code'], $res['msg'], $res['data']);
    }

    /**
     * 退出登录
     * @return type
     */
    public function actionLogout()
    {
        $session = Yii::$app->session;
        $session->remove('user_id');
        $this->redirect('/redeem/user/reg');
    }

    /**
     * 发送验证码
     * @return type
     */
    public function actionSendSms()
    {
        $mobile = trim($this->_request('mobile'));
        $sms = new Sms();
        $randnum = $sms->randnum();
        $res = $sms->send($mobile, $randnum);
        if($res != 0){
            $this->_json(-20001, '验证码发送失败，请重新发送');
        }
        $ret = (new VerifyCode())->_save_code($mobile, $randnum);
        if(!$ret){
            $this->_json(-20002, '验证码保存失败');
        }
        $this->_json(20000, '发送成功');
    }

    /**
     * 用户认证
     * @return type
     */
    public function actionAuth()
    {

        $opend_id = $this->_get_openid();
        //加载
        $uid = intval($this->_request('uid'));
        if(!$this->isAjax()){
            return $this->render('auth', ['uid' => $uid]);
        }

        //保存
        $name = trim($this->_request('name'));
        $email = trim($this->_request('email'));
        $mobile = trim($this->_request('mobile'));
        $param = [
            'uid' => $uid,
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'wechat_openid' => $opend_id,
        ];
        $res = (new Auth())->_add_auth($param);
        if($res['code'] < 0 ){
            $this->_json($res['code'], $res['msg']);
        }
        $this->_json($res['code'], $res['msg'], $res['data']);
    }

    /**
     * 用户列表
     * @return type
     */
    public function actionWechat()
    {
//        $options = [
//            'token' => $this->_token, //填写你设定的key
//            'appid' => $this->_appId,
//            'appsecret' => $this->_appSecret,
//            'encodingAesKey' => $this->_encodingAesKey,
//        ];
//        $wechat = new WechatApp();
//        $wechat = new Wechat();
//        $echostr = $this->_request('echostr');
//        if($wechat->checkSignature()){
//            return $echostr;
//        }else{
//            return false;
//        }

//        $wechat->valid();
//        $type = $wechat->getRev()->getRevType();
//        switch($type) {
//            case WechatApp::MSGTYPE_TEXT:
//                $wechat->text("hello, I'm 宝宝黄")->reply();
//                exit;
//                break;
//            case WechatApp::MSGTYPE_EVENT:
//                break;
//            case WechatApp::MSGTYPE_IMAGE:
//                break;
//            default:
//                $wechat->text("help info")->reply();
//        }

        $userauth = new WechatAuth();
        echo"<pre>";print_r($userauth->WeOuth());
//        var_dump(12212);





    }









}
