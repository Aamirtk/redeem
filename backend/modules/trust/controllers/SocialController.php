<?php

namespace backend\modules\trust\controllers;

use app\base\CommonWebController;
use backend\modules\trust\models\TrustBase;
use backend\modules\trust\models\TrustSocialGrowth;

class SocialController extends CommonWebController
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
        $basedata['base_point_social']=$basedata['base_point_interval']*$basedata['base_social']/100;

        $model = new TrustSocialGrowth();
        $data = $model->find()->orderBy(' id desc')->asArray()->one();
        $data['social_point_growth_level']=$basedata['base_point_interval']*$data['social_growth_level']/100;
        return $this->render('edit',['base'=>$basedata,'social'=>$data]);
    }
    /**
     * 更新身份特征分值权重配置数据
     */
    public function actionUpdate()
    {
        $id = $this->getHttpParam('id');
        $social_growth_level = $this->getHttpParam('social_growth_level');

        $record= TrustSocialGrowth::findOne(['id'=>$id]);
        if(empty($record))
        {
            $this->printError();
        }
        if(0<=$social_growth_level)
        {
            $record->social_growth_level=$social_growth_level;
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
