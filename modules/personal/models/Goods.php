<?php
/**
 * Created by PhpStorm.
 * User: Huangbo
 * Date: 2016/2/29
 * Time: 17:00
 */
namespace frontend\modules\personal\models;

use common\models_shop\shop_comments;
use common\models_shop\shop_goods;
use common\models_shop\shop_goods_data;
use common\models_shop\shop_goods_tags;
use common\models_shop\shop_praises;
use common\models_shop\shop_collections;
use common\lib\Category;
use common\models_shop\shop_category;
use yii;

class Goods extends shop_goods
{
    /**
     * 根据商品id获取username
     * @param $id int 商品表的id
     * @return bool|string 返回username,当id为空或者商品记录不存在，返回false，否则返回string
    **/
    public static function getUsernameByGoodsId($id){
        if(empty($id)){
            return false;
        }
        $_info = self::_get_info(['goods_id' => $id]);
        return $_info ? $_info['username'] : false;
    }

    /**
     * 根据商品id获取上一篇商品和下一个商品
     * @param $id 商品表的id
     * @param $username 用户名
     * @return array 返回前一个和后一个商品
     *         previous 前一个
     *         next     后一个
     **/
    public static function getGoodsBesides($id, $username)
    {
        $_besides = [];
        $_besides['previous'] = self::find()
            ->where(['<', 'goods_id', $id])
            ->andWhere(['username' => $username])
            ->andWhere(['status' => '2', 'is_delete' => '2'])
            ->orderBy('goods_id desc')
            ->limit(1)
            ->asArray()
            ->one();
        $_besides['next'] = self::find()
            ->where(['>', 'goods_id', $id])
            ->andWhere(['username' => $username])
            ->andWhere(['status' => '2', 'is_delete' => '2'])
            ->orderBy('goods_id asc')
            ->limit(1)
            ->asArray()
            ->one();
        return $_besides;

    }

    /**
     * 关联点赞表，获取所有标签
     * @return ActiveQuery Object
     **/
    public function getAllTags(){
        return $this->hasMany(shop_goods_tags::className(), ['goods_id' => 'goods_id']);
    }

    /**
     * 关联点赞表，获取商品描述
     * @return ActiveQuery Object
     **/
    public function getDescription(){
        return $this->hasOne(shop_goods_data::className(), ['goods_id' => 'goods_id']);
    }

    /**
     * 关联点赞表，获取所有点赞
     * @return ActiveQuery Object
     **/
    public function getAllPraises(){
        return $this->hasMany(shop_praises::className(), ['obj_id' => 'goods_id']);
    }
    /**
     * 关联点赞表，获取我的点赞
     * @return ActiveQuery Object
     **/
    public function getMyPraise($username){
        return $this->hasMany(shop_praises::className(), ['obj_id' => 'goods_id'])->where(['username' => trim($username)]);
    }
    /**
     * 关联收藏表，获取所有收藏
     * @return ActiveQuery Object
     **/
    public function getAllCollections(){
        return $this->hasMany(shop_collections::className(), ['obj_id' => 'goods_id']);
    }
    /**
     * 关联收藏表，获取我的收藏
     * @return ActiveQuery Object
     **/
    public function getMyCollection($username){
        return $this->hasMany(shop_collections::className(), ['obj_id' => 'goods_id'])->where(['username' => trim($username)]);
    }
    /**
     * 关联评论表，获取所有评论
     * @return ActiveQuery Object
     **/
    public function getAllComments(){
        return $this->hasMany(shop_comments::className(), ['obj_id' => 'goods_id']);
    }
    /**
     * 更新评论数量
     * @param $field string 表字段
     *  comment_num-评论 like_num-点赞次数 collection_num-收藏次数 views_num-浏览次数 buy_num-购买次数
     * @param $goods_id int 商品编号
     * @param $num int 改变数量
     * @return bool
     **/
    public static function updateField($field = 'comment_num' ,$goods_id, $num = 1){
        try {
            $sql = 'UPDATE' . self::tableName() . ' SET ' . $field . ' = ' . $num . ' WHERE goods_id =' . $goods_id;
            self::getDb()->createCommand($sql)->execute();
            self::updateHotNum($goods_id);
        } catch (yii\base\Exception $e) {
            return false;
        }
        return true;
    }
    /**
     * 更新热度数量
     * @param $goods_id int 商品编号
     * @return bool
     **/
    public static function updateHotNum($goods_id){
        try {
            $sql = 'UPDATE ' . self::tableName()
                . ' SET hot_num = (like_num + comment_num + views_num + collection_num + buy_num) WHERE goods_id =' . $goods_id;
            return self::getDb()->createCommand($sql)->execute();
        } catch (yii\base\Exception $e) {
            return false;
        }
    }
    /**
     * 获取商品交易类型版权
     * @param $type 商品交易类型
     * @return string
     **/
    public static function getTransactionAuth($type){
        $auth = Yii::$app->params['goods_transaction_auth'];
        return isset($auth[$type]) ? $auth[$type] : '';
    }

    /**
     * 获取商品交易类型图标
     * @param $type 商品交易类型
     * @return string
     **/
    public static function getTransactionIcon($type){
        $icon = Yii::$app->params['goods_transaction_icon'];
        return isset($icon[$type]) ? $icon[$type] : $icon[4];
    }

    /**
     * 获取商品各级分类
     * @param $c_id 商品分类id
     * @return array
     **/
    public static function getGoodsAllCate($c_id){
        $_cate_array = [];
        if(empty($c_id)){
            return $_cate_array;
        }
        $_cate_mdl = new shop_category();
        $_category_mdl = new Category();
        $_cate_list = $_cate_mdl->_get_list(['status' => '1'], 'sort desc, c_id asc', 1, 0);//获取全部分类
        $_cate_parent_list = array_reverse($_category_mdl->_get_parent_class($_cate_list, $c_id));//获取当前分类父级分类
        $_cate_array = yii\helpers\ArrayHelper::getColumn($_cate_parent_list, 'name');
        return $_cate_array;
    }



}