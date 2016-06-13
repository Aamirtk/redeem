<?php
namespace frontend\modules\tag\controllers;

use frontend\modules\tag\models\RecommendLinkModel;
use frontend\modules\tag\models\SynonymsModel;
use yii;
use yii\web\Controller;
use frontend\modules\tag\libs\SphinxClient;
use yii\helpers\ArrayHelper;

/**
 * 标签推荐位设置
 * Class RecommendController
 * @package frontend\modules\tag\controllers
 */
class RecommendController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionAddRecommendAd()
    {
        $model = new RecommendLinkModel();
        $model->comment = yii::$app->request->post('comment');
        $model->img = yii::$app->request->post('img');
        $model->href = yii::$app->request->post('href');
        $model->as_default = yii::$app->request->post('as_default');
        $result = $model->save();
        return json_encode(['ret' => $result]);
    }

    public function actionEditRecommendAd()
    {
        $id = yii::$app->request->post('id');
        unset($_POST['id']);
        $model = RecommendLinkModel::find()
            ->where(['id' => $id])
            ->one();
        if ($model)
        {
            $model->comment = yii::$app->request->post('comment');
            $model->img = yii::$app->request->post('img');
            $model->href = yii::$app->request->post('href');
            $model->as_default = yii::$app->request->post('as_default');
        }
        $result = $model->update();
        return json_encode(['ret' => true]);
    }

    public function actionDeleteAd($id)
    {
        $model = RecommendLinkModel::find()
            ->where(['id' => $id])
            ->one();
        $model->delete();
        $this->redirect(yii::$app->urlManager->createUrl(['admin/tag/rec-ad']));
    }


    public function actionTest()
    {
        var_dump(RecommendLinkModel::find()->all());
    }
}