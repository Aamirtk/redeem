<?php

namespace frontend\modules\home\controllers;

use backend\modules\content\models\Activity;
use backend\modules\content\models\Circle;
use common\api\VsoApi;
use common\lib\Mupload;
use common\lib\Upload;
use frontend\modules\talent\models\User;
use frontend\modules\personal\models\Person;
use backend\modules\content\models\Banner;
use frontend\modules\talent\models\VsoUser;
use yii;
use frontend\modules\activity\models\MilProject;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use backend\modules\content\models\Site;
use common\models\CommonProjectHot;

/**
 * DefaultController implements the CRUD actions for Project model.
 */
class DefaultController extends Controller
{
    public $enableCsrfValidation = false;
    public $layout = 'default';
    public $site = [];//站点信息
    public $user_info = [];//用户信息
    public $banners = [];//banner

    public function beforeAction($action)
    {
        $site = Site::find()->limit(1)->one();
        $this->site = ArrayHelper::toArray($site);
        $vso_uname = User::getLoginedUsername();
        $banners = Banner::find()->asArray()->all();
        $this->banners = $banners;
        if (!empty($vso_uname))
        {
            $this->user_info = Person::getUserInfo($vso_uname);
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $force_pc = yii::$app->request->get('f');
        if (!$force_pc && isMobile())
        {
            $this->redirect('/m/index');
        }
        $page_config = Site::getSiteSeo();

        // 累计项目入驻
        $count_million_proj = yii::$app->cache->get('count_million_proj');
        if (!$count_million_proj)
        {
            $count_million_proj = MilProject::find()->where(['proj_status' => MilProject::STATUS_PASS])->count();
            yii::$app->cache->add('count_million_proj', $count_million_proj, 1800);
        }

        // 累计创意人才
        $count_talent = yii::$app->cache->get('count_talent');
        if (!$count_talent)
        {
            $count_talent = User::find()->where(['status' => User::STATUS_ACTIVE])->count();
            yii::$app->cache->add('count_talent', $count_talent, 1800);
        }

        // 累计粉丝数
        $count_fans = yii::$app->cache->get('count_fans');
        if (!$count_fans)
        {
            $count_fans = ceil(
                yii::$app->db_uc->createCommand('SELECT COUNT(username) FROM vso_user')->queryScalar() / 10000
            );
            yii::$app->cache->add('count_fans', $count_fans, 1800);
        }

        // 热门项目[排行榜]
        $hot_projs = MilProject::getHotProjects();

        //获取热门项目
        $hot_projs_top5 = CommonProjectHot::getTop5();

        // 推荐项目
        $all_projs = MilProject::getTopProjects('all', 6);
        // 近期活动
        $activity = [
            'all' => Activity::getHotActivity('0', 0, 4),
            'sz' => Activity::getHotActivity('1', 0, 4),
            'bj' => Activity::getHotActivity('2', 0, 4),
            'sh' => Activity::getHotActivity('3', 0, 4),
            'gz' => Activity::getHotActivity('4', 0, 4),
            'hk' => Activity::getHotActivity('5', 0, 4)
        ];
        // 圈子
        $circle = Circle::getHotCircle(0, 4);

        // 轮播图
        $banners = Banner::getBannerList(Banner::TYPE_HOME);

        return $this->render(
            'index',
            [
                'count_million_proj' => $count_million_proj,
                'count_talent' => $count_talent,
                'hot_projs' => $hot_projs,
                'all_projs' => $all_projs,
                'page_config' => $page_config,
                'activity' => $activity,
                'circle' => $circle,
                'hot_projs_top5' => $hot_projs_top5,
                'count_fans' => $count_fans,
                'banners' => $banners
            ]
        );
    }

    public function actionTuned()
    {
        $page_config = [
            'site_name' => "申请创客空间-永久免费-安全稳定-蓝海创意云在线创作平台",
            'seo_keywords' => '免费申请创客空间，免费空间，空间安全稳定',
            'seo_desc' => '蓝海创意云会员免费申请空间，创客空间方便好用，海量容量、永久免费、安全稳定，是百万创客随时随地查看项目进度的好帮手。立即体验！'
        ];
        return $this->render(
            'tuned',
            [
                'page_config' => $page_config
            ]
        );
    }

    // 创意空间H5首页
    public function actionMindex()
    {
        $username = User::getLoginedUsername();
        //获取热门项目
        $hot_projs_top5 = CommonProjectHot::getTop5();
        foreach ($hot_projs_top5 as $k => $v)
        {
            $hot_projs_top5[$k] = $v;
            $project = MilProject::getProjDetail($v['proj_id'], $username);
            $hot_projs_top5[$k]['fans_num'] = isset($project['fans_num']) ? $project['fans_num'] : 0;
        }
        // 推荐项目
        $all_projs = MilProject::getTopProjects('all', 6);
        return $this->render(
            'mindex',
            [
                'hot_projs_top5' => $hot_projs_top5,
                'all_projs' => $all_projs
            ]
        );
    }

    // 创意空间H5项目列表页
    public function actionMlist()
    {
        $pageSize = yii::$app->params['home_list_page_size'];
        $indus_pid = 0;
        $page = 1;
        $startNum = (intval($page) - 1) * intval($pageSize);
        if (empty($indus_pid))
        {
            $where = ['proj_status' => MilProject::STATUS_PASS];
        }
        else
        {
            $where = ['proj_status' => MilProject::STATUS_PASS, 'indus_pid' => $indus_pid];
        }
        $list = MilProject::getList(
            $where
            ,
            []
            ,
            ['listorder' => SORT_ASC, 'created_at' => SORT_DESC, 'id' => SORT_DESC]
            ,
            $startNum
            ,
            $pageSize
        );
        return $this->render('mlist', ['list' => $list]);
    }

    // 创意空间H5排行榜
    public function actionMrank()
    {
        // 热门项目[排行榜]
        $hot_projs = MilProject::getHotProjects();
        return $this->render('mrank', ['hot_projs' => $hot_projs]);
    }

    // 创意空间H5圈子
    public function actionMquanzi()
    {
        // 圈子
        $circle = Circle::getHotCircle(0, 4);
        return $this->render('mquanzi', ['circle' => $circle]);
    }

    // 创意空间H5活动
    public function actionMactivity()
    {
        // 近期活动
        $activity = [
            '0' => Activity::getHotActivity('0', 0, 4),
            '1' => Activity::getHotActivity('1', 0, 4),
            '2' => Activity::getHotActivity('2', 0, 4),
            '3' => Activity::getHotActivity('3', 0, 4),
            '4' => Activity::getHotActivity('4', 0, 4),
            '5' => Activity::getHotActivity('5', 0, 4)
        ];
        return $this->render('mactivity', ['activity' => $activity]);
    }
    // 创意空间入驻广告
    public function actionLandfall(){
        //写入上线人员的推广cookie
        setcookie('prom', '34885', null, "/", ".vsochina.com", null, true);
        return $this->render('landfall');
    }

    public function actionIn()
    {
        $nickname = yii::$app->request->post('nickname');
        $email = yii::$app->request->post('email');
        $password = yii::$app->request->post('password');
        $data = [];
        $data['email'] = $email;
        $data['password'] = $password;
        $data['nickname'] = $nickname;
        $data['prom_username'] = '30189049';
        //curl api
        $emailRegisterApiUrl = 'http://api.vsochina.com/user/user/register-email';
        $api = new VsoApi();
        $apiReturn = $api->send($emailRegisterApiUrl,$data,'post',false);
        echo json_encode($apiReturn);
    }

    // 创意空间入驻流程
    public function actionMentry()
    {
        $post = yii::$app->request->post();
        if (empty($post))
        {
            return $this->render('mentry');
        }
        $redirect = '/home/default/mentry';

        // 数据校验
        $mobile = yii::$app->request->post('mobile');
        if (empty($mobile))
        {
            return $this->redirect($redirect);
        }
        $username = yii::$app->request->post('username');
        if (empty($username))
        {
            $username = VsoUser::find()->select('username')->where(['mobile' => $mobile])->scalar();
        }
        $proj_name = yii::$app->request->post('proj_name');
        if (empty($proj_name))
        {
            return $this->redirect($redirect);
        }
        $proj_desc = yii::$app->request->post('proj_desc');
        if (empty($proj_desc))
        {
            return $this->redirect($redirect);
        }
        $team_desc = yii::$app->request->post('team_desc');
        if (empty($team_desc))
        {
            return $this->redirect($redirect);
        }
        // 文件上传
        $img_arr = [];
        $proj_banner = '';
        $proj_thumb = '';
        if (isset($_FILES['fileFirst']) && !empty($_FILES['fileFirst']['name']))
        {
            if (!is_array($_FILES['fileFirst']['name']))
            {
                $path = Upload::ajax_upload('/projects', 'fileFirst');
                $proj_banner = $proj_thumb = $path;
                if (!empty($path))
                {
                    array_push($img_arr, $path);
                }
            }
            else
            {
                $count = count($_FILES['fileFirst']['name']);
                for ($i = 0; $i < $count; $i++)
                {
                    if (!empty($_FILES['fileFirst']['name'][$i]))
                    {
                        $path = Mupload::ajax_upload('/projects', 'fileFirst', $i);
                        if ($i == 0)
                        {
                            $proj_banner = $proj_thumb = $path;
                        }
                        if (!empty($path))
                        {
                            array_push($img_arr, $path);
                        }
                    }
                }
            }
        }
        if (isset($_FILES['fileSecond']) && !empty($_FILES['fileSecond']['name']))
        {
            if (!is_array($_FILES['fileSecond']['name']))
            {
                $path = Upload::ajax_upload('/projects', 'fileSecond');
                if (!empty($path))
                {
                    array_push($img_arr, $path);
                }
            }
            else
            {
                $count = count($_FILES['fileSecond']['name']);
                for ($i = 0; $i < $count; $i++)
                {
                    if (!empty($_FILES['fileSecond']['name'][$i]))
                    {
                        $path = Mupload::ajax_upload('/projects', 'fileSecond', $i);
                        if (!empty($path))
                        {
                            array_push($img_arr, $path);
                        }
                    }
                }
            }
        }

        $url = "http://maker.vsochina.com/api/project/million-create";
        $data = [
            'username' => $username,
            'mobile' => $mobile,
            'proj_name' => $proj_name,
            'proj_desc' => $proj_desc,
            'team_desc' => $team_desc,
            'img_arr' => json_encode($img_arr),
            'proj_banner' => $proj_banner,
            'proj_thumb' => $proj_thumb,
        ];
        $result = VsoApi::send($url, $data);
        if (isset($result['result']) && $result['result'])
        {
            return $this->redirect('/home/default/registersucess');
        }
        else
        {
            return $this->redirect($redirect);
        }
    }
    public function actionRegistersucess()
    {
        $page_config = [
            'site_name' => "申请创客空间-永久免费-安全稳定-蓝海创意云在线创作平台",
            'seo_keywords' => '免费申请创客空间，免费空间，空间安全稳定',
            'seo_desc' => '蓝海创意云会员免费申请空间，创客空间方便好用，海量容量、永久免费、安全稳定，是百万创客随时随地查看项目进度的好帮手。立即体验！'
        ];
        return $this->render(
            'registersucess',
            [
                'page_config' => $page_config
            ]
        );
    }

}