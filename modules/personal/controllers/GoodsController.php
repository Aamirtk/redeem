<?php
/**
 * 商品详情-个人空间
 * User: Huangbo
 * Date: 2016/3/1
 * Time: 15:24
 */
namespace frontend\modules\personal\controllers;

use common\lib\Page;
use yii;
use yii\helpers\ArrayHelper;
use common\models_shop\shop_category;
use frontend\controllers\CommonController;
use frontend\modules\personal\models\Goods;
use frontend\modules\personal\models\Skin;
use common\models_shop\shop_praises;
use common\models_shop\shop_collections;
use common\models_shop\shop_comments;
use common\models_shop\shop_auth_scope;
use common\queue\VsoShop;


class GoodsController extends CommonController {
    public $enableCsrfValidation = false;
    public $layout               = 'default';
    public $obj_username         = "";  // 被访问用户的用户名
    public $vso_uname            = '';          // 当前登录用户
    public $is_self              = false;    // 被访问用户是否是当前登录用户
    public $user_info            = array();  // 被访问用户信息

    /**
     * 用户可售商品列表页
     * @username string 用户平台注册ID
     * @return array
     */
    public function actionIndex() {
        $page = yii::$app->request->get('page');
        $page = max(1, $page);
        $limit = Yii::$app->params['per_goods_index_pagesize'];
        $username = $this->obj_username;
        $_shop_mdl = (new Goods());
        //取商品列表
        $goods = $_shop_mdl->_get_list(
            ['username' => $username, 'status' => '2', 'is_delete' => '2'],
            'create_time desc',
            $page,
            $limit
        );
        //取商品数量
        $goods_count = $_shop_mdl->_get_count(['username' => $username, 'status' => '2', 'is_delete' => '2']);

        $_data = [
            '_page_mdl' => new Page($page, $goods_count, $limit),
            'goods' => $goods,
            'columnWidth' => Skin::getPerIndexWidth($username),
            'imgWidth' => Skin::getPerIndexImgWidth($username),
        ];
        return $this->render('index', $_data);

    }

    /**
     * 用户可售商品详情页
     * @id int 商品ID
     * @return array
     */
    public function actionView($id) {
        $good = Goods::find()
            ->where(['goods_id' => $id])
            ->one();
        if (!$good || $good->status != '2' || $good->is_delete != '2' || $good->shop->status == '2') {
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
        $comments = shop_comments::getComments([
            'obj_id' => $good->goods_id,
            'p_id' => 0,
            'type' => shop_comments::COMMENT_GOODS
        ],
            0,
            $pageSize
        );
        $tags = ArrayHelper::getColumn($good->allTags, 'tag_name');
        $description = ArrayHelper::getValue($good->description, 'description', '');

        //获取上下一个
        $besides = Goods::getGoodsBesides($good['goods_id'], $good['username']);
        $auth_scope = shop_auth_scope::_get_auth_scope_name($good->auth_scope);
        $scope_list = [];
        if (!empty($auth_scope)) {
            foreach ($auth_scope as $val) {
                $scope_list[] = $val['name'];
            }
        }

        //获取版权
        $auth = [
            'type' => $good->transaction_type,
            'text' => Goods::getTransactionAuth($good->transaction_type),
            'icon' => Goods::getTransactionIcon($good->transaction_type),
            'auth_scope' => $scope_list,
        ];
        //获取商品分类
        $good_cat = Goods::getGoodsAllCate($good['c_id']);

        //改变商品表记录，通过队列可以实现延迟
        $shopqueue_enable = yii::$app->params['vsoshop_queue_enable'];
        if ($shopqueue_enable) {
            $VsoShop = new VsoShop();
            $rej = $VsoShop->updateFiled('views_num', $id, $good->views_num + 1);
            if (!$rej) {
                Goods::updateField('views_num', $id, $good->views_num + 1) ? false : $this->printError();
            }
        } else {
            Goods::updateField('views_num', $id, $good->views_num + 1) ? false : $this->printError();
        }
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
            'good_cat' => $good_cat,
        ];
        $_shop_category_mdl = (new shop_category());
        $_shop_list = $_shop_category_mdl->_get_info(["c_id" => $good['c_id']]);
//        $tags = json_decode($good['tags']);
        $tags = ArrayHelper::getColumn($good->allTags, 'tag_name');
        $a_tags = "";
        $a_tags_d = "";
        $b_tags = "";
        $b_tags_d = "";
        if(!empty($tags[0])){
            $a_tags .= ",".$tags[0].",";
            $a_tags_d .= $tags[0]."素材,";
        }
        if(!empty($tags[1])){
            $b_tags .= $tags[1].",";
            $b_tags_d .= $tags[1]."模板,";
        }
        $typeName = "";
        if(!empty($_shop_list["name"])){
            $typeName .= $_shop_list["name"]."-";
        }
        $fileName = "资源";
        if(!empty($good['name'])){
            $fileName = $good["name"];
        }
        yii::$app->view->params['_page_config'] = [
            'title' => $fileName."下载-".$typeName."创意商城mall.vsochina.com",
            'keyword' => $fileName.$a_tags.$b_tags."原创创意作品",
            'description' => $fileName."作品下载,".$a_tags_d.$b_tags_d."原创创意".$fileName."作品下载.创意商城mall.vsochina.com有创意更懂你。",
        ];
        return $this->render('detail', $_data);
    }

