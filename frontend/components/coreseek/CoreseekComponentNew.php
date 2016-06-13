<?php
namespace frontend\components\coreseek;

use yii;
use yii\base\Component;
use frontend\components\coreseek\SphinxClient;
use frontend\modules\tag\models\TagRecommendLinkModel;
use frontend\modules\tag\models\TagRecommendUserModel;
use frontend\modules\tag\models\RecommendLinkModel;
use frontend\modules\tag\models\SynonymsModel;
use app\modules\industry\models\Industry;
use yii\helpers\ArrayHelper;

/**
 * Sphinx搜索公共组件
 * Class CoreseekComponentNew
 * @package frontend\components\coreseek
 */
class CoreseekComponentNew extends Component
{
    /**
     * Sphinx API 对象
     */
    public $sphinxClient;

    /**
     * Sphinx.php中的配置信息数组
     */
    public $sphinxConfig;

    /**
     * 初始化SphinxClient
     */
    public function init()
    {
        $this->sphinxConfig = yii::$app->params['sphinx'];
        $this->sphinxClient = new SphinxClient();
        $this->sphinxClient->SetServer($this->sphinxConfig['host'], $this->sphinxConfig['port']);
        //重置sphinx的默认匹配规则、排序规则、过滤器和分组规则
        $this->sphinxClient->SetMatchMode(SPH_MATCH_ALL);
        $this->sphinxClient->SetSortMode(SPH_SORT_RELEVANCE);
        $this->sphinxClient->ResetFilters();
        $this->sphinxClient->ResetGroupBy();
        parent::init();
    }

    /**
     * 全局搜索
     * @param $inputKeyword string 搜索关键字
     * @param $offset int 分页起始点
     * @param $limit int 分页数据量
     * @param $indexName string 索引名称
     * @param $orderBy string 排序规则
     * @param $indus string 行业id
     * @return array 全局搜索结果
     */
    public function search($inputKeyword, $offset = 0, $limit = 1000, $indexName = 'enterprise,talent', $orderBy = '', $indus = '', $residency = '', $isIndusRoot=true)
    {
        $keyword = urldecode($inputKeyword);
        if ($indexName == '*')
        {
            //搜索索引为*时,执行全索引查询
            return $this->searchAllIndex($keyword, $offset, $limit);
        }
        //构造搜索关键字
        $keyword = $this->buildSphinxSearchString($keyword, $indexName);
        $searchResult = $this->searchSphinx($keyword, $offset, $limit, $indexName, $orderBy, $indus, $residency, $isIndusRoot);
        //查询推荐位
        $recs = $this->searchRecommend(urldecode($inputKeyword));
        $searchResult['rec_ads'] = $recs['rec_ads'];
        $usernames = ArrayHelper::getColumn($recs['rec_users'], 'username');
        $usernameSearchString = $this->buildSphinxSearchString(implode(' ', $usernames), 'enterprise,talent',true);//官方推荐依据username
        //如果默认的都没有配置,就无官方推荐数据
        if(empty($usernameSearchString))
        {
            $searchResult['rec_users'] = [];
        }
        else
        {
            $sphinxRecUsers = yii::$app->sphinx->searchSphinx($usernameSearchString, 0, 1000, 'enterprise,talent');
            $searchResult['rec_users'] = $sphinxRecUsers['rc'];
        }
        return $searchResult;
    }

