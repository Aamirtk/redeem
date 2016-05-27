<?php

namespace backend\modules\point\controllers;

use app\base\CommonWebController;

class DefaultController extends CommonWebController
{
    public function limitActions()
    {
        return [];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}
