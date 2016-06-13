<?php
/**
 * Created by PhpStorm.
 * User: Qingwenjie
 * Date: 2015/11/2
 * Time: 15:49
 */
namespace frontend\modules\rc\controllers;

use Yii;
use yii\web\Controller;
use app\modules\rc\models;
use common\api\VsoApi;
use frontend\controllers\CommonController;
use frontend\modules\personal\models\Person;
class ReportController extends CommonController
{
    public $layout = false;
    public $enableCsrfValidation = false;

    /**
     * 举报功能逻辑处理
     * @param String obj 举报业务类型(shop,task,service,user)
     * @param String obj_id 必须.举报对象编号
     * @param String origin_id 必须.举报对象源编号
     * @param String username 举报人用户名
     * @param String user_type 举报人用户类型，默认1 个人，2为企业
     * @param String report_desc 必须.举报描述
     * @param String report_file 举报文件地址，如果有文件上传，需要走上传接口
     * @param String phone 举报人联系方式
     * @param String qq 举报人联系方式
     * @param String to_username 被举报人用户名
     * @return   json
     */
    public function actionAjaxSaveReport()
    {
        //举报接口url
        $url = Yii::$app->params['apiReportUrl'];
        $data = Yii::$app->request->get();
        $callback = Yii::$app->request->get('callback');
        $vso_user_info = Person::getUserInfo($data['username']);
        $data['qq'] = $vso_user_info['qq'];
        $data['phone'] = $vso_user_info['mobile'];
        $rst = VsoApi::send($url, $data, "post");
        if(isset($rst['ret']) && $rst['ret'] == 0){
            $res = json_encode(['result' => 1]);
            exit($callback .'('. $res .')');
        }else{
            $res = json_encode(['result' => 0]);
            exit($callback .'('. $res .')');
        }

    }
}