    /**
     * 全索引搜索
     * @param $keyword string 关键字
     * @param $offset int 分页起始点
     * @param $limit int 分页数据量
     * @return array
     */
    private function searchAllIndex($keyword, $offset, $limit)
    {
        $rc = $this->searchSphinx('@(nickname,truename,name) ' . $keyword, $offset, $limit, 'enterprise,talent');
//        $project = $this->searchSphinx('@(proj_type,proj_name,proj_sub_name,proj_tag,indus_name) ' . $keyword, $offset, $limit, 'project');
        $work = $this->searchSphinx('@(work_name,username) ' . $keyword, $offset, $limit, 'work');
        $result = ['rc' => $rc['rc'], 'work' => $work['rc']];
        $recs = $this->searchRecommend(urldecode($keyword));
        $result['rec_ads'] = $recs['rec_ads'];
        $usernames = ArrayHelper::getColumn($recs['rec_users'], 'username');
        $usernameSearchString = $this->buildSphinxSearchString(implode(' ', $usernames), 'enterprise,talent',true);
        $usernameSearchString = str_replace('&', '|', $usernameSearchString);
        //如果默认的都没有配置,就无官方推荐数据
        if(empty($usernameSearchString))
        {
            $result['rec_users'] = [];
        }
        else
        {
            $sphinxRecUsers = yii::$app->sphinx->searchSphinx($usernameSearchString, 0, 1000, 'enterprise,talent');
            $result['rec_users'] = $sphinxRecUsers['rc'];
        }
        return $result;
    }

    /**
     * 全局搜索同search(),为兼容上一版本而存在
     * @param $inputKeyword
     * @param int $offset
     * @param int $limit
     * @param string $indexName
     * @param string $orderBy
     * @param string $indus
     * @return array
     */
    public function search2($inputKeyword, $offset = 0, $limit = 1000, $indexName = 'enterprise,talent', $orderBy = '', $indus = '', $residency = '', $isIndusRoot=true)
    {
        return $this->search($inputKeyword, $offset, $limit, $indexName, $orderBy, $indus, $residency, $isIndusRoot);
    }

    /**
     * 调用sphinx进行搜索
     * @param $keyword
     * @param int $offset
     * @param int $limit
     * @param string $indexName
     * @param string $orderBy
     * @param string $indus
     * @return array
     */
    public function searchSphinx($keyword, $offset = 0, $limit = 1000, $indexName = 'enterprise,talent', $orderBy = '', $indus = '', $residency= '', $isIndusRoot=true)
    {
        //设置搜索匹配方式
        $this->setMatchMode($indexName, $keyword);
        //设置排序规则
        $this->setSortMode($indexName, $orderBy);
        //设置过滤器
        $this->setFilter($indexName, $indus, $residency, $isIndusRoot);
//        $this->setFilterRes($indexName, $residency);
        //设置分页
        $this->setLimit($offset, $limit);
        //执行搜索
        $result = $this->sphinxClient->Query($keyword, $indexName);
        $error = $this->sphinxClient->GetLastError();
        if ($error)
        {
            //发生搜索异常
            yii::error("Sphinx search exception : " . $error);
            yii::error('keyword : ' . $keyword);
            if (YII_DEBUG)
            {
                var_dump($error, $keyword);
                exit;
            }
            return ['total_count' => 0, 'rc' => []];
        }
        else
        {
            $re = $this->handleResult($result);
            if (!empty($re['rc']))
            {
                //人才搜索级联查询作品信息
                if ($indexName == 'enterprise' || $indexName == 'talent' || $indexName == 'enterprise,talent')
                {
                    $re['rc'] = $this->cascadeSearchWorks($re['rc']);
                }
            }
            else
            {
                //完整搜索为查找到结果时,分拆搜索字符串,分别搜索取并集
                $subKeywords = explode('&', $keyword);
                if (count($subKeywords) > 1)
                {
                    foreach ($subKeywords as $sk)
                    {
                        $this->sphinxClient->AddQuery($sk, $indexName);
                    }
                    $re = $this->batchHandleResult($this->sphinxClient->RunQueries(), $indexName);
                }
            }
            return $re;
        }
    }

