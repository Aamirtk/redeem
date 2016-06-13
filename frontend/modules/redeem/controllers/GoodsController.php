<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\api\VsoApi;
use common\models\User;
use common\models\Auth;


class GoodsController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;


    /**
     * 商品列表
     * @return type
     */
    public function actionList()
    {
        return $this->render('index');
    }

    /**
     * 商品介绍
     * @return type
     */
    public function actionView()
    {
        return $this->render('view');
    }

    /**
     * 商品图文详情
     * @return type
     */
    public function actionDetail()
    {
        return $this->render('detail');
    }


}
