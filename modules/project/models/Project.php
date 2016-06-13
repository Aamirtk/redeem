<?php

namespace frontend\modules\project\models;

use common\models\CommonProject;
use common\models\FilterWord;
use frontend\modules\talent\models\User;
use Yii;

class Project extends CommonProject
{
    /**
     * 获取推荐任务列表
     * @param string $type 推荐类型
     * @param int $limit
     * @return array
     */
    public static function getRecomProjs($type = '', $limit = null)
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
            ->orderBy(['listorder' => SORT_ASC]);
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
            $projs[$k]['member_list'] = ProjMember::getProjMembers($proj_id);
            $projs[$k]['user']['favor_status'] = ProjFavorite::getFavorStatus($proj_id);
            $user = User::getUserInfo($v['username']);
            $projs[$k]['user']['nickname'] = isset($user['nickname']) && !empty($user['nickname']) ? $user['nickname'] : '';
            $projs[$k]['user']['tag'] = isset($user['tag']) && !empty($user['tag']) ? $user['tag'] : '';
            $projs[$k]['user']['tag'] = str_replace(",", " | ", $projs[$k]['user']['tag']);
            $projs[$k]['user']['avatar'] = isset($user['avatar']) && !empty($user['avatar']) ? $user['avatar'] : '';
        }
        return $projs;
    }

    /**
     * 获取项目详情，包括项目成员列表
     * @param $proj_id 项目编号
     * @return array|static
     */
    public static function getProjDetail($proj_id)
    {
        if (empty($proj_id))
        {
            return [];
        }
        $project = self::find()->where(['proj_id' => $proj_id])->asArray()->one();
        if (empty($project))
        {
            return [];
        }
        $project['proj_tag'] = FilterWord::formatTag($project['proj_tag']);
        $project['member_list'] = ProjMember::getProjMembers($proj_id, null);
        $project['user']['favor_status'] = ProjFavorite::getFavorStatus($proj_id);
        $user = User::getUserInfo($project['username']);
        $project['user']['nickname'] = isset($user['nickname']) && !empty($user['nickname']) ? $user['nickname'] : '';
        $project['user']['tag'] = isset($user['tag']) && !empty($user['tag']) ? $user['tag'] : '';
        $project['user']['tag'] = FilterWord::formatTag($project['user']['tag']);
        $project['user']['avatar'] = isset($user['avatar']) && !empty($user['avatar']) ? $user['avatar'] : '';
        return $project;
    }

    public static function indexlimi()
    {
        $username = User::getLoginedUsername();
        $userarr = self::getUserArr();
        if (!in_array($username, $userarr))
        {
            return false;
        }
        else
        {
            return true;
        }
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
        return ['4', '5', '6', '7', '8', '9', '10', '11', '12', '14', '15', '16', '17', '18', '19'];
    }
}
