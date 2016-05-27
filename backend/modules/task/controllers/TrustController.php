<?php

namespace backend\modules\task\controllers;

use backend\modules\auth\models\AuthEnterprise;
use backend\modules\auth\models\AuthMobile;
use backend\modules\auth\models\AuthRealname;
use backend\modules\task\models\Task;
use backend\modules\trust\models\TrustBehavior;
use backend\modules\trust\models\TrustIdentity;
use backend\modules\trust\models\TrustRangePointConfig;
use backend\modules\trust\models\TrustRecord;
use backend\modules\trust\models\TrustSocialGrowth;
use backend\modules\trust\models\VsoTrustNegativeRecode;
use backend\modules\trust\models\VsoUserTrust;
use backend\modules\trust\models\VsoUserTrustBehavior;
use backend\modules\trust\models\VsoUserTrustIdentity;
use backend\modules\trust\models\VsoUserTrustRecord;
use backend\modules\trust\models\VsoUserTrustSocial;
use backend\modules\user\models\KekeWitkeySpace;
use backend\modules\user\models\VsoUserExt;
use common\models\UserModel;
use yii;
use yii\base\Controller;

class TrustController extends Controller
{
    protected $trust_month = '';
    public function beforeAction($action)
    {
        set_time_limit(0);
        // 信用月份，计算用户信用时所处的月份
        $this->trust_month = date("Ym");
        return parent::beforeAction($action);
    }

    /**
     * 计算用户信用分值
     * 用户删选：通过手机认证
     */
    public function actionIndex()
    {
        // 筛选需要计算信用值的用户列表
        $authMobileTableName = AuthMobile::tableName();
        $auth_status = AuthMobile::STATUS_PASS;
        $sql = "SELECT DISTINCT username FROM {$authMobileTableName} WHERE auth_status = {$auth_status}";
        $userList = AuthMobile::getDb()->createCommand($sql)->queryAll();
        // 过滤不合法用户
        $userList = array_filter($userList);

        if (empty($userList))
        {
            return;
        }
        // 循环计算每位用户的各项信用值
        foreach ($userList as $k => $v)
        {
            $username = $v['username'];
            // 用户名不存在or用户被禁用，跳过本次计算
            if (!UserModel::isAvailableUsername($username))
            {
                continue;
            }
            // 近期履约
            $this->actionNearFuture($username);
            // 历史信用
            $this->actionHistory($username);
            // 身份特征
            $this->actionIdentity($username);
            // 社交关系
            $this->actionSocialGrowth($username);
            // 行为偏好
            $this->actionBehavior($username);
            // 计算用户的总信用
            $this->actionCalcUserTotalPoint($username);
        }
    }

    /**
     * 获取用户近期履约获得的信用
     * @param $username 用户名
     * @return float 信用值
     */
    public function actionNearFuture($username)
    {
        if (empty($username))
        {
            return 0;
        }
        // 取用户近3个月的数据统计信用值
        $month = TrustRecord::getConfigPctByKey('record_cycle');
        // 起始时间为结束时间往前$month个月
        $start_time = $this->getNaturalMonth($month);
        // 结束时间是当前月份的1号0点
        $end_time = strtotime(date("Y-m-01"));
        // 计算用户近期履约信用
        return $this->actionCalcUserTrustRecord($username, $start_time, $end_time, TrustRecord::RECORD_TYPE_NEAR);
    }

    /**
     * 历史信用
     * @param $username 用户名
     * @return float 信用值
     */
    public function actionHistory($username)
    {
        if (empty($username))
        {
            return 0;
        }
        // 取用户3-24个月之内的数据统计信用值
        $month_latest = TrustRecord::getConfigPctByKey('record_cycle', TrustRecord::RECORD_TYPE_NEAR);
        $month_earliest = TrustRecord::getConfigPctByKey('record_cycle', TrustRecord::RECORD_TYPE_HISTORY);
        $start_time = $this->getNaturalMonth($month_earliest);
        $end_time = $this->getNaturalMonth($month_latest);
        // 计算用户历史信用
        return $this->actionCalcUserTrustRecord($username, $start_time, $end_time, TrustRecord::RECORD_TYPE_HISTORY);
    }

