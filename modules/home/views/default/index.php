<!DOCTYPE html>
<?php
$site = \backend\modules\content\models\Site::find()->limit(1)->one();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?= $page_config['site_name'] ?></title>
    <meta name="keywords" content="<?= $page_config['seo_keywords'] ?>"/>
    <meta name="description" content="<?= $page_config['seo_desc'] ?>"/>
    <meta name="renderer" content="webkit"/>
    <meta name="baidu-site-verification" content="NpzvG27pvo" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.3.5/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css" />
    <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/font/userWork/font.css" />
    <script type="text/javascript" charset="utf-8" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
</head>
<body>
<script type="text/javascript" src="http://account.vsochina.com/static/js/jquery.validate.js"></script>
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_header.php')?>
<!--banner-->
<?php if (!empty($banners)):?>
<div class="dsn-banner">
    <ul class="rslides">
        <!--
        <li>
            <a style="cursor: auto;"><img src="/images/home/banner-1.jpg" alt=""></a>
            <div class="dsn-banner-info">
                <p class="font36">创意空间 · 专注文创项目孵化</p>
                <p class="font16">项目企划 协同创作 推广宣发一站式孵化平台</p>
            </div>
        </li>
        -->
        <?php $banners = $this->context->banners ;?>
        <?php foreach ($banners as $k => $v):?>
            <?php if ($v['obj_type']=='home'):?>
            <li>
                <a target="_blank" href="<?php if (isset($v['link']) && !empty($v['link'])): ?><?= $v['link'] ?><?php endif;?>">
                    <?php if (isset($v['img']) && !empty($v['img'])): ?>
                    <img src="<?= $v['img'] ?>" alt="<?php if (isset($v['alt']) && !empty($v['alt'])): ?><?= $v['alt'] ?><?php endif;?>">
                    <?php endif;?>
                </a>
            </li>
            <?php endif;?>
        <?php endforeach;?>
    </ul>
    <!--
    <div class="dsn-banner-search-box">
        <div class="dsn-banner-drop">
            <span>选择项目类型</span>
            <ul class="dsn-banner-drop-ul">
                <li><a href="javascript:;">动漫</a></li>
                <li><a href="javascript:;">影视</a></li>
                <li><a href="javascript:;">游戏</a></li>
                <li><a href="javascript:;">小说</a></li>
                <li><a href="javascript:;">设计</a></li>
                <li><a href="javascript:;">其他</a></li>
            </ul>
        </div>
        <div class="dsn-banner-search">
            <input type="text" placeholder="搜索项目关键词……">
            <button>GO</button>
        </div>
    </div>
    -->
</div>
<?php endif;?>
<!--/banner-->
<!--dsn-num-->
<div class="dsn-num clearfix">
    <div class="ds-1200">
        <div class="col-xs-4">
            <dl class="dsn-num-dl">
                <dd class="dsn-num-btn-txt">一站式为你解决文创项目创业中的资金、人才、推广等难题，打造文创行业最可靠的在线众创空间。</dd>
                <dd class="dsn-num-btn-dd"><a href="/project/default/create" class="dsn-num-btn" target="_blank">项目入驻</a></dd>
            </dl>
        </div>
        <div class="col-xs-4">
            <dl class="dsn-num-dl">
                <dd class="dsn-num-btn-txt">为文创企业提供超乎想象的在线协同创作体验，在线即可使用多款设计软件、实时预览设计效果。</dd>
                <dd class="dsn-num-btn-dd"><a href="http://rc.vsochina.com/rc/recruit/enterprise" class="dsn-num-btn" target="_blank">企业入驻</a></dd>
            </dl>
        </div>
        <div class="col-xs-4">
            <dl class="dsn-num-dl">
                <dd class="dsn-num-btn-txt">发现全国各地文创项目，携手五湖四海创作人才，共筑优秀项目创作之家，开启梦想征途美妙乐章。</dd>
                <dd class="dsn-num-btn-dd dsn-login-before" style="padding-left: 0;"><a href="http://rc.vsochina.com/rc/recruit/personal" class="dsn-num-btn">个人入驻</a></dd>
                <dd class="dsn-num-btn-dd dsn-login-after" style="padding-left: 0;"><a  class="dsn-num-btn dsn-num-graybtn">已加入</a></dd>
            </dl>
        </div>
    </div>