    /**
     * 构造Sphinx搜索字符串
     * @param $keyword string 用户输入的搜索词
     * @param $indexName string 要搜索的索引名称
     * @return string sphinx搜索字符串
     */
    private function buildSphinxSearchString($keyword, $indexName, $isrecuser=false)
    {
        $sphinxSearchString = '';
        //搜索词是否包含空格,启动手动分词
        $keywordArray = explode(' ', $keyword);
        if (count($keywordArray) > 1)
        {
            //搜索詞包含空格
            //按照配置项构造搜索词
            foreach ($keywordArray as $subKeyword)
            {
                //获取分词的同义词
                $subKeywordSynonyms = json_decode($this->getSynonyms($subKeyword));
                $temp = '';
                foreach ($subKeywordSynonyms as $word)
                {
                    if ($word)
                    {
                        //搜索索引是否为*
                        if ($indexName == '*')
                        {
                            $temp .= $word . ' | ';
                        }
                        else
                        {
                            //获取搜索词的同义词配置
                            $this->sphinxConfig;
                            $template = $isrecuser?$this->sphinxConfig['index'][$indexName]['recuser_keyword_template']:$this->sphinxConfig['index'][$indexName]['keyword_template'];
                            $temp .= sprintf($template, $word) . ' | ';
                        }
                    }
                }
                $sphinxSearchString .= '(' . substr($temp, 0, (strlen($temp) - 2)) . ') & ';
            }
            $sphinxSearchString = substr($sphinxSearchString, 0, (strlen($sphinxSearchString) - 2));
        }
        else
        {
            $subKeywordSynonyms = json_decode($this->getSynonyms($keyword));
            foreach ($subKeywordSynonyms as $word)
            {
                if ($word)
                {
                    //获取搜索词的同义词配置
                    $this->sphinxConfig;
                    $template = $isrecuser?$this->sphinxConfig['index'][$indexName]['recuser_keyword_template']:$this->sphinxConfig['index'][$indexName]['keyword_template'];
                    $sphinxSearchString .= sprintf($template, $word) . ' | ';
                }
            }
            $sphinxSearchString = substr($sphinxSearchString, 0, (strlen($sphinxSearchString) - 2));
        }
        return $sphinxSearchString;
    }

    /**
     * 设置搜索匹配模式
     * @param $indexName
     * @param $keyword
     */
    private function setMatchMode($indexName, $keyword)
    {
        //判断搜索索引是否为*
        if ($indexName == '*')
        {
            $this->sphinxClient->SetMatchMode(SPH_MATCH_ALL);
        }
        else
        {
            //按照配置設置搜索配置
            $this->sphinxClient->SetMatchMode(SPH_MATCH_EXTENDED2);
        }
    }

    /**
     * 设置匹配规则
     * @param $indexName
     * @param $orderBy
     */
    private function setSortMode($indexName, $orderBy = '')
    {
        if ($indexName != '*')
        {
            if ($orderBy)
            {
                $this->sphinxClient->SetSortMode(SPH_SORT_EXTENDED, $orderBy);
            }
        }
    }

    /**
     * 设置过滤器
     * @param $indexName
     * @param $indus
     */
    private function setFilter($indexName, $indus, $residency,$isIndusRoot)
    {

        if ($indus||$residency)
        {
            if ($indus)
            {
                //搜索企业时过滤行业
                if ($indexName == 'enterprise'||$indexName == 'talent'||$indexName == 'enterprise,talent')
                {
                    if ($indus && strpos($indus, ',') > 0)
                    {
                        $indusArr = explode(',', $indus);
                        if($isIndusRoot)
                        {
                            $this->sphinxClient->SetFilter('indus_pid', $indusArr);
                        }
                        else
                        {
                            $this->sphinxClient->SetFilter('indus_id', $indusArr);
                        }

                    }
                    else
                    {
                        if($isIndusRoot)
                        {
                            $this->sphinxClient->SetFilter('indus_pid', [$indus]);
                        }
                        else
                        {
                            $this->sphinxClient->SetFilter('indus_id', [$indus]);
                        }
                    }
                }
            }
            if ($residency)
            {
                //搜索企业时过滤行业
                if ($indexName == 'enterprise'||$indexName == 'talent'||$indexName == 'enterprise,talent')
                {
                     $this->sphinxClient->SetFilter('residency', [crc32($residency)]);
                }
            }            //搜索作品时,过滤uid
            if ($indexName == 'work')
            {
                if ($indus)
                {
                    $this->sphinxClient->SetFilter('uid', [$indus]);
                }
            }
        }
        else
        {
            //没有过滤字段时,重置过滤器
            $this->sphinxClient->ResetFilters();
        }
    }
    /**
     * 设置过滤器
     * @param $indexName
     * @param $indus
     */
    private function setFilterRes($indexName,  $residency)
    {
        if ($residency)
        {
            //搜索企业时过滤行业
            if ($indexName == 'enterprise'||$indexName == 'talent'||$indexName == 'enterprise,talent')
            {
                 $this->sphinxClient->SetFilter('residency', [crc32($residency)]);
            }
        }
        else
        {
            //没有过滤字段时,重置过滤器
            $this->sphinxClient->ResetFilters();
        }
    }
    /**
     * 设置分页
     * @param $offset
     * @param $limit
     */
    private function setLimit($offset, $limit)
    {
        $this->sphinxClient->SetLimits((int)$offset, (int)$limit);
    }

