<?php

namespace frontend\modules\api\controllers;

use common\api\VsoApi;
use frontend\modules\talent\models\VsoUser;
use yii;
use yii\web\Controller;

class ProjectController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * 创建百万大赛项目
     * 原有项目不在在线创作的项目表中
     */
    public function actionMillionCreate()
    {
        $mobile = yii::$app->request->post('mobile');
        if (empty($mobile))
        {
            echo json_encode(['result' => false, 'message' => '缺少手机号']);
            exit;
        }
        $username = yii::$app->request->post('username');
        if (empty($username))
        {
            $username = VsoUser::find()->select('username')->where(['mobile' => $mobile])->scalar();
        }
        $proj_name = yii::$app->request->post('proj_name');
        if (empty($proj_name))
        {
            echo json_encode(['result' => false, 'message' => '缺少项目名称']);
            exit;
        }
        $proj_desc = yii::$app->request->post('proj_desc');
        if (empty($proj_desc))
        {
            echo json_encode(['result' => false, 'message' => '缺少项目简介']);
            exit;
        }
        $team_desc = yii::$app->request->post('team_desc');
        if (empty($team_desc))
        {
            echo json_encode(['result' => false, 'message' => '缺少成员介绍']);
            exit;
        }
        $img_arr = yii::$app->request->post('img_arr');
        if (empty($img_arr))
        {
            echo json_encode(['result' => false, 'message' => '请上传项目图片']);
            exit;
        }
        $proj_banner = yii::$app->request->post('proj_banner');
        $proj_thumb = yii::$app->request->post('proj_thumb');

        $url = "http://api.vsochina.com/cz/million/create";
        $data = [
            'mobile' => $mobile,
            'username' => $username,
            'proj_name' => $proj_name,
            'proj_desc' => $proj_desc,
            'team_desc' => $team_desc,
            'img_arr' => $img_arr,
            'proj_banner' => $proj_banner,
            'proj_thumb' => $proj_thumb,
            'settle_type' => 1
        ];
        $result = VsoApi::send($url, $data);
        if (isset($result['ret']) && $result['ret'] == 20001)
        {
            echo json_encode(['result' => true, 'message' => $result['msg']]);
        }
        // 不可用
        else
        {
            echo json_encode(['result' => false, 'message' => $result['msg']]);
        }
        exit;
    }
}