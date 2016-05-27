<?php

namespace backend\modules\trust\controllers;

use app\base\CommonWebController;
use backend\modules\trust\models\TrustRangePointConfig;

class RangePointController extends CommonWebController
{

    public $range_name=[
        '1'=>'近期完成任务累计金额',
        '2'=>'近期完成任务累计次数',
        '3'=>'历史完成任务累计金额',
        '4'=>'历史完成任务累计次数',
        '5'=>'保证金托管留存金额',
        '6'=>'成长等级',
    ];
    public function limitActions()
    {
        return [
            'list', 'list-view', 'recent-view', 'get-channels', 'active', 'delete', 'details', 'update', 'edit',
        ];
    }

    /**
     * 范围配置数据列表
     * @return type
     */
    public function actionListView()
    {
        $range_type= $this->getHttpParam('range_type', false, null);
        return $this->render('list',['range_type'=>  $range_type,'range_name'=>$this->range_name[$range_type]]);
    }
    /**
     * 范围配置数据
     */
    public function actionList()
    {
        $range_type = $this->getHttpParam('range_type', false, null);
        $model=new TrustRangePointConfig();
        $record=$model->find()->where(['range_type'=>$range_type])->orderBy(' min_val asc')->asArray()->all();
        $this->printSuccess(['data'=> $record,'range_name'=>$this->range_name[$range_type]]);
    }
    /**
     * 详情显示
     */
    public function actionEdit()
    {
        $id= $this->getHttpParam('id', false, null);
        $range_type= $this->getHttpParam('range_type', false, null);
        $record=[];
        if(!empty($id)){
            $model=new TrustRangePointConfig();
            $record=$model->findOne(['id'=>$id]);
        }
        return $this->render('edit',['details'=>  $record,'range_type'=>$range_type]);
    }
    /**
     * 更新范围数据
     */
    public function actionUpdate()
    {
        $id = $this->getHttpParam('id');
        $min_val = $this->getHttpParam('min_val');
        $max_val = $this->getHttpParam('max_val');
        $point = $this->getHttpParam('point');
        $range_type = $this->getHttpParam('range_type');
        if(empty($id))
        {
            $data['range_type']=$range_type;
            $data['min_val']=$min_val;
            $data['max_val']=$max_val;
            $data['point']=$point;
            $data['created_at']=time();
            $model=new TrustRangePointConfig();
            $model->setAttributes($data, false);
            if($model->save())
            {
                $this->printSuccess();
            }
            else
            {
                $this->printError();
            }
        }
        $record=TrustRangePointConfig::findOne(['id'=>$id]);
        if(empty($record))
        {
            $this->printError();
        }
        if(0<=$min_val)
        {
            $record->min_val=$min_val;
        }
        if(0<=$max_val)
        {
            $record->max_val=$max_val;
        }
        if(0<=$point)
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
     * 删除规则
     */
    public function actionDelete()
    {
        $ids= $this->getHttpParam('ids', false, null);
        $num = TrustRangePointConfig::deleteAll(['id' => $ids]);
        if($num)
        {
            $this->printSuccess();
        }
        else
        {
            $this->printError();
        }
    }
}