</div>
<!--/dsn-num-->
<!--新首页热门项目-->
<div class="dsn-activity clearfix">
    <div class="dsn-hotproject">
        <h2 class="dsn-head">
            <i class="dsn-icon-head"></i>
            热门项目
        </h2>
        <div class="dsn-hotproject-slidebox clearfix">
            <div class="dsn-hotproject-slidecontent col-xs-10">
                <?php foreach($hot_projs_top5 as $hot):?>
                    <dl class="hotproject-slidecontent-item">
                        <dt class="pull-left">
                            <a target="_blank" href="http://maker.vsochina.com/project/<?= $hot['proj_id']?>">
                                <img src="<?= $hot['img']?>">
                            </a>
                        </dt>
                        <dd class="dsn-hotproject-title"><a target="_blank" href="http://maker.vsochina.com/project/<?= $hot['proj_id']?>" class="pull-right">+MORE</a><a href="http://maker.vsochina.com/project/<?= $hot['proj_id']?>" target="_blank">
                                <?= $hot['title']?>
                            </a></dd>
                        <dd class="dsn-hotproject-subtitle"><?= $hot['subtitle']?></dd>
                        <dd class="dsn-hotproject-desc">
                            <?= $hot['content']?>
                        </dd>
                        <dd class="dsn-hotproject-info clearfix">
                            <i class="icon-24 icon-24-dingwei"></i>
                            <span class="ds-w-dingwei"><?= $hot['address']?></span>
                            <i class="icon-24 icon-24-tag"></i>
                            <span class="ds-w-shijian"><?= $hot['tag']?></span>
                            <i class="icon-24 icon-24-shijian"></i>
                            <span>进行中</span>
                        </dd>
                    </dl>
                <?endforeach;?>
            </div>
            <div class="dsn-hotproject-slidenav col-xs-2">
                <div class="hotproject-slidebar">
                    <a href="javascript:void(0);"></a>
                </div>
                <ul class="dsn-hotproject-navlist">
                    <li class="active">
                        <a href="javascript:void(0);">动漫</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">影视</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">游戏</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">音乐</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">小说</a>
                    </li>
                    <!--<li>
                        <a href="javascript:void(0);">其他</a>
                    </li>-->
                </ul>
            </div>
        </div>
    </div>
