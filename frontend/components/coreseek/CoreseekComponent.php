<?php
frontend frontend\components\coreseek;

use yii;
use yii\base\Component;
use frontend\components\coreseek\SphinxClient;
use frontend\modules\tag\models\TagRecommendLinkModel;
use frontend\modules\tag\models\TagRecommendUserModel;
use frontend\modules\tag\models\RecommendLinkModel;
use frontend\modules\tag\models\SynonymsModel;
use app\modules\industry\models\Industry;
use yii\helpers\ArrayHelper;

class CoreseekComponent extends Component
{
    public $sphinxClient;
    public $sphinxConfig;

    public function init()
    {
        $this->sphinxConfig = yii::$app->params['sphinx'];
        $this->sphinxClient = new SphinxClient();
        $this->sphinxClient->SetServer($this->sphinxConfig['host'], $this->sphinxConfig['port']);
        parent::init();
    }

    /**
     * 全站搜索入口
     * @param $limit
     * @param $offset
     * @param string $index
     * @param string $orderby
     * @return array|string
     */
    public function actionSearch($keyword, $limit, $offset = 0, $index = 'enterprise,talent', $orderby = '')
    {
        $keyword = urldecode($keyword);
        $indexInput = yii::$app->request->get('index');
        if (isset($indexInput) && !empty($indexInput))
        {
            $index = $indexInput;
        }
        $orderbyInput = yii::$app->request->get('orderby');
        if (isset($orderbyInput) && !empty($orderbyInput))
        {
            $orderby = $orderbyInput;
        }
        $offsetInput = yii::$app->request->get('offset');
        if (isset($offsetInput) && !empty($offsetInput))
        {
            $offset = $offsetInput;
        }
        //存储搜索记录
        $this->saveSearchRecord($keyword);
        //从redis读取缓存的搜索结果
        $redisSearchResult = $this->readCache($keyword . '-search-' . $offset . '-' . $limit);
        if ($redisSearchResult)
        {
            //缓存中有搜索结果,直接返回
            return $redisSearchResult;
        }
        else
        {
            //非全库搜索
            if ($index != '*')
            {
                $result = [];
                $rc = $this->searchSphinx($keyword, $limit, $offset, $index, $orderby);
                $total = empty($rc) || $rc['total_count'] == null ? 0 : $rc['total_count'];
                $result['total_count'] = $total;
                $rc = empty($rc) ? [] : $rc['data'];
                if ($index == 'enterprise' || $index == 'talent' || $index == 'enterprise,talent')
                {
                    $rc = $this->cascadeSearchWorks($rc);
                    $result['rc'] = $rc == null ? [] : $rc;
                }
                else
                {
                    $result[$index] = $rc;
                }
                $recs = $this->searchRecommend($keyword);
                $result['rec_ads'] = $recs['rec_ads'];
                $str = $this->constructSearchString(ArrayHelper::getColumn($recs['rec_users'], 'username'), 'enterprise,talent');
                //没有配置推荐人才,不从sphinx搜索
                if ($str)
                {
                    $recUserS = $this->searchFromSphinx($str, 'enterprise,talent');
                }
                else
                {
                    $recUserS = ['data' => []];
                }
                $recUserS = $recUserS['data'];
                $recUserS = $this->cascadeSearchWorks($recUserS);
                $result['rec_users'] = $recUserS;
                //缓存中不存在相应的搜索结果,从sphinx中搜索结果
                $result = json_encode($result);
                //将sphinx搜索到的结果缓存到redis
                $this->writeCache($keyword . '-search-' . $offset . '-' . $limit, $result);
                return $result;
            }
            else
            {
                //全库搜索
                $rc = $this->searchFromSphinx($this->constructSearchString($keyword, 'enterprise,talent'), 'enterprise,talent', 2, 0, '');
                $work = $this->searchFromSphinx($this->constructSearchString($keyword, 'work'), 'work', 2, 0, '');
                $project = $this->searchFromSphinx($this->constructSearchString($keyword, 'project'), 'project', 2, 0, '');
//                $rec = $this->searchRecommend($keyword);
                $result = ['rc' => $rc['data'], 'work' => $work['data'], 'project' => $project['data'], //                    'rec_ad' => $rec['rec_ads'],
//                    'rec_user' => $rec['rec_users']
                ];
                return json_encode($result);
            }
        }
    }

