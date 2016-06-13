<?php

namespace frontend\modules\api\controllers;

use common\api\VsoApi;
use frontend\modules\talent\models\VsoUser;
use yii;
use yii\web\Controller;

class UserController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * 手机号是否已经注册
     * 已注册，用户入驻
     * 未注册，注册新用户，用户入驻
     * @param $mobile
     */
    public function actionIsMobileRegisted()
    {
        $mobile = yii::$app->request->get('mobile');
        $result = VsoUser::isUserRegisted($mobile);
        echo json_encode($result);
    }

    /**
     * 手机号是否可用，用于注册校验
     */
    public function actionIsAvailableMobile()
    {
        $mobile = yii::$app->request->get('mobile');
        if (empty($mobile))
        {
            echo json_encode(['result' => false, 'message' => '缺少手机号']);
            exit;
        }
        if (!preg_match("/^1[34578][0-9]{9}$/", $mobile))
        {
            echo json_encode(['result' => false, 'message' => '手机号不合法']);
            exit;
        }
        $url = "http://api.vsochina.com/user/auth/is-available-mobile";
        $data = [
            'mobile' => $mobile,
            'username' => yii::$app->request->get('username')
        ];
        $result = VsoApi::send($url, $data, 'get');
        // 手机号可用
        if (isset($result['ret']) && $result['ret'] == 0)
        {
            echo json_encode(['result' => true, 'message' => $result['message']]);
        }
        // 不可用
        else
        {
            echo json_encode(['result' => false, 'message' => $result['message']]);
        }
        exit;
    }

    /**
     * 验证密码是否正确
     * 用户名+密码 or 手机号+密码
     */
    public function actionCheckPassword()
    {
        $password = yii::$app->request->post('password');
        if (empty($password))
        {
            echo json_encode(['result' => false, 'message' => '缺少密码']);
            exit;
        }
        $mobile = yii::$app->request->post('mobile');
        $username = yii::$app->request->post('username');
        if (empty($username))
        {
            $username = VsoUser::find()->select('username')->where(['mobile' => $mobile])->scalar();
        }

        $url = "http://api.vsochina.com/user/safe/check-password";
        $data = [
            'username' => $username,
            'password' => $password
        ];
        $result = VsoApi::send($url, $data);
        if (isset($result['ret']) && $result['ret'] == 14040)
        {
            echo json_encode(['result' => true, 'message' => $result['message']]);
        }
        else
        {
            echo json_encode(['result' => false, 'message' => $result['message']]);
        }
        exit;
    }
}