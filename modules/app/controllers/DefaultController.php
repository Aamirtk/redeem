<?php

namespace frontend\modules\app\controllers;

use common\api\VsoApi;
use yii\web\Controller;

class DefaultController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 推荐应用
     */
    public function actionRecomList()
    {
        // 推荐应用
        $url = "http://api.vsochina.com/app/app/list";
        $data = [
            'isindex' => 1,
            'limit' => 6
        ];
        $result = VsoApi::send($url, $data);
        $recom_apps = isset($result['data']) && !empty($result['data']) ? $result['data'] : [];
        echo json_encode($recom_apps);
        exit;
    }
}
