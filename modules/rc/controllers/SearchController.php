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
use common\api\VsoApi;
use common\models\FilterWord;
use common\models\CommonTalent;
use common\models\CommonCity;
use common\models\CommonIndustry;

class SearchController extends Controller {

    public $layout               = false;
    public $enableCsrfValidation = true;

    /**
     * 搜索入口
     * @return string
     */
    public function actionIndex() {
        //搜索条件
        $keyword = trim(yii::$app->request->get('keyword', '')); //搜索关键字
        $keyword = join(' ', array_filter(explode(' ', $keyword)));

        $user_type = yii::$app->request->get('user_type', 0); //搜索类型1个人 2 企业
        $indus_id = yii::$app->request->get('indus_id', 0); //搜索行业
        $residency = yii::$app->request->get('residency', ''); //搜索地区
        $pno = yii::$app->request->get('pno', 1); //页码
        if (((int)$pno) <= 0) {
            $pno = 1;
        }
        if($pno > 67){
            $pno = 67;
        }
        $limit = yii::$app->request->get('limit',
            yii::$app->params['searchPageLimit']); //每页数量
        $orderby = yii::$app->request->get('orderby', 2); //排序(1:粉丝数 2:作品数)
        $offset = yii::$app->request->get('offset', ($pno - 1) * $limit); //起始位置
        $offset = $offset > 1485 ? 1485 : $offset;//最多1500条,按照每页15条计算
        $search = [
            "keyword" => $this->replace_specialChar($keyword),//过滤搜索关键字
            "indus_id" => $indus_id,
            "user_type" => $user_type,
            "offset" => $offset,
            "limit" => $limit,
            "orderby" => $orderby,
            "index" => 'enterprise,talent',//默认个人+企业
            "residency" => $residency,
            "p_indus" => '',//一级行业分类
            "s_indus_name" => '',//二级行业分类名称
            "isIndusRoot" => true,//是否一级分类
        ];
        //行业信息
        if ($indus_id > 0) {
            $search['index'] = 'enterprise';
            $indusInfo = $this->dealIndus($indus_id);
            $search['isIndusRoot'] = $indusInfo['isIndusRoot'];//是否是一级分类
            $search['p_indus'] = $indusInfo['p_indus'];//一级分类名称
            $search['s_indus_name'] = $indusInfo['s_indus_name'];//二级分类名称
            $search['p_indus_url'] = $indusInfo['p_indus_url'];//一级分类关闭URL
            $search['s_indus_url'] = $indusInfo['s_indus_url'];//二级分类关闭URL
        }
        //人才类型
        if ($user_type > 0) {
            $search['index'] = $user_type == 2 ? 'enterprise' : 'talent';
        }
        //排序
        $search['user_type_li'] = $this->displayUserType($user_type);
        if (in_array($orderby, array(2))) {
            $search['orderby'] = 'work_count DESC';//按照作品数降序
        } else {
            $search['orderby'] = '';
        }
        $search['orderby_li'] = $this->displayOrderby($orderby);
        $residencyShort = '';
        if ($residency) {
            $residency = CommonCity::getName((int)$residency);
            $residencyShort = str_replace(array('省', '市', '维吾尔自治区', '壮族自治区', '藏族自治区', '回族自治区', '特别行政区', '自治区',), '', $residency);
        }
        //搜索结果
        if (empty($search['keyword'])) {
            $result = ['total_count' => 0, 'rc' => [], 'rec_users' => [], 'rec_ads' => []];
        } else {
            $result = yii::$app->sphinx->search2($search['keyword'], $offset, $limit, $search['index'], $search['orderby'], $search['indus_id'], $residency, $search['isIndusRoot']);
        }

        //搜索关键字显示处理
        $search['keyword'] = urldecode($keyword);
        //翻页处理
        $totalCount = $result['total_count']> 1000 ? 1000 :$result['total_count'];
        $totalPage = ceil($totalCount / $limit);
        if (((int)$totalPage) <= 0) {
            $totalPage = 1;
        }
        if (((int)$totalPage) > 100) {
            $totalPage = 100;
        }

        $search['totalPage'] = $totalPage;
        $search['totalCount'] = $totalCount;
        $search['pno'] = $pno > $totalPage ? $totalPage : $pno;
        $search['topPage_li'] = $this->displayTopPage($search);
        //一级行业分类
        $industries = $this->getIndustry();
        //二级分类
        $s_industries = [];
        if (isset($search['p_indus']['id'])) {
            $s_industries = $this->getIndustryStype($search['p_indus']['id']);
        }
        if (!empty($s_industries)) {
            $industries = $s_industries;
        }
        //分类显示处理
        $search['industries'] = $this->displayIndus($industries, $search, $s_industries);
        //地区(省)
        $provinces = $this->getProvinces($search['residency']);
        //当前请求路径
        $currentUrl = Yii::$app->request->getUrl();
        $searchUrl = Yii::$app->request->getPathInfo();
        if (!stripos($currentUrl, '?')) {
            $currentUrl = $currentUrl . "?";
        }
        //处理搜索结果里的头像,作品封面
        $result = $this->dealSearchResult($result);
        //右侧广告显示
        $search['rightBannerLi'] = $this->displayRightBanner($result);
        //当前登录用户
        $vso_uname = User::getLoginedUsername();
        //获取我的粉丝列表
        $favors = $this->getFavorList($vso_uname);

        return $this->render('index',
            ['talents' => $result, 'search' => $search,
                '_this_obj' => $this, 'pno' => $pno, 'industries' => $industries,
                'currentUrl' => $currentUrl, 'favors' => $favors, 'vso_uname' => $vso_uname,
                'searchUrl' => $searchUrl, 'orderby' => $orderby, 'loginUrl' => yii::$app->params['loginUrl'],
                'provinces' => $provinces, 'residency' => $residencyShort]);
    }

