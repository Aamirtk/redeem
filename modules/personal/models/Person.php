<?php

namespace frontend\modules\personal\models;

use common\api\VsoApi;
use yii;
use frontend\modules\talent\models\User;
use frontend\modules\personal\models\PersonalLink;
use common\models\CommonTalent;
use yii\helpers\ArrayHelper;
use common\models_shop\shop;

class Person extends User
{
    const FAVORLISTFLAG = 'FavorListFlag:';
    const FAVORLIST = 'FavorList:';
    const USERWORKS = 'UserWorks:';
    const USERWORKSFLAG = 'UserWorksFlag:';

    /**
     * 当前登录用户是否是被访问用户本人
     * @param $obj_username 被访问用户
     * @return bool（true=>是，false=>否）
     */
    public static function isUserSelf($obj_username)
    {
        $username = User::getLoginedUsername();
        if ($username == $obj_username)
        {
            return true;
        }
        return false;
    }

    /**
     * 获取用户信息
     * @param $username 用户名
     * @return array
     */
    public static function getUserInfo($username)
    {
        //从redis缓存里面获取
        $redis=yii::$app->redis;
        $userInfo = json_decode($redis->get('rc:userinfo:username:'.$username),true);
//        if($userInfo){
//            return $userInfo;
//        }
        //取用户信息
        $url = yii::$app->params['user_detail'];
        $data['username'] = $username;
        $rst = VsoApi::send($url, $data, "get");
        $per_links = PersonalLink::getPersonalLink($username);
        $avatar = CommonTalent::getUserAvatar($username);
        //判断是否开通店铺或者店铺
        $has_shop = shop::_get_user_has_shop($username);
        $signture = self::getSignture($username);

        if (isset($rst['data']) && !empty($rst['data']))
        {
            //所在地区
            $residency = empty($rst['data']['residency']) ? '' : explode(',', ($rst['data']['residency']));
            $rst['data']['province'] = isset($residency[0]) ? $residency[0] : '';
            $rst['data']['city'] = isset($residency[1]) ? $residency[1] : '';
            //人才标签
            $lable = empty($rst['data']['lable']) ? array() : explode(',', ($rst['data']['lable']));
            $rst['data']['lable'] = $lable;
            $rst['data']['personal_links'] = $per_links;
            $rst['data']['avatar'] = $avatar;
            $rst['data']['has_shop'] = $has_shop;
            $rst['data']['signture'] = $signture;
            $redis->set('rc:userinfo:username:'.$username, json_encode($rst['data'],true));
            $redis->expire('rc:userinfo:username:'.$username, 10*60);
            $userInfo = $rst['data'];
            return $userInfo;
        }
        else
        {
            return [];
        }
    }
    /**
     * 获取用户的关注列表
     * @param type $vso_uname
     * @return type
     */
    public static function getFavorList($vso_uname)
    {
        $favors = array();
        $res    = array();
        $redis = yii::$app->redis;
        if (!empty($vso_uname))
        {
//            $flag = self::getFavorFlag($vso_uname);
//            $data = $redis->get(self::FAVORLIST.$vso_uname);
//            if($data && $flag==1){
//                $res = json_decode($data, true);
//            }else{
//                $expireTime = yii::$app->params['workExpireTime'];
                $url = yii::$app->params['apiFavorListUrl'];
                $res = VsoApi::send($url, ['username' => $vso_uname], "post");
//                $redis->setex(self::FAVORLIST.$vso_uname, $expireTime, json_encode($res));
//                self::setFavorFlag($vso_uname, 1);
//            }
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
    /**
     * 设置从redis缓存获取的flag
     * @param $prefix redis缓存key前缀
     * @param $key redis缓存key主体
     * @param $flag 1-从缓存获取 2-不从缓存获取
     */
    public static function setFlag($prefix='', $key, $flag = 2)
    {
        $redis = yii::$app->redis;
        $redis->set($prefix.$key, $flag);
    }

    /**
     * 获取从redis缓存获取的flag
     * @param $prefix redis缓存key前缀
     * @param $key redis缓存key主体
     * @param $flag 1-从缓存获取 2-不从缓存获取
     */
    public static function getFlag($prefix='', $key)
    {
        $flag = 2;
        $redis = yii::$app->redis;
        $data = $redis->get($prefix.$key);
        if(!$data){
            $redis->set($prefix.$key, 2);
        }else{
            $flag = $data;
        }
        return $flag;
    }
    /**
     * 设置点赞/取消点赞操作Flag
     * @param $vso_uname
     * @param $flag
     */
    public static function setFavorFlag($vso_uname, $flag = 2)
    {
        self::setFlag(self::FAVORLISTFLAG, $vso_uname, $flag);
    }
    /**
     * 获取点赞/取消点赞操作Flag
     * @param $vso_uname
     * @return bool
     */
    public static function getFavorFlag($vso_uname)
    {
        return self::getFlag(self::FAVORLISTFLAG, $vso_uname);
    }

    /**
     * 获取用户作品
     * @param type $username
     * @return type
     */
    public static function getUserWorks($username)
    {
        //$redis = yii::$app->redis;
        //$flag = self::getUserWorksFlag($username);
        //$data = $redis->get(self::USERWORKS.$username);
        //用户作品
        //if($data){
        //    $works = json_decode($data, true);
        //}else{
//            $expireTime = yii::$app->params['workExpireTime'];
            $workurl = yii::$app->params['userAllWorksUrl'];
            $para['username'] = $username;
            $works = VsoApi::send($workurl, $para, "get");
//            $redis->setex(self::USERWORKS.$username, $expireTime, json_encode($works));
//            self::setUserWorksFlag($username, 1);
        //}

        return isset($works['data']) ? $works['data'] : array();
    }
    /**
     * 设置点赞/取消点赞操作Flag
     * @param $vso_uname
     * @param $flag
     */
    public static function setUserWorksFlag($vso_uname, $flag = 2)
    {
        self::setFlag(self::USERWORKSFLAG, $vso_uname, $flag);
    }
    /**
     * 获取点赞/取消点赞操作Flag
     * @param $vso_uname
     * @return bool
     */
    public static function getUserWorksFlag($vso_uname)
    {
        return self::getFlag(self::USERWORKSFLAG, $vso_uname);
    }

    /**
     * 保存用户签名
     * @param $username
     * @param $signture 个性签名
     * @return bool
     */
    public static function saveSignture($username, $signture)
    {
        $data = array();
        $param = [
            'username'=>$username,
            'signture'=>$signture
        ];
        if (!empty($username))
        {
            $url = yii::$app->params['apiUpdateSingtureUrl'];
            $data = VsoApi::send($url, $param, "post");
        }
        return isset($data['ret'])&&$data['ret']==14020?true:false;
    }
    /**
     * 获取用户签名
     * @param $username
     * @return string
     */
    public static function getSignture($username)
    {
        $data = array();
        $param = [
            'username'=>$username,
        ];
        if (!empty($username))
        {
            $url = yii::$app->params['apiGetSingtureUrl'];
            $data = VsoApi::send($url, $param, "get");
        }
        return ArrayHelper::getValue($data, 'data.signture', '');
    }
    /**
     * 获取用户昵称
     * @param $username
     * @return string
     */
    public static function getNickName($username)
    {
        $user_info = self::getUserInfo($username);
        return ArrayHelper::getValue($user_info, 'nickname', '');
    }
    /**
     * 获取用户点赞数量
     * @param type $username
     * @return type
     */
    public static function getUserPraiseWorkids($username)
    {
        if(empty($username))
        {
            return [];
        }
//        $redis = yii::$app->redis;
//        $flag = $redis->get('rc:praiseflag:username:'.$username);
//        $data = json_decode($redis->get('rc:praiseworkids:username:'.$username),true);
//        //用户作品
//        if(empty($data) || $flag)
//        {
//            $expireTime = yii::$app->params['workExpireTime'];
            $praiseWorkidsurl = yii::$app->params['getUserPraiseWorkids'];
            $para['username'] = $username;
            $works = VsoApi::send($praiseWorkidsurl, $para, "get");
            $data=isset($works['data']) ? $works['data']:[];
//            $redis->set('rc:praiseworkids:username:'.$username, json_encode($data));
//            $redis->expire('rc:praiseworkids:username:'.$username,$expireTime);
//            $flag = $redis->set('rc:praiseflag:username:'.$username,true);
//        }

        return $data ? $data : [];
    }
}