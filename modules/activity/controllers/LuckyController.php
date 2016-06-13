<?php

namespace frontend\modules\activity\controllers;

use backend\modules\content\models\MillionProject;
use common\api\VsoApi;
use common\models\CzProject;
use common\models\CzProjFavorite;
use frontend\modules\activity\models\SpringUtil;
use frontend\modules\project\models\Project;
use frontend\modules\talent\models\VsoUser;
use yii\web\Controller;
use yii;

class LuckyController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * 点赞迎新春活动介绍
     * @return string
     */
    public function actionLuckymoney()
    {
        $force_pc = yii::$app->request->get('f');
        if (!$force_pc && isMobile()) {
            $this->redirect('/m/activity/luckymoney20160205');
        }
        $totalSendPackMoney = yii::$app->redis->get('weixin.vsochina.com:spring2016:pack:limit:'.date("Y:m:d", time()));
        if($totalSendPackMoney == null)
        {
            $totalSendPackMoney = 0;
        }
        return $this->render('luckymoney',[
            'activity_start_time'=>mktime(yii::$app->params['spring_festivel_activity_start_per_day'],0,0,date("m"),date("d"),date("Y")),
            'activity_end_time'=>mktime(yii::$app->params['spring_festivel_activity_stop_per_day'],0,0,date("m"),date("d"),date("Y")),
            'now'=>time(),
            'finished'=>$totalSendPackMoney >= yii::$app->params['spring_pack_limit_per_day'],
        ]);
    }

    /**
     * Mobile 点赞迎新春活动介绍
     * @return string
     */
    public function actionMluckymoney()
    {
        $totalSendPackMoney = yii::$app->redis->get('weixin.vsochina.com:spring2016:pack:limit:'.date("Y:m:d", time()));
        if($totalSendPackMoney == null)
        {
            $totalSendPackMoney = 0;
        }
        return $this->render('mluckymoney',[
            'activity_start_time'=>mktime(yii::$app->params['spring_festivel_activity_start_per_day'],0,0,date("m"),date("d"),date("Y")),
            'activity_end_time'=>mktime(yii::$app->params['spring_festivel_activity_stop_per_day'],0,0,date("m"),date("d"),date("Y")),
            'now'=>time(),
            'sdk' => $this->wechatJsSdkData(),
            'finished'=>$totalSendPackMoney >= yii::$app->params['spring_pack_limit_per_day'],
        ]);
    }

    /**
     * Mobile 红包页面
     * @return string
     */
    public function actionMlucky()
    {
        if(yii::$app->params['spring_festivel_activity_switch']==false){
            $this->redirect("/home/default/index"); //活动结束
        }
        $qr_url = yii::$app->request->post('qr_url');
        $proj_name = yii::$app->request->post('proj_name');
        return $this->render('mlucky', ['src' => $qr_url, 'proj_name' => $proj_name,'sdk' => $this->wechatJsSdkData()]);
    }

    /**
     * 构造微信jssdk必须的参数
     * @return mixed
     */
    private function wechatJsSdkData()
    {
        //获取jssdk门票
        $ticket = $this->getJsTicket();
        //根据门票生成签名
        $signArr = [];
        $signArr['noncestr'] = 'landhightech';
        $signArr['jsapi_ticket'] = $ticket;
        $signArr['timestamp'] = time();
        $signArr['url'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        ksort($signArr);
        $orginSing = '';
        foreach ($signArr as $key => $value)
        {
            $orginSing .= $key . '=' . $value . '&';
        }
        $sign = sha1(substr($orginSing, 0, strlen($orginSing) - 1));

        $data['appId'] = 'wxcb006182f6e037ad';
        $data['timestamp'] = $signArr['timestamp'];
        $data['nonceStr'] = $signArr['noncestr'];
        $data['signature'] = $sign;
        return $data;
    }

    private function getJsTicket()
    {
        $redis = yii::$app->redis;
        //从redis中读取ticket
        $ticket = $redis->get("js_ticket");
        if (!$ticket)
        {
            $token = $this->getAccessToken();
            $ticketUrl = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=%s&type=jsapi";
            $ticketUrl = sprintf($ticketUrl, $token);
            $ticket = file_get_contents($ticketUrl);
            $ticket = json_decode($ticket);
            $redis->setex("js_ticket", 60, $ticket->ticket);
            return $ticket->ticket;
        }
        else
        {
            return $ticket;
        }
    }

    private function getAccessToken()
    {
        $redis = yii::$app->redis;
        //从redis中读取AccessToken
        $accessToken = $redis->get("wc:access_token");
        if (!$accessToken)
        {
            //Redis中没有找到,通过接口获取新的token,存入Redis
            $apiUrl = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s';
            $apiUrl = sprintf($apiUrl, 'wxcb006182f6e037ad', '8230c56f3da54ff26fb86e77f6cf5f4e');
            $response = file_get_contents($apiUrl);
            $responseJson = json_decode($response);
            $accessToken = $responseJson->access_token;
            $redis->setex("wc:access_token", 60, $accessToken);
        }
        return $accessToken;
    }

    /**
     * Mobile 推广注册得红包页面
     * @return string
     */
    public function actionMluckyregister($proj_id,$error='')
    {
        if(yii::$app->params['spring_festivel_activity_switch']==false){
            $this->redirect("/project/default/view/$proj_id"); //活动结束
        }
        $proj = CzProject::find()->where(['proj_id'=>$proj_id])->one();
        return $this->render('mluckyregister', [
            'proj_id' => $proj_id,
            'error'=>$error,
            'proj_name'=>!empty($proj)?$proj->proj_name:'创意空间',
            'sdk' => $this->wechatJsSdkData()]);
    }

    public function actionRegister()
    {
        $mobile = yii::$app->request->post('mobile');
        //注册
        if (isset($mobile)) {
            $data = [];
            $data['mobile'] = $mobile;
            $data['prom_username'] = '30189049';
            //curl api
            $registerApiUrl = 'http://api.vsochina.com/user/user/register-mobile';
            $api = new VsoApi();
            $apiReturn = $api->send($registerApiUrl, $data, 'post', false);
            echo json_encode($apiReturn);
        }
    }

    public function actionLogin()
    {
        $name = yii::$app->request->post('name');
        $password = yii::$app->request->post('password');
        $project = yii::$app->request->post('project');
        //校验身份
        $data = [];
        $data['name'] = $name;
        $data['password'] = $password;
        $loginUrl = 'http://api.vsochina.com/user/user/login';
        $api = new VsoApi();
        $apiReturn = $api->send($loginUrl, $data, 'post', false);
        if ($apiReturn['ret'] == 13000) {
            $user = VsoUser::find()->where(['mobile'=>$name])->one();
            $username = $user->username;
            //点赞
            $model = CzProjFavorite::findOne(['proj_id' => $project, 'username' => $username]);
            //点过赞
            if (!empty($model)) {
                return json_encode(['result'=>false,'message'=>'已经关注过本项目','ticket'=>null,'proj_name'=>null]);
            }

            $model = new CzProjFavorite();
            $model->setAttributes([
                'proj_id' => $project,
                'username' => $username,
                'created_at' => time()
            ]);
            if ($model->save()) {
                $ticket = null;
                //2016春节红包活动开关
                if (SpringUtil::isSpringActivityAvaliable()) {
                    //curl 微信接口,生成红包和二维码
                    //生成伪装码
                    $dummyAction = microtime().uniqid();
                    yii::error($dummyAction);
                    $dummyAction = md5($dummyAction);
                    //将伪装码存入redis
                    yii::$app->redis->lpush(yii::$app->params['spring_festivel_activity_pack_url_dummy'], $dummyAction);
                    //利用伪装码拼装红包生成接口地址
                    $packGenUrl = yii::$app->params['spring_festivel_activity_pack_gen_url'] . $dummyAction;
                    //组装接口请求数据
                    $packGenPost = [];
                    $packGenPost['username'] = $username;
                    $packGenPost['project'] = $project;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $packGenUrl);
                    curl_setopt($ch, CURLOPT_POST, 1); // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $packGenPost); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//成功时不返回true，只返回结果
                    $output = curl_exec($ch);
                    $ticket = isset(json_decode($output)->ticket) ? json_decode($output)->ticket : null;
                    curl_close($ch);
                }
                CzProjFavorite::updateFansNum($project);
                if ($ticket != null) {
                    $proj = \common\models\CzProject::find()
                             ->where(['proj_id' => $project])
                             ->one();
                    return json_encode(['result'=>true,'message'=>'','ticket'=>$ticket,'proj_name'=>$proj->proj_name]);
                }
                else
                {
                    return json_encode(['result'=>false,'message'=>'未知错误','ticket'=>null,'proj_name'=>null]);
                }
            }
            else {
                return json_encode(['result'=>false,'message'=>'关注失败','ticket'=>null,'proj_name'=>null]);
            }
        }
        else {
            //登录失败
            return json_encode(['result'=>false,'message'=>'用户名或密码错误','ticket'=>null,'proj_name'=>null]);
        }
    }
}