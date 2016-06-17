<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\User;
use common\models\Points;
use common\models\PointsRecord;
use common\models\Address;


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

        $_data = [
            'user' => $this->user
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

        $a_mdl = new Address();
        $list = $a_mdl->_get_list(['uid' => $this->uid, 'is_deleted' => $a_mdl::NO_DELETE]);
        if(!empty($list)){
            foreach($list as $key => $val){
                $list[$key]['type_name'] = $a_mdl::_get_address_type_name($val['type']);
            }
        }
        $_data = [
            'list' => $list,
            'uid' => $this->uid,
        ];
        return $this->render('address', $_data);
    }

    /**
     * 我的积分
     * @return type
     */
    public function actionPoints()
    {
        $pr_mdl = new PointsRecord();
        $record_list = $pr_mdl->_get_list(['>', 'id', 0], 'id DESC');
        $_data = [
            'user' => $this->user,
            'record_list' => $record_list
        ];
        return $this->render('points', $_data);
    }



}
