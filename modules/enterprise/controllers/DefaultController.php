<?php

namespace frontend\modules\enterprise\controllers;

use frontend\controllers\CommonController;
use frontend\modules\enterprise\models\CrmCompany;
use yii;
use frontend\modules\enterprise\models\CrmWork;
use frontend\modules\enterprise\models\News;
use common\lib\CropAvatar;
use common\models_shop\shop;

class DefaultController extends CommonController
{
    public $enableCsrfValidation = false;
    public $layout = "/main_ent"; //设置使用的布局文件
    public $company = null;
    public $has_shop = false;

    public function beforeAction($action)
    {
        //obj_name 被访问的用户名
        $company = CrmCompany::getInfo(['username' => $this->obj_username, 'status' => CrmCompany::STATUS_NORMAL]);
        if(!$company['logo']){
            $company['logo'] = $this->getAvatar($this->obj_username);
        }
        // 被访问用户
        $this->company = $company;
        //判断是否开通店铺或者店铺
        $this->has_shop = shop::_get_user_has_shop($this->obj_username);
        return parent::beforeAction($action);
    }


    /**
     * 企业主空间首页 rj
     * */
    public function actionIndex()
    {
        $username = $this->obj_username;
        $pageSize = isMobile() ? yii::$app->params['ment_case_index_page_size'] : yii::$app->params['ent_case_index_page_size'];
        $list = CrmWork::getList(
            ['username' => $username, 'status' => CrmWork::STATUS_ACTIVE],
            ['order' => SORT_DESC, 'create_time' => SORT_DESC],
            $totalCount,
            0,
            $pageSize
        );

        $newslist = News::getList(
            [
                'obj_id' => $this->company['id'],
                'obj_type' => News::OBJ_TYPE
            ],
            ['listorder' => SORT_ASC, 'created_at' => SORT_DESC], 0, 6
        );
        $data['list'] = $list;
        $data['newslist'] = $newslist;
        $data['username'] = $username;
        $data['avatar'] = $username;
        return isMobile() ? $this->render('mindex', $data) : $this->render('index', $data);
    }

    /**
     * 修改公司基本信息
     */
    public function actionEditCompany()
    {
        $login_username = $this->obj_username;

        $id = yii::$app->request->post('id');
        if (empty($id))
        {
            echo json_encode(['result' => false, 'msg' => '缺少公司编号']);
            exit;
        }
        $obj = CrmCompany::findOne(['id' => $id, 'status' => CrmCompany::STATUS_NORMAL]);
        if (!$obj)
        {
            echo json_encode(['result' => false, 'msg' => '该公司不存在']);
            exit;
        }
        $username = $obj['username'];
        //验证权限
        if($login_username!=$username){
            echo json_encode(['result' => false, 'msg' => '权限不够']);
            exit;
        }

        // 企业简介
        $description = yii::$app->request->post('description');
        if (isset($description))
        {
            $data['description'] = $description;
        }

        // logo
        $logo = trim(yii::$app->request->post('logo'));
        if (!empty($logo))
        {
            $data['logo'] = $logo;
        }
        // banner
        $banner = trim(yii::$app->request->post('banner'));
        if (!empty($banner))
        {
            $data['banner'] = $banner;
        }
        // 交易记录是否显示（1=>显示，其它不显示）
        $record_is_show=yii::$app->request->post('record_is_show');
        if(!empty($record_is_show))
        {
            $data['record_is_show'] = intval($record_is_show);
        }
        // 更新时间
        $data['update_time'] = time();

        $rst = $obj->updateAll($data, ['id'=>$id]);

        if ($rst)
        {
            return $this->printSuccess(['data' => $data], 200);
        }
        else
        {
            return $this->printError([], 10000);
        }
    }

    /**
     * 上传回调方法
     * */
    public function actionUploadSuccess(){
        $workfile = $_GET['workfile'] ? urldecode($_GET['workfile']) : '';
        $action_to = yii::$app->request->get('action')? yii::$app->request->get('action') : 'setfileurlfromcallback';
        if ($workfile) {
            echo "<script>window.parent." . $action_to . "('$workfile');</script>";
            exit();
        }
    }
}