    /**
     * 异步获取商品的评论列表
     * @id int page 页码
     * @id int goods_id 商品编号
     * @return json
     */
    public function actionAjaxLoadComments() {
        $goods_id = intval($this->getHttpParam('obj_id', false, 0));
        $page = intval($this->getHttpParam('page', false, 1));
        $pageSize = Yii::$app->params['goods_comment_pagesize'];
        $offset = ($page - 1) * $pageSize;
        $comments = shop_comments::getComments(['obj_id' => $goods_id, 'p_id' => 0], $offset, $pageSize);
        $totalNum = shop_comments::getCommentsNum($goods_id);
        $this->printSuccess(['comments' => $comments, 'totalNum' => $totalNum]);
    }

    /**
     * 异步改变用户对商品的点赞状态
     * @username string 用户平台注册ID
     * @goods_id int 商品ID
     * @status   int 状态
     * @return   json
     */
    public function actionAjaxAlterPraise() {
//        $username = trim($this->getHttpParam('username', false, ''));
        $jsonpcallback = yii::$app->request->get('jsonpcallback');
        $username = $this->vso_uname;
        if (empty($username)) {
            $ret_code = json_encode(["result" => false, "code" => null]);
            if (!empty($jsonpcallback)) {
                $ret_code = $jsonpcallback . '(' . $ret_code . ')';
            }
            exit($ret_code);
        }
        $goods_id = intval($this->getHttpParam('obj_id', false, 0));
        $status = intval($this->getHttpParam('status', false, 0));
        $type = intval($this->getHttpParam('type', false, 1));
        if ($status == 1) {//添加记录
            $result = shop_praises::_add([
                'username' => $username,
                'obj_id' => $goods_id,
                'type' => $type,
            ]);
        } else {//删除记录
            $result = shop_praises::_delete([
                'username' => $username,
                'obj_id' => $goods_id,
            ]);
        }
        if ($result) {
            //改变商品表记录  
            $totalNum = shop_praises::getCommentsNum(['obj_id' => $goods_id, 'type' => shop_comments::COMMENT_GOODS]);
            if (Goods::updateField('like_num', $goods_id, $totalNum) == false) {
                $ret_code = json_encode(["result" => false, "errorMessage" => '', "code" => '']);
            } else {
                $ret_code = json_encode(["result" => true, "code" => null]);
            }
        } else {
            $ret_code = json_encode(["result" => false, "errorMessage" => '', "code" => '']);
        }

        if (!empty($jsonpcallback)) {
            $ret_code = $jsonpcallback . '(' . $ret_code . ')';
        }
        exit($ret_code);
    }

    /**
     * 异步改变用户对商品的收藏状态
     * @username string 用户平台注册ID
     * @goods_id int 商品ID
     * @status   int 状态
     * @return   json
     */
    public function actionAjaxAlterCollect() {
        $username = trim($this->getHttpParam('username', false, ''));
        $goods_id = intval($this->getHttpParam('obj_id', false, 0));
        $status = intval($this->getHttpParam('status', false, 0));
        $type = intval($this->getHttpParam('type', false, 1));
        $status == 1 ? 1 : -1;
        if ($status == 1) {//添加记录
            $result = shop_collections::_add([
                'username' => $username,
                'obj_id' => $goods_id,
                'type' => $type,
            ]);
        } else {//删除记录
            $result = shop_collections::_delete([
                'username' => $username,
                'obj_id' => $goods_id,
            ]);
        }
        if ($result) {
            //改变商品表记录
            $totalNum = shop_collections::getCommentsNum(['obj_id' => $goods_id, 'type' => shop_comments::COMMENT_GOODS]);
            Goods::updateField('collection_num', $goods_id, $totalNum) ? false : $this->printError();
            $this->printSuccess();
        } else {
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
    public function actionAjaxAddComment() {
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
        if ($result <> false && $p_id == 0) {
            $totalNum = shop_comments::getCommentsNum(['obj_id' => $goods_id, 'type' => shop_comments::COMMENT_GOODS]);
            Goods::updateField('comment_num', $goods_id, $totalNum) ? false : $this->printError();
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
     * @goods_id int 商品ID
     * @status   int 状态
     * @return   json
     */
    public function actionAjaxDelComment() {
        $comment_id = intval($this->getHttpParam('comment_id', false, 0));
        $goods_id = intval($this->getHttpParam('obj_id', false, 0));
        $is_comment = intval($this->getHttpParam('is_comment', false, 0));
        $result = shop_comments::_update(['id' => $comment_id], ['status' => 0]);
        if ($result <> false && $is_comment == 1) {
            $totalNum = shop_comments::getCommentsNum(['obj_id' => $goods_id, 'type' => shop_comments::COMMENT_GOODS]);
            Goods::updateField('comment_num', $goods_id, $totalNum) ? false : $this->printError();
        }
        if ($result <> false) {
            $this->printSuccess();
        } else {
            $this->printError();
        }
    }

}
