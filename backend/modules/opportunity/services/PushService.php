<?php

namespace backend\modules\opportunity\services;

use yii;
use yii\db\ActiveRecord;

use backend\modules\opportunity\models\OpportunityRecord;
use backend\modules\opportunity\models\OpportunityTask;
use backend\modules\opportunity\models\OpportunityUser;
use backend\modules\vip\models\VipPrivileges;
use backend\modules\vip\models\VipIndustries;
use common\api\VsoApi;


class PushService extends ActiveRecord
{

    /**
     *  商机推送，队列消费
     *
     * @param $message
     */
    public function handlePushOpportunityData($message)
    {
        if (isset($message) && !empty($message))
        {
            $members = $this->getMembers($message);
            if (!empty($message))
            {
                //暗标推送金额为0
                if($message['mark'] == 'dark')
                {
                    $message['task_cash'] = 0;
                }
                //$finalMembers = $this->filterMembers($members);
                $this->pushOpportunity($members, $message);
            }
        }
    }

    /**
     * 获得推送会员
     */
    public function getMembers($message = '')
    {
        $connection = yii::$app->get('db_uc');
        $SQL = "SELECT a.username FROM
        " . VipPrivileges::tableName() . " AS a
        INNER JOIN " . OpportunityUser::tableName() . " AS b ON a.username = b.username
        INNER JOIN " . VipIndustries::tableName() . " AS c ON a.username = c.username";

        //已推送金额 小于等于 商机推送金额
        $where = ' WHERE a.business_push * 10000 >=b.recommend_cash ';

        //任务不推送给发布者自己
        $where .= " and  a.username != '{$message['username']}'";

        //匹配行业分类
        $resCategor = VsoApi::send(yii::$app->params['categoryapi'], [], "get");

        if (array_key_exists($message['indus_id'], $resCategor['data'])) {
            $newIndusId = $resCategor['data'][$message['indus_id']];
            if (!empty($newIndusId))
            {
                $where .= " and  c.stype = {$newIndusId}";
            }
        }else{
            //行业不存在，则不推送
            return [];
        }

        //在有效期内的会员
        $where .= ' AND a.valid_end >= ' . time();

        //会员等级，购买时间排序
        $orderby = ' ORDER BY a.group_id DESC, valid_begin ASC ';

        $result = $connection->createCommand($SQL . $where . $orderby)->queryAll();

        return $result;
    }

    /**
     * 过滤不符合要求的会员
     */
    public function filterMembers($members)
    {
        return $members;
    }


    /**
     *
     * 推送商机给会员用户
     *  1、商机推送表
     *  2、任务推送记录表
     *  3、用户推送记录表
     *
     * @param $members array  会员列表
     * @param $message array  推送信息
     * @return bool
     * @throws yii\base\InvalidConfigException
     */
    public function pushOpportunity($members, $message)
    {

        if(empty($members) || empty($message))
        {
            return false;
        }

        $sysTime = time();

        $vipArr = [];

        //商机推送数据
        $recordArr = [];
        foreach ($members as $k => $v)
        {
            $vipArr[] = $v['username'];
            $resV = [];
            $resV['username'] = $v['username'];
            $resV['task_id'] = $message['task_id'];
            $resV['task_wid'] = $message['task_wid'];
            $resV['task_title'] = $message['task_title'];
            $resV['task_desc'] = $message['task_desc'];
            $resV['indus_id'] = $message['indus_id'];
            $resV['indus_pid'] = $message['indus_pid'];
            $resV['indus_name'] = $message['indus_name'];
            $resV['created_at'] = $sysTime;
            $recordArr[] = $resV;
        }

        $connection = yii::$app->get('db_uc');
        $transaction = $connection->beginTransaction();
        try
        {
            $connection->createCommand()->batchInsert(
                OpportunityRecord::tableName(), [
                'username',
                'task_id',
                'task_wid',
                'task_title',
                'task_desc',
                'indus_id',
                'indus_pid',
                'indus_name',
                'created_at'
            ], $recordArr
            )->execute();

            //任务推送记录
            $connection->createCommand()->insert(
                OpportunityTask::tableName(), [
                    'task_id' => $message['task_id'],
                    'task_wid' => $message['task_wid'],
                    'recommend_count' => count($members),
                    'created_at' => $sysTime
                ]
            )->execute();

            //用户推送记录
            if (!empty($vipArr))
            {
                $upSQL = "UPDATE " . OpportunityUser::tableName() . " SET recommend_count=recommend_count+1,recommend_cash=recommend_cash+" . floatval($message['task_cash']);
                $wUserArr = implode("','", $vipArr);
                $upWhere = " WHERE username in ('{$wUserArr}')";
                $connection->createCommand($upSQL . $upWhere)->execute();
                // 商机推送是否超限，超限时添加会员特权服务
                foreach ($members as $k => $v)
                {
                    OpportunityUser::checkRecommendCashOverflow($v['username']);
                }
            }

            $transaction->commit();
        }
        catch (Exception $e)
        {
            $transaction->rollBack();
        }
    }

}