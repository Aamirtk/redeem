<?php
use yii;
use yii\helpers\Html;
use yii\helpers\Url;
?>
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
    <script type="text/javascript" src="http://static.vsochina.com/libs/iScroll/5.1.1/iscroll-probe.min.js"></script>
    <!--cookie domain-->
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
    <script type="text/javascript">
        var _WORKDETAIL_URL = '<?= yii::$app->urlManager->createUrl("enterprise/work/detail");?>';
        var _USERNAME = '<?= $username ?>';
        var _MAXPAGE = 2;
        var _PAGE = 1;
    </script>
    <script type="text/javascript" src="/js/enterprise/m_enterprise.js"></script>
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


<body onload="loaded()">
    <!--content-->
    <!--nav-->
    <div class="me-nav me-detail-nav clearfix maxw-750">
        <a href="javascript:void(0);" onclick="history.go(-1);" class="me-nav-back"><i class="icon-20 icon-20-back"></i></a>
        <div class="me-nav-option">
            <a href="javascript:void(0);" class="me-nav-opbtn"><i class="icon-20 icon-20-option"></i></a>
            <div class="me-nav-opcontent">
                <i class="me-nav-triangle"></i>
                <ul>
                    <li><a href="/enterprise/default/index/<?= $username?>">企业首页</a></li>
                    <li><a href="/enterprise/work/list/<?= $username?>">案例展示</a></li>
<!--                    <li><a href="javascript:void(0);">交易评价</a></li>-->
<!--                    <li><a href="javascript:void(0);">交易记录</a></li>-->
                </ul>
            </div>
        </div>
        <p class="me-nav-title">案例展示</p>
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
            <dd class="me-head-name"><?= $name ?></dd>
            <dd class="me-head-desc">
                <span class="head-desc-block">
                    <?php foreach($industryList as $key => $p):?>
                        <?= $p['industry']['name']?>
                        <?php if($key<count($industryList)-1):?>
                            <i class="me-dot"></i>
                        <?php endif ?>
                    <?php endforeach;?>
                </span>
            </dd>
        </dl>
    </div>
    <!--/head-->
    <!--案例展示-->
    <div class="me-part me-list-part me-part-caseshow maxw-750">
        <div class="me-part-titlebox">
            <ul class="me-list-category clearfix">
                <li class="ins_type active" id="type_0" data-type="0"><a href="javascript:;">所有分类</a></li>
                <?php foreach($industryList as $key => $p):?>
                    <li class="ins_type" id="type_<?= $p['industry']['id']?>" data-type="<?= $p['industry']['id']?>">
                        <a href="javascript:;"><?= $p['industry']['name']?></a>
                        <input type="hidden" id="ptype_<?= $p['industry']['id']?>" value="<?= $p['industry']['name']?>" />
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="me-part-contentbox" id="caseshow_wrapper">
            <ul class="part-caseshow-list clearfix">
            </ul>
        </div>
    </div>
    <!--/案例展示-->
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

    <script type="text/javascript">
        var myScroll;
        function loaded () {
            setTimeout(function(){
                myScroll = new IScroll('#caseshow_wrapper', {
                    tap: true,
                    probeType: 2
                });
                myScroll.on("scroll", function() {
                    var y = this.y,
                    maxY = this.maxScrollY;

                    //上拉时加载数据
                    if(y >= 40&&_PAGE>1)
                    {
                        _PAGE = _PAGE-1;
                        ment_ctl.username = _USERNAME;
                        ment_ctl.page = _PAGE;
                        ment_ctl.getList();
                        onCompletion(this, _list, wid, ratio);
                        return;
                    }

                    //下拉时加载数据
                    if(y <= (maxY - 40)&&_PAGE<_MAXPAGE)
                    {
                        _PAGE = _PAGE+1;
                        ment_ctl.username = _USERNAME;
                        ment_ctl.page = _PAGE;
                        ment_ctl.getList();
                        onCompletion(this, _list, wid, ratio);
                        return;
                    }
                });
            }, 500);
        }
        function onCompletion(myScroll, _list, wid, ratio)
        {
            setTimeout(function(){
                myScroll.refresh();
            }, 500);
        }

        $(function(){
            $(document).on('tap', '#caseshow_wrapper a', function(event) {
                window.location.href = $(this).attr('href');
            });
            $('#caseshow_wrapper').height($(window).height() - $('.me-head').outerHeight() - $(".me-part-titlebox").outerHeight() - 102);

            var _box = $('.part-intro-contentbox'),
                _para = _box.find('.part-intro-content'),
                ph = _para.outerHeight(),
                bh = _box.outerHeight();
            if(ph > bh)
            {
                _box.next('.part-intro-slide').css('display', 'block');
            }
            $('.part-intro-slide').on('click', function(event) {
                var _this = $(this),
                    _par = _this.parent('.me-part-contentbox');
                if(_par.hasClass('down'))
                {
                    _box.css('height', ph);
                    _par.removeClass('down').addClass('up');
                }
                else if(_par.hasClass('up'))
                {
                    _box.css('height', bh);
                    _par.removeClass('up').addClass('down');
                }
            });

            //
            $(".ins_type").click(function(){
                var type = $(this).attr("data-type");
                ment_ctl.type = type;
                ment_ctl.page = 1;
                ment_ctl.getList();
                setTimeout(function(){
                    myScroll.refresh();
                }, 500);
            });

            //获取初始数据
            ment_ctl.username = _USERNAME;
            ment_ctl.page = _PAGE;
            ment_ctl.getList();
        });
    </script>
</body>

</html>