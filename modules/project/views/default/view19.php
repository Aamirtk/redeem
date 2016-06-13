<?php
use frontend\modules\project\models\Project;
use frontend\modules\project\models\ProjFavorite;
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>目录页</title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="renderer" content="webkit"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <link rel="stylesheet" type="text/css" href='http://cz.vsochina.com/themes/creation/css/jquery.mCustomScrollbar.css'>
    <link rel="stylesheet" type="text/css" href="http://account.vsochina.com/static/css/login/common.css?v=20150831"   />

    <link rel="stylesheet" type="text/css" href="/css/dreamSpace.css"/>
    <link rel="stylesheet" type="text/css" href="/css/detail.css" />


    <script language="javascript" type="text/javascript" charset="utf-8" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
    <script src='http://cz.vsochina.com/themes/creation/js/jquery.mCustomScrollbar.concat.min.js'></script>
</head>
<body class="view-blue-bg">
<!--header-top-->
<script type="text/javascript" charset="utf-8" src="http://account.vsochina.com/static/js/vsoheader.js"></script>
<!--/header-top-->
<!--detail-content-->
<div class="westcampus-box">
    <div class="westcampus-banner">
        <h2 class="h1">蓝海创意云文创基金专区</h2>
        <h2 class="h2">联手国内外资本打造创新的文创孵化服务</h2>
        <p class="txt-box">
            <span class="txt-bg"></span>
            <span class="txt-txt">助力创业者实现创业梦想，伴你走上成功之路！</span>
        </p>
    </div>
</div>
<div class="westcampus-strategic">
    <div class="westcampus-strategic-cooperation">
        <div class="westcampus-enterprise-title">
            <p class="enterprise-title-en">Investment Fund</p>
            <p class="enterprise-title-ch">蓝海创意云文创意基金投资计划</p>
        </div>
        <p class="strategic-para">
            “蓝海创意云”平台由中国传媒大学旗下的高科技产业化公司蓝海彤翔研发并运营，是全球首创的综合性文化产业云平台，定位于影视动漫制作的全流程业务管理，以互联网的优势服务于文化创意产业。平台由任务大厅、在线创作、渲染农场、创意商城、创意社区五大板块组成，各版块之间通过流程及功能的互动和链接，形成了一个完整的文化创意产业的生态链，构建了一个创新型产业模式，实现了文化创意产业的云端生态社区。
        </p>
        <p class="strategic-para mt25">
            “蓝海创意云文创基金”由“蓝海创意云”与国内外资本联手打造，旨在培育优质的文创项目，可以为项目方提供包含早期扶持、影视器材租赁、IP投资、完片担保、电影发行、影视衍生物投资等在内的全链条孵化服务。我们期待来自文化创意领域的优秀创业者，与我们一路同行，一起收获。
        </p>
    </div>
</div>

<div class="westcampus-enterprise">
    <div class="westcampus-enterprise-title">
        <p class="enterprise-title-en project">Project focus</p>
        <p class="enterprise-title-ch">项目聚焦</p>
    </div>
</div>

