<?php

namespace backend\modules\user\controllers;

use Yii;
use app\base\CommonWebController;
use common\api\VsoApi;

class UserController extends CommonWebController
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
        $search = $this->getHttpParam('search', false, null);
        $page = $this->getHttpParam('page', false, 0);
        $pageSize = $this->getHttpParam('pageSize', false, 10);
        $offset = $page * $pageSize;
        $res = VsoApi::send(yii::$app->params['usersearchapi'], ['search' => $search, 'offset' => $offset, 'pageSize' => $pageSize], "post");
        $this->printSuccess($res);
    }


}
