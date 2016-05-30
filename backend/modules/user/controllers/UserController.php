<?php

namespace backend\modules\user\controllers;

use Yii;
use app\base\BaseController;
use common\api\VsoApi;

class UserController extends BaseController
{

    public $layout = 'layout';

    /**
     * 路由权限控制
     * @return array
     */
    public function limitActions()
    {
        return ['list', 'list-view', 'export'];
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
     * 用户数据
     */
    public function actionList()
    {

    }


}
