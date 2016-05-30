<?php

namespace backend\modules\user\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\api\VsoApi;
use common\models\User;
use app\modules\team\models\Team;

class UserController extends BaseController
{

    public $layout = 'layout';

    /**
     * 路由权限控制
     * @return array
     */
    public function limitActions()
    {
        return ['list', 'list-view', 'export'];
    }

    /**
     * 用户列表
     * @return type
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 用户数据
     */
    public function actionList()
    {
        if($this->isGet()){
            return $this->render('list');
        }
        $mdl = new User();
        $query = $mdl::find();
        $search = $this->_request('search');
        $page = $this->_request('page',  0);
        $pageSize = $this->_request('pageSize', 10);
        $offset = $page * $pageSize;
        $memTb = $mdl::tableName();
        $teamTb = Team::tableName();
        if ($search)
        {
            if (isset($search['uptimeStart'])) //时间范围
            {
                $query = $query->andWhere(['>', $memTb . '.created_at', strtotime($search['uptimeStart'])]);
            }
            if (isset($search['uptimeEnd'])) //时间范围
            {
                $query = $query->andWhere(['<', $memTb . '.created_at', strtotime($search['uptimeEnd'])]);
            }
            if (isset($search['grouptype'])) //时间范围
            {
                $query = $query->andWhere(['group_id' => $search['grouptype']]);
            }
            if (isset($search['filtertype']) && !empty($search['filtercontent']))
            {
                if ($search['filtertype'] == 2)//按照用户名称筛选
                {
                    $query = $query->andWhere(['like', $memTb . '.name', trim($search['filtercontent'])]);
                }
                elseif ($search['filtertype'] == 1)//按照用户ID筛选
                {
                    $query = $query->andWhere([$memTb . '.username' => trim($search['filtercontent'])]);
                }
            }
            if (isset($search['inputer']) && !empty($search['inputer']))
            {
                $query = $query->andWhere(['like', $teamTb . '.nickname', trim($search['filtercontent'])]);
            }
            if (isset($search['inputercompany'])) //筛选条件
            {
                $query = $query->andWhere([$teamTb . '.company_id' => $search['inputercompany']]);
            }
            if (isset($search['checkstatus'])) //筛选条件
            {
                $query->andWhere([$memTb . '.check_status' => $search['checkstatus']]);
            }
        }

        $_order_by = 'uid ASC';
        $userArr = $query
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $userList = ArrayHelper::toArray($userArr, [
            'common\models\User' => [
                'uid',
                'nick',
                'name',
                'mobile',
                'avatar',
                'email',
                'points',
                'wechat' => 'wechat_openid',
                'user_type' => function ($m) {
                    return User::_get_user_type($m->user_type);
                },
                'user_status' => function ($m) {
                    return User::_get_user_status($m->user_status);
                },
                'inputer' => function ($m) {
                    return '录入人';
                },
                'checker' => function ($m) {
                    return '审核人';
                },
                'create_at' => function ($m) {
                    return date('Y-m-d h:i:s', $m->create_at);
                },

            ],
        ]);
        
        $_data = [
            'userList' => $userList,
            'totalCount' => count($userList)
        ];
        exit(json_encode($_data));

    }




}
