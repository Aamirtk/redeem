<?php

namespace frontend\modules\redeem\controllers;

use common\models\Address;
use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\User;
use common\models\Auth;
use common\models\City;

class AddressController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;


    /**
     * 生成订单
     * @return type
     */
    public function actionAdd()
    {
        $uid = $this->_request('uid');
        //加载
        if(!$this->isAjax()){
            return $this->render('add', ['uid' => $uid]);
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