    /**
     * 获取一级行业分类
     * @return type
     */
    public function getIndustry() {
        //取redis里的
        $redis = yii::$app->redis;
        $industries = json_decode($redis->get('rc:industries:lvl:0:'), true);
        if (empty($industries)) {
            $industries = CommonIndustry::getIndustryList(0);
            $redis->set('rc:industries:lvl:0:', json_encode($industries));
            $redis->expire('rc:industries:lvl:0:', 604800);
        }
        return $industries;
    }

    /**
     * 关注用户
     */
    public function actionFavor() {
        $username = User::getLoginedUsername();
        $obj_name = yii::$app->request->get('obj_name');
        $id = yii::$app->request->get('id');
        $redirect = yii::$app->request->get('redirect');
        $data = [
            'username' => $username,
            'obj_name' => $obj_name,
        ];
        $this->setRedirectUrl($redirect);
        //关注
        $url = yii::$app->params['apiFavorUrl'];
        $result = VsoApi::send($url, $data, "post");
        if ($result['ret'] == 13380) {
            $result['focus_num'] = $this->updateFavor($obj_name, $id);
        }
        echo json_encode($result);
    }

    /**
     * 取消关注用户
     */
    public function actionUnFavor() {
        $username = User::getLoginedUsername();
        $obj_name = yii::$app->request->get('obj_name');
        $id = yii::$app->request->get('id');
        $redirect = yii::$app->request->get('redirect');
        $data = [
            'username' => $username,
            'obj_name' => $obj_name,
        ];
        $this->setRedirectUrl($redirect);
        //搜索结果
        $url = yii::$app->params['apiUnFavorUrl'];
        $result = VsoApi::send($url, $data, "post");
        if ($result['ret'] == 13400) {
            $result['focus_num'] = $this->updateFavor($obj_name, $id);
        }
        echo json_encode($result);
    }

    /**
     * 获取用户的关注列表
     * @param type $vso_uname
     * @return type
     */
    public function getFavorList($vso_uname) {
        $favors = array();
        $res = array();
        if (!empty($vso_uname)) {
            $url = yii::$app->params['apiFavorListUrl'];
            $res = VsoApi::send($url, ['username' => $vso_uname], "post");
        }
        if (!empty($res['data'])) {
            foreach ($res['data'] as $favor) {
                $favors[] = $favor['obj_name'];
            }
        }
        return $favors;
    }

    /**
     * 企业用户认证判断
     */
    public function actionDxtender() {
        $username = User::getLoginedUsername();
        $data = [
            'username' => $username,
        ];
        $redirect = yii::$app->request->get('redirect');
        $this->setRedirectUrl($redirect);
        //企业用户认证结果
        $url = yii::$app->params['apiAuthEnterpriseUrl'];
        $result = VsoApi::send($url, $data, "get");
        echo json_encode($result);
    }

    /**
     * 过滤特殊字符
     * @param type $strParam
     * @return type
     */
    public function replace_specialChar($strParam) {
        $str = FilterWord::filterContent(urldecode($strParam));
        $regex = "/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\|/";
        $str = preg_replace($regex, "", $str);
        $str = urlencode(addslashes($str));
        return $str;
    }

