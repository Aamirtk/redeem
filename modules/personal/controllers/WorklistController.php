<?php
/**
 * 个人空间-作品集
 */
namespace frontend\modules\personal\controllers;

use frontend\modules\personal\models\Person;
use frontend\modules\personal\models\Worklist;
use frontend\controllers\CommonController;
use yii;
use frontend\modules\personal\models\PersonalSkin;
use frontend\modules\talent\models\User;
class WorklistController extends CommonController
{
    public $enableCsrfValidation = false;
    public $layout = 'default';
    public $obj_username = "";  // 被访问用户的用户名
    public $is_self = false;    // 被访问用户是否是当前登录用户
    public $user_info=array();  // 被访问用户信息
    public $vso_uname='';  // 当前登录用户
    /**
     * 用户作品集
     * username
     */
    public function actionIndex()
    {
        //取用户作品集图片
        $file_url    = Worklist::getCoverUrl(yii::$app->request->get('workfile') ?
                urldecode(yii::$app->request->get('workfile')) : '');
        if ($file_url)
        {
            echo "<script>window.parent.setfileurl('$file_url');</script>";
            exit();
        }
        if(empty($this->obj_username)||$this->obj_username==yii::$app->params['rc_domain_prefix'])
        {
            @header('HTTP/1.1 301 Moved Permanently');
            header("Location: http://www.vsochina.com");
            exit;  
        }
        //取用户作品集
        $worklistData = Worklist::getPersonalWorklist($this->obj_username);
        $worklist=isset($worklistData['worklist'])?$worklistData['worklist']:[];
        $no_worklist=isset($worklistData['no_worklist'])?$worklistData['no_worklist']:[];
        return $this->render('pworks', ['worklist' => $worklist,'file_url' => $file_url,
             'no_worklist' => $no_worklist,]);
    }
    /**
     * 创建/更新作品集
     */
    public function actionCreate()
    {
        $p_work_id = yii::$app->request->post('p_work_id');
        $username = yii::$app->request->post('username');
        $name= yii::$app->request->post('name');
        $cover= yii::$app->request->post('cover');
        $status = yii::$app->request->post('status');
        if(empty($p_work_id))
        {
            $res = Worklist::createWorklist($username,$name,$cover);
        }
        else
        {
            $res = Worklist::updateWorklist($p_work_id,$name,$cover,$status);
        }
        echo json_encode($res);
    }
    /**
     * 用户作品集的作品
     * username
     */
    public function actionWorks($id)
    {
        //取用户作品集
        $file_url    = Worklist::getCoverUrl(yii::$app->request->get('workfile') ?
                urldecode(yii::$app->request->get('workfile')) : '');
        if ($file_url)
        {
            echo "<script>window.parent.setfileurl('$file_url');</script>";
            exit();
        }
        $worklistinfo=Worklist::getWorklistInfo($id);
        $username=$worklistinfo['username'];
        if($this->obj_username==yii::$app->params['rc_domain_prefix'])
        {
            @header('HTTP/1.1 301 Moved Permanently');
            header('Location:http://'.$username.'.vsochina.com'.$_SERVER['REQUEST_URI']) ;
            exit;
        }
        elseif($this->obj_username!=$username)
        {
            @header('HTTP/1.1 301 Moved Permanently');
            header("Location: http://www.vsochina.com");
            exit;            
        }         
        //取用户动态作品
        $works = Worklist::getWorkByWorklist($id);
        //取用户作品集
        $worklist=Worklist::getUserWorklist($this->obj_username);
        //取皮肤宽度
        $skin=PersonalSkin::findOne(['username'=>$this->obj_username ]);
        $per_skin = $skin?['pc_id'=>$skin->pc_id, 'mobile_id'=>$skin->mobile_id]:['pc_id'=>1, 'mobile_id'=>2];
        $columnWidth= $per_skin['pc_id']==1?'360':'530';
        return $this->render('../index/index', ['works' => $works,'worklist' => $worklist,'columnWidth' => $columnWidth]);
    }
    /**
     * 用户作品集的作品
     * username
     */
    public function actionNworks()
    {
        //取用户作品集
        $file_url    = Worklist::getCoverUrl(yii::$app->request->get('workfile') ?
                urldecode(yii::$app->request->get('workfile')) : '');
        if ($file_url)
        {
            echo "<script>window.parent.setfileurl('$file_url');</script>";
            exit();
        }
        //取用户动态作品
        $works = Worklist::getNoWorkListWork($this->obj_username);
        //取用户作品集
        $worklist=Worklist::getUserWorklist($this->obj_username);
        //取皮肤宽度
        $skin=PersonalSkin::findOne(['username'=>$this->obj_username ]);
        $per_skin = $skin?['pc_id'=>$skin->pc_id, 'mobile_id'=>$skin->mobile_id]:['pc_id'=>1, 'mobile_id'=>2];
        $columnWidth= $per_skin['pc_id']==1?'360':'530';
        return $this->render('../index/index', ['works' => $works,'worklist' => $worklist,'columnWidth' => $columnWidth]);
    }
}
