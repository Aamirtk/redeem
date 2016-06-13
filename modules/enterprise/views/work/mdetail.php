<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title><?= $this->context->company['name'] ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit" />
    <!--reset.css  header.css  footer.css-->
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/public/resetcss/mreset.css"/>
    <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/libs/bootstrap/3.3.5/css/bootstrap.min.css">
    <!--css-->
    <link type="text/css" rel="stylesheet" href="/css/rc_index.css">
    <link type="text/css" rel="stylesheet" href="/css/rc_mobile_enterprise.css">
    <!--jquery-->
    <script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!--cookie domain-->
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
</head>
<!-- Piwik -->
<script type="text/javascript">
    var _paq = _paq || [];
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
        var u="//analyst.vsochina.com:8080/";
        _paq.push(['setTrackerUrl', u+'piwik.php']);
        _paq.push(['setSiteId', 6]);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
    })();
</script>
<noscript><p><img src="//analyst.vsochina.com:8080/piwik.php?idsite=6" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->
<body>
    <!--content-->
    <!--nav-->
    <div class="me-nav me-detail-nav clearfix maxw-750">
        <a href="javascript:void(0);" onclick="history.go(-1);" class="me-nav-back"><i class="icon-20 icon-20-back"></i></a>
        <div class="me-nav-option">
            <a href="javascript:void(0);" class="me-nav-opbtn"><i class="icon-20 icon-20-option"></i></a>
            <div class="me-nav-opcontent">
                <i class="me-nav-triangle"></i>
                <ul>
                    <li><a href="/enterprise/default/index/<?= $this->context->company['username']?>">企业首页</a></li>
                    <li><a href="/enterprise/work/list/<?= $this->context->company['username']?>">案例展示</a></li>
<!--                    <li><a href="javascript:void(0);">交易评价</a></li>-->
<!--                    <li><a href="javascript:void(0);">交易记录</a></li>-->
                </ul>
            </div>
        </div>
        <p class="me-nav-title">案例详情</p>
    </div>
    <!--/nav-->
    <!--head-->
    <div class="me-head maxw-750">
        <dl class="clearfix">
            <?php
            $banner = $this->context->company['banner'];
            $logo = $this->context->company['logo'];
            if (empty($banner))
            {
                $banner = yii::$app->params['default_enterprise_banner'];
            }
            ?>
            <dt><img src="<?= $logo ?>"></dt>
            <dd class="me-head-name"><?= $banner = $this->context->company['name']; ?></dd>
            <dd class="me-head-desc">
                <span class="head-desc-block">
                    <span class="head-desc-key">好评</span>
                    <span><?= round($evaluation['user_rate']/5, 2)*100 ?>%</span>
                </span>
                <span class="head-desc-block">
                    <span class="head-desc-key">交易额</span>
                    &yen;<span><?= $evaluation['trans_cash'] ?></span>元
                </span>
            </dd>
        </dl>
    </div>
    <!--/head-->
    <!--intro-->
    <div class="me-intro maxw-750">
        <p class="me-intro-casename"><?= $model['work_name'] ?></p>
        <p class="me-intro-caseprice">参考价格：<span class="intro-caseprice-num">&yen;<?= $model['work_price'] ?></span></p>
        <div class="me-intro-caseimg"><img src="<?= $model['work_url'] ?>"></div>
        <p class="me-intro-caseinfo"><?= $model['content'] ?></p>
        <!-- 下面的div放富文本编辑的内容 -->
        <div class="me-intro-edit"></div>
    </div>
    <!--intro-->
    <!--操作按钮-->
    <!--<div class="me-part me-part-operate clearfix maxw-750">
        <a href="javascript:void(0);" class="part-operate-share">推荐朋友</a>
        <a href="javascript:void(0);" class="part-operate-hire">立即约稿</a>
    </div>-->
    <!--/操作按钮-->
    <!--/content-->
    <script type="text/javascript" src="http://static.vsochina.com/libs/jquery.lazyload/1.9.5/jquery.lazyload.js"></script>
    <script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>
    <script type="text/javascript" src="/js/rc_mobile.js"></script>
    <!--add experience-->
    <script type="text/javascript" src="http://account.vsochina.com/static/js/experience.js?v=1"></script>
    <div style="display: none;">
        <!--
            <script type="text/javascript" charset="utf-8" src="http://account.vsochina.com/static/js/global_statistics.js"></script>
        -->
    <div>
</body>

</html>