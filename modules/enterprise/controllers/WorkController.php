<?php

namespace frontend\modules\enterprise\controllers;

use frontend\modules\enterprise\models\CrmCompany;
use frontend\modules\enterprise\models\CrmIndustries;
use frontend\modules\enterprise\models\CrmWork;
use frontend\modules\talent\models\User;
use yii;
use yii\helpers\ArrayHelper;
use frontend\controllers\CommonController;
use common\api\VsoApi;
use common\models_shop\shop;

class WorkController extends CommonController
{
    public $enableCsrfValidation = false;
    public $layout = "/main_ent"; //设置使用的布局文件
    public $company = null;
    public $has_shop = false;

    public function beforeAction($action)
    {
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
     * 企业案例列表页 rj
     */
    public function actionList()
    {
        $username = $this->obj_username;
        //获取存在的案例分类
        $industryList = CrmWork::getListType(['username' => $username, 'status' => CrmWork::STATUS_ACTIVE], 'create_time desc', 'ptype');
        //下为所有一级分类
        //$industryList = Industry::getIndustryList();
        $crmInfo = CrmCompany::getCrmCompanyInfo($username);

        $data['username'] = $username;
        $data['name'] = $crmInfo['name'];
        $data['industryList'] = $industryList;
        return isMobile()?$this->render('mlist', $data):$this->render('list', $data);

    }

    /**
     * 获取企业案例列表 rj
     * username
     * page
     * pageSize
     */
    public function actionCaseList()
    {
        $param = Yii::$app->request->post();


        if ((isset($param['username']) && empty($param['username'])) || !isset($param['username']))
        {
            return $this->printError([], 10001);
        }
        if (!isset($param['type']))
        {
            return $this->printError([], 10001);
        }

        if ((isset($param['page']) && empty($param['page'])) || !isset($param['page']))
        {
            $param['page'] = 1;
        }

        $param['pageSize'] = isMobile()?yii::$app->params['ment_case_page_size']:yii::$app->params['ent_case_page_size'];

        $startNum = (intval($param['page']) - 1) * intval($param['pageSize']);
        $pageSize = $param['pageSize'];
        //获取版本案例
        $totalCount = 0;
        if ($param['type'] != 0)
        {
            $where = ['username' => $param['username'], 'ptype' => $param['type'], 'status' => CrmWork::STATUS_ACTIVE];
        }
        else
        {
            $where = ['username' => $param['username'], 'status' => CrmWork::STATUS_ACTIVE];
        }
        $list = CrmWork::getList($where, 'create_time desc', $totalCount, $startNum, $pageSize);

        $data['list'] = $list;
        $data['totalCount'] = ceil($totalCount / $pageSize);//总页数
        return $this->_echoJson($data);
    }

    /**
     * 点赞 rj
     * id
     * 以后可能还需要加限制
     * */
    public function actionZan()
    {
        $param = Yii::$app->request->post();

        if ((isset($param['id']) && empty($param['id'])) || !isset($param['id']))
        {
            return $this->printError([], 10001);
        }

        $data = CrmWork::getInfo(['id' => $param['id']]);
        if (!$data)
        {
            return $this->printError([], 10002);
        }

        $updateData['id'] = $data['id'];
        $updateData['zan'] = $data['zan'] + 1;
        $rst = CrmWork::setInfo($updateData);

        if ($rst)
        {
            return $this->printSuccess(['zan' => $updateData['zan']], 200);
        }
        else
        {
            return $this->printError([], 10000);
        }
    }

    /**
     * 获取热门案例
     * */
    public function actionHotList()
    {
        $param = Yii::$app->request->post();

        if ((isset($param['username']) && empty($param['username'])) || !isset($param['username']))
        {
            return $this->printError([], 10001);
        }
        $totalCount = 0;
        $list = CrmWork::getList(
            ['username' => $param['username'], 'status' => CrmWork::STATUS_ACTIVE],
            " create_time desc",
            $totalCount,
            0,
            4
        );
        return $this->_echoJson(["list" => $list]);
    }

    /**
     * 获取企业单个案例信息 rj
     * id
     */
    public function actionDetail()
    {
        $id = intval(yii::$app->request->get('id'));
        $model = CrmWork::getInfo(['id' => $id]);
        // 案例不存在或已删除，跳转用户企业主空间首页
        if (empty($model) || $model['status'] == CrmWork::STATUS_DELETED)
        {
            return $this->redirect(yii::$app->defaultRoute);
        }
        if($this->obj_username==yii::$app->params['rc_domain_prefix'])
        {
            @header('HTTP/1.1 301 Moved Permanently');
            header('Location:http://'.$model['username'].'.vsochina.com'.$_SERVER['REQUEST_URI']) ;
            exit;
        }
        elseif($this->obj_username!=$model['username'])
        {
            @header('HTTP/1.1 301 Moved Permanently');
            header("Location: http://www.vsochina.com");
            exit;            
        }        
        $nextModel = CrmWork::getInfo(['>', 'id', $id], "order asc,id asc", ['username' => $model['username'], 'status' => CrmWork::STATUS_ACTIVE]);

        $prevModel = CrmWork::getInfo(['<', 'id', $id], "order asc,id desc", ['username' => $model['username'], 'status' => CrmWork::STATUS_ACTIVE]);

        $this->company = CrmCompany::getInfo(['username' => $model['username'], 'status' => CrmCompany::STATUS_NORMAL]);

        //获取交易评价概况
        $dat['username'] = $model['username'];
        $evaluation = VsoApi::send(yii::$app->params['record_general_evaluation'], $dat, "get");

        $data['model'] = $model;
        $data['nextModel'] = $nextModel;
        $data['prevModel'] = $prevModel;
        $data['evaluation'] = ArrayHelper::getValue($evaluation, 'data', null);
        $data['vso_uname'] = User::getLoginedUsername();
        return isMobile() ? $this->render('mdetail', $data) : $this->render('detail', $data);
    }

    /**
     * ajax添加案例，post
     * work_name 案例名称，必填
     * work_price 类似服务价格，必填
     * work_url 缩略图地址，必填
     * ptype 所属行业，必填
     * work_type 案例类型（1=>图片，2=>视频，3文本），可选，默认图片
     * work_url 图片or视频地址，根据work_type区分
     */
    public function actionCreate()
    {
        $username=$this->obj_username;
        $this->layout = null;
        $post = yii::$app->request->post();
        if (empty($post))
        {
            return $this->render('create');
        }

        if (empty($username))
        {
            echo json_encode(['result' => false, 'msg' => '登录后才能进行此操作']);
            exit;
        }
        // 案例名称
        $work_name = trim(yii::$app->request->post('work_name'));
        if (empty($work_name))
        {
            echo json_encode(['result' => false, 'msg' => '请输入案例名称']);
            exit;
        }
        // 类似服务价格
        $work_price = yii::$app->request->post('work_price');
        if (empty($work_price))
        {
            echo json_encode(['result' => false, 'msg' => '请输入类似服务价格']);
            exit;
        }
        // 缩略图
        $work_url = trim(yii::$app->request->post('work_url'));
        if (empty($work_url))
        {
            echo json_encode(['result' => false, 'msg' => '请上传缩略图']);
            exit;
        }
        // 所属行业
        $ptype = trim(yii::$app->request->post('indus_pid'));
        if (empty($ptype))
        {
            echo json_encode(['result' => false, 'msg' => '请选择所属行业']);
            exit;
        }
        // 案例类型（1=>图片，2=>视频，3=>文本）
        $work_type = intval(yii::$app->request->post('work_type'));
        $work_type = empty($work_type) ? 1 : $work_type;

        $model = new CrmWork();
        $model->setAttributes([
            'username' => $username,
            'company_id' => CrmCompany::getCompanyidByUsername($username),
            'work_name' => $work_name,
            'work_price' => sprintf("%.2f", $work_price),
            'work_type' => $work_type,
            'ptype' => yii::$app->request->post('indus_pid'),
            'work_url' => $work_url
        ]);
        switch ($work_type)
        {
            case "1":   // 图片
                $work_url = trim(yii::$app->request->post('work_url'));
                if (empty($work_url))
                {
                    echo json_encode(['result' => false, 'msg' => '请上传图片地址']);
                    exit;
                }
                // 案例详情
                $content = trim(yii::$app->request->post('content'));
                if (empty($content))
                {
                    echo json_encode(['result' => false, 'msg' => '请输入案例简介']);
                    exit;
                }
                $model->setAttributes(['content' => $content]);
                break;
            case "2":   // 视频
            case "3": // 文本，content必填
                break;
        }
        if ($model->save())
        {
            CrmIndustries::createCrmIndus($model['username'], $ptype);
            echo json_encode(['result' => true, 'msg' => '添加案例成功']);
            exit;
        }
        else
        {
            echo json_encode(['result' => false, 'msg' => '添加案例失败']);
            exit;
        }
    }

    /**
     * ajax编辑案例，post
     * id 案例编号，必填
     * work_name 案例名称，必填
     * work_price 类似服务价格，必填
     * work_url 缩略图地址，必填
     * ptype 所属行业，必填
     * work_type 案例类型（1=>图片，2=>视频，3文本），可选，默认图片
     * work_url 图片or视频地址，根据work_type区分
     */
    public function actionUpdate()
    {
        $id = yii::$app->request->get('id');
        $this->layout = null;
        $model = CrmWork::find()->where(['id' => $id])->one();
        $post = yii::$app->request->post();

        if (empty($post))
        {
            return $this->render('update', ['model' => $model]);
        }
        if (empty($model))
        {
            echo json_encode(['result' => false, 'msg' => '案例不存在']);
            exit;
        }
        $username = $this->obj_username;
        if (empty($username))
        {
            echo json_encode(['result' => false, 'msg' => '登录后才能进行此操作']);
            exit;
        }
        if ($model['username']!=$username)
        {
            echo json_encode(['result' => false, 'msg' => '您没有编辑该案例的权限']);
            exit;
        }
        // 案例名称
        $work_name = trim(yii::$app->request->post('work_name'));
        if (empty($work_name))
        {
            echo json_encode(['result' => false, 'msg' => '请输入案例名称']);
            exit;
        }
        // 类似服务价格
        $work_price = yii::$app->request->post('work_price');
        if (empty($work_price))
        {
            echo json_encode(['result' => false, 'msg' => '请输入类似服务价格']);
            exit;
        }
        // 缩略图
        $work_url = trim(yii::$app->request->post('work_url'));
        if (empty($work_url))
        {
            echo json_encode(['result' => false, 'msg' => '请上传案例封面']);
            exit;
        }
        // 所属行业
        $ptype = trim(yii::$app->request->post('indus_pid'));
        if (empty($ptype))
        {
            echo json_encode(['result' => false, 'msg' => '请选择所属行业']);
            exit;
        }
        // 案例类型（1=>图片，2=>视频，3=>文本）
        $work_type = intval(yii::$app->request->post('work_type'));
        $work_type = empty($work_type) ? 1 : $work_type;

        $model->setAttributes([
            'work_name' => $work_name,
            'work_price' => sprintf("%.2f", $work_price),
            'work_type' => $work_type,
            'ptype' => yii::$app->request->post('indus_pid'),
            'work_url' => $work_url,
            'updated_at' => time()
        ]);
        switch ($work_type)
        {
            case "1":   // 图片
                $work_url = trim(yii::$app->request->post('work_url'));
                if (empty($work_url))
                {
                    echo json_encode(['result' => false, 'msg' => '请上传图片地址']);
                    exit;
                }
                // 案例详情
                $content = trim(yii::$app->request->post('content'));
                if (empty($content))
                {
                    echo json_encode(['result' => false, 'msg' => '请输入案例简介']);
                    exit;
                }
                $model->setAttributes(['content' => $content]);
                break;
            case "2":   // 视频
            case "3": // 文本，content必填
                break;
        }
        if ($model->save())
        {
            CrmIndustries::createCrmIndus($model['username'], $ptype);
            echo json_encode(['result' => true, 'msg' => '编辑案例成功']);
            exit;
        }
        else
        {
            echo json_encode(['result' => false, 'msg' => '编辑案例失败']);
            exit;
        }
    }

    /**
     * ajax删除案例，post
     * id 案例编号，必填
     */
    public function actionDelete()
    {
        $id = yii::$app->request->post('id');
        if (empty($id))
        {
            echo json_encode(['result' => false, 'msg' => '缺少案例编号']);
            exit;
        }
        $model = CrmWork::find()->where(['id' => $id])->one();
        if (empty($model))
        {
            echo json_encode(['result' => false, 'msg' => '案例不存在，无法删除']);
            exit;
        }
        $username = $this->obj_username;
        if (empty($username))
        {
            echo json_encode(['result' => false, 'msg' => '登录后才能进行此操作']);
            exit;
        }
        if ($model['username']!=$username)
        {
            echo json_encode(['result' => false, 'msg' => '您没有删除该案例的权限']);
            exit;
        }
        $model->setAttributes([
            'status' => CrmWork::STATUS_DELETED,
            'updated_at' => time()
        ]);
        if ($model->save())
        {
            echo json_encode(['result' => true, 'msg' => '删除案例成功']);
            exit;
        }
        else
        {
            echo json_encode(['result' => false, 'msg' => '删除案例失败']);
            exit;
        }
    }
}