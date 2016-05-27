<?php

namespace backend\modules\task\models;

use common\models\KekeWitkeyMark;
use Yii;

class TaskMarkModel extends KekeWitkeyMark
{
    /**
     * 获取用户作为甲方在某段时间内收到的乙方任务评价
     * @param string $username 用户名
     * @param integer $start_time 起始时间，时间戳
     * @param integer $end_time 结束时间，时间戳
     * @return array
     */
    public static function getUserTaskMarkA($username, $start_time, $end_time)
    {
        if (empty($username))
        {
            return [];
        }
        // 筛选任务模块的评论
        $modelCodeArr = [self::MODEL_CODE_SREWARD, self::MODEL_CODE_PREWARD];
        $aidStarArr = self::find()
            ->select('mark_id, aid_star')
            ->where(['username' => $username, 'mark_type' => self::MARK_TYPE_BUYER])
            ->andWhere(['in', 'model_code', $modelCodeArr])
            ->andWhere(['between', 'mark_time', $start_time, $end_time])
            ->andWhere(['not', ['aid_star' => null]])
            ->asArray()
            ->all();
        return empty($aidStarArr) ? [] : $aidStarArr;
    }

    /**
     * 获取用户作为乙方在某段时间内收到的甲方任务评价
     * @param string $username 用户名
     * @param integer $start_time 起始时间，时间戳
     * @param integer $end_time 结束时间，时间戳
     * @return array
     */
    public static function getUserTaskMarkB($username, $start_time, $end_time)
    {
        if (empty($username))
        {
            return [];
        }
        // 筛选任务模块的评论
        $modelCodeArr = [self::MODEL_CODE_SREWARD, self::MODEL_CODE_PREWARD];
        $aidStarArr = self::find()
            ->select('mark_id, aid_star')
            ->where(['username' => $username, 'mark_type' => self::MARK_TYPE_SELLER])
            ->andWhere(['in', 'model_code', $modelCodeArr])
            ->andWhere(['between', 'mark_time', $start_time, $end_time])
            ->andWhere(['not', ['aid_star' => null]])
            ->asArray()
            ->all();
        return empty($aidStarArr) ? [] : $aidStarArr;
    }
}