    /**
     * 刷新关注或取消关注的结果
     */
    public function updateFavor($obj_name, $id) {
        //粉丝数量
        $furl = yii::$app->params['apiFavorNum'];
        $fdata = ['username' => $obj_name];
        $fres = VsoApi::send($furl, $fdata, "post");

        //刷新搜索引擎
//        $url      = yii::$app->params['searchRefresh'];
//        $data     = ['id' => $id,'value'=>$fres['data']?$fres['data']:0];
//        $res  = VsoApi::send($url, $data, "get");
        $res = yii::$app->sphinx->updateFocus($id, $fres['data'] ? $fres['data'] : 0);
        return $fres['data'] ? $fres['data'] : 0;
    }

    /**
     * 搜索提示
     */
    public function actionRemind($keyword) {
        $keyword = $this->replace_specialChar($keyword);
        $result = yii::$app->sphinx->search2($keyword, 0, 5, '*');
//        $result = json_decode($result, true);
        if (!empty($result['rc'])) {
            $li = '<ul class="bdsug-list">';
            foreach ($result['rc'] as $rc) {
                $li .= '<li><a href="/talent/' . $rc['username'] . '" title="' . $rc['nickname'] . '">' . $rc['nickname'] . '</a></li>';
            }
            $li .= '</ul>';
            if (!empty($result['rec_users'])) {
                $i = 0;
                $li .= '<div class="official_promote">
                    <h2><i class="icon-16 icon-16-circles"></i>官方推荐人才</h2>
                    <ul class="official-promote-lst">';
                foreach ($result['rec_users'] as $aduser) {
                    if (3 < $i) {
                        break;
                    }
                    $aduser['avatar'] = CommonTalent::getUserAvatar($aduser['username']);
                    $li .= '<li>
                            <a href="/talent/' . $aduser['username'] . '">
                                <img src="' . $aduser['avatar'] . '" alt="">
                                <span class="official-name" title="' . $aduser['nickname'] . '">' . $aduser['nickname'] . '</span>
                            </a>
                        </li>';
                    $i++;
                    ///<span class="color-orange">排名：8</span>
                }
                $li .= '</ul>
                </div>';
            }
            echo $li;
        }
        echo '';
    }

    /**
     * 设置返回URL
     */
    public function setRedirectUrl($redirect) {
        if (empty($redirect)) {
            $redirect = yii::$app->params['rc_frontendurl'];
        }
        setcookie("redirect_url", $redirect, time() + 60000, '/', 'vsochina.com');
    }

    /**
     * 获取省份,显示短名称(北京,江苏,内蒙古..)
     * @return type
     */
    public function getProvinces($residency) {
        $provinces = CommonCity::getProvinces();
        $provinceLi = '';
        foreach ($provinces as $k => $v) {
            $provinces[$k] = $v;
            $provinces[$k]['name'] = str_replace(array('省', '市', '维吾尔自治区', '壮族自治区', '藏族自治区', '回族自治区', '特别行政区', '自治区',), '', $v['name']);
            $provinceUrl = $this->replaceSearchUrl('residency', $v['id']);
            $provinceActive = $residency == $v['id'] ? 'class="active"' : '';
            $provinceLi .= '<a href="' . $provinceUrl . '"' . $provinceActive . '>' . $provinces[$k]['name'] . '</a>';
        }
        $noProvinceUrl = $this->replaceSearchUrl('residency', '');
        $noProvinceActive = empty($residency) ? 'class="active"' : '';
        $provinceLi .= '<a href="' . $noProvinceUrl . '"' . $noProvinceActive . '>不限</a>';
        return $provinceLi;
    }

    /**
     * 获取二级分类列表
     * @param type $indus_id
     * @return type
     */
    public function getIndustryStype($indus_id) {
        if (empty($indus_id)) {
            return [];
        }
        $redis = yii::$app->redis;
        $s_industries = json_decode($redis->get('rc:industries:lvl:1:id:' . $indus_id), true);
        if (empty($s_industries) || $redis->get('rc:industries:refresh:')) {
            $s_industries = CommonIndustry::getIndustries(['id' => $indus_id, 'lvl' => 1]);
            $redis->set('rc:industries:lvl:1:id:' . $indus_id, json_encode($s_industries));
            $redis->expire('rc:industries:lvl:1:id:' . $indus_id, Yii::$app->params['catExpireTime']);
            yii::$app->redis->set('rc:industries:refresh:', false);
        }
        return $s_industries;
    }