    /**
     * 身份特征
     * @param $username 用户名
     * @return float 信用值
     */
    public function actionIdentity($username)
    {
        if (empty($username))
        {
            return 0;
        }
        // 实名认证用户获得的信用分，默认为0
        $realname_point = 0;
        $realname_value = intval(AuthRealname::isUserAuthRealname($username));
        // 用户通过实名认证，计算信用分
        if ($realname_value)
        {
            $realname_point = TrustIdentity::getTrustPointByKey('identity_realname');
        }
        // 企业认证用户获得的信用分，默认为0
        $enterprise_point = 0;
        $enterprise_value = intval(AuthEnterprise::isUserAuthEnterprise($username));
        // 用户通过企业认证，计算信用分
        if ($enterprise_value)
        {
            $enterprise_point = TrustIdentity::getTrustPointByKey('identity_enterprise');
        }
        // 基本信息总信用分
        $info_pct = TrustIdentity::getTrustPointByKey('identity_baseinfo');
        // 基本信息
        $info_statistic = KekeWitkeySpace::getUserBasicInfoStatistic($username);
        // 用户基本信息可以获得的信用分，保留两位小数
        $info_point = $info_pct * $info_statistic['value_length'] / $info_statistic['key_length'];
        $info_point = round($info_point, 2);

        // 信息稳定性，用户对基本信息的修改频次和信用分
        $stability_value = TrustIdentity::getUserInfoModifications($username);
        $stability_point = TrustIdentity::getUserStabilityPoint($username, $stability_value);

        $model = VsoUserTrustIdentity::find()
            ->where(['username' => $username, 'trust_month' => $this->trust_month])
            ->one();
        if (empty($model))
        {
            $model = new VsoUserTrustIdentity();
        }
        else
        {
            $model->setAttribute('updated_at', time());
        }

        // 用户身份特征获得的总信用
        $total_point = $realname_point + $enterprise_point + $info_point + $stability_point;
        $total_point = round($total_point, 2);

        $model->setAttributes([
            'username' => $username,
            'trust_month' => $this->trust_month,
            'total_point' => $total_point,
            'realname_value' => $realname_value,
            'realname_point' => $realname_point,
            'enterprise_value' => $enterprise_value,
            'enterprise_point' => $enterprise_point,
            'baseinfo_key' => $info_statistic['key_length'],
            'baseinfo_value' => $info_statistic['value_length'],
            'baseinfo_point' => $info_point,
            'stability_value' => $stability_value,
            'stability_point' => $stability_point
        ]);
        return $model->save();
    }

    /**
     * 社会关系
     * @param $username 用户名
     * @return float 信用值
     */
    public function actionSocialGrowth($username)
    {
        if (empty($username))
        {
            return 0;
        }
        // 用户信用等级
        $level = VsoUserExt::getUserPointLevel($username);
        // 社会关系用户应该获得的信用分
        $point = TrustSocialGrowth::getRangePointByValue($level);
        // 社会关系信用明细
        $model = VsoUserTrustSocial::find()
            ->where(['username' => $username, 'trust_month' => $this->trust_month])
            ->one();

        // 数据不存在，新建
        if (empty($model))
        {
            $model = new VsoUserTrustSocial();
        }
        // 数据已存在，记录更新时间
        else
        {
            $model->setAttribute('updated_at', time());
        }
        $model->setAttributes([
            'username' => $username,
            'trust_month' => $this->trust_month,
            'total_point' => $point,
            'level_value' => $level,
            'level_point' => $point
        ]);
        return $model->save();
    }

    /**
     * 行为偏好
     * @param $username 信用值
     * @return float 信用值
     */
    public function actionBehavior($username)
    {
        if (empty($username))
        {
            return 0;
        }
        $month = TrustBehavior::getConfigPctByKey('behavior_cycle');
        $start_time = $this->getNaturalMonth($month);
        $end_time = strtotime(date("Y-m-01"));
        // 账户活跃度
        // 在线次数
        $activity_value = TrustBehavior::getUserOnlineNumber($username, $start_time, $end_time);
        // 活跃信用分
        $activity_point = TrustBehavior::getUserOnlinePoint($activity_value);

        // 发布任务次数
        $pubTaskNumber = Task::getUserPubTaskNumber($username, $start_time, $end_time);
        // 发布任务获得信用分
        $pubTaskNumberPoint = TrustBehavior::getUserPubTaskPoint($pubTaskNumber);
        // 投稿次数
        $deliveryNumber = Task::getUserTaskDeliveryCount($username, $start_time, $end_time);
        // 投稿获得的信用分
        $deliveryNumberPoint = TrustBehavior::getUserDeliveryPoint($deliveryNumber);
        // 保证金托管留存金额
        $netWarrantCash = Task::getUserNetWarrantCash($username, $start_time, $end_time);
        // 保证金托管留存获得的信用分
        $netWarrantCashPoint = TrustBehavior::getRangePointByValue($netWarrantCash);

        $model = VsoUserTrustBehavior::find()
            ->where(['username' => $username, 'trust_month' => $this->trust_month])
            ->one();

        // 用户行为偏好的总信用分
        $total_point = $activity_point + $pubTaskNumberPoint + $deliveryNumberPoint + $netWarrantCashPoint;
        $total_point = round($total_point, 2);

        // 数据不存在，新建
        if (empty($model))
        {
            $model = new VsoUserTrustBehavior();
        }
        // 数据已存在，记录更新时间
        else
        {
            $model->setAttribute('updated_at', time());
        }
        $model->setAttributes([
            'username' => $username,
            'trust_month' => $this->trust_month,
            'total_point' => $total_point,
            'activity_value' => $activity_value,
            'activity_point' => $activity_point,
            'tender_value' => $pubTaskNumber,
            'tender_point' => $pubTaskNumberPoint,
            'bid_value' => $deliveryNumber,
            'bid_point' => $deliveryNumberPoint,
            'deposit_value' => $netWarrantCash,
            'deposit_point' => $netWarrantCashPoint,
        ]);
        return $model->save();
    }

