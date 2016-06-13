<?php
namespace frontend\modules\activity\models;

use yii;

class SpringUtil
{
    public static function isSpringActivityAvaliable()
    {
        $now = time();
        $timeAvaliable = $now >= yii::$app->params['spring_festivel_activity_time_switch_start'] && $now <= yii::$app->params['spring_festivel_activity_time_switch_end'];
        $activitySwitch = yii::$app->params['spring_festivel_activity_switch'];
        $isClockAvaliable = (intval(date("H",time())) >= yii::$app->params['spring_festivel_activity_start_per_day']) && (intval(date("H",time())) <= yii::$app->params['spring_festivel_activity_stop_per_day']);
        return $activitySwitch && $timeAvaliable && $isClockAvaliable;
    }
}