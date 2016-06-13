<?php
/**
 * Created by PhpStorm.
 * User: Huangbo
 * Date: 2016/05/09
 * Time: 17:00
 */
namespace frontend\modules\ucenter\controllers;

use yii;
use yii\web\Controller;
use frontend\controllers\UcenterController;
use frontend\modules\ucenter\models\SubdomainUser;
use frontend\modules\ucenter\models\SubdomainCheck;

class SubdomainController extends UcenterController
{
    public $layout = 'ucenter_setting';//用户中心-个人主页
    public $enableCsrfValidation = false;

    //暂时屏蔽掉二级域名功能
//    public function init() {
//        exit;
//    }

    /**
     * 用户中心二级域名页
     * @return HTML
     */
    public function actionApply()
    {
        $mdl = new SubdomainUser();
        $mdl_ch = new SubdomainCheck();
        //判断有无二级域名
        $subdomain = $mdl->_get_info([
            'username' => $this->_user['username']
        ]);
        //获取审核记录详情
        $_check_info = $mdl_ch->_get_check_info($this->_user['username']);
        $_data = [
            'subdomain' => $subdomain,
            'check' => $_check_info ? $_check_info['check'] : [],
            '_check_info' => $_check_info,
        ];
        return $this->render('apply', $_data);
    }

    /**
     * 异步添加二级域名审核信息
     * @return json
     */
    public function actionAjaxAddCheck(){
        if(empty($this->_user)){
            $_data = [
                'code' => -10001,
                'msg' => '请先登录'
            ];
            $this->_return_json($_data);
        }
        $subdomain = trim(Yii::$app->request->post('subdomain', ''));
        $mdl_us = new SubdomainUser();
        $mdl_ch = new SubdomainCheck();

        //判断是否有待审核记录
        $check = $mdl_ch->_get_info([
            'username' => $this->_user['username'],
            'check_status' => $mdl_ch::CHECK_WAIT,
        ]);
        if($check){
            $_data = [
                'code' => -10002,
                'msg' => "您已经提交了域名{$check['subdomain']}.vsochina.com的申请，不能重复提交，请耐心等待审核结果！"
            ];
            $this->_return_json($_data);
        }

        //校验二级域名
        $mdl_us->subdomain = $subdomain;
        $mdl_us->username = $this->_user['username'];
        //验证
        if(!$mdl_us->validate()){
            $error = $mdl_us->errors;
            $msg = current($error)[0];
            $_data = [
                'code' => -10009,
                'msg' => $msg
            ];
            $this->_return_json($_data);
        }
        //保存审核记录
        $res = $mdl_ch->_save([
            'subdomain' => $subdomain,
            'username' => $this->_user['username'],
            'check_status' => $mdl_ch::CHECK_WAIT,
        ]);
        if(!$res){
            $_data = [
                'code' => -10003,
                'msg' => '提交审核失败！'
            ];
            $this->_return_json($_data);
        }

        $_data = [
            'code' => 10002,
            'msg' => '您的域名申请已经提交审核！'
        ];
        $this->_return_json($_data);
    }

    /**
     * 异步校验二级域名是否合法
     * @return json
     */
    public function actionAjaxCheckDomain(){
        if(empty($this->_user)){
            $_data = [
                'code' => -10001,
                'msg' => '请先登录'
            ];
            $this->_return_json($_data);
        }
        $mdl = new SubdomainUser();
        $mdl->subdomain = trim(Yii::$app->request->post('subdomain', ''));
        if(!$mdl->validate(['subdomain'])){
            $_data = [
                'code' => -10009,
                'msg' => $mdl->errors['subdomain'][0]
            ];
            $this->_return_json($_data);
        }

        $_data = [
            'code' => 10009,
            'msg' => '域名校验成功！'
        ];
        $this->_return_json($_data);
    }

}