    /**
     * 全站搜索
     * @param $keyword string 搜索关键字
     * @param $limit integer 分页数量
     * @param $offset integer 分页起始点
     * @param $index string  索引名称
     * @param $orderby string
     * @return array
     */
    private function searchSphinx($keyword, $limit, $offset, $index, $orderby = '')
    {
        //初始化分类结果存储数组
        $result = [];
        //读取关键字的同义词配置
        if ($index != '*')
        {
            $keywordsString = $this->actionGetSynonyms($keyword);
            $keywords = json_decode($keywordsString);
        }
        else
        {
            $keywords = $keyword;
        }
        $this->setSphinxSortMode($index);
        $result = $this->searchFromSphinx($this->constructSearchString($keywords, $index), $index, $limit, $offset, $orderby);
        //企业、人才级联查询作品信息
        return $result;
    }

    /**
     * 根据岁所给企业或人才级联查询作品信息
     * @param $enterpriseOrTalents
     */
    private function cascadeSearchWorks($enterpriseOrTalents)
    {
        foreach ($enterpriseOrTalents as $unique => $eot)
        {
            //根据username级联查询作品
            $this->setSphinxSortMode('work');
            $enterpriseOrTalents[$unique]['work'] = $this->searchFromSphinx($this->constructSearchString($eot['username'], 'work'), 'work');
        }
        return $enterpriseOrTalents;
    }

    /**
     * 从Sphinx查询数据
     * @param $keyword string 关键字
     * @param $index string 索引名称
     * @param int $limit
     * @param int $offset
     * @param string $orderby
     * @return array
     */
    public function searchFromSphinx($keyword, $index, $limit = 1000, $offset = 0, $orderby = '')
    {
        //根据当前索引$index设置排序规则
        $this->setSphinxSortMode($index);
        if (isset($orderby) && !empty($orderby) && $orderby != '')
        {
            $this->sphinxClient->SetSortMode(SPH_SORT_EXTENDED, $orderby);
        }
        //根据配置值设置匹配模式
        $this->sphinxClient->SetMatchMode($this->sphinxConfig['index'][$index]['match_mode']);
        //读取当前匹配模式下的关键词搜索方案
        $this->sphinxClient->SetLimits((int)$offset, (int)$limit);

        $result = $this->sphinxClient->Query($keyword, $index);
        $error = $this->sphinxClient->GetLastError();
        if ($error)
        {
            yii::error("Sphinx search exception : " . $error);
            yii::error('keyword : ' . $keyword);
            if (YII_DEBUG)
            {
                var_dump($error, $keyword);
                exit;
            }
            return [];
        }
        else
        {
            $re = $this->handleResult($result);
            $handleResult = ['total_count' => 0, 'data' => []];
            if ($re['total_count'] == 0 && strpos($keyword, '&') > 0)
            {
                $splitKw = explode('&', $keyword);
                for ($i = 0; $i < count($splitKw); $i++)
                {
                    $subre = $this->searchFromSphinx($splitKw[$i], $index, $limit, $offset, $orderby);
                    if ($subre['total_count'] > 0)
                    {
                        $handleResult['total_count'] = $subre['total_count'];
                        $handleResult['data'] = array_merge($handleResult['data'],$subre['data']);
                    }
                }
                return ['total_count' => count($handleResult), 'data' => $handleResult['data']];
            }
            else
            {
                return $this->handleResult($result);
            }
        }
    }

    /**
     * 设置Sphinx查询结果的排序规则
     * @param $index string 查询的索引名称
     */
    private function setSphinxSortMode($index)
    {
        //读取sphinx配置,设置各个索引下的排序模式
        $sortModel = $this->sphinxConfig['index'][$index]['sort_mode'];
        $sortTemplate = $this->sphinxConfig['index'][$index]['sort_template'];
        $this->sphinxClient->SetSortMode($sortModel, $sortTemplate);
    }

