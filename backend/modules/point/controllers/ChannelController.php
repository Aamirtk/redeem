<?php

namespace backend\modules\point\controllers;

use yii;
use yii\helpers\Json;
use app\base\CommonWebController;
use backend\modules\point\models\PointChannel;
use backend\modules\point\models\PointConfigRule;

class ChannelController extends CommonWebController
{
    public function limitActions()
    {
        return [
            'list',
            'list-view',
            'delete',
            'details',
            'update',
            'rules',
            'distribute',
            'activate',
            'add',
        ];
    }

    /**
     * 项目列表视图
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 频道列表
     *
     * @return string
     */
    public function actionList()
    {
        $model = new PointChannel();

        $search = $this->getHttpParam('search', false, null);
        $page = $this->getHttpParam('page', false, 0);
        $pageSize = $this->getHttpParam('pageSize', false, 10);
        $offset = $page * $pageSize;

        $query = $model->find()->where(['in', 'available', [1]]); //0未启用 2启用

        if ($search)
        {
            if(isset($search['chid']))
            {
                $query = $query->andWhere(['chid' => $search['chid']]);
            }elseif (isset($search['s_chid']))
            {
                $query = $query->andWhere(['chid' => $search['s_chid']]);
            }
        }
        $count = $query->count();
        $talents = $query->select(
            [
                'chid',
                'channelname',
                'available',
                'distribute',
                'created_at',
                'updated_at'
            ]
        )
                         ->orderBy(['chid' => SORT_DESC])
                         ->offset($offset)
                         ->limit($pageSize)
                         ->all();
        $this->printSuccess(['channels' => $talents, 'totalCount' => $count]);
    }

    /**
     * 删除频道（软删，只更新字段）
     * @throws \Exception
     */
    public function actionDelete()
    {
        $chid = yii::$app->request->post('chid');

        if(empty($chid))
        {
            return;
        }
        $channel = PointChannel::findOne($chid);
        $channel->available = 0;
        $num = $channel->save();
        if($num)
        {
            $this->printSuccess();
        }
        else
        {
            $this->printError();
        }
    }

    /**
     * 通过用户名获取用户详情
     * 同时获取身份验证信息
     *
     * @param $id
     */
    public function actionDetails($id)
    {
        if (empty($id))
        {
            return;
        }
        $model = new PointChannel();
        $details = $model->find()
                         ->select(
                             [
                                 'chid',
                                 'channelname',
                                 'distribute'
                             ]
                         )
                         ->where(['chid' => $id])
                         ->asArray(true)
                         ->one();
        if ($details)
        {
            $this->printSuccess($details);
        }
        else
        {
            $this->printError();
        }
    }

    /**
     *  频道编辑
     */
    public function actionUpdate()
    {
        $chid = $this->getHttpParam('chid');
        $model = PointChannel::findOne(['chid' => $chid]);
        $channelInfo = $model->toArray();

        if (empty($channelInfo))
        {
            $this->printError();
        }

        $model->setAttributes(yii::$app->request->post());
        if ($model->validate())
        {
            $model->updated_at = time();
            if ($model->save())
            {
                $this->printSuccess();
            }
            else
            {
                $this->printError();
            }
        }
    }

    /**
     * 规则数据
     */
    public function actionRules()
    {
        $model = new PointConfigRule();

        $chid = $this->getHttpParam('chid');
        if (empty($chid))
        {
            return;
        }

        $query = $model->find()->where(['in', 'available', [1]]); //0未启用 1启用
        $query->andWhere(['chid' => $chid]);
        $rules = $query->select(
            [
                'rid',
                'rulealias',
                'available',
                'point'
            ]
        )
                       ->orderBy(['rid' => SORT_DESC])
                       ->all();

        if ($rules || empty($rules))
        {
            $this->printSuccess(['channels' => $rules]);
        }
        else
        {
            $this->printError();
        }

    }

    /**
     * 平台配比
     */
    public function actionDistribute()
    {
        $model = new PointChannel();
        $query = $model->find()->select(['name' => 'channelname', 'y' => 'distribute'])->where(
            [
                'in',
                'available',
                [1]
            ]
        ); //0未启用 1启用
        $distributes = $query->asArray()->all();

        $result = [];
        foreach ($distributes as $k => $v)
        {
            $v['y'] = floatval($v['y']);
            $result[] = $v;
        }
        unset($distributes);

        echo Json::encode($result);
    }

    /**
     * 激活数据
     */
    public function actionActivate()
    {
        $channels = PointChannel::find()->select(['text' => 'channelname', 'value' => 'chid'])
                                ->where(['in','available',[0]])->asArray()->all();
        echo json_encode($channels);
    }

    /**
     * 新增频道
     * @return string
     */
    public function actionAdd()
    {
        $model = new PointChannel();

        $post = yii::$app->request->post($model->formName());

        if ($post)
        {
            $model->setAttributes($post, false);
            if ($model->save())
            {
                yii::$app->session->setFlash('success', '活动添加成功,请到频道管理激活！');
            }
            else
            {
                yii::$app->session->setFlash('error', '活动添加失败！');
            }

        }

        return $this->render('add', ['model' => $model]);
    }

}