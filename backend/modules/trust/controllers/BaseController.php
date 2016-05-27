<?php

namespace backend\modules\trust\controllers;

use app\base\CommonWebController;
use backend\modules\trust\models\TrustBase;

class BaseController extends CommonWebController
{

    public function limitActions()
    {
        return [
            'list', 'list-view', 'get-channels', 'active', 'delete', 'details', 'update', 'edit',
        ];
    }

    /**
     * 基础分值权重配置数据
     * @return type
     */
    public function actionListView()
    {
        $model = new TrustBase();
        $data = $model->find()->orderBy(' id desc')->asArray()->one();
        $data['base_point_interval']=$data['base_point_max']-$data['base_point_min'];
        $data['base_point_identity']=$data['base_point_interval']*$data['base_identity']/100;
        $data['base_point_recent_record']=$data['base_point_interval']*$data['base_recent_record']/100;
        $data['base_point_history_record']=$data['base_point_interval']*$data['base_history_record']/100;
        $data['base_point_behavior']=$data['base_point_interval']*$data['base_behavior']/100;
        $data['base_point_social']=$data['base_point_interval']*$data['base_social']/100;
        return $this->render('edit',['base'=>$data]);
    }
    /**
     * 更新基础分值权重配置数据
     */
    public function actionUpdate()
    {
        $id = $this->getHttpParam('id');
        $base_point_min = $this->getHttpParam('base_point_min');
        $base_point_max = $this->getHttpParam('base_point_max');
        $base_identity = $this->getHttpParam('base_identity');
        $base_recent_record = $this->getHttpParam('base_recent_record');
        $base_history_record = $this->getHttpParam('base_history_record');
        $base_behavior = $this->getHttpParam('base_behavior');
        $base_social = $this->getHttpParam('base_social');

        $record=  TrustBase::findOne(['id'=>$id]);
        if(empty($record))
        {
            $this->printError();
        }
        if(0<=$base_point_min)
        {
            $record->base_point_min=$base_point_min;
        }
        if(0<=$base_point_max)
        {
            $record->base_point_max=$base_point_max;
        }
        if(0<=$base_identity)
        {
            $record->base_identity=$base_identity;
        }
        if(0<=$base_recent_record)
        {
            $record->base_recent_record=$base_recent_record;
        }
        if(0<=$base_history_record)
        {
            $record->base_history_record=$base_history_record;
        }
        if(0<=$base_behavior)
        {
            $record->base_behavior=$base_behavior;
        }
        if(0<=$base_social)
        {
            $record->base_social=$base_social;
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
}
