<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>人才库企业入驻</title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit" />
    <!--reset.css  header.css  footer.css-->
    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css" />
    <!--css-->
    <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/libs/bootstrap/3.3.5/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="/css/rc_index.css">
    <link type="text/css" rel="stylesheet" href="/css/recruiting.css" />
    <!--jquery-->
    <script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!--cookie domain-->
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
</head>

<body class="bg-darkgrey mw1200">
    <!--header-->
    <script type="text/javascript" src="http://account.vsochina.com/static/js/vsoheader.js"></script>
    <?php echo $_this_obj->renderPartial('//rc/index_header'); ?>
    <!--/header-->

    <!--banner-->
    <div class="enter-banner">
        <img src="/images/rc/enter-demo1.jpg">
    </div>
    <!--/banner-->

    <div class="recruitingbox">
        <div class="recruiting-info">
            <p class="fs16 color1">“蓝海创意云人才库”是中国第一家专业的文创人才储蓄平台</p>
            <p class="mt25 ml10 color2">平台汇聚文创行业最顶尖的企业、工作室和个人。其严格的审核制度，保证了入驻用户基本信息和作品案例展示的真实、准确。通过这些详实的个人信息、图片、视频和音乐等多媒体作品，将用户的行业技能优势淋漓尽致的展示出来，为项目雇佣、人才交流提供了方便的渠道。 同时，蓝海创意云经验丰富的团队，以专业的角度为用户提供全方位的包装推广服务，让专业人才获得更加专业、安全、便捷的行业发展机会。</p>
            <div style="float: left; margin-bottom: 55px;">
            <p class="mt60 ml10 fs16 color1">加入我们，您将有机会获得以下特权：</p>
            <p class="mt25"><span class="color1">·【专业展示】</span>专业、全面的人才展示</p>
            <p class="mt16"><span class="color1">·【官方认证】</span>行业权威的资料真实性认证</p>
            <p class="mt16"><span class="color1">·【全面包装】</span>为人才量身定制的包装和推广服务</p>
            <p class="mt16"><span class="color1">·【精准推送】</span>定向、精准的机会推介</p>
            <p class="mt16"><span class="color1">·【制片管理】</span>蓝海创意云专业的制片管理团队会为您和您的项目提供专业的制片管理服务</p>
            <p class="mt16"><span class="color1">·【个性空间】</span>所有入驻人才都可以免费开通高度个性化的人才空间</p>
            <p class="mt16"><span class="color1">·【行业交流】</span>安全、便捷、有效的行业沟通平台，交友工作两不误</p>
            <p class="mt16"><span class="color1">·【排名座次】</span>同行业排行榜，准确了解您在行业中的地位</p>
            </div>
            <div class="vsobanner">
                <img src="/images/rc/personchkin.jpg" />
            </div>
            <div class="btnbox">
                <a href="javascript:void(0)" class="checked-btn fs16" id="enterprise"><i class="enterprise"></i>企业入驻</a>
                <a href="javascript:void(0)" class="checked-btn fs16" id="personal" style="margin-left: 35px;"><i class="person"></i>个人入驻</a>
            </div>

        </div>
    </div>

    <script type="text/javascript" src="http://static.vsochina.com/libs/jquery.lazyload/1.9.5/jquery.lazyload.js"></script>
    <script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>
    <script type="text/javascript" src="/js/dreamSpace.js"></script>
    <script type="text/javascript" src="/js/rc_index.js"></script>
    <!--footer-->
    <script type="text/javascript" src="http://account.vsochina.com/static/js/vsofooter.js"></script>
    <!--add experience-->
    <script type="text/javascript" src="http://account.vsochina.com/static/js/experience.js?v=1"></script>
    <div style="display: none;">
        <!--
            <script type="text/javascript" charset="utf-8" src="http://account.vsochina.com/static/js/global_statistics.js"></script>
        -->
    <div>
        <script>
            $(function(){
                $("#enterprise").click(function(){
                    $.ajax({
                        url: "<?=yii::$app->params['rc_frontendurl']?>/rc/recruit/register",
                        dataType:'json',
                        success: function(data){
                            switch(data.ret)
                            {
                                case 9003://未登录
                                    window.location.href='<?=yii::$app->params['loginUrl']?>';
                                    break;
                                case 14000://入驻成功
                                    alert('您已经是入驻会员了');
                                    setTimeout(window.location.href='<?=yii::$app->params['rc_frontendurl']?>/talent/<?=$vso_uname?>',3000);
                                    break;
                                case 13837:
                                    window.location.href='<?=yii::$app->params['rc_frontendurl']?>/rc/recruit/enterprise';
                                    break;
                                case 13840:
                                    alert('入驻申请提交成功,信息正在审核中,请耐心等待');
                                    break;
                                case 13839:
                                    alert('您提交的入驻申请因为资料有误而失败,您可以<a href="<?=yii::$app->params['rc_frontendurl']?>/rc/recruit/enterprise">点击这里</a>重新申请');
                                    break;
                                case 13841:
                                    alert(data.message);
                                    break;
                                default:
                                    alert('您提交的入驻申请因为资料有误而失败,您可以<a href="<?=yii::$app->params['rc_frontendurl']?>/rc/recruit/enterprise">点击这里</a>重新申请');
                                    break;
                            }
                        },
                        error: function() {
                            alert('系统繁忙,请稍候重试');
                          },
                    });
                });

                $("#personal").click(function(){
                    $.ajax({
                        url: "<?=yii::$app->params['rc_frontendurl']?>/rc/recruit/apply",
                        dataType:'json',
                        success: function(data){
                            switch(data.ret)
                            {
                                case 9003://未登录
                                    window.location.href='<?=yii::$app->params['loginUrl']?>';
                                    break;
                                case 14000://入驻成功
                                    alert('您已经是入驻会员了');
                                    setTimeout(window.location.href='<?=yii::$app->params['rc_frontendurl']?>/talent/<?=$vso_uname?>',3000);
                                    break;
                                case 13837:
                                    window.location.href='<?=yii::$app->params['rc_frontendurl']?>/rc/recruit/personal';
                                    break;
                                case 13840:
                                    alert('入驻申请提交成功,信息正在审核中,请耐心等待');
                                    break;
                                case 13841:
                                    alert('您已经申请了企业入驻,不能再申请个人入驻了');
                                    break;
                                case 13839:
                                    alert('您提交的入驻申请因为资料有误而失败,您可以<a href="<?=yii::$app->params['rc_frontendurl']?>/rc/recruit/personal">点击这里</a>重新申请');
                                    break;
                                default:
                                    alert('您提交的入驻申请因为资料有误而失败,您可以<a href="<?=yii::$app->params['rc_frontendurl']?>/rc/recruit/personal">点击这里</a>重新申请');
                                    break;
                            }
                        },
                        error: function() {
                            alert('系统繁忙,请稍候重试');
                          },
                    });
                });
            });
        </script>
<?php echo $_this_obj->renderPartial('//rc/index_footer'); ?>
</body>

</html>