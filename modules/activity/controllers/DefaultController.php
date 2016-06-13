<?php

namespace frontend\modules\activity\controllers;

use backend\modules\content\models\Activity;
use backend\modules\content\models\Banner;
use yii\web\Controller;
use yii;
class DefaultController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $page_config = [
            'site_name'=>"申请创客空间-永久免费-安全稳定-蓝海创意云在线创作平台",
            'seo_keywords'=>'免费申请创客空间，免费空间，空间安全稳定',
            'seo_desc'=>'蓝海创意云会员免费申请空间，创客空间方便好用，海量容量、永久免费、安全稳定，是百万创客随时随地查看项目进度的好帮手。立即体验！'
        ];
        // 获取第一页的全国列表,后台修改时会重新加载缓存
        $activity = yii::$app->cache->get('activity_list_cache');
        if (!$activity)
        {
            $activity['list'] = Activity::find()->where(['is_put' => 1])->asArray()->limit(yii::$app->params['activity_list_page_size'])->orderBy(['listorder' => SORT_ASC])->all();
            $activity['count'] = Activity::find()->where(['is_put' => 1])->count();
            yii::$app->cache->set('activity_list_cache', $activity, 3600);
        }
        $city = Activity::getActivityCity();

        $banner = Banner::getBannerList(Banner::TYPE_ACTIVITY_LIST, 1);

        return $this->render('activitylist',[
            'page_config' => $page_config,
            'activity_list' => $activity['list'],
            'activity_count' => $activity['count'],
            'city' => $city,
            'banner' => $banner
        ]);
    }

    public function actionList()
    {
        $city = yii::$app->request->post('city');
        $page = yii::$app->request->post('page');
        $pageSize = yii::$app->request->post('pageSize');
        $activity = Activity::find()->where(['is_put' => 1]);
        if ($city)
        {
            $activity->andWhere(['city_id' => $city]);
        }
        if ($page && $pageSize)
        {
            $activity->offset(($page - 1) * $pageSize);
            $activity->limit($pageSize);
        }
        $list = $activity->asArray()->orderBy(['listorder' => SORT_ASC])->all();
        $count = $activity->count();

        return json_encode(['list' => $list, 'count' => $count]);
    }
}