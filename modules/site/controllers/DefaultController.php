<?php

namespace frontend\modules\site\controllers;

use backend\modules\content\models\Site;
use yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Display the Site Information
     * @return mixed
     */
    public function actionSiteInfo($site_type)
    {
        $model = new Site();
        if(empty($site_type))
        {
            return false;
        }
        $result = $model->find()->where(['site_type'=>$site_type])->limit(1)->asArray()->one();
        echo json_encode($result);
        exit;
    }
}
