<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>创客空间makerspace-我有梦想我要入驻-蓝海创意云</title>
    <meta name="keywords" content="创客空间, makerspace,设计梦想"/>
    <meta name="description" content="我有梦想我要入驻创客空间makerspace,我们是一群普通的设计小青年,却有着不平凡的设计梦想.创客空间makerspace热门项目,数十位行业大师倾力推介."/>
    <meta name="renderer" content="webkit"/>
    <meta name="baidu-site-verification" content="NpzvG27pvo" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css" />
    <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/font/userWork/font.css" />

    <link type="text/css" rel="stylesheet" href="/css/dreamSpace.css" />
    <script type="text/javascript" charset="utf-8" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
</head>
<body>
<!--header-top-->
<script type="text/javascript" charset="utf-8" src="http://account.vsochina.com/static/js/vsoheader.js"></script>
<!--/header-top-->
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/header.php') ?>
<!--banner-->
<div class="autoheight">
    <div class="ds-table">
    <div class="ds-1200">
        <div class="ds-half ds-half-left">
            <?php if ($talent_exist) :?>
                <p class="font36" style="color:#00cc97;">您已成功入驻</p>
                <p class="font16">
                    您已完成以下三步验证，快与志同道合的小伙伴一起，
                    <br>
                    实现文创梦想，赢取百万奖金吧！
                </p>
            <?php else:?>
                <p class="font36">欢迎创客  · 伙伴入驻</p>
                <p class="font16">
                    完成以下三步验证，入驻创客空间，与志同道合的小伙伴一起，
                    <br>
                    实现文创梦想，赢取百万奖金
                </p>
            <?php endif;?>
        </div>
        <div class="ds-half">
            <div class="ds-process">
                <div class="ds-process-step<?php if (!empty($username)):?> finish<?php endif; ?>">
                    <em class="dotted-green"></em>
                    <div class="ds-process-btn-box">
                        <?php if(empty($username)):?>
                            <a href="http://www.vsochina.com/index.php?do=prom&u=34885&p=reg" class="ds-btn ds-process-btn"> 注册</a>
                        <?php else: ?>
                            <a href="javascript:;" class="ds-btn ds-process-btn"> 注册</a>
                        <?php endif; ?>
                    </div>
                    <?php if(empty($username)):?>
                        <span class="ds-process-tip tip-before"><i class="ds-icon-20 ds-icon-tip"></i><b>*</b> 请完善信息</span>
                    <?php else: ?>
                        <span class="ds-process-tip tip-after"><i class="ds-icon-20 ds-icon-tip"></i><b>*</b> 信息已完善</span>
                    <?php endif; ?>
                </div>
                <div class="ds-process-step<?php if ($real_auth):?> finish<?php endif; ?>">
                    <em class="dotted-green"></em>
                    <div class="ds-process-btn-box">
                        <a target="_blank" href="http://account.vsochina.com/auth/realname" class="ds-btn ds-process-btn"> 实名认证</a>
                    </div>
                    <?php if(!$real_auth):?>
                        <span class="ds-process-tip tip-before"><i class="ds-icon-20 ds-icon-tip"></i><b>*</b> 请完善信息</span>
                    <?php else: ?>
                        <span class="ds-process-tip tip-after"><i class="ds-icon-20 ds-icon-tip"></i><b>*</b> 信息已完善</span>
                    <?php endif; ?>
                </div>
                <div class="ds-process-step<?php if ($has_work):?> finish<?php endif; ?>">
                    <em class="dotted-green"></em>
                    <div class="ds-process-btn-box">
                        <?php if(empty($username)):?>
                            <a href=javascript:;" class="ds-btn ds-process-btn"> 上传作品</a>
                        <?php else: ?>
                            <a target="_blank" href="http://www.vsochina.com/index.php?do=ucenter&view=accountcenter&op=manage_work" class="ds-btn ds-process-btn"> 上传作品</a>
                        <?php endif; ?>
                    </div>
                    <?php if(!$has_work):?>
                        <span class="ds-process-tip tip-before"><i class="ds-icon-20 ds-icon-tip"></i><b>*</b> 请完善信息</span>
                    <?php else: ?>
                        <span class="ds-process-tip tip-after"><i class="ds-icon-20 ds-icon-tip"></i><b>*</b> 信息已完善</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <br class="clear">
        <img src="/images/ds-banner.jpg" alt="">
    </div>
    </div>
</div>
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/footer.php') ?>
<!--/banner-->
<script type="text/javascript" src="http://static.vsochina.com/libs/jquery.lazyload/1.9.5/jquery.lazyload.js"></script>
<script type="text/javascript" src="/js/dreamSpace.js"></script>
<script type="text/javascript">
    function talent_join() {
        var username = getCookie('vso_uname');
        if (username == '') {
            alert("登录后才能进行此操作");
            return false;
        }
        $.ajax({
            type: "POST",
            dataType: "json",
            async: false,
            data: {
                'real_auth': "<?= $real_auth ?>",
                'has_work': "<?= $has_work ?>"
            },
            url: "/talent/default/join",
            success: function (json) {
                if (json.result) {
                    window.location.reload();
                }
                else {
                    alert(json.msg);
                }
            }
        });
    }
</script>
</body>
</html>