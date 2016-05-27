<?php

namespace backend\modules\point\controllers;

use yii;
use app\base\CommonWebController;
use backend\modules\point\models\PointConfigRule;
use backend\modules\point\models\PointChannel;

class AllocationController extends CommonWebController
{

    public function limitActions()
    {
        return [
            'list', 'rule', 'get-channels', 'active', 'delete', 'details', 'update', 'edit',
        ];
    }

    /**
     * 配比列表数据
     */
    public function actionList()
    {
        $model = new PointConfigRule();

        $search = $this->getHttpParam('search', false, null);
        $page = $this->getHttpParam('page', false, 0);
        $pageSize = $this->getHttpParam('pageSize', false, 10);
        $offset = $page * $pageSize;
        $data = $model->searchRules($pageSize, $offset, $search);
        $this->printSuccess($data);
    }

    /**
     * 配比列表
     * @return type
     */
    public function actionRule()
    {
        return $this->render('list');
    }

    /**
     * 频道下拉框数据
     */
    public function actionGetChannels()
    {
        $channels = PointChannel::find()->select(['text' => 'channelname', 'value' => 'chid'])
            ->where(['in','available',[1]])->asArray()->all();
        echo json_encode($channels);
    }

    /**
     * 启用/停用配比规则
     */
    public function actionActive()
    {
        $rids = $this->getHttpParam('rids');
        $availbale = $this->getHttpParam('availbale');
        if (!empty($rids))
        {
            $model = new PointConfigRule();
            $model->updateAll(['available' => ($availbale == 1 ? 0 : 1)], ['in', 'rid', $rids]);
        }
        return $this->render('list');
    }

    /**
     * 删除配比规则
     */
    public function actionDelete()
    {
        $rids = $this->getHttpParam('rids');
        if (!empty($rids))
        {
            $model = new PointConfigRule();
            $model->updateAll(['available' => 0], ['in', 'rid', $rids]);
        }
        return $this->render('list');
    }

    /**
     * 配比详情
     */
    public function actionDetails()
    {
        $rid = $this->getHttpParam('rid');
        $details=PointConfigRule::getRuleDetails($rid);
        if($details)
        {
            $this->printSuccess($details);
        }
        else
        {
            $this->printError();
        }
    }

    /**
     * 更新配比数据
     */
    public function actionUpdate()
    {
        $rid = $this->getHttpParam('rid');
        $rulealias = $this->getHttpParam('rulealias');
        $point = $this->getHttpParam('point');
        $record=PointConfigRule::findOne(['rid'=>$rid]);
        if(empty($record))
        {
            $this->printError();
        }
        if($rulealias)
        {
            $record->rulealias=$rulealias;
        }
        if($point)
        {
            $record->point=$point;
        }
        $record->updated_at=  time();
        if($record->save())
        {
            $this->printSuccess();
        }
        else
        {
            $this->printError();
        }
    }

    /**
     * 配比编辑页面
     * @return type
     */
    public function actionEdit()
    {
        $rid = $this->getHttpParam('rid');
        $details=PointConfigRule::getRuleDetails($rid);
        return $this->render('edit',['details'=>$details]);
    }
}
