<?php

namespace frontend\modules\activity\controllers;

use backend\modules\content\models\Site;
use common\models\CzProject;
use common\models\FilterWord;
use frontend\modules\activity\models\MillionProjectVote;
use frontend\modules\activity\models\Schedule;
use frontend\modules\project\models\ProjExt;
use frontend\modules\project\models\ProjMember;
use frontend\modules\talent\models\User;
use yii;
use frontend\modules\activity\models\MilProject;
use frontend\modules\project\models\Project;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\Exception;
use yii\data\Pagination;

/**
 * MillionController implements the CRUD actions for Project model.
 */
class MillionController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex($act = '')
    {
        $username = User::getLoginedUsername();

        //网站全局信息
        $site = Site::find()->limit(1)->one();

        // 热门项目
        $hot_projs = MilProject::getRecomProjs($username, 'hot', 3);
        // 推荐项目
        $all_projs = MilProject::getRecomProjs($username, 'all');

        // 创客企业
        $enterprise = User::getRecomUser(2);
        // 创客人才
        $individual = User::getRecomUser(1);

        $result = $this->render('index', [
            'site' => $site,
            'hot_projs' => $hot_projs,
            'all_projs' => $all_projs,
            'individual' => $individual,
            'enterprise' => $enterprise
        ]);

        if ($act == 'makehtml')
        {
            return $result;
        }
        elseif ($username == '')
        {
            $indexhtml = Yii::getAlias('@frontend') . '/web/index.html';
            if (file_exists($indexhtml) && filesize($indexhtml) > 102400)
            {
                echo file_get_contents($indexhtml);
                exit();
            }
            else
            {
                return $result;
            }
        }
        else
        {
            return $result;
        }
    }

    /**
     * 大赛说明
     * @return string
     */
    public function actionIntro_bak()
    {
        return $this->render('intro');
    }

    /**
     * 百万大赛说明页，用于手机端访问，PC端直接跳转首页
     * @return string|yii\web\Response
     */
    public function actionIntro()
    {
        return $this->redirect('http://100.vsochina.com');
    }

    /**
     * 百万创意大赛投票接口
     *
     * 调用入口:     {maker server domain}/activity/million/vote
     * 调用请求方式: POST
     * 请求参数:     integer p_id 被投票项目的id
     * 调用要求：    当前用户处于登录状态时可用
     *
     * 返回值:
     * 返回值类型:   JSON String
     * 返回值示例:
     *              {
                        "ret":false,
                        "message":"invalid username"
     *              }
     */
    public function actionVote()
    {
        $username = User::getLoginedUsername();
        $projectId = yii::$app->request->post('p_id');
        if(!$username)
        {
            return json_encode(['ret'=>false,'message'=>'invalid username']);
        }
        if(!isset($projectId) || empty($projectId))
        {
            return json_encode(['ret'=>false,'message'=>'invalid project_id']);
        }
        //检查当前用户今日剩余的投票次数
        $redisVoteCountKey = yii::$app->params['million_vote'].date("Y:m:d", time()).':'.$username;
        $todayVoteCount = yii::$app->redis->get($redisVoteCountKey);
        if($todayVoteCount > 2)
        {
            return json_encode(['ret'=>false,'message'=>'vote not avaliable']);
        }
        //保存投票记录
        $voteModel = new MillionProjectVote();
        $voteModel->project_id = $projectId;
        $voteModel->username = $username;
        $voteModel->vote_time=time();
        $dbSaveResult = $voteModel->save();
        if($dbSaveResult)
        {
            yii::$app->redis->set($redisVoteCountKey,($todayVoteCount+1));
            return json_encode(['ret'=>true,'message'=>'vote success']);
        }
        else
        {
            return json_encode(['ret'=>false,'message'=>$voteModel->getErrors()]);
        }
    }

    /**
     * 百万创意大赛大赛赛程
     *
     * 调用入口:     {maker server domain}/activity/million/schedule
     * 调用请求方式: POST
     * 请求参数:
     * 调用要求：
     *
     * 返回值:
     * 返回值类型:   JSON String
     * 返回值示例:
     *              {
     * "ret":true,
     * "data":{
     *      "4":[
     *          {
     *              "id":"22",
     *              "title":"11111",
     *              "icon":"http:\/\/maker.vsochina.com\/upload\/projects\/20160229\/images56d3fd0da1b40.jpg",
     *              "start_time":"2016-02-01 16:01:00",
     *              "create_time":"1456730953",
     *              "status":"2",
     *              "order":"1",
     *              "type":"4"
     *          }
     *          ],
     *      "1":[
     *          {
     *              "id":"3",
     *              "title":"22",
     *              "icon":"http:\/\/maker.vsochina.com\/upload\/projects\/20160229\/images56d3f08eddc23.jpg",
     *              "start_time":"2016-02-10 15:33:00",
     *              "create_time":"1456730258",
     *              "status":"0",
     *              "order":"2",
     *              "type":"1"
     *          }
     *          ]
     *       }
     */
    public function actionSchedule(){
        $redis = yii::$app->redis;
        $redis_schedule = $redis->get('index:million_schedule');
        if (!$redis_schedule)
        {
            $schedules = Schedule::getList();
            $redis->set('index:million_schedule', json_encode($schedules));

            $million_schedule = json_encode(['ret'=>true,'data'=>$schedules]);
        }
        else{
            $schedules = json_decode($redis_schedule);
            $million_schedule = json_encode(['ret'=>true,'data'=>$schedules]);
        }

        return $million_schedule;
    }
}