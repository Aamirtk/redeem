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
                <span>一代神魔剑侠小说大宗师还珠楼主惊天巨著</span>
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
            <img src="/images/9/1.jpg" alt="<?= $project['proj_name'] ?>"  />
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
                    <span class="category-content">古装/玄幻/仙侠 50集电视剧</span>
                </p>
                <div class="leftinfo-mpart-operate">
                    <ul class="operate-support-box">
                        <li class="fl support-num">
                            <p class="support-firstline">
                                <span id="support_pno">8000万</span>人民币
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

            <p class="blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                节目名称：
                <span class="detail-word-gray">新蜀山剑侠传</span>
            </p>
            <p class="blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                节目类型：
                <span class="detail-word-gray">古装/玄幻/仙侠</span>
            </p>
            <p class="blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                节目长度：
                <span class="detail-word-gray">50集</span>
            </p>
            <p class="blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                受众群体：
                <span class="detail-word-gray">15~40，核心观众&nbsp;&nbsp;&nbsp;40~60，辐射观众</span>
            </p>
            <p class="blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                播出平台：
                <span class="detail-word-gray">强势卫视&nbsp;&nbsp;&nbsp;台网联动</span>
            </p>
            <p class="blue fs16 indent0 fwb mt35">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                制作总预算
            </p>
            <p class="indent0">
                约8000万人民币
            </p>
            <p class="blue fs16 indent0 fwb mt35">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                发行计划/回报：
            </p>
            <p class="indent0">
                行价收益保守预计
            </p>
            <p class="indent0">1、首播一级卫视发行平台：一家一线卫视加二线卫视             预估收益：80万元/家×60集×2＝9600万元</p>
            <p class="indent0">2、二轮卫视两家电视台发行                                                  预估收益：30万元/集×60集×2＝3600万元</p>
            <p class="indent0">3、五家地面电视台发行                                                         预估收益：5万元/集×60集×5=1500万元</p>
            <p class="indent0">3、网络版权独家首播：优酷/乐视/迅雷/腾讯                     预估收益：160万元/集×60集＝9600万元</p>
            <p class="indent0">4、海外发行预估收益：                                                          预估收益： 15万元/集×60集=900万元
            </p>
            <p class="blue  indent0 mt20">
                以上发行收益估算总计：25200万元
            </p>
            <p class="blue indent0">
                预计收益回报：25200万元—8000万元=17200万元
            </p>
            <p class="blue fs16 indent0 fwb mt20">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                时间周期
            </p>
            <p class="indent0">
                拍摄周期：110天  2016年初杀青  下半年宣发
            </p>
        </div>
    </div>


    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》项目背景</h2>
            </div>

        </div>
        <div class="detail-rightpart">
            <p class="blue indent0">
                这部中国神话巨著，“开小说界千古未有之奇观”，洋洋500万言，这部作品对后来以古龙、金庸、梁羽生为代表的新派武侠有很大的影响，像书中的降龙十八掌，弹指神通，白发魔女，总之这部书绝对是武侠小说史上，值得大书一笔的巨著。</p>
            <p class="blue indent0">著名作家倪匡称天下第一奇书是还珠楼主所著的武侠神怪小说《蜀山剑侠传》。</p>
            <p class="blue indent0">白先勇先生就曾经反复的通读此书，认为“没有其他书让我这么着迷过”。</p>
            <p class="blue indent0">著名的RPG游戏——《仙剑奇侠传》中也借用了蜀山派的背景</p>
            <p class="blue indent0">如今畅销的网络小说《诛仙》也继承了《蜀山剑侠传》的衣钵。</p>

            <p class="blue fs16 indent0 fwb mt24">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                经典影视剧改编
            </p>
            <p class="indent0">
                <span class="w340">1983年徐克导演 电影《新蜀山剑侠》</span>           主演：元彪 郑少秋 林青霞 洪金宝
            </p>
            <p class="indent0">
                <span class="w340">2001年徐克导演 电影《蜀山传》</span>                  主演：郑伊健 张柏芝 古天乐 吴京章子怡 林熙蕾</p>
            <p class="indent0">
                <span class="w340">2002年 40集电视剧《新蜀山剑侠》</span>             主演：马景涛 陈德容 李立群 钱小豪</p>


            <p class="blue fs16 indent0 fwb mt24">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                大型网络游戏
            </p>
            <p class="indent0">根据蜀山为背景改编的蜀山系列网络游戏，具有庞大的游戏玩家</p>
            <p class="indent0">《蜀山剑侠传》《蜀山OL》《蜀山传奇》《蜀山神话》《乾坤一剑》《梦幻蜀山》《蜀山新传》《大唐无双蜀山》</p>
            <p class="blue fs16 indent0 fwb mt20">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                项目优势
            </p>
            <p class="indent0">• 小说关注度★★★★☆ 《蜀山剑侠传》原著的成就极高，被成为中国神话巨著。</p>
            <p class="indent0">• 影视关注度★★★★★ 著名鬼才导演徐克非常钟爱《蜀山剑侠传》，曾三度拍摄蜀山题材影视作品，无论是对国产电影的贡献还是关注度，都获得了巨大的成功。</p>
            <p class="indent0">• 新蜀山关注度★★★★★ 本剧将以精美的动画特效呈现出仙魔斗剑的宏大场面、亦真亦幻的蜀山奇景、灵动可爱的各类仙宠以及异彩纷呈的各色兵器，并在人物造型、置景美术和动作特效上力求精益求精。用最好的资源把《新蜀山剑侠传》打造成2015年最火的“现象级”作品。</p>
            <p class="indent0">• 拥有这四个元素的题材的电视剧，几乎每一部无论是影响力还是收视率都获得了巨大的成功。从《仙剑奇侠传》三部曲开始到《轩辕剑》，在播出期间，传统媒体收视率都遥遥领先，随着新媒体网络的不断发展，《古剑奇谭》已成为2014年现象级大片。</p>
            <p class="indent0">• 而《新蜀山剑侠传》虽为同类型作品，但在剧本的挖掘和制作的要求上与这些成功作品相比有过之而无不及，一定会创造更大的收视神话。</p>
            <p class="indent0">• 本剧即将打造国内玄幻经典大剧。</p>
            <p class="indent0">• 本剧将邀请最具实力的创作人员参与制作，当红一线影星加盟倾情演绎。著名导演对本剧有着极大的期望，已经开始着手案头工作。本剧将力邀一线实力偶像演员加盟。</p>
            <p class="indent0">• 本剧主人公在设定上都是以性格各异、青春靓丽的青年为蓝本，在性格、外形、武功上最大程度的满足观众对于视觉美的追求。</p>
        </div>
    </div>

    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》团队阵容</h2>

            </div>
            <div class="leftinfo-mpart">
                <p class="leftinfo-mpart-category-new">
                    <i class="ds-icon-16 ds-icon-entertime"></i>
                    项目入驻时间：<?= date('Y-m-d', $project['created_at'])?>
                </p>
                <p class="leftinfo-mpart-desc">

                </p>
            </div>
        </div>
        <div class="detail-rightpart">
            <p class="blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                【总监制、艺术总监】：周炳坤
            </p>
            <p class="indent0">
                <span class="w340">电影 《为了母亲的微笑》（已拍） </span> 电影《小牛的草原》（已拍）
            </p>
            <p class="indent0">
                <span class="w340">30集电视剧《人人都爱我丈夫》（已拍）   </span>
                30集电视剧《乱世情缘》（已拍）
            </p>
            <p class="indent0">
                <span class="w340">40集电视连续剧《少年神探狄仁杰》（已拍） </span>
                36集情感励志剧《女人的渴望》（筹备中）
            </p>
            <p class="indent0">
                <span class="w340">50集古装玄幻仙侠剧《新蜀山剑侠传》（筹备中）  </span>
                42集古装悬疑探案剧《少年神探狄仁杰2》（剧本创作中）
            </p>
            <p class="blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                人物介绍&主演拟定
            </p>
            <p class="indent0 mt20">
                李英琼： 18-24岁，男，宽厚善良，胸襟豁达，顽强执着，重情重义的悲情英雄。
            </p>
            <ul class="detail-images-float mt20">
                <li>
                    <div class="lazy-box" style="width:122px; height:150px;">
                        <img data-original="/images/9/2.jpg" alt="李英琼" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box" style="width:102px; height:150px;">
                        <img data-original="/images/9/3.jpg" alt="李英琼" class="lazy" />
                    </div>
                </li>
            </ul>
            <p class="indent0 mt20">
                周轻云： 15-24岁，女，冰雪聪明，秀外慧中，正直坦率，善解人意的柔情女侠。
            </p>
            <ul class="detail-images-float mt20">
                <li>
                    <div class="lazy-box" style="width:99px; height:150px;">
                        <img data-original="/images/9/4.jpg" alt="周轻云" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box" style="width:101px; height:150px;">
                        <img data-original="/images/9/5.jpg" alt="周轻云" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box" style="width:136px; height:150px;">
                        <img data-original="/images/9/6.jpg" alt="周轻云" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box" style="width:100px; height:150px;">
                        <img data-original="/images/9/7.jpg" alt="周轻云" class="lazy" />
                    </div>
                </li>
            </ul>
            <p class="indent0 mt20">
                余英男： 20-26岁，男，聪明机智、心狠手辣、胸有城府、重利轻义的傲世枭雄。
            </p>
            <ul class="detail-images-float mt20">
                <li>
                    <div class="lazy-box" style="width:105px; height:150px;">
                        <img data-original="/images/9/8.jpg" alt="余英男" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box" style="width:105px; height:150px;">
                        <img data-original="/images/9/9.jpg" alt="余英男" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box" style="width:100px; height:150px;">
                        <img data-original="/images/9/10.jpg" alt="余英男" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box" style="width:99px; height:150px;">
                        <img data-original="/images/9/11.jpg" alt="余英男" class="lazy" />
                    </div>
                </li>
            </ul>
            <p class="indent0 mt20">
                齐灵云： 16-25岁，女，聪明善良，嫉恶如仇，高贵傲慢，用情至深的痴情女神。
            </p>
            <ul class="detail-images-float mt20">
                <li>
                    <div class="lazy-box" style="width:118px; height:150px;">
                        <img data-original="/images/9/12.jpg" alt="齐灵云" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box" style="width:100px; height:150px;">
                        <img data-original="/images/9/13.jpg" alt="齐灵云" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box" style="width:114px; height:150px;">
                        <img data-original="/images/9/14.jpg" alt="齐灵云" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box" style="width:105px; height:150px;">
                        <img data-original="/images/9/15.jpg" alt="齐灵云" class="lazy" />
                    </div>
                </li>
            </ul>
            <p class="indent0 mt20">
                严人英： 16-24岁，男，忠义仁厚，刚正不阿，行事稳健，心思缜密的谦谦君子。
            </p>
            <ul class="detail-images-float mt20">
                <li>
                    <div class="lazy-box" style="width:116px; height:150px;">
                        <img data-original="/images/9/16.jpg" alt="严人英" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box" style="width:111px; height:150px;">
                        <img data-original="/images/9/17.jpg" alt="严人英" class="lazy" />
                    </div>
                </li>
                <li>
                    <div class="lazy-box" style="width:107px; height:150px;">
                        <img data-original="/images/9/18.jpg" alt="严人英" class="lazy" />
                    </div>
                </li>
            </ul>
            <p class="indent0 mt20">
                明 珠： 16-22岁，女 ，刁钻古怪，聪明绝顶，敢爱敢恨，超凡脱俗的热情魔女。
            </p>
            <p class="indent0 mt20">
                齐漱溟： 45岁左右，男，峨嵋派掌门四师叔，玄真子死后暂时代替峨嵋掌教之位。
            </p>
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



<?php require_once(Yii::getAlias('@frontend') . '/web/layout/footer.php') ?>
</body>
</html>