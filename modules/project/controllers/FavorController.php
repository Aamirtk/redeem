<?php

namespace frontend\modules\project\controllers;

use frontend\modules\project\models\Project;
use common\models\CzProjFavorite;
use frontend\modules\talent\models\User;
use yii;
use yii\web\Controller;
use frontend\modules\activity\models\SpringUtil;

class FavorController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 关注项目
     * @param $id 项目编号
     */
    public function actionFavor($id)
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

        $model = CzProjFavorite::findOne(['proj_id' => $id, 'username' => $username]);

        if (!empty($model))
        {
            echo json_encode(['result' => false, 'msg' => '已经关注，不允许重复操作']);
            exit;
        }

        $model = new CzProjFavorite();
        $model->setAttributes([
            'proj_id' => $id,
            'username' => $username,
            'created_at' => time()
        ]);

        if ($model->save())
        {
            $ticket = null;
            //2016春节红包活动开关
            if(SpringUtil::isSpringActivityAvaliable())
            {
                //curl 微信接口,生成红包和二维码
                //生成伪装码
                $dummyAction = md5(microtime());
                //将伪装码存入redis
                yii::$app->redis->lpush(yii::$app->params['spring_festivel_activity_pack_url_dummy'],$dummyAction);
                //利用伪装码拼装红包生成接口地址
                $packGenUrl = yii::$app->params['spring_festivel_activity_pack_gen_url'].$dummyAction;
                //组装接口请求数据
                $packGenPost = [];
                $packGenPost['username'] = $username;
                $packGenPost['project'] = $id;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $packGenUrl);
                curl_setopt($ch, CURLOPT_POST, 1); // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。
                curl_setopt($ch, CURLOPT_POSTFIELDS, $packGenPost); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//成功时不返回true，只返回结果
                $output = curl_exec($ch);
                yii::error('PACK_GEN_IFACE_RETURN : '.$output);
                $ticket = isset(json_decode($output)->ticket) ? json_decode($output)->ticket:null;
                curl_close($ch);
            }
            CzProjFavorite::updateFansNum($id);
            echo json_encode(['result' => true, 'msg' => '关注成功', 'fans_num' => CzProjFavorite::getFansNum($id),'ticket'=>$ticket]);
            exit;
        }
        else
        {
            echo json_encode(['result' => false, 'msg' => '关注失败']);
            exit;
        }
    }

    public function actionRemoveFavor($id)
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

        $model = CzProjFavorite::findOne(['proj_id' => $id, 'username' => $username]);

        if (empty($model))
        {
            echo json_encode(['result' => false, 'msg' => '数据不存在，请您先关注']);
            exit;
        }

        if ($model->delete())
        {
            CzProjFavorite::updateFansNum($id);
            echo json_encode(['result' => true, 'msg' => '取消关注成功', 'fans_num' => CzProjFavorite::getFansNum($id)]);
            exit;
        }
        else
        {
            echo json_encode(['result' => false, 'msg' => '取消关注失败']);
            exit;
        }
    }
}
