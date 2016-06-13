<?php

namespace frontend\modules\activity\models;

use common\api\Http;
use common\api\VsoApi;
use Yii\helpers\ArrayHelper;
use common\models\CommonTalent;
use common\models\CzMilProject;
use common\models\CzProjectMember;
use common\models\CzProjFavorite;
use common\models\CzUsers;
use common\models\FilterWord;
use common\models\CommonIndustry;
use frontend\modules\talent\models\User;
use frontend\modules\personal\models\Person;
use Yii;

class MilProject extends CzMilProject
{
    /**
     * 获取列表数据
     * */
    public static function getList($where, $andWhere, $orderBy, $offset, $limit){
        $rst = self::find()
            ->where($where)
            ->andWhere($andWhere)
            ->with('project')
            //->with('indus')
            ->orderBy($orderBy)
            ->offset($offset)
            ->limit($limit)
            ->asArray(true)
            ->all();
        return $rst;
    }

    /**
     * 获取分类列表
     * */
    public static function getListType($where = [], $order = '', $group = '')
    {
        return self::find()
            ->with('indus')
            ->where($where)
            ->orderBy($order)
            ->groupBy($group)
            ->asArray(true)
            ->all();
    }

    /**
     * 获取推荐任务列表
     * @param string $type 推荐类型
     * @param int $limit
     * @param string $username 当前登录账号
     * @return array
     */
    public static function getRecomProjs($username, $type = '', $limit = null)
    {
        $where = [];
        switch ($type)
        {
            case "hot": // 热门任务，用于首页
                $where = ['proj_status' => self::STATUS_PASS, 'is_hot' => 1];
                break;
            case "new": // 最新任务，用于首页
                $where = ['proj_status' => self::STATUS_PASS, 'is_new' => 1];
                break;
            case "all":
                $where = ['proj_status' => self::STATUS_PASS];
                break;
            default:
                return [];
        }
        $query = self::find()
            ->where($where)
            ->with('project')
            ->with('indus')
            ->orderBy(['listorder' => SORT_ASC,'created_at' => SORT_DESC, 'id' => SORT_DESC]);
        if (!empty($limit) && intval($limit) > 0)
        {
            $query->limit(intval($limit));
        }
        $projs = $query->asArray()->all();
        if (empty($projs))
        {
            return [];
        }
        foreach ($projs as $k => $v)
        {
            $proj_id = $v['proj_id'];
            $projs[$k]['proj_tag'] = str_replace(",", " | ", $projs[$k]['proj_tag']);
            $projs[$k]['member_list'] = CzProjectMember::getProjMembers($proj_id);
            $projs[$k]['user']['favor_status'] = CzProjFavorite::getFavorStatus($proj_id, $username);
            $user = CzUsers::getUserInfo($v['username']);
            $projs[$k]['user']['nickname'] = isset($user['nickname']) && !empty($user['nickname']) ? $user['nickname'] : '';
            $projs[$k]['user']['tag'] = isset($user['tag']) && !empty($user['tag']) ? $user['tag'] : '';
            $projs[$k]['user']['tag'] = str_replace(",", " | ", $projs[$k]['user']['tag']);
            //$projs[$k]['user']['avatar'] = isset($user['icon']) && !empty($user['icon']) ? $user['icon'] : '';
            $projs[$k]['user']['avatar'] = CommonTalent::getUserAvatar($v['username']);

        }
        return $projs;
    }

    /**
     * 获取项目详情，包括项目成员列表
     * @param $proj_id 项目编号
     * @param $login_username 当前登录用户
     * @return array|static
     */
    public static function getProjDetail($proj_id,$login_username)
    {
        if (empty($proj_id))
        {
            return [];
        }
        $project = self::find()->where(['proj_id' => $proj_id,'proj_status' => self::STATUS_PASS])->asArray()->one();
        if (empty($project))
        {
            return [];
        }
        $project['proj_tag'] = FilterWord::formatTag($project['proj_tag']);
        $project['member_list'] = CzProjectMember::getProjMembers($proj_id, null);
        $project['user']['favor_status'] = CzProjFavorite::getFavorStatus($proj_id, $login_username);
        $user = User::getUserInfo($project['username']);
        $project['user']['nickname'] = isset($user['nickname']) && !empty($user['nickname']) ? $user['nickname'] : '';
        $project['user']['tag'] = isset($user['tag']) && !empty($user['tag']) ? $user['tag'] : '';
        $project['user']['tag'] = FilterWord::formatTag($project['user']['tag']);
        $project['user']['avatar'] = isset($user['avatar']) && !empty($user['avatar']) ? $user['avatar'] : '';
        return $project;
    }

    /**
     * 不在许可范围的用户和资讯，直接线上首页
     * @param $id
     * @param $username
     * @return string
     */
    public static function userlimit($id, $username)
    {
        $userarr = self::getUserArr();
        $viewidarr = self::getViewIdArr();
        if (in_array($id, $viewidarr))
        {
            if (!in_array($username, $userarr))
            {
                return false;
            }
        }
        return true;
    }

