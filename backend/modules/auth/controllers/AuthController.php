<?php

namespace backend\modules\auth\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\api\VsoApi;
use common\models\User;
use common\models\Auth;
use app\modules\team\models\Team;

class AuthController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;
    public $checker_id = '';

    /**
     * 放置需要初始化的信息
     */
    public function init()
    {
        //后台登录人员ID
        $this->checker_id = Yii::$app->user->identity->uid;
    }

    /**
     * 路由权限控制
     * @return array
     */
    public function limitActions()
    {
        return [
            'list',
            'list-view',
            'export',
            'info',
            'update',
            'ajax-save',
            'ajax-check',
        ];
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
        if ($this->isGet()) {
            return $this->render('list');
        }
        $mdl = new Auth();
        $query = $mdl::find();
        $search = $this->_request('search');
        $page = $this->_request('page', 0);
        $pageSize = $this->_request('pageSize', 10);
        $offset = $page * $pageSize;
        $memTb = $mdl::tableName();
        $teamTb = Team::tableName();
        if ($search) {
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
            if (isset($search['filtertype']) && !empty($search['filtercontent'])) {
                if ($search['filtertype'] == 2)//按照用户名称筛选
                {
                    $query = $query->andWhere(['like', $memTb . '.name', trim($search['filtercontent'])]);
                } elseif ($search['filtertype'] == 1)//按照用户ID筛选
                {
                    $query = $query->andWhere([$memTb . '.username' => trim($search['filtercontent'])]);
                }
            }
            if (isset($search['inputer']) && !empty($search['inputer'])) {
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

        $_order_by = 'auth_id ASC';
        $userArr = $query
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $authList = ArrayHelper::toArray($userArr, [
            'common\models\Auth' => [
                'auth_id',
                'nick',
                'name',
                'mobile',
                'avatar',
                'email',
                'auth_status',
                'wechat' => 'wechat_openid',
                'user_type' => function ($m) {
                    return User::_get_user_type($m->user_type);
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
            'userList' => $authList,
            'totalCount' => count($authList)
        ];
        exit(json_encode($_data));
    }

    /**
     * 改变用户状态
     * @return array
     */
    function actionAjaxCheck()
    {

        $auth_id = intval($this->_request('auth_id'));
        $auth_status = intval($this->_request('auth_status'));
        $reason = trim($this->_request('reason'));

        //检验参数是否合法
        if (empty($auth_id)) {
            $this->_json(-20001, '审核编号id不能为空');
        }
        if (!in_array($auth_status, [Auth::CHECK_PASS, Auth::CHECK_UNPASS])) {
            $this->_json(-20002, '审核状态错误');
        }

        //保存状态及原因
        $reslut = Auth::_save_check($auth_id, $auth_status, $reason);

        $this->_json($reslut['code'], $reslut['msg']);
    }

    /**
     * 加载用户详情
     * @return array
     */
    function actionInfo()
    {
        $auth_id = intval($this->_request('auth_id'));

        $mdl = new User();
        //检验参数是否合法
        if (empty($auth_id)) {
            $this->_json(-20001, '用户编号id不能为空');
        }

        //检验用户是否存在
        $user = $mdl->_get_info(['auth_id' => $auth_id]);
        if (!$user) {
            $this->_json(-20003, '用户信息不存在');
        }
        $user['auth_status'] = User::_get_auth_status($user['auth_status']);
        $user['user_type'] = User::_get_user_type($user['user_type']);
        $user['update_at'] = date('Y-m-d h:i:s', $user['update_at']);
        $user['create_at'] = date('Y-m-d h:i:s', $user['create_at']);
        $_data = [
            'user' => $user
        ];
        return $this->render('info', $_data);
    }



}
