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
            <h1>Theo（简单任务）</h1>
            <p>
                <span>一个史诗的故事，关于一群小动物努力克服一切困难，以阻止人类战争和拯救自己的同类。</span>
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
        <div class="detail-graphic" style="width:1200px; 450px;">
            <img src="/images/11/1.jpg" alt="<?= $project['proj_name'] ?>"  />
        </div>
    </div>
    <!--/detail-banner-->

    <!--detail-info-->
    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《Theo》项目概述</h2>
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
            <div class="lazy-box " style="width:753px; height:208px; ">
                <img data-original="/images/11/2.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
            </div>
            <p class="blue fs16 indent0 mt20 fwb">
                故事模式：
                <span class="detail-word-gray">动漫式冒险</span>
            </p>
            <p class="blue fs16 indent0 fwb">
                目标观众：
                <span class="detail-word-gray">所有年龄层</span>
            </p>
            <p class="blue fs16 indent0 fwb">
                格式：
                <span class="detail-word-gray">三维动画</span>
            </p>
            <p class="blue fs16 indent0 fwb">
                片长：
                <span class="detail-word-gray">90  分钟</span>
            </p>
            <p class="blue fs16 indent0 mt20 fwb">
                故事亮点
            </p>
            <p class="indent0">
                1.喜剧 、勇气 、冒险 、浪漫和团队精神；
            </p>
            <p class="indent0">
                2. 儿童 、青少年及所有年龄；
            </p>
            <p class="indent0">
                3.东方和西方文化的融合；
            </p>
            <p class="blue fs16 indent0 mt20 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                我们的独特性和竞争优势
            </p>
            <p class="indent0">
                1.结合了好莱坞和亚洲专业人员；
            </p>
            <p class="indent0">
                2. 独特的风格，结合了微型模型制作和CG动画制作；
            </p>
            <p class="indent0">
                3.动画制作和管理管道的丰富经验；
            </p>
            <p class="indent0">
                4.以中国工艺大师的优势；
            </p>
            <p class="indent0">
                5.利用3D打印，加快生产过程；
            </p>
        </div>
    </div>
    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《Theo》项目内容</h2>
            </div>
            <div class="leftinfo-mpart">
                <p class="leftinfo-mpart-category-new">
                    <i class="ds-icon-16 ds-icon-entertime"></i>
                    项目入驻时间：<?= date('Y-m-d', $project['created_at'])?>
                </p>
            </div>
        </div>
        <div class="detail-rightpart">
            <div class="detail-rightpart-images">
                <div class="lazy-box" style="width:750px;height: 82px;">
                    <img data-original="/images/11/3.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
            <p class="indent1 mt20">
                简单任务这部长篇动画电影，是描述关于生存在常人难于看到的昆虫世界里发生的一些惊险趣事，主角是一群可爱有趣并且充满活力的昆虫。纵观现在环球经济走向成熟，人类社会处于政经文教皆提升的阶段。这部长篇动画电影横空出世，带来了一篇关于年轻壁虎的冒险传奇。故事发生于主角西奥的少年时代，这也是他人生的转捩点。我们会随着主角进入一个奇趣的昆虫村庄，里面住着一群可爱逗趣的昆虫及令人难以忘怀的爬虫，这样的奇幻世界势必会拓展孩童们的想象视野。
            </p>
            <p class="indent1">
                西奥的伙伴有搞怪滑稽的胖子青蛙山姆。他会伴随意志坚定的男主角西奥面对这场人类掀起的大规模战争。这场会导致生灵涂炭的战役将会毁灭西奥他们居住的村庄。面对如此困境，甜美动人的女壁虎林将介入这个动荡的局势。从开始的互相抵触到最后的惺惺相惜，面对危机的时刻，一切争执随风而散，取而代之的是患难见真情。
            </p>
            <p class="indent0">
                我们的三维主人翁是否能顺利把信件传送出去，以阻止这场斗争？即便面对极为艰辛的难关和挑战？他们三位朝夕相处的伙伴是否会发生动人的爱情故事，还是令人唏嘘的三角恋？年少的他们总有些许自负和不成熟，他们是否能克服这些并以大局为重？当他们找到了人生真谛后，是否会继续秉持下去？
            </p>
            <p class="indent0">
                惊心动魄的冒险之旅，高潮迭起令人喘不过气的故事情节，加上千军万马的史诗级战争场面。个中答案将在走完这趟终
                极之旅后揭晓。
            </p>
            <p class="blue fs16 indent0 mt55 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                好莱坞独一无二3D立体动画电影制作
            </p>
            <div class="lazy-box mt20" style="width:740px;height: 360px;">
                <img data-original="/images/11/4.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
            </div>
            <p class="indent0">
                微型场景和道具制作/3D打印/3D电脑动画/中国精细的制作工艺/微距摄影制作
            </p>
            <div class="lazy-box mt20" style="width:732px;height: 373px;">
                <img data-original="/images/11/5.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
            </div>
            <p class="indent0">
                特效绿幕拍摄
            </p>

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
                    《Theo》项目由成熟的国际团队强强联合制作。
                </p>
            </div>
        </div>
        <div class="detail-rightpart">
            <p class="blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                导演——NICKSON FONG尼克森
            </p>
            <p class="indent0">
                Nickson Fong是2013年奥斯卡技术成就奖得主，他发明的Pose Space Deformation技术为CG角色动画带来了革命，
                并在很多好莱坞大片中反复使用。他参与的经典作品有《怪物史莱克》、《精灵鼠小弟》等。
            </p>
            <div class="detail-rightpart-images mt20 mb40">
                <div class="lazy-box" style="width:570px; height:338px;">
                    <img data-original="/images/11/6.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
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
                            <img src="/images/11/slide01.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/11/slide02.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/11/slide03.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/11/slide04.jpg" alt="<?= $project['proj_name'] ?>" />
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