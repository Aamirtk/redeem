<?php

namespace frontend\modules\project\controllers;

use backend\modules\content\models\Site;
use common\models\CzProject;
use common\models\FilterWord;
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
use common\models\CommonProjectHot;
use common\models\CommonTalent;
use common\models\CzMilProjectExt;

/**
 * DefaultController implements the CRUD actions for Project model.
 */
class DefaultController extends Controller
{
    public $enableCsrfValidation = false;
    public $vso_uname = '';          // 当前登录用户
    public function beforeAction($action)
    {
        //登录用户
        $this->vso_uname = User::getLoginedUsername();
        return parent::beforeAction($action);
    }

    /**
     * Displays a single Project model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $isMobile = isMobile();
        if($isMobile){
            return $this->redirect(['/project/default/mdetail/', 'id' => $id]);
        }

        //当前登录用户
        $vso_uname = $this->vso_uname;

        if (in_array($id, Project::getViewIdArr()))
        {
            if (!Project::userlimit($id, $vso_uname))
            {
                return $this->redirect('index');
            }
            else
            {
                $project = Project::getProjDetail($id);
                return $this->render(
                    'view' . $id,
                    ['project' => $project, 'extend' => ProjExt::findOne(['proj_id' => $id])]
                );
            }
        }
        $project = MilProject::getProjDetail($id, $vso_uname);
        // 项目不存在
        if (empty($project))
        {
            $this->redirect(yii::$app->defaultRoute);
        }

        // 非法状态的项目，不允许
        if (!in_array($project['proj_status'], MilProject::getValidProjStatusArr()))
        {
            $this->redirect(yii::$app->defaultRoute);
        }

        // 项目未通过审核，不允许项目管理员之外的用户查看
        if ($project['proj_status'] != MilProject::STATUS_PASS && $project['username'] != $vso_uname)
        {
            $this->redirect(yii::$app->defaultRoute);
        }



        //获取登录用户头像
        $user_info = MilProject::getRedisUserInfo($vso_uname);

        //获取浏览次数
        $view_num = MilProject::getViewsNum($id);

        //获取评论
        $pageSize = yii::$app->params['cz_projec_comment_pagesize'];
        $params = [
            'p_id' => $id,
            'page' => 1,
            'limit' => $pageSize,
            'sort_type' => 2
        ];
        $comments = MilProject::getCzProjComments($params);
        $totalCount = isset($comments['_count']) ? $comments['_count'] : 0;
        $totalPage = ceil($totalCount/$pageSize);

        //获取在线创作项目信息
        $cz_proj = CzProject::find()->where(['proj_id' => $id])->asArray()->one();

        // 推荐项目
        $all_projs = MilProject::getRecomProjs($vso_uname, 'all');

        //SEO信息
        $seo = CzMilProjectExt::getProjSeo($id);

        //获取上一个下一个项目链接和名称
        foreach ($all_projs as $i => $v)
        {
            if ($v['proj_id'] == $id)
            {
                if ($i == 0)
                {
                    $prev_proj = null;
                    $next_proj = $all_projs[$i + 1];
                }
                else if ($i == count($all_projs) - 1)
                {
                    $prev_proj = $all_projs[$i - 1];
                    $next_proj = null;
                }
                else
                {
                    $prev_proj = $all_projs[$i - 1];
                    $next_proj = $all_projs[$i + 1];
                }
            }
        }
        return $this->render(
            'detail',
            [
                'cz_project' => $cz_proj,
                'extend' => $project,
                'project' => $project,
                'seo' => $seo,
                'prev_proj' => $prev_proj,
                'next_proj' => $next_proj,
                'vso_uname' => $vso_uname,
                'user_info' => $user_info,
                'view_num' => $view_num,
                'comments' => $comments,
                'pageSize' => $pageSize,
                'totalCount' => $totalCount,
                'totalPage' => $totalPage,
            ]
        );
    }

    /**
     * 项目入驻，PC端访问跳转在线创作
     */
    public function actionCreate()
    {
        if (isMobile())
        {
            return $this->redirect('/home/default/mentry');
        }
        else
        {
            return $this->redirect(yii::$app->params['czMatchUrl']);
        }
    }

