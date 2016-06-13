<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\api\VsoApi;
use common\models\User;
use common\models\Auth;


class MyController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;


    /**
     * 用户列表
     * @return type
     */
    public function actionIndex()
    {
        return $this->render('index');
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
        $mdl = new User();
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
                'name_card',
                'email',
                'points',
                'wechat' => 'wechat_openid',
                'user_type' => function ($m) {
                    return User::_get_user_type($m->user_type);
                },
                'user_status' => function ($m) {
                    return User::_get_user_status($m->user_status);
                },
                'status' => 'user_status',
                'inputer' => function ($m) {
                    return '录入人';
                },
                'checker' => function ($m) {
                    return '审核人';
                },
                'update_at' => function ($m) {
                    return date('Y-m-d h:i:s', $m->update_at);
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

    /**
     * 改变用户状态
     * @return array
     */
    function actionAjaxChangeStatus()
    {
        $uid = intval($this->_request('uid'));
        $status = intval($this->_request('status'));

        $mdl = new User();
        //检验参数是否合法
        if (empty($uid)) {
            $this->_json(-20001, '用户编号id不能为空');
        }
        if (!in_array($status, [$mdl::IS_DELETE, $mdl::NO_DELETE])) {
            $this->_json(-20002, '用户状态错误');
        }

        //检验用户是否存在
        $user = $mdl->_get_info(['uid' => $uid]);
        if (!$user) {
            $this->_json(-20003, '用户信息不存在');
        }

        if ($status == $mdl::NO_DELETE) {
            $rst = $mdl->_save([
                'uid' => $uid,
                'user_status' => $mdl::NO_DELETE,
                'update_at' => time(),
            ]);
            if (!$rst) {
                $this->_json(-20004, '用户信息保存失败');
            }
        } else {
            $rst = $mdl->_save([
                'uid' => $uid,
                'user_status' => $mdl::IS_DELETE,
                'update_at' => time(),
            ]);
            if (!$rst) {
                $this->_json(-20005, '用户信息保存失败');
            }
        }

        $this->_json(20000, '保存成功！');
    }

    /**
     * 加载用户详情
     * @return array
     */
    function actionInfo()
    {
        $uid = intval($this->_request('uid'));

        $mdl = new User();
        //检验参数是否合法
        if (empty($uid)) {
            $this->_json(-20001, '用户编号id不能为空');
        }

        //检验用户是否存在
        $user = $mdl->_get_info(['uid' => $uid]);
        if (!$user) {
            $this->_json(-20003, '用户信息不存在');
        }
        $user['user_status'] = User::_get_user_status($user['user_status']);
        $user['user_type'] = User::_get_user_type($user['user_type']);
        $user['update_at'] = date('Y-m-d h:i:s', $user['update_at']);
        $user['create_at'] = date('Y-m-d h:i:s', $user['create_at']);
        $_data = [
            'user' => $user
        ];
        return $this->render('info', $_data);
    }

    /**
     * 编辑用户信息
     * @return array
     */
    function actionUpdate()
    {
        $uid = intval($this->_request('uid'));

        $mdl = new User();
        //检验参数是否合法
        if (empty($uid)) {
            $this->_json(-20001, '用户编号id不能为空');
        }

        //检验用户是否存在
        $user = $mdl->_get_info(['uid' => $uid]);
        if (!$user) {
            $this->_json(-20003, '用户信息不存在');
        }

        $_data = [
            'user' => $user
        ];
        return $this->render('edit', $_data);
    }

    /**
     * 编辑用户信息
     * @return array
     */
    function actionAjaxSave()
    {
        $uid = intval($this->_request('uid'));
        $email = trim($this->_request('email'));
        $mobile = trim($this->_request('mobile'));

        $mdl = new User();
        //检验参数是否合法
        if (empty($uid)) {
            $this->_json(-20001, '用户编号id不能为空');
        }
        if (empty($email)) {
            $this->_json(-20002, '电子邮箱不能为空');
        }
        if (empty($mobile)) {
            $this->_json(-20003, '用户手机号码不能为空');
        }

        //检验用户是否存在
        $user = $mdl->_get_info(['uid' => $uid]);
        if (!$user) {
            $this->_json(-20004, '用户信息不存在');
        }

        $rst = $mdl->_save([
            'uid' => $uid,
            'email' => $email,
            'mobile' => $mobile,
            'update_at' => time(),
        ]);
        if (!$rst) {
            $this->_json(-20005, '用户信息保存失败');
        }

        $this->_json(20000, '用户信息保存成功！');
    }






}