    /**
     * 替换搜索的url
     * @param type $param
     * @param type $value
     * @return string
     */
    public function replaceSearchUrl($param, $value) {
        //当前请求路径
        $currentUrl = Yii::$app->request->getUrl();
        if ($value) {
            if (stripos($currentUrl, '&' . $param)) {
                $url = preg_replace('/(&|\?)' . $param . '=[^&]+/', '&' . $param . '=' . $value, $currentUrl);
            } else {
                $url = $currentUrl . '&' . $param . '=' . $value;
            }
        } else {
            $url = preg_replace('/(&|\?)' . $param . '=[^&]+/', '', $currentUrl);
        }
        return $url;
    }

    /**
     * 设置行业分类信息
     * @param type $indus_id
     * @return type
     */
    public function dealIndus($indus_id) {
        $indusInfo['isIndusRoot'] = CommonIndustry::isRoot($indus_id);//是否是一级分类
        $indusInfo['p_indus'] = CommonIndustry::getRootIndus($indus_id);//一级分类名称
        $indusInfo['s_indus_name'] = CommonIndustry::getIndusName($indus_id);//二级分类名称
        $indusInfo['p_indus_url'] = $this->replaceSearchUrl('indus_id', '');
        $indusInfo['s_indus_url'] = $this->replaceSearchUrl('indus_id', isset($indusInfo['p_indus']['id']) ? $indusInfo['p_indus']['id'] : '');

        return $indusInfo;
    }

    /**
     * 处理筛选行业分类的显示
     * @param type $industries
     * @param type $search
     * @return type
     */
    public function displayIndus($industries, $search, $s_industries = array()) {
        $selectIndus = !empty($s_industries) ? $search['p_indus']['id'] : '';
        $noIndusUrl = $this->replaceSearchUrl('indus_id', $selectIndus);
        $noIndusActive = (empty($search['indus_id']) || (($search['isIndusRoot']) && !empty($s_industries))) ? ' class="active"' : '';
        $noIndusLi = '<li><a href="' . $noIndusUrl . '" ' . $noIndusActive . '>不限</a></li>';
        $indusLi = '';
        foreach ($industries as $industry) {
            $indusUrl = $this->replaceSearchUrl('indus_id', $industry['id']);
            $indusUrlActive = $search['indus_id'] == $industry['id'] ? ' class="active"' : '';
            $indusLi .= '<li><a href="' . $indusUrl . '"' . $indusUrlActive . '>' . $industry['name'] . '</a></li>';
        }
        return $noIndusLi . $indusLi;
    }

    /**
     * 设置人才类型显示
     * @param type $userType
     * @return type
     */
    public function displayUserType($userType) {
        $noUserTypeUrl = $this->replaceSearchUrl('user_type', '');
        $noUserTypeActive = empty($userType) ? ' class="active"' : '';
        $noUserTypeLi = '<li><a href="' . $noUserTypeUrl . '"' . $noUserTypeActive . '>不限</a></li>';
        $talentUserUrl = $this->replaceSearchUrl('user_type', 1);
        $talentUserActive = $userType == 1 ? ' class="active"' : '';
        $talentUserLi = '<li><a href="' . $talentUserUrl . '"' . $talentUserActive . '>个人</a></li>';
        $enterpriseUserUrl = $this->replaceSearchUrl('user_type', 2);
        $enterpriseUserActive = $userType == 2 ? ' class="active"' : '';
        $enterpriseUserLi = '<li><a href="' . $enterpriseUserUrl . '"' . $enterpriseUserActive . '>企业</a></li>';
        return $noUserTypeLi . $talentUserLi . $enterpriseUserLi;
    }

    /**
     * 设置排序的显示
     * @param type $orderby
     * @return string
     */
    public function displayOrderby($orderby) {
        $workUrl = $this->replaceSearchUrl('orderby', 2);//按照作品数量排序
        $workActive = $orderby == 2 ? ' class="active pull-left"' : ' pull-left';
        $workLi = '<a href="' . $workUrl . '"' . $workActive . '>作品数 <span class="glyphicon glyphicon-arrow-up"></span></a>';
        return $workLi;
    }

