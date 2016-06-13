<?php

namespace frontend\modules\enterprise\controllers;

use frontend\controllers\CommonController;
use frontend\modules\enterprise\models\CrmCompany;
use frontend\modules\talent\models\User;
use yii;
use common\api\VsoApi;
use common\models_shop\shop;

class RecordController extends CommonController
{
    public $enableCsrfValidation = false;
    public $layout = "/main_ent"; //设置使用的布局文件
    public $company = null;
    public $has_shop = false;

    public function beforeAction($action)
    {
        $company = CrmCompany::getInfo(['username' => $this->obj_username, 'status' => CrmCompany::STATUS_NORMAL]);
        if(!$company['logo']){
            $company['logo'] = $this->getAvatar($this->obj_username);
        }
        // 被访问用户
        $this->company = $company;
        //判断是否开通店铺或者店铺
        $this->has_shop = shop::_get_user_has_shop($this->obj_username);
        return parent::beforeAction($action);
    }

    /**
     * 获取交易评价
     * username
     * */
    public function actionMark()
    {
        $username = $this->obj_username;
        $url = yii::$app->params['record_general_evaluation'];
        $data['username'] = $username;
        if ((isset($username) && empty($username)) || !isset($username))
        {
            //跳转错误页面
            //return $this->printError([],10001);
        }

        //若已设定不显示交易记录则跳转到企业主首页
        if(isset($this->company['record_is_show']) && $this->company['record_is_show'] == 0){
            return $this->redirect(['default/index', 'username' => $username]);
        }

        //获取交易评价概况
        $general_evaluuation = VsoApi::send($url, $data, "get");

        $rst['username'] = $username;
        $rst['gen_eval'] = isset($general_evaluuation) ? $general_evaluuation['data'] : null;

        return $this->render('index', $rst);
    }

    /**
     * 交易历史
     * */
    public function actionIndex()
    {
        $username = $this->obj_username;
        //若已设定不显示交易记录则跳转到企业主首页
        if(isset($this->company['record_is_show']) && $this->company['record_is_show'] == 0){
            return $this->redirect(['default/index', 'username' => $username]);
        }

        $rst['username'] = $username;
        return $this->render('history', $rst);
    }

    /**
     * 获取交易记录
     * username
     * type 1.中标 2.雇佣
     * */
    public function actionRecordHistory()
    {
        $pageSize = yii::$app->params['record_page_size'];

        $param = Yii::$app->request->get();
        if ((isset($param['username']) && empty($param['username'])) || !isset($param['username']))
        {
            return $this->printError([], 10001);
        }
        if ((isset($param['page']) && empty($param['page'])) || !isset($param['page']))
        {
            $param['offset'] = 0;
            $param['limit'] = $pageSize;
        }
        else
        {
            $param['offset'] = ($param['page'] - 1) * $pageSize;
            $param['limit'] = $pageSize;
        }

        $url = yii::$app->params['record'];
        $data['username'] = $param['username'];
        $data['type'] = $param['type'];
        $data['offset'] = $param['offset'];
        $data['limit'] = $param['limit'];
        $history = VsoApi::send($url, $data, "get");

        return $this->_echoJson($history);
    }

    /**
     * 获取交易评价
     * username
     * type 1.来自雇员 2.来自雇主
     * mark_status 1.好评 2.中评 3.差评
     * offset 偏移量
     * limit 数量
     * */
    public function actionGeneralList()
    {
        $pageSize = yii::$app->params['record_general_page_size'];

        $param = Yii::$app->request->get();

        if ((isset($param['username']) && empty($param['username'])) || !isset($param['username']))
        {
            return $this->printError([], 10001);
        }
        if ((isset($param['type']) && empty($param['type'])) || !isset($param['type']))
        {
            return $this->printError([], 10001);
        }
        if ((isset($param['mark_status']) && empty($param['mark_status'])) || !isset($param['mark_status']))
        {
            return $this->printError([], 10001);
        }
        if ((isset($param['page']) && empty($param['page'])) || !isset($param['page']))
        {
            $param['offset'] = 0;
            $param['limit'] = $pageSize;
        }
        else
        {
            $param['offset'] = ($param['page'] - 1) * $pageSize;
            $param['limit'] = $pageSize;
        }

        $url = yii::$app->params['record_general_list'];
        $data['username'] = $param['username'];
        $data['type'] = $param['type'];
        $data['mark_status'] = $param['mark_status'];
        $data['offset'] = $param['offset'];
        $data['limit'] = $param['limit'];
        $rst = VsoApi::send($url, $data, "get");
        return $this->_echoJson($rst);
    }
}