<div class="view-project-all clearfix">
    <div class="view-project-row">
        <div class="view-project-box">
            <a href="http://maker.vsochina.com/project/4" class="lazy-box" style="width: 580px;height: 210px;">
                <img class="lazy" data-original="/images/100/1.jpg" alt="深海总动员">
            </a>
            <div class="plr20">
                <div class="view-project-left">
                <p class="view-project-title">《深海总动员》</p>
                <p class="view-project-bread">
                    <i class="ds-icon-16 ds-icon-blue-right"></i>
                    影视制作 <b>|</b> 动画项目 <b>|</b> 三维
                </p>
                </div>
                <a href="http://maker.vsochina.com/project/4" class="ds-btn ds-btn-blue">了解详情</a>
                <br class="clear">
                <div class="view-project-bottom">
                    《深海总动员》由奥斯卡获奖大片创意班底和中国最成熟的CG制作团队联手打造，影片讲述深海章鱼狄普寻找海洋中巨大生物南希拯救家园，在途中遇到了许多志同道合的朋友和惊险搞笑的事情。
                </div>
            </div>
        </div>
        <div class="view-project-box">
            <a href="http://maker.vsochina.com/project/5" class="lazy-box" style="width: 580px;height: 210px;">
                <img class="lazy" data-original="/images/100/2.jpg" alt="嘻哈英熊">
            </a>
            <div class="plr20">
                <div class="view-project-left">
                <p class="view-project-title">《嘻哈英熊》</p>
                <p class="view-project-bread">
                    <i class="ds-icon-16 ds-icon-blue-right"></i>
                    影视制作 <b>|</b> 动画项目 <b>|</b> 三维
                </p>
                </div>
                <a href="http://maker.vsochina.com/project/5" class="ds-btn ds-btn-blue">了解详情</a>
                <br class="clear">
                <div class="view-project-bottom">
                    《嘻哈英熊》讲述单身熊爸与动物特工激情对撞，上演了一场搞笑、刺激的冒险之旅，展现了“家人与爱”这一永恒不变的亲情主题。
                </div>
            </div>
        </div>
        <div class="view-project-box">
            <a href="http://maker.vsochina.com/project/6" class="lazy-box" style="width: 580px;height: 210px;">
                <img class="lazy" data-original="/images/100/3.jpg" alt="异兽来袭">
            </a>
            <div class="plr20">
                <div class="view-project-left">
                <p class="view-project-title">《异兽来袭》</p>
                <p class="view-project-bread">
                    <i class="ds-icon-16 ds-icon-blue-right"></i>
                    影视制作 <b>|</b> 真人电影  <b>|</b> CG
                </p>
                </div>
                <a href="http://maker.vsochina.com/project/6" class="ds-btn ds-btn-blue">了解详情</a>
                <br class="clear">
                <div class="view-project-bottom">
                    《异兽来袭》题材独特，着力表现一群形形色色的小人物在遭遇凶残异兽的极端灾难事件后，从被动逃避到主动反击，在一次次付出惨痛的代价之后，凭借亲情、爱情、友情等情感的支撑，最终幸存下来的男女主角战胜了异兽。
                </div>
            </div>
        </div>
        <div class="view-project-box">
            <a href="http://maker.vsochina.com/project/7" class="lazy-box" style="width: 580px;height: 210px;">
                <img class="lazy" data-original="/images/100/4.jpg" alt="龙之重生">
            </a>
            <div class="plr20">
                <div class="view-project-left">
                    <p class="view-project-title">《龙之重生》</p>
                    <p class="view-project-bread">
                        <i class="ds-icon-16 ds-icon-blue-right"></i>
                        影视制作 <b>|</b> 动画项目  <b>|</b> 三维
                    </p>
                </div>
                <a href="http://maker.vsochina.com/project/7" class="ds-btn ds-btn-blue">了解详情</a>
                <br class="clear">
                <div class="view-project-bottom">
                    《龙之重生》根据第一部成功打入美国漫画市场的同名中国英雄漫画改编，讲述来自中国东海岸的一对双胞胎兄妹由中国龙的遗骸发掘出超能力而被邪恶力量觊觎，为了阻止邪恶计划并维护世界和平而变身成为超级英雄的故事。
                </div>
            </div>
        </div>
    </div>

</div>