    /**
     * 处理sphinx查询到的数据,按照常规格式进行整理
     * @param $sphinxResult array sphinx查询返回的数据
     * @return array
     */
    private function handleResult($sphinxResult)
    {
        $result = [];
        if (isset($sphinxResult['matches']) && !empty($sphinxResult['matches']))
        {
            $matches = $sphinxResult['matches'];
            foreach ($matches as $id => $value)
            {
                $value['attrs']['id'] = $id;
                $value['attrs'] = array_push($result, $value['attrs']);
            }
        }
        return ['total_count' => $sphinxResult['total_found'], 'data' => $result];
    }

    /**
     * 记录搜索记录
     */
    private function saveSearchRecord($keyword)
    {
        $redisRecord = $this->readCache('search-record');
        if (!$redisRecord)
        {
            $record = [$keyword => 1];
            $this->writeCache('search-record', json_encode($record));
        }
        else
        {
            $redisRecord = json_decode($redisRecord);
            if (isset($redisRecord->$keyword))
            {
                $redisRecord->$keyword += 1;
            }
            $this->writeCache('search-record', json_encode($redisRecord));
        }
    }

    /**
     * 推荐位搜索
     * @param $keyword
     * @return array
     */
    public function searchRecommend($keyword)
    {
        $data = SynonymsModel::find()->where(['keyword' => $keyword])->with('link')->with('user')->one();
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
            //如果推荐位数据为空,返回默认推荐位数据
            $recAds = ArrayHelper::getColumn($ad, 'attributes');
            $recUsers = ArrayHelper::getColumn($user, 'attributes');
            if (count($recAds) == 0)
            {
                $recAds = RecommendLinkModel::find()->where(['as_default' => 1])->all();
                $recAds = ArrayHelper::getColumn($recAds, 'attributes');
            }
            if (count($recUsers) == 0)
            {
                $recUsers = TagRecommendUserModel::find()->where(['tag_id' => 1])->with('user')->all();
                $recUsers = ArrayHelper::getColumn($recUsers, 'attributes');
            }
            return ['rec_ads' => $recAds, 'rec_users' => $recUsers];
        }
        else
        {
            $recAds = RecommendLinkModel::find()->where(['as_default' => 1])->all();
            $recAds = ArrayHelper::getColumn($recAds, 'attributes');

            $recUsers = TagRecommendUserModel::find()->where(['tag_id' => 1])->with('user')->asArray()->all();
            $recUsers = ArrayHelper::getColumn($recUsers, 'user');
            return ['rec_ads' => $recAds, 'rec_users' => $recUsers];
        }
    }

    /**
     * 缓存数据到redis
     * @param $key
     * @return null
     */
    public function readCache($key)
    {
        if (yii::$app->params['sphinx']['cache'])
        {
            $redis = yii::$app->redis;
            $key = yii::$app->params['sphinx']['encodekey'] ? md5($key) : $key;
            return $redis->get($key);
        }
        else
        {
            return null;
        }
    }

    /**
     * 从redis缓存中读取数据
     * @param $key
     * @param $value
     * @return bool
     */
    public function writeCache($key, $value)
    {
        if (yii::$app->params['sphinx']['cache'])
        {
            $redis = yii::$app->redis;
            $key = yii::$app->params['sphinx']['encodekey'] ? md5($key) : $key;
            return $redis->setex($key, yii::$app->params['sphinx']['expire'], $value);
        }
        else
        {
            return true;
        }
    }

    public function deleteCache($key)
    {
        if (yii::$app->params['sphinx']['cache'])
        {
            $redis = yii::$app->redis;
            return $redisDeleteResult = $redis->executeCommand('DEL', $key);
        }
        else
        {
            return true;
        }
    }

    /**
     * 构建搜索字符串
     * @param $synonyms array 同义词数组
     * @param $index string 索引
     * @return string
     */
    private function constructSearchString($synonyms, $index)
    {
        if ($index == '*')
        {
            return $synonyms;
        }
        if (is_array($synonyms))
        {
            for ($i = 0; $i < count($synonyms); $i++)
            {
                //转移特殊字符
                $word = $this->sphinxClient->EscapeString($synonyms[$i]);
                $synonyms[$i] = str_replace('%s', $word, $this->sphinxConfig['index'][$index]['keyword_template']);
            }
            return implode($synonyms, ' | ');
        }
        else
        {
            return str_replace('%s', $synonyms, $this->sphinxConfig['index'][$index]['keyword_template']);
        }
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
            $mysqlRecord = SynonymsModel::find()->where(['keyword' => $keyword])->one();
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
            $this->writeCache($keyword . '-syonoyms', $result);
            return $result;
        }
    }

    public function updateFocus($id, $value)
    {
        $res = $this->sphinxClient->UpdateAttributes('enterprise', ['focus_num'], [$id => [(int)$value]]);
        $res += $this->sphinxClient->UpdateAttributes('talent', ['focus_num'], [$id => [(int)$value]]);
        return $res;
    }

    /**
     * 人才排行榜
     */
    public function rank($industry = '')
    {
        //根据当前索引$index设置排序规则
        $this->sphinxClient->SetSortMode(SPH_SORT_EXTENDED, 'score DESC');
        //根据配置值设置匹配模式
        $this->sphinxClient->SetMatchMode(SPH_MATCH_EXTENDED2);
        //读取当前匹配模式下的关键词搜索方案
        $this->sphinxClient->SetLimits((int)0, (int)yii::$app->params['rank_limit']);
        if ($industry == '')
        {
            $result = $this->sphinxClient->Query('', 'talent');
        }
        else
        {
            $result = $this->sphinxClient->Query('@tag ' . $industry, 'talent');
        }
        $error = $this->sphinxClient->GetLastError();
        if ($error)
        {
            yii::error("Sphinx search exception : " . $error);
            return [];
        }
        else
        {
            $result = $this->handleResult($result);
            $data = $result['data'];
            $data = $this->cascadeSearchWorks($data);
            $result['data'] = $data;
            return json_encode($result);
        }
    }

    private function constructSearchString2($keyword, $index)
    {
        if ($index == '*')
        {
            return $keyword;
        }

        $joinWords = explode(' ', $keyword);
        if (count($joinWords) > 1)
        {
            $str = '';
            foreach ($joinWords as $w)
            {
                $temp = '(' . $this->constructSearchString(json_decode($this->actionGetSynonyms($w)), $index) . ') & ';
                $str .= $temp;
            }
            return substr($str, 0, strlen($str) - 2);
        }
        else
        {
            $synonyms = $this->actionGetSynonyms($keyword);
            return $this->constructSearchString(json_decode($synonyms), $index);
        }

        /*if (is_array($synonyms))
        {
            for ($i = 0; $i < count($synonyms); $i++)
            {
                //转移特殊字符
                $word = $this->sphinxClient->EscapeString($synonyms[$i]);
                $synonyms[$i] = str_replace('%s', $word, $this->sphinxConfig['index'][$index]['keyword_template']);
            }
            return implode($synonyms, ' | ');
        }
        else
        {
            return str_replace('%s', $synonyms, $this->sphinxConfig['index'][$index]['keyword_template']);
        }*/
    }

    public function test($keyword, $index)
    {
        var_dump($this->constructSearchString2($keyword, $index));
    }

    public function search2($keyword, $limit, $offset = 0, $index = 'enterprise,talent', $orderby = '')
    {
        $keyword = urldecode($keyword);
        $indexInput = yii::$app->request->get('index');
        if (isset($indexInput) && !empty($indexInput))
        {
            $index = $indexInput;
        }
        $orderbyInput = yii::$app->request->get('orderby');
        if (isset($orderbyInput) && !empty($orderbyInput))
        {
            $orderby = $orderbyInput;
        }
        $offsetInput = yii::$app->request->get('offset');
        if (isset($offsetInput) && !empty($offsetInput))
        {
            $offset = $offsetInput;
        }
        //存储搜索记录
        $this->saveSearchRecord($keyword);
        //从redis读取缓存的搜索结果
        $redisSearchResult = $this->readCache($keyword . '-search-' . $offset . '-' . $limit);
        if ($redisSearchResult)
        {
            //缓存中有搜索结果,直接返回
            return $redisSearchResult;
        }
        else
        {
            //非全库搜索
            if ($index != '*')
            {
                $result = [];
                $rc = $this->searchFromSphinx($this->constructSearchString2($keyword, $index), $index, $limit, $offset, $orderby = '');
                $total = empty($rc) || $rc['total_count'] == null ? 0 : $rc['total_count'];
                $result['total_count'] = $total;
                $rc = empty($rc) ? [] : $rc['data'];
                if ($index == 'enterprise' || $index == 'talent' || $index == 'enterprise,talent')
                {
                    $rc = $this->cascadeSearchWorks($rc);
                    $result['rc'] = $rc == null ? [] : $rc;
                }
                else
                {
                    $result[$index] = $rc;
                }
                $recs = $this->searchRecommend($keyword);
                $result['rec_ads'] = $recs['rec_ads'];
                $str = $this->constructSearchString(ArrayHelper::getColumn($recs['rec_users'], 'username'), 'enterprise,talent');
                //没有配置推荐人才,不从sphinx搜索
                if ($str)
                {
                    $recUserS = $this->searchFromSphinx($str, 'enterprise,talent');
                }
                else
                {
                    $recUserS = ['data' => []];
                }
                $recUserS = $recUserS['data'];
                $recUserS = $this->cascadeSearchWorks($recUserS);
                $result['rec_users'] = $recUserS;
                //缓存中不存在相应的搜索结果,从sphinx中搜索结果
                $result = json_encode($result);
                //将sphinx搜索到的结果缓存到redis
                $this->writeCache($keyword . '-search-' . $offset . '-' . $limit, $result);
                return $result;
            }
            else
            {
                //全库搜索
                $rc = $this->searchFromSphinx($this->constructSearchString2($keyword, $index), 'enterprise,talent', $limit, $offset, '');
                $rc['data'] = $this->cascadeSearchWorks($rc['data']);
                $work = $this->searchFromSphinx($this->constructSearchString2($keyword, $index), 'work', $limit, $offset, '');
                $project = $this->searchFromSphinx($this->constructSearchString2($keyword, $index), 'project', $limit, $offset, '');
//                $rec = $this->searchRecommend($keyword);
                $result = ['rc' => $rc['data'], 'work' => $work['data'], 'project' => $project['data'], //                    'rec_ad' => $rec['rec_ads'],
//                    'rec_user' => $rec['rec_users']
                ];
                $recs = $this->searchRecommend($keyword);
                $result['rec_ads'] = $recs['rec_ads'];
                $str = $this->constructSearchString(ArrayHelper::getColumn($recs['rec_users'], 'username'), 'enterprise,talent');
                //没有配置推荐人才,不从sphinx搜索
                if ($str)
                {
                    $recUserS = $this->searchFromSphinx($str, 'enterprise,talent');
                }
                else
                {
                    $recUserS = ['data' => []];
                }
                $recUserS = $recUserS['data'];
                $recUserS = $this->cascadeSearchWorks($recUserS);
                $result['rec_users'] = $recUserS;
                return json_encode($result);
            }
        }
    }

    /**
     * 全站搜索
     * @param $keyword string 搜索关键字
     * @param $limit integer 分页数量
     * @param $offset integer 分页起始点
     * @param $index string  索引名称
     * @param $orderby string
     * @return array
     */
    private function searchSphinx2($keyword, $limit, $offset, $index, $orderby = '')
    {
        $this->setSphinxSortMode($index);
        $result = $this->searchFromSphinx($this->constructSearchString2($keyword, $index), $index, $limit, $offset, $orderby);
        //企业、人才级联查询作品信息
        return $result;
    }
}
