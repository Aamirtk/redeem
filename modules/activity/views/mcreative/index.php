<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>百万创意创业大赛官网-创意空间maker.vsochina.com</title>
    <meta name="keywords" content="百万创意创业大赛,创意空间,创意项目"/>
    <meta name="description" content="百万大赛奖金、亿元创业资金支持；与文创及互联网大咖面对面碰撞；全程创业支持和辅导，免费对接行业资源。大赛面向全国征集优秀创意项目,寻找中国最具创意的年轻人和最具商业潜力的优秀项目。主办方蓝海创意云通过人才扶持、资金支持、免费提供在线软硬件资源、导师培养等多样化方式，采取线上入驻创意空间和线下入驻创客空间，对优秀创意项目进行孵化。"/>
    <meta name="renderer" content="webkit"/>
    <meta name="baidu-site-verification" content="NpzvG27pvo" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.3.5/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css" />
    <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/font/userWork/font.css" />
    <link type="text/css" rel="stylesheet" href="/css/activity-mcreative.css" />

    <script type="text/javascript" charset="utf-8" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
</head>
<body>
    <!-- header -->
    <script type="text/javascript" charset="utf-8" src="http://maker.vsochina.com/js/maker_header.js"></script>

    <div class="mcreative-banner">
        <a href="http://maker.vsochina.com" class="mcreative-logo"><img src="/images/activity/mcreative/vsologo.png" alt="创意空间"></a>
        <div class="mcreative-nav clearfix">
            <ul class="mcreative-navlist clearfix">
                <li class="cur">
                    <a href="javascript:void(0);">
                        <p class="mcreative-navlist-ch">大赛首页</p>
                        <p class="mcreative-navlist-en">HOME</p>
                    </a>
                </li>
                <li>
                    <a href="news">
                        <p class="mcreative-navlist-ch">赛事新闻</p>
                        <p class="mcreative-navlist-en">NEWS</p>
                    </a>
                </li>
                <li>
                    <a href="intro">
                        <p class="mcreative-navlist-ch">大赛介绍</p>
                        <p class="mcreative-navlist-en">INTRO</p>
                    </a>
                </li>
                <li>
                    <a href="rules">
                        <p class="mcreative-navlist-ch">赛事规则</p>
                        <p class="mcreative-navlist-en">RULE</p>
                    </a>
                </li>
                <!--<li>
                    <a href="#mcreative_judge">
                        <p class="mcreative-navlist-ch">评委阵容</p>
                        <p class="mcreative-navlist-en">JUDGE</p>
                    </a>
                </li>-->
                <!--<li>
                    <a href="javascript:void(0);">
                        <p class="mcreative-navlist-ch">相关活动<i class="icon-hot">H</i></p>
                        <p class="mcreative-navlist-en">ACTIVITY</p>
                    </a>
                </li>-->
                <li>
                    <?php if($username):?>
                        <a href="https://cz.vsochina.com/project/project?t=mp">
                    <?php else:?>
                        <a href="javascript:openLoginpop()">
                    <?php endif;?>
                            <p class="mcreative-navlist-ch">项目审核<i class="icon-hot">H</i></p>
                            <p class="mcreative-navlist-en">CENSOR</p>
                        </a>
                </li>
            </ul>
            <?php if($username):?>
                <a href="https://cz.vsochina.com/project/project?t=mp" class="mcreative-entrance">
            <?php else:?>
                <a href="javascript:openLoginpop()" class="mcreative-entrance">
            <?php endif;?>
                    <p class="mcreative-entrance-ch">报名入口</p>
                    <p class="mcreative-entrance-en">ENTRANCE</p>
                    <i class="icon-triangle-top"></i>
                    <i class="icon-triangle-bottom"></i>
                </a>
        </div>
    </div>

    <div class="mcreative-part mcreative-whitepart">
        <div class="mcreative-titlebox ds-1200 clearfix">
            <div class="mcreative-title">
                <b></b>
                <span class="mcreative-title-ch">大赛赛程</span>
                <span class="mcreative-title-en">SCHEDULE</span>
            </div>
        </div>
        <div class="mcreative-schedule ds-1200">
            <ul class="mcreative-schedule-nav clearfix">
                <li class="active"><a>项目征集</a></li>
                <li class="unclick"><a style="cursor: default;">分赛区评选</a></li>
                <li class="unclick"><a style="cursor: default;">全国总决赛</a></li>
                <li class="unclick"><a style="cursor: default;">项目孵化</a></li>
            </ul>
            <div class="mcreative-schedule-slidewrap">
                <div class="mcreative-schedule-slideblock"></div>
            </div>
            <div class="mcreative-schedule-box">
                <div class="mcreative-schedule-content active">
                    <div class="mcreative-schedule-slideBox">
                        <a class="mcreative-slideBox-prev"></a>
                        <a class="mcreative-slideBox-next"></a>
                        <ul class="mcreative-slideBox-list clearfix">
                        </ul>
                    </div>
                </div>
                <div class="mcreative-schedule-content">
                    <div class="mcreative-schedule-slideBox">
                        <a class="mcreative-slideBox-prev"></a>
                        <ul class="mcreative-slideBox-list clearfix">
                        </ul>
                        <a class="mcreative-slideBox-next"></a>
                    </div>
                </div>
                <div class="mcreative-schedule-content">
                    <div class="mcreative-schedule-slideBox">
                        <a class="mcreative-slideBox-prev"></a>
                        <ul class="mcreative-slideBox-list clearfix">
                        </ul>
                        <a class="mcreative-slideBox-next"></a>
                    </div>
                </div>
                <div class="mcreative-schedule-content">
                    <div class="mcreative-schedule-slideBox">
                        <a class="mcreative-slideBox-prev"></a>
                        <ul class="mcreative-slideBox-list clearfix">
                        </ul>
                        <a class="mcreative-slideBox-next"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mcreative-part mcreative-blackpart">
        <div class="mcreative-blackpart-toptriwrap">
            <div class="mcreative-blackpart-toptri"></div>
        </div>
        <div class="mcreative-blackpart-bottriwrap">
            <div class="mcreative-blackpart-bottri"></div>
        </div>
        <div class="ds-1200 clearfix">
            <div class="mcreative-news pull-left">
                <div class="mcreative-titlebox clearfix">
                    <div class="mcreative-title">
                        <b></b>
                        <span class="mcreative-title-ch">赛事新闻</span>
                        <span class="mcreative-title-en">NEWS</span>
                    </div>
                    <a href="news" class="mcreative-more">+ MORE</a>
                </div>
                <ul class="mcreative-newslist">
                    <?php if(isset($news)):?>
                    <?php foreach($news as $new):?>
                        <li>
                            <a class="clearfix" href="<?=yii::$app->params['frontendurl'].'/studio/trends/detail?id='.$new['id']?>">
                                <i class="icon-dot"></i>
                                <span class="mcreative-newslist-type">官方新闻</span>
                                <i class="icon-separate">-</i>
                                <p class="mcreative-newslist-title"><?=$new['name']?></p>
                                <span class="mcreative-newslist-date"><?=date('Y/m/d',$new['create_time'])?></span>
                            </a>
                        </li>
                    <?php endforeach;?>
                    <?php endif;?>
                </ul>
            </div>
            <div class="mcreative-rank pull-right">
                <div class="mcreative-titlebox clearfix">
                    <div class="mcreative-title">
                        <b></b>
                        <span class="mcreative-title-ch">项目排行榜</span>
                        <span class="mcreative-title-en">RANKING</span>
                    </div>
                    <a target="view_window" href="http://maker.vsochina.com/project/default/list" class="mcreative-more">+ MORE</a>
                </div>
                <div class="mcreative-rank-topone">
                    <?php if(isset($rank[0])):?>
                        <a target="view_window" href="http://maker.vsochina.com/project/<?=$rank[0]['project_id']?>">
                            <dl>
                                <dt>
                                    <img src="<?=$rank[0]['project']['proj_icon']?>" style="width: 100px;" alt="<?=$rank[0]['project']['proj_name']?>">
                                    <span class="mcreative-topone-lt"><span class="topone-lt-bg"></span><span class="topone-lt-content">01</span></span>
                                </dt>
                                <dd class="mcreative-topone-title">《<?=$rank[0]['project']['proj_name']?>》</dd>
                                <dd class="mcreative-topone-studio"><?=$rank[0]['project']['studio']['studio_name']?></dd>
                                <dd class="mcreative-topone-tag">
                                    <?php if(is_array(($rank[0]['project']['studio']['cats']))):?>
                                        <?php foreach($rank[0]['project']['studio']['cats'] as $c):?>
                                            <?=$c['cat']['name']?> |
                                        <?php endforeach;?>
                                    <?php endif;?>
                                </dd>
                            </dl>
                        </a>
                    <?php endif;?>
                </div>
                <ul class="mcreative-rank-list">
                    <?php for($i=1;$i<count($rank);$i++):?>
                    <li>
                        <a target="view_window" class="clearfix" href="http://maker.vsochina.com/project/<?=$rank[$i]['project_id']?>">
                            <i class="icon-dot icon-bluedot"></i>
                            <p class="rank-list-title">《<?=$rank[$i]['project']['proj_name']?>》</p>
                            <p class="rank-list-ballot"><?=$rank[$i]['vote']?>票</p>
                        </a>
                    </li>
                    <?php endfor;?>

                </ul>
            </div>
        </div>
    </div>

    <div class="mcreative-part mcreative-whitepart">
        <div class="mcreative-titlebox ds-1200 clearfix">
            <div class="mcreative-title">
                <b></b>
                <span class="mcreative-title-ch">优质项目</span>
                <span class="mcreative-title-en">PROJECTS</span>
            </div>
            <a target="view_window" href="http://maker.vsochina.com/project/default/list" class="mcreative-more">+ MORE</a>
        </div>
        <div class="mcreative-projects ds-1200">
            <div class="row">
                <?php foreach($all_projs as $pr):?>
                    <?php if($pr['project']):?>
                        <div class="col-xs-3" data-id="">
                            <dl class="dsn-caselist-dl">
                                <dt><a target="view_window" href="http://maker.vsochina.com/project/<?=$pr['proj_id']?>"><img src="<?=$pr['project']['proj_icon']?>" alt="" width="289" height="165"></a></dt>
                                <dd class="ds-project-mark">
                                    <a target="view_window" href="http://maker.vsochina.com/project/<?=$pr['proj_id']?>"><?=isset($pr['project']['project_name'])?$pr['project']['project_name']:''?></a>
                                </dd>
                                <dd class="clearfix">
                                    <div class="mcreative-projects-studio pull-left"><?=$pr['project']['studio']['studio_name']?></div>
                                    <div class="mcreative-projects-support pull-right"><span class="color-blue"><?=$pr['fans_num']?></span>支持</div>
                                </dd>
                            </dl>
                        </div>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
        </div>
    </div>

    <div class="mcreative-part mcreative-blackpart">
        <div class="mcreative-blackpart-toptriwrap">
            <div class="mcreative-blackpart-toptri"></div>
        </div>
        <div class="mcreative-blackpart-bottriwrap">
            <div class="mcreative-blackpart-bottri"></div>
        </div>
        <div class="ds-1200 clearfix">
            <div class="mcreative-reward">
                <div class="mcreative-titlebox clearfix">
                    <div class="mcreative-title">
                        <b></b>
                        <span class="mcreative-title-ch">赛事奖金</span>
                        <span class="mcreative-title-en">AWARD</span>
                    </div>
                </div>
                <div class="mcreative-reward-map">
                    <img src="/images/activity/mcreative/map.png" alt="百万创意大赛赛区">
                </div>
                <div class="mcreative-reward-zone">
                    <div class="reward-zone-bg"></div>
                    <ul class="reward-zone-nav row">
                        <li class="col-xs-6 active"><a>分赛区</a></li>
                        <li class="col-xs-6"><a>总决赛</a></li>
                    </ul>
                    <div class="reward-zone-box">
                        <div class="reward-zone-content active">
                            <ul class="reward-zone-head row">
                                <li class="col-xs-2">组别</li>
                                <li class="col-xs-3">名次</li>
                                <li class="col-xs-4">奖励</li>
                                <li class="col-xs-3">人数</li>
                            </ul>
                            <div class="reward-zone-socialwrap row">
                                <div class="reward-zone-social col-xs-2">
                                    社会组
                                    <div class="reward-zone-rightcol"></div>
                                </div>
                                <div class="reward-zone-list col-xs-10">
                                    <div class="reward-zone-leftcol"></div>
                                    <div class="reward-zone-item row">
                                        <div class="col-sm-3">
                                            <span class="reward-zone-rank">
                                                <i class="reward-zone-rankno">1</i>
                                            </span>
                                        </div>
                                        <div class="reward-zone-money col-sm-4">20,000</div>
                                        <div class="reward-zone-count col-sm-3">1</div>
                                        <div class="reward-zone-bottomline"></div>
                                    </div>
                                    <div class="reward-zone-item row">
                                        <div class="reward-zone-topline"></div>
                                        <div class="col-sm-3">
                                            <span class="reward-zone-rank">
                                                <i class="reward-zone-rankno">2</i>
                                            </span>
                                        </div>
                                        <div class="reward-zone-money col-sm-4">10,000</div>
                                        <div class="reward-zone-count col-sm-3">2</div>
                                        <div class="reward-zone-bottomline"></div>
                                    </div>
                                    <div class="reward-zone-item row">
                                        <div class="reward-zone-topline"></div>
                                        <div class="col-sm-3">
                                            <span class="reward-zone-rank">
                                                <i class="reward-zone-rankno">3</i>
                                            </span>
                                        </div>
                                        <div class="reward-zone-money col-sm-4">6,000</div>
                                        <div class="reward-zone-count col-sm-3">3</div>
                                    </div>
                                </div>
                                <div class="reward-zone-bottomline"></div>
                            </div>
                            <div class="reward-zone-campuswrap row">
                                <div class="reward-zone-topline"></div>
                                <div class="reward-zone-campus col-xs-2">
                                    学生组
                                    <div class="reward-zone-rightcol"></div>
                                </div>
                                <div class="reward-zone-list col-xs-10">
                                    <div class="reward-zone-leftcol"></div>
                                    <div class="reward-zone-item row">
                                        <div class="col-sm-3">
                                            <span class="reward-zone-rank">
                                                <i class="reward-zone-rankno">1</i>
                                            </span>
                                        </div>
                                        <div class="reward-zone-money col-sm-4">10,000</div>
                                        <div class="reward-zone-count col-sm-3">1</div>
                                        <div class="reward-zone-bottomline"></div>
                                    </div>
                                    <div class="reward-zone-item row">
                                        <div class="reward-zone-topline"></div>
                                        <div class="col-sm-3">
                                            <span class="reward-zone-rank">
                                                <i class="reward-zone-rankno">2</i>
                                            </span>
                                        </div>
                                        <div class="reward-zone-money col-sm-4">5,000</div>
                                        <div class="reward-zone-count col-sm-3">2</div>
                                        <div class="reward-zone-bottomline"></div>
                                    </div>
                                    <div class="reward-zone-item row">
                                        <div class="reward-zone-topline"></div>
                                        <div class="col-sm-3">
                                            <span class="reward-zone-rank">
                                                <i class="reward-zone-rankno">3</i>
                                            </span>
                                        </div>
                                        <div class="reward-zone-money col-sm-4">3,000</div>
                                        <div class="reward-zone-count col-sm-3">3</div>
                                        <div class="reward-zone-bottomline"></div>
                                    </div>
                                    <div class="reward-zone-item row">
                                        <div class="reward-zone-topline"></div>
                                        <div class="col-sm-3">
                                            <span class="reward-zone-rank">
                                                <i class="reward-zone-rankno">优</i>
                                            </span>
                                        </div>
                                        <div class="reward-zone-money col-sm-4">1,500</div>
                                        <div class="reward-zone-count col-sm-3">8</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reward-zone-content">
                            <ul class="reward-zone-head row">
                                <li class="col-xs-2">组别</li>
                                <li class="col-xs-3">名次</li>
                                <li class="col-xs-4">奖励</li>
                                <li class="col-xs-3">人数</li>
                            </ul>
                            <div class="reward-zone-socialwrap row">
                                <div class="reward-zone-social col-xs-2">
                                    社会组
                                    <div class="reward-zone-rightcol"></div>
                                </div>
                                <div class="reward-zone-list col-xs-10">
                                    <div class="reward-zone-leftcol"></div>
                                    <div class="reward-zone-item row">
                                        <div class="col-sm-3">
                                            <span class="reward-zone-rank">
                                                <i class="reward-zone-rankno">1</i>
                                            </span>
                                        </div>
                                        <div class="reward-zone-money col-sm-4">120,000</div>
                                        <div class="reward-zone-count col-sm-3">1</div>
                                        <div class="reward-zone-bottomline"></div>
                                    </div>
                                    <div class="reward-zone-item row">
                                        <div class="reward-zone-topline"></div>
                                        <div class="col-sm-3">
                                            <span class="reward-zone-rank">
                                                <i class="reward-zone-rankno">2</i>
                                            </span>
                                        </div>
                                        <div class="reward-zone-money col-sm-4">60,000</div>
                                        <div class="reward-zone-count col-sm-3">2</div>
                                        <div class="reward-zone-bottomline"></div>
                                    </div>
                                    <div class="reward-zone-item row">
                                        <div class="reward-zone-topline"></div>
                                        <div class="col-sm-3">
                                            <span class="reward-zone-rank">
                                                <i class="reward-zone-rankno">3</i>
                                            </span>
                                        </div>
                                        <div class="reward-zone-money col-sm-4">30,000</div>
                                        <div class="reward-zone-count col-sm-3">3</div>
                                    </div>
                                </div>
                                <div class="reward-zone-bottomline"></div>
                            </div>
                            <div class="reward-zone-campuswrap row">
                                <div class="reward-zone-topline"></div>
                                <div class="reward-zone-campus col-xs-2">
                                    学生组
                                    <div class="reward-zone-rightcol"></div>
                                </div>
                                <div class="reward-zone-list col-xs-10">
                                    <div class="reward-zone-leftcol"></div>
                                    <div class="reward-zone-item row">
                                        <div class="col-sm-3">
                                            <span class="reward-zone-rank">
                                                <i class="reward-zone-rankno">1</i>
                                            </span>
                                        </div>
                                        <div class="reward-zone-money col-sm-4">60,000</div>
                                        <div class="reward-zone-count col-sm-3">1</div>
                                        <div class="reward-zone-bottomline"></div>
                                    </div>
                                    <div class="reward-zone-item row">
                                        <div class="reward-zone-topline"></div>
                                        <div class="col-sm-3">
                                            <span class="reward-zone-rank">
                                                <i class="reward-zone-rankno">2</i>
                                            </span>
                                        </div>
                                        <div class="reward-zone-money col-sm-4">30,000</div>
                                        <div class="reward-zone-count col-sm-3">2</div>
                                        <div class="reward-zone-bottomline"></div>
                                    </div>
                                    <div class="reward-zone-item row">
                                        <div class="reward-zone-topline"></div>
                                        <div class="col-sm-3">
                                            <span class="reward-zone-rank">
                                                <i class="reward-zone-rankno">3</i>
                                            </span>
                                        </div>
                                        <div class="reward-zone-money col-sm-4">15,000</div>
                                        <div class="reward-zone-count col-sm-3">3</div>
                                        <div class="reward-zone-bottomline"></div>
                                    </div>
                                    <div class="reward-zone-item row">
                                        <div class="reward-zone-topline"></div>
                                        <div class="col-sm-3">
                                            <span class="reward-zone-rank">
                                                <i class="reward-zone-rankno">人气</i>
                                            </span>
                                        </div>
                                        <div class="reward-zone-money col-sm-4">10,000</div>
                                        <div class="reward-zone-count col-sm-3">1</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(yii::$app->params['show_mcreative_judge']):?>
        <div id="mcreative_judge" class="mcreative-part mcreative-whitepart">
            <div class="mcreative-judge-bg"></div>
            <div class="mcreative-titlebox ds-1200 clearfix">
                <div class="mcreative-title">
                    <b></b>
                    <span class="mcreative-title-ch">评委阵容</span>
                    <span class="mcreative-title-en">JUDGE</span>
                </div>
            </div>
            <div class="ds-1200">
                <ul class="mcreative-judge-list row">
                    <?php foreach(yii::$app->params['mcreative_judge'] as $judge):?>
                        <li class="col-xs-2">
                            <a target="view_window" href="">
                                <div class="mcreative-judge-img">
                                    <img src="<?=$judge['image']?>" alt="<?=$judge['name']?>">
                                </div>
                                <div class="mcreative-judge-name"><?=$judge['name']?></div>
                                <div class="mcreative-judge-career"><?=$judge['position']?></div>
                            </a>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    <?php endif;?>

    <div class="mcreative-part mcreative-blackpart">
        <div class="mcreative-blackpart-toptriwrap">
            <div class="mcreative-blackpart-toptri"></div>
        </div>
        <div class="mcreative-blackpart-bottriwrap">
            <div class="mcreative-blackpart-bottri"></div>
        </div>
        <div class="ds-1200 clearfix">
            <div class="mcreative-leftlogo pull-left">
                <img src="/images/activity/mcreative/leftlogo.png?v=1" alt="百万创意大赛">
            </div>
            <div class="mcreative-information pull-right">
                <div class="mcreative-titlebox clearfix">
                    <div class="mcreative-title clearfix">
                        <b></b>
                        <span class="mcreative-title-ch">关于&nbsp;<i class="color-blue">蓝海创意云&nbsp;“百万创意创业大赛”</i></span>
                        <span class="mcreative-title-en">INFORMATION</span>
                    </div>
                </div>
                <div class="mcreative-information-desc">
                    百万大赛奖金、亿元创业资金支持；与文创及互联网大咖面对面碰撞；全程创业支持和辅导，免费对接行业资源。大赛面向全国征集优秀创意项目，走进100所高校、100所文化创意园区，寻找中国最具创意的年轻人和最具商业潜力的优秀项目。
                </div>
                <a href="intro" class="mcreative-information-btn">了解更多</a>
            </div>
        </div>
    </div>

    <div class="row pd0 ds-1200 mcreative-partner-box">
        <div class="col-xs-4">
            <div class="mcreative-part mcreative-whitepart">
        <div class="mcreative-titlebox ds-1200 clearfix">
                    <div class="mcreative-title">
                        <b></b>
                        <span class="mcreative-title-ch">主办方</span>
                        <span class="mcreative-title-en">ORGANIZER</span>
                    </div>
                </div>
        <div class="ds-1200">
                    <ul class="mcreative-partner-list clearfix">
                        <li><a href="javascript:void(0);"><img src="/images/activity/logos/江苏高科技投资集团.jpg" alt="江苏高科技投资集团"></a></li>
                        <li><a href="javascript:void(0);"><img src="/images/activity/logos/中国苏州文化创意设计产业交易博览会组委会.jpg" alt="中国苏州文化创意设计产业交易博览会组委会"></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xs-3">
            <div class="mcreative-part mcreative-whitepart">
        <div class="mcreative-titlebox ds-1200 clearfix">
                    <div class="mcreative-title">
                        <b></b>
                        <span class="mcreative-title-ch">承办方</span>
                        <span class="mcreative-title-en">UNDERTAKER</span>
                    </div>
                </div>
        <div class="ds-1200">
                    <ul class="mcreative-partner-list clearfix">
                        <li><a href="javascript:void(0);"><img src="/images/activity/logos/landhightech.jpg" alt="蓝海创意云"></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xs-5">
            <div class="mcreative-part mcreative-whitepart">
        <div class="mcreative-titlebox ds-1200 clearfix">
                    <div class="mcreative-title">
                        <b></b>
                        <span class="mcreative-title-ch">协办方</span>
                        <span class="mcreative-title-en">CO-SPONSOR</span>
                    </div>
                </div>
        <div class="ds-1200">
                    <ul class="mcreative-partner-list clearfix">
                        <li><a href="javascript:void(0);"><img src="/images/activity/logos/杭州新鼎明影视投资管理股份有限公司.jpg" alt="杭州新鼎明影视投资管理股份有限公司"></a></li>
                        <li><a href="javascript:void(0);"><img src="/images/activity/logos/中国传媒大学-苏州.jpg" alt="中国传媒大学-苏州"></a></li>
                        <li><a href="javascript:void(0);"><img src="/images/activity/logos/中国传媒大学-广州.jpg" alt="中国传媒大学-广州"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="mcreative-part mcreative-whitepart">
        <div class="mcreative-titlebox ds-1200 clearfix">
            <div class="mcreative-title">
                <b></b>
                <span class="mcreative-title-ch">媒体支持</span>
                <span class="mcreative-title-en">MEDIA SUPPORT</span>
            </div>
        </div>
        <div class="ds-1200">
            <ul class="mcreative-partner-list clearfix">
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/达晨创投.jpg" alt="达晨创投"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/zkct.jpg" alt="中科创投"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/新华日版.jpg" alt="新华日版"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/新浪.jpg" alt="新浪"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/腾讯视频.jpg" alt="腾讯视频"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/亚洲动漫文化产业协会.jpg" alt="亚洲动漫文化产业协会"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/上海大学.jpg" alt="上海大学"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/国立台湾艺术大学.jpg" alt="国立台湾艺术大学"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/澳门大学.jpg" alt="澳门大学"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/中华学社（团结香港基金）.jpg" alt="中华学社（团结香港基金）"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/中国文化创意产业网站.jpg" alt="中国文化创意产业网站"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/有妖气.jpg" alt="有妖气.jpg"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/扬子晚报.jpg" alt="扬子晚报"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/香港城市大学.jpg" alt="香港城市大学"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/现代快报.jpg" alt="现代快报"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/微漫画.jpg" alt="微漫画"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/钛媒体.jpg" alt="钛媒体"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/苏州高新区新闻网.jpg" alt="苏州高新区新闻网"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/大学生艺术在线.jpg" alt="大学生艺术在线"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/NVDIA.jpg" alt="NVDIA"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/DELL.jpg" alt="DELL"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/广东省动漫行业联盟.jpg" alt="广东省动漫行业联盟"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/广东动漫行业协会.jpg" alt="广东动漫行业协会"></a></li>
                <li><a href="javascript:void(0);"><img src="/images/activity/logos/广东开放大学.jpg" alt="广东开放大学"></a></li>
            </ul>
        </div>
    </div>

    <!-- footer -->
    <?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_footer.php') ?>

    <script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>
    <script type="text/javascript">
        $(function(){
            if($(".mcreative-slideBox-list li").length > 0) {
                $(".mcreative-schedule-slideBox").slide({
                    mainCell:".mcreative-slideBox-list",
                    vis: 4,
                    pnLoop: false,
                    autoPlay: false,
                    prevCell: ".mcreative-slideBox-prev",
                    nextCell: ".mcreative-slideBox-next",
                    effect: "left",
                    easing: "swing"
                });
            }

            $('.mcreative-schedule-nav li').on('click', function(event) {
                var _this = $(this),
                    _schedule = _this.closest('.mcreative-schedule'),
                    index = _this.index();
                if(_this.hasClass("unclick")){
                    return;
                }
                _schedule.find(".mcreative-schedule-slideblock").stop(true).animate({left: 25 * index + "%"}, 100);
                _this.addClass("active").siblings().removeClass("active");
                _schedule.find('.mcreative-schedule-box .mcreative-schedule-content').eq(index).addClass("active").siblings().removeClass("active");
            });

            $('.reward-zone-nav li').on('click', function(event) {
                var _this = $(this),
                    index = _this.index();
                _this.addClass("active").siblings().removeClass("active");
                _this.closest('.mcreative-reward-zone').find('.reward-zone-box .reward-zone-content').eq(index).addClass("active").siblings().removeClass("active");
            });
            schedule.init();
        });
        var schedule = {
            init : function(){
                var _self = this;
                $.ajax({
                    type : "GET",
                    url : '<?= yii::$app->urlManager->createUrl("activity/million/schedule");?>',
                    dataType : "json",
                    success: function(json){
                        _self.loadHtml(json);
                    }
                });
            },
            loadHtml : function(json){
                $(".mcreative-slideBox-list").empty();
                $.each(json.data, function(p_index,p_element) {
                    $.each(p_element,function(index,element){
//                        var date = element.start_time.substring(0,19);
//                        date = date.replace(/-/g,'/');
//                        var start_time = new Date(date);
//                        var minute = start_time.getMinutes();
//                        if (minute < 10) {
//                            minute = "0" + minute;
//                        }
//                        var hour = start_time.getHours();
//                        if (hour < 10) {
//                            hour = "0" + hour;
//                        }
//                        var date = '<span class="mcreative-slideBox-date">' + (start_time.getMonth() + 1) + '月' + start_time.getDate() + '日</span><span class="mcreative-slideBox-time">' + hour + ':' + minute + '</span>';
                        var status_list = ['即将开始','进行中','已结束'];
                        var status = status_list[element.status];
                        var icon = element.icon;
                        var title = element.title;
                        var type_list = ['项目征集','分赛区评选','全国总决赛','项目孵化'];
                        var type = type_list[element.type];
                        var html = '<li>\
                                    <div class="mcreative-slideBox-top">\
                                        <p>' + element.start_time + '</p>\
                                        <p class="mcreative-slideBox-status">' + status + '</p>\
                                    </div>\
                                    <div class="mcreative-slideBox-bottom">\
                                        <div class="mcreative-bottom-bg"></div>\
                                        <div class="mcreative-bottom-img"><img src="' + icon + '" alt="' + title + '"></div>\
                                        <p>' + title + '</p>\
                                        <p>' + type + '</p>\
                                    </div>\
                                </li>';
                        $(".mcreative-slideBox-list").eq(p_index).append(html);
                    });
                });

                if($(".mcreative-slideBox-list li").length > 0) {
                    $(".mcreative-schedule-slideBox").slide({
                        mainCell:".mcreative-slideBox-list",
                        vis: 4,
                        pnLoop: false,
                        autoPlay: false,
                        prevCell: ".mcreative-slideBox-prev",
                        nextCell: ".mcreative-slideBox-next",
                        effect: "left",
                        easing: "swing"
                    });
                }
            }
        }
    </script>
</body>
</html>