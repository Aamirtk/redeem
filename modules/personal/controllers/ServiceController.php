<?php
/**
 * 服务详情-个人空间
 * User: Huangbo
 * Date: 2016/3/1
 * Time: 15:24
 */
namespace frontend\modules\personal\controllers;

use frontend\controllers\CommonController;
use frontend\modules\personal\models\Person;
use frontend\modules\personal\models\Service;
use yii;
use yii\helpers\ArrayHelper;
use frontend\modules\talent\models\User;
use common\models_shop\shop_praises;
use common\models_shop\shop_collections;
use common\models_shop\shop_comments;
use frontend\modules\personal\models\Skin;
use common\lib\Industry;

class ServiceController extends CommonController {
    public $enableCsrfValidation = false;
    public $layout               = 'default';
    public $obj_username         = "";  // 被访问用户的用户名
    public $vso_uname            = '';          // 当前登录用户
    public $is_self              = false;    // 被访问用户是否是当前登录用户
    public $user_info            = array();  // 被访问用户信息

    public function beforeAction($action) {
        $param = Yii::$app->request->isGet ? Yii::$app->request->get() : Yii::$app->request->post();
        // 被访问用户;

        if (isset($param['username']) && !empty($param['username'])) {
            $this->obj_username = $param['username'];
        } else if (isset($param['id']) && !empty($param['id'])) {
            $this->obj_username = Service::getUsernameByServiceId($param['id']);
        }
        // 被访问用户详情
        $user_info = Person::getUserInfo($this->obj_username);
        $this->user_info = $user_info;
        //登录用户
        $this->vso_uname = User::getLoginedUsername();
        //是否是用户自己
        $this->is_self = ($this->vso_uname == $this->obj_username);
        return parent::beforeAction($action);
    }

    /**
     * 用户可售服务列表页
     * @username string 用户平台注册ID
     * @return array
     */
    public function actionIndex($username) {
        $serviceArr = Service::find()
            ->where('username = :username', [':username' => $username])
            ->andWhere(" status = '2' ")
            ->andWhere(" is_delete = '2' ")
            ->all();
        $service = ArrayHelper::toArray($serviceArr, [
            'frontend\modules\personal\models\Service' => [
                'service_id',
                'name',
                'description',
                'price',
                'thumb',
                'category' => function($m){
                    return Industry::getNodeInfo($m->c_id, false);
                },
            ],
        ]);
        $_data = [
            'services' => $service,
            'columnWidth' => Skin::getPerIndexWidth($username),
        ];
        return $this->render('index', $_data);
    }

    /**
     * 用户可售服务详情页
     * @id int 服务ID
     * @return array
     */
    public function actionView($id) {
        $service = Service::find()
            ->where(['service_id' => $id])
            ->one();
        if(!$service || $service->status != '2'|| $service->is_delete != '2' || $service->shop->status == '2'){
            $this->redirect(Yii::$app->params['frontendurl'] . '/message/goods/?msg=');
        }
        $pageSize = Yii::$app->params['goods_comment_pagesize'];
        //获取详情页所需参数
        $comments = shop_comments::getComments([
            'obj_id' => $service->service_id,
            'p_id' => 0,
            'type' => shop_comments::COMMENT_SERVICE],
            0,
            $pageSize
        );
        $besides = Service::getServiceBesides($id);
        //企业认证状态
        $ent_auth_status = Service::_get_user_auth_status($this->vso_uname)['ent_auth_status'];
        //改变服务表记录
        Service::updateField('views_num', $id, $service->views_num + 1) ? false : $this->printError();
        $_data = [
            'service' => $service,
            'besides' => $besides,
            'comments' => $comments,
            'comment_type' => shop_comments::COMMENT_SERVICE,
            'pageSize' => $pageSize,
            'user_info' => $this->user_info,
            'ent_auth_status' => $ent_auth_status,
        ];
        return $this->render('detail', $_data);
    }

    /**
     * 异步获取服务的评论列表
     * @id int page 页码
     * @id int service_id 服务编号
     * @return json
     */
    public function actionAjaxLoadComments() {
        $service_id = intval($this->getHttpParam('service_id', false, 0));
        $page = intval($this->getHttpParam('page', false, 1));
        $page = max($page, 1);
        $pageSize = Yii::$app->params['service_comment_pagesize'];
        $offset = ($page - 1) * $pageSize;
        $comments = shop_comments::getComments(['obj_id' => $service_id, 'p_id' => 0, 'type' => shop_comments::COMMENT_SERVICE], $offset, $pageSize);
        $totalNum = shop_comments::getCommentsNum(['obj_id' => $service_id, 'type' => shop_comments::COMMENT_SERVICE]);
        $this->printSuccess(['comments' => $comments, 'totalNum' => $totalNum]);
    }

