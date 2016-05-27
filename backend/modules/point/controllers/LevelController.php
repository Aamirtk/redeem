<?php

namespace backend\modules\point\controllers;

use yii;
use app\base\CommonWebController;
use backend\modules\point\models\PointConfigLevel;

class LevelController extends CommonWebController
{
    public function limitActions()
    {
        return [
            'list',
            'list-view',
            'details',
            'update',
        ];
    }


    /**
     * 项目列表视图
     */
    public function actionListView()
    {
        return $this->render('list');
    }


    /**
     * 等级列表
     *
     * @return string
     */
    public function actionList()
    {
        $model = new PointConfigLevel();

        $page = $this->getHttpParam('page', false, 0);
        $pageSize = $this->getHttpParam('pageSize', false, 10);
        $offset = $page * $pageSize;

        $query = $model->find(); //0未启用 2启用

        $count = $query->count();
        $talents = $query->select(
            [
                'level_id',
                'level',
                'requirement',
                'created_at',
                'updated_at'
            ]
        )
                         ->orderBy(['level' => SORT_ASC])
                         ->offset($offset)
                         ->limit($pageSize)
                         ->all();
        $this->printSuccess(['levels' => $talents, 'totalCount' => $count]);
    }


    public function actionDetails($id)
    {
        if (empty($id))
        {
            return;
        }
        $model = new PointConfigLevel();
        $details = $model->find()
                         ->select(
                             [
                                 'level_id',
                                 'level',
                                 'requirement'
                             ]
                         )
                         ->where(['level_id' => $id])
                         ->asArray(true)
                         ->one();
        if ($details)
        {
            $this->printSuccess($details);
        }
        else
        {
            $this->printError();
        }
    }


    /**
     *  频道编辑
     */
    public function actionUpdate()
    {
        $level_id = $this->getHttpParam('level_id');
        $model = PointConfigLevel::findOne(['level_id' => $level_id]);
        $levelInfo = $model->toArray();

        if (empty($levelInfo))
        {
            $this->printError();
        }

        $model->setAttributes(yii::$app->request->post());

        if ($model->validate())
        {
            $model->updated_at = time();

            if ($model->save())
            {
                // 根据用户积分重新计算现有等级
                PointConfigLevel::reCalculateUserPointLevel();
                $this->printSuccess();
            }
            else
            {
                $this->printError();
            }
        }
    }

}