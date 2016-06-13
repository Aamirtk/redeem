<!DOCTYPE html>
<?php
$id = yii::$app->request->get('id');
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?= $project['proj_name'] ?></title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="renderer" content="webkit"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <link rel="stylesheet" type="text/css" href='http://cz.vsochina.com/themes/creation/css/jquery.mCustomScrollbar.css'>
    <link rel="stylesheet" type="text/css" href="http://account.vsochina.com/static/css/login/common.css?v=20150831"   />
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/jplayer/2.9.1/skin/blue.monday/jplayer.blue.monday.css" />

    <link rel="stylesheet" type="text/css" href="/css/dreamSpace.css"/>
    <link rel="stylesheet" type="text/css" href="/css/detail.css" />


    <script language="javascript" type="text/javascript" charset="utf-8" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
    <script src='http://cz.vsochina.com/themes/creation/js/jquery.mCustomScrollbar.concat.min.js'></script>
</head>
<body>
<!--header-top-->
<script type="text/javascript" charset="utf-8" src="http://account.vsochina.com/static/js/vsoheader.js"></script>
<!--/header-top-->
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/header.php') ?>
<!--detail-content-->
<div class="dreamspace-detail-content">
    <!--detail-banner-->
    <div class="detail-banner">
        <div class="detail-title fl">
            <h1><?= $project['proj_name'] ?></h1>
            <p>
                <span>三“人”组合拯救世界 爆笑动画之旅正式开始</span>
            </p>
        </div>
        <!--
        <dl class="detail-producer fr">
            <dt class="fl">
                <a href="" target="_blank" class="detail-portrait-50">
                    <img src="/images/4/portrait1.jpg" alt="<?= $project['proj_name'] ?>" />
                </a>
            </dt>
            <dd class="detail-producer-name">黑潮</dd>
            <dd class="detail-producer-desc">
                <span class="detail-first">游戏制作</span>
            </dd>
        </dl>
         -->
        <div class="detail-graphic">
            <img src="/images/10/1.jpg" alt="<?= $project['proj_name'] ?>"  />
        </div>
    </div>
    <!--/detail-banner-->

    <!--detail-info-->
    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》项目介绍</h2>
                <!--<p class="leftinfo-tpart-subhead entertime">项目入驻时间：<?= date('Y-m-d', $project['created_at'])?></p>-->
            </div>
            <div class="leftinfo-mpart">
                <!--
                <p class="leftinfo-mpart-desc">

                </p>
                -->
                <p class="leftinfo-mpart-category-new">
                    <i class="ds-icon-16 ds-icon-block-1"></i>
                    <span>项目类型</span>
                    <span>-</span>
                    <span class="category-content">三维动画电影</span>
                </p>
                <div class="leftinfo-mpart-operate">
                    <ul class="operate-support-box">
                        <li class="fl support-num">
                            <p class="support-firstline">
                                <span id="support_pno" class="favor_num_<?= $project['proj_id'] ?>"><?= $project['fans_num'] ?></span>人
                            </p>
                            <p class="support-secondline">点赞</p>
                        </li>
                        <li class="fl support-percentage">
                            <p class="support-firstline">
                                <span>进行中</span>
                            </p>
                            <p class="support-secondline">项目进度</p>
                        </li>
                    </ul>
                    <?php if ($project['user']['favor_status']):?>
                        <a href="javascript:void(0);" class="yellow-btn w120 focused" name="project_<?= $project['proj_id']?>" value="<?= $project['proj_id']?>" onclick="remove_favor_project(this)">已点赞</a>
                    <?php else:?>
                        <a href="javascript:void(0);" class="yellow-btn w120" name="project_<?= $project['proj_id']?>" value="<?= $project['proj_id']?>" onclick="favor_project(this)">点赞</a>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <div class="detail-rightpart">
            <div class="detail-rightpart-images">
                <div class="lazy-box" style="width:750px;height: 51px;">
                    <img data-original="/images/10/2.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
            <p class="blue fs16 indent0 fwb mt20">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                故事介绍：
            </p>
            <p class="indent0">
                《SMART》是发生在2026年北京的动画喜剧电影。一位孤独的科学家Jen用一块超级电脑芯片创造了世界上第一个被赋予“感情”的机器人Mensa。恶势力不顾一切想要追回芯片。Mensa必须和一只无家可归、呆萌而欢乐的小狗，以及一只坏脾气的鸟组团，从恶势力的计划中寻找并拯救Jen（以及世界）。
            </p>
            <div class="detail-rightpart-images">
                <div class="lazy-box" style="width:750px;height: 102px;">
                    <img data-original="/images/10/3.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
        </div>
    </div>


    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》角色介绍</h2>
            </div>
            <div class="leftinfo-mpart">
                <p class="leftinfo-mpart-category-new">
                    <i class="ds-icon-16 ds-icon-member"></i>
                    好莱坞创意班底
                </p>
                <p class="leftinfo-mpart-desc">
                    《SMART》讲述了由科学家Jen制作的机器人Mensa和一只鸟，一只小狗组团共同从而是里寻找并拯救Jen和世界的故事。
                </p>
            </div>
        </div>
        <div class="detail-rightpart">
            <div class="detail-rightpart-images mt20 mb40">
                <div class="lazy-box" style="width:750px; height:375px;">
                    <img data-original="/images/10/4.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
                <div class="lazy-box" style="width:750px; height:376px;">
                    <img data-original="/images/10/5.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
                <div class="lazy-box" style="width:750px; height:369px;">
                    <img data-original="/images/10/6.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
                <div class="lazy-box" style="width:750px; height:376px;">
                    <img data-original="/images/10/7.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
                <div class="lazy-box" style="width:750px; height:369px;">
                    <img data-original="/images/10/8.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
        </div>
    </div>

    <div class="detail-info detail-info-two pb90">
        <div class="detail-leftpart">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》项目演示</h2>
            </div>
        </div>
        <div class="detail-bannerpart new-m-castlist slideBox">
            <a class="detail-bannerpart-prev" href="javascript:void(0)"></a>
            <ul class="less">
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/10/slide01.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/10/slide02.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/10/slide03.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/10/slide04.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/10/slide05.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
            </ul>
            <a class="detail-bannerpart-next" href="javascript:void(0)"></a>
        </div>
    </div>

    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》项目进度</h2>
            </div>
            <div class="leftinfo-mpart">
                <p class="leftinfo-mpart-category-new">
                    <i class="ds-icon-16 ds-icon-gantt"></i>
                    项目甘特图
                </p>
            </div>
        </div>
        <div class="detail-rightpart">
            <div class="detail-rightpart-images mt20 mb40">
                <div class="lazy-box" style="width:750px; height:357px;">
                    <img data-original="/images/10/9.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
        </div>
    </div>
