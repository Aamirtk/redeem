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
                <span>单身熊爸与动物特工激情对撞，上演了一场搞笑、刺激的冒险之旅</span>
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
            <img src="/images/5/banner-pro1.jpg" alt="<?= $project['proj_name'] ?>"  />
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
            <div class="detail-rightpart-images">
                <div class="lazy-box" style="width:750px;height: 82px;">
                    <img data-original="/images/5/detail-img2.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
            <p class="indent0 mt35">
                <span class="blue fs16 fwb">
                    <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                    影片种类：
                </span>
                <span class="indent0">
                    合家欢动画电影
                </span>
            </p>
            <p class="indent0 mt35">
                <span class="blue fs16 fwb">
                    <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                    故事类型：
                </span>
                <span class="indent0">
                    冒险、喜剧、励志
                </span>
            </p>
            <p class="indent0 mt35">
                <span class="blue fs16 fwb">
                    <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                    影片时长：
                </span>
                <span class="indent0">
                    90分钟
                </span>
            </p>
            <p class="indent0 mt35">
                <span class="blue fs16 fwb">
                    <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                    开拍时间：
                </span>
                <span class="indent0">
                    2014年
                </span>
            </p>
            <p class="indent0 mt35">
                <span class="blue fs16 fwb">
                    <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                    上映时间：
                </span>
                <span class="indent0">
                    2015年寒假
                </span>
            </p>
            <div class="detail-rightpart-images mt35">
                <div class="lazy-box" style="width:750px;height: 82px;">
                    <img data-original="/images/5/detail-img3.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
            <p class="mt35">
                只为救回被猎人掳走的熊仔“嘻哈”，生性鲁莽的熊爸爸“大山”闯入了节日中热闹的人类城镇；就在大山即将被抓之际，却被神秘的特工狗“亨特”救下。
            </p>
            <p>
                此时的嘻哈已落入动物贩卖集团的魔窟，被坏人扮成了熊猫，身价飙升。为了拯救儿子，大山不亨特组成动物特工拍档，展开了潜入魔窟的秘密行动；满载动物的火车即将启程，救援刻不容缓！可神秘的亨特却将大山带去了另一个斱向……
            </p>
            <p>
                特工狗亨特到底隐藏着什么秘密？
            </p>
            <p>
                鲁莽的大山能否历经磨难，救出相依为命的儿子？
            </p>
            <div class="detail-rightpart-images mt35">
                <div class="lazy-box" style="width:750px;height: 82px;">
                    <img data-original="/images/5/detail-img4.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
            <div class="detail-rightpart-images">
                <div class="lazy-box" style="width:750px;height: 573px;">
                    <img data-original="/images/5/detail-img5.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
            <div class="detail-rightpart-images">
                <div class="lazy-box" style="width:750px;height: 82px;">
                    <img data-original="/images/5/detail-img6.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
            <div class="detail-rightpart-images">
                <div class="lazy-box" style="width:750px;height: 218px;">
                    <img data-original="/images/5/detail-img7.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
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
                    创作营销高度整合
                </p>
                <p class="leftinfo-mpart-desc indent-5">
                    《<?= $project['proj_name'] ?>》首度将动漫创作和大电影制作、营销高度整合。本项目拥有骨灰级动漫创作人，资深电影视效总监，还有强有力的大电影专业宣发，以及主流媒体后盾。
                </p>
            </div>
        </div>
        <div class="detail-rightpart">
            <p class="blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                以深厚的媒体资源，为影片保驾护航 —— 李晓明（出品人）
            </p>
            <p class="indent0">
                原中央电视台副台长，中广树德国际文化传媒有限公司总经理
            </p>
            <p class="indent0">
                以深厚的媒体资源，为影片保驾护航。
            </p>


            <p class="mt35 blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                专业雄厚的宣发实力 —— 宋贝贝（制片人）
            </p>
            <p class="indent0">
                曾参与众多电影作品的制片和宣发，从国产大电影到好莱坞一线电影，所取得的票房成绩有目共睹。
            </p>
            <p class="indent0">
                主要作品：
            </p>
            <p class="indent0 indent-5">
                《杜拉拉升职记》、《夏日乐悠悠》、《建国大业》、
            </p>
            <p class="indent0 indent-5">
                《钢铁侠3》、《复仇者联盟》、《警察故事2013》、
            </p>
            <p class="indent0 indent-5">
                《北京爱情故事》、《环形使者》、《催眠大师》
            </p>


            <p class="mt35 blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                资深视效指导，创意达人 —— 王琦（导演）
            </p>
            <p class="indent0">
                曾参与主创的网络动画系列剧《豆儿日记》自2008年优酷首播以来，引起全网络转播，仅优酷单平台的点播量已达63,000,000次，全网点播量达1亿次以上。不仅获得了无数网友的热捧，更斩获近20个国内外动漫奖项。
            </p>
            <p class="indent0">
                作为特效指导参与的《百万巨鳄》上映后，其中逼真的鳄鱼特效动画，赢得了业界多位明星及导演的赞誉；影片于当年荣获澳门国际电影节金莲花奖-最佳特效奖。
            </p>
            <p class="indent0">
                特效短片作品《怪物》于2014年获得中国电影电视技术学会二等奖。
            </p>
            <p class="mt35 indent0">
                主要作品：动画系列剧：《豆儿日记》电影特效：《百万巨鳄》《叱前怪兽》《七夜追魂》《怪物》特种动画电影：《太空迷航》《未来警察》《卡纳蓝蝶恋》
            </p>

            <p class="mt35 blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                电影视效专家 —— 杨佳航（执行导演）
            </p>
            <p class="indent0">
                中国第一批制作好莱坞电影的特效师之一，先后参与二十多部好莱坞电影及国产电影的特效制作。
            </p>
            <p class="indent0">
                作为中国特效师，其作品经过美国环球影业、迪斯尼、哥伦比亚影业、20世纪福克斯、派拉蒙影业、HBO、狮门影业及索尼影业严苛的检验。
            </p>
            <p class="indent0">
                2010年，为斯皮尔伯格的《血战太平洋》制作的特效，摘得当年美国艾美奖最佳视觉效果的桂冠。
            </p>


            <p class="mt35 blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                骨灰级动漫创作人 —— 施阳（副导演）&柳晨光（动画总监）
            </p>
            <p class="indent0">
                施阳·代表作品：
            </p>
            <p class="indent0">
                北京市朝阳区标志形象：洛宝贝
            </p>
            <p class="indent0">
                动画电影导演：《哈宝的冒险王国》、《章鱼哥》。
            </p>
            <p class="indent0">
                动画短片：
            </p>
            <p class="indent0 indent-5">
                《海岸之家》、《锦衣卫》、《幸运萱萱》。
            </p>
            <p class="indent0">
                卡通游戏形象设计：《怪物X联盟》
            </p>
            <p class="mt35 indent0">
                柳晨光·参与作品：
            </p>
            <p class="indent0">
                动画电影（日本）：
            </p>
            <p class="indent0 indent-5">
                《Freedom》（大友兊洋作品），《苹果核战记》
            </p>
            <p class="indent0">
                短片及动画形象：
            </p>
            <p class="indent0 indent-5">
                《吉祥父子》，《劲舞团》
            </p>
            <p class="indent0">
                动画剧集（日本）：
            </p>
            <p class="indent0 indent-5">
                《机动战士高达seed》，《犬夜叉》，《海贼王》，
            </p>
            <p class="indent0 indent-5">
                《变形金刚》（日版），《恶魔城》
            </p>


            <p class="mt35 blue fs16 indent0 fwb">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                CG行业先行者 —— 朱新凯（执行制片人）
            </p>
            <p class="indent0">
                行业老鸟，拥有丰富的人力资源及项目管理经验，多年的CG行业背景是动画电影制作过程中的有力保障。
            </p>
            <p class="indent0">
                方特主题公园3D立体电影：
            </p>
            <p class="indent0 indent-5">
                《未来警察》巨幕立体影片
            </p>
            <p class="indent0 indent-5">
                《秦皇求仙》环幕立体影片
            </p>
            <p class="indent0 indent-5">
                《生命起源》环幕立体影片
            </p>
            <p class="indent0 indent-5">
                《大闹天宥》水幕电影
            </p>
            <p class="indent0 indent-5">
                《宇博会》环幕立体影片
            </p>
            <p class="indent0 indent-5">
                《华夏五千年》环幕立体影片
            </p>
            <p class="mt35 indent0">
                参与的院线电影作品：
            </p>
            <p class="indent0 indent-5">
                《叱前怪兽》（中英合拍）
            </p>
            <p class="indent0 indent-5">
                《百万巨鳄》
            </p>
            <p class="indent0 indent-5">
                《七夜追魂》（台湾出品，即将上映）主演释小龙，蔡松林监制
            </p>
            <p class="indent0 indent-5">
                《异兽来袭》（拍摄中）
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
                            <img src="/images/5/slide01.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/5/slide02.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/5/slide03.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/5/slide04.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/5/slide05.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
            </ul>
            <a class="detail-bannerpart-next" href="javascript:void(0)"></a>
        </div>
    </div>

    <div class="detail-info detail-info-one pb170">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》发行团队</h2>
            </div>
        </div>
        <div class="detail-rightpart">
            <ul class="rightinfo-groupmember num2">
                <li>
                    <div class="detail-rightpart-images">
                        <div class="lazy-box" style="width:200px;height: 100px;">
                            <img data-original="/images/5/detail-img8.jpg" alt="万达影视" class="lazy" />
                        </div>
                    </div>
                    <p class="mt20 blue fs16 indent0 fwb">
                        <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                        万达影视
                    </p>
                    <p class="groupmember-role">电影制式世界第一大院线</p>
                </li>
                <li>
                    <div class="detail-rightpart-images">
                        <div class="lazy-box" style="width:200px;height: 100px;">
                            <img data-original="/images/5/detail-img9.jpg" alt="和颂传媒" class="lazy" />
                        </div>
                    </div>
                    <p class="mt20 blue fs16 indent0 fwb">
                        <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                        和颂传媒
                    </p>
                    <p class="groupmember-role">专业影视传播机构</p>
                </li>
            </ul>
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