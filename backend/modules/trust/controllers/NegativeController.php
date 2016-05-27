<?php

namespace backend\modules\trust\controllers;

use app\base\CommonWebController;
use backend\modules\trust\models\TrustNegativeRule;

class NegativeController extends CommonWebController
{
    
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
        return $this->render('list');
    }
    /**
     * 范围配置数据
     */
    public function actionList()
    {
        $model=new TrustNegativeRule();
        $search = $this->getHttpParam('search', false, null);
        $page = $this->getHttpParam('page', false, 0);
        $pageSize = $this->getHttpParam('pageSize', false, 10);
        $offset = $page * $pageSize;
        $data = $model->searchRules($pageSize, $offset, $search);
        $this->printSuccess($data);
    }
    /**
     * 详情显示
     */
    public function actionEdit()
    {
        $id= $this->getHttpParam('id', false, null);
        $record=[];
        if(!empty($id)){
            $model=new TrustNegativeRule();
            $record=$model->findOne(['id'=>$id]);
        }
        return $this->render('edit',['details'=>  $record]);
    }
    /**
     * 更新范围数据
     */
    public function actionUpdate()
    {
        $id = $this->getHttpParam('id');
        $content = $this->getHttpParam('content');
        $point = $this->getHttpParam('point');
        if(empty($id))
        {
            $data['content']=$content;
            $data['point']=$point;
            $data['created_at']=time();
            $model=new TrustNegativeRule();
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
        $record=TrustNegativeRule::findOne(['id'=>$id]);
        if(empty($record))
        {
            $this->printError();
        }
        if($content)
        {
            $record->content=$content;
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
}