    /**
     * 获取指定关键字的同义词配置
     * @return string JSON格式的同义词数组字符串(包含给定的关键词)
     */
    public function getSynonyms($keyword)
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
        return ['total_count' => $sphinxResult['total_found'], 'rc' => $result];
    }

    /**
     * 处理批量查询搜索结果
     * @param $sphinxResult array sphinx批量搜索结果
     * @param $indexName string 索引名称
     * @return array
     */
    private function batchHandleResult($sphinxResult, $indexName)
    {
        $total_found = 0;
        $rc = [];
        for ($i = 0; $i < count($sphinxResult); $i++)
        {
            $singleResult = $this->handleResult($sphinxResult[$i]);
            $total_found += $singleResult['total_count'];
            if ($indexName == 'enterprise' || $indexName == 'talent' || $indexName == 'enterprise,talent')
            {
                $singleResult['rc'] = $this->cascadeSearchWorks($singleResult['rc']);
            }
            $rc = array_merge($rc, $singleResult['rc']);
        }
        return ['total_count' => $total_found, 'rc' => $rc];
    }

    /**
     * 根据所给企业或人才级联查询作品信息
     * @param $enterpriseOrTalents
     */
    private function cascadeSearchWorks($enterpriseOrTalents)
    {
        $this->sphinxClient->ResetFilters();
        $this->setSortMode('work');
        $this->sphinxClient->SetSortMode(SPH_SORT_RELEVANCE);
        $template = $this->sphinxConfig['index']['work']['keyword_template'];
        foreach ($enterpriseOrTalents as $unique => $eot)
        {
            $string = '@(work_name,username) ' . $eot['username'];
            $this->sphinxClient->SetMatchMode(SPH_MATCH_EXTENDED2);
            //根据username级联查询作品
            $enterpriseOrTalents[$unique]['work'] = $this->searchSphinx($string, 0, 1000, 'work', '', ''); //$this->searchSphinx($eot['username'], 'work'), 'work');
        }
        return $enterpriseOrTalents;
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
     * 人才排行榜
     */
    public function rank($industry = '', $offset = 0, $limit = 10)
    {
        //根据当前索引$index设置排序规则
        $this->sphinxClient->SetSortMode(SPH_SORT_EXTENDED, 'score DESC');
        //根据配置值设置匹配模式
        $this->sphinxClient->SetMatchMode(SPH_MATCH_EXTENDED2);
        //读取当前匹配模式下的关键词搜索方案
        $this->sphinxClient->SetLimits($offset, $limit);
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
            $data = $result['rc'];
            $data = $this->cascadeSearchWorks($data);
            $result['rc'] = $data;
            return $result;
        }
    }

    /**
     * 更新粉丝数
     * @param $id
     * @param $value
     * @return mixed
     */
    public function updateFocus($id, $value)
    {
        $res = $this->sphinxClient->UpdateAttributes('enterprise', ['focus_num'], [$id => [(int)$value]]);
        $res += $this->sphinxClient->UpdateAttributes('talent', ['focus_num'], [$id => [(int)$value]]);
        return $res;
    }
}


