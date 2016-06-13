<?php
/**
 * Created by PhpStorm.
 * User: Qingwenjie
 * Date: 2015/11/2
 * Time: 15:49
 */
namespace frontend\modules\rc\controllers;

use frontend\modules\talent\models\User;
use yii;
use yii\web\Controller;
use frontend\modules\rc\models\Site;
use common\api\VsoApi;
use common\models\RcPersonalWidget;
use common\models\CommonTalent;
use frontend\controllers\CommonController;
use frontend\modules\ucenter\models\SubdomainUser;
use frontend\modules\enterprise\models\CrmCompany;
use frontend\modules\enterprise\models\CrmWork;
use frontend\modules\enterprise\models\News;
use frontend\modules\personal\models\Worklist;
use frontend\modules\personal\models\Person;
use frontend\modules\personal\models\PersonalSkin;
use common\models_shop\shop;
class IndexController extends CommonController
{
    //public $layout = false;
    public $enableCsrfValidation = false;
    public $layout = ""; //设置使用的布局文件
    public $company = null;
    public $has_shop = false;
    //人才库动态首页
    function actionIndex($type = '')
    {
        //rc以外的其它二级域名跳到个人/企业空间总入口
        if($_SERVER['HTTP_HOST']!=yii::$app->params['rc_domain_host'])
        {
            $host=explode('.',$_SERVER['HTTP_HOST']);
            $username=$host[0];
            //获取二级域名对应的用户名
            $domain_username=  SubdomainUser::getSubdomainUser($username);
            $url_ursername=$domain_username?$domain_username:$username;            
            $data = User::getTalentType($url_ursername);
            if (isset($data['isValid']) && $data['isValid'] && 2 == $data['user_type'])
            {
                //企业空间
                return $this->renderEnterprise();
            }
            else
            {
                //个人空间
                return $this->renderPersonal();
            }
        }
        $this->layout=FALSE;
        //生成缓存
        if ($type == 'create') {
            $data = $this->_get_index_data();
            if($data && yii::$app->redis->set("Vso_RC_Index_Data", json_encode($data))){
                exit('Success');
            } else {
                exit('Fail');
            }
        }
        elseif($type =='preview'){
            $data =  $this->_get_index_data();
            $data['_this_obj']=$this;
            //直接加载缓存
            return $this->render('index', $data);
        }
        else {
            $data = json_decode(yii::$app->redis->get("Vso_RC_Index_Data"),true);
            if (!$data) {
                $data =  $this->_get_index_data();
            }
            $data['_this_obj']=$this;
            //直接加载缓存
            return $this->render('index', $data);
        }
    }

    /**
     * 首页信息缓存
     * @return array
     */
    private function _get_index_data(){
        //获取作品模块相关排序
        $_work_group_order = \app\modules\rc\models\RcPushGroup::_get_list(
            ['mode' => 'index_words', 'is_show' => 'true'],
            'sort asc'
        );
        $data = [
            '_page_title' => '蓝海创意云服务商库-汇聚国内文化创意行业服务行业优秀人才,工作室,服务公司RC.VSOCHINA.COM',
            '_page_keywords' => '服务商,服务公司,创意设计人才',
            '_page_description' => '蓝海创意云服务商库RC.VSOCHINA.COM汇聚国内文化创意行业服务行业优秀人才、工作室、服务公司.找影视、动漫、游戏、创意设计人才,工作室,服务公司就到蓝海创意云服务商库.',
            '_word_group_order' => $_work_group_order,
            '_info' => $this->_get_index_push_info(),
        ];
        return $data;
    }
    //获取推送数据
    private function _get_index_push_info()
    {
        $_push_list = \app\modules\rc\models\RcPushInfo::_get_list();
        $push_data = [];
        if (!empty($_push_list)):
            foreach ($_push_list as $val):
                $_this_data = $val;
                $_this_data['content'] = json_decode($_this_data['content'], true);
                if (!empty($_this_data['content']['link']) && !in_array(
                        $_this_data['content']['link'],
                        ['#', 'javascript:void(0);', 'javascript:void(0)']
                    )
                )
                {
                    $uri = parse_url($_this_data['content']['link']);
                    if (!empty($uri['query']))
                    {
                        parse_str($uri['query'], $_query);
                        $_this_data['content']['link'] = (empty($uri['scheme']) ? '' : $uri['scheme'] . '://') . (empty($uri['host']) ? '' : $uri['host']) . (empty($uri['path']) ? '' : $uri['path']) . '?' . http_build_query(
                                $_query
                            );
                    }
                }
                $push_data[$_this_data['p_id']] = $_this_data;
            endforeach;
        endif;
        return $push_data;
    }
    /**
     * Display the Site Information
     * @return mixed
     */
    public function actionSiteInfo()
    {
        $model = new Site();
        $site_type = yii::$app->request->get('site_type');
        $jsonpcallback = yii::$app->request->get('jsonpcallback');
        if (empty($site_type))
        {
            return false;
        }
        $result = $model->find()->where(['site_type' => $site_type])->limit(1)->asArray()->one();
        echo $ret_code = $jsonpcallback . '(' . json_encode($result) . ')';;
        exit;
    }

    function actionEnterprisecase()
    {
        return $this->render('enterprisecase');
    }