    /**
     * 设置上导航分页显示
     * @param type $search
     * @return type
     */
    public function displayTopPage($search) {
        if ($search['pno'] - 1 < 1) {
            $leftUrl = "javascript:void(0)";
        } else {
            $n = ($search['pno'] - 1) < 1 ? 1 : $search['pno'] - 1;
            $leftUrl = $this->replaceSearchUrl('pno', $n);
        }
        $leftLi = '<a href="' . $leftUrl . '"' . '><span class="glyphicon glyphicon-menu-left"></span></a>';
        if ($search['pno'] + 1 > $search['totalPage']) {
            $rightUrl = 'javascript:void(0)';
        } else {
            $n = ($search['pno'] + 1) > $search['totalPage'] ? $search['totalPage'] : $search['pno'] + 1;
            $rightUrl = $this->replaceSearchUrl('pno', $n);
        }
        $rightLi = '<a href="' . $rightUrl . '"' . '><span class="glyphicon glyphicon-menu-right"></span></a>';
        return $leftLi . $search['pno'] . $rightLi;
    }

    /**
     * 获取作品的封面图
     * @param type $work
     * @return string
     */
    public function getWorkThumb($work) {
        /**
         * 作品图片修改为显示230尺寸的缩略图,不显示原图
         */
        $url = '/images/rc/index/nopic.jpg';
        if ((strpos($work['work_url'], "http") !== false)&&(strpos($work['work_url'], "vsochina.com") === false) || strpos($work['work_url'], ".gif") !== false) { //肯定是外联
            $url = $work['work_url']; //外链方式
        } else {
            switch ($work['pic_or_video']) {
                case 1:
                    $url = $work['work_url'];
                    if ($url) {
                        $urlArray = explode('.', $url);
                        $ext = $urlArray[count($urlArray) - 1];
                        $url = substr($url, 0, strlen($url) - (strlen($ext) + 1));
                        $url = $url . '_230.' . $ext;
                    } else {
                        $url = '/images/rc/index/nopic.jpg';
                    }
                    break;
                case 2:
                    $url = $work['cover_url'];
                    if ($url) {
                        $urlArray = explode('.', $url);
                        $ext = $urlArray[count($urlArray) - 1];
                        $url = substr($url, 0, strlen($url) - (strlen($ext) + 1));
                        $url = $url . '_230.' . $ext;
                    } else {
                        $url = '/images/rc/index/nopic.jpg';
                    }
                    break;
                case 3:
                    $url = '/images/rc/index/nopic.jpg';
                    break;
                case 4:
                    $url = $work['work_url'];
                    if ($url) {
                        $urlArray = explode('.', $url);
                        $ext = $urlArray[count($urlArray) - 1];
                        $url = substr($url, 0, strlen($url) - (strlen($ext) + 1));
                        $url = $url . '_230.' . $ext;
                    } else {
                        $url = '/images/rc/index/nopic.jpg';
                    }
                    break;
                case 5:
                    $url = $work['cover_url'];
                    if ($url) {
                        $urlArray = explode('.', $url);
                        $ext = $urlArray[count($urlArray) - 1];
                        $url = substr($url, 0, strlen($url) - (strlen($ext) + 1));
                        $url = $url . '_230.' . $ext;
                    } else {
                        $url = '/images/rc/index/nopic.jpg';
                    }
                    break;
            }
        }
        return $url;
    }

    public function dealSearchResult($result) {
        //列表里的用户头像和作品封面
        foreach ($result['rc'] as $key => $item) {
            $result['rc'][$key]['avatar'] = CommonTalent::getUserAvatar($item['username']);
            if ($result['rc'][$key]['work']['rc']) {
                foreach ($result['rc'][$key]['work']['rc'] as $k => $work) {
                    $result['rc'][$key]['work']['rc'][$k]['url'] = $this->getWorkThumb($work);
                }
            }
        }
        //官方推荐里的用户头像和作品封面
        foreach ($result['rec_users'] as $key => $item) {
            $result['rec_users'][$key]['avatar'] = CommonTalent::getUserAvatar($item['username']);
            if ($result['rec_users'][$key]['work']['rc']) {
                foreach ($result['rec_users'][$key]['work']['rc'] as $k => $work) {
                    $result['rec_users'][$key]['work']['rc'][$k]['url'] = $this->getWorkThumb($work);
                }
            }
        }

        return $result;
    }

    public function displayRightBanner($result) {
        $li = '';
        if (isset($result['rec_ads'])) {
            $k = 0;
            foreach ($result['rec_ads'] as $rec_ad) {
                if (4 < $k) {
                    break;
                }
                $li .= '<a href="' . $rec_ad['href'] . '"target="_blank"><img src="' . $rec_ad['img'] . '"alt="' . $rec_ad['comment'] . '" width="267" height="167">
            </a>';
                $k++;
            }
        }
        return $li;
    }
}
