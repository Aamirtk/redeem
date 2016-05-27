<?php
namespace backend\modules\vip\controllers;

use Yii;
use app\base\CommonWebController;
use backend\modules\vip\models\Groups;

class GroupController extends CommonWebController
{
    public $layout = 'layout';

    /**
     * 路由权限控制
     * @return array
     */
    public function limitActions()
    {
        return ['list', 'list-view', 'view', 'update', 'edit', 'get-group-detail', 'get-groups'];
    }


    /**
     * 会员分类列表
     * @return type
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 会员分类数据
     */
    public function actionList()
    {
        $model = new Groups();
        $search = $this->getHttpParam('search', false, null);
        $page = $this->getHttpParam('page', false, 0);
        $pageSize = $this->getHttpParam('pageSize', false, 10);
        $offset = $page * $pageSize;
        $data = $model->searchGroups($pageSize, $offset, $search);
        $this->printSuccess($data);
    }

    /**
     * 查看会员类型页面
     */
    public function actionView()
    {
        $id = $this->getHttpParam('id', false, null);
        $record = [];
        if (!empty($id))
        {
            $model = new Groups();
            $record = $model->findOne(['id' => $id]);
        }
        return $this->render('view', ['groups' => $record]);
    }

    /**
     * 增加/修改会员类型
     */
    public function actionEdit()
    {
        $id = $this->getHttpParam('id', false, null);
        $record = [];
        if (!empty($id))
        {
            $model = new Groups();
            $record = $model->findOne(['id' => $id]);
        }
        return $this->render('add', ['groups' => $record]);
    }

    /**
     * 更新会员分类数据
     */
    public function actionUpdate()
    {
        //基础信息
        $id = $this->getHttpParam('id', false, null);
        $data['name'] = $this->getHttpParam('name', false, null);
        $data['price'] = $this->getHttpParam('price', false, 0);
        $data['status'] = $this->getHttpParam('status', false, 1);
        //配置参数
        $data['business_push'] = $this->getHttpParam('business_push', false, 0); //商机推送
        $data['shop_type'] = $this->getHttpParam('shop_type', false, 0);//商铺类型
        $data['proj_num_lv1'] = $this->getHttpParam('proj_num_lv1', false, 0);//可入驻一级类目数量上限
        $data['proj_num_lv2'] = $this->getHttpParam('proj_num_lv2', false, 0);//可入驻二级类目数量上限
        $data['render_time'] = $this->getHttpParam('render_time', false, 0);//渲染时长上限
        $data['proj_limit'] = $this->getHttpParam('proj_limit', false, 0);//虚拟工作室项目数量上限
        $data['proj_user_limit'] = $this->getHttpParam('proj_user_limit', false, 0);//虚拟工作室项目成员数量上限
        $data['studio_limit'] = $this->getHttpParam('studio_limit', false, 0); //可加入虚拟工作室上限
        $data['studio_user_limit'] = $this->getHttpParam('studio_user_limit', false, 0);//工作室人数上限
        $data['created_at'] = time();
        if (empty($id))
        {
            $model = new Groups();
            $model->setAttributes($data, false);
            if ($model->save())
            {
                $this->printSuccess();
            }
            else
            {
                $this->printError();
            }
        }
        else
        {
            $record = Groups::findOne(['id' => $id]);
            $record->name = $data['name'];
            $record->price = $data['price'];
            $record->status = $data['status'];
            $record->business_push = $data['business_push'];
            $record->shop_type = $data['shop_type'];
            $record->proj_num_lv1 = $data['proj_num_lv1'];
            $record->proj_num_lv2 = $data['proj_num_lv2'];
            $record->render_time = $data['render_time'];
            $record->proj_limit = $data['proj_limit'];
            $record->proj_user_limit = $data['proj_user_limit'];
            $record->studio_limit = $data['studio_limit'];
            $record->studio_user_limit = $data['studio_user_limit'];
            $record->updated_at = time();
            if ($record->update())
            {
                $this->printSuccess();
            }
            else
            {
                $this->printError();
            }
        }
    }

    /**
     * 获取某个会员分类的配置明细
     */
    public function actionGetGroupDetail()
    {
        $id = $this->getHttpParam('id', false, null);
        $record = [];
        if (!empty($id))
        {
            $model = new Groups();
            $record = $model->findOne(['id' => $id]);
        }
        $this->printSuccess($record);
    }

    /**
     * 获取会员分类名称
     */
    public function actionGetGroups()
    {
        $data=  Groups::find()->select(['id as value', 'name as text'])->asArray()->all();;
        echo json_encode($data);
    }
}