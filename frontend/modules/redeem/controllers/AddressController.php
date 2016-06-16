<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use app\base\BaseController;
use common\models\Address;
use common\models\User;
use common\models\Auth;
use common\models\City;

class AddressController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;
    private $uid;
    private $user;

    public function init(){
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
        $this->uid = $uid;
        $this->user = $user;
    }

    /**
     * 添加地址
     * @return type
     */
    public function actionAdd()
    {
        //加载
        if(!$this->isAjax()){
            return $this->render('add', ['uid' => $this->uid]);
        }
        //保存
        $param = $this->_request();
        $res = (new Address())->_add_address($param);
        if($res['code'] < 0 ){
            $this->_json($res['code'], $res['msg']);
        }
        $this->_json($res['code'], $res['msg'], $res['data']);
    }

    /**
     * 更改地址
     * @return type
     */
    public function actionUpdate()
    {
        $add_id = $this->_request('add_id');
        //加载
        if(!$this->isAjax()){
            $add = (new Address())->_get_info(['add_id' => $add_id]);
            //如果没有，跳回列表页
            if(!$add){
                $this->redirect('/redeem/my/address');
            }
            $_data = [
                'uid' => $this->uid,
                'add' => $add,
            ];
            return $this->render('update', $_data);
        }
        //保存
        $param = $this->_request();
        $res = (new Address())->_add_address($param);
        if($res['code'] < 0 ){
            $this->_json($res['code'], $res['msg']);
        }
        $this->_json($res['code'], $res['msg'], $res['data']);
    }



    /**
     * 异步获取城市列表
     * @return type
     */
    public function actionAjaxGetCities()
    {
        $city = intval($this->_request('cid'), 0);
        $_data = City::_get_cities($city);
        $this->_json(20000, '获取成功', $_data);
    }


}
