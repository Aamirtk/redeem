<?php

namespace frontend\modules\personal\controllers;

use common\utils\LHTCurl;
use frontend\controllers\CommonController;
use yii;
use common\api\VsoApi;

class TemplateController extends CommonController
{
    /**
     * 用户首页
     * username
     * */
    public function actionIndex($username)
    {
        $url = yii::$app->params['user_detail'];
        $data['username'] = $username;
        $rst = VsoApi::send($url, $data, "get");

        var_dump($rst);

        //用户模板 默认值 应该从数据库中都，若不存在则使用默认值
        $type = yii::$app->params['user_template_default'];

        //$type = 'test';

        $pageRender = $type . '/index';
        return $this->render("default/change");
    }

    /**
     * 用户交易记录
     * username
     * */
    public function actionRecord($username)
    {

        $url = yii::$app->params['record_general_evaluation'];
        $data['username'] = $username;
        if ((isset($username) && empty($username)) || !isset($username))
        {
            //return $this->printError([],10001);
        }

        //获取交易评价概况
        $general_evaluuation = VsoApi::send($url, $data, "get");
        var_dump($general_evaluuation);

        $rst['username'] = $username;
        $rst['gen_eval'] = $username;


        $type = "default"; //从数据库中抓
        $pageRender = $type . '/record';

        return $this->render($pageRender, $rst);
    }

    /**
     * 用户交易历史
     * username
     * */
    public function actionHistory($username)
    {
        $type = "default"; //从数据库中抓
        $pageRender = $type . '/history';

        $rst['username'] = $username;
        return $this->render($pageRender, $rst);
    }

    /**
     * 关注
     * */
    public function actionFocus()
    {

    }

    /**
     * 局部加载切换模板
     * type 模板标记号
     * */
    public function actionChangeTemplate()
    {
        $type = yii::$app->request->get('type');

        $pageRender = $type . '/example';

        return $this->_echoJson(['ret' => 200, 'html' => $this->renderAjax($pageRender)]);
    }
}
