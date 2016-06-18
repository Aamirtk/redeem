<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\api\VsoApi;
use common\lib\Filter;
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
        $g_mdl = new Goods();

        $_goods_list = $g_mdl->_get_list(['goods_status' => $g_mdl::STATUS_UPSHELF], 'gid DESC', 1, 20);
        $_data = [
            'user' => $this->user,
            'goods_list' => $_goods_list,
        ];
        return $this->render('index', $_data);
    }

    /**
     * 索索
     * @return type
     */
    public function actionSearch()
    {
        $keywords = urldecode($this->_request('keywords'));
        if(empty($keywords)) {
            $this->_json(-20001, '关键词不能为空');
        }

        $g_mdl = new Goods();
        $param = [
            'sql' => "`goods_status` = :goods_status AND `name` like '%{$keywords}%'",
            'params' => [':goods_status' => $g_mdl::STATUS_UPSHELF]
        ];
        $_goods_list = $g_mdl->_get_list($param,'gid DESC', 1, 30);

        $_data = [
            'goods' => $_goods_list,
        ];
        $this->_json(20000, '成功', $_data);
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
