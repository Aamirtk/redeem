<?php

namespace backend\modules\trust\controllers;

use app\base\CommonWebController;
use backend\modules\trust\models\TrustBase;
use backend\modules\trust\models\TrustRecord;

class RecordController extends CommonWebController
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
    public function actionRecentView()
    {
        $baseModel = new TrustBase();
        $basedata = $baseModel->find()->orderBy(' id desc')->asArray()->one();
        $basedata['base_point_interval']=$basedata['base_point_max']-$basedata['base_point_min'];
        $basedata['base_point_recent_record']=$basedata['base_point_interval']*$basedata['base_recent_record']/100;

        $model = new TrustRecord();
        $data = $model->find()->where(['record_type'=>1])->orderBy(' id desc')->asArray()->one();
        $data['record_point_amount']=$basedata['base_point_interval']*$data['record_amount']/100;
        $data['record_point_count']=$basedata['base_point_interval']*$data['record_count']/100;
        $data['record_point_overall_merit']=$basedata['base_point_interval']*$data['record_overall_merit']/100;
        return $this->render('edit',['base'=>$basedata,'record'=>$data]);
    }
    /**
     * 更新履约分值权重配置数据
     */
    public function actionUpdate()
    {
        $id = $this->getHttpParam('id');
        $record_amount = $this->getHttpParam('record_amount',false);
        $record_count = $this->getHttpParam('record_count',false);
        $record_overall_merit = $this->getHttpParam('record_overall_merit',false);
        $record_cycle = $this->getHttpParam('record_cycle',false);
        $pay_speed = $this->getHttpParam('pay_speed',false);
        $work_happy = $this->getHttpParam('work_happy',false);
        $quality = $this->getHttpParam('quality',false);
        $efficiency = $this->getHttpParam('efficiency',false);
        $attitude = $this->getHttpParam('attitude',false);
        $record= TrustRecord::findOne(['id'=>$id]);
        if(empty($record))
        {
            $this->printError();
        }
        if(0<=$record_amount&&$record_amount!=null)
        {
            $record->record_amount=$record_amount;
        }
        if(0<=$record_count&&$record_count!=null)
        {
            $record->record_count=$record_count;
        }
        if(0<=$record_overall_merit&&$record_overall_merit!=null)
        {
            $record->record_overall_merit=$record_overall_merit;
        }
        if(0<=$record_cycle&&$record_cycle!=null)
        {
            $record->record_cycle=$record_cycle;
        }
        if(0<=$pay_speed&&$pay_speed!=null)
        {
            $record->pay_speed=$pay_speed;
        }
        if(0<=$work_happy&&$work_happy!=null)
        {
            $record->work_happy=$work_happy;
        }
        if(0<=$quality&&$quality!=null)
        {
            $record->quality=$quality;
        }
        if(0<=$efficiency&&$efficiency!=null)
        {
            $record->efficiency=$efficiency;
        }
        if(0<=$attitude&&$attitude!=null)
        {
            $record->attitude=$attitude;
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
     * 近期履约权重配置数据
     * @return type
     */
    public function actionHistoryView()
    {
        $baseModel = new TrustBase();
        $basedata = $baseModel->find()->orderBy(' id desc')->asArray()->one();
        $basedata['base_point_interval']=$basedata['base_point_max']-$basedata['base_point_min'];
        $basedata['base_point_history_record']=$basedata['base_point_interval']*$basedata['base_history_record']/100;

        $model = new TrustRecord();
        $data = $model->find()->where(['record_type'=>2])->orderBy(' id desc')->asArray()->one();
        $data['record_point_amount']=$basedata['base_point_interval']*$data['record_amount']/100;
        $data['record_point_count']=$basedata['base_point_interval']*$data['record_count']/100;
        $data['record_point_overall_merit']=$basedata['base_point_interval']*$data['record_overall_merit']/100;
        return $this->render('edit',['base'=>$basedata,'record'=>$data]);
    }

    /**
     * 行为偏好各规则配置数据
     * @return type
     */
    public function actionEdit()
    {
        $id= $this->getHttpParam('id', false, null);
        $record_type= $this->getHttpParam('record_type', false, null);
        $record=[];
        if(!empty($id)){
            $model=new TrustRecord();
            $record=$model->findOne(['id'=>$id]);
        }
        return $this->render('detail',['record'=>  $record,'record_type'=>$record_type]);
    }
}
