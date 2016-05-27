<?php

namespace backend\modules\trust\controllers;

use yii;
use app\base\CommonWebController;
use backend\modules\trust\services\TrustService;
use backend\modules\trust\models\VsoUserTrustIdentity;
use backend\modules\trust\models\VsoUserTrustRecord;
use backend\modules\trust\models\VsoUserTrustBehavior;
use backend\modules\trust\models\VsoUserTrustSocial;
use backend\modules\trust\models\VsoUserTrust;
use backend\modules\trust\models\VsoTrustNegativeRecode;
use backend\modules\trust\models\TrustNegativeRule;

class UserController extends CommonWebController
{
    public function limitActions()
    {
        return [
            'trust-list',
            'get-trust-data',
            'trust-record',
            'trust-history',
            'trust-negative',
            'get-negative-data',
            'get-history-data',
            'negative-add',
        ];
    }

    /**
     * 用户信用评分
     * 用户信用得分列表
     * table:vso_user_trust_2016
     *
     * @return string
     */
    public function actionTrustList()
    {
        return $this->render('trust_list');
    }


    public function actionGetTrustData()
    {
        $search = $this->getHttpParam('search', false, null);

        $page = $this->getHttpParam('page', false, 0);
        $pageSize = $this->getHttpParam('pageSize', false, 10);
        $offset = $page * $pageSize;

        $model = new TrustService();
        $result = $model->getTrustData($search, $pageSize, $offset);

        $this->printSuccess(['trusts' => $result['trusts'], 'totalCount' => $result['count']]);
    }


    /**
     * 用户信用评分明细
     * 根据用户名称查询，数据来自不同的行为记录
     * vso_user_trust_behavior_2016
     * vso_user_trust_identity_2016
     * vso_user_trust_record_2016 record_type 履约类型 1:近期 2:历史
     * vso_user_trust_social_2016
     *
     * @return string
     */
    public function actionTrustRecord($username = null)
    {
        if (empty($username))
        {
            return $this->redirect(Yii::$app->urlManager->createUrl(['trust/user/trust-list']));
        }

        $model = new TrustService();
        //用户信息
        $userinfo = $model->getTrustUserInfo($username);
        //用户身份特征
        $identity = VsoUserTrustIdentity::getUserIdentity($username);
        //近期履约
        $recents = VsoUserTrustRecord::getUserRecents($username, 1);
        //历史履约
        $historys = VsoUserTrustRecord::getUserRecents($username, 2);

        //用户行为偏好
        $behaviors = VsoUserTrustBehavior::getUserBehaviors($username);
        //用户社会关系
        $socials = VsoUserTrustSocial::getUserSocials($username);

        return $this->render(
            'trust_record', [
                'userinfo' => $userinfo,
                'identity' => $identity,
                'recents' => $recents,
                'historys' => $historys,
                'behaviors' => $behaviors,
                'socials' => $socials,
                'username' => $username
            ]
        );
    }


    /**
     * 用户历史信用评分
     * 根据用户名称查询，数据来自不同的行为记录
     * vso_user_trust_behavior_2016
     * vso_user_trust_identity_2016
     * vso_user_trust_record_2016 履约类型 1:近期 2:历史
     * vso_user_trust_social_2016
     *
     * @return string
     */
    public function actionTrustHistory($username = null)
    {
        if (empty($username))
        {
            return $this->redirect(Yii::$app->urlManager->createUrl(['trust/user/trust-list']));
        }

        $model = new TrustService();
        $userinfo = $model->getTrustUserInfo($username);

        return $this->render('trust_history', ['userinfo' => $userinfo, 'username' => $username]);
    }


    /**
     * 增加负面信息
     * vso_trust_negative_recode
     *
     * @return string
     */
    public function actionTrustNegative($username = null)
    {
        if (empty($username))
        {
            return $this->redirect(Yii::$app->urlManager->createUrl(['trust/user/trust-list']));
        }

        $model = new TrustService();
        $userinfo = $model->getTrustUserInfo($username);

        //负面信息
        $rulesNegative = TrustNegativeRule::getRulesNegative();

        return $this->render(
            'trust_negative', [
            'userinfo' => $userinfo,
            'username' => $username,
            'rulesNegative' => $rulesNegative
        ]
        );
    }

    /**
     * 增加负面信用分值
     */
    public function actionNegativeAdd()
    {
        $username = $this->getHttpParam('username');
        if (empty($username))
        {
            yii::$app->session->setFlash('error', '添加的用户不存在！');
        }

        $selectd = $this->getHttpParam('select_radio_trust');

        $negative = new VsoTrustNegativeRecode();
        if ($selectd == '1')
        {
            $negativeId = $this->getHttpParam('select_trust');
            $ruleInfo = TrustNegativeRule::getRulesNegativeInfo($negativeId);
            if ($ruleInfo)
            {
                $negative->negative_id = $ruleInfo['id'];
                $negative->negative_content = $ruleInfo['content'];
                $negative->negative_point = $ruleInfo['point'];
            }
        }
        else
        {
            $negative->negative_content = $this->getHttpParam('negative_content', true);
            $negative->negative_point = $this->getHttpParam('negative_point', true);
        }
        $negative->trust_month = date('Ym');
        $negative->username = $username;
        $negative->operator = Yii::$app->user->identity->getUser();
        $negative->created_at = time();
        $result = $negative->save();

        if ($result)
        {
            $model = VsoUserTrust::find()
            ->where(['username' => $username, 'trust_month' => $negative->trust_month])
            ->one();
            $trust=$model->trust-$negative->negative_point;
            $negative_count=$model->negative_count+1;
            $negative_point=$model->negative_point+$negative->negative_point;
            $model->setAttributes([
                'username' => $username,
                'trust_month' => $negative->trust_month,
                'trust' => $trust > 0 ? intval($trust) : 0,
                'negative_count' => $negative_count,
                'negative_point' => $negative_point,
                'updated_at'=>time()
            ]);
            $model->save();
            yii::$app->session->setFlash('success', '对用户扣分成功！');
        }
        else
        {
            yii::$app->session->setFlash('error', '扣分失败！');
        }

        return $this->redirect(Yii::$app->urlManager->createUrl(["trust/user/trust-negative?username={$username}"]));
    }

    /**
     * 获得负面影响记录
     *
     * @param null $username
     * @return yii\web\Response
     */
    public function actionGetNegativeData($username = null,$trust_month=null)
    {

        if (empty($username))
        {
            return $this->redirect(Yii::$app->urlManager->createUrl(['trust/user/trust-list']));
        }

        $negativeDataArr = VsoTrustNegativeRecode::getUserNegativeTrust($username,$trust_month);
        $this->printSuccess(['negatives' => $negativeDataArr['negatives'], 'totalCount' => $negativeDataArr['count']]);
    }

    /**
     * 获得负面影响记录
     *
     * @param null $username
     * @return yii\web\Response
     */
    public function actionGetHistoryData($username = null)
    {
        if (empty($username))
        {
            return $this->redirect(Yii::$app->urlManager->createUrl(['trust/user/trust-list']));
        }

        $hisData = VsoUserTrust::getUserHisTrustData($username);
        $this->printSuccess(['historys' => $hisData['historys'], 'totalCount' => $hisData['count']]);
    }
}