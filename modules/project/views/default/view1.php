<?php
use frontend\modules\project\models\ProjMember;
$id = yii::$app->request->get('id');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>《<?= $project['proj_name'] ?>》SKATER BOY项目专区-创客空间-蓝海创意云</title>
    <meta name="keywords" content="《滑板少年》,SKATER BOY,滑板少年团队介绍"/>
    <meta name="description" content="光怪陆离的机械世界,追逐梦想的滑板少年.滑板少年项目为三维动画短片.滑板少年团队介绍,主创为三名在广州美术学院的在校大学生,专业为数码娱乐,热爱动漫热爱游戏."/>
    <meta name="renderer" content="webkit"/>
    <meta name="baidu-site-verification" content="NpzvG27pvo"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <link rel="stylesheet" type="text/css" href="http://account.vsochina.com/static/css/login/common.css?v=20150831"/>
    <link rel="stylesheet" type="text/css" href="/css/dreamSpace.css"/>
    <link rel="stylesheet" type="text/css" href="/css/detail.css" />

    <script language="javascript" type="text/javascript" charset="utf-8" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
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
                <span>光怪陆离的机械世界，追逐梦想的滑板少年</span>
            </p>
        </div>
        <dl class="detail-producer fr">
            <dt class="fl">
                <?php if (isset($project['user']['avatar']) && !empty($project['user']['avatar'])): ?>
                <a href="<?= yii::$app->params['user_center_url'] ?><?= $project['username']?>.html" target="_blank" class="detail-portrait-50">
                    <img src="<?= $project['user']['avatar'] ?>" alt="<?= $project['user']['nickname'] ?>" />
                </a>
                <?php endif;?>
            </dt>
            <dd class="detail-producer-name"><?= $project['user']['nickname'] ?></dd>
            <dd class="detail-producer-desc">
                <span class="detail-first"><?= $project['user']['tag'] ?></span>
            </dd>
        </dl>
        <div class="detail-graphic">
            <img src="/images/1/banner-pro2.jpg" alt="<?= $project['proj_name'] ?>" width="1200" height="450"/>
        </div>
    </div>
    <!--/detail-banner-->

    <!--detail-info-->
    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》项目简介</h2>
                <p class="leftinfo-tpart-subhead entertime">项目入驻时间：<?= date('Y-m-d', $project['created_at'])?></p>
            </div>
            <div class="leftinfo-mpart">
                <p class="leftinfo-mpart-desc">
                    本片为三维动画短片，故事设定在一个机器横行的世界里，机器人就像是人类一样为生计、金钱而疲于奔命。主创为三名在校大学生，角色设计曾获得“大学生原创毕业作品大赛二等奖”。
                </p>
                <p class="leftinfo-mpart-category">
                    <span>项目类型</span>
                    <span>-</span>
                    <span class="category-content">动画制作</span>
                </p>
                <div class="leftinfo-mpart-operate">
                    <ul class="operate-support-box">
                        <li class="fl support-num">
                            <p class="support-firstline">
                                <span id="support_pno" class="favor_num_<?= $project['proj_id'] ?>"><?= $project['fans_num'] ?></span>人
                            </p>
                            <p class="support-secondline">关注</p>
                        </li>
                        <li class="fl support-percentage">
                            <p class="support-firstline">
                                <span>进行中</span>
                            </p>
                            <p class="support-secondline">项目进度</p>
                        </li>
                    </ul>
                    <?php if ($project['user']['favor_status']):?>
                        <a href="javascript:void(0);" class="yellow-btn w120 focused" name="project_<?= $project['proj_id']?>" value="<?= $project['proj_id']?>" onclick="remove_favor_project(this)">已关注</a>
                    <?php else:?>
                        <a href="javascript:void(0);" class="yellow-btn w120" name="project_<?= $project['proj_id']?>" value="<?= $project['proj_id']?>" onclick="favor_project(this)">关注</a>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <div class="detail-rightpart">
            <div class="detail-rightpart-images mb55">
                <img src="/images/1/detail-img1.jpg" alt="<?= $project['proj_name'] ?>" />
            </div>
            <p>
                <?=$project['proj_short_desc']?>
            </p>
            <div class="detail-rightpart-images mt35 mb55">
                <img src="/images/1/detail-img2.jpg" alt="<?= $project['proj_name'] ?>" />
            </div>
            <p class="mt35">
                KEN（肯），主人公，就出生在一个这样的世界里，他是由机器人父母罗曼和爱丽丝打工攒钱买回来的零件组装起来的机器人。他们虽然不富有，但是家庭和睦，过得十分融洽。日子一天天过去，当肯渐渐长大后，他学习东西的欲望越来越强烈。他最想在自己喜欢的滑板上有所建树，也想通过自己的努力，让家里人过上好的生活。于是他决定到“机器人城”去拜访他崇拜的偶像——罗德学滑板。罗德是城中滑板的元老和记录的保持者，他创下的几个记录至今无法打破，他也被认为是近代最优秀的滑板选手之一，他的故事深深的影响    着一代代年轻的滑板者。肯希望在他的门下修炼，以便变得更强，于是他开始了他的拜师之路。
            </p>
            <p class="mt35">
                “机器人城”离肯所生活的圣安蒂斯小镇很远，肯在准备好行李后，一个人踏上去“机器人城”的路。在途中，肯遇到有很多像他一样喜欢滑板的少年，在他们当地的滑板比赛肯都不会错过，随着参加的比赛越来越多，肯慢慢结识几个伙伴SANDY,MARCO,ROBEN，他们组成一支团队，一向着罗德家前行，就这样，热血的肯，开始了他与“滑板王”的冒险奇缘。
            </p>
            <div class="detail-rightpart-roles">
                <div class="detail-rightpart-images mt55">
                    <img src="/images/1/detail-img3.jpg" alt="<?= $project['proj_name'] ?>" />
                </div>
                <div class="roles-box">
                    <div class="roles-info">
                        <p class="pink">姓名：肯 / KEN</p>
                        <p class="pink">象征符号：执着</p>
                        <p><span class="pink">个性描述：</span>美味的食物和滑板梦——这就是肯生活的全部。他心目中的偶像是滑板王罗德。滑板零等级，竟然成了万众瞩目的“滑板高手”。热血的肯，开始了他与“滑板王”的冒险奇缘</p>
                    </div>
                    <div class="roles-img">
                        <img src="/images/1/roles-ken.jpg" alt="<?= $project['proj_name'] ?>" />
                    </div>
                </div>
            </div>
            <div class="detail-rightpart-roles">
                <div class="detail-rightpart-images">
                    <img src="/images/1/detail-img4.jpg" alt="<?= $project['proj_name'] ?>" />
                </div>
                <div class="roles-box">
                    <div class="roles-info">
                        <p class="pink">姓名：山迪 / SANDY</p>
                        <p class="pink">象征符号：机智</p>
                        <p><span class="pink">个性描述：</span>4人中身形最娇小的一个，但学东西非常快，后退很有劲。最反感别人说他个子小，对马可的潜力半信半疑。</p>
                    </div>
                    <div class="roles-img">
                        <img src="/images/1/roles-sandy.jpg" alt="<?= $project['proj_name'] ?>" />
                    </div>
                </div>
            </div>
            <div class="detail-rightpart-roles">
                <div class="detail-rightpart-images">
                    <img src="/images/1/detail-img5.jpg" alt="<?= $project['proj_name'] ?>" />
                </div>
                <div class="roles-box">
                    <div class="roles-info">
                        <p class="pink">姓名：马可 / MARCO</p>
                        <p class="pink">象征符号：威武</p>
                        <p><span class="pink">个性描述：</span>不爱说话，最爱和山迪一起比赛。身手灵活，强壮有力，心里很不服气肯成了“滑板少年组冠军”。霸气十足的马克，最爱吃杏仁饼干。</p>
                    </div>
                    <div class="roles-img">
                        <img src="/images/1/roles-marco.jpg" alt="<?= $project['proj_name'] ?>" />
                    </div>
                </div>
            </div>
            <div class="detail-rightpart-roles">
                <div class="detail-rightpart-images">
                    <img src="/images/1/detail-img6.jpg" alt="<?= $project['proj_name'] ?>" />
                </div>
                <div class="roles-box">
                    <div class="roles-info">
                        <p class="pink">姓名：罗宾 / ROBIN</p>
                        <p class="pink">象征符号：优雅</p>
                        <p><span class="pink">个性描述：</span>拥有两条无比轻巧的长腿，个性优雅自信。虽然不太合群，却一直和四位伙伴同甘共苦。</p>
                    </div>
                    <div class="roles-img">
                        <img src="/images/1/roles-robin.jpg" alt="<?= $project['proj_name'] ?>" />
                    </div>
                </div>
            </div>
            <div class="detail-rightpart-images mt35">
                <img src="/images/1/detail-img7.jpg" alt="<?= $project['proj_name'] ?>" />
            </div>
        </div>
    </div>

    <?php if (!empty($project['member_list'])):?>
    <?php $count_member = count($project['member_list']);?>
    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》团队介绍</h2>
                <p class="leftinfo-tpart-subhead groupnum">团队人数：<span><?= $count_member ?></span>人</p>
            </div>
            <div class="leftinfo-mpart">
                <p class="leftinfo-mpart-desc">
                    本片主创为<?= $count_member ?>名在广州美术学院的在校大学生，专业为数码娱乐。
                </p>
                <div class="leftinfo-mpart-operate">
                    <?php if (!ProjMember::isProjMember($id)) :?>
                    <!--<a href="javascript:void(0);" class="yellow-btn apply-enter w125">申请加入团队</a>-->
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="detail-rightpart">
            <p>
                 这个团队只有<?= $count_member ?>个人，我们是同班同学，团队建立1年，这个滑板男孩是我们的第一次合作，这次假期，<?= $count_member ?>人皆在网易实习游戏动画。热爱动画，热爱游戏，关注中国元素是我们<?= $count_member ?>个的基本特点。
            </p>
            <ul class="rightinfo-groupmember mt35 num3">
                <?php foreach ($project['member_list'] as $k => $v): ?>
                    <li>
                        <div>
                            <a href="<?= yii::$app->params['user_center_url'] ?><?= $v['username'] ?>.html" target="_blank" class="detail-portrait-100">
                                <img src="<?= $v['avatar'] ?>" alt="<?= $v['nickname'] ?>" width="64px" height="64px"/>
                            </a>
                        </div>
                        <p class="groupmember-name"><?= $v['nickname'] ?></p>
                        <p class="groupmember-role"><?= $v['tag'] ?></p>
                    </li>
                <? endforeach ?>
            </ul>
        </div>
    </div>
    <?php endif;?>

    <div class="detail-info detail-info-two">
        <div class="detail-leftpart">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》项目演示</h2>
            </div>
        </div>
        <div class="detail-bannerpart new-m-castlist slideBox">
            <a class="detail-bannerpart-prev" href="javascript:void(0)"></a>
            <ul>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/1/slide01.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/1/slide02.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/1/slide03.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/1/slide04.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/1/slide05.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/1/slide06.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/1/slide07.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/1/slide08.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/1/slide09.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/1/slide10.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/1/slide11.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/1/slide12.png" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/1/slide13.png" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/1/slide14.bmp" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/1/slide15.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
            </ul>
            <a class="detail-bannerpart-next" href="javascript:void(0)"></a>
        </div>
    </div>

    <div class="detail-info">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2 class="ml0">为什么选择入驻创客空间？</h2>
            </div>
        </div>
        <div class="detail-rightpart">
            <p>
                 一次无意间，老师的推荐让我认识了创意云这个平台，刚好有一个大学生原创活动比赛，后来也陆续关注到该平台其它活动，觉得这里有着一帮和自己一样的人在积极的参加着各种活动，而且平台的活动类型比较全面，没有明确的限制，给了我们一个展示自我的很好平台，偶尔会小忘来登录，客服还是很热情很耐心的通知和沟通，所以总体感觉这里是个值得常来的平台，主办方的诚意，和最创新大赛举办的热衷，让人感觉nice，很舒服。所以选择入驻创空间。
            </p>
        </div>
    </div>

    <div class="detail-riskbg">
        <div class="detail-info">
            <div class="detail-leftpart fl">
                <div class="leftinfo-tpart">
                    <h2>《<?= $project['proj_name'] ?>》项目风险</h2>
                </div>
            </div>
            <div class="detail-rightpart">
                <p class="indent0">
                    1.时间
                </p>
                <p class="indent0">
                    我们是在校学生，目前3人都正在实习中，所以制作时间不一定充足。目前项目进度处在调试材质和调动画的过程中，已完成40%的工作量，因为时间问题所以项目正在推迟进行，但是开学季实习期也差不多结束，我们又可以开始继续做了。
                </p>
                <p class="mt24 indent0">
                    2.资金
                </p>
                <p class="indent0">
                    目前缺乏项目资金，后续制作部分可能遇到资金缺乏带来的相关问题。
                </p>
                <p class="mt24 indent0">
                    3.技术
                </p>
                <p class="indent0">
                    作品是3ds Max做的，也用到了ZBrush。是全三维制作，MV还在调动作。困难很多的，技术上有问题的地方只能一边做一边找教程学。
                </p>
            </div>
        </div>
    </div>

    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》项目答疑解惑</h2>
                <p class="leftinfo-tpart-subhead question">网友问题：<span>3</span>个</p>
            </div>
            <div class="leftinfo-mpart">
                <p class="leftinfo-mpart-desc">
                    阅读其网友提出的问题，帮助自己快速了解更多项目咨询。也欢迎您提出更多的问题，项目团队和创客空间官方客服人员会在第一时间回复问题，尽可能给出令您满意的答案。
                </p>
                <!--
                <div class="leftinfo-mpart-operate">
                    <a href="javascript:void(0);" class="yellow-btn w120 ask-question">我要提问</a>
                </div>
                -->
            </div>
        </div>
        <div class="detail-rightpart">
            <dl class="detail-rightpart-questionlist">
                <dt>
                    <a href="javascript:void(0);">
                        我非常喜欢这个项目，如果我关注这个项目，可以得到什么好处？
                    </a>
                </dt>
                <dd>
                    <p class="indent0">
                        滑板少年的周边如果能够得到关注而可以制作的话，会送给关注我们的朋友。比如主角肯的角色玩偶、毛毡挂饰等等。当然这些也会考虑到大家的喜好程度来投个票。
                    </p>
                </dd>
                <dt>
                    <a href="javascript:void(0);">片子时间是剧情表现会怎样规划？</a>
                </dt>
                <dd>
                    <p class="indent0">
                        基本是MV式的动画短片，利用剪辑和镜头表现和音乐一样的节奏，不会设置辅线剧情，同时实际按照自身情况来看，不打算做太长的片子。这也有制作周期、技术、资金的考虑。
                    </p>
                </dd>
                <dt>
                    <a href="javascript:void(0);">问下主创，这个项目是怎样开始的？</a>
                </dt>
                <dd>
                    <p class="indent0">
                        日常画的题材比较多，机器人算是比较喜欢的。角色来源于课上的作业，后面因为兴趣把他们做成3D的了，然后也想用于做动画。现在主流自己的小组做这个的MV动画。也做了其他全息投影的运用。就其实一个作业设计出来的角色可以用到很多地方。虽然没有太多时间，但是很喜欢这个故事，所以想要去完成它。
                    </p>
                </dd>
            </dl>
        </div>
    </div>

    <!--
    <div class="detail-info">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》项目进度</h2>
            </div>
        </div>
        <div class="detail-rightpart">
            <div class="leftinfo-mpart-operate">
                <a href="javascript:void(0);" class="yellow-btn w120">查看进度</a>
            </div>
        </div>
    </div>
    -->

    <!--detail-info-->
</div>
<input type="hidden" name="hidden_proj_id" value="<?= $id;?>" >
<!--/detail-content-->

<script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>
<script type="text/javascript" src="/js/jquery.placeholder.min.js"></script>

<script type="text/javascript" src="/js/dreamSpace.js"></script>
<script type="text/javascript" src="/js/project_action.js"></script>
<script type="text/javascript" src="/js/project_detail.js"></script>
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/footer.php') ?>
</body>
</html>