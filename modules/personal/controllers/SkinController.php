<?php
/**
 * 个人空间- 皮肤设置
 * Developer-黄波
 * Date-2015.11.30
 */

namespace frontend\modules\personal\controllers;

use frontend\controllers\CommonController;
use frontend\modules\personal\models\PersonalSkin;
use frontend\modules\personal\models\Skin;
use frontend\modules\personal\models\PersonalLink;
use frontend\modules\personal\models\SkinMeta;
use frontend\modules\personal\models\Person;
use frontend\modules\talent\models\User;
use yii;

class SkinController extends CommonController
{
    public $enableCsrfValidation = false;
    //public $layout = 'default';
    public $obj_username = "";  // 被访问用户的用户名
    public $vso_uname = '';          // 当前登录用户
    public $is_self = false;    // 被访问用户是否是当前登录用户
    public $user_info = array();  // 被访问用户信息    
    /**
     * 选择皮肤页面
     *
     * */
    function actionIndex() {
        $res = PersonalSkin::findOne(['username'=>$this->obj_username]);
        $per_skin = $res?['pc_id'=>$res->pc_id, 'mobile_id'=>$res->mobile_id]:['pc_id'=>1, 'mobile_id'=>2];
        $pc_ids = Skin::findAll(['skin_type'=> 0]);
        $mobile_ids = Skin::findAll(['skin_type'=> 1]);
        $user_info = Person::getUserInfo($this->obj_username);
        return $this->render('edit', [
            'username'=>$this->obj_username,
            'per_skin'=>$per_skin,
            'pc_ids'=>$pc_ids,
            'mobile_ids'=>$mobile_ids,
            'user_info'=>$user_info
        ]);
    }

    /**
     * 加载皮肤页面
     *
     * */
    function actionDisplaySkin() {
        $username = Yii::$app->request->get('username', '');
        $skin_id = intval(Yii::$app->request->get('skinid', 0));
        $skin_type = intval(Yii::$app->request->get('skintype', 0));
        $skin_meta = SkinMeta::getSkinMeta($skin_id);
        $info = [];

        //获取get或者post方式传的username参数
        if (!empty($username))
        {

            $user_info = Person::getUserInfo($username);
            $vso_uname = User::getLoginedUsername();
            $is_self = Person::isUserSelf($username);
            $info = [
                'obj_username' => $username,
                'user_info' => $user_info,
                'vso_uname' => $vso_uname,
                'is_self' => $is_self
            ];
        }

        if($skin_type==0){//PC端
            return $this->render('pc', ['skinid'=>$skin_id,'skintype'=>$skin_type, 'meta'=>$skin_meta, 'info'=>$info]);
        }else{//移动端
            return $this->render('mobile', ['skinid'=>$skin_id,'skintype'=>$skin_type, 'meta'=>$skin_meta, 'info'=>$info]);
        }
    }

    /**
     * 保存皮肤
     *
     * */
    function actionSaveSkin() {
        $username = Yii::$app->request->get('username');
        $pc_id = intval(Yii::$app->request->get('pc_id', 1));
        $mobile_id = intval(Yii::$app->request->get('mobile_id', 2));
        $res = PersonalSkin::findOne(['username'=>$username]);
        $personSkin = $res?$res:new PersonalSkin();
        $personSkin->username = $username;
        $personSkin->pc_id = $pc_id;
        $personSkin->mobile_id = $mobile_id;
        if($personSkin->save()){
            echo json_encode(['success'=> true, 'msg'=>'保存成功!']);

        }else{
            echo json_encode(['success'=> false, 'msg'=>'保存失败!']);
        }
    }

    /**
     * 保存链接
     *
     * */
    function actionSaveLink() {
        $username = Yii::$app->request->get('username');
        $link_name = Yii::$app->request->get('link_name', '');
        $link_url = Yii::$app->request->get('link_url', '');
        $link = new PersonalLink();
        $link->username = $username;
        $link->link_name = $link_name;
        $link->link_url = $link_url;

        if($link->save()){
            echo json_encode(['success'=> true, 'msg'=>'保存成功!']);
        }else{
            echo json_encode(['success'=> false, 'msg'=>'保存失败!']);
        }

    }


}