    /**
     * 项目入驻，项目基本信息
     * @return string
     * @throws \Exception
     */
    public function actionCreate_bak()
    {
        // 用户已登录时入驻创客
        User::createUser(User::getLoginedUsername());

        $post = yii::$app->request->post();
        if (empty($post))
        {
            return $this->render('create');
        }

        $model = new Project();
        $model->setAttributes([
            'username' => yii::$app->request->post('username'),
            'proj_name' => FilterWord::filterContent(yii::$app->request->post('proj_name')),
            'proj_sub_name' => FilterWord::filterContent(yii::$app->request->post('proj_sub_name')),
            'indus_pid' => yii::$app->request->post('indus_pid'),
            'proj_thumb' => yii::$app->request->post('proj_thumb'),
            'expected_period' => yii::$app->request->post('expected_period'),
            'proj_tag' => FilterWord::filterContent(yii::$app->request->post('proj_tag')),
            'mobile' => yii::$app->request->post('mobile')
        ]);

        $transaction = yii::$app->get('db_maker')->beginTransaction();
        try
        {
            if ($model->insert())
            {
                $proj_id = $model->proj_id;
                $modelExt = new ProjExt();
                $modelExt->setAttributes([
                    'proj_id' => $proj_id,
                    'proj_banner' => yii::$app->request->post('proj_banner'),
                    'proj_desc' => FilterWord::filterContent(yii::$app->request->post('proj_desc')),
                    'team_desc' => FilterWord::filterContent(yii::$app->request->post('team_desc')),
                    'remarks' => FilterWord::filterContent(yii::$app->request->post('remarks')),
                    'proj_risk' => FilterWord::filterContent(yii::$app->request->post('proj_risk')),
                    'img_str' => FilterWord::filterContent(yii::$app->request->post('imgArr')),
                    'qa_str' => FilterWord::filterContent(yii::$app->request->post('qaArr')),
                ]);
                $modelExt->qa_str = str_replace("\\n", "\\\\n", $modelExt->qa_str);
                $modelExt->insert();

                // 项目成员初始化
                $memberStr = yii::$app->request->post('proj_member_str');
                ProjMember::updateProjMember($proj_id, $memberStr);
                $transaction->commit();
                echo json_encode(['result' => true, 'msg' => '新增项目成功']);
            }
            else
            {
                $transaction->rollBack();
                echo json_encode(['result' => false, 'msg' => '新增项目失败']);
            }
        }
        catch (Exception $e)
        {
            echo json_encode(['result' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $username = User::getLoginedUsername();
        if (empty($username))
        {
            $this->redirect(yii::$app->params['loginUrl']);
        }

        $basic = Project::findOne($id);
        if (empty($basic))
        {
            $this->redirect(['my-project']);
        }
        /**
         * 验证是否有权限编辑项目，没有权限则不允许编辑，跳转首页
         * （1）当前登录用户是项目管理员
         * （1）当前登录用户在用户权限列表中
         */
        if ( !($username == $basic['username'] || in_array($username, $this->userarr)))
        {
            $this->redirect(yii::$app->defaultRoute);
        }

        $extend = ProjExt::find()->where(['proj_id' => $id])->one();
        $data = [
            'basic' => $basic,
            'extend' => $extend
        ];

        $post = yii::$app->request->post();
        if (empty($post))
        {
            return $this->render('update', $data);
        }

        $basic->setAttributes([
            'proj_name' => FilterWord::filterContent(yii::$app->request->post('proj_name')),
            'proj_sub_name' => FilterWord::filterContent(yii::$app->request->post('proj_sub_name')),
            'indus_pid' => yii::$app->request->post('indus_pid'),
            'proj_thumb' => yii::$app->request->post('proj_thumb'),
            'expected_period' => yii::$app->request->post('expected_period'),
            'proj_tag' => FilterWord::filterContent(yii::$app->request->post('proj_tag')),
            'proj_status' => Project::STATUS_WAIT,
            'updated_at' => time()
        ]);

        $transaction = yii::$app->get('db_maker')->beginTransaction();
        try
        {
            if ($basic->update())
            {
                if (empty($extend))
                {
                    $extend = new ProjExt();
                }
                $extend->setAttributes([
                    'proj_id' => $id,
                    'proj_banner' => yii::$app->request->post('proj_banner'),
                    'proj_desc' => FilterWord::filterContent(yii::$app->request->post('proj_desc')),
                    'team_desc' => FilterWord::filterContent(yii::$app->request->post('team_desc')),
                    'remarks' => FilterWord::filterContent(yii::$app->request->post('remarks')),
                    'proj_risk' => FilterWord::filterContent(yii::$app->request->post('proj_risk')),
                    'img_str' => FilterWord::filterContent(yii::$app->request->post('imgArr')),
                    'qa_str' => FilterWord::filterContent(yii::$app->request->post('qaArr')),
                ]);
                $extend->qa_str = str_replace("\\n", "\\\\n", $extend->qa_str);
                $extend->save();

                // 项目成员更新
                $memberStr = yii::$app->request->post('proj_member_str');
                ProjMember::updateProjMember($id, $memberStr);
                $transaction->commit();
                echo json_encode(['result' => true, 'msg' => '编辑项目成功']);
            }
            else
            {
                $transaction->rollBack();
                echo json_encode(['result' => false, 'msg' => '编辑项目失败']);
            }
        }
        catch (Exception $e)
        {
            echo json_encode(['result' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * 删除项目
     * 假删，修改项目状态
     * @param $id 项目编号
     */
    public function actionDelete($id)
    {
        $username = User::getLoginedUsername();
        if (empty($username))
        {
            echo json_encode(['result' => false, 'mag' => '登录后才能进行此操作']);
            exit;
        }
        if (empty($id))
        {
            echo json_encode(['result' => false]);
            exit;
        }
        $model = Project::find()->where(['proj_id' => $id])->one();
        if (empty($model))
        {
            echo json_encode(['result' => false, 'msg' => '项目不存在']);
            exit;
        }
        $model->setAttributes(['proj_status' => Project::STATUS_DELETED, 'updated_at' => time()]);
        if ($model->update())
        {
            echo json_encode(['result' => true, 'msg' => '删除成功']);
        }
        else
        {
            echo json_encode(['result' => false, 'msg' => '删除失败']);
        }
        exit;
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 列表页面
     * */
    public function actionList()
    {
        $page_config = [
            'site_name'=>"创客创意项目-最具价值的创业项目-蓝海创意云在线创作平台",
            'seo_keywords'=>'创意项目，孵化项目，创业项目',
            'seo_desc'=>'蓝海创意云在线创作平台最具价值的创客项目孵化平台，免费入驻提交创意项目。蓝海创意云创客空间孵化优秀文创项目，实现年轻人创业梦想的摇篮。'
        ];
        //网站全局信息
        $site = Site::find()->limit(1)->one();
        //获取存在的案例分类
        $industryList = MilProject::getListType(['proj_status' => MilProject::STATUS_PASS], 'created_at desc', 'indus_pid');
        return $this->render('list', [
            'site' => $site,
            'indus' => $industryList,
            'page_config' => $page_config
        ]);
    }

    /**
     * 获取活动列表 ajax
     * */
    public function actionActList(){
        $pageSize = yii::$app->params['home_list_page_size'];
        $indus_pid = yii::$app->request->post('type');
        $page = yii::$app->request->post('page');
        $startNum = (intval($page) - 1) * intval($pageSize);
        if(empty($indus_pid)){
            $where = ['proj_status' => MilProject::STATUS_PASS];
        }
        else{
            $where = ['proj_status' => MilProject::STATUS_PASS, 'indus_pid' => $indus_pid];
        }
        $list = MilProject::getList(
            $where
            , []
            , ['listorder' => SORT_ASC,'created_at' => SORT_DESC, 'id' => SORT_DESC]
            , $startNum
            , $pageSize);

        return json_encode(["list" => $list]);
    }

    public function actionMdetail($id)
    {
        $username = User::getLoginedUsername();

        if ($id == 19)
        {
            if (!Project::userlimit($id, $username))
            {
                return $this->redirect('index');
            }
            else
            {
                $project = Project::getProjDetail($id);
                return $this->render(
                    'view19',
                    ['project' => $project, 'extend' => ProjExt::findOne(['proj_id' => $id])]
                );
            }
        }
        $project = MilProject::getProjDetail($id, $username);
        // 项目不存在
        if (empty($project))
        {
            $this->redirect(yii::$app->defaultRoute);
        }

        // 非法状态的项目，不允许
        if (!in_array($project['proj_status'], MilProject::getValidProjStatusArr()))
        {
            $this->redirect(yii::$app->defaultRoute);
        }

        // 项目未通过审核，不允许项目管理员之外的用户查看
        if ($project['proj_status'] != MilProject::STATUS_PASS && $project['username'] != $username)
        {
            $this->redirect(yii::$app->defaultRoute);
        }

        //获取在线创作项目信息
        $cz_proj = CzProject::find()->where(['proj_id' => $id])->asArray()->one();

        // 推荐项目
        $all_projs = MilProject::getRecomProjs($username, 'all');

        //SEO信息
        $seo = CzMilProjectExt::getProjSeo($id);

        //获取上一个下一个项目链接和名称
        foreach ($all_projs as $i => $v)
        {
            if ($v['proj_id'] == $id)
            {
                if ($i == 0)
                {
                    $prev_proj = null;
                    $next_proj = $all_projs[$i + 1];
                    $next_proj2 = $all_projs[$i + 2];
                }
                else if ($i == count($all_projs) - 1)
                {
                    $prev_proj = $all_projs[$i - 1];
                    $next_proj = null;
                    $next_proj2 = null;
                }
                else
                {
                    $prev_proj = $all_projs[$i - 1];
                    $next_proj = $all_projs[$i + 1];
                    $next_proj2 = $all_projs[$i + 2];
                }
            }
        }

        $hot_projs_top5 = CommonProjectHot::getTop5();

        return $this->render(
            'mdetail',
            [
                'cz_project' => $cz_proj,
                'extend' => $project,
                'project' => $project,
                'seo' => $seo,
                'prev_proj' => $prev_proj,
                'next_proj' => $next_proj,
                'next_proj2'=>$next_proj2,
                'top'=>$hot_projs_top5,
                'username'=>$username
            ]
        );
    }

    /**
     * 添加评论
     * */
    public function actionAjaxAddComment(){
        if(empty($this->vso_uname)){
            return false;
        }
        $p_id = yii::$app->request->post('p_id', '');
        $username = yii::$app->request->post('username', '');
        $comment_id = yii::$app->request->post('comment_id', '');
        $content = yii::$app->request->post('content', '');
        //获取评论
        $_getData = [
            'p_id' => $p_id,
            'username' => $username
        ];
        !empty($comment_id) ? $_getData['comment_id'] = $comment_id : false;
        $_postData = [
            'content' => $content
        ];
        $res = MilProject::addCzProjComment($_getData, $_postData);
        echo json_encode(['res' => $res]);
    }

    /**
     * 删除评论
     * */
    public function actionAjaxDeleteComment(){
        if(empty($this->vso_uname)){
            return false;
        }
        $params = yii::$app->request->post();
        $res = MilProject::delCzProjComment($params);
        echo json_encode(['res' => $res]);
    }
    /**
     * 异步加载评论
     * */
    public function actionAjaxLoadComments(){
        $id = yii::$app->request->post('id', '');
        $page = yii::$app->request->post('page', 1);

        //获取评论
        $pageSize = yii::$app->params['cz_projec_comment_pagesize'];
        $params = [
            'p_id' => $id,
            'page' => $page,
            'limit' => $pageSize,
            'sort_type' => 2
        ];
        $comments = MilProject::getCzProjComments($params);
        if(isset($comments['_items'])){
            echo json_encode(['res' => $comments['_items']]);
        }else{
            echo json_encode(['res' => []]);
        }

    }
    
    /**
     * 修正浏览量
     * */
    public function actionAdjustViews(){
        $redis = yii::$app->redis;
        $where = ['proj_status' => MilProject::STATUS_PASS];
        $list = MilProject::getList(
            $where
            , []
            , ['listorder' => SORT_ASC,'created_at' => SORT_DESC, 'id' => SORT_DESC]
            , 0
            , 50);
        foreach($list as $proj){
            $view_num = $redis->hget('maker:project:views', $proj['proj_id']);
            if(empty($view_num) || $view_num < 10000){
                $redis->hincrby('maker:project:views', $proj['proj_id'], rand(10000, 15000));
            }

        }
        echo '浏览数量更新成功！';
    }


}