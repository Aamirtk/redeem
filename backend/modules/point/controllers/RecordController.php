<?php

namespace backend\modules\point\controllers;

use yii;
use app\base\CommonWebController;
use backend\modules\point\services\PointService;
use backend\modules\point\models\PointConfigRule;
use backend\modules\user\models\VsoUserExt;

class RecordController extends CommonWebController
{
    public function limitActions()
    {
        return [
            'point-list',
            'point-list-data',
            'get-rulealias',
            'get-user-info'
        ];
    }

    /**
     * [视图]积分赠送列表
     *
     * @return string
     */
    public function actionPointList()
    {
        return $this->render('point_list');
    }

    /**
     * [数据]积分赠送列表
     *
     * @return string
     */
    public function actionPointListData()
    {
        $search = $this->getHttpParam('search', false, null);
        $page = $this->getHttpParam('page', false, 0);
        $pageSize = $this->getHttpParam('pageSize', false, 10);
        $offset = $page * $pageSize;

        $model = new PointService();
        $result = $model->getPointListData($search, $pageSize, $offset);

        if(isset($search['username']) && !empty($search['username']))
        {
            $this->printSuccess(['records' => $result['records'], 'totalCount' => $result['count'],'username'=>$search['username']]);
        }
        else
        {
            $this->printSuccess(['records' => $result['records'], 'totalCount' => $result['count']]);
        }

    }

    /**
     * 频道下拉框数据
     */
    public function actionGetRulealias()
    {
        $rulealias = PointConfigRule::find()->select(['text' => 'rulealias', 'value' => 'rid'])
                                    ->asArray()->all();
        echo json_encode($rulealias);
    }


    /**
     * 获得用户信息：等级，得分
     * @param $username
     */
    public function actionGetUserInfo($username)
    {
        if (empty($username))
        {
            $userInfo = '';
            echo json_encode($userInfo);
        }
        $userInfo = VsoUserExt::find()->select(
            [
                'point',
                'username',
                'point_level'
            ]
        )->where(['username' => $username])->asArray()->one();
        echo json_encode($userInfo);
    }
}