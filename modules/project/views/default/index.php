<?php
use frontend\modules\talent\models\User;
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?= $site['site_name'] ?></title>
    <meta name="keywords" content="<?= $site['seo_keywords'] ?>"/>
    <meta name="description" content="<?= $site['seo_desc'] ?>"/>
    <meta name="renderer" content="webkit"/>
    <meta name="baidu-site-verification" content="NpzvG27pvo" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css" />
    <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/font/userWork/font.css" />

    <link type="text/css" rel="stylesheet" href="/css/dreamSpace.css" />
    <link type="text/css" rel="stylesheet" href="/css/detail.css" />
    <script type="text/javascript" charset="utf-8" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
</head>
<body>
<!--header-top-->
<script type="text/javascript" charset="utf-8" src="http://account.vsochina.com/static/js/vsoheader.js"></script>
<script type="text/javascript" src="http://account.vsochina.com/static/js/jquery.validate.js"></script>
<!--/header-top-->
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/header.php')?>
<div class="ds-index-wrap">
    <!--banner-->
    <div class="ds-banner">
        <div class="ds-banner-slide specialSlide">
            <div class="hd">
                <div class="prev"><div class="slide-bg"></div><i class="triangle-left"></i></div>
                <ul></ul>
                <div class="next"><div class="slide-bg"></div><i class="triangle-right"></i></div>
            </div>
            <div class="bd">
                <ul>
                    <?php $banners = \backend\modules\content\models\Banner::getBannerList();?>
                    <?php if(count($banners)>0):?>
                        <?foreach ($banners as $k => $v):?>
                        <li>
                            <?php if($v['link']):?>
                            <div class="ds-banner-desc">
                                <p class="banner-enter-title"><a target="_blank" href="<?= $v['link']?>"><?= $v['main_title'] ?></a></p>
                                <p class="banner-enter-subtitle"><a target="_blank" href="<?= $v['link']?>"><?= $v['vice_title'] ?></a></p>
                            </div>
                            <a target="_blank" href="<?= $v['link']?>">
                                <?php if($v['img']):?>
                                <img src="<?= $v['img'] ?>" alt="<?= $v['alt'] ?>">
                                <?php endif;?>
                            </a>
                            <?php else:?>
                            <div class="ds-banner-desc">
                                <p class="banner-enter-title"><a href="javascript:;" style="cursor:inherit;"><?= $v['main_title'] ?></a></p>
                                <p class="banner-enter-subtitle"><a href="javascript:;" style="cursor:inherit;"><?= $v['vice_title'] ?></a></p>
                            </div>
                            <a href="javascript:;" style="cursor:inherit;">
                                <?php if($v['img']):?>
                                    <img src="<?= $v['img'] ?>" alt="<?= $v['alt']?>">
                                <?php endif;?>
                            </a>
                            <?php endif;?>
                        </li>
                        <?php endforeach;?>
                    <?php endif;?>
                </ul>
            </div>
        </div>
        <div class="ds-banner-enter">
            <div class="banner-enter-button">
                <div class="banner-enter-bg"></div>
                <a href="http://maker.vsochina.com/project/default/create" target="_blank">
                    申请入驻
                </a>
            </div>
        </div>
    </div>
    <!--/banner-->

    <div class="ds-project-wrap">
        <div class="project-wrap-bg"></div>
        <!--热门项目-->
        <div class="ds-hot">
            <div class="ds-1200">
                <div class="ds-hotpart-title ds-part-title" id="maker_hot_projects" name="maker_hot_projects">
                    <p>
                        <span class="font22">热门项目</span>
                        <span class="font16">HOT PROJECTS</span>
                    </p>
                    <!--
                        <p class="hotpart-title-ch">热门项目</p>
                    -->
                </div>
                <div class="ds-tab">
                    <?php if (count($hot_projs) > 0): ?>
                    <ul class="ds-tab-nav">
                        <?php foreach ($hot_projs as $k => $v): ?>
                            <li<?php if ($k==0):?> class="active"<?php endif;?>>
                                <a target="_blank" href="<?= Yii::$app->urlManager->createUrl(['/project/default/view', 'id' => $v['proj_id']])?>">
                                    <div class="ds-tab-img-bg"></div>
                                    <img src="<?= $v['proj_thumb'] ?>" alt="<?= $v['proj_name']?>" width="409" height="256">
                                    <?php if($v['is_new']):?>
                                    <p class="ds-tab-img-new"></p>
                                    <?php endif;?>
                                </a>
                            </li>
                        <? endforeach ?>
                    </ul>
                    <? endif ?>
                    <div class="tab-box">
                        <?php if (count($hot_projs) > 0): ?>
                            <?php foreach ($hot_projs as $k => $v): ?>
                                <div class="tab-content" style="display: <?php if ($k == 0): ?>block;<?php else: ?>none;<?php endif; ?>" >
                                    <div class="ds-img-box">
                                        <a target="_blank" href="<?= Yii::$app->urlManager->createUrl(['/project/default/view', 'id' => $v['proj_id']])?>">
                                            <img src="<?= $v['proj_pic'] ?>" alt="<?= $v['proj_name']?>" class="ds-img-big">
                                        </a>
                                        <div class="ds-bar">
                                            <div class="ds-bar-bg"></div>
                                            <!--<span class="ds-bar-title"><b>项目状态</b>      <i>进行中</i></span>-->
                                            <span class="ds-bar-title"><b>支持人数</b>      <i class="font30 favor_num_<?= $v['proj_id'] ?>" ><?= $v['fans_num'] ?></i><b>人</b> </span>
                                            <!--<span class="ds-bar-title"><b>项目完成度</b>    <i class="font32">95%</i></span>-->
                                        </div>
                                    </div>
                                    <div class="ds-tab-title">
                                        《<?= $v['proj_name'] ?>》
                                        <?php if ($v['user']['favor_status']):?>
                                            <a href="javascript:;" class="ds-btn ds-btn-green focused" name="project_<?= $v['proj_id']?>" value="<?= $v['proj_id']?>" onclick="remove_favor_project(this)">已关注</a>
                                        <?php else:?>
                                            <a href="javascript:;" class="ds-btn ds-btn-green" name="project_<?= $v['proj_id']?>" value="<?= $v['proj_id']?>" onclick="favor_project(this)">关注</a>
                                        <?php endif ?>
                                    </div>
                                    <p class="ds-tab-bread"><?= $v['proj_tag'] ?></p>

                                    <p class="ds-tab-txt">
                                        <?= $v['proj_short_desc'] ?>
                                    </p>

                                    <div class="ds-main-member">
                                        <span>项目主创成员</span>
                                    </div>
                                    <?php if (count($v['member_list']) > 0): ?>
                                    <div class="ds-main-member-list">
                                        <?php foreach ($v['member_list'] as $mk => $mv): ?>
                                            <dl class="ds-main-member-img">
                                                <dt>
                                                    <a<?php if ($v['username']):?> target="_blank" href="<?= yii::$app->params['user_center_url'] ?><?= $mv['username']?>.html"<?php endif;?>>
                                                        <img src="<?= $mv['avatar'] ?>" alt="<?= $mv['nickname'] ?>" width="64px" height="64px">
                                                    </a>
                                                </dt>
                                                <dd class="ds-main-member-name"><?= $mv['nickname'] ?></dd>
                                                <dd class="ds-main-member-role"><?= $mv['tag'] ?></dd>
                                            </dl>
                                        <? endforeach ?>
                                    </div>
                                    <? endif ?>
                                </div>
                            <? endforeach ?>
                        <? endif ?>
                    </div>
                </div>
            </div>
        </div>
        <!--/热门项目-->

        <!--全部项目-->
        <div class="ds-all-project">
            <div class="ds-1200">
                <div class="ds-part-title">
                    <p>
                        <span class="font22">推荐项目</span>
                        <span class="font16">RECOMMENDING PROJECTS</span>
                        <!--
                        <a href="javascript:void(0);" class="ds-part-link font-14">查看项目列表 》</a>
                        -->
                    </p>
                </div>
                <div class="ds-project-list">
                    <ul class="ds-project-ul">
                        <?php if (count($all_projs) > 0): ?>
                            <?php foreach ($all_projs as $k => $v): ?>
                                <li>
                                    <a target="_blank" href="<?= Yii::$app->urlManager->createUrl(['/project/default/view', 'id' => $v['proj_id']])?>" class="ds-project-img">
                                        <img src="<?= $v['proj_thumb'] ?>" alt="<?= $v['proj_name']?>" width="291" height="166">
                                    </a>
                                    <div class="ds-project-info">
                                        <a class="ds-project-head"<?php if ($v['username']):?> target="_blank" href="<?= yii::$app->params['user_center_url'] ?><?= $v['username']?>.html"<?php endif;?>>
                                            <?php if ($v['username']):?><img src="<?= $v['user']['avatar'] ?>" alt="<?= $v['user']['nickname'] ?>" style=""><?php endif;?>
                                        </a>
                                        <div class="ds-project-info-right">
                                            <p class="ds-project-title">
                                                <a target="_blank" href="<?= Yii::$app->urlManager->createUrl(['/project/default/view', 'id' => $v['proj_id']])?>">《<?=$v['proj_name']?>》</a>
                                            </p>
                                            <p class="ds-project-bread"><?= $v['proj_tag'] ?></p>

                                            <p class="ds-project-mark">
                                                <span><i class="ds-icon-16 icon-16-praise"></i><i class="favor_num_<?= $v['proj_id'] ?>"><?= $v['fans_num'] ?></i>人 </span>
                                                <!--<span class="w-50"><i class="ds-icon-16 icon-16-right"></i>50%</span>-->
                                                <?php if ($v['user']['favor_status']):?>
                                                    <a href="javascript:;" class="ds-btn ds-btn-green ds-btn-praise focused" name="project_<?= $v['proj_id']?>" value="<?= $v['proj_id']?>" onclick="remove_favor_project(this)">已关注</a>
                                                <?php else:?>
                                                    <a href="javascript:;" class="ds-btn ds-btn-green ds-btn-praise" name="project_<?= $v['proj_id']?>" value="<?= $v['proj_id']?>" onclick="favor_project(this)">关注</a>
                                                <?php endif ?>
                                                <br class="clear">
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            <? endforeach ?>
                        <? endif ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!--/全部项目-->
    <!--创客伙伴-->
    <div class="ds-all-friend" id="maker_all_friend" name="maker_all_friend">
        <div class="ds-1200">
            <div class="ds-part-title">
                <p>
                    <span class="font22">创客伙伴</span>
                    <span class="font16">HOT PARTNERS</span>
                </p>
            </div>
            <div class="ds-friend">
                <ul class="ds-friend-nav">
                    <li class="active">
                        <a href="javascript:;" class="btn-dark-blue active">
                            创客企业
                            <!--
                                <em class="triangle-down"></em>
                            -->
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="btn-dark-blue">
                            创客人才
                            <!--
                                <em class="triangle-down"></em>
                            -->
                        </a>
                    </li>
                </ul>

                <div class="friend-box">
                    <?php if (count($enterprise) > 0): ?>
                    <div class="friend-content" style="display:block;">
                        <ul class="friend-list">
                            <?php foreach ($enterprise as $k => $v): ?>
                                <li>
                                    <a href="<?= yii::$app->params['user_center_url'] ?><?= $v['username'] ?>.html" target="_blank">
                                        <div class="ds-friend-bg"></div>
                                        <?php if ($v['work_img']):?>
                                        <img src="<?= $v['work_img'] ?>" alt="<?= $v['work_img_alt'] ?>" class="ds-friend-img" width="210" height="310">
                                        <?php endif;?>
                                        <div class="ds-friend-bar">
                                            <img src="<?= $v['avatar'] ?>" alt="<?= $v['nickname'] ?>" class="ds-friend-head">
                                            <span class="ds-friend-text">
                                                <?= $v['nickname'] ?>
                                            </span>
                                        </div>
                                    </a>
                                </li>
                            <? endforeach ?>
                        </ul>
                    </div>
                    <? endif ?>

                    <?php if (count($individual) > 0): ?>
                    <div class="friend-content">
                        <ul class="friend-list">
                            <?php foreach ($individual as $k => $v): ?>
                                <li>
                                    <a href="<?= yii::$app->params['user_center_url'] ?><?= $v['username'] ?>.html" target="_blank">
                                        <div class="ds-friend-bg"></div>
                                        <?php if ($v['work_img']):?>
                                        <img src="<?= $v['work_img'] ?>" alt="<?= $v['work_img_alt'] ?>" class="ds-friend-img" width="210" height="310">
                                        <? endif; ?>
                                        <div class="ds-friend-bar">
                                            <img src="<?= $v['avatar'] ?>" alt="<?= $v['nickname'] ?>" class="ds-friend-head">
                                            <span class="ds-friend-text">
                                                <?= $v['nickname'] ?>
                                            </span>
                                        </div>
                                    </a>
                                </li>
                            <? endforeach ?>
                        </ul>
                    </div>
                    <? endif ?>
                </div>
                <br class="clear" />
            </div>

        <!--
             <div class="ds-join-right">
                <p class="ds-join-line"></p>
                <span class="ds-join-right-box">
                    <?php $talentExist = User::isTalentExist(); ?>
                    <?php if ($talentExist) : ?>
                        <a href="javascript:;" class="ds-btn ds-btn-green disable">您已入驻</a>
                    <?php else:?>
                        <a href="/talent/default/index" class="ds-btn ds-btn-green">立即入驻</a>
                    <?php endif;?>
                </span>
            </div>
        -->
        </div>
    </div>
    <!--/创客伙伴-->

    <div class="push-box">
        <a href="javascript:;" class="push-box-close">
            <p class="push-box-close-bg"></p>
            [ 关闭 ]
        </a>
    </div>
