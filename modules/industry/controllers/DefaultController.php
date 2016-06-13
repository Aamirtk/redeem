<?php

namespace frontend\modules\industry\controllers;

use common\models\CommonIndustry;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetIndustryList($lvl=0)
    {
        $industry = CommonIndustry::getIndustryList($lvl);
        echo json_encode($industry);
        exit;
    }
}
