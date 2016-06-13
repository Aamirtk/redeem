<?php
namespace frontend\modules\personal\controllers;

use common\api\VsoApi;
use frontend\controllers\CommonController;
use yii;

class RecordController extends CommonController
{
    public $enableCsrfValidation=false;
    public $layout = 'default';
    public $obj_username = "";  // 被访问用户的用户名
    public $vso_uname = '';          // 当前登录用户
    public $is_self = false;    // 被访问用户是否是当前登录用户
    public $user_info=array();  // 被访问用户信息

    /**
     * 交易记录
     * @param $username 被访问者用户名
     * @param string $type（1=>来自雇员，2=>来自雇主）
     * @param string $mark_status（1=>好评，2=>中评，3=>差评）
     * @return string|yii\web\Response
     */
    public function actionView()
    {
        $username=$this->obj_username;
        if (empty($username))
        {
            return $this->redirect(yii::$app->defaultRoute);
        }
        //获取交易评价概况
        $url = yii::$app->params['record_general_evaluation'];
        $general_evaluation = VsoApi::send($url, ['username' => $username], "get");
        $eval = isset($general_evaluation['data']) ? $general_evaluation['data'] : null;
        $data = [
            'eval' => $eval
        ];
        return $this->render('view', $data);
    }
}