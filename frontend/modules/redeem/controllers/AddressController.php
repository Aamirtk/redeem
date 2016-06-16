<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\api\VsoApi;
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
        return $this->render('add');
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
