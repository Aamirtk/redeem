<?php

namespace frontend\modules\activity\controllers;

use backend\modules\content\models\MillionProject;
use common\api\Http;
use common\models\CzMilProject;
use common\models\CzProject;
use frontend\modules\activity\models\MillionProjectVote;
use frontend\modules\activity\models\MilProject;
use yii\web\Controller;
use yii;
use frontend\modules\talent\models\User;

/**
 * McreateController implements the CRUD actions for million creative competition model.
 */
class McreativeController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * 百万创意大赛活动页(PC)
     * @return string
     */
    public function actionIndex()
    {
        $force_pc = yii::$app->request->get('f');
        if (!$force_pc && isMobile()) {
            $this->redirect('mindex');
        }
        $res = null;
        $res = yii::$app->cache->get('index_news');
        if(!$res){
            $_http_mdl = new Http();
            $res = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czStudioTrendsList'], ['s_id' => yii::$app->params['offical_studio_id'], 'page' => 1, 'limit' => 10]));
            yii::$app->cache->set('index_news',$res,300);
        }
        $rank = null;
        $rank = yii::$app->cache->get('index_rank');
        if(!$rank){
            $rank = $this->rankList();
            yii::$app->cache->set('index_rank',$rank,300);
        }
        $all_projs = null;
        $all_projs = yii::$app->cache->get('index_projs');
        if(!$all_projs){
            $all_projs = MilProject::getList(
                ['proj_status' => 5]
                , []
                , ['listorder' => SORT_ASC,'created_at' => SORT_DESC, 'id' => SORT_DESC]
                , 0
                , 8);
            yii::$app->cache->set('index_projs',$all_projs,300);
        }
        $username = User::getLoginedUsername();
        return $this->render('index', [
            'news' => $res['data']['_items'],
            'rank'=>$rank,
            'all_projs'=>$all_projs,
            'username'=>$username
        ]);
    }

    private function rankList(){
        $rank = MillionProjectVote::find()->select(['project_id','count(project_id) as vote'])->groupBy(['project_id'])->orderBy(['count(project_id)'=>SORT_DESC])->with('project')->offset(0)->limit(10)->asArray()->all();
        return $rank;
    }

    public function actionTest(){
        $millProjs = MillionProject::find()->where(['proj_status'=>5])->asArray()->with('project')->all();
        return $this->render('votetest',['projs'=>$millProjs]);
    }

    private function _json_to_arr($json) {
        if (empty($json)) {
            return '';
        }
        return json_decode($json,true);
    }

    /**
     * 百万创意大赛活动页(Mobile)
     * @return string
     */
    public function actionMindex()
    {
        $username = User::getLoginedUsername();

        if (!isMobile())
        {
            $this->redirect('index');
        }
        return $this->render('mindex',['username'=>$username]);
    }

    /**
     * 百万创意大赛规则页(PC)
     * @return string
     */
    public function actionRules()
    {
        $force_pc = yii::$app->request->get('f');
        if (!$force_pc && isMobile())
        {
            $this->redirect('mrules');
        }
        $username = User::getLoginedUsername();
        return $this->render('rules',['username'=>$username]);
    }

    /**
     * 百万创意大赛规则页(Mobile)
     * @return string
     */
    public function actionMrules()
    {
        $username = User::getLoginedUsername();
        if (!isMobile())
        {
            $this->redirect('rules');
        }
        return $this->render('mrules',['username'=>$username]);
    }

    /**
     * 百万创意大赛新闻页
     * @return string
     */
    public function actionNews()
    {
        $_http_mdl = new Http();
        $res = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czStudioTrendsList'], ['s_id' => yii::$app->params['offical_studio_id'], 'page' => 1, 'limit' => 10]));
        $username = User::getLoginedUsername();
        return $this->render('news',[
            'news'=>$res['data']['_items'],
            'username'=>$username
        ]);
    }

    /**
     * 百万创意大赛赛事介绍页
     * @return string
     */
    public function actionIntro()
    {
        $username = User::getLoginedUsername();
        return $this->render('intro',['username'=>$username]);
    }
}