</div>
<!--/新首页热门项目-->
<!--incubating project-->
<!-- 孵化中的项目-->
<div class="dsn-activity dsn-bggray clearfix">
    <div class="ds-1200">
        <div class="dsn-project-left">
            <h2 class="dsn-head">
                <i class="dsn-icon-head"></i>
                孵化中的项目
                <div class="site-choice">
                    <a target="_blank" href="http://maker.vsochina.com/project/default/list">+MORE</a>
                </div>
            </h2>
            <?php foreach($all_projs as $v):?>
                <div class="dsn-probox">
                    <div class="dsn-brief">
                        <a target="_blank" href="/project/<?= $v['proj_id'] ?>">
                            <img src="<?= $v['project']['proj_icon'] ?>" width="294" height="170"/>
                            <?php
                                $indusName = "";
                                if(isset($v['index_title']) && !empty($v['index_title']))
                                {
                                    //若存在首页项目名称，则使用，否则使用【行业名称】《项目名》
                                    $indusName = $v['index_title'];
                                }
                                else
                                {
                                    //若行业名称不为空
                                    if(isset($v['indus']) && isset($v['indus']['name']) && !empty($v['indus']['name']))
                                    {
                                        $indusName = "【" . $v['indus']['name'] . "】" . "《" . $v['project']['proj_name'] . "》";
                                    }
                                    else
                                    {
                                        $indusName = "《" . $v['project']['proj_name'] . "》";
                                    }
                                }
                            ?>
                            <p class="dsn-para"><?= $indusName ?></p>
                        </a>
                    </div>
                    <ul class="font14 fc-common">
                        <li class="pro-detail">
                            <?php
                                //全是中文则18个字符，否则12个字符
                                $subLen = preg_match("/^[\x7f-\xff]+$/", $v['user']['nickname']) ? 18 : 12;
                            ?>
                            <a <?php if ($v['username']):?> target="_blank" href="/talent/<?= $v['username'] ?>" title="<?= $v['user']['nickname'] ?>" <?php endif;?>>
                                <img src="<?= $v['user']['avatar'] ?>" />
                                <span class="fc-gray"><?= strlen($v['user']['nickname']) < $subLen ? $v['user']['nickname'] : substr($v['user']['nickname'], 0, $subLen).'..'; ?></span>
                            </a>
                            <b class="division-line"></b>
                        </li>
                        <li class="pro-detail">
                            <span class="fc-blue fwb"><?= $v['fans_num'] ?></span>
                            <span class="fc-gray">支持人数</span>
                            <b class="division-line"></b>
                        </li>
                        <li class="pro-detail">
                            <span class="fc-blue fwb">进行中</span>
                            <span class="fc-gray">项目状态</span>
                        </li>
                    </ul>
                </div>
            <?php endforeach;?>
        </div>

        <?php if (!empty($hot_projs)) :?>
        <div class="dsn-project-right">
            <h2 class="dsn-head">
                <i class="dsn-icon-head"></i>
                项目排行榜
            </h2>
            <div class="dsn-prorank">
                <ul>
                    <?php foreach($hot_projs as $k => $v):?>
                        <?php if ($k == 0):?>
                        <li class="first">
                            <a target="_blank" href="/project/<?= $v['proj_id'] ?>" class="prorank-img">
                                <img src="<?= $v['proj_icon'] ?>" alt="">
                                <div class="bg-ranknum"><span class="ranknum"><?= sprintf('%02d',$k+1) ?></span></div>
                            </a>
                            <div class="intruduce">
                                <a target="_blank" href="/project/<?= $v['proj_id'] ?>">
                                    <p class="rank-title" title="《<?= $v['proj_name'] ?>》">《<?= $v['proj_name'] ?>》</p>
                                </a>
                                <a target="_blank" href="/talent/<?= $v['username'] ?>">
                                    <p style="color:#d0d0d3;" title="项目方：<?= $v['user']['nickname'] ?>">项目方：<?= $v['user']['nickname'] ?></p>
                                </a>
                                <p class="fc-lightgreen" title="<?= $v['fans_num'] ?>人支持"><?= $v['fans_num'] ?>人支持</p>
                            </div>
                        </li>
                        <?php else:?>
                        <li>
                            <a target="_blank" href="/project/<?= $v['proj_id'] ?>"><?= sprintf('%02d',$k+1) ?>
                                <span class="font12 fc-topic ml10" title="《<?= $v['proj_name'] ?>》">《<?= $v['proj_name'] ?>》</span>
                                <span class="font12 pull-right" title="<?= $v['fans_num'] ?>人支持"><?= $v['fans_num'] ?>人支持</span>
                            </a>
                        </li>
                        <?php endif;?>
                    <?php endforeach;?>
                    <li class="clearfix">
                        <a class="dsn-prorank-link" href="http://maker.vsochina.com/project/default/list" target="_blank">查看更多》</a>
                    </li>
                </ul>
            </div>
        </div>
        <?php endif;?>
    </div>
    <div style="clear: both;"></div>
</div>
<!--/未孵化项目-->
<!--近期活动-->
<div class="dsn-activity dsn-bgwhite clearfix">
    <div class="ds-1200">
        <h2 class="dsn-head">
            <i class="dsn-icon-head"></i>
            近期活动
            <div class="site-choice dsn-actbrief-link" >
                <a class="dsn-site-default">全国
                    <b class="division-line"></b>
                </a>
                <a>苏州<b class="division-line"></b></a>
                <a>北京<b class="division-line"></b></a>
                <a>上海<b class="division-line"></b></a>
                <a>广州<b class="division-line"></b></a>
                <a>香港<b class="division-line"></b></a>
                <a href="http://maker.vsochina.com/activity/default/index" target="_blank">+MORE</a>
            </div>
        </h2>
        <div class="dsn-actbrief-box-all">
            <?php $city = \backend\modules\content\models\Activity::getActivityCity()?>
            <?php foreach($activity as $k => $value):?>
                <div class="dsn-actbrief-box" <?php if ($k == 'all'):?>style="display: block;"<?php endif;?>>
                    <?php foreach($value as $v):?>
                    <div class="dsn-actbrief">
                        <a target="_blank" href="<?= $v['link']?>"><img src="<?= $v['banner']?>" /></a>
                        <div class="dsn-illustrate">
                            <a target="_blank" href="<?= $v['link']?>" class="ill-head"><?= $v['title']?></a>
                            <p class="act-intruduce"><?= $v['desc']?></p>
                            <p class="fc-purple"><?= isset($city[$v['city_id']]) ? $city[$v['city_id']] . '活动' : '';?><span class="pull-right fc-gray"><?= date('d/m/Y', $v['start_time'])?></span></p>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
            <?php endforeach;?>
        </div>
    <div style="clear: both;"></div>
