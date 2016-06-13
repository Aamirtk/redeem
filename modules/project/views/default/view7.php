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
                <span>来自中国东海岸的一对双胞胎兄妹由中国龙的遗骸发掘出超能力而被邪恶力量觊觎，为了阻止邪恶计划并维护世界和平而变身成为超级英雄的故事。</span>
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
            <img src="/images/7/banner-pro1.jpg" alt="<?= $project['proj_name'] ?>"  />
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
                                <span id="support_pno">1500万</span>
                                人民币
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
            <div class="detail-rightpart-images">
                <div class="lazy-box" style="width:750px;height: 400px;">
                    <img data-original="/images/7/detail-img2.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>

            <div class="detail-rightpart-images fr mt35 mr15">
                <div class="lazy-box" style="width:202px;height: 385px;">
                    <img data-original="/images/7/detail-img3.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
            <p class="blue fs16 fwb indent0 mt35">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                童话优势
            </p>
            <p class="indent0">
                1.动画流程构建框架完整，技术水平国内领先；
            </p>
            <p class="indent0">
                2. 集结岛城最优秀动画精英；
            </p>
            <p class="indent0">
                3.下线百人团队磨合期超过2年；
            </p>
            <p class="indent0">
                4.国际高端动画项目起家，国际最新动画技术随时更新。
            </p>


            <p class="blue fs16 fwb indent0 mt35">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                剧本
            </p>
            <p class="indent0">
                国际认可（畅销漫画，黑马发行）
            </p>


            <p class="blue fs16 fwb indent0 mt35">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                制作团队
            </p>
            <p class="indent0">
                经验丰富，身经百战
            </p>


            <p class="blue fs16 fwb indent0 mt35">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                项目总费用
            </p>
            <p class="indent0">
                整体电影制作预算3000万元人民币
            </p>


            <p class="blue fs16 fwb indent0 mt35">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                预计投资回报
            </p>
            <p class="indent0">
                <span class="mr50">筹资：1500万用于三维动画制作</span>
                <span class="mr50">占票房收益：50%</span>
                <span class="mr50">基于电影的衍生产品的分享收益50%</span>
            </p>
            <p class="indent0 blue">预计总收益：5000万</p>
            <p class="indent0">
                <span class="mr50">自筹：1500万元人民币（用于前期设计和部分三维动画制作，海外配音配乐）  </span>
                <span class="mr50">占票房收益：50%</span>
            </p>
            <p class="indent0">基于电影的衍生产品的分享收益50% </p>
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
                <p class="leftinfo-mpart-desc indent-5">
                    《龙之重生》是漫画历史和国际主流市场首次出现的中国超级英雄作品，也是泽灵超能英雄系列的开篇之作。在2012年7月的圣迭戈动漫展上，黑马漫画公司公布了《龙之重生》的发行预告，泽灵也以黑马特别嘉宾的形式出席了该动漫展，并接受了MTV:Geek专访。
                </p>
            </div>
        </div>
        <div class="detail-rightpart">

            <div class="detail-rightpart-images">
                <div class="lazy-box" style="width:750px;height: 82px;">
                    <img data-original="/images/7/detail-img4.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
            <p class="mt24">
                龙是真真实实存在的。
            </p>
            <p>
                至少，它们曾经存在过……
            </p>
            <p>
                中国探险家张杰西一直不相信她父亲建成所讲的有关中国龙的故事传说，直到有一天，她和父亲在西藏的冰山里发现了一具冰封的龙的遗骸从而证实了龙的确曾经存在过的事实。建成毕生的探求，也为杰西的孪生哥哥杰克的职业生涯带来契机。杰克是在美国生活的遗传学专家，他开始着手解码龙的DNA的潜力，希望能够不负家人的期望用基因技术治愈自己瘫痪的双腿。
            </p>
            <p>
                但是他的试验结果被一位别有用心的美国将军所窃取， 并将杰克绑架。 危机关头，杰西被迫将杰克未经实验的龙DNA配方注射到自己体内，从而释放出久远年代里龙那古老的超能力。最终，这对孪生兄妹不得不面对一场与变异兽士兵大军的激烈对抗，从而阻止将军的邪恶计划并维护世界和平。
            </p>
            <div class="detail-rightpart-images mt24">
                <div class="lazy-box" style="width:736px;height: 346px;">
                    <img data-original="/images/7/detail-img5.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
            <div class="detail-rightpart-images mt10">
                <div class="lazy-box" style="width:736px;height: 371px;">
                    <img data-original="/images/7/detail-img6.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
            <div class="detail-rightpart-images mt10">
                <div class="lazy-box" style="width:736px;height: 208px;">
                    <img data-original="/images/7/detail-img7.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
        </div>
    </div>

    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》项目背景</h2>
            </div>
        </div>
        <div class="detail-rightpart">
            <p>
                自20世纪30年代的超人诞生起，已经有数千位超级英雄在报纸、图书、电视和大荧幕上无数次地拯救了地球，在近几年更是不断地在世界范围内掀起票房狂潮。然而如此庞大的队伍中，却从未有一个东方面孔以正面形象出现，行侠仗义，拯救世界。
            </p>
            <p>
                今天，这种局面将被彻底打破，历史将被这一部作品改变 ----《龙之重生：杰西与杰克第一次冒险》这部由泽灵原创、美国黑马全球发行的动漫作品已经横空出世。
            </p>
            <p>
                《龙之重生》是漫画历史和国际主流市场首次出现的中国超级英雄作品，也是泽灵超能英雄系列的开篇之作。在2012年7月的圣迭戈动漫展上，黑马漫画公司公布了《龙之重生》的发行预告，泽灵也以黑马特别嘉宾的形式出席了该动漫展，并接受了MTV:Geek专访。随后，众多国外媒体纷纷报道了《龙之重生》这一来自中国的首个超级漫画英雄漫画。 目前，《龙之重生》正由美国黑马漫画公司进行全球发行，在黑马数字商店、亚马逊等多种方渠道接收预定，实体书也将从今年五月提供。
            </p>
            <p>
                注：美国黑马漫画公司已有近30年的历史，发行了诸如《阿童木》、《机械战警》、《变相怪杰》、《地狱男爵》、《苹果核战记》、《罪恶之城》、《斯巴达300》、《古墓丽影》、《星球大战》、《蛮王柯南》等无数经典作品，是美国漫画三巨头之一，也是当今全球最大的独立漫画出版商。
            </p>
            <div class="detail-rightpart-images mt24">
                <div class="lazy-box" style="width:739px;height: 359px;">
                    <img data-original="/images/7/detail-img8.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
            <div class="detail-rightpart-images mt24">
                <div class="lazy-box" style="width:732px;height: 373px;">
                    <img data-original="/images/7/detail-img9.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
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
                <!--
                <p class="leftinfo-mpart-desc indent-5">
                    《深海》项目由成熟的国际团队制作，作品具有和进口片同样的质量和中国的较低成本，适合进取型的发行公司投资并参与。
                </p>
                -->
            </div>
        </div>
        <div class="detail-rightpart">
            <p class="blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                导演——卡罗琳·塞尔徳
            </p>
            <p class="indent0">
                卡罗琳·塞尔徳的作品获得诸多国内及国际奖项，并在电影电视节上获奖，包括：美国电影顾问委员会奖、美国电影节、美国温馨电影展、国际家庭电影节、美国桑塔·芭芭拉电影节、芝加哥国际电影节、奥斯汀影展、英国电影魔法电影节、父母电视委员会、鸽子基金会。
            </p>


            <p class="mt35 blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                执行导演——艾德里安
            </p>
            <p class="indent0">
                代表作
            </p>
            <div class="detail-rightpart-images mt10">
                <div class="lazy-box" style="width:733px;height: 282px;">
                    <img data-original="/images/7/detail-img10.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>


            <p class="mt35 blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                动作导演——艾瑞克
            </p>
            <p class="indent0">
                代表作
            </p>
            <div class="detail-rightpart-images mt10">
                <div class="lazy-box" style="width:596px;height: 168px;">
                    <img data-original="/images/7/detail-img11.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>


            <p class="mt35 blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                制片人——张英松
            </p>
            <p class="indent0">
                童幻动漫有限公司创始人，曾经参与《龙之谷》，《pix》，《中国梦》等电影的开发和制作
            </p>


            <p class="mt35 blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                制片人——张霖
            </p>
            <p class="indent0">
                泽灵文化传播有限公司创始人，带领团队创作了《龙之重生》等一系列原创项目。如今，泽灵文化传媒有限公司已经成为亚洲最具创造力和国际化的动漫概念创意公司之一。
            </p>


            <p class="mt35 blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                制片人——拜尔斯
            </p>
            <p class="indent0">
                艾美奖提名的制片人，拜尔斯制片或导演了大量的独立电影，执笔了30多部电影剧本，并执笔、制片了众多动画电影以及系列剧。拜尔斯在亚洲影视界有着十几年的经验。其著名作品包括、《刮痧》、《猛龙特警》等。
            </p>


            <p class="mt35 blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                执行制片人——古拉斯
            </p>
            <p class="indent0">
                作为一位在新锐媒体制作、新媒体技术以及交互式网络电视领域中从业近二十年的先驱人物，被美国《连线》命名为“重塑好莱坞娱乐的25人”之一。 先后为《泰坦尼克号》、《彗星撞地球》等电影亲自担纲视觉特效总监，并在《从地球到月球》的出色视效表现而荣获艾美奖提名。
            </p>
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
                            <img src="/images/7/slide01.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/7/slide02.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/7/slide03.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/7/slide04.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/7/slide05.jpg" alt="<?= $project['proj_name'] ?>" />
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