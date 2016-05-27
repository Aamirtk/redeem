<?php

namespace backend\modules\opportunity\controllers;

use yii;
use yii\web\Controller;
use yii\helpers\Json;


use backend\modules\opportunity\services\PushService;

class PushController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionPushTask()
    {
        $result = ['code' => 0];
        if (yii::$app->request->isPost)
        {
            yii::$app->amqp->send('push_opportunity_exchange', 'push_opportunity_routing', yii::$app->request->post(), 'direct');
            $result['code'] = 0;
            $result['msg'] = 'success';
        }
        else
        {
            $result['code'] = 1;
            $result['msg'] = 'fail';
        }
        echo Json::encode($result);
        exit;
    }


    public function actionTestPushTask()
    {
        $model = new PushService();

        $message['task_id'] = 321;
        $message['task_wid'] = 57665767657;
        $message['task_title'] = 'test_tile';
        $message['task_desc'] = 'test_desc';
        $message['task_cash'] = 320;

        $model->handlePushOpportunityData($message);
    }
}