    function actionRank($industry = '')
    {
        $vso_uname = User::getLoginedUsername();
        $favors = $this->getFavorList($vso_uname);
        $pno = yii::$app->request->get('pno', 1);
        //获取rank
        $totalCount = yii::$app->params['rc_rank_total_num'];
        $pageSize = yii::$app->params['rc_rank_page_size'];
        $totalPage = ceil($totalCount/$pageSize);
        $offset = ($pno-1)*$pageSize;
        $rank = yii::$app->sphinx->rank($industry, $offset, $pageSize);
        //获取用户的头像
        foreach ($rank['rc'] as $key => $item) {
//            $rank['rc'][$key]['user_info'] = Person::getUserInfo($item['username']);
            $rank['rc'][$key]['avatar'] = CommonTalent::getUserAvatar($item['username']);
        }
        //获取人才周刊挂件ID
        $_weekly_widget_info = RcPersonalWidget::_get_info(['temp_id' => 6]);

        //获取人才周刊挂件ID
        $_cover_story_widget_info = RcPersonalWidget::_get_info(['temp_id' => 7]);

        return $this->render(
            'rank',
            [
                'rank' => $rank,
                'pno' => $pno,
                'pageSize' => $pageSize,
                'totalCount' => $totalCount,
                'totalPage' => $totalPage,
                'loginUrl' => yii::$app->params['loginUrl'],
                'favors' => $favors,
                '_this_obj' => $this,
                '_cover_story_widget_id' => $_cover_story_widget_info['widget_id'],
                '_weekly_widget_id' => $_weekly_widget_info['widget_id'],
            ]
        );
    }

    /**
     * 获取用户的关注列表
     * @param type $vso_uname
     * @return type
     */
    public function getFavorList($vso_uname)
    {
        $favors = array();
        $res = array();
        if (!empty($vso_uname))
        {
            $url = yii::$app->params['apiFavorListUrl'];
            $res = VsoApi::send($url, ['username' => $vso_uname], "post");
        }
        if (!empty($res['data']))
        {
            foreach ($res['data'] as $favor)
            {
                $favors[] = $favor['obj_name'];
            }
        }
        return $favors;
    }

    //个人用户首页mobile
    function actionMindex()
    {
        return $this->render('mindex');
    }
    //个人用户首页mobile
    function actionMabout()
    {
        return $this->render('mabout');
    }
    //个人用户首页mobile
    function actionMdetail()
    {
        return $this->render('mdetail');
    }
    //渲染用户企业空间首页
    public function renderEnterprise()
    {
        $this->layout="../../../../views/layouts/main_ent";
        //obj_name 被访问的用户名
        $company = CrmCompany::getInfo(['username' => $this->obj_username, 'status' => CrmCompany::STATUS_NORMAL]);
        if(!$company['logo']){
            $company['logo'] = $this->getAvatar($this->obj_username);
        }
        // 被访问用户
        $this->company = $company;
        //判断是否开通店铺或者店铺
        $this->has_shop = shop::_get_user_has_shop($this->obj_username);
        $username = $this->obj_username;
        $pageSize = isMobile() ? yii::$app->params['ment_case_index_page_size'] : yii::$app->params['ent_case_index_page_size'];
        $list = CrmWork::getList(
            ['username' => $username, 'status' => CrmWork::STATUS_ACTIVE],
            ['order' => SORT_DESC, 'create_time' => SORT_DESC],
            $totalCount,
            0,
            $pageSize
        );

        $newslist = News::getList(
            [
                'obj_id' => $this->company['id'],
                'obj_type' => News::OBJ_TYPE
            ],
            ['listorder' => SORT_ASC, 'created_at' => SORT_DESC], 0, 6
        );
        $data['list'] = $list;
        $data['newslist'] = $newslist;
        $data['username'] = $username;
        return isMobile() ? $this->render('../../../enterprise/views/default/mindex', $data) : $this->render('../../../enterprise/views/default/index', $data);          
    }
    //渲染用户个人空间首页
    public function renderPersonal()
    {
        $this->layout="../../../personal/views/layouts/default";
        //取用户作品集
        $file_url = Worklist::getCoverUrl(yii::$app->request->get('workfile') ? urldecode(yii::$app->request->get('workfile')) : '');
        $username = $this->obj_username;
        if ($file_url) {
            echo "<script>window.parent.setfileurl('$file_url');</script>";
            exit();
        }
        //取用户动态作品
        $works = Person::getUserWorks($username);
        //取用户作品集
        $worklist = Worklist::getUserWorklist($username);
        //取皮肤宽度
        $skin = PersonalSkin::findOne(['username' => $username]);
        $per_skin = $skin ? ['pc_id' => $skin->pc_id, 'mobile_id' => $skin->mobile_id] : ['pc_id' => 1, 'mobile_id' => 2];
        $columnWidth = $per_skin['pc_id'] == 1 ? '360' : '530';
        //取登录用户点赞的作品
        $praiseWorkids = Person::getUserPraiseWorkids($this->vso_uname);
        if (!isMobile()) {
            return $this->render('../../../personal/views/index/index', ['works' => $works, 'worklist' => $worklist, 'columnWidth' => $columnWidth]);
        } else {
            return $this->render('../../../personal/views/index/mindex', ['works' => $works, 'worklist' => $worklist, 'praiseWorkids' => $praiseWorkids]);
        }        
    }
}