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
                <span>水果形象可爱，可衍生的范围广</span>
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
        <div class="detail-graphic" style="width:1200px;height:450px;">
            <img src="/images/14/1.jpg" alt="<?= $project['proj_name'] ?>" />
        </div>
    </div>
    <!--/detail-banner-->

    <!--detail-info-->
    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《森果精灵》项目概述</h2>
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
                                <span id="support_pno">300万</span>人民币
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

            <p class="yellow fs16 indent0">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                森果精灵到底是一种什么样的动画？
            </p>
            <p class="indent0">
                《森果精灵》针对女性以及儿童市场，采用三维制作二维渲染的方式，及秉承高品质制作的理念又能降低生产成本。相比国内同等成本的动画片《森果精灵》拥有绝对的品质优势，加上同等宣传力度，《森过精灵》有望在未来5年内成为国内动漫第一品牌。
            </p>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                森果精灵的产品技术优势
            </p>
            <p class="indent0">
                品质与成本的完美匹配
            </p>
            <p class="indent0">二维渲染效果效果颜色艳丽，动画流畅度更高，渲染更快，制作成本低.</p>
            <p class="indent0">三维渲染效果颜色更加细腻，效果更加丰富，可重复利用二维制作资源.</p>
            <div class="lazy-box mt24" style="width:638px; height:180px;">
                <img data-original="/images/14/2.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
            </div>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                全3D视觉效果 画面效果更加细腻
            </p>
            <div class="lazy-box mt24" style="width:720px; height:168px;">
                <img data-original="/images/14/3.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
            </div>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                森果精灵项目开发预算
            </p>
            <p class="indent0">
                制作与发行预算1000万
            </p>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                项目开发硬件
            </p>
            <p class="indent0">
                需要容纳团队工作的办公场地和相关工作设备，可容纳30-50人团队办公的场地，团队需要的办公电脑、渲染测试机、
            </p>
            <p class="indent0">
                服务器以及办公用品。
            </p>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                投资回报
            </p>
            <p class="indent0">
                300万人民币作为项目启动资金，用15集影片制作。我们愿意出让我们项目股份20%。
            </p>
            <p class="indent0">
                我们也接受与投资方共同合作开发项目，共同持有该项目IP的做法。
            </p>
        </div>
    </div>
    <div >
        <div class="detail-info detail-info-one ">
            <div class="detail-leftpart fl">
                <div class="leftinfo-tpart">
                    <h2>《森果精灵》发展策略与规划</h2>
                </div>
            </div>
            <div class="detail-rightpart">
                <p class="yellow fs16 indent0 mt20">
                    <i class="ds-icon-16 ds-icon-diamond"></i>
                    森果精灵的制作模式
                </p>
                <p class="indent0">
                    我们招揽全球最好的创作团队提供创作素材，起步高端；利用本土的制作团队加工生产，成本更低；因为采用全球创            </p>
                <p class="indent0">
                    意人才，所以内容更加符合大多数国家的审美需求，销售渠道更加广泛。
                </p>
                <div class="lazy-box mt20" style="width:660px; height:77px;">
                    <img data-original="/images/14/4.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
                <p class="yellow fs16 indent0 mt20">
                    <i class="ds-icon-16 ds-icon-diamond"></i>
                    动画生产
                </p>
                <p class="indent0">
                    自己的核心团队进行电影制作，TV版可由本土其他外包团队代工，保证品质的同时，降低制作成本。制作生产的同时
                </p>
                <p class="indent0">
                    可进行其他品牌合作洽谈，植入广告，可适当降低动画片制作成本。
                </p>
                <p class="yellow fs16 indent0 mt20">
                    <i class="ds-icon-16 ds-icon-diamond"></i>
                    品牌建设
                </p>
                <p class="indent0">
                    动画产品全球推广放映，影院、电视、各大视频媒体网站等授权播出，博客微博等自媒体平台进行宣传推广，短时
                </p>
                <p class="indent0">
                    间内扩大品牌知名度。《森果精灵》以其独有的可爱形象作为公益大使，可在小朋友和父母心中树立良好品牌形象。
                </p>
                <p class="yellow fs16 indent0 mt20">
                    <i class="ds-icon-16 ds-icon-diamond"></i>
                    产品授权
                </p>
                <p class="indent0">
                    《森果精灵》形象可爱，可衍生的范围广，例如：游戏、婴童产品、玩具、卡贴、文具等等。
                </p>
                <div class="lazy-box mt20" style="width:660px; height:77px;">
                    <img data-original="/images/14/5.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
                <div class="lazy-box mt20" style="width:670px; height:314px;">
                    <img data-original="/images/14/6.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
        </div>
    </div>


    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《森果精灵》盈利途径</h2>
            </div>
        </div>
        <div class="detail-rightpart">
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                森果精灵的制作模式介绍
            </p>
            <p class="indent0">
                以《森果精灵》品牌形象授权为盈利点，满足少儿观众的同时提升父母对品牌的认知。《森果精灵》以动画制作为切入点,
            </p>
            <p class="indent0">
                建立自品牌开发平台，切入少儿与家庭娱乐产业。
            </p>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                周边产品
            </p>
            <p class="indent0">
                通过同时研发的周边产品：日用品、玩具、手办、图书等产品进行宣传推广
            </p>
            <div class="lazy-box mt24" style="width:398px;height: 140px;">
                <img data-original="/images/14/7.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
            </div>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                品牌授权成功案例
            </p>
            <p class="indent0">
                方广是国内老牌婴童食品开发厂商，有着20年的发展经历，森果精灵的部分卡通形象已成功授权方广作为
                产品的形象代言。
            </p>
            <div class="lazy-box mt20" style="width:412px;height: 198px;">
                <img data-original="/images/14/8.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
            </div>


        </div>
    </div>

    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》团队介绍</h2>
            </div>

        </div>
        <div class="detail-rightpart">
            <p class="yellow fs16 indent0">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                剧本：松井亚弥（带队）丸尾みほ、橋本裕志 协力
            </p>
            <p class="indent0">
                代表作：
            </p>
            <div class="detail-rightpart-images mt20 mb40">
                <div class="lazy-box mt55" style="width:750px; height:219px;">
                    <img data-original="/images/14/9.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>

            <p class="yellow fs16 indent0 mt55">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                设定：
            </p>
            <p class="indent0">
                代表作
            </p>
            <div class="detail-rightpart-images mt20 mb40">
                <div class="lazy-box" style="width:686px;height: 217px;">
                    <img data-original="/images/14/10.jpg" alt="<?= $project['proj_name'] ?>" class="lazy"/>
                </div>
            </div>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                分镜：CANDY BOX公司
            </p>
            <p class="indent0">
                主要参与过《刀剑神域》、《进击的巨人》、《魔笛》等知名动画的分镜创作。
            </p>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                中期：自有团队
            </p>
            <p class="indent0">
                团队成员均有过国内一线动画制作经验，参与过项目包括：《郑和魔海劫》、《龙之谷》、《神笔马良》、《疯狂的年兽》等
                等动画电影项目。
            </p>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                张宇 创始人/导演
            </p>
            <p class="indent0">
                6年影视动画从业经验，参与过多部国内外动画电影项目，作品入围过“斯图加特”电影节艺术短片制作，有着丰富的
                制作与管理经验。11年应邀加入上海37数码，参加动画电影《郑和魔海劫》的制作，主要负责面部绑定工具与流程开发
                拥有2项技术专利。12年创立TiPics影视动画机构，致力于三维影视动画及广告业务,期间参与国内史诗魔幻3D电影《龙
                之谷-破晓奇兵》以及丽薇杰原创电影《果乐城》的制作。旗下拥有一批经验丰富的影视动画制作人员。
            </p>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                郑因时 项目经理
            </p>
            <p class="indent0">
                4年市场推广和动画制作项目管理经验、1年演出经纪行业市场经验。熟悉三维动画制作整套流程，能独立熟练的进行
                WBS分解、工作量及时间需求分析。拥有一定动画软件操作能力。
            </p>
            <p class="indent0">
                曾获
            </p>
            <p class="indent0">
                2007年 作品《魔术师》入选上海电子艺术节“Chained Animation”中法动画创作优秀项目
                2010年 上海大学生电视节奖紫丁香大奖
                2013年 中国邮政储蓄银行创富大赛荣获创盈组奖金
            </p>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                邵晴 CG总监
            </p>
            <p class="indent0">
                八年CG从业经验，参与过多部动画电影和影视特效工作，以及几十部广告TVC和企业宣传片的三维后期制作与指导工作。
            </p>
            <p class="indent0">
                擅长整体画面效果的把控，在导演与技术人员之间架好桥梁，针对不同项目提出相应的解决方案，仅仅低将艺术与技术结合在一起。
                主要作品有：《不怕贼惦记》、《赤壁》、《大闹天宫 3D》、《赛尔号2》、《无敌兵乓兔》、TV动画《啊啦菌团》等。
            </p>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                董明 动画导演
            </p>
            <p class="indent0">
                8年从业经验，一直从事动画环节制作，师从比利时动画导演Wouter至今，参加欧美项目大小30余部，对动画表演有着
                深刻的理解，能够准确而清晰的把握导演要求，完美还原剧本创作。是中国不可多得的最好的动画师。
            </p>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                于翔 流程总监
            </p>
            <p class="indent0">
                资深影视特效师/技术总监，早期IDMT培训学员，先后在环球数码部以及培训部就职，后在上海36及东方梦工厂参与CGI
                部门、培训部门的工作以及《驯龙记》TV版的生产，项目经验极为丰富.
            </p>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                曹丰硕 模型组长
            </p>
            <p class="indent0">
                资深影视CG艺术家，精通MAYA、Zbrush、PS、MARI等模型制作软件，以及整个电影后期制作流程。曾就职大连博涛、
                苏州米粒，曾参与国内外多类项目的制作。
            </p>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                龙钢 绑定组长
            </p>
            <p class="indent0">
                影视动画绑定新秀，毕业两年内参与了两步动画电影制作，学习能力强，善于解决项目中存在的各类技术问
                题，生产效率极高。
            </p>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                沈青云 动画组长
            </p>
            <p class="indent0">
                资深高级动画师，曾就职于中影影视、郑致光、大魔王，参与动画电影《小恐龙与金银岛》腾讯动画片
                《勇者大冒险》等项目的制作。
            </p>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                连增会 后期组长
            </p>
            <p class="indent0">
                资深影视后期特效师，擅长后期包装与剪辑。曾就职于北京枫丹丽舍和一石数码，参与电影《人鱼帝国》的后期制作
                对影视动画后期有着深刻的理解和认识。
            </p>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                后期：日本的Sound Design ON公司
            </p>
            <p class="indent0">
                主要参与过《马里奥》系列配乐及电影《3D 贞子》配乐
            </p>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                主题曲：黒须克彦、Mao
            </p>
            <p class="indent0">
                日本黒须克彦担当制作，Mao负责演唱参与过动画《哆啦A梦》主题曲的合作。
            </p>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                配音
            </p>
            <p class="indent0">
                日本由新艺双元公司负责
                中国则有上海电影译制片厂的配音老师，动画片《秦时明月》的配音导演刘钦负责。
            </p>
            <p class="yellow fs16 indent0 mt20">
                <i class="ds-icon-16 ds-icon-diamond"></i>
                上海资源
            </p>
            <p class="indent0">
                郑因时 复旦大学上海视觉艺术学院创友会会长
            </p>
            <p class="indent0">
                汪建强 上海电视台副台长
            </p>
            <p class="indent0">
                龚建英 中国动画学会副会长兼秘书长
            </p>
            <p class="indent0">
                国家二级文学编辑
            </p>
            <p class="indent0">
                文化部扶持动漫专业专家委员会专家
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