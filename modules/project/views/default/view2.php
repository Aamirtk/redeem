<?php
use frontend\modules\project\models\ProjMember;
$id = yii::$app->request->get('id');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>《<?= $project['proj_name'] ?>》项目专区-创客空间-蓝海创意云</title>
    <meta name="keywords" content="《朋友大金》项目, 插画,《朋友大金》团队介绍"/>
    <meta name="description" content="朋友大金,你就想一颗药,治愈所有的伤痛.我渴望把蛋液的插画变成绘本.朋友大金团队介绍,vera本名王威,喜欢把心底里埋藏的情感画出来.除了大金,还喜欢画带狐狸面具的少女."/>
    <meta name="renderer" content="webkit"/>
    <meta name="baidu-site-verification" content="NpzvG27pvo" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <link rel="stylesheet" type="text/css" href="http://account.vsochina.com/static/css/login/common.css?v=20150831"   />
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
                <span>你就像一颗药</span>
                <span>治愈所有的伤痛</span>
            </p>
        </div>
        <dl class="detail-producer fr">
            <dt class="fl">
                <?php if (isset($project['user']['avatar']) && !empty($project['user']['avatar'])): ?>
                <a class="detail-portrait-50 nolink">
                    <img src="<?= $project['user']['avatar'] ?>" alt="<?php if (isset($project['user']['nickname'])): ?><?= $project['user']['nickname'] ?><?php endif;?>" />
                </a>
                <?php endif;?>
            </dt>
            <dd class="detail-producer-name"><?= $project['user']['nickname'] ?></dd>
            <dd class="detail-producer-desc">
                <span class="detail-first"><?= $project['user']['tag'] ?></span>
            </dd>
        </dl>
        <div class="detail-graphic">
            <img src="/images/2/banner-pro1.jpg" alt="<?= $project['proj_name'] ?>" width="1200" height="450"/>
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
                    她就是我的一颗药。什么事儿都找她，她给我很多正能量。我渴望把单页的插画变成绘本，从绘本变成动态的短片，还能把这个形象变成实物。大金不仅仅可以陪伴我，也可以陪伴每一个人在偌大的城市里继续奋斗下去！
                </p>
                <p class="leftinfo-mpart-category">
                    <span>项目类型</span>
                    <span>-</span>
                    <span class="category-content">插画</span>
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
            <p class="indent0">
                2012年10月底，我在猫空的工作刚转正，就在那段时间，我认识了一个工作上的同事，那时候我不知道她叫什么，但是我很喜欢她这样的同事，会给周围的人带去很多欢乐。11月1号的时候，我用她的形象画了一张小画。后来，我们接触的多了，了解的多了，就成了好朋友。怎么说呢，她就是我的一颗药。什么事儿都找她，她给我很多正能量。通过了解的加深，我逐渐将她的形象丰满起来，并且这个形象就用她的名字——大金命名。当然，这个形象不仅仅是画她，更多的时候也是借她的“口”来表达自己的想法。即便我画其他的稿子，也带有她的影子。这个形象我会一直画下去，我渴望把单页的插画变成绘本，从绘本变成动态的短片，还能把这个形象变成实物。大金不仅仅可以陪伴我，也可以陪伴每一个人在偌大的城市里继续奋斗下去！
            </p>
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
                <div class="leftinfo-mpart-operate">
                    <?php if (!ProjMember::isProjMember($id)) :?>
                    <!--<a href="javascript:void(0);" class="yellow-btn apply-enter w125">申请加入团队</a>-->
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="detail-rightpart">
            <p class="indent0">
                Vera本名王威，取Vera这个名字完全不是为了洋气，而是简单好记。我也并不知道Vera的正确读法，但是有一天一个朋友跟我说这个单词在意大利语里是真的真实的意思。我觉得这个意思倒是我很喜欢的。作为一个80后，我是很多独生子女之中的一个，虽然表面上大大咧咧但是内心还是很敏感和感性的。我喜欢把心底里埋藏的情感画出来。除了大金，还喜欢画带狐狸面具的少女。
            </p>
            <ul class="rightinfo-groupmember mt35 num4">
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
                            <img src="/images/2/slide01.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide02.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide03.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide04.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide05.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide06.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide07.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide08.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide09.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide10.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide11.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide12.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide13.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide14.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide15.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide16.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide17.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide18.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide19.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide20.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide21.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide22.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide23.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide24.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide25.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide26.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide27.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide28.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide29.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide30.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide31.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide32.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide33.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide34.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide35.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide36.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide37.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide38.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide39.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide40.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/2/slide41.jpg" alt="<?= $project['proj_name'] ?>" />
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
            <p class="indent0">
                每个原创作者都需要一个展示自己的平台，当然也希望能通过自己的努力实现自己的梦想。通过创客空间这个平台我可以让很多的人见到我的作品，并且通过作品认识我，甚至，我更能通过这个平台实现我我做绘本做短片的愿望。每个想要实现梦想的人都会乐意在这个平台上展示自我，实现自我。
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
                    做这个系列最早就是处于对动漫的爱好，觉得要创造几个好玩、好看的动漫形象。毕业后，我一直从事动漫行业，我深深喜爱这个行业，在工作中我找到了无穷的乐趣，每天都可以和自己喜爱的卡通形象生活在一起。但是，我还是觉得缺少了点什么，我更想亲手让自己创作出来的形象更有生命力，可以更有灵性，那就只有自己做了，所以我决定创业做自己喜欢的卡通形象。尽管我一直在从事这个行业，也比较了解这个行业，可是我还是太年轻，缺乏管理经验，我担心自己缺乏驾驭团队的能力，不过我相信创意云平台也会给我创业指导的。另外，我也担心我设计的动漫形象不会被动漫迷们接受，那接下来的我计划开发的动漫衍生品能不能打开市场也会有问题，但是我相信我自己，我再创作这个系列形象的时候，也给很多身边的朋友看过，他们也都非常喜欢这些形象，所以啊，我相信，只要我用心设计这些形象，给与他们血与肉，微笑和哭泣，就一定可以吸引动漫们迷们。最后，如果我创业了，我就要全职去设计和开发动漫形象，没有资金的支持，我的项目就有可能进行不下去。所以，我要参加创意云这个百万大赛，争取获得好名次，可以拿到投资。
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
                        我很喜欢你的形象，我可以加入你的团队吗？
                    </a>
                </dt>
                <dd>
                    <p class="indent0">
                        如果你有市场灵感、能帮助我把这个形象推广出去，我很欢迎你加入我的团队。
                    </p>
                </dd>
                <dt>
                    <a href="javascript:void(0);">我可以代理开发你的动漫形象衍生品吗？</a>
                </dt>
                <dd>
                    <p class="indent0">
                        我现在希望自己开发动漫衍生品，如果您在当地有渠道，可以代理销售我的动漫衍生品。
                    </p>
                </dd>
                <dt>
                    <a href="javascript:void(0);">你可以按照我的样子设计动漫人物吗？</a>
                </dt>
                <dd>
                    <p class="indent0">
                        不好意思，我有我心目中的动漫形象，如果你真的愿意出现在我的动漫片里，我可以给你设计一个好玩的配角形象，不过也许是打酱油的哦。
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
<!--/detail-content-->
<input type="hidden" name="hidden_proj_id" value="<?= $id;?>" >
<script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>
<script type="text/javascript" src="/js/jquery.placeholder.min.js"></script>

<script type="text/javascript" src="/js/dreamSpace.js"></script>
<script type="text/javascript" src="/js/project_action.js"></script>
<script type="text/javascript" src="/js/project_detail.js"></script>
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/footer.php') ?>
</body>
</html>