<?php
/**
 * Created by PhpStorm.
 * User: Qingwenjie
 * Date: 2016/2/15
 * Time: 11:03
 */
namespace frontend\modules\studio\controllers;

use common\api\Http;
use common\api\VsoApi;
use common\models\CzProject;
use frontend\modules\studio\models\TbV2Studio;
use frontend\modules\studio\models\TbV2StudioBanner;
use frontend\modules\talent\models\User;
use yii;
use yii\web\Controller;

class IndexController extends Controller {

    public $enableCsrfValidation = false;
    //工作室首页
    public function actionIndex() {
        echo('index');
    }

    //工作室列表页面
    public function actionList() {
        //获取参数
        $cid = yii::$app->request->get('cid', 0);//行业ID
        $keyword = yii::$app->request->get('keyword');//工作室名称
        $username = User::getLoginedUsername();

        $_http_mdl = new Http();
        //获取行业列表
        $_industry_open_params = [];
        $_industry_list = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czStudioCategoryList'], $_industry_open_params));

        //获取工作室列表
        $_studio_open_params = [
            'page' => 1,
            'limit' => 36,
        ];

        //按行业
        if (max($cid, 0) < 0) {
            $_studio_open_params['industry'] = $cid;
        }

        //按工作室名称搜索
        if (!empty($keyword)) {
            $_studio_open_params['keyword'] = $keyword;
        }

        $_studio_list = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czStudioList'], $_studio_open_params));
        $data = [
            '_page_config' => [
                'title' => '工作室列表_创意空间_创意云',
                'keyword' => '',
                'description' => '',
            ],
            '_industry_list' => $_industry_list['data'],
            '_studio_list' => $_studio_list['data'],
            'username'=>$username
        ];
        return $this->render('list', $data);
    }

    //工作室详情页面
    public function actionDetail() {
        $s_id = yii::$app->request->get('s_id');
        $username = User::getLoginedUsername();
        $_http_mdl = new Http();
        // 添加访问信息
        $_http_mdl->_get(yii::$app->params['czAddStudioVisit'], ['s_id' => $s_id, 'username' => $username]);
        // 获取工作室信息
        $studio = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czStudioInfo'], ['s_id' => $s_id, 'username' => $username]));
        // 获取项目列表
        $project = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czStudioProjectList'], ['s_id' => $s_id]));
        //工作室动态
        $publicProjects = CzProject::find()->where(['studio_id'=>$studio['data']['studio_id'],'proj_self_status'=>0,'proj_status'=>0])->orderBy(['proj_created'=>SORT_DESC])->asArray()->all();
        //获取用户注册时间
        $creator = $studio['data']['studio_owner'];
        $api = new VsoApi();
        $info = $api->send('http://api.vsochina.com/user/info/view', $data = ['username'=>$creator], $type = "get");
        $create_time = $info['data']['create_time'];
        //当前用户是否为当前工作室的成员
        $isMember = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czIsStudioMember'], ['s_id' => $s_id, 'username' => $username]));

        $data = [
            '_studio' => $studio['data'],
            '_project' => $project['data'],
            '_public_projects'=>$publicProjects,
            '_create_time'=>$create_time,
            '_isMember'=>$isMember['data']['data']
        ];
        //获取banner图片偏移量
        $bannerPosition = TbV2StudioBanner::find()->where(['s_id'=>$s_id])->one();
        if($bannerPosition)
        {
            $data['dx'] = $bannerPosition->x_axis;
            $data['dy'] = $bannerPosition->y_axis;
            $data['banner_img'] = $bannerPosition->path;
        }
        else
        {
            $data['dx'] = 0;
            $data['dy'] = 0;
            $data['banner_img'] = null;
        }
        return $this->render('detail', $data);
    }

    //获取工作室成员列表
    public function actionMemberList() {
        $s_id = yii::$app->request->get('s_id');
        $page = yii::$app->request->get('page');
        $limit = yii::$app->request->get('limit');

        if ($s_id) {
            $_http_mdl = new Http();
            $res = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czStudioMemberList'], ['s_id' => $s_id, 'page' => $page, 'limit' => $limit]));
            if ($res['ret'] == 20001) {
                return json_encode(['result' => true ,'data' => $res['data']]);
            }
        }
        return json_encode(['ret' => false]);
    }

    public function actionFocus() {
        $s_id = yii::$app->request->post('s_id');
        $username = User::getLoginedUsername();

        if ($s_id && $username) {
            $_http_mdl = new Http();
            $res = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czFocusStudio'], ['s_id' => $s_id, 'username' => $username]));
            if ($res && $res['ret'] == 20001) {
                return json_encode(['result' => true]);
            }
        }

        return json_encode(['result' => false]);
    }