    /**
     * 计算用户的总信用分
     * @param $username 用户名
     * @return bool|void
     */
    public function actionCalcUserTotalPoint($username)
    {
        if (empty($username))
        {
            return;
        }
        $model = VsoUserTrust::find()
            ->where(['username' => $username, 'trust_month' => $this->trust_month])
            ->one();

        if (empty($model))
        {
            $model = new VsoUserTrust();
        }
        else
        {
            $model->setAttribute('updated_at', time());
        }

        $model->setAttributes([
            'username' => $username,
            'trust_month' => $this->trust_month,
            'trust' => VsoUserTrust::calcUserTotalTrustPoint($username)
        ]);
        return $model->save();
    }

    /**
     * 获取当前时间往前$month个自然月的开始时间
     * @param int $month 月份（上个月=>$month=1，上上个月=>$month=2，以此类推）
     * @return int 开始时间，时间戳
     */
    public static function getNaturalMonth($month = 1)
    {
        return strtotime(date("Y-m-01", strtotime("-{$month} Month")));
    }

    /**
     * 计算用户的信用
     * @param string $username
     * @param integer $start_time
     * @param integer $end_time
     * @param integer $record_type 履约类型（1=>近期，2=>历史）
     * @return bool
     */
    public function actionCalcUserTrustRecord($username, $start_time, $end_time, $record_type)
    {
        // 完成任务累计金额
        $cash = Task::getUserCompleteTaskTotalCash($username, $start_time, $end_time);
        // 完成任务累计金额获得的信用分
        if ($record_type == TrustRecord::RECORD_TYPE_HISTORY)
        {
            $cash_key = TrustRangePointConfig::RANGE_TYPE_HISTORY_CASH;
            $finish_key = TrustRangePointConfig::RANGE_TYPE_HISTORY_PUB;
        }
        else
        {
            $cash_key = TrustRangePointConfig::RANGE_TYPE_NEAR_CASH;
            $finish_key = TrustRangePointConfig::RANGE_TYPE_NEAR_PUB;
        }
        $cash_point = TrustRecord::getRangePointByValue($cash, $cash_key);
        // 完成任务累计次数
        $finishTaskNumber = Task::getUserCompleteTaskNumber($username, $start_time, $end_time);
        // 完成任务累计次数获得的信用分
        $finishTaskPoint = TrustRecord::getRangePointByValue($finishTaskNumber, $finish_key);
        // 完成任务综合评分获得的信用分
        $mark_point = TrustRecord::getUserMarkPoint($username, $start_time, $end_time, $record_type);
        // 负面影响扣分
        $negative_point = VsoTrustNegativeRecode::getUserNegativeTrustPoint($username, $start_time, $end_time, $record_type);

        $model = VsoUserTrustRecord::find()
            ->where(['record_type' => $record_type, 'username' => $username, 'trust_month' => $this->trust_month])
            ->one();

        if (empty($model))
        {
            $model = new VsoUserTrustRecord();
        }
        else
        {
            $model->setAttribute('updated_at', time());
        }

        // 总信用分：近期履约or历史信用
        $total_point = $cash_point + $finishTaskPoint + $mark_point - $negative_point;
        $total_point = round($total_point, 2);
        $model->setAttributes([
            'username' => $username,
            'trust_month' => $this->trust_month,
            'total_point' => $total_point,
            'record_type' => $record_type,
            'amount_value' => $cash,
            'amount_point' => $cash_point,
            'count_value' => $finishTaskNumber,
            'count_point' => $finishTaskPoint,
            'merit_point' => $mark_point,
            'negative_point' => $negative_point,
        ]);
        return $model->save();
    }
}