</div>
</div>
<!--/近期活动-->
<!--/incubating project-->
<!--创意圈子-->
<div class="dsn-activity dsn-bggray clearfix">
    <div class="ds-1200">
        <h2 class="dsn-head">
            <i class="dsn-icon-head"></i>
            创意圈子
            <div class="site-choice">
                <a target="_blank" href="http://bbs.vsochina.com/forum-61-1.html">+MORE</a>
            </div>
        </h2>

        <?php foreach($circle as $v):?>
            <div class="col-xs-3">
                <a target="_blank" href="<?= $v['link']?>" class="dsn-circles">
                    <img src="<?= $v['banner']?>" alt="">
                    <span><?= $v['title']?></span>
                </a>
            </div>
        <?php endforeach;?>
    </div>
</div>
<!--/创意圈子-->

<?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_footer.php')?>
<script src="http://static.vsochina.com/libs/responsiveslides/responsiveslides.min.js"></script>
<script type="text/javascript" src="http://static.vsochina.com/libs/jquery.lazyload/1.9.5/jquery.lazyload.js"></script>
<script type="text/javascript" src="/js/dreamSpace.js"></script>
<script type="text/javascript">
    $(function(){
        var parameter = window.location.search,
            reg = new RegExp(/to=/),
            toClass;
        if(reg.test(parameter))
        {
            toClass = '.' + parameter.substring(4);
            if($(toClass).length !== 0)
            {
                $("body, html").animate({
                    scrollTop: $(toClass).offset().top
                }, "slow");
            }
        }

    });

    // 新首页热门项目
    $(function(){
        $(".dsn-hotproject-navlist li a").on('click', function(event) {
            var _this = $(this),
                _a = _this.closest('.dsn-hotproject-navlist').prev('.hotproject-slidebar').children('a'),
                _content = _this.closest('.dsn-hotproject-slidenav').prev('.dsn-hotproject-slidecontent'),
                _li = _this.closest('li'),
                index = _li.index();
            _a.stop(true).animate({'top': 5 + index * 39 + 'px'}, 100);
            _content.stop(true).animate({'top': - index * 223 + 'px'}, 100);
            _li.addClass('active').siblings().removeClass('active');
        });
    });

    $(".dsn-banner-drop").hover(function(){
        $(this).addClass("active");
    },function(){
        $(this).removeClass("active");
    });
    $(".dsn-banner-drop-ul a").on("click",function(){
        var text = $(this).text();
        $(".dsn-banner-drop span").text(text);
        $(".dsn-banner-drop").removeClass("active");
    });
    /*轮播图*/
    $(".rslides").responsiveSlides({
        auto: true,             // Boolean: 设置是否自动播放, true or false
        speed: 500,            // Integer: 动画持续时间，单位毫秒
        timeout: 4000,          // Integer: 图片之间切换的时间，单位毫秒
        pager: false,           // Boolean: 是否显示页码, true or false
        nav: false,             // Boolean: 是否显示左右导航箭头（即上翻下翻）, true or false
        random: false,          // Boolean: 随机幻灯片顺序, true or false
        pause: false,           // Boolean: 鼠标悬停到幻灯上则暂停, true or false
        pauseControls: true,    // Boolean: 悬停在控制板上则暂停, true or false
        prevText: "Previous",   // String: 往前翻按钮的显示文本
        nextText: "Next",       // String: 往后翻按钮的显示文本
        maxwidth: "",           // Integer: 幻灯的最大宽度
        navContainer: "",       // Selector: Where controls should be appended to, default is after the 'ul'
        manualControls: "",     // Selector: 声明自定义分页导航
        namespace: "rslides",   // String: 修改默认的容器名称
        before: function () {
        },   // Function: 回调之前的参数
        after: function () {
        }
    });
    $(".dsn-actbrief-link a").on("click",function(){
        var index = $(this).index();
        $(this).addClass("dsn-site-default").siblings().removeClass("dsn-site-default");
        $(".dsn-actbrief-box-all .dsn-actbrief-box").eq(index).show().siblings().hide();
    })

</script>
<script type="text/javascript" charset="utf-8" src="http://static.vsochina.com/public/rightbox/vso.rightbox.js?v=4"></script>
<script type="text/javascript" src="/js/project_action.js"></script>
</body>
</html>