    /**
     * 允许查看孵化项目的用户名数组
     * @return array
     */
    public static function getUserArr()
    {
        return ['Sherry', '30870416', '30735191', '30823284', 'fttang', 'honesthu'];
    }

    public static function getViewIdArr()
    {
        return ['4', '5', '6', '7', '8', '10', '11', '12', '14', '19'];
    }

    /**
     * 获取热门项目
     */
    public static function getHotProjects()
    {
        $url = "http://api.vsochina.com/project/project/get-hot-projects";
        $data = [
            'offset' => '0',
            'limit' => '13'
        ];
        $result = VsoApi::send($url, $data, 'get');
        $data = isset($result['data']) ? $result['data'] : [];
        return $data;
    }

    /**
     * 获取孵化项目
     */
    public static function getTopProjects($type = '', $limit = null){
        $redis = yii::$app->redis;
        $projs = json_decode($redis->get('index:allProject'),true);

        if(empty($projs))
        {
            $projs = CzMilProject::getAllProject($type,$limit);
            $redis->set('index:allProject', json_encode($projs));
        }
        return $projs;
    }
    /**
     * 获取浏览次数
     * @id 项目id
     * @return 浏览次数
     **/
    public static function  getViewsNum($id){
        if(empty($id)){
            return 0;
        }
        $redis = yii::$app->redis;
        $redis->hincrby('maker:project:views', $id, 1);
        return $redis->hget('maker:project:views', $id);
    }
    /**
     * 获取评论信息
     * @params array
     * @return array 评论
     **/
    public static function  getCzProjComments($params){
        $comments = [];
       $domain_url = yii::$app->params['cz_projec_comment'];
        $http = new Http();
        $result = objectToArray(json_decode($http->_get($domain_url, $params)));
        if($result['ret'] == 20001 && isset($result['data'])){
            $comments = $result['data'];
        }
        return self::getCzProjCommentsInfo($comments) ;
    }
    /**
     * 获取评论信息-添加头像等信息
     * @params array
     * @return array 评论
     **/
    public static function getCzProjCommentsInfo($comments){
        if(!$comments || isset($comments['_items'])&&!$comments['_items']){
            return [];
        }
        foreach($comments['_items'] as $key => $comment){
            $comments['_items'][$key]['avatar'] = self::getRedisUserInfo($comment['username'], 'avatar');
            $comments['_items'][$key]['nickname'] = self::getRedisUserInfo($comment['username'], 'nickname');
            $comments['_items'][$key]['diff_date'] = self::getDiffDate($comment['create_time']);
            if($comment['_replay']){
                foreach($comment['_replay'] as $i => $rep){
                    $comments['_items'][$key]['_replay'][$i]['avatar'] = self::getRedisUserInfo($rep['username'], 'avatar');
                    $comments['_items'][$key]['_replay'][$i]['nickname'] = self::getRedisUserInfo($rep['username'], 'nickname');
                    $comments['_items'][$key]['_replay'][$i]['diff_date'] = self::getDiffDate($rep['create_time']);
                }
            }

        }
        return $comments;
    }
    /**
     * 添加评论信息
     * @params array
     * @return array 评论
     **/
    public static function  addCzProjComment($_getData, $_postData){
        $domain_url = yii::$app->params['cz_projec_add_comment'];
        $http = new Http();
        $result = objectToArray(json_decode($http->_post($domain_url, $_getData, $_postData)));
        if($result['ret'] == 20001){
            $result['data']['nickname'] = self::getRedisUserInfo($result['data']['username'], 'nickname');
            $result['data']['avatar'] = self::getRedisUserInfo($result['data']['username'], 'avatar');
            return $result['data'];
        }else{
            return false;
        }
    }
    /**
     * 删除评论信息
     * @params array
     * @return array 评论
     **/
    public static function  delCzProjComment($params){
        $comments = [];
        $domain_url = yii::$app->params['cz_projec_del_comment'];
        $http = new Http();
        $result = objectToArray(json_decode($http->_get($domain_url, $params)));

        if($result['ret'] == 20001 || $result['ret'] == 20002){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 获取用户信息-缓存方式
     * @params string $username
     * @return string $key
     **/
    public static function getRedisUserInfo($username, $key = ''){
        $redis = yii::$app->redis;
        $exptime = 10*60;//设置过期时间为10分钟
        $userInfo = json_decode($redis->get('maker:project:comment:'.$username),true);
        if(empty($userInfo)){
            $userInfo = Person::getUserInfo($username);
            $redis->setex('maker:project:comment:'.$username, $exptime, json_encode($userInfo));
        }
        if(!empty($key) && isset($userInfo[$key])){
            return $userInfo[$key];
        }else{
            return $userInfo;
        }
    }

    public static function getDiffDate($time){
        $now = time();
        $diff = $now > $time ? $now-$time : $time-$now;
        $d = floor($diff/3600/24);
        $h = floor($diff/3600);
        $m = floor($diff/60);
        if($d > 0){
            return $d . '天前';
        }else if($h > 0){
            return $h . '小时前';
        }else if($m > 0){
            return $m . '分钟前';
        }else{
            return '1分钟前';
        }
    }
}