<?php

namespace frontend\modules\api\controllers;

use yii;
use yii\web\Controller;
use common\api\VsoApi;

class DefaultController extends Controller
{
    public $enableCsrfValidation = false;
    //发送手机验证码
    public function actionSendMobileMessage()
    {
        $data = yii::$app->request->post('data');
        $url = 'http://api.vsochina.com/message/mobile/send-mobile-message';
        $res = VsoApi::send($url, $data, "post");
        echo json_encode($res);
    }

    //验证手机验证码
    public function actionCheckValidCodeByMobile()
    {
        $data = yii::$app->request->post('data');
        $url = 'http://api.vsochina.com/message/mobile/check-valid-code-by-mobile';
        $res = VsoApi::send($url, $data, "post");
        echo json_encode($res);
    }
}