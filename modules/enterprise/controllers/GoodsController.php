<?php

namespace frontend\modules\enterprise\controllers;

use common\lib\Page;
use yii;
use yii\helpers\ArrayHelper;
use frontend\modules\talent\models\User;
use frontend\modules\personal\models\Person;
use frontend\controllers\CommonController;
use frontend\modules\personal\models\Goods;
use common\models_shop\shop_praises;
use common\models_shop\shop_collections;
use common\models_shop\shop_comments;
use common\models_shop\shop_auth_scope;
use frontend\modules\enterprise\models\CrmWork;
use frontend\modules\enterprise\models\CrmCompany;
use common\lib\Industry;
use common\models_shop\shop;

class GoodsController extends CommonController
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
     * 获取商品列表
     * @username string 被访问主页的平台id
     * @return array
     */
    public function actionList()
    {
        $username = $this->obj_username;
        $page = Yii::$app->request->get('page');
        $page = max(1, $page);
        $limit = Yii::$app->params['ent_goods_index_pagesize'];
        $mdl = new Goods();
        $goodsArr = $mdl->_get_list(['username' => $this->obj_username, 'status' => '2', 'is_delete' => '2'], 'create_time desc', $page, $limit);
        $goods = array_map(function($m){
            return [
                'goods_id' => $m['goods_id'],
                'name' => $m['name'],
                'price' => $m['price'],
                'username' => $m['username'],
                'like_num' => $m['like_num'],
                'comment_num' => $m['comment_num'],
//                'description' => $m['description'],
                'thumb' => $m['goods_type'] != 'audio' ? _get_thumbnail($m['username'], $m['thumb_original'], 292, '', false, 'fit') : Yii::$app->params['auto_goods_cover'],
                'category' => Industry::getNodeInfo($m['c_id'], false)['name'],
            ];
        }, $goodsArr);
        $totalCount = $mdl->_get_count(['username' => $username, 'status' => '2']);
        $_data = [
            'goods' => $goods,
            'totalPage' => ceil($totalCount/$limit),
            'pageSize' => $limit,
            'username' => $this->obj_username,
        ];
        return $this->render('list', $_data);
    }
    /**
     * 异步获取商品列表
     * @id int page 页码
     * @id int goods_id 商品编号
     * @return json
     */
    public function actionAjaxList()
    {
        $page = intval($this->getHttpParam('page', false, 1));
        $pageSize = Yii::$app->params['ent_goods_index_pagesize'];
        $mdl = new Goods();
        $goodsArr = $mdl->_get_list(['username' => $this->obj_username, 'status' => '2', 'is_delete' => '2'], 'create_time desc', $page, $pageSize);
        $goods = array_map(function($m){
            return [
                'goods_id' => $m['goods_id'],
                'name' => $m['name'],
                'price' => $m['price'],
                'username' => $m['username'],
                'like_num' => $m['like_num'],
                'comment_num' => $m['comment_num'],
//                'description' => $m['description'],
                'thumb' => $m['goods_type'] != 'audio' ? _get_thumbnail($m['username'], $m['thumb_original'], 292, '', false, 'fit') : Yii::$app->params['auto_goods_cover'],
                'category' => Industry::getNodeInfo($m['c_id'], false)['name'],
            ];
        }, $goodsArr);
        $_data = [
            'goods' => $goods,
        ];
        $this->printSuccess($_data);
    }

    /**
     * 用户可售商品详情页
     * @id int 商品ID
     * @return array
     */
    public function actionView()
    {
        $id = intval(yii::$app->request->get('id'));
        $good = Goods::find()
            ->where(['goods_id' => $id])
            ->one();
        if(!$good || $good->status != '2'|| $good->is_delete != '2'|| $good->shop->status == '2'){
            $this->redirect(Yii::$app->params['frontendurl'] . '/message/goods/?msg=');
        }
        if($this->obj_username==yii::$app->params['rc_domain_prefix'])
        {
            @header('HTTP/1.1 301 Moved Permanently');
            header('Location:http://'.$good->username.'.vsochina.com'.$_SERVER['REQUEST_URI']) ;
            exit;
        }
        elseif($this->obj_username!=$good->username)
        {
            @header('HTTP/1.1 301 Moved Permanently');
            header("Location: http://www.vsochina.com");
            exit;            
        }         
        $pageSize = Yii::$app->params['goods_comment_pagesize'];
        //获取详情页所需参数
        $myPraise = $good->getMyPraise($this->vso_uname)->count();
        $myCollection = $good->getMyCollection($this->vso_uname)->count();
        $comments = shop_comments::getComments(['obj_id' => $good->goods_id, 'p_id' => 0], 0, $pageSize);
        $tags = ArrayHelper::getColumn($good->allTags, 'tag_name');
        $description = ArrayHelper::getValue($good->description, 'description', '');
        $besides = Goods::getGoodsBesides($good['goods_id'],$good['username']);

        $auth_scope = shop_auth_scope::_get_auth_scope_name($good->auth_scope);
        $scope_list = [];
        if (!empty($auth_scope)) {
            foreach ($auth_scope as $val) {
                $scope_list[] = $val['name'];
            }
        }

        $auth = [
            'type' => $good->transaction_type,
            'text' => Goods::getTransactionAuth($good->transaction_type),
            'icon' => Goods::getTransactionIcon($good->transaction_type),
            'auth_scope' => $scope_list,
        ];
        //获取商品分类
        $good_cat = Goods::getGoodsAllCate($good['c_id']);
        //改变商品表记录
        Goods::updateField('views_num', $id, $good->views_num + 1) ? false : $this->printError();

        $totalCount = 0;
        $hot_cases = CrmWork::getList(
            ['username' => $this->obj_username, 'status' => CrmWork::STATUS_ACTIVE],
            "create_time desc",
            $totalCount,
            0,
            4
        );

        $_data = [
            'good' => $good,
            'besides' => $besides,
            'myPraise' => $myPraise,
            'myCollection' => $myCollection,
            'comments' => $comments,
            'comment_type' => shop_comments::COMMENT_GOODS,
            'tags' => $tags,
            'description' => $description,
            'pageSize' => $pageSize,
            'user_info' => $this->user_info,
            'auth' => $auth,
            'hot_cases' => $hot_cases,
            'good_cat' => $good_cat,
        ];
        return $this->render('detail', $_data);
    }

    /**
     * 异步获取商品的评论列表
     * @id int page 页码
     * @id int goods_id 商品编号
     * @return json
     */
    public function actionAjaxLoadComments()
    {
        $goods_id = intval($this->getHttpParam('obj_id', false, 0));
        $page = intval($this->getHttpParam('page', false, 1));
        $pageSize = Yii::$app->params['goods_comment_pagesize'];
        $offset = ($page - 1) * $pageSize;
        $comments = shop_comments::getComments(['obj_id' => $goods_id, 'p_id' => 0, 'type' => shop_comments::COMMENT_GOODS], $offset, $pageSize);
        $totalNum = shop_comments::getCommentsNum(['obj_id' => $goods_id, 'type' => shop_comments::COMMENT_GOODS]);
        $this->printSuccess(['comments' => $comments, 'totalNum' => $totalNum]);
    }
    /**
     * 异步改变用户对商品的点赞状态
     * @username string 用户平台注册ID
     * @goods_id int 商品ID
     * @status   int 状态
     * @return   json
     */
    public function actionAjaxAlterPraise()
    {
        $username = trim($this->getHttpParam('username', false, ''));
        $goods_id = intval($this->getHttpParam('obj_id', false, 0));
        $status = intval($this->getHttpParam('status', false, 0));
        $type = intval($this->getHttpParam('type', false, 1));
        $by = $status == 1 ? 1 : -1;
        if($status == 1){//添加记录
            $result = shop_praises::_add([
                'username' => $username,
                'obj_id' => $goods_id,
                'type' => $type,
            ]);
        }else{//删除记录
            $result = shop_praises::_delete([
                'username' => $username,
                'obj_id' => $goods_id,
            ]);
        }
        if($result){
            //改变商品表记录
            $totalNum = shop_praises::getCommentsNum(['obj_id' => $goods_id, 'type' => shop_comments::COMMENT_GOODS]);
            Goods::updateField('like_num', $goods_id, $totalNum) ? false : $this->printError();
            $this->printSuccess();
        }else{
            $this->printError();
        }
    }
    /**
     * 异步改变用户对商品的收藏状态
     * @username string 用户平台注册ID
     * @goods_id int 商品ID
     * @status   int 状态
     * @return   json
     */
    public function actionAjaxAlterCollect()
    {
        $username = trim($this->getHttpParam('username', false, ''));
        $goods_id = intval($this->getHttpParam('obj_id', false, 0));
        $status = intval($this->getHttpParam('status', false, 0));
        $type = intval($this->getHttpParam('type', false, 1));
        $status == 1 ? 1 : -1;
        if($status == 1){//添加记录
            $result = shop_collections::_add([
                'username' => $username,
                'obj_id' => $goods_id,
                'type' => $type,
            ]);
        }else{//删除记录
            $result = shop_collections::_delete([
                'username' => $username,
                'obj_id' => $goods_id,
            ]);
        }
        if($result){
            //改变商品表记录
            $totalNum = shop_collections::getCommentsNum(['obj_id' => $goods_id, 'type' => shop_comments::COMMENT_GOODS]);
            Goods::updateField('collection_num', $goods_id, $totalNum) ? false : $this->printError();
            $this->printSuccess();
        }else{
            $this->printError();
        }
    }
    /**
     * 异步添加评论
     * @username string 用户平台注册ID
     * @goods_id int 商品ID
     * @status   int 状态
     * @return   json
     */
    public function actionAjaxAddComment()
    {
        $username = trim($this->getHttpParam('username', false, ''));
        $content = trim($this->getHttpParam('content', false, ''));
        $goods_id = intval($this->getHttpParam('obj_id', false, 0));
        $p_id = intval($this->getHttpParam('p_id', false, 0));
        $type = intval($this->getHttpParam('type', false, 1));
        $_params = [
            'username' => $username,
            'obj_id' => $goods_id,
            'p_id' => $p_id,
            'content' => $content,
            'type' => $type,
        ];
        $result = shop_comments::_add($_params);
        if($result <> false && $p_id == 0){
            $totalNum = shop_comments::getCommentsNum(['obj_id' => $goods_id, 'type' => shop_comments::COMMENT_GOODS]);
            Goods::updateField('comment_num', $goods_id, $totalNum) ? false : $this->printError();
        }
        if($result <> false){
            $comment = shop_comments::getComments(['id' => $result]);
            $this->printSuccess([
                'new_comment' => $comment[0],
            ]);
        }else{
            $this->printError();
        }
    }
    /**
     * 异步删除评论
     * @username string 用户平台注册ID
     * @goods_id int 商品ID
     * @status   int 状态
     * @return   json
     */
    public function actionAjaxDelComment()
    {
        $comment_id = intval($this->getHttpParam('comment_id', false, 0));
        $goods_id = intval($this->getHttpParam('obj_id', false, 0));
        $is_comment = intval($this->getHttpParam('is_comment', false, 0));
        $result = shop_comments::_update(['id' => $comment_id], ['status' => 0]);
        if($result <> false && $is_comment == 1){
            $totalNum = shop_comments::getCommentsNum(['obj_id' => $goods_id, 'type' => shop_comments::COMMENT_GOODS]);
            Goods::updateField('comment_num', $goods_id, $totalNum) ? false : $this->printError();
        }
        if($result <> false){
            $this->printSuccess();
        }else{
            $this->printError();
        }
    }




}