</div>

<script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>
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

        $(".ds-banner-slide").slide({
            mainCell: ".bd ul",
            vis: 1,
            autoPlay: true,
            effect: "leftLoop",
            easing: "swing",
            mouseOverStop: true,
            trigger: 'click',
            titCell: ".hd ul",
            autoPage: true,
            prevCell: ".prev",
            nextCell: ".next",
            startFun: function(){
                var w = $(".ds-index-wrap").width(),
                    num = $(".ds-banner-slide .bd ul li").length;
                $(".ds-banner-slide .bd ul").width(w * num).children('li').width(w);
                // $(".ds-banner-slide .bd img").each(function(index, el) {
                //     var _this = $(this),
                //         ml = -(_this.width() / 2);
                //     _this.css({
                //         "left": '50%',
                //         "margin-left": ml + 'px'
                //     });
                // });
            }
        });

        $(window).resize(function(event) {
            if($('.specialSlide').length > 0)
            {
                $('.specialSlide').each(function(index, el) {
                    var _this = $(this),
                        w = $(".ds-index-wrap").width(),
                        num = _this.find(".bd ul li").length;
                    _this.find(".bd ul").stop(true, true).css({
                        width: w * num + 'px',
                        left: '-' + w * (num / 3) + 'px'
                    }).children('li').stop(true, true).width(w);
                });
            }
        });
    });
    var idnum = 0;
    //pushShow = setInterval(pushShowFun,500);
    clearInterval(pushHide);
    //pushHide = setInterval(pushHideFun, 3000);
    $(document).on("mouseover", ".push-box .push-content", function () {
        clearInterval(pushHide);
        if ($(".push-box .push-content").length <= 1) {
            $(".push-box").stop(true).animate({"opacity": 1,"height":"80px"}, 500);
        }
        else {
            $(this).stop(true).animate({"opacity": 1,"height":"80px"}, 500);
        }
    });
    $(document).on("mouseleave", ".push-box", function () {
        clearInterval(pushHide);
        //pushHide = setInterval(pushHideFun, 3000);
    });
    $(document).on("click", ".push-content .push-close", function () {
        if ($(".push-box .push-content").length <= 1) {
            $(".push-content").remove();
            $(".push-box").hide();
        }
        else {
            $(this).parents(".push-content").remove();
        }
    });
    $(".push-box-close").on("click", function () {
        clearInterval(pushShow);
        var _this = $(this),
            _par = _this.parent(".push-box"),
            _content = _par.find(".push-content").stop(true, true);
        _par.stop(true, true).hide();
        _content.remove();
    });

    //文本框内限制字数
    $("#maxlength_input").on("keyup", function () {
        var _this = $(this);
        var _msgnum = _this.parent().next();
        var txt = _this.val();
        var len = _this.val().length;
        _msgnum.html(txt.length + "/30");
    });
</script>
<script type="text/javascript" src="/js/project_action.js"></script>
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/footer.php') ?>
</body>
</html>