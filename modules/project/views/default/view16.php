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
                <span>问问憨态可爱的熊猫，童话世界是否有条神秘小径可以通往？</span>
            </p>
        </div>
        <!--
        <dl class="detail-producer fr">
            <dt class="fl">
                <a href="" target="_blank" class="detail-portrait-50">
                    <img src="/images/15/1.jpg" alt="<?= $project['proj_name'] ?>" />
                </a>
            </dt>
            <dd class="detail-producer-name">黑潮</dd>
            <dd class="detail-producer-desc">
                <span class="detail-first">游戏制作</span>
            </dd>
        </dl>
         -->
        <div class="detail-graphic" style="width:1200px;height:450px;">
            <img src="/images/16/1.jpg" alt="<?= $project['proj_name'] ?>" />
        </div>
    </div>
    <!--/detail-banner-->

    <!--detail-info-->
    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《PandaLand》项目概述</h2>
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
            <div class="lazy-box mt20" style="width:736px; height:163px; ">
                <img data-original="/images/16/2.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
            </div>
            <p class="gray indent0">
                It is our objective is to make Pandaland a quality driven, beautifully crafted, fun and engaging film.
                For Pandaland to succeed it will need to appeal to a wide audience.
                It all starts at the script.
            </p>
            <p class="gray indent0">
                We are very much looking forward to partner up with Jenny, John and team to create an emotionally engag
                ing story with a narrative drive that delivers beyond the question whether the Pandas will survive.
            </p>
            <p class="gray indent0">
                We are excited to bring additional ideas and story arcs to the table to deliver on a fun and clever script that
                appeals to both kids and adults alike.
            </p>
            <p class="gray indent0">
                Storyboarding and pre-visualisation will further assist to establish a multi-layered film through considered
                visual direction - this is where Cirkus will optimise the budget.
            </p>

        </div>
    </div>
    <div class="detail-info detail-info-one ">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart mt20">
                <h2>《PandaLand》项目内容</h2>
            </div>
            <div class="leftinfo-mpart">
                <p class="leftinfo-mpart-category-new">
                    <i class="ds-icon-16 ds-icon-entertime"></i>
                    项目入驻时间：<?= date('Y-m-d', $project['created_at'])?>
                </p>
                <p class="leftinfo-mpart-desc">
                    《PandaLand》讲述了熊猫家族在一位叫巴斯的熊猫带领
                    下面对世界浩劫的故事。
                </p>
            </div>

        </div>
        <div class="detail-rightpart">
            <div class="lazy-box " style="width:737px; height:1000px; ">
                <img data-original="/images/16/4.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
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
                    国内外奥斯卡大片班底
                </p>
                <p class="leftinfo-mpart-desc">
                    Cirkus’ artists are well versed in multi-tasking, en-
                    suring they see different perspectives in problem
                    solving. Their expertise lies in making a visual eye-
                    catching and out of the ordinary.
                </p>
            </div>

        </div>
        <div class="detail-rightpart">
            <p class="blue fs16 indent0 fwb underline">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                CHRISTIAN GREET
            </p>
            <p class="indent0 fwb">DIRECTOR</p>
            <p class="indent0">
                Juggler Christian Greet is one of the leading award winning Animation Directors at Cirkus.
            </p>
            <ul class="detail-images-float-20">
                <li>
                    <div class="lazy-box mt20" style="width:168px; height:100px; ">
                        <img data-original="/images/16/5.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box mt20" style="width:168px; height:100px; float:left">
                        <img data-original="/images/16/6.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box mt20" style="width:168px; height:100px;">
                        <img data-original="/images/16/7.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box mt20" style="width:168px; height:100px;">
                        <img data-original="/images/16/8.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
            </ul>

            <p class="blue fs16 indent0 fwb underline mt55">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                DAVID SCOTT
            </p>
            <p class="indent0 fwb">
                DIRECTOR/LEAD PREVIS DIRECTOR
            </p>
            <p class="indent0">
                Over the past 17 years David has worked across a number of digital disciplines, from directing
                animated children’s television to Lensing Zack Snyder’s animated feature ‘Legend of the Guardians: The
                Owls of Ga’Hoole’.
            </p>
            <ul class="detail-images-float-20">
                <li>
                    <div class="lazy-box mt20" style="width:168px; height:100px; ">
                        <img data-original="/images/16/9.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box mt20" style="width:168px; height:100px; float:left">
                        <img data-original="/images/16/10.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box mt20" style="width:168px; height:100px;">
                        <img data-original="/images/16/11.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box mt20" style="width:168px; height:100px;">
                        <img data-original="/images/16/12.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
            </ul>

            <p class="blue fs16 indent0 fwb underline mt55">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                JAMES CUNNINGHAM
            </p>
            <p class="indent0 fwb">
                CO-DIRECTOR
            </p>
            <p class="indent0">
                James’ long and successful career in animation has seen him directing and supervising 11 Visual Effects or
                Animation driven short films.
            </p>
            <ul class="detail-images-float-20">
                <li>
                    <div class="lazy-box mt20" style="width:168px; height:100px; ">
                        <img data-original="/images/16/13.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box mt20" style="width:168px; height:100px;">
                        <img data-original="/images/16/14.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
                <li >
                    <div class="lazy-box mt20" style="width:168px; height:100px;">
                        <img data-original="/images/16/15.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box mt20" style="width:168px; height:100px;">
                        <img data-original="/images/16/17.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
            </ul>
            <br class="clear">

            <p class="blue fs16 indent0 fwb underline mt55">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                MARKO KLIJN
            </p>
            <p class="indent0 fwb">
                EXECUTIVE PRODUCER
            </p>
            <p class="indent0">
                Marko Klijn has been active in the animation industry for 17 years, and since 2006, he has been the
                Ringmaster of Cirkus.
            </p>
            <ul class="detail-images-float-20">
                <li>
                    <div class="lazy-box mt20" style="width:168px; height:100px; ">
                        <img data-original="/images/16/18.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box mt20" style="width:168px; height:100px; float:left">
                        <img data-original="/images/16/19.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box mt20" style="width:168px; height:100px;">
                        <img data-original="/images/16/20.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box mt20" style="width:168px; height:100px;">
                        <img data-original="/images/16/21.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
            </ul>

            <p class="blue fs16 indent0 fwb underline mt55">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                CHRISSY METGE
            </p>
            <p class="indent0 fwb">
                PRODUCER
            </p>
            <p class="indent0">
                Chrissy has always known what she wanted to do in life and that was to work with animation. She
                was always seen to be either reading it or watching it so she pursued it!
            </p>
            <ul>
                <li style="float:left; margin-right:20px;">
                    <div class="lazy-box mt20" style="width:168px; height:100px; ">
                        <img data-original="/images/16/22.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
                <li style="float:left; margin-right:20px;">
                    <div class="lazy-box mt20" style="width:168px; height:100px; float:left">
                        <img data-original="/images/16/23.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
                <li style="float:left; margin-right:20px;">
                    <div class="lazy-box mt20" style="width:168px; height:100px;">
                        <img data-original="/images/16/24.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
                <li style="float:left;">
                    <div class="lazy-box mt20" style="width:168px; height:100px;">
                        <img data-original="/images/16/25.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
            </ul>
            <br class="clear">


        </div>
    </div>
    <div class="detail-info detail-info-two pb120">
        <div class="detail-leftpart">
            <div class="leftinfo-tpart">
                <h2>《PandaLand》项目展示</h2>
            </div>
        </div>
        <div class="detail-bannerpart new-m-castlist slideBox">
            <a class="detail-bannerpart-prev" href="javascript:void(0)"></a>
            <ul class="less">
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/16/slide01.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/16/slide02.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/16/slide03.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/16/slide04.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/16/slide05.jpg" alt="<?= $project['proj_name'] ?>" />
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
        $(".detail-info-two .slideBox").slide({
            mainCell:"ul",
            vis: 4,
            autoPlay: false,
            prevCell: ".detail-bannerpart-prev",
            nextCell: ".detail-bannerpart-next",
            effect: "leftLoop"
        });

        $(".rightinfo-groupmember.num5").mCustomScrollbar({
            scrollButtons:{
                scrollSpeed:50
            },
            axis:"y"
        });
    });
</script>

<?php require_once(Yii::getAlias('@frontend') . '/web/layout/footer.php') ?>
</body>
</html>