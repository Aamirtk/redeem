<?php

namespace frontend\modules\news\controllers;

use common\models\CommonNews;
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
     * Displays a single Project model.
     * @param integer $id
     * @return mixed
     */
    public function actionNewsList()
    {
        $limit = yii::$app->request->post('limit');
        if (empty($limit))
        {
            $limit = 6;
        }
        $news = CommonNews::find()
            ->select('id, title, link, listorder')
            ->where(['obj_type' => CommonNews::OBJ_TYPE])
            ->limit($limit)
            ->orderBy(['listorder' => SORT_ASC])
            ->asArray()
            ->all();
        echo json_encode($news);
        exit;
    }
}
