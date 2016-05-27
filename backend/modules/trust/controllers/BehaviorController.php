<?php

namespace backend\modules\trust\controllers;

use app\base\CommonWebController;
use backend\modules\trust\models\TrustBase;
use backend\modules\trust\models\TrustBehavior;
use backend\modules\trust\models\TrustRangePointConfig;

class BehaviorController extends CommonWebController
{

    public function limitActions()
    {
        return [
            'list', 'list-view', 'recent-view','history-view', 'get-channels', 'active',
            'delete', 'details', 'update', 'edit',
        ];
    }

    /**
     * 近期履约权重配置数据
     * @return type
     */
    public function actionListView()
    {
        $baseModel = new TrustBase();
        $basedata = $baseModel->find()->orderBy(' id desc')->asArray()->one();
        $basedata['base_point_interval']=$basedata['base_point_max']-$basedata['base_point_min'];
        $basedata['base_point_behavior']=$basedata['base_point_interval']*$basedata['base_behavior']/100;
        $model = new TrustBehavior();
        $data = $model->find()->orderBy(' id desc')->asArray()->one();
        $data['behavior_point_activity']=$basedata['base_point_interval']*$data['behavior_activity']/100;
        $data['behavior_point_tender']=$basedata['base_point_interval']*$data['behavior_pub_task']/100;
        $data['behavior_point_bid']=$basedata['base_point_interval']*$data['behavior_bid']/100;
        $data['behavior_point_deposit']=$basedata['base_point_interval']*$data['behavior_deposit']/100;
        return $this->render('edit',['base'=>$basedata,'behavior'=>$data]);
    }
    /**
     * 更新履约分值权重配置数据
     */
    public function actionUpdate()
    {
        $id = $this->getHttpParam('id');
        $behavior_activity = $this->getHttpParam('behavior_activity',false,null);
        $behavior_pub_task = $this->getHttpParam('behavior_pub_task',false,null);
        $behavior_bid = $this->getHttpParam('behavior_bid',false,null);
        $behavior_deposit = $this->getHttpParam('behavior_deposit',false,null);
        $behavior_min_online = $this->getHttpParam('behavior_min_online',false,null);
        $behavior_activity_percent = $this->getHttpParam('behavior_activity_percent',false,null);
        $behavior_min_tender= $this->getHttpParam('behavior_min_tender',false,null);
        $behavior_tender_percent = $this->getHttpParam('behavior_tender_percent',false,null);
        $behavior_min_bid = $this->getHttpParam('behavior_min_bid',false,null);
        $behavior_bid_percent= $this->getHttpParam('behavior_bid_percent',false,null);
        $behavior_cycle = $this->getHttpParam('behavior_cycle',false,null);
        $record= TrustBehavior::findOne(['id'=>$id]);
        if(empty($record))
        {
            $this->printError();
        }
        if($behavior_activity)
        {
            $record->behavior_activity=$behavior_activity;
        }
        if($behavior_pub_task)
        {
            $record->behavior_pub_task=$behavior_pub_task;
        }
        if($behavior_bid)
        {
            $record->behavior_bid=$behavior_bid;
        }
        if($behavior_deposit)
        {
            $record->behavior_deposit=$behavior_deposit;
        }
        if($behavior_min_online)
        {
            $record->behavior_min_online=$behavior_min_online;
        }
        if($behavior_activity_percent)
        {
            $record->behavior_activity_percent=$behavior_activity_percent;
        }
        if($behavior_min_tender)
        {
            $record->behavior_min_tender=$behavior_min_tender;
        }
        if($behavior_tender_percent)
        {
            $record->behavior_tender_percent=$behavior_tender_percent;
        }
        if($behavior_min_bid)
        {
            $record->behavior_min_bid=$behavior_min_bid;
        }
        if($behavior_bid_percent)
        {
            $record->behavior_bid_percent=$behavior_bid_percent;
        }
        if($behavior_cycle)
        {
            $record->behavior_cycle=$behavior_cycle;
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
     * 行为偏好各规则配置数据
     * @return type
     */
    public function actionEdit()
    {
        $id= $this->getHttpParam('id', false, null);
        $type= $this->getHttpParam('type', false, null);
        $record=[];
        if(!empty($id)){
            $model=new TrustBehavior();
            $record=$model->findOne(['id'=>$id]);
        }
        return $this->render('detail',['behavior'=>  $record,'type'=>$type]);
    }
}
