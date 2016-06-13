<?php
$id = yii::$app->request->get('id');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>山君</title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="renderer" content="webkit"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <link rel="stylesheet" type="text/css" href="http://account.vsochina.com/static/css/login/common.css?v=20150831"   />
     <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/jplayer/2.9.1/skin/blue.monday/jplayer.blue.monday.css" />

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
            <h1>山君</h1>
            <p>
                <span>山魅魍魉不离散，笔墨染笺为君颜。</span>
            </p>
        </div>
        <dl class="detail-producer fr">
            <dt class="fl">
                <a href="<?= yii::$app->params['user_center_url'] ?>19351081.html" target="_blank" class="detail-portrait-50">
                    <img src="/images/20/portrait1.jpg" alt="音马yata" />
                </a>
            </dt>
            <dd class="detail-producer-name">音马yata</dd>
            <dd class="detail-producer-desc">
                <span class="detail-first">漫画 | 动画</span>
            </dd>
        </dl>
        <div class="detail-graphic">
            <img src="/images/20/banner-pro1.jpg" alt="山君"  />
        </div>
    </div>
    <!--/detail-banner-->

    <!--detail-info-->
    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《山君》项目简介</h2>
                <p class="leftinfo-tpart-subhead entertime">项目入驻时间：2015-10-20</p>
            </div>
            <div class="leftinfo-mpart">
                <p class="leftinfo-mpart-desc">
                    原创漫画《山君》由音马yata单人绘制，目前项目处于初步开篇连载中。是一部记录山中妖怪与人类的故事的漫画。画风娟丽干净，设定独特有趣，故事线各自起伏交织，但叙事十分清晰。
                </p>
                <p class="leftinfo-mpart-category">
                    <!--<i class="ds-icon-16 ds-icon-block-1"></i>-->
                    <span>项目类型</span>
                    <span>-</span>
                    <span class="category-content">漫画连载</span>
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
            <div class="detail-rightpart-images">
                <div class="lazy-box" style="width:750px;height: 82px;">
                    <img data-original="/images/20/detail-img1.png" alt="山君" class="lazy" />
                </div>
            </div>
            <p class="mt55">
                很久年代的山上森林里，各种妖怪山魅生存，人类与之发生着种种故事。而主角是旁观这一切，似乎不是人也不算妖怪的戴着面具的神秘人，他观察着万物，兴衰生死，日复一日。妖怪和人的种种也在他的观察范围，却是个不会过分干预的角色。狩猎少年，砍柴樵夫，山林少女，各色人群的故事，沼泽之神，山中鬼魅，乃至一草一叶幻化的神怪…各种妖怪也有自己的故事。自称是山君的神秘人究竟是谁，他又有怎样的经历和故事…..
            </p>
            <div class="detail-rightpart-images mt55">
                <div class="lazy-box" style="width:750px;height: 82px;">
                    <img data-original="/images/20/detail-img2.png" alt="山君" class="lazy" />
                </div>
            </div>

            <p class="indent0 fs18 brown fwb mt40">山君肆方</p>
            <p class="indent0">
                主角，常年带一顶面具和斗笠，黑发长袍，总是懒懒散散的不经意出现在各个地方的神秘人物。有点喜欢戏弄他人，记录所看到的故事。对于妖怪了解的很多，喜欢到处游荡，睡觉，对喜欢的事情很热心。
            </p>
            <p class="indent0 fs18 brown fwb mt35">狩猎少年</p>
            <p class="indent0">
                第一话的角色，名叫风莲，外表俊朗但冷漠的少年。狩猎途中无意认识山君，并且被山君发现自己一直饲养并且企图驯化的凶恶神兽。在训练中神兽暴走导致周围村庄出现危险，是一个有野心的有些鲁莽的少年。
            </p>
            <p class="indent0 fs18 brown fwb mt35">黄衣少女</p>
            <p class="indent0">
                第二话角色，叫松若，因为在山中无意发现一个英俊男子并且喜欢上了他，每天远远的偷偷跟着男子上山，一次被山君发现，山君告知少女男子并不是人类，其真正的身份是山中光所幻化的妖怪形象，晚上就会消失。少女有次因为追寻而迷失山间遇到危险，山君便带来半夜月光变幻的光神去救她。
            </p>
            <p class="indent0 fs18 brown fwb mt35">白泽</p>
            <p class="indent0">
                妖怪并且十分睿智聪明，几乎知晓一切事物，性格淡然喜欢独处。个性温柔谦逊，和山君是朋友。
            </p>
            <p class="indent0 fs18 brown fwb mt35">嘲风燕君</p>
            <p class="indent0">
                燕君是龙之子嘲风，是家宅神兽，一直忠心耿耿保护镇宅，忠心并且性格坚毅。主人的村里发生严重饥荒举家搬迁，留下了孤单的宅神燕君。燕君变得迷茫无助时候遇到了山君肆方…
            </p>
            <p class="indent0 fs18 brown fwb mt35">沼神</p>
            <p class="indent0">
                沼泽地里的妖怪，毒舌并且不喜欢任何人的打扰，喜欢捉弄迷路的行人。
            </p>
            <p class="indent0 fs18 brown fwb mt35">庆忌</p>
            <p class="indent0">
                送信的小妖怪。
            </p>
            <p class="indent0 fs18 brown fwb mt35">睚眦骁戈</p>
            <p class="indent0">
                脾气暴躁的龙之子。
            </p>
            <p class="indent0 mt35">
                此外还有许多妖怪，狐仙，龙女，鲛人。
            </p>
        </div>
    </div>

    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《山君》团队介绍</h2>
            </div>
            <div class="leftinfo-mpart">
                <p class="leftinfo-mpart-category-new">
                    <i class="ds-icon-16 ds-icon-member"></i>
                    团队人数：<span>1</span>人
                </p>
                <p class="leftinfo-mpart-desc">
                    西安美院在校学生，单人绘制漫画，目前负责包括剧本、人设、绘制等在内所有的制作工作。
                </p>
            </div>
        </div>

        <div class="detail-rightpart">
            <p class="indent0">
                目前是西安美术学院的在校学生，专业为动画专业，单人绘制《山君》中，负责所有的剧本、人设、线稿、上色等漫画绘制工作。自称是“一个比较怕麻烦但是一直想画画的家伙…”。
            </p>
            <ul class="rightinfo-groupmember mt35 num4">
                <li>
                    <div>
                        <a href="<?= yii::$app->params['user_center_url'] ?>19351081.html" target="_blank" class="detail-portrait-100">
                            <img src="/images/20/portrait1.jpg" alt="音马yata" width="64px" height="64px">
                        </a>
                    </div>
                    <p class="groupmember-name">音马yata</p>
                    <p class="groupmember-role">剧本 | 人设 | 绘制</p>
                </li>
            </ul>
        </div>
    </div>

    <div class="detail-info detail-info-two">
        <div class="detail-leftpart">
            <div class="leftinfo-tpart">
                <h2>《山君》项目展示</h2>
            </div>
        </div>
        <div class="detail-bannerpart new-m-castlist slideBox">
            <a class="detail-bannerpart-prev" href="javascript:void(0)"></a>
            <ul class="less">
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/20/slide01.jpg" alt="山君" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/20/slide02.jpg" alt="山君" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/20/slide03.jpg" alt="山君" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/20/slide04.jpg" alt="山君" />
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
                因之前在创意云参加了情调苏州创意设计&摄影大赛，之后工作人员联系推荐了百万大赛，觉得很有意思。
            </p>
            <p class="indent0">
                我对《山君》准备蛮久，而且很想有这样一部作品。我想的是，全彩的话大家应该更喜欢？同时因为是比赛...所以想更努力些....
            </p>
        </div>
    </div>

    <div class="detail-riskbg">
        <div class="detail-info">
            <div class="detail-leftpart fl">
                <div class="leftinfo-tpart">
                    <h2>《山君》项目风险</h2>
                </div>
            </div>
            <div class="detail-rightpart">
                <p class="indent0">
                    音马yata：风险…就是害怕有拖稿情况= =
                </p>
                <p class="indent0 mt24">
                    1、项目属于初期阶段，为正式开始连载
                </p>
                <p class="indent0">
                    目前项目属于初期，未正式开始连载，正式开始连载后，我一般会订好日期然后按时更新的。会保证日常连载。
                </p>
                <p class="indent0 mt24">
                    2、全彩漫画工作量较大
                </p>
                <p class="indent0">
                    想往更加细致写实努力，画出真的森林感觉，《山君》为全彩漫画，里面有几个相对独立的故事章节，有不同的妖怪和人。
                </p>
            </div>
        </div>
    </div>

    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《山君》项目答疑解惑</h2>
                <p class="leftinfo-tpart-subhead question">网友问题：<span>3</span>个</p>
            </div>
            <div class="leftinfo-mpart">
                <p class="leftinfo-mpart-desc">
                    阅读其网友提出的问题，帮助自己快速了解更多项目咨询。也欢迎您提出更多的问题，项目团队和创梦空间官方客服人员会在第一时间回复问题，尽可能给出令您满意的答案。
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
                        我很喜欢你的作品，可以出周边产品吗？
                    </a>
                </dt>
                <dd>
                    <p class="indent0">
                        很好啊。
                    </p>
                </dd>
                <dt>
                    <a href="javascript:void(0);">支持你的作品，如果以后出版了可以获得什么吗？</a>
                </dt>
                <dd>
                    <p class="indent0">
                        获得什么？获得快乐？
                    </p>
                </dd>
                <dt>
                    <a href="javascript:void(0);">我很喜欢这种风格，可以加入你的团队吗？</a>
                </dt>
                <dd>
                    <p class="indent0">
                        看情况吧，如果你爱好画画并且有能力就加入吧。
                    </p>
                </dd>
            </dl>
        </div>
    </div>
</div>
<!--/detail-content-->



<script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>

<script type="text/javascript" src="http://static.vsochina.com/libs/jplayer/2.9.1/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="/js/jquery.placeholder.min.js"></script>
<script type="text/javascript" src="/js/dreamSpace.js"></script>
<script type="text/javascript" src="/js/project_action.js"></script>
<script type="text/javascript" src="/js/project_detail.js"></script>

<?php require_once(Yii::getAlias('@frontend') . '/web/layout/footer.php') ?>
</body>
</html>