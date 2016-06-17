<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\api\VsoApi;
use common\models\User;
use common\models\Goods;


class HomeController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;

    /**
     * 用户列表
     * @return type
     */
    public function actionIndex()
    {
        $uid = $this->_request('uid', 2);
        $u_mdl = new User();
        $g_mdl = new Goods();

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
        $_goods_list = $g_mdl->_get_list(['>' , 'gid', 0], 'gid DESC', 1, 20);
        $_data = [
            'user' => $user,
            'goods_list' => $_goods_list,
        ];
        return $this->render('index', $_data);
    }

    /**
     * 用户列表
     * @return type
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 关于我们
     * @return type
     */
    public function actionAbout()
    {
        return $this->render('about');
    }





}
