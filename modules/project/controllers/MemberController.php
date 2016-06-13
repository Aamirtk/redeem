<?php

namespace frontend\modules\project\controllers;

use frontend\modules\project\models\ProjMember;
use frontend\modules\talent\models\User;
use yii;

class MemberController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 申请加入项目
     * @param $id 项目编号
     * @throws \Exception
     */
    public function actionApply($id)
    {
        if (empty($id))
        {
            echo json_encode(['result' => false, 'msg' => '缺少项目编号']);
            exit;
        }
        $username = User::getLoginedUsername();
        if (empty($username))
        {
            echo json_encode(['result' => false, 'msg' => '登录后才能进行此操作']);
            exit;
        }
        $model = ProjMember::findOne(['proj_id' => $id, 'username' => $username]);
        if (!empty($model))
        {
            switch ($model['status'])
            {
                case ProjMember::STATUS_PASS:
                    $msg = "您已经是成员，请不要重复操作";
                    break;
                case ProjMember::STATUS_WAIT:
                case ProjMember::STATUS_DENIED:
                    $msg = "您已申请过，请等待审核结果";
                default:
                    break;
            }
            echo json_encode(['result' => false, 'msg' => $msg]);
            exit;
        }
        $model = new ProjMember();
        $model->setAttributes([
            'proj_id' => $id,
            'username' => $username,
            'description' => yii::$app->request->post('content')
        ]);

        if ($model->insert())
        {
            User::createUser($username);
            echo json_encode(['result' => true, 'msg' => '申请成功']);
            exit;
        }
        else
        {
            echo json_encode(['result' => false, 'msg' => '申请失败']);
        }
    }

    /**
     * 获取项目成员列表
     * @param $id
     */
    public function actionGetMembers($id)
    {
        if (empty($id))
        {
            echo json_encode(['result' => false, 'msg' => '缺少项目编号']);
            exit;
        }

        $result = ProjMember::find()
            ->select('username, created_at')
            ->where(['proj_id' => $id, 'status' => 1])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(5)
            ->asArray()
            ->all();
        echo json_encode($result);
    }
}
