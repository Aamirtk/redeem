<?php
namespace frontend\modules\personal\models;

use yii;
use common\api\VsoApi;

class Worklist
{

    /**
     * 获取用户作品集
     * @param type $username
     * @return type
     */
    public static function getUserWorklist($username)
    {
        //用户作品集
        $workurl = yii::$app->params['apiWorklistUrl'];
        $data['username'] = $username;
        $works = VsoApi::send($workurl, $data, "get");
        return isset($works['data']) ? $works['data'] : array();
    }
    /**
     * 创建作品集
     * @return type
     */
    public static function createWorklist($username,$name,$cover)
    {
        $data['username'] = $username;
        $data['name'] = $name;
        $data['cover'] = $cover;
        $workurl = yii::$app->params['apiWorklistCreateUrl'];
        $res = VsoApi::send($workurl, $data, "post");
        return $res;
    }
    /**
     * 更新作品集
     * @return type
     */
    public static function updateWorklist($p_work_id,$name,$cover,$status)
    {
        $data['p_work_id'] = $p_work_id;
        $data['name'] = $name;
        $data['cover'] = $cover;
        $data['status'] = $status;
        $workurl = yii::$app->params['apiWorklistUpdateUrl'];
        $res = VsoApi::send($workurl, $data, "post");
        return $res;
    }
    /**
     * 获取缩略图URL
     * @param type $url
     */
    public static function getCoverUrl($url,$width=230)
    {
        if(empty($url))
        {
            return '';
        }
        $img_src_large = $url;
        $img_arr       = explode(".", $img_src_large);
        $format        = "." . end($img_arr);
        if (empty($width)||  !in_array($format, array('.jpg','.jpeg','.png','.gif')))
        {
            $new_format = $format;
        }
        else
        {
            $new_format = "_" . $width . $format;
        }
        $img_src = str_replace($format, $new_format, $img_src_large);
        return $img_src;
    }
    /**
     * 获取用户作品集
     * @param type $username
     * @return type
     */
    public static function getWorkByWorklist($p_work_id)
    {
        //用户作品集的作品
        $workurl = yii::$app->params['apiWorklistWorksUrl'];
        $data['p_work_id'] = $p_work_id;
        $works = VsoApi::send($workurl, $data, "get");
        return isset($works['data']) ? $works['data'] : array();
    }
    /**
     * 获取作品集详情
     * @param type $p_work_id
     * @return type
     */
    public static function getWorklistInfo($p_work_id)
    {
        //用户作品集
        $workurl = yii::$app->params['apiWorklistInfoUrl'];
        $data['p_work_id'] = $p_work_id;
        $works = VsoApi::send($workurl, $data, "get");
        return isset($works['data']) ? $works['data'] : array();
    }

    /**
     * 获取用户作品集,包括未分类
     * @param type $username
     * @return type
     */
    public static function getPersonalWorklist($username)
    {
        //用户作品集
        $workurl = yii::$app->params['apiPersonalWorklistUrl'];
        $data['username'] = $username;
        $works = VsoApi::send($workurl, $data, "get");
        return isset($works['data']) ? $works['data'] : array();
    }
    /**
     * 获取用户未分类作品集下的作品
     * @param type $username
     * @return type
     */
    public static function getNoWorkListWork($username)
    {
        //用户作品集的作品
        $workurl = yii::$app->params['apiNoWorkListWorkUrl'];
        $data['username'] = $username;
        $works = VsoApi::send($workurl, $data, "get");
        return isset($works['data']) ? $works['data'] : array();
    }
    /**
     * 获取作品集创建者
     * @param type $id
     * @return string
     */
    public static function getWorklistOwner($id)
    {
        $worklist = self::getWorklistInfo($id);
        if (isset($worklist['username']) && !empty($worklist['username']))
        {
            return $worklist['username'];
        }
        return '';
    }
}