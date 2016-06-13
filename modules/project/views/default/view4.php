<?php
$id = yii::$app->request->get('id');
?>
<!DOCTYPE html>
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
                <span>奇幻神秘的深海世界  惊心动魄的冒险之旅</span>
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
            <img src="/images/4/banner-pro1.jpg" alt="<?= $project['proj_name'] ?>"  />
        </div>
    </div>
    <!--/detail-banner-->

    <!--detail-info-->
    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》项目概述</h2>
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
                                <span id="support_pno">3000万</span>人民币
                            </p>
                            <p class="support-secondline">融资需求</p>
                        </li>
                        <li class="fl support-percentage">
                            <p class="support-firstline">
                                <span>进行中</span>
                            </p>
                            <p class="support-secondline">项目进度</p>
                        </li>
                    </ul>
                    <?php if ($project['user']['favor_status']):?>
                        <!--<a href="javascript:void(0);" class="yellow-btn w120 focused" name="project_<?= $project['proj_id']?>" value="<?= $project['proj_id']?>" onclick="remove_favor_project(this)">已点赞</a>-->
                    <?php else:?>
                        <!--<a href="javascript:void(0);" class="yellow-btn w120" name="project_<?= $project['proj_id']?>" value="<?= $project['proj_id']?>" onclick="favor_project(this)">点赞</a>-->
                    <?php endif ?>
                </div>
            </div>
        </div>
        <div class="detail-rightpart">
            <div class="video">
                <div id="jp_container_3" class="jp-video jp-video-270p" role="application" aria-label="media player">
                    <div class="jp-type-single">
                        <div id="jquery_jplayer_3" class="jp-jplayer"></div>
                        <div class="jp-gui">
                            <div class="jp-video-play">
                                <button class="jp-video-play-icon" role="button" tabindex="0">play</button>
                            </div>
                            <div class="jp-interface">
                                <div class="jp-progress">
                                    <div class="jp-seek-bar">
                                        <div class="jp-play-bar"></div>
                                    </div>
                                </div>
                                <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                                <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                                <div class="jp-controls-holder">
                                    <div class="jp-controls">
                                        <button class="jp-play" role="button" tabindex="0">play</button>
                                        <button class="jp-stop" role="button" tabindex="0">stop</button>
                                    </div>
                                    <div class="jp-volume-controls">
                                        <button class="jp-mute" role="button" tabindex="0">mute</button>
                                        <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                                        <div class="jp-volume-bar">
                                            <div class="jp-volume-bar-value"></div>
                                        </div>
                                    </div>
                                    <div class="jp-toggles">
                                        <button class="jp-repeat" role="button" tabindex="0">repeat</button>
                                        <button class="jp-full-screen" role="button" tabindex="0">full screen</button>
                                    </div>
                                </div>
                                <div class="jp-details">
                                    <div class="jp-title" aria-label="title">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                        <div class="jp-no-solution">
                            <span>Update Required</span>
                            To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                        </div>
                    </div>
                </div>
            </div>

            <p class="blue fs16 indent0 fwb mt20">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                项目亮点 – 国产片投入+进口片回报
            </p>
            <p class="indent0">
                动画片是中国观众的首选并且有最好的票房保证，《深海》项目由成熟的国际团队制作，作品具有和进口片同样的质量和中国的较低成本，适合进取型的发行公司投资并参与
            </p>
            <p class="blue fs16 indent0 fwb mt20">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                项目成本
            </p>
            <p class="indent0">
                约8500万人民币
            </p>
            <p class="blue fs16 indent0 fwb mt20">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                票房预期（中国大陆）+海外票房
            </p>
            <p class="indent0">
                全球票房保守估计5.1亿⼈民币
            </p>
            <p class="blue fs16 indent0 fwb mt20">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                时间周期
            </p>
            <p class="indent0">
                2014年11月完成前期创意准备工作开始制作，2016年9月完成制作，2016年寒假档期上
            </p>
            <p class="blue fs16 indent0 fwb mt20">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                预计投资回报
            </p>
            <p class="indent0">
                包括发行代理费、版权、衍生品在内的投资方总投资回报保守估计为170%
            </p>
            <p class="blue fs16 indent0 fwb mt20">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                高质量
            </p>
            <p class="indent0">
                利用国际故事的创作和技术优势及资金为中国市场提供高质量的电影
            </p>
            <p class="blue fs16 indent0 fwb mt20">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                低风险
            </p>
            <p class="indent0">
                总投入8500万元，
            </p>
            <p class="indent0">
                投资方投1500万的投入拥有全部的中国市场40%和12.5%的国际市场
            </p>
            <p class="fs20 indent0 mt20">投资拥有优先收回投资权。</p>
        </div>
    </div>
    <div class="bg-gray">
        <div class="detail-info detail-info-one ">
            <div class="detail-leftpart fl">
                <div class="leftinfo-tpart">
                    <h2>《<?= $project['proj_name'] ?>》项目市场定位</h2>
                </div>
            </div>
            <div class="detail-rightpart">
                <dl class="target-dl">
                    <dt>1、电影制式</dt>
                    <dd>· 格式:  CGI  </dd>
                    <dd>· 片长:  82分钟</dd>
                    <dd>· 语言:  中文普通话</dd>
                    <dd>· 预计上映时间:  2016年暑期</dd>
                    <dd>· 类型:  家庭影片</dd>
                </dl>
                <dl class="target-dl">
                    <dt>2、目标市场</dt>
                    <dd>· 家庭  </dd>
                    <dd>· 儿童（5-12岁）</dd>
                    <dd>· 父母</dd>
                    <dd>· 祖父母</dd>
                    <dd>· 对环境保护感兴趣的年轻人</dd>
                </dl>
            </div>
        </div>
    </div>


    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》项目内容</h2>
            </div>
            <div class="leftinfo-mpart">
                <p class="leftinfo-mpart-category-new">
                    <i class="ds-icon-16 ds-icon-entertime"></i>
                    项目入驻时间：<?= date('Y-m-d', $project['created_at'])?>
                </p>
                <p class="leftinfo-mpart-desc">
                    《<?= $project['proj_name'] ?>》由奥斯卡获奖大片创意班底和中国最成熟的CG制作团队联手打造，影片讲述深海章鱼狄普寻找海洋中巨大生物南希拯救家园，在途中遇到了许多志同道合的朋友和惊险搞笑的事情。
                </p>
            </div>
        </div>
        <div class="detail-rightpart">

            <div class="detail-rightpart-images">
                <div class="lazy-box" style="width:750px;height: 82px;">
                    <img data-original="/images/4/detail-img2.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
            <p class="mt24">
                个性调皮和任性的狄普，觉着去外面的世界瞧瞧才是它想要的生活。因为一时的淘气摆弄鱼雷爆破将自己的家园毁损。让家人和朋友被困，这时必须寻找海洋中巨大的生物南希来拯救大家。在和朋友寻找南希的途中遇到许多志同道合的朋友和许多惊醒有趣搞笑的事情。
            </p>
            <p>
                剧中的反派角色邪恶三人组。它们为了满足变为人类的私欲，欲收集所有海洋伙伴冻成冰块发射到地球毁灭后人类移居的外太空。达西将狄普及它的几个伙伴冻在冷冻室里，它们经过一番自救从中逃了出来。随之其它被冰冻的海洋伙伴和南希也随之从火箭中滑落到海中。
            </p>
            <p>
                所有人都返回家园去解救克拉肯和它们的家园。这时的恶人组掉到了深海中。
            </p>
            <div class="detail-rightpart-images mt35">
                <div class="lazy-box" style="width:750px;height: 82px;">
                    <img data-original="/images/4/detail-img3.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
                <div class="lazy-box" style="width:750px;height: 533px;">
                    <img data-original="/images/4/detail-img4.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
                <div class="lazy-box" style="width:750px;height: 533px;">
                    <img data-original="/images/4/detail-img5.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
                <div class="lazy-box" style="width:750px;height: 533px;">
                    <img data-original="/images/4/detail-img6.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
                <div class="lazy-box" style="width:750px;height: 533px;">
                    <img data-original="/images/4/detail-img7.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
        </div>
    </div>

    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》团队介绍</h2>
            </div>
            <div class="leftinfo-mpart">
                <p class="leftinfo-mpart-category-new">
                    <i class="ds-icon-16 ds-icon-member"></i>
                    中外团队强强联手
                </p>
                <p class="leftinfo-mpart-desc">
                    《深海》项目由成熟的国际团队制作，作品具有和进口片同样的质量和中国的较低成本，适合进取型的发行公司投资并参与。
                </p>
            </div>
        </div>
        <div class="detail-rightpart">
            <p class="blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                剧本：Mike de Seve（狒狒动画）
            </p>
            <p class="indent0">
                20多年来，狒狒动画团队为全球知名动画工作室和网络视频进行创作、指导和设计，夺得了艾美奖，也获得了奥斯卡提名。著名的作品包括：怪物史莱克，料理鼠王，马达加斯加和功夫熊猫。
            </p>
            <div class="detail-rightpart-images mt20 mb40">
                <div class="lazy-box" style="width:433px; height:220px;">
                    <img data-original="/images/4/detail-img8.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>

            <p class="blue fs16 indent0 fwb mt55">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                角色开发：Sergio Pablos（SP）工作室
            </p>
            <p class="indent0">
                SP工作室致力于动画故事片的原创内容，代表作有《卑鄙的我》。SP的老板Sergio Pablos也为迪士尼的《人员泰山》、《高飞狗》，蓝天工作室的《里约大冒险》设计过角色。
            </p>
            <div class="detail-rightpart-images mt20 mb40">
                <div class="lazy-box" style="width:750px;height: 230px;">
                    <img data-original="/images/4/detail-img9.jpg" alt="<?= $project['proj_name'] ?>" class="lazy"/>
                </div>
            </div>
        </div>
    </div>

    <div class="detail-info detail-info-two pb120">
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
                            <img src="/images/4/slide01.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/4/slide02.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/4/slide03.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/4/slide04.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/4/slide05.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
            </ul>
            <a class="detail-bannerpart-next" href="javascript:void(0)"></a>
        </div>
    </div>
