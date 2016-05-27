<?php

namespace backend\modules\user\controllers;

use Yii;
use app\base\CommonWebController;
use common\api\VsoApi;

class UserController extends CommonWebController
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
        $search = $this->getHttpParam('search', false, null);
        $page = $this->getHttpParam('page', false, 0);
        $pageSize = $this->getHttpParam('pageSize', false, 10);
        $offset = $page * $pageSize;
        $res = VsoApi::send(yii::$app->params['usersearchapi'], ['search' => $search, 'offset' => $offset, 'pageSize' => $pageSize], "post");
        $this->printSuccess($res);
    }

    /**
     * 导出用户数据
     */
    public function actionExport()
    {
        $search['s_condition'] = $this->getHttpParam('hide_condition', false, null);
        $search['s_condition_value'] = $this->getHttpParam('s_condition_value', false, null);
        $search['status'] = $this->getHttpParam('s_status_value', false, null);
        $search['group_id'] = $this->getHttpParam('s_group_value', false, null);
        $search['auth_type'] = $this->getHttpParam('s_auth_value', false, null);
        $res = VsoApi::send(yii::$app->params['usersearchapi'], ['search' => $search,'offset'=>0,'pageSize'=>1000], "post");
        // 输出列名信息
        $head = array('用户名', '昵称', '邮箱', '手机号', '账户状态', '创建时间',
            '会员特权', '特权到期日', '认证状态', '人才状态', '店铺状态', '最近登录时间');
        foreach ($head as $i => $v)
        {
            $head[$i] = iconv('utf-8', 'gbk', $v);
        }
        $headline = implode(',', $head);
        $users = $res['users'];
//        // 计数器
//        $cnt = 0;
//        // 每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
//        $limit = 500;
        // 逐行取出数据，不浪费内存,暂时1000条
        $count = $res['totalCount']>1000?1000:$res['totalCount'];
        $str = '';
        for ($t = 0; $t < $count; $t++)
        {
//            $cnt ++;
//            if ($limit == $cnt)
//            { //刷新一下输出buffer，防止由于数据过多造成问题
//                ob_flush();
//                flush();
//                $cnt = 0;
//            }
            $row = $users[$t];
            foreach ($row as $i => $v)
            {
                if ($i == 'status')
                {
                    $v = $v == 1 ? '已激活' : '未激活';
                }
                if ($i == 'create_time')
                {
                    $v = $v > 0 ? date('Y-m-d', $v) : '';
                }
                if ($i == 'last_login_time')
                {
                    $v = $v > 0 ? date('Y-m-d', $v) : '';
                }
                if ($i == 'valid_end')
                {
                    $v = $v == '无限期' ? '无限期' : date('Y-m-d', $v);
                }
                if ($i == 'group_id')
                {
                    continue;
                }
                $detail[] = $v ? iconv('utf-8', 'gbk', $v) : '';
            }
            $detailline = implode(',', $detail);
            $str.=$detailline . "\r\n";
            unset($row);
            unset($detail);
        }
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=user.csv");
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        echo $headline . "\r\n" . $str;
    }

}
