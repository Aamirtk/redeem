<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\User;
use common\models\Auth;
use common\models\Session;
use common\models\VerifyCode;
use common\lib\Sms;
use common\lib\WechatAuth;


class UserController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;

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

        //加载
        if(!$this->isAjax()){
            return $this->render('reg');
        }

        //保存
        $mobile = trim($this->_request('mobile'));
        $verifycode = intval($this->_request('verifycode'));

        $param = [
            'mobile' => $mobile,
            'verifycode' => $verifycode,
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

        $options = yiiParams('wechatConfig');
        $auth = new WechatAuth($options);

        $open_id = $auth->wxuser['open_id'];
        $nickname = $auth->wxuser['nickname'];
        $avatar = $auth->wxuser['avatar'];
        unset($auth);

        $user = (new User())->_get_info(['wechat_openid' => $open_id]);

        //从session中校验用户登录信息
        session_destroy();
        $session = Yii::$app->session;
        //有记录，表示已经注册，跳转到首页
        if($user){
            $session->set('uid', $user['id']);
            return $this->redirect('/redeem/home/index');
        }else{
            $session->set('wechat_openid', $open_id);
            $session->set('nick', $nickname);
            $session->set('avatar', $avatar);
            return $this->redirect('/redeem/user/reg');
        }

    }


}
