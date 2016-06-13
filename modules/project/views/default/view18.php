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
                <!--<span>奇幻神秘的深海世界  惊心动魄的冒险之旅</span>-->
            </p>
        </div>
        <div class="detail-graphic">
            <img src="/images/18/1.jpg" alt="<?= $project['proj_name'] ?>"  />
        </div>
    </div>
    <!--/detail-banner-->

    <!--detail-info-->
    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《十二生肖之生肖传奇》概述</h2>
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
                    <span class="category-content">动画脚本</span>
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
            <p class="blue fs16 indent0">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                本部动画电影需要具备以下几个关键点
            </p>
            <div class="pl15">
                <p class="indent0">1. 原汁原味地地道道的中国风 </p>
                <p class="indent0">2. 能激起年轻人的热血剧情</p>
                <p class="indent0">3. 使观众有代入感民族自豪感的内容</p>
                <p class="indent0">4. 情节风趣幽默搞笑 </p>
                <p class="indent0">5. 视觉效果炫酷吊炸天</p>
            </div>
            <p class="blue fs16 indent0 mt55">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                主要人物性格
            </p>
            <div class="pl15">
                <p class="indent0">小龙女</p>
                <p class="indent0">优点：聪慧 坚强 独立</p>
                <p class="indent0">缺点：孤僻 自卑</p>
                <p class="indent0">性格分析：小龙女天生聪慧，因为是个孤儿从小就独自生活，所以她的性格非常独立和坚强，很多事情都要自己去承担，但也因此内心十分孤独渴望友谊，卑微出身也经常招来嘲笑使她内心很自卑。 </p>
                <p class="indent0 mt35">龙太子</p>
                <p class="indent0">优点：乐观 积极</p>
                <p class="indent0">缺点：任性 自私</p>
                <p class="indent0">性格分析：龙太子出身高贵，从小衣食无忧，没有经历过太多磨难所以性格积极乐观，也因此显的太过天真和简单。因为是独子集万千宠爱于一身所以性格自私任性不懂得与人分享。 </p>
            </div>
            <p class="blue fs16 indent0 mt55">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                故事主线
            </p>
            <div class="pl15">
                <p class="indent0">通过中华民族的代表动物：龙，引领其他十二生肖动物贯穿整部电影，从一开始不懂事的小龙开始（暗指沉睡中的中国），经过一系列的磨难与成长，最终蜕变成大家的精神领袖带领其他生肖一起团结一致战胜了邪恶势力并取得最终的胜利（暗指中国-沉睡的巨龙已经觉醒）。故事中出现的反面角色可以是十二生肖以外的其他动物比如猫，野鸡（小日本的国鸟），白头雕（美国的代表动物），狮子（英国的代表动物）等。电影高潮部分要使人感觉到中华民族这条巨龙已经崛醒，使观众感到热血沸腾，激情澎湃，激起大家强烈的民族自豪感。但整部电影不能有说教味太浓，情节上还是要与时俱进，以轻松幽默为主，让观众全程无尿点的捧腹大笑为主导。</p>
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