    public function actionUnfocus() {
        $s_id = yii::$app->request->post('s_id');
        $username = User::getLoginedUsername();

        if ($s_id && $username) {
            $_http_mdl = new Http();
            $res = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czUnFocusStudio'], ['s_id' => $s_id, 'username' => $username]));
            if ($res && $res['ret'] == 20001) {
                return json_encode(['result' => true]);
            }
        }

        return json_encode(['result' => false]);
    }

    public function actionJoinStudio() {
        $reason = yii::$app->request->post('reason');
        $email = yii::$app->request->post('email');
        $s_id = yii::$app->request->post('s_id');
        $username = User::getLoginedUsername();

        if ($s_id && $username && $reason && $email) {
            $_http_mdl = new Http();
            $res = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czStudioJoinStudioMessage'], ['s_id' => $s_id, 'username' => $username, 'email' => $email, 'reason' => $reason]));
            if ($res && $res['ret'] == 20001) {
                return json_encode(['result' => true]);
            }
        }

        return json_encode(['result' => false]);
    }



    //json转数组
    private function _json_to_arr($json) {
        if (empty($json)) {
            return '';
        }

        return json_decode($json,true);
    }
    public function actionTrends() {
        return $this->render('trends');
    }

    // 工作室上传页面
    public function actionUpload() {
        $s_id = yii::$app->request->get('s_id');
        if(isset($s_id) && !empty($s_id))
        {
            $username = User::getLoginedUsername();
            $_http_mdl = new Http();
            // 获取工作室信息
            $studio = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czStudioInfo'], ['s_id' => $s_id, 'username' => $username]));
            $otherTrends = $res = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czStudioTrendsList'], ['s_id' =>$s_id,'page'=>yii::$app->request->get('page'),'limit'=>yii::$app->request->get('limit')]));
            if($studio['data']['studio_owner'] == $username)
            {
                return $this->render('upload',['s_id'=>$s_id,'_studio'=>$studio['data'], '_others'=>$otherTrends['data']]);
            }
            else
            {
                return $this->redirect(yii::$app->params['frontendurl'].'/studio/index/detail?s_id='.$s_id);
            }
        }
        else
        {
            return $this->redirect(yii::$app->params['frontendurl'].'/studio/index/detail?s_id='.$s_id);
        }
    }


    /**
     * banner拖动位置保存
     */
    public function actionDragBanner()
    {
        $bannerPosition = TbV2StudioBanner::find()->where(['s_id'=>yii::$app->request->post('s_id')])->one();
        if($bannerPosition)
        {
            $bannerPosition->x_axis = yii::$app->request->post('dx');
            $bannerPosition->y_axis = yii::$app->request->post('dy');
            $saveResult = $bannerPosition->update();
        }
        else
        {
            $model = new TbV2StudioBanner();
            $model->s_id = yii::$app->request->post('s_id');
            $model->x_axis = yii::$app->request->post('dx');
            $model->y_axis = yii::$app->request->post('dy');
            $model->path = yii::$app->request->post('path');
            $saveResult = $model->save();
        }
        echo $saveResult;
    }

    /**
     * 本地上传banner
     * @return string
     * @throws \Exception
     */
    public function actionEditBanner()
    {
        $editResult = false;
        $bannerPosition = TbV2StudioBanner::find()->where(['s_id'=>yii::$app->request->post('s_id')])->one();
        if($bannerPosition)
        {
            $bannerPosition->x_axis = 0;
            $bannerPosition->y_axis = 0;
            $bannerPosition->path = yii::$app->request->post('src');
            $editResult = $bannerPosition->update();
        }
        else
        {
            $model = new TbV2StudioBanner();
            $model->s_id = yii::$app->request->post('s_id');
            $model->x_axis = 0;
            $model->y_axis = 0;
            $model->path = yii::$app->request->post('src');
            $editResult = $model->save();
        }
        return json_encode(['editResult'=>$editResult]);
    }

    /**
     * 本地上传头像
     * @return string
     * @throws \Exception
     */
    public function actionEditIcon()
    {
        $studio = TbV2Studio::find()->where(['s_id'=>yii::$app->request->post('s_id')])->one();
        $studio->icon = yii::$app->request->post('icon');
        $editResult = $studio->update();
        return json_encode(['editResult'=>$editResult]);
    }
}