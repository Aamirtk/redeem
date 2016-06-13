<?php
/**
 * 个人空间-动态
 */
namespace frontend\modules\personal\controllers;

use frontend\modules\personal\models\Person;
use frontend\modules\personal\models\Worklist;
use frontend\controllers\CommonController;
use yii;
use common\api\VsoApi;
use common\lib\Filter;
use frontend\modules\talent\models\User;
use frontend\modules\personal\models\PersonalSkin;
use yii\base\DynamicModel;

class IndexController extends CommonController
{
    public $enableCsrfValidation = false;
    public $layout = 'default';
    public $obj_username = "";  // 被访问用户的用户名
    public $vso_uname = '';          // 当前登录用户
    public $is_self = false;    // 被访问用户是否是当前登录用户
    public $user_info = array();  // 被访问用户信息

    /**
     * 用户首页动态
     * username
     */
    public function actionIndex()
    {
        //取用户作品集
        $file_url = Worklist::getCoverUrl(yii::$app->request->get('workfile') ? urldecode(yii::$app->request->get('workfile')) : '');
        $username = $this->obj_username;
        if ($file_url) {
            echo "<script>window.parent.setfileurl('$file_url');</script>";
            exit();
        }
        //取用户动态作品
        $works = $this->getUserWorks($username);
        //取用户作品集
        $worklist = Worklist::getUserWorklist($username);
        //取皮肤宽度
        $skin = PersonalSkin::findOne(['username' => $username]);
        $per_skin = $skin ? ['pc_id' => $skin->pc_id, 'mobile_id' => $skin->mobile_id] : ['pc_id' => 1, 'mobile_id' => 2];
        $columnWidth = $per_skin['pc_id'] == 1 ? '360' : '530';
        //取登录用户点赞的作品
        $praiseWorkids = Person::getUserPraiseWorkids($this->vso_uname);
        if (!isMobile()) {
            return $this->render('index', ['works' => $works, 'worklist' => $worklist, 'columnWidth' => $columnWidth]);
        } else {
            return $this->render('mindex', ['works' => $works, 'worklist' => $worklist, 'praiseWorkids' => $praiseWorkids]);
        }
    }

    /**
     * 获取用户作品
     * @param type $username
     * @return type
     */
    public function getUserWorks($username)
    {
        return Person::getUserWorks($username);
    }

    /**
     * 发私站内信
     */
    public function actionMessage()
    {
        $data['username'] = User::getLoginedUsername(); //登录用户
        $data['to_username'] = yii::$app->request->post('to_username'); //接收用户
        $data['title'] = Filter::escape(yii::$app->request->post('tar_title')); //标题
        $data['content'] = Filter::escape(yii::$app->request->post('tar_content')); //内容
        $apiMessageSendurl = yii::$app->params['apiMessageSendUrl'];
        $res = VsoApi::send($apiMessageSendurl, $data, "post");
        echo json_encode($res);
    }

    /**
     * 更新作品所在作品集
     */
    public function actionUpdateWork()
    {
        $data['workid'] = yii::$app->request->post('workid');
        $data['p_work_id'] = yii::$app->request->post('p_work_id');
        $apiWorkUpdateUrl = yii::$app->params['apiWorkUpdateUrl'];
        $res = VsoApi::send($apiWorkUpdateUrl, $data, "post");
        //设置作品读取Flag
        Person::setUserWorksFlag(User::getLoginedUsername(), 2);
        echo json_encode($res);
    }

    /**
     * 删除作品
     */
    public function actionDeleteWork()
    {
        $data['workid'] = yii::$app->request->post('workid');
        $apiWorkDeleteUrl = yii::$app->params['apiWorkDeleteUrl'];
        $res = VsoApi::send($apiWorkDeleteUrl, $data, "post");
        //设置作品读取Flag
        Person::setUserWorksFlag(User::getLoginedUsername(), 2);
        echo json_encode($res);
    }

    /**
     * 保存个性签名
     * */
    public function actionSaveSignture()
    {
        $res = [];
        $username = yii::$app->request->get('username');
        $signture = yii::$app->request->get('signture');
        $model = DynamicModel::validateData(compact('signture'), [
            [['signture'], 'string', 'max' => 50],
        ]);
        //校验输入合法性
        if ($model->hasErrors()) {
            echo json_encode([
                'success' => 0,
                'msg' => '个性标签名不能够大于50个字，请重新输入'
            ]);
            die();
        } else if (preg_match('/select|insert|and|or|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile/i', $signture)) {
            echo json_encode([
                'success' => 0,
                'msg' => '您的输入不合法，请重新输入'
            ]);
            die();
        }

        if (Person::saveSignture($username, $signture)) {
            echo json_encode([
                'success' => 1,
                'msg' => '个性标签名添加成功'
            ]);
            die();
        } else {
            echo json_encode([
                'success' => 0,
                'msg' => '个性标签名添加失败'
            ]);
            die();
        }
    }

    /**
     * 手机版-关于
     */
    public function actionMabout()
    {
        $post = yii::$app->request->get();
        if (!isMobile()) {
            return;
        }
        return $this->render('mabout');

    }
}
