<?php
namespace frontend\modules\tag\controllers;

use frontend\modules\tag\models\TagRecommendLinkModel;
use frontend\modules\tag\models\TagRecommendUserModel;
use frontend\modules\tag\models\RecommendLinkModel;
use frontend\modules\tag\models\SynonymsModel;
use app\modules\industry\models\Industry;
use yii;
use yii\web\Controller;
use frontend\modules\tag\libs\SphinxClient;
use yii\helpers\ArrayHelper;
use yii\base\Exception;

class IndexController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * 全站搜索入口
     * @param $limit
     * @param $offset
     * @param string $index
     * @param string $orderby
     * @return array|string
     */
    public function actionSearch($limit, $offset = 0, $index = 'enterprise,talent', $orderby = '')
    {
        $keyword = yii::$app->request->get('keyword');
        return yii::$app->sphinx->search2($keyword, $offset,$limit,  $index, $orderby);
    }

    /**
     * 根据当前输入关键字查询输入框提示
     * @return mixed
     */
    public function actionTips()
    {
        $keyword = yii::$app->request->get('keyword');
        return yii::$app->sphinx->actionSearch($keyword, 2, $offset = 0, '*', $orderby = '');
    }

    /**
     * 新增关键字同义词设置
     */
    public function actionCreateSynonyms()
    {
        $keyword = yii::$app->request->post("keyword");
        $synonyms = yii::$app->request->post("synonyms");
        $hot = yii::$app->request->post("hot");
        try
        {
            //将关系存入redis
            $redisSaveResult = yii::$app->sphinx->writeCache($keyword . '-synonyms', json_encode(explode(',', $synonyms)));
            //将关系存入mysql
            $synonymsModel = new SynonymsModel();
            $synonymsModel->keyword = $keyword;
            $synonymsModel->synonyms = $synonyms;
            $synonymsModel->hot = $hot;
            $mysqlSaveResult = $synonymsModel->save();
            $saveResult = $redisSaveResult && $mysqlSaveResult;
            $returnResult = ['res' => $saveResult, 'data' => $synonyms];
            echo json_encode($returnResult);
        }
        catch (Exception $e)
        {
            if (strpos($e->getMessage(), 'Duplicate'))
            {
                $returnResult = ['res' => false, 'data' => [], 'msg' => '关键字"' . $keyword . '"已存在,请勿重复创建'];
            }
            else
            {
                $returnResult = ['res' => false, 'data' => [], 'msg' => $e->getMessage()];
            }
            echo json_encode($returnResult);
        }
    }

    /**
     * 删除指定id的关键字同义词配置
     */
    public function actionDeleteSynonyms($id)
    {
        if ($id == 1)
        {
            $this->redirect(yii::$app->urlManager->createUrl(['admin/tag/index']));
            exit;
        }
        $redisDeleteResult = false;
        $mysqlDeleteResult = false;
//        $id = yii::$app->request->post("id");
        //删除mysql数据
        $mysqlRecord = SynonymsModel::find()
            ->where(['id' => $id])
            ->one();
        if ($mysqlRecord)
        {
            //删除redis缓存
            $redis = yii::$app->redis;
            $redisDeleteResult = $redis->executeCommand('DEL', [md5($mysqlRecord->keyword . '-synonyms')]);
            $mysqlDeleteResult = $mysqlRecord->delete();
        }
        $deleteResult = $redisDeleteResult && $mysqlDeleteResult;
        $returnResult = ['res' => $deleteResult];
        //echo json_encode($returnResult);
        $this->redirect(yii::$app->urlManager->createUrl(['admin/tag/index']));
    }

    /**
     * 修改指定id下一个关键字的同义词设置
     */
    public function actionUpdateSynonyms()
    {
        $id = yii::$app->request->post("id");
        $synonyms = yii::$app->request->post("synonyms");
        $hot = yii::$app->request->post("hot");

        $mysqlUpdateResult = false;
        $redisUpdateResult = false;

        $mysqlRecord = SynonymsModel::find()
            ->where(['id' => $id])
            ->one();
        if ($mysqlRecord)
        {
            //更新mysql记录
            $mysqlRecord->synonyms = $synonyms;
            $mysqlRecord->hot = $hot;
            $mysqlUpdateResult = $mysqlRecord->update();
            //更新redis记录
            $redisUpdateResult = yii::$app->sphinx->writeCache($mysqlRecord->keyword . '-syonoyms', json_encode(explode(',', $synonyms)));
        }
        $updateResult = ($mysqlUpdateResult >= 0) && $redisUpdateResult;
        $returnResult = ['res' => $updateResult, 'data' => $synonyms];
        echo json_encode($returnResult);
    }

    /**
     * 获取指定关键字的同义词配置
     * @return string JSON格式的同义词数组字符串(包含给定的关键词)
     */
    public function actionGetSynonyms($keyword)
    {
        //读取redis中缓存的同义词配置
        $redisRecord = yii::$app->redis->get(base64_encode($keyword) . '-synonyms');
        if ($redisRecord)
        {
            return $redisRecord;
        }
        else
        {
            $mysqlRecord = SynonymsModel::find()
                ->where(['keyword' => $keyword])
                ->one();
            //找到相关同义词配置
            if ($mysqlRecord)
            {
                $synonymsString = $keyword . ',' . $mysqlRecord->synonyms;
            }
            else
            {
                //未找到同义词配置,返回关键字本身
                $synonymsString = $keyword;
            }
            $result = json_encode(explode(',', $synonymsString));
            yii::$app->sphinx->writeCache($keyword . '-syonoyms', $result);
            return $result;
        }
    }

    /**
     * 获取当前所有已配置的搜索关键词
     */
    public function actionListSynonyms()
    {
        $synonymsList = SynonymsModel::find()
            ->all();
        echo json_encode(yii\helpers\ArrayHelper::getColumn($synonymsList, 'attributes'));
    }

    /**
     * 读取搜索记录
     * @return string JSON格式搜索访问记录
     */
    public function actionGetSearchRecord()
    {
        $redisRecord = yii::$app->sphinx->readCache('search-record');
        return $redisRecord;
    }

    /**
     * 分类关键词搜索
     */
    public function actionIsearch($industry)
    {
        $rootModel = Industry::find()
            ->where(['name' => $industry])
            ->one();
        $root = $rootModel->root;
        $level = $rootModel->lvl;

        $targets = Industry::find()
            ->where(['root' => $root])
            ->andWhere(['>', 'lvl', $level])
            ->all();
        $tagetKeyWords = ArrayHelper::getColumn(ArrayHelper::getColumn($targets, 'attributes'), 'name');
        $tagetKeyWords[count($tagetKeyWords) + 1] = $industry;
    }

    /**
     * 清空redis中存储的搜索结果缓存和同义词缓存
     */
    public function actionClearRedisCache()
    {
        $redis = yii::$app->redis;
        $deleteCount = $redisDeleteResult = $redis->executeCommand('FLUSHDB');
        return json_encode(['res' => $deleteCount]);
    }

    /**
     * 根据搜索访问频率修改既有标签热度(计划任务定时更新)
     */
    public function actionUpdateHot()
    {
        $redisRecord = yii::$app->sphinx->readCache('search-record');
        $record = json_decode($redisRecord);
        foreach ($record as $key => $value)
        {
            $synonyms = SynonymsModel::find()
                ->where(['keyword' => $key])
                ->one();
            if ($synonyms)
            {
                echo $key;
                $synonyms->hot = $value;
                $res = $synonyms->update();
                var_dump($res);
            }
        }
    }

    /**
     * 推荐位搜索
     * @param $keyword
     * @return array
     */
    public function searchRecommend($keyword)
    {
        $data = SynonymsModel::find()
            ->where(['keyword' => $keyword])
            ->with('link')
            ->with('user')
            ->one();
        if ($data)
        {
            $ads = $data->link;
            $users = $data->user;

            $ad = [];
            foreach ($ads as $key => $value)
            {
                if ($value->link)
                {
                    $ad[$key] = $value->link;
                }
            }
            $user = [];
            foreach ($users as $key => $value)
            {
                if ($value->user)
                {
                    $user[$key] = $value->user;
                }
            }
            return ['rec_ads' => ArrayHelper::getColumn($ad, 'attributes'),
                'rec_users' => ArrayHelper::getColumn($user, 'attributes')
            ];
        }
        else
        {
            return ['rec_ads' => [],
                'rec_users' => []
            ];
        }
    }

    /**
     * 更新sphinx索引中的关注数量字段的值
     * @param $id
     * @param $value
     */
    public function actionUpdateFocus($id, $value)
    {
        yii::$app->sphinx->updateFocus($id, $value);
    }

    /**
     * 排行榜数据接口
     * @return string JSON格式字符串
     */
    public function actionRank()
    {
        return yii::$app->sphinx->rank();
    }
}