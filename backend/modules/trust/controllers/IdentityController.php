<?php

namespace backend\modules\trust\controllers;

use app\base\CommonWebController;
use backend\modules\trust\models\TrustBase;
use backend\modules\trust\models\TrustIdentity;

class IdentityController extends CommonWebController
{

    public function limitActions()
    {
        return [
            'list', 'list-view', 'get-channels', 'active', 'delete', 'details', 'update', 'edit',
        ];
    }

    /**
     * 身份特征分值权重配置数据
     * @return type
     */
    public function actionListView()
    {
        $baseModel = new TrustBase();
        $basedata = $baseModel->find()->orderBy(' id desc')->asArray()->one();
        $basedata['base_point_interval']=$basedata['base_point_max']-$basedata['base_point_min'];
        $basedata['base_point_identity']=$basedata['base_point_interval']*$basedata['base_identity']/100;

        $model = new TrustIdentity();
        $data = $model->find()->orderBy(' id desc')->asArray()->one();
        $data['identity_point_realname']=$basedata['base_point_interval']*$data['identity_realname']/100;
        $data['identity_point_enterprise']=$basedata['base_point_interval']*$data['identity_enterprise']/100;
        $data['identity_point_baseinfo']=$basedata['base_point_interval']*$data['identity_baseinfo']/100;
        $data['identity_point_stability']=$basedata['base_point_interval']*$data['identity_stability']/100;
        return $this->render('edit',['base'=>$basedata,'identity'=>$data]);
    }
    /**
     * 更新身份特征分值权重配置数据
     */
    public function actionUpdate()
    {
        $id = $this->getHttpParam('id');
        $identity_realname = $this->getHttpParam('identity_realname',false,null);
        $identity_enterprise = $this->getHttpParam('identity_enterprise',false,null);
        $identity_baseinfo = $this->getHttpParam('identity_baseinfo',false,null);
        $identity_stability = $this->getHttpParam('identity_stability',false,null);
        $identity_cycle = $this->getHttpParam('identity_cycle',false,null);
        $identity_max_modifications = $this->getHttpParam('identity_max_modifications',false,null);

        $record= TrustIdentity::findOne(['id'=>$id]);
        if(empty($record))
        {
            $this->printError();
        }
        if($identity_realname)
        {
            $record->identity_realname=$identity_realname;
        }
        if($identity_enterprise)
        {
            $record->identity_enterprise=$identity_enterprise;
        }
        if($identity_baseinfo)
        {
            $record->identity_baseinfo=$identity_baseinfo;
        }
        if($identity_stability)
        {
            $record->identity_stability=$identity_stability;
        }
        if($identity_cycle)
        {
            $record->identity_cycle=$identity_cycle;
        }
        if($identity_max_modifications)
        {
            $record->identity_max_modifications=$identity_max_modifications;
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
     * 信息稳定性规则配置数据
     * @return type
     */
    public function actionEdit()
    {
        $id= $this->getHttpParam('id', false, null);
        $record=[];
        if(!empty($id)){
            $model=new TrustIdentity();
            $record=$model->findOne(['id'=>$id]);
        }
        return $this->render('detail',['identity'=>  $record]);
    }
}
