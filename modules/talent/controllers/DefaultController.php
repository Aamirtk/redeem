<?php

namespace frontend\modules\talent\controllers;

use frontend\modules\auth\models\AuthRealname;
use frontend\modules\talent\models\VsoUser;
use frontend\modules\work\models\KekeWorksShow;
use Yii;
use frontend\modules\talent\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for User model.
 */
class DefaultController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * 人才入驻首页
     * @return string
     */
    public function actionIndex()
    {
        // 是否已登录
        $username = User::getLoginedUsername();

        $real_auth = false;
        $has_work = false;

        $data = [
            'username' => $username,
            'real_auth' => $real_auth,
            'has_work' => $has_work,
            'talent_exist' => false
        ];
        if (empty($username))
        {
            return $this->render('index', $data);
        }

        // 是否经过实名认证
        $real_auth = AuthRealname::isUserAuthRealname($username);

        // 是否上传过作品
        $count_work = KekeWorksShow::getUserWorkNum($username);
        $has_work = $count_work ? true : false;

        if ($real_auth && $has_work)
        {
            User::createUser($username);
        }

        $data = [
            'username' => $username,
            'real_auth' => $real_auth,
            'has_work' => $has_work,
            'talent_exist' => User::isTalentExist()
        ];
        return $this->render('index', $data);
    }

    /**
     * 查看用户详情页，路由跳转
     * @todo，需要根据用户类型和是否开通新版个人空间做跳转
     * @param $username
     */
    public function actionView($username)
    {
        // 通过接口判断是否已经入驻人才库
        $data = User::getTalentType($username);
        if (isset($data['isValid']) && $data['isValid'] && 2 == $data['user_type'])
        {
            return $this->redirect("http://rc.vsochina.com/enterprise/default/index/{$username}");
        }
        elseif (isset($data['isValid']) && $data['isValid'] && 2 <> $data['user_type'])
        {
            return $this->redirect("http://rc.vsochina.com/personal/index/{$username}");
        }
        // 不满足以上条件，跳转旧版个人中心
        $url = yii::$app->params['user_center_url'] . "{$username}.html";
        return $this->redirect($url);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['view', 'id' => $model->uid]);
        }
        else
        {
            return $this->render(
                'create',
                [
                    'model' => $model,
                ]
            );
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['view', 'id' => $model->uid]);
        }
        else
        {
            return $this->render(
                'update',
                [
                    'model' => $model,
                ]
            );
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 人才入驻
     */
    public function actionJoin()
    {
        $username = User::getLoginedUsername();
        if (empty($username))
        {
            echo json_encode(['result' => false, 'msg' => '登录后才能进行此操作']);
            exit;
        }

        if (User::find()->where(['username' => $username])->count())
        {
            echo json_encode(['result' => false, 'msg' => '您已经是人才，不能重复入驻']);
            exit;
        }

        $result = false;
        $real_auth = yii::$app->request->post('real_auth');
        $has_work = yii::$app->request->post('has_work');

        if ($real_auth && $has_work)
        {
            $result = User::createUser($username);
        }

        if ($result)
        {
            echo json_encode(['result' => $result, 'msg' => '您已成功入驻']);
            exit;
        }
        else
        {
            echo json_encode(['result' => $result, 'msg' => '入驻失败']);
            exit;
        }
    }

    /**
     * 手机号是否已经注册
     * 已注册，用户入驻
     * 未注册，注册新用户，用户入驻
     * @param $mobile
     */
    public function actionIsMobileRegisted($mobile)
    {
        $result = VsoUser::isUserRegisted($mobile);
        echo json_encode($result);
    }

    /**
     * 校验团队成员的合法性
     */
    public function actionValidateProjMember()
    {
        // 团队成员用户名字符串，转成小写，去重
        $memberStr = strtolower(yii::$app->request->post('memberStr'));
        $memberArr = explode(",", $memberStr);
        $memberArr = array_unique($memberArr);
        // 非法用户数组
        $invalidUserArr = [];
        foreach ($memberArr as $k => $v)
        {
            // 用户在平台是否已经注册
            $exist = VsoUser::find()->where(['username' => $v])->count();
            if (!$exist)
            {
                array_push($invalidUserArr, $v);
            }
        }
        if (empty($invalidUserArr))
        {
            echo json_encode(['result' => true, 'msg' => '']);
            exit;
        }
        else
        {
            $invalidUser = implode(",", $invalidUserArr);
            echo json_encode(['result' => false, 'msg' => "团队成员{$invalidUser}不存在"]);
            exit;
        }
    }

    /**
     * 模糊搜索平台用户
     * 用于项目入驻or编辑项目时搜索成员
     * 搜索范围：用户名，昵称，手机号，邮箱
     * @param $key 搜索关键词，不能为空
     * @param int $limit 返回数据条数
     * @return json 包括用户名，昵称，头像
     */
    public function actionSearchUser($key, $limit=10)
    {
        // 关键词为空
        if(empty($key))
        {
            echo json_encode([]);
            exit;
        }
        $result = VsoUser::find()
            ->select('username, nickname')
            ->where(['like', 'username', $key])
            ->orWhere(['like', 'nickname', $key])
            ->orWhere(['like', 'mobile', $key])
            ->orWhere(['like', 'email', $key])
            ->limit($limit)
            ->asArray()
            ->all();
        // 查询结果为0条用户
        if (empty($result))
        {
            echo json_encode([]);
            exit;
        }
        // 查询到数据
        $count = count($result);
        for ($i = 0; $i < $count; $i++)
        {
            $username = $result[$i]['username'];
            // 获取用户头像
            $result[$i]['avatar'] = User::getUserAvatar($username);
        }
        echo json_encode($result);
        exit;
    }
}