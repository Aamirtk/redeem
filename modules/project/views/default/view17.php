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
                <span>奇幻的失落文明 神秘的远古城邦</span>
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
        <div class="detail-graphic" style="width:1200px;height:450px;">
            <img src="/images/17/1.jpg" alt="<?= $project['proj_name'] ?>" />
        </div>
    </div>
    <!--/detail-banner-->

    <!--detail-info-->
    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《黑卡姆城》项目概述</h2>
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
                    <span class="category-content">真人科幻电影</span>
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

            <p class="blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                影片名称
            </p>
            <p class="indent0">
                黑卡姆城(暂定)
            </p>
            <p class="blue fs16 indent0 mt20 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                影片类型
            </p>
            <p class="indent0">
                动作    冒险
            </p>

            <p class="blue fs16 indent0 mt20 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                故事元素
            </p>
            <p class="indent0">
                失落文明、动作、传奇、悬疑、爱情
            </p>
            <p class="blue fs16 indent0 mt20 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                诉求对象
            </p>
            <p class="indent0">
                老少皆宜。以当代大学生、男性观众、独立自主新一代 都市白领女性为主要讲述对象。
            </p>
            <p class="blue fs16 indent0 mt20 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                风格特色
            </p>
            <p class="indent0">
                中国人的成人童话
            </p>
            <p class="blue fs16 indent0 mt20 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                影片主旨
            </p>
            <p class="indent0">
                以中国上古神话历史为背景，构建传奇失落文明。在个人传奇经历下讲述与现代都市文明、科技各方面碰撞。在更深
                层次下， 对社会结构与人类生存困境进行哲学反思。
            </p>
        </div>
    </div>
    <div >
        <div class="detail-info detail-info-one ">
            <div class="detail-leftpart fl">
                <div class="leftinfo-tpart">
                    <h2>《黑卡姆城》项目内容</h2>
                </div>
                <div class="leftinfo-mpart">
                    <p class="leftinfo-mpart-category-new">
                        <i class="ds-icon-16 ds-icon-entertime"></i>
                        项目入驻时间：<?= date('Y-m-d', $project['created_at'])?>
                    </p>
                    <p class="leftinfo-mpart-desc">
                        《黑卡姆城》以中国上古神话历史为背景，构建传奇失落
                        文明。以楼兰、大汉为文化背景参考设定的遗失古文明，
                        并在个人传奇经历下讲述与现代都市文明、科技各方面
                        碰撞。
                    </p>
                </div>
            </div>
            <div class="detail-rightpart">

                <div class="lazy-box mt20" style="width:750px; height:82px;">
                    <img data-original="/images/17/2.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
                <p class="indent1">
                    15年前，司马黄突然失踪。其妻在5年后脱离司马家族，嫁给了一位房地 产商，将年仅12岁的女儿司马休休（暂定）
                    遗弃在司马家。10年来，司马休休跟随祖父以及大伯、小叔长大，从小养成了叛逆捣蛋、无法无天的性格， 并耳濡目染
                    一身堪舆本领和中国功夫。家人十分宠爱司马休休，但每次她追问父亲去向时，众人都讳莫如深，并阻止她接触家族内
                    部资料。她只得自己悄悄调查，偷看资料。
                </p>
                <p class="indent1">
                    司马休休大学毕业之际，突然收拾行李，在不告知众人的情况下，孤身前往新疆塔里木盆地，并带走了家中大部分
                    资料和神秘物品，一如当时司马黄失踪时一样。
                </p>
                <p class="indent1">
                    日本内阁情报调查室一直未放弃对司马家族的监视和调查，在司马休休离家之际就跟踪上了她。同时，国安也收到
                    司马休休前往黑卡姆城并身陷险境的消息，当即派出特殊人员追寻并保护。
                </p>
                <p class="indent1">
                    自此，“一个少女引发的血案”拉开序幕。
                </p>
                <div class="lazy-box mt20" style="width:750px; height:82px;">
                    <img data-original="/images/17/3.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
                <p class="blue fs16 indent0 mt20 fwb">
                    <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                    气候
                </p>
                <p class="indent0">
                    温带沙漠气候。极端干旱，降盐雨，雨量极少，太阳辐射强。夏 季十分炎热，白昼最高气温达到50°C以上。一年中
                    11个月都是昼长夜短， 只有按黑卡姆历的12月会出现昼夜长短相等都为12个小时的情况，每年 降水量在12月12日
                    达到最高值。
                </p>
                <p class="blue fs16 indent0 mt20 fwb">
                    <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                    水文
                </p>
                <p class="indent0">
                    黑卡姆无地面水源。流沙漩涡下沙雕城中通有内外双环暗河，分 别通向昆仑山和天山，两河都为高山降水和高山冰雪
                    融水补给。黑卡姆 历6~7月为汛期，无旱期。
                </p>
                <p class="blue fs16 indent0 mt20 fwb">
                    <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                    地貌
                </p>
                <p class="indent0">
                    四面皆为流动沙丘，沙中散落着大大小小的兽形怪石。黑卡姆城 上方形成一个巨大的凝固流沙漩涡，漩涡四周金字塔形
                    沙丘为漩涡提供 了天然屏障。
                </p>
                <p class="blue fs16 indent0 mt20 fwb">
                    <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                    土壤
                </p>
                <p class="indent0">
                    有机物含量较低，不适宜生物生存，含有大量的铁元素和硅元素， 固定位置有固氮菌。
                </p>
                <div class="lazy-box mt20" style="width:750px; height:82px;">
                    <img data-original="/images/17/4.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
                <p class="indent0">
                    本片以当下社会环境为背景，以黑卡姆城与现实社会的不同空间纬度呈 术 现不同角色在不同环境的社会属性。
                    基于以上特点，美术前期设计分为以下几点：
                </p>
                <p class="blue fs16 indent0 mt20 fwb">
                    <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                    关于空间（画面构图）：
		 <span class="detail-word-gray">利用空间的差异和对比强化故事主旨，在 定 有限的空间内力求营造更多的变化和可
		 能性，多以镜头画面构图的型式感呈现空间的层次。</span>
                </p>

                <p class="blue fs16 indent0 mt20 fwb">
                    <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                    关于色彩：
		 <span class="detail-word-gray">画面的色调选取柔和的暖色调，饱和度选取偏高的暖黄 为基调，明度选取对比较强的高反差，为夸张
		 的叙事营造合理的画面氛 围。</span>
                </p>
                <p class="blue fs16 indent0 mt20 fwb">
                    <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                    关于气氛：
		 <span class="detail-word-gray">以暖色如调，色彩明快，多层次，少过度。来突出表现 快节奏的都市生活。本片定位为一个与世隔绝
		的世界中。在一个与世隔绝的城池里，多处场景需要与现实场景有所不同。</span>
                </p>
                <p class="blue fs16 indent0 mt20 fwb">
                    <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                    关于场景：
		 <span class="detail-word-gray">游戏中的主场景选用偏中式的建筑结构，在有可能的情况下，选择小面积搭建，或模型拍摄，大场
		景在三维建模的基础上以matte－painting的方式呈现。现实中的场景为未来感极强的都市为主，以凸显反差。
		（社会化未变）</span>
                </p>
                <p class="blue fs16 indent0 mt20 fwb">
                    <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                    关于调度：
                    <span class="detail-word-gray">镜头设计在有空间描述的时候选用全境别，环绕式的运动， 以体现人物与环境的关系。强化视觉效果。</span>
                </p>
                <p class="blue fs16 indent0 mt20 fwb">
                    <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                    关于转场：
                    <span class="detail-word-gray"> 黑卡姆城与现实的转场衔接，以特效手段的空间长位移掉队为主。</span>
                </p>
            </div>
        </div>
    </div>

    <div class="bg-gray mb40">
        <div class="detail-info detail-info-one ">
            <div class="detail-leftpart fl">
                <div class="leftinfo-tpart">
                    <h2>《黑卡姆城》项目卖点</h2>
                </div>
            </div>
            <div class="detail-rightpart">
                <p class="blue fs18 indent0 mt20 fwb">
                    1、
                    <span class="detail-word-gray">以历史、神话为背景的中国神秘堪舆术，具有中国玄幻色彩的“科幻”设定。</span>
                </p>
                <p class="blue fs18 indent0 mt20 fwb">
                    2、
                    <span class="detail-word-gray">以楼兰、大汉为文化背景参考设定的遗失古文明，有强烈的异域风情。</span>
                </p>
                <p class="blue fs18 indent0 mt20 fwb">
                    3、
                    <span class="detail-word-gray">典型好莱坞剧作模式。剧情紧凑，节奏感强，悬疑色彩浓厚。</span>
                </p>
                <p class="blue fs18 indent0 mt20 fwb">
                    4、
                    <span class="detail-word-gray">人物设定聚焦于第一批步入社会的90后女性。女主角为90后女孩，人物不老 套，现代感强。</span>
                </p>
                <p class="blue fs18 indent0 mt20 fwb">
                    5、
                    <span class="detail-word-gray">历史、神话结合的环境视觉奇观，并来源于中国神话。</span>
                </p>
                <p class="blue fs18 indent0 mt20 fwb">
                    6、
                    <span class="detail-word-gray">有大量以女主角为主的动作场面，惊险刺激，并伴有喜剧元素。</span>
                </p>
                <p class="blue fs18 indent0 mt20 fwb">
                    7、
                    <span class="detail-word-gray">对于社会制度的哲学性反思，故事底蕴深厚，言之有物。</span>
                </p>
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