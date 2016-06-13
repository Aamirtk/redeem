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
                <span>无敌魔幻小战队与外星人的斗智斗勇魔法大战。</span>
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
            <img src="/images/12/banner-pro1.jpg" alt="<?= $project['proj_name'] ?>"  />
        </div>
    </div>
    <!--/detail-banner-->

    <!--detail-info-->
    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《无敌小飞猪2》项目概述</h2>
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
                    <span class="category-content">真人三维动画电影</span>
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
                <div class="lazy-box" style="width:750px;height: 400px;">
                    <img data-original="/images/12/detail-img2.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>

            <div class="detail-rightpart-images fr mt55 ml15">
                <div class="lazy-box" style="width:202px;height: 385px;">
                    <img data-original="/images/12/detail-img3.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
            <p class="blue fs16 fwb indent0 mt35 mr232" style="margin-right: 232px;">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                电影简介
            </p>
            <p class="mr232">
                《无敌小飞猪》是由导演 宋占涛 执导国内首部少儿真人动画魔幻电影，由于东泽、范子轩等主演。影片2015年4月3日在中国内地上映。
            </p>
            <p class="mr232">
                电影讲述了训练营里女孩凌菲，带领无敌魔幻小战队，在人见人爱小飞猪的帮助下，与盗取时空法器的外星虫，展开了一场斗智斗勇的魔法大战。
            </p>
            <p class="mt35 pr232">
                《无敌小飞猪》是导演宋占涛打造的儿童魔幻主题系列电影，第一部集结007邦女郎卡特琳娜•莫里诺、香港老戏骨徐少强、台湾搞笑天才张立威等老牌巨星，于今年上半年成功登陆全国荧屏，上映后口碑与票房获得双丰收。影片中由CG特效制作的动画角色——来自外星球的小飞猪，也凭借可爱呆萌、智勇双全的设定虏获了大量粉丝。
            </p>
            <p class="mt35 pr232">
                第二部《无敌小飞猪之虚灵特战队》将延续真人与3D动画结合的创作手法。在3D动画的制作中，影片制片方通过与蓝海创意云展开合作，引入更加优秀的特效团队，将着力改进第一部影片在VFX视觉特效、DI数字中间片等方面有所欠缺的地方，力求让影片的特效制作更上一层楼，为观众带来一场真人与动画无缝契合的奇幻之旅。
            </p>
        </div>
    </div>

    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《无敌小飞猪2》项目内容</h2>
            </div>
            <div class="leftinfo-mpart">
                <p class="leftinfo-mpart-category-new">
                    <i class="ds-icon-16 ds-icon-entertime"></i>
                    项目入驻时间：<?= date('Y-m-d', $project['created_at'])?>
                </p>
                <p class="leftinfo-mpart-desc indent-5">
                    《无敌小飞猪之虚灵特战队》将延续真人与3D动画结合的创作手法。在3D动画的制作中，影片制片方通过与蓝海创意云展开合作，引入更加优秀的特效团队，将着力改进第一部影片在VFX视觉特效、DI数字中间片等方面有所欠缺的地方，力求让影片的特效制作更上一层楼。
                </p>
            </div>
        </div>
        <div class="detail-rightpart">

            <div class="detail-rightpart-images">
                <div class="lazy-box" style="width:750px;height: 82px;">
                    <img data-original="/images/12/detail-img4.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
            <p class="mt24">
                主人公凌菲是一个略带“公主病”的小千金，被父母送到了一个古怪的训练营里打发暑假。在这个古怪的训练营里凌菲认识了电脑神童艾丁，俩人很快成为了好朋友；
            </p>
            <p class="mt24">
                某天夜里，凌菲独自一人出来散步，偶遇了从天而降的小飞猪。凌菲觉得它很可爱就把它带回了宿舍。从此，凌菲带着小飞猪一起参加训练营的各种活动。
            </p>
            <p class="mt24">
                一天小飞猪闯进了教授古拉法的实验室里，跟教授捣乱，觉得教授的实验室里非常好玩，准备下次带凌菲他们一起来玩。于此同时，由外星势力老大派来的两只外星虫子偷偷潜入了训练营，准备偷取藏在教授实验室里的时空法器。小飞猪带着凌菲等人来到教授古拉法的实验室，却发现教授受了伤，并指知道了教授的真实身份。原来古拉法是活了上千年的魔法老师，一直掌握着守护开启魔法时空门的使命！
            </p>
            <p class="mt24">
                教授的无私感染了小孩子们，于是，凌菲等人决定帮助教授抢回装有时空法器的保险箱。最终，在法力无边的小飞猪的帮助下，外星生物的计划彻底落空了。教授并没有采用暴力手段对付两只外星虫子，而是决定开启时空之门，送外星虫回去；经过了此番波澜，训练营里的所有人都开始“长大”，所有人都得到了新的启迪与感悟。
            </p>
            <p class="mt24">
                同时，小飞猪也完成了此次猪猪星球派给他的“天使任务”。小飞猪望着大家恋恋不舍，最后化成一道光穿梭天空……
            </p>
            <div class="detail-rightpart-images mt35">
                <div class="lazy-box" style="width:781px;height: 208px;">
                    <img data-original="/images/12/detail-img5.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
        </div>
    </div>

    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《无敌小飞猪2》项目优势</h2>
            </div>
        </div>
        <div class="detail-rightpart">
            <p>
                剧情曲折生动，于爆笑中解读童心世界，于惊险中诠释少儿成长过程中的“真善美”，传递树立正确教育理念正能量。
            </p>
            <p class="mt24">
                《无敌小飞猪2》剧情跌宕起伏，每一个人物的内心都在随着剧情的发展而发生微妙的改变。《无敌小飞猪》除了赋予作品瑰丽奇幻的想像、，更多的是解读少儿儿童纯真而又丰富的内心世界，讲述了一个快乐成长的故事。贯穿在这个成长故事始终的是发人深省的教育桎棝。而搞笑元素是绝对亮点，在片中所呈现的无敌小猪与孩子们的故事中，一个简单的细节便能戳中观众笑点，令快乐爆棚。
            </p>
            <p class="mt24">
                3D视觉特效震撼酷炫，画面如诗似梦瞬间俘获眼球；真人动画无缝契合，不可思议的新异世界精彩呈现。
            </p>
            <p class="mt24">
                一反国内动画电影盲目跟风好莱坞的现状，《无敌小飞猪》使用真人与动画组合的拍摄手法。呈现在观众面前的是辽阔的宇宙、奇异的植物、超凡入胜的绮丽胜景。影片将曲折的故事融入到这些奇幻场景中，这种写实与玄幻相结合的手法不落窠臼，独树一帜，开创了国产少儿玄幻真人动画电影的先河。
            </p>
            <p class="mt24">
                呆萌小猪无敌搞笑，独门法宝出奇制胜，科幻元素蕴涵题材创新，儿童版“超级英雄”组合横空出世。
            </p>
            <p class="mt24">
                三维动画角色小飞猪是本片最能抓取眼睛的角色之一。它呆萌可爱，法力强大；它来自异星，却又与地球孩子一般顽皮淘气。每一位观众都能从小飞猪身上寻到自己儿时的影子。小飞猪偕同地球小伙伴组成少儿版“正义联盟”，与邪恶外星势力斗智斗勇，展开了一场精彩绝伦的较量，凭借小飞猪无往不胜的独门技能，智能双全的小小“超级英雄”们是否挽救了宇宙的命运呢？4月3日《无敌小飞猪》重磅来袭，开启童心世界的奇幻之旅。
            </p>
            <div class="detail-rightpart-images mt55">
                <div class="lazy-box" style="width:736px;height: 490px;">
                    <img data-original="/images/12/detail-img6.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
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
                    好莱坞巨星007邦德女郎-卡特琳娜加盟儿童魔幻电影《无敌小飞猪》，小飞猪开启全球暖心公映!港台两地“戏骨”联袂助演，甘做绿叶陪衬花朵，演技精湛不落俗套。
                </p>
            </div>
        </div>
        <div class="detail-rightpart">
            <p class="blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                导演——宋占涛
            </p>
            <p class="indent0">
                代表作：《囧蛋奇兵》制片人/监制；《无敌小飞猪》制片人/导演；《瘦身魔方-美丽不瘦》统筹；《染血玫瑰》统筹兼执行导演；《给你一生我的手》统筹；《向导》统筹；《爱的天空下》现场制片；《沉默的呼唤》现场制片。
            </p>


            <p class="mt35 blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                主要演员
            </p>
            <ul class="rightinfo-groupmember num3">
                <li class="mt35">
                    <div class="detail-rightpart-images">
                        <div class="lazy-box" style="width:184px;height: 235px;">
                            <img data-original="/images/12/detail-img7.jpg" alt="万达影视" class="lazy" />
                        </div>
                    </div>
                    <p class="groupmember-role">卡特琳娜·莫里诺</p>
                </li>
                <li class="mt35">
                    <div class="detail-rightpart-images">
                        <div class="lazy-box" style="width:184px;height: 235px;">
                            <img data-original="/images/12/detail-img8.jpg" alt="和颂传媒" class="lazy" />
                        </div>
                    </div>
                    <p class="groupmember-role">徐少强</p>
                </li>
                <li class="mt35">
                    <div class="detail-rightpart-images">
                        <div class="lazy-box" style="width:184px;height: 235px;">
                            <img data-original="/images/12/detail-img9.jpg" alt="和颂传媒" class="lazy" />
                        </div>
                    </div>
                    <p class="groupmember-role">范子轩</p>
                </li>
                <li class="mt35">
                    <div class="detail-rightpart-images">
                        <div class="lazy-box" style="width:184px;height: 235px;">
                            <img data-original="/images/12/detail-img10.jpg" alt="万达影视" class="lazy" />
                        </div>
                    </div>
                    <p class="groupmember-role">张植绿</p>
                </li>
                <li class="mt35">
                    <div class="detail-rightpart-images">
                        <div class="lazy-box" style="width:184px;height: 235px;">
                            <img data-original="/images/12/detail-img11.jpg" alt="和颂传媒" class="lazy" />
                        </div>
                    </div>
                    <p class="groupmember-role">张立威</p>
                </li>
                <li class="mt35">
                    <div class="detail-rightpart-images">
                        <div class="lazy-box" style="width:184px;height: 235px;">
                            <img data-original="/images/12/detail-img12.jpg" alt="和颂传媒" class="lazy" />
                        </div>
                    </div>
                    <p class="groupmember-role">无敌小飞猪</p>
                </li>
            </ul>
            <p class="mt35">
                蓝色小飞猪有一只粉红色的鼻子，身后有一对小翅膀，富有正义感但又极喜欢搞恶作剧。敢于承认错误并且对自己做错的事负责，珍惜友谊并且愿意为朋友挺身而出。喜欢捉弄人，对新奇的事物很感兴趣，喜欢美食，特别是没有见过的美食。希望能完成猪猪星球交给的天使任务，早日回到自己的家乡。
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
                            <img src="/images/12/slide01.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/12/slide02.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/12/slide03.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/12/slide04.jpg" alt="<?= $project['proj_name'] ?>" />
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
    });
</script>

<script type="text/javascript" src="/js/project_detail.js"></script>
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/footer.php') ?>
</body>
</html>