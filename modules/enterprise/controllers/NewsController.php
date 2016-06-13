<?php

namespace frontend\modules\enterprise\controllers;

use frontend\controllers\CommonController;
use frontend\modules\enterprise\models\CrmCompany;
use frontend\modules\enterprise\models\News;
use frontend\modules\talent\models\User;
use yii;
use common\models_shop\shop;

class NewsController extends CommonController
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
     * 获取热门新闻
     * */
    public function actionHotList()
    {
        $param = Yii::$app->request->post();

        if (!isset($param['obj_id']) || empty($param['obj_id']))
        {
            return $this->printError([], 10001);
        }
        $list = News::getList(['obj_id' => $param['obj_id'], 'obj_type' => News::OBJ_TYPE], ['listorder' => SORT_ASC, 'created_at' => SORT_DESC], 0, 20);

        return $this->_echoJson(["list" => $list]);
    }

    /**
     * 新闻详情页
     * */
    public function actionDetail()
    {
        $id=yii::$app->request->get('id');
        $model = News::getInfo(['id' => $id]);
        if (empty($model))
        {
            return $this->redirect(yii::$app->defaultRoute);
        }
        $this->company =  CrmCompany::getInfo(['id' => $model['obj_id'], 'status' => CrmCompany::STATUS_NORMAL]);
        if($this->obj_username==yii::$app->params['rc_domain_prefix'])
        {
            @header('HTTP/1.1 301 Moved Permanently');
            header('Location:http://'.$this->company['username'].'.vsochina.com'.$_SERVER['REQUEST_URI']) ;
            exit;
        }
        elseif($this->obj_username!=$this->company['username'])
        {
            @header('HTTP/1.1 301 Moved Permanently');
            header("Location: http://www.vsochina.com");
            exit;            
        }         
        $prevModel = News::getInfo(
            ['>', 'id', $id],
            "listorder asc,id asc",
            ['obj_type' => News::OBJ_TYPE, 'obj_id' => $model['obj_id']]
        );

        $nextModel = News::getInfo(
            ['<', 'id', $id],
            "listorder asc,id desc",
            ['obj_type' => News::OBJ_TYPE, 'obj_id' => $model['obj_id']]
        );

        // 是否已登录
        $user = $this->user_info;

        $data['model'] = $model;
        $data['nextModel'] = $nextModel;
        $data['prevModel'] = $prevModel;
        $data['user'] = $user;
        return $this->render('detail', $data);
    }

    /**
     * 企业动态 rj
     * */
    public function actionDynamic()
    {
        $username = $this->obj_username;
        $newslist = News::getList(
            ['obj_id' => $this->company['id'], 'obj_type' => News::OBJ_TYPE],
            ['listorder' => SORT_ASC, 'created_at' => SORT_DESC]
        );

        $data['username'] = $username;
        $data['newslist'] = $newslist;
        return $this->render('dynamic', $data);
    }

    /**
     * ajax添加新闻动态，post
     * title 标题，必填
     * content 新闻详情，必填
     * listorder 排序，可选，默认为0
     */
    public function actionCreate()
    {
        // 用户是否登录
        $login_username = $this->obj_username;
        if (empty($login_username))
        {
            echo json_encode(['result' => false, 'msg' => '登录后才能进行此操作']);
            exit;
        }
        // 公司是否存在
        $obj_id = trim(yii::$app->request->post('obj_id'));
        $this->company =  CrmCompany::getInfo(['id' => $obj_id, 'status' => CrmCompany::STATUS_NORMAL]);
        if (empty($this->company))
        {
            echo json_encode(['result' => false, 'msg' => '入驻后才能进行此操作']);
            exit;
        }
        $title = trim(yii::$app->request->post('title'));
        if (empty($title))
        {
            echo json_encode(['result' => false, 'msg' => '请输入动态标题']);
            exit;
        }
        $content = trim(yii::$app->request->post('content'));
        if (empty($content))
        {
            echo json_encode(['result' => false, 'msg' => '请输入动态详情']);
            exit;
        }
        $username = $this->company['username'];
        //验证权限
        if($login_username!=$username){
            echo json_encode(['result' => false, 'msg' => '权限不够']);
            exit;
        }

        // 添加动态
        $model = new News();
        $model->setAttributes([
            'title' => $title,
            'obj_type' => News::OBJ_TYPE,
            'listorder' => intval(yii::$app->request->post('listorder')),
            'content' => $content,
            'obj_id' => $obj_id
        ]);
        if ($model->save())
        {
            echo json_encode(['result' => true, 'msg' => '动态添加成功', 'id' => $model['id']]);
            exit;
        }
        else
        {
            echo json_encode(['result' => false, 'msg' => '动态添加失败']);
            exit;
        }
    }

    /**
     * ajax编辑新闻动态，post
     * id 动态编号，必填
     * title 标题，必填
     * content 新闻详情，必填
     * listorder 排序，可选，默认为0
     */
    public function actionUpdate()
    {
        // 用户是否登录
        $login_username = User::getLoginedUsername();
        if (empty($login_username))
        {
            echo json_encode(['result' => false, 'msg' => '登录后才能进行此操作']);
            exit;
        }
        // 动态编号
        $id = yii::$app->request->post('id');
        if (empty($id))
        {
            echo json_encode(['result' => false, 'msg' => '缺少动态编号']);
            exit;
        }
        // 数据是否存在
        $model = News::find()->where(['id' => $id])->one();
        if (empty($model))
        {
            echo json_encode(['result' => false, 'msg' => '该数据不存在']);
            exit;
        }
        // 标题
        $title = trim(yii::$app->request->post('title'));
        if (empty($title))
        {
            echo json_encode(['result' => false, 'msg' => '请输入动态标题']);
            exit;
        }
        // 内容
        $content = trim(yii::$app->request->post('content'));
        if (empty($content))
        {
            echo json_encode(['result' => false, 'msg' => '请输入动态详情']);
            exit;
        }

        $this->company =  CrmCompany::getInfo(['id' => $model['obj_id'], 'status' => CrmCompany::STATUS_NORMAL]);
        $username = $this->company['username'];
        //验证权限
        if(!CrmCompany::isUserSelf($username)){
            echo json_encode(['result' => false, 'msg' => '权限不够']);
            exit;
        }

        // 编辑动态
        $model->setAttributes([
            'title' => $title,
            'listorder' => intval(yii::$app->request->post('listorder')),
            'content' => $content,
            'updated_at' => time()
        ]);
        if ($model->save())
        {
            echo json_encode(['result' => true, 'msg' => '动态编辑成功']);
            exit;
        }
        else
        {
            echo json_encode(['result' => false, 'msg' => '动态编辑失败']);
            exit;
        }
    }

    /**
     * ajax删除动态，post
     * id 企业动态编号，必填
     */
    public function actionDelete()
    {
        // 动态编号
        $id = yii::$app->request->post('id');
        if (empty($id))
        {
            echo json_encode(['result' => false, 'msg' => '缺少动态编号']);
            exit;
        }
        // 数据是否存在
        $model = News::find()->where(['id' => $id])->one();
        $this->company =  CrmCompany::getInfo(['id' => $model['obj_id'], 'status' => CrmCompany::STATUS_NORMAL]);
        $username = $this->company['username'];
        //验证权限
        if($this->obj_username!=$username){
            echo json_encode(['result' => false, 'msg' => '权限不够']);
            exit;
        }
        if (empty($model))
        {
            echo json_encode(['result' => false, 'msg' => '删除失败，该数据不存在']);
            exit;
        }
        if ($model->delete())
        {
            echo json_encode(['result' => true, 'msg' => '动态删除成功']);
            exit;
        }
        else
        {
            echo json_encode(['result' => false, 'msg' => '动态删除失败']);
            exit;
        }
    }

    /**
     * 新闻编辑页面
     * */
    public function actionEdit($id){
        // 用户是否登录
        $login_username = $this->obj_username;
        if (empty($login_username))
        {
            //跳转登录页
            return $this->redirect( yii::$app->params['loginUrl']);
        }

        // 数据是否存在
        $model = News::find()->where(['id' => $id])->one();
        $this->company =  CrmCompany::getInfo(['id' => $model['obj_id'], 'status' => CrmCompany::STATUS_NORMAL]);

        $username = $this->company['username'];
        if (empty($model) || $login_username!=$username)
        {
            //跳转错误页
            //throw new yii\base\Exception("用户不存在或者权限不够");
            return $this->redirect(['default/index', 'username' => $username]);
        }

        $data = [];
        $data['model'] = $model;

        return $this->render('edit', $data);
    }
    /**
     * 新闻新增页面
     * */
    public function actionAdd($username){
        // 用户是否登录
        $login_username = User::getLoginedUsername();
        if (empty($login_username))
        {
            //跳转登录页
            return $this->redirect( yii::$app->params['loginUrl']);
        }
        if (!$this->is_self)
        {
            //跳转错误页
            //throw new yii\base\Exception("用户不存在或者权限不够");
            return $this->redirect(['default/index', 'username' => $username]);
        }

        $data = [];
        $data['model'] = null;
        return $this->render('edit', $data);
    }
}
