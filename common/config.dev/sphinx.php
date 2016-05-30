<?php
/**
 * cache                是否开启redis缓存sphinx查询结果
 * expire               缓存过期时间(second)
 * encodekey            是否MD5加密redis数据键
 * host                 searchd服务地址
 * port                 searchd服务通信端口
 * index                索引名称
 * match_mode           匹配模式
 * keyword_template     匹配模板 %s为占位符,运行时会被提交的搜索字符串替换
 * sort_mode            排序模式
 * sort_template        排序模板
 */
return [
    'cache' => false,
    'expire' => 300,
    'encodekey' => false,
    'host' => '192.168.2.5',
    'port' => 9312,
    'index' => [
        //企业信息
        'enterprise' =>
            [
                'match_mode' => SPH_MATCH_EXTENDED2,
                'keyword_template' => '(@(nickname,truename) %s)',
                'sort_mode' => SPH_SORT_EXTENDED,
                'sort_template' => 'nickname ASC,work_count DESC,focus_num DESC'
            ],
        //人才信息
        'talent' =>
            [
                'match_mode' => SPH_MATCH_EXTENDED2,
                'keyword_template' => '(@(nickname,truename,name) %s)',
                'sort_mode' => SPH_SORT_EXTENDED,
                'sort_template' => 'nickname ASC,work_count DESC,focus_num DESC'
            ],
        //项目
        'project' =>
            [
                'match_mode' => SPH_MATCH_EXTENDED2,
                'keyword_template' => '(@(proj_type,proj_name,proj_sub_name,proj_tag,indus_name) %s)',
                'sort_mode' => SPH_SORT_RELEVANCE,
                'sort_template' => ''
            ],
        //作品
        'work' =>
            [
                'match_mode' => SPH_MATCH_EXTENDED2,
                'keyword_template' => '(@(work_name) %s)',
                'sort_mode' => SPH_SORT_EXTENDED,
                'sort_template' => 'likenum DESC'
            ],
        'enterprise,talent' =>
            [
                'match_mode' => SPH_MATCH_EXTENDED2,
                'keyword_template' => '(@(nickname,truename,name) %s)',
		'recuser_keyword_template' => '(@(username) %s)',
                'sort_mode' => SPH_SORT_EXTENDED,
                'sort_template' => 'nickname ASC,work_count DESC,focus_num DESC'
            ],
        '*' =>
            [
                'match_mode' => SPH_MATCH_ALL,
                'keyword_template' => '%s',
                'sort_mode' => SPH_SORT_RELEVANCE,
                'sort_template' => ''
            ]
    ]
];