</div>
<!--/detail-content-->

<script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>
<script type="text/javascript" src="http://static.vsochina.com/libs/jquery.lazyload/1.9.5/jquery.lazyload.js"></script>
<script type="text/javascript" src="http://static.vsochina.com/libs/jplayer/2.9.1/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="/js/jquery.placeholder.min.js"></script>
<script type="text/javascript" src="/js/dreamSpace.js"></script>
<script type="text/javascript" src="/js/project_action.js"></script>

<script type="text/javascript">
    $(function(){
        $("#jquery_jplayer_3").jPlayer({
            ready: function () {
                $(this).jPlayer("setMedia", {
                    title: "<?= $project['proj_name'] ?>",
                    flv: "/images/4/4.flv",
                    m4a: "/images/4/4.mp4",
                    poster: "http://www.jplayer.org/video/poster/Finding_Nemo_Teaser_640x352.png"
                });
            },
            play: function() { // To avoid multiple jPlayers playing together.
                $(this).jPlayer("pauseOthers");
            },
            size:{
                width: "750px",
                height: "400px"
            },
            swfPath: "http://static.vsochina.com/libs/jplayer/2.9.1",
            supplied: "flv, mp4",
            cssSelectorAncestor: "#jp_container_3",
            globalVolume: true,
            useStateClassSkin: true,
            autoBlur: false,
            smoothPlayBar: true,
            keyEnabled: true
        });
    });
</script>

<script type="text/javascript" src="/js/project_detail.js"></script>
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/footer.php') ?>
</body>
</html>