    /**
     * 异步改变用户对服务的点赞状态
     * @username string 用户平台注册ID
     * @service_id int 服务ID
     * @status   int 状态
     * @return   json
     */
    public function actionAjaxAlterPraise() {
        $username = trim($this->getHttpParam('username', false, ''));
        $service_id = intval($this->getHttpParam('obj_id', false, 0));
        $status = intval($this->getHttpParam('status', false, 0));
        $type = intval($this->getHttpParam('type', false, 1));
        $status == 1 ? 1 : -1;
        if ($status == 1) {//添加记录
            $result = shop_praises::_add([
                'username' => $username,
                'obj_id' => $service_id,
                'type' => $type,
            ]);
        } else {//删除记录
            $result = shop_praises::_delete([
                'username' => $username,
                'obj_id' => $service_id,
            ]);
        }
        if ($result) {
            //改变服务表记录
            $totalNum = shop_praises::getCommentsNum(['obj_id' => $service_id, 'type' => shop_comments::COMMENT_SERVICE]);
            if (Service::updateField('like_num', $service_id, $totalNum) == false) {
                $ret_code = json_encode(["result" => false, "errorMessage" => '', "code" => '']);
            } else {
                $ret_code = json_encode(["result" => true, "code" => null]);
            }
        } else {
            $ret_code = json_encode(["result" => false, "errorMessage" => '', "code" => '']);
        }
        $jsonpcallback = yii::$app->request->get('jsonpcallback');
        if (!empty($jsonpcallback)) {
            $ret_code = $jsonpcallback . '(' . $ret_code . ')';
        }
        exit($ret_code);
    }

    /**
     * 异步改变用户对服务的收藏状态
     * @username string 用户平台注册ID
     * @service_id int 服务ID
     * @status   int 状态
     * @return   json
     */
    public function actionAjaxAlterCollect() {
        $username = trim($this->getHttpParam('username', false, ''));
        $service_id = intval($this->getHttpParam('obj_id', false, 0));
        $status = intval($this->getHttpParam('status', false, 0));
        $type = intval($this->getHttpParam('type', false, 1));
        $status == 1 ? 1 : -1;
        if ($status == 1) {//添加记录
            $result = shop_collections::_add([
                'username' => $username,
                'obj_id' => $service_id,
                'type' => $type,
            ]);
        } else {//删除记录
            $result = shop_collections::_delete([
                'username' => $username,
                'obj_id' => $service_id,
            ]);
        }
        if ($result) {
            //改变服务表记录
            $totalNum = shop_collections::getCommentsNum(['obj_id' => $service_id, 'type' => shop_comments::COMMENT_SERVICE]);
            Service::updateField('like_num', $service_id, $totalNum) ? false : $this->printError();
            $this->printSuccess();
        } else {
            $this->printError();
        }
    }

    /**
     * 异步添加评论
     * @username string 用户平台注册ID
     * @service_id int 服务ID
     * @status   int 状态
     * @return   json
     */
    public function actionAjaxAddComment() {
        $username = trim($this->getHttpParam('username', false, ''));
        $content = trim($this->getHttpParam('content', false, ''));
        $service_id = intval($this->getHttpParam('obj_id', false, 0));
        $p_id = intval($this->getHttpParam('p_id', false, 0));
        $type = intval($this->getHttpParam('type', false, 1));
        $_params = [
            'username' => $username,
            'obj_id' => $service_id,
            'p_id' => $p_id,
            'content' => $content,
            'type' => $type,
        ];
        $result = shop_comments::_add($_params);
        if ($result <> false && $p_id == 0) {
            $totalNum = shop_comments::getCommentsNum(['obj_id' => $service_id, 'type' => shop_comments::COMMENT_SERVICE]);
            Service::updateField('comment_num', $service_id, $totalNum) ? false : $this->printError();
        }
        if ($result <> false) {
            $comment = shop_comments::getComments(['id' => $result]);
            $this->printSuccess([
                'new_comment' => $comment[0],
            ]);
        } else {
            $this->printError();
        }
    }

    /**
     * 异步删除评论
     * @username string 用户平台注册ID
     * @service_id int 服务ID
     * @status   int 状态
     * @return   json
     */
    public function actionAjaxDelComment() {
        $comment_id = intval($this->getHttpParam('comment_id', false, 0));
        $service_id = intval($this->getHttpParam('obj_id', false, 0));
        $is_comment = intval($this->getHttpParam('is_comment', false, 0));
        $result = shop_comments::_update(['id' => $comment_id], ['status' => 0]);
        if ($result <> false && $is_comment == 1) {
            $totalNum = shop_comments::getCommentsNum(['obj_id' => $service_id, 'type' => shop_comments::COMMENT_SERVICE]);
            Service::updateField('comment_num', $service_id, $totalNum) ? false : $this->printError();
        }
        if ($result <> false) {
            $this->printSuccess();
        } else {
            $this->printError();
        }
    }


}
