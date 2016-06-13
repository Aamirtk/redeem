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
                <span>奇幻神秘的深海世界  惊心动魄的冒险之旅</span>
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
            <img src="/images/6/1.jpg" alt="<?= $project['proj_name'] ?>"  />
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
                    <span class="category-content">真人CG电影</span>
                </p>
                <div class="leftinfo-mpart-operate">
                    <ul class="operate-support-box">
                        <li class="fl support-num">
                            <p class="support-firstline">
                                <span id="support_pno">洽谈中</span>
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
            <div class="detail-rightpart-images">
                <div class="lazy-box" style="width:750px;height: 130px;">
                    <img data-original="/images/6/2.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
            <p class="blue fs16 indent0 fwb mt20">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                类型：<span class="detail-word-gray">《<?= $project['proj_name'] ?>》</span>
            </p>
            <p class="blue fs16 indent0 fwb ">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                故事介绍：<span class="detail-word-gray">科幻 灾难 惊悚</span>
            </p>
            <p class="blue fs16 indent0 fwb ">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                格式：<span class="detail-word-gray">数字</span>
            </p>
            <p class="blue fs16 indent0 fwb ">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                时长：<span class="detail-word-gray">90分钟</span>
            </p>
            <p class="blue fs16 indent0 fwb ">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                制作预算：<span class="detail-word-gray">1000万元</span>
            </p>
            <p class="blue fs16 indent0 fwb ">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                宣发预算：<span class="detail-word-gray">500万元</span>
            </p>
            <p class="blue fs16 indent0 fwb ">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                发行范围：<span class="detail-word-gray">亚洲</span>
            </p>
            <p class="mt20">
                本片制片方综合考虑两方面的发展趋势，以年龄段在16至35岁之间的主流电影观众为目标，借鉴《异形》、《大海啸之鲨口逃生》、《狂蟒之灾》、《逃亡鳄鱼岛》、《狮口惊魂》等好莱坞影片，整合多方优势资源，以总计1100万元人民币的中低预算成本，摄制发行国内首部怪兽题材科幻灾难惊悚电影《异兽来袭》。
            </p>
            <p class="indent0">
                本片故事背景设定为观众能够触摸得到的现实生活环境中。全部人物均设定为观众所熟悉的普通小人物。
            </p>
            <p>
                本片着力表现一群形形色色的小人物在遭遇凶残异兽的极端灾难事件后，从被动逃避到主动反击，在一次次付出惨痛的代价之后，凭借亲情、爱情、友情等情感的支撑，最终幸存下来的男女主角战胜了异兽。
            </p>
            <p>
                由于题材的独特性，如果结合适当的宣传攻势，本片将有可能创造中国电影史上低成本投资影片又一次以小博大的票房奇迹。
            </p>
            <p class="blue fs16 indent0 fwb mt20">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                故事介绍
            </p>
            <p>夏夜，一颗“陨石”穿越天际落入了北方山林，摧毁通讯信号塔，一只相貌奇异的怪兽从“陨石”中爬出来，毫不犹豫地干掉了两个好奇的通讯维修工……</p>
            <p>大山深处偏僻的滑雪场，迎来了前来游玩的女孩莫莫一家、富二代李公子和他的朋友们。他们肆意狂欢，引起了山林中怪兽的注意。富二代和女友干柴烈火之际，怪兽突然出现，抓走杀死了女友……</p>
            <p>滑雪场经理、李公子身边的马仔又接二连三地死去，恐慌蔓延，人人自危。莫莫爸妈为了保护莫莫相继牺牲，他们不得不把莫莫托付给退役军人老马。</p>
            <p> 老马能保护莫莫摆脱怪兽的魔爪吗？</p>
            <p> 莫莫又揭开了怪兽吃人怎样的真相？</p>
        </div>
    </div>


    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》演员介绍</h2>
            </div>
            <div class="leftinfo-mpart">
                <p class="leftinfo-mpart-category-new">
                    <i class="ds-icon-16 ds-icon-member"></i>
                    优质团队联手打造
                </p>
                <p class="leftinfo-mpart-desc">
                    《异兽来袭》题材独特，着力表现一群形形色色的小人物在遭遇凶残异兽的极端灾难事件后，从被动逃避到主动反击，在一次次付出惨痛的代价之后，凭借亲情、爱情、友情等情感的支撑，最终幸存下来的男女主角战胜了异兽。拯救Jen和世界的故事。
                </p>
            </div>
        </div>
        <div class="detail-rightpart">
            <div class="detail-rightpart-images mt20 mb40">
                <div class="lazy-box" style="width:750px; height:130px;">
                    <img data-original="/images/6/3.jpg" alt="<?= $project['proj_name'] ?>" class="lazy" />
                </div>
            </div>
            <p class="blue fs16 indent0 fwb mt20">
                <i class="ds-icon-16 ds-icon-diamond-blue"></i>
                角色介绍
            </p>
            <div class="detail-role-left">
                <div class="detail-rightpart-images">
                    <div class="lazy-box" style="width:130px; height:131px;">
                        <img data-original="/images/6/4.jpg" alt="甘于晓雪" class="lazy" />
                    </div>
                </div>
                <p class="indent0">莫莫——甘于晓雪 饰</p>
                <p class="indent0">
                    著名童星，出演过《中国式离婚》、《非亲兄弟》、《南下》、《金婚》、《大宅院的女人》等数十部电影、电视剧作品，并参与拍摄了张艺谋导演的网通迎奥运宣传片、北京电视台迎奥运公益广告、贾樟柯导演的玉兰油二十年宣传片《中国式美丽》等作品的拍摄。
                </p>
            </div>
            <div class="detail-role-right">
                <div class="detail-rightpart-images">
                    <div class="lazy-box" style="width:130px; height:131px;">
                        <img data-original="/images/6/5.jpg" alt="于博宁" class="lazy" />
                    </div>
                </div>
                <p class="indent0 text-right">马师傅——于博宁 饰</p>
                <p class="indent0">
                    新生代演员，出演过《智取威虎山》、《太平轮》、《坚持》、《张治中》、《天龙八部》、《奇妙女孩》、《倚天屠龙记》、《水浒》、《中国特警2》、《我为出嫁狂》、《一级通缉令》、《零炮楼》等众多影视作品。
                </p>
            </div>
            <div class="detail-role-left">
                <div class="detail-rightpart-images">
                    <div class="lazy-box" style="width:130px; height:131px;">
                        <img data-original="/images/6/6.jpg" alt="尹大为" class="lazy" />
                    </div>
                </div>
                <p class="indent0">莫父——尹大为 饰</p>
                <p class="indent0">
                    旅法导演、演员 。中国电影家、电视家、戏曲家协会会员。 其导演或主演过的作品包括《影后蝴蝶》、《京城缉捕队》、《北京女人》、《飞跃》、《兰花儿》、《冼夫人》、《保密局1949》、《温州人在巴黎》、《天使的翅膀》、《寻找雷锋》、《变成太阳的手鼓》等。
                </p>
            </div>
            <div class="detail-role-right">
                <div class="detail-rightpart-images">
                    <div class="lazy-box" style="width:130px; height:131px;">
                        <img data-original="/images/6/7.jpg" alt="王斯琼" class="lazy" />
                    </div>
                </div>
                <p class="indent0 text-right">莫母——王斯琼 饰</p>
                <p class="indent0">
                    国家一级演员，曾在80多部影视剧中担任主演和主要角色，成功的塑造过许多不同年代、不同身份、不同职业、不同性格的人物，其主要代表作包括：《浮华城市》、《雾非雾》、《台湾第一巡府》、《船政风云》、《我的父亲是板凳》、《双核时代》、《我为出嫁狂》等。
                </p>
            </div>
            <div class="detail-role-left">
                <div class="detail-rightpart-images">
                    <div class="lazy-box" style="width:130px; height:131px;">
                        <img data-original="/images/6/8.jpg" alt="杨祖青" class="lazy" />
                    </div>
                </div>
                <p class="indent0">丁雪——杨祖青 饰</p>
                <p class="indent0">
                    新生代演员，先后出演电视剧作品《小芳》、《剪爱》、《黛玉传》、《蝴蝶劫》、《远亲近邻》、《风雨雕花楼》、《天经地义》。电影作品《红色恋歌》、《金牌小姐和猫》等。
                </p>
            </div>
            <div class="detail-role-right">
                <div class="detail-rightpart-images">
                    <div class="lazy-box" style="width:130px; height:131px;">
                        <img data-original="/images/6/9.jpg" alt="黄榛" class="lazy" />
                    </div>
                </div>
                <p class="indent0 text-right">张剑鸣——黄榛 饰</p>
                <p class="indent0">
                    新生代演员，南京艺术学院影视学院表演本科班毕业，先后出演过《英雄有约》、《不想回家》、《奶娘》、《千里邮缘》、《扇娘》、《山里山外》、《盖世英雄曹操》、《城市猎人》、《利箭纵横》、《互联网》等作品。
                </p>
            </div>
            <div class="detail-role-left">
                <div class="detail-rightpart-images">
                    <div class="lazy-box" style="width:130px; height:131px;">
                        <img data-original="/images/6/10.jpg" alt="于佳" class="lazy" />
                    </div>
                </div>
                <p class="indent0">李宇翔——于佳 饰</p>
                <p class="indent0">
                    主持人、演员。曾在中央台、北京台、旅游卫视等各大电视台主持过多档节目，并参与主演微电影《有梦就去追》、电视短剧《雏菊》、《我爱我车》、《melody》、《爱情就在隔壁》、《恋恋红旗》、《妈妈要去西藏》、《对手》等。
                </p>
            </div>
            <div class="detail-role-right">
                <div class="detail-rightpart-images">
                    <div class="lazy-box" style="width:130px; height:131px;">
                        <img data-original="/images/6/11.jpg" alt="诗梓佳" class="lazy" />
                    </div>
                </div>
                <p class="indent0 text-right">施露露——诗梓佳 饰</p>
                <p class="indent0">
                    新生代优质偶像，网络“人气美女”kitty诗梓佳从出道开始就备受关注，近来更是人气一路高涨，风光无限，昔日的网络红人俨然已走向现实舞台。
                </p>
            </div>
        </div>
    </div>

    <div class="detail-info detail-info-two pb90">
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
                            <img src="/images/6/slide01.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/6/slide02.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/6/slide03.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/6/slide04.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/6/slide05.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="/images/6/slide06.jpg" alt="<?= $project['proj_name'] ?>" />
                        </div>
                    </a>
                </li>
            </ul>
            <a class="detail-bannerpart-next" href="javascript:void(0)"></a>
        </div>
    </div>

    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》项目镜头分析</h2>
            </div>
        </div>
        <div class="detail-rightpart">
            <table class="detail-table">
                <tr>
                    <th width="360" class="borderbottom">镜头类别</th>
                    <th width="38" class="borderbottom text-right">数量</th>
                </tr>
                <tr>
                    <td>A、CG怪兽及互动镜头</td>
                    <td class="text-right">293</td>
                </tr>
                <tr>
                    <td>B、全CG镜头及其它三维镜头</td>
                    <td class="text-right">14</td>
                </tr>
                <tr>
                    <td>C、数字背景及合成镜头</td>
                    <td class="text-right">30</td>
                </tr>
                <tr>
                    <td>D、绿幕合成镜头</td>
                    <td class="text-right">37</td>
                </tr>
                <tr>
                    <td>E、擦除镜头</td>
                    <td class="text-right">48</td>
                </tr>
                <tr>
                    <td class="borderbottom">F、简单合成镜头</td>
                    <td class="borderbottom text-right">11</td>
                </tr>
                <tr>
                    <td >合计：</td>
                    <td class=" text-right">433</td>
                </tr>
            </table>
            <p class="indent0 mt20">
                依据粗剪成片统计，全片涉及特效的场次总时长约45分钟。
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