<div class="view-all-project">
    <div class="ds-1200">
        <div class="ds-all-project-title">
            <!--<a target="_blank" href="http://cz.vsochina.com" class="pull-right">查看项目列表&gt;&gt;</a>-->
            <span class="font40">A</span>
                <span class="all-title">
                    <b>全部项目</b>
                    <i>LL PROJECTS</i>
                </span>
            <br class="clear">
        </div>

        <div class="view-project-row">
            <div class="view-project-box">
                <a href="http://maker.vsochina.com/project/4" class="lazy-box" style="width: 363px;height: 280px;">
                    <img class="lazy" data-original="/images/100/12.jpg" alt="深海总动员">
                </a>
                <div class="plr10">
                    <div class="view-project-left">
                        <p class="view-project-title">《深海总动员》</p>
                        <p class="view-project-bread">
                            <i class="ds-icon-16 ds-icon-blue-right"></i>
                            影视制作 <b>|</b> 动画项目  <b>|</b> 三维
                        </p>
                    </div>
                    <a href="http://maker.vsochina.com/project/4" class="ds-btn ds-btn-blue">了解详情</a>
                    <br class="clear">
                </div>
            </div>
            <div class="view-project-box">
                <a href="http://maker.vsochina.com/project/5" class="lazy-box" style="width: 363px;height: 280px;">
                    <img class="lazy" data-original="/images/100/13.jpg" alt="嘻哈英熊">
                </a>
                <div class="plr10">
                    <div class="view-project-left">
                        <p class="view-project-title">《嘻哈英熊》</p>
                        <p class="view-project-bread">
                            <i class="ds-icon-16 ds-icon-blue-right"></i>
                            影视制作 <b>|</b> 动画项目  <b>|</b> 三维
                        </p>
                    </div>
                    <a href="http://maker.vsochina.com/project/5" class="ds-btn ds-btn-blue">了解详情</a>
                    <br class="clear">
                </div>
            </div>
            <div class="view-project-box">
                <a href="http://maker.vsochina.com/project/6" class="lazy-box" style="width: 363px;height: 280px;">
                    <img class="lazy" data-original="/images/100/14.jpg" alt="异兽来袭">
                </a>
                <div class="plr10">
                    <div class="view-project-left">
                        <p class="view-project-title">《异兽来袭》</p>
                        <p class="view-project-bread">
                            <i class="ds-icon-16 ds-icon-blue-right"></i>
                            影视制作 <b>|</b> 真人电影  <b>|</b> CG
                        </p>
                    </div>
                    <a href="http://maker.vsochina.com/project/6" class="ds-btn ds-btn-blue">了解详情</a>
                    <br class="clear">
                </div>
            </div>
            <div class="view-project-box">
                <a href="http://maker.vsochina.com/project/7" class="lazy-box" style="width: 363px;height: 280px;">
                    <img class="lazy" data-original="/images/100/15.jpg" alt="龙之重生">
                </a>
                <div class="plr10">
                    <div class="view-project-left">
                        <p class="view-project-title">《龙之重生》</p>
                        <p class="view-project-bread">
                            <i class="ds-icon-16 ds-icon-blue-right"></i>
                            影视制作 <b>|</b> 动画项目  <b>|</b> 三维
                        </p>
                    </div>
                    <a href="http://maker.vsochina.com/project/7" class="ds-btn ds-btn-blue">了解详情</a>
                    <br class="clear">
                </div>
            </div>
            <div class="view-project-box">
                <a href="http://maker.vsochina.com/project/8" class="lazy-box" style="width: 363px;height: 280px;">
                    <img class="lazy" data-original="/images/100/5.jpg" alt="匹诺曹3000">
                </a>
                <div class="plr10">
                    <div class="view-project-left">
                        <p class="view-project-title">《匹诺曹3000》</p>
                        <p class="view-project-bread">
                            <i class="ds-icon-16 ds-icon-blue-right"></i>
                            影视制作 <b>|</b> 动画项目  <b>|</b> 三维
                        </p>
                    </div>
                    <a href="http://maker.vsochina.com/project/8" class="ds-btn ds-btn-blue">了解详情</a>
                    <br class="clear">
                </div>
            </div>
            <div class="view-project-box">
                <a href="http://maker.vsochina.com/project/15" class="lazy-box" style="width: 363px;height: 280px;">
                    <img class="lazy" data-original="/images/100/6.jpg" alt="酥脆21克">
                </a>
                <div class="plr10">
                    <div class="view-project-left">
                        <p class="view-project-title">《酥脆21克》</p>
                        <p class="view-project-bread">
                            <i class="ds-icon-16 ds-icon-blue-right"></i>
                            影视制作 <b>|</b> 真人电影  <b>|</b> CG
                        </p>
                    </div>
                    <a href="http://maker.vsochina.com/project/15" class="ds-btn ds-btn-blue">了解详情</a>
                    <br class="clear">
                </div>
            </div>
            <div class="view-project-box">
                <a href="http://maker.vsochina.com/project/10" class="lazy-box" style="width: 363px;height: 280px;">
                    <img class="lazy" data-original="/images/100/7.jpg" alt="SMART">
                </a>
                <div class="plr10">
                    <div class="view-project-left">
                        <p class="view-project-title">《SMART》</p>
                        <p class="view-project-bread">
                            <i class="ds-icon-16 ds-icon-blue-right"></i>
                            影视制作 <b>|</b> 动画项目  <b>|</b> 三维
                        </p>
                    </div>
                    <a href="http://maker.vsochina.com/project/10" class="ds-btn ds-btn-blue">了解详情</a>
                    <br class="clear">
                </div>
            </div>
            <div class="view-project-box">
                <a href="http://maker.vsochina.com/project/16" class="lazy-box" style="width: 363px;height: 280px;" >
                    <img class="lazy" data-original="/images/100/8.jpg" alt="Panda Land">
                </a>
                <div class="plr10">
                    <div class="view-project-left">
                        <p class="view-project-title">《Panda Land》</p>
                        <p class="view-project-bread">
                            <i class="ds-icon-16 ds-icon-blue-right"></i>
                            影视制作 <b>|</b> 动画项目  <b>|</b> 三维
                        </p>
                    </div>
                    <a href="http://maker.vsochina.com/project/16" class="ds-btn ds-btn-blue">了解详情</a>
                    <br class="clear">
                </div>
            </div>
            <div class="view-project-box">
                <a href="http://maker.vsochina.com/project/11" class="lazy-box" style="width: 363px;height: 280px;">
                    <img class="lazy" data-original="/images/100/9.jpg" alt="Theo">
                </a>
                <div class="plr10">
                    <div class="view-project-left">
                        <p class="view-project-title">《Theo》</p>
                        <p class="view-project-bread">
                            <i class="ds-icon-16 ds-icon-blue-right"></i>
                            影视制作 <b>|</b> 动画项目  <b>|</b> 三维
                        </p>
                    </div>
                    <a href="http://maker.vsochina.com/project/11" class="ds-btn ds-btn-blue">了解详情</a>
                    <br class="clear">
                </div>
            </div>
            <div class="view-project-box">
                <a href="http://maker.vsochina.com/project/9" class="lazy-box" style="width: 363px;height: 280px;">
                    <img class="lazy" data-original="/images/100/16.jpg" alt="蜀山剑侠传">
                </a>
                <div class="plr10">
                    <div class="view-project-left">
                        <p class="view-project-title">《蜀山剑侠传》</p>
                        <p class="view-project-bread">
                            <i class="ds-icon-16 ds-icon-blue-right"></i>
                            影视制作 <b>|</b> 电视剧项目  <b>|</b> 武侠
                        </p>
                    </div>
                    <a href="http://maker.vsochina.com/project/9" class="ds-btn ds-btn-blue">了解详情</a>
                    <br class="clear">
                </div>
            </div>
            <div class="view-project-box">
                <a href="http://maker.vsochina.com/project/14" class="lazy-box" style="width: 363px;height: 280px;">
                    <img class="lazy" data-original="/images/100/11.jpg" alt="森果精灵">
                </a>
                <div class="plr10">
                    <div class="view-project-left">
                        <p class="view-project-title">《森果精灵》</p>
                        <p class="view-project-bread">
                            <i class="ds-icon-16 ds-icon-blue-right"></i>
                            影视制作 <b>|</b> 动画项目  <b>|</b> 三维
                        </p>
                    </div>
                    <a href="http://maker.vsochina.com/project/14" class="ds-btn ds-btn-blue">了解详情</a>
                    <br class="clear">
                </div>
            </div>
            <div class="view-project-box">
                <a href="http://maker.vsochina.com/project/12" class="lazy-box" style="width: 363px;height: 280px;">
                    <img class="lazy" data-original="/images/100/17.jpg" alt="无敌小飞猪2">
                </a>
                <div class="plr10">
                    <div class="view-project-left">
                        <p class="view-project-title">《无敌小飞猪2》</p>
                        <p class="view-project-bread">
                            <i class="ds-icon-16 ds-icon-blue-right"></i>
                            影视制作 <b>|</b> 真人电影  <b>|</b> 动画合成
                        </p>
                    </div>
                    <a href="http://maker.vsochina.com/project/12" class="ds-btn ds-btn-blue">了解详情</a>
                    <br class="clear">
                </div>
            </div>
            <div class="view-project-box">
                <a href="http://maker.vsochina.com/project/18" class="lazy-box" style="width: 363px;height: 280px;">
                    <img class="lazy" data-original="/images/100/18.jpg" alt="十二生肖之生肖传奇">
                </a>
                <div class="plr10">
                    <div class="view-project-left">
                        <p class="view-project-title">《十二生肖之生肖传奇》</p>
                        <p class="view-project-bread">
                            <i class="ds-icon-16 ds-icon-blue-right"></i>
                            影视制作 <b>|</b> 动画项目
                        </p>
                    </div>
                    <a href="http://maker.vsochina.com/project/18" class="ds-btn ds-btn-blue">了解详情</a>
                    <br class="clear">
                </div>
            </div>
            <div class="view-project-box">
                <a href="http://maker.vsochina.com/project/17" class="lazy-box" style="width: 363px;height: 280px;">
                    <img class="lazy" data-original="/images/100/19.jpg" alt="黑卡姆城">
                </a>
                <div class="plr10">
                    <div class="view-project-left">
                        <p class="view-project-title">黑卡姆城</p>
                        <p class="view-project-bread">
                            <i class="ds-icon-16 ds-icon-blue-right"></i>
                            影视制作 <b>|</b> 电影项目 <b>|</b> 科幻
                        </p>
                    </div>
                    <a href="http://maker.vsochina.com/project/17" class="ds-btn ds-btn-blue">了解详情</a>
                    <br class="clear">
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
<script type="text/javascript" src="/js/dreamSpace.js?v=1"></script>
<script type="text/javascript" src="/js/project_action.js"></script>

<script type="text/javascript"></script>



<?php require_once(Yii::getAlias('@frontend') . '/web/layout/footer.php') ?>
</body>
</html>