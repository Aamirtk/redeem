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
                <span>安逸放纵的生活VS永无止境的抗争</span>
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
            <img src="/images/15/1.jpg" alt="<?= $project['proj_name'] ?>" />
        </div>
    </div>
    <!--/detail-banner-->

    <!--detail-info-->
    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《酥脆21g》项目概述</h2>
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
                    <span class="category-content">中美合拍动作科幻长片</span>
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

                未来世界强大而神秘的VOR组织应运而生人类社会因此改变前进轨道我们是否更快乐
            </p>
            <p class="indent1 mt35">
                当下的社会科技突飞猛进，人们对科技的依赖越来越大，人与人之间的情感反而越发麻木。
            </p>
            <p class="indent1">
                就此现状，本片将时间设置在未来，意在将科技高度发达后的社会现状用一种相对极端的方式展示出来，从而将
                人与科技的关系模拟的设置在一个对立且激化的矛盾上。
            </p>
            <p class="indent1">
                在宗教被科技所替代的时代，科技用一种简单粗暴的方式强制的将人类的痛苦记忆删除，美其名曰：为了人类的
                健康，宗教在丧失了为人类规避痛苦着一“职能”以后渐渐的被科技所“取代”。与此同时，科技并不阻止大多数哲学的进步和传播，因为哲学
                在多数时候在帮助人们寻找痛苦的出处，然而在科学因为具备了为人类“解决”痛苦的能力之后，自然不与哲学相抵触。
            </p>
            <p class="indent1">在此，本片意在讨论痛苦对于人的意义。在人们真的可以“删除”痛苦的时候我们是否真的要删除他们。</p>
            <p class="blue fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                导演/编剧：伏龙    项目策划：赵雪薇
            </p>
        </div>
    </div>
    <div class="detail-info detail-info-one ">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《酥脆21g》项目内容</h2>
                <p class="leftinfo-tpart-subhead entertime">项目入驻时间：<?= date('Y-m-d', $project['created_at'])?></p>
            </div>
        </div>
        <div class="detail-rightpart">
            <p class="indent1">
                2097年，科技高度发达，世界变得颓靡，阴郁。一个名叫VOR的组织诞生了……VOR设计并研发了记忆体验仪，
                记忆体验仪可以使佩戴者随时删除和重置记忆，为了达到控制全人类的目的，他们声称记忆体验仪能够帮助人类清除痛
                苦记忆，提高生活质量。在谎言的伪装下，VOR蛊惑和强制全人类安装记忆体验仪。计算机在VOR的操控下，代替人
                脑作出判断，胁迫甚至强制人类作出所谓“最合理”的选择。电脑主宰了人脑。一群向往平等与自由的人们在社会学家
                戈多的领导下，组成地下抵抗组织，他们拆除了记忆体验仪，却遭到VOR的残忍屠杀……

                一场人类与VOR的对抗由此拉开帷幕……
            </p>
            <p class="indent1">
                吴一本是一个基因定制婴儿，他有着拳击手与艺术家的优良基因，在孤儿院的残忍监禁下长大。后来，吴一邂逅了
                戈多的女儿旺达，两人相爱。吴一也成为了“叛逃者”的一员，很受戈多器重。旺达怀孕。一次吴一和旺达二人驱车外
                出的路上，遭遇VOR警察，为了保护旺达的安全，吴一被捕。VOR将吴一的记忆全部删除，并将其改造成专门抓捕“叛
                逃者”的机械战警！
            </p>
            <p class="indent1">
                警察与“叛逃者”，截然对立的身份，使吴一和旺达这对眷侣似乎永远没有相认的可能……与此同时，VOR秘密决
                定在2100年删除人类此前的所有记忆，从而开启人类的“新纪元”。
            </p>
            <p class="indent1">
                一场人类与VOR的对抗由此拉开帷幕……
            </p>

            <p class="blue fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                世界观构建
            </p>
            <p class="indent0">
                距今大约100年后，人类生存在一个科技高度发达的时代里，计算机渐渐具备了近乎人脑的思维能力。依靠科技的进步，
                一个名叫VOU的组织应运而生，为达到控制全人类的目的。他们设计并研发记忆体验仪，声称记忆体验仪可以帮助佩
                戴者随时删除和重置记忆，能够帮助人类改善痛苦记忆。在谎言的伪装下，VOU强制全人类安装记忆体验仪。计算机
                在VOU的操控下，代替人类作出判断，胁迫甚至强制人类作出所谓“最合理”的选择。电脑主宰了人脑。
            </p>
            <p class="indent0">
                向往自由的人们团结起来形成地下抵抗组织，却遭到VOU的残忍屠杀，原本平静的世界变得颓废，绝望和疯狂。人类
                开始丧失信仰，丧失对记忆的自主管控能力，进而丧失了人情，甚至是人性。
                与此同时VOU秘密决定在2100年删除人类此前的所有的记忆，从而开启人类的“新纪元”。
                一场人类与VOU的对抗由此拉开帷幕。
            </p>
            <p class="blue fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                影片参考
            </p>
            <ul>
                <li style="float:left; margin-right:27px;">
                    <div class="lazy-box mt20" style="width:180px; height:265px; ">
                        <img data-original="/images/15/2.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
                <li style="float:left; margin-right:27px;">
                    <div class="lazy-box mt20" style="width:180px; height:265px; float:left">
                        <img data-original="/images/15/3.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
                <li style="float:left; marigin-right:150px;">
                    <div class="lazy-box mt20" style="width:180px; height:265px;">
                        <img data-original="/images/15/4.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                    </div>
                </li>
            </ul>
            <br class="clear">
            <p class="blue fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                人物简介/形象参考
            </p>
            <p class="blue indent0 mt20">
                吴一：
            </p>
            <p class="indent0">
                三十岁左右。略显老成， 独立且自信，性格坚毅人格独立，心思敏感重感情，抗拒VOU对人类的独裁控制，为捍卫独
                立自主思维权利做斗争。（克里夫·欧文）
            </p>
            <p class="blue indent0 mt20">
                旺达：
            </p>
            <p class="indent0 mt20">
                26岁左右，射手座，极有魅力，平静的举手投足之中透露出优雅的贵族气质，出身书香门第，被长辈寄予厚望。骨子里
                对自由强烈向往，具有良好的文化底蕴。这让她即具备反叛社会的理论基础又有十足的勇气。（娜塔莉·波特曼）
            </p>
            <p class="blue indent0 mt20">
                牧师：
            </p>
            <p class="indent0">
                50岁左右。沉稳冷静，拥有及其深厚的文化背景，曾因其宗教身份遭到
                VOU的严重迫害，最终在宗教丧失意义的社会环境下，教堂成为最初的地下组
                织的批护所，渐渐成为地下抵抗组织的领袖。（摩根·弗里曼）
            </p>
            <p class="indent0">
                VOU总裁史密斯：
            </p>
            <p class="indent0">
                优雅的混蛋
            </p>
            <p class="blue indent0 mt20">
                萨拉：
            </p>
            <p class="indent0">
                4岁，天真可爱，古灵精怪的小姑娘
            </p>

        </div>
    </div>
    <div class="detail-info detail-info-two pb120">
        <div class="detail-leftpart">
            <div class="leftinfo-tpart">
                <h2>《酥脆21g》视觉展示</h2>
            </div>
        </div>
        <div class="detail-bannerpart new-m-castlist slideBox">
            <a class="detail-bannerpart-prev" href="javascript:void(0)"></a>
            <ul class="less">
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/15/slide01.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/15/slide02.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/15/slide03.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/15/slide04.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/15/slide05.jpg" alt="<?= $project['proj_name'] ?>" />
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
    });
</script>



<?php require_once(Yii::getAlias('@frontend') . '/web/layout/footer.php') ?>
</body>
</html>