</div>
<!--/detail-content-->

<script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>

<script type="text/javascript" src="http://static.vsochina.com/libs/jplayer/2.9.1/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="/js/jquery.placeholder.min.js"></script>
<script type="text/javascript" src="http://static.vsochina.com/libs/jquery.lazyload/1.9.5/jquery.lazyload.js"></script>
<script type="text/javascript" src="/js/dreamSpace.js"></script>
<script type="text/javascript" src="/js/project_action.js"></script>

<script type="text/javascript">
    $(function () {
        $("#jquery_jplayer_3").jPlayer({
            ready: function () {
                $(this).jPlayer("setMedia", {
                    title: "<?= $project['proj_name'] ?>",
                    flv: "/images/4/4.flv",
                    m4a: "/images/4/4.mp4",
                    poster: "http://www.jplayer.org/video/poster/Finding_Nemo_Teaser_640x352.png"
                });
            },
            play: function () { // To avoid multiple jPlayers playing together.
                $(this).jPlayer("pauseOthers");
            },
            size: {
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

        $(".rightinfo-groupmember.num5").mCustomScrollbar({
            scrollButtons:{
                scrollSpeed:50
            },
            axis:"y"
        });
    });
</script>

<script type="text/javascript" src="/js/project_detail.js"></script>
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/footer.php') ?>
</body>
</html>