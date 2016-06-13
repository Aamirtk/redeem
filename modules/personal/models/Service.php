<?php
/**
 * Created by PhpStorm.
 * User: Huangbo
 * Date: 2016/2/29
 * Time: 17:00
 */
namespace frontend\modules\personal\models;

use common\models_shop\shop_comments;
use common\models_shop\shop_service;
use common\models_shop\shop_praises;
use common\models_shop\shop_collections;
use common\models_shop\shop_category;
use yii;
use common\api\VsoApi;

class Service extends shop_service
{
    /**
     * 根据服务id获取username
     * @param $id 服务表的id
     * @return bool|string 返回username,当id为空或者服务记录不存在，返回false，否则返回string
    **/
    public static function getUsernameByServiceId($id){
        if(empty($id)){
            return false;
        }
        $_info = self::_get_info(['service_id' => $id]);
        return $_info ? $_info['username'] : false;
    }

    /**
     * 根据服务id获取上一篇服务和下一个服务
     * @param $id 服务表的id
     * @return array 返回前一个和后一个服务
     *         previous 前一个
     *         next     后一个
     **/
    public static function getServiceBesides($id){
        $_besides = [];
        $_this = self::_get_info(['service_id' => $id]);
        if(empty($_this)){
            $_besides['previous'] = [];
            $_besides['next'] = [];
        }
        $_besides['previous'] = self::find()
            ->where(['<', 'service_id', $id])
            ->andWhere(['username' => $_this['username']])
            ->andWhere(['status' => '2', 'is_delete' => '2'])
            ->orderBy('service_id desc')
            ->limit(1)
            ->asArray()
            ->one();
        $_besides['next'] = self::find()
            ->where(['>', 'service_id', $id])
            ->andWhere(['username' => $_this['username']])
            ->andWhere(['status' => '2', 'is_delete' => '2'])
            ->orderBy('service_id asc')
            ->limit(1)
            ->asArray()
            ->one();
        return $_besides;

    }

    /**
     * 关联点赞表，获取所有点赞
     * @return ActiveQuery Object
     **/
    public function getAllPraises(){
        return $this->hasMany(shop_praises::className(), ['obj_id' => 'service_id']);
    }
    /**
     * 关联点赞表，获取我的点赞
     * @return ActiveQuery Object
     **/
    public function getMyPraise($username){
        return $this->hasMany(shop_praises::className(), ['obj_id' => 'service_id'])->where(['username' => trim($username)]);
    }
    /**
     * 关联收藏表，获取所有收藏
     * @return ActiveQuery Object
     **/
    public function getAllCollections(){
        return $this->hasMany(shop_collections::className(), ['obj_id' => 'service_id']);
    }
    /**
     * 关联收藏表，获取我的收藏
     * @return ActiveQuery Object
     **/
    public function getMyCollection($username){
        return $this->hasMany(shop_collections::className(), ['obj_id' => 'service_id'])->where(['username' => trim($username)]);
    }
    /**
     * 关联评论表，获取所有评论
     * @return ActiveQuery Object
     **/
    public function getAllComments(){
        return $this->hasMany(shop_comments::className(), ['obj_id' => 'service_id']);
    }
    /**
     * 更新评论数量
     * @param $field 表字段
     *  comment_num-评论 like_num-点赞次数 collection_num-收藏次数 views_num-浏览次数 buy_num-购买次数
     * @param $service_id 服务编号
     * @param $num 改变数量
     * @return bool
     **/
    public static function updateField($field = 'comment_num' ,$service_id, $num = 1){
        if(!in_array($field, self::attributes())){
            return false;
        }
        try {
            $sql = 'UPDATE' . self::tableName() . ' SET ' . $field . ' = ' . $num . ' WHERE service_id =' . $service_id;
            self::getDb()->createCommand($sql)->execute();
            self::updateHotNum($service_id);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
    /**
     * 更新热度数量
     * @param $service_id 服务编号
     * @return bool
     **/
    public static function updateHotNum($service_id){
        try {
            $sql = 'UPDATE ' . self::tableName()
                . ' SET hot_num = (like_num + comment_num + views_num + collection_num + buy_num) WHERE service_id =' .$service_id;
            return self::getDb()->createCommand($sql)->execute();
        } catch (yii\base\Exception $e) {
            return false;
        }
    }
    /**
     * 获取服务交易类型版权
     * @param $type 服务编号
     * @return string
     **/
    public static function getTransactionAuth($type){
        $auth = Yii::$app->params['service_transaction_auth'];
        return isset($auth[$type]) ? $auth[$type] : '';
    }

    /**
     * 获取当前登录用户的认证状态
     * @return int $auth_status 认证状态
     */
    public static function _get_user_auth_status($username) {
        $result = VsoApi::send(yii::$app->params['getUserAuthStatusUrl'], ['username' => $username], 'get');
        if (!empty($result)) {
            $user_auth_status = $result['data'];
            $auth_status = [
                'per_auth_status' => $user_auth_status['realname_auth_status'],
                'ent_auth_status' => $user_auth_status['enterprise_auth_status'],
            ];
        }else{
            $auth_status = [
                'per_auth_status' => 3,
                'ent_auth_status' => 3,
            ];
        }
        return $auth_status;
    }







}