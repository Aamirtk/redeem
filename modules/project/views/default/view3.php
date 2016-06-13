<?php
use frontend\modules\project\models\ProjMember;
$id = yii::$app->request->get('id');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>《<?= $project['proj_name'] ?>》SKATER BOY项目专区-创客空间-蓝海创意云</title>
    <meta name="keywords" content="《黑潮计划》,SKATER BOY,黑潮计划团队介绍"/>
    <meta name="description" content="光怪陆离的机械世界,追逐梦想的黑潮计划.黑潮计划项目为三维动画短片.黑潮计划团队介绍,主创为三名在广州美术学院的在校大学生,专业为数码娱乐,热爱动漫热爱游戏."/>
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
                <span>以黑潮世界观与曼萨纳半岛的传奇故事为背景的卡牌游戏</span>
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
                <span class="detail-first">游戏制作</span>
            </dd>
        </dl>
        <div class="detail-graphic">
            <img src="/images/3/banner-pro1.jpg" alt="<?= $project['proj_name'] ?>" />
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
                    本项目名称《黑潮》网络游戏开发项目，依托全新设计的黑潮世界观与曼萨纳半岛传奇故事进行游戏的开发项目，将公司经营发展成为全国著名的手机游戏生产公司，将企业打造成为拥有自主开发知识产权的民族品牌手游巨鳄。
                </p>
                <p class="leftinfo-mpart-category">
                    <span>项目类型</span>
                    <span>-</span>
                    <span class="category-content">游戏制作</span>
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
            <div class="detail-rightpart-images mb40">
                <img src="/images/3/detail-img1.jpg" alt="<?= $project['proj_name'] ?>" />
            </div>
            <p class="yellow fs18 indent0">
                什么是黑潮计划 Project Blight？
            </p>
            <p class="mt20">
                本项目名称《黑潮》网络游戏开发项目，依托全新设计的黑潮世界观与曼萨纳半岛传奇故事进行游戏的开发项目，将公司经营发展成为全国著名的手机游戏生产公司，将企业打造成为拥有自主开发知识产权的民族品牌手游巨鳄。
            </p>
            <p class="mt20">
                黑潮项目是一个由独立游戏制作者开发并与中国传媒大学苏州研究院，以及“创意云”游戏中心合作推广的一款奇幻战略游戏。除了这个游戏本身以外，黑潮会引入多终端的娱乐理念，不仅仅是开发一款游戏，而是一套完整且全新的游戏制作理念，一个多种媒体和多个游戏组合的娱乐体验。游戏相比市面上较为奇幻战略游戏中的系统进行了大量的创新和努力，游戏的开发中我们引入了媲美西方大型奇幻游戏的世界设定和文学性剧本，这是一般的手机游戏中较为少见的。玩家在和一个个鲜明的角色互动的同时，设计和养成自己的士兵并创建自己的国度并讲述属于自己的史诗。
            </p>
            <p class="mt20">
                最关键的是，黑潮独创性的多终端娱乐理念主要体现在接入大量智能穿戴设备,读入每天运动数据进行人物养成，给玩家带来强烈的代入感。一方面可以拓宽游戏的市场，一方面也可以另游戏对玩家的黏着度进一步上升。此外，这种全新理念符合了最新西方的智能设备标准，给本项目带来了进入西欧北美市场的可能性。
            </p>
            <div class="detail-rightpart-images mt55 mb90">
                <img src="/images/3/detail-img2.jpg" alt="<?= $project['proj_name'] ?>" />
            </div>
            <div class="detail-rightpart-clique empire mb30">
                <p class="indent0 bluebg">
                    雷诺维德帝国作为生命女神的信徒聚集地，对于商贾、旅者亦或星界来客来说，都是曼萨纳半岛上难得的奇迹国度。这片美丽的国度物产优良，道路发达，商业、手工业都相当繁荣。雷诺维德的主要居民，人类，通常被认为是善良友好的居民，勤劳带给他们富足与优越的生活，美好的生活条件使他们对待陌生人更加亲切和友善。虽然从某种意义上来说，经历了三次重大战役，曾经伟大的雷诺维德分崩离析之后，只应该留下惨痛的回忆、纪念碑上密密麻麻死难者的姓名以及山河破碎的家园而已。令人惊讶的是，坚强的雷诺维德人类迅速摆脱了对背叛者的仇恨，迅速的踏上了建设的脚步。如今，雷诺维德一片朝气蓬勃的新气象，粮食富足、商品繁多，一切和战争前没什么分别。如果硬要睁大眼睛，用力寻找的话，大约也只能看到元老会外交处的小心翼翼以及年轻的帝国卫队拿起钢枪，让稚嫩的双手布满老茧了吧。
                </p>
            </div>
            <div class="detail-rightpart-clique order mb30">
                <p class="indent0 redbg">
                    费昂拉赫教团这个以阴影女神卡夏为信仰的教会发源于北方被称作卡夏之辉光的神迹，并在帝国的分裂当中建立了正如其名是以其对秩序的追求而闻名的国度。生活于北方疾苦之地的人们相信，只有在正确的秩序与法律的引导下，才能让更多的人活下去。他们编纂的繁复而又巨细无遗的法律，不仅规范了每一个费昂拉赫子民生活的方方面面，同时也界定了整个国家三权分立的构架：教皇持权杖，象征着皇权与信仰；战争天使持剑，象征着军事与力量；审判长持典，象征着法律与秩序。在这样条理清晰的规则指引下，费昂拉赫的人民虽然在与帝国的独立战争中付出了前所未有的巨大代价，却依然能够紧密的团结在一起，他们相信着在死后，他们的肉身将重返圣湖，灵魂则回归卡夏的怀抱，并在某一日以新的身份重回世间，与教团的兄弟姐妹们一同战斗。
                </p>
            </div>
            <div class="detail-rightpart-clique horde mb30">
                <p class="indent0 yellowbg">
                    斯韦尔德部落建立于曼萨纳之泪的湖畔，坐拥着整个曼萨纳半岛最为丰饶的土地。部落的子民由曾今巴洛利亚王国巨人王国的遗民，世代生活于此的兽人组成，这些享受着曼萨纳神恩的幸运儿们是曼萨纳最虔诚的信徒，借助着他们狂热的信仰与非凡的精神力，一些优秀的兽人甚至能暂时借用曼萨纳的神力用于己身，从而获得强大的能力。虽然在其他势力的眼中，这些无忧无虑的部落兽人不过是粗鲁残暴、原始落后的象征，但其实每一个兽人都有着自己必须遵循的道德与礼仪，他们向往自由因此远离纷争，他们热爱生命因此厌倦杀戮。他们享受着神的恩赐，遵循着神的指引，过着属于自己的乌托邦式的生活，直到曾经的巨人国王挣脱牢狱的消息传来，腥风血雨即将再次席卷曼萨纳半岛，而这次，斯维尔德部落的子民们正位于这黑潮的正中央。
                </p>
            </div>
            <div class="detail-rightpart-images mt90">
                <img src="/images/3/detail-img3.jpg" alt="<?= $project['proj_name'] ?>" />
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
                    本项目为<?= $count_member ?>名青年创造业者策划：项目主创陈浩主，策划珠海格，主工程师郑重。
                </p>
                <div class="leftinfo-mpart-operate">
                    <?php if (!ProjMember::isProjMember($id)) :?>
                    <!--<a href="javascript:void(0);" class="yellow-btn apply-enter w125">申请加入团队</a>-->
                    <?php endif;?>
                </div>
            </div>
        </div>
        <div class="detail-rightpart">
            <p class="indent0">
                黑潮的团队经历过几次变动，和不同的开发时期有关，现在团队才开始逐渐趋于稳定。首先要介绍的是陈浩，一个一直梦想制作游戏的骨灰级的玩家，同样也是团队的核心主创和投资人。整个黑潮的游戏开发理念都是由陈浩提出和把控的，他负责项目的整体方向把控和团队人员的协调沟通工作，确保项目顺利进展。项目的其他成员比如主策划珠海格，主工程师郑重都是游戏行业内的精英，也有丰富的游戏项目开发经验。整个团队还有来自创意云平台的独立策划团队、原画师以及程序员们，他们都以委托开发的形式加入了这个在线团队，所以该团队的在线总人数不亚于30人。
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
            <ul class="less">
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/3/slide01.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/3/slide02.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/3/slide03.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/3/slide04.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/3/slide05.jpg" alt="<?= $project['proj_name'] ?>" />
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
                创意云的各种功能和孵化政策，当然还有创客空间都是吸引我们入住的主要原因。举例来说，我们有大量的美术元件需要进行外包，而很多的外包公司和团体早就在业内组成了一个巨大的生态链条，对于小规模的游戏团体和独立游戏制作者，他们却很难找到适合自己的外包途径，又面临层层转包且混乱不堪的外包市场。而在创客空间，我们的任务需求、开发进度和人才引进都是公开透明的，中间除了创作者之外会没有其他转包方生存的余地，极大的节省了我们的沟通和实际开发成本。
            </p>
            <p class="indent0">
                另外，创客空间也为我们提供了不同类型的资金孵化和与之相对的基于互联网模式的众筹体系。除了较为传统的模式之外，结合开放式的游戏构架，将会鼓励社区用户提议，自己发起游戏内容的众筹从而实现玩家花钱鼓励适合自己的游戏内容的开发。并且通过线上的创客空间也能更方便的让更多的人知道我们的作品，无论是潜在的合作者、投资人还是运营商都可能在项目的早起和中期就加入进来，并和我们一同完善这个项目。
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
                    目前项目的风险主要体现在市场竞争方面。随着行业发展和收入的增加及诱人的发展前景，必定会吸引更多投资者进入本行业，另一方面，产品在进入市场也形成了与已有品牌有效的竞争，这势必会影响到市场拓展的速度和获利的空间。此外， 在项目进入市场初期，其知名度不够，导致在线人数不高，但项目产品有其足够的竞争优势，这就需要我黑潮工作室制定完善的市场拓展方案，综合利用广告、公共关系、促销等多种手段，迅速扩大市场知名度，吸纳会员，使市场进入期尽可能的缩短，从而更快的建立起完善的发展平台，将企业带入良性发展轨道。
                </p>
                <p class="mt24 indent0">
                    目前针对这些风险，主要的相应对策包括：
                </p>
                <p class="indent0">
                    （1）加大宣传力度，提升产品的品牌影响力，确立品牌形象。
                </p>
                <p class="indent0">
                    （2）加强产品设计和服务创新能力，通过整合设计、个案设计，使产品创新领先，服务更细致完善，使企业自身市场
                </p>
                <p class="indent37">
                    中形成独特的竞争力。
                </p>
                <p class="indent0">
                    （3）加强对各项目的运行管理和服务质量，减少因技术不成熟与监管不得力所造成的运行事故率，努力完善各环节降
                </p>
                <p class="indent37">
                    低用户投诉率和使用的逆反心理。
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
                        我立志成为一名美术/策划/程序员，但是经验比较少，不知道能不能加入。
                    </a>
                </dt>
                <dd>
                    <p class="indent0">
                        当然可以，我们十分欢迎任何一个有兴趣的创作者加入进来，并和我们共同成长。你可以通过私信我们的创意云账号，或者是直接通过创客空间的虚拟工作室联系到我们。当然我们目前最期待的是更多的美术人员啦。
                    </p>
                </dd>
                <dt>
                    <a href="javascript:void(0);">通过创意云加入项目的话，项目的知识产权会怎么结算呢？</a>
                </dt>
                <dd>
                    <p class="indent0">
                        我们会给与任何一个加入项目的人以项目署名权。在署名权之外，我们的合作方式其实是多种多样的，可以是知识产权买断式的委托创作。也可以是互相享有一定知识产权的合作开发模式，或者直接加入我们项目组和我们共享所有的创作成果。
                    </p>
                </dd>
                <dt>
                    <a href="javascript:void(0);">我不是创作者，我该如何支持这个项目呢？</a>
                </dt>
                <dd>
                    <p class="indent0">
                        你好，谢谢你对我们的项目感兴趣。一般情况下，我们欢迎来自所有人对我们项目和游戏提出的建议。你可以试玩我们的游戏或者关注我们的项目开发情况，给我们提出一些建议。此外我们会准备多次众筹活动，我们会通过这些活动来接受大家对我们的支持并给与大家应得的丰厚回报。
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

<script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>
<script type="text/javascript" src="/js/jquery.placeholder.min.js"></script>
<script type="text/javascript" src="/js/dreamSpace.js"></script>
<script type="text/javascript" src="/js/project_action.js"></script>
<script type="text/javascript" src="/js/project_detail.js"></script>
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/footer.php') ?>
</body>
</html>