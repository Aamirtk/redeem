<?php
namespace frontend\modules\personal\models;

use yii;
use common\api\VsoApi;

class Work
{
    /**
     * 获取作品的创建人
     * @param $work_id
     * @return string
     */
    public static function getWorkOwner($work_id)
    {
        $work = self::getWorkDetail($work_id);
        if (isset($work['username']) && !empty($work['username']))
        {
            return $work['username'];
        }
        return '';
    }

    /**
     * 获取作品详情
     * @param $work_id
     * @return array
     */
    public static function getWorkDetail($work_id)
    {
        if (empty($work_id)) {
            return [];
        }
        $redis = yii::$app->redis;
        $data = json_decode($redis->get('rc:workdetail:work_id:' . $work_id), true);
        $apiFlag = $redis->get('rc:workdetailflag:work_id:' . $work_id);
        if (empty($data) || $apiFlag) {
            $url = "https://api.vsochina.com/work/work/view";
            $data = [
                'workid' => $work_id,
                'size' => 'middle'
            ];
            $curl_result = VsoApi::send($url, $data, 'get');
            if (isset($curl_result['data'])) {
                $data = $curl_result['data'];
                $redis->set('rc:workdetail:work_id:' . $work_id, json_encode($data));
                $redis->expire('rc:workdetail:work_id:' . $work_id, yii::$app->params['workExpireTime']);
                $redis->set('rc:workdetailflag:work_id:' . $work_id, false);
            }
        }
        return $data ? $data : [];
    }

    /**
     * 获取作品的评论列表
     * @param $work_id
     * @return array
     */
    public static function getWorkCommentList($work_id, $offset = 0, $limit = 10)
    {
        if (empty($work_id))
        {
            return [];
        }
        $url = "https://api.vsochina.com/comment/get-comment-list";
        $data = [
            'objid' => $work_id,
            'objtype' => 'works',
            'offset' => $offset,
            'limit' => $limit
        ];
        $curl_result = VsoApi::send($url, $data, 'get');
        if (isset($curl_result['data']))
        {
            return $curl_result['data'];
        }
        return [];
    }

    /*
     * 添加作品
     * @param $data
     * @return array|Boolean
     */
    public static function _add_work($data)
    {
        if (empty($data))
        {
            return false;
        }
        $url = "http://api.vsochina.com/work/work/create";
        $_api_result = VsoApi::send($url, $data, 'post');
        if ($_api_result['ret'] == '13660')
        {
            return $_api_result;
        }
        return false;
    }

    /*
     * 查找作品
     * @param $work_id
     * @return Boolean|Array
     */
    public static function _get_work($work_id)
    {
        if (empty($work_id))
        {
            return false;
        }
        $data = [
            'workid' => $work_id,
        ];
        $url = "http://api.vsochina.com/work/work/get-work-info";
        $_api_result = VsoApi::send($url, $data, 'get');
        if ($_api_result['ret'] == '13620')
        {
            return $_api_result;
        }
        return false;
    }

    /*
     * 更新作品
     * @param $data
     */
    public static function _update_work($data)
    {
        if(empty($data)){
            return false;
        }

        $url = "http://api.vsochina.com/work/work/update";
        $_api_result = VsoApi::send($url, $data, 'post');
        if ($_api_result['ret'] == '13670')
        {
            $redis=yii::$app->redis;
            $redis->set('rc:workdetailflag:work_id:'.$data['workid'],true);
            return $_api_result;
        }
        return false;
    }
}