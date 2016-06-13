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
    <script type="text/javascript">
        var _WORKDETAIL_URL = '<?= yii::$app->urlManager->createUrl("enterprise/work/detail");?>';
    </script>
    <script type="text/javascript" src="/js/enterprise/m_enterprise.js"></script>
</head>

<body>
    <!--content-->
    <!--banner-->
    <?php
    $banner = $this->context->company['banner'];
    $logo = $this->context->company['logo'];
    if (empty($banner))
    {
        $banner = yii::$app->params['default_enterprise_banner'];
    }
    ?>
    <div class="me-banner maxw-750" style="background: url(<?= $banner ?>) #4d4d4d no-repeat center center;background-size: cover;">
        <!--nav-->
        <div class="me-nav clearfix">
            <a href="javascript:void(0);" onclick="history.go(-1);" class="me-nav-back"><i class="icon-20 icon-20-back"></i></a>
            <div class="me-nav-option">
                <a href="javascript:void(0);" class="me-nav-opbtn"><i class="icon-20 icon-20-option"></i></a>
                <div class="me-nav-opcontent">
                    <i class="me-nav-triangle"></i>
                    <ul>
                        <li><a href="/enterprise/default/index/<?= $this->context->company['username']?>">企业首页</a></li>
                        <li><a href="/enterprise/work/list/<?= $this->context->company['username']?>">案例展示</a></li>
<!--                        <li><a href="javascript:void(0);">交易评价</a></li>-->
<!--                        <li><a href="javascript:void(0);">交易记录</a></li>-->
                    </ul>
                </div>
            </div>
        </div>
        <!--/nav-->

        <div class="me-banner-logo">
            <img src="<?= $logo ?>">
        </div>
        <p class="me-banner-name"><?= $banner = $this->context->company['name']; ?></p>
        <p class="me-banner-category">
            <?php foreach($industryList as $key => $p):?>
                <?= $p['industry']['name']?>
                <?php if($key<count($industryList)-1):?>
                    <i class="me-dot"></i>
                <?php endif ?>
            <?php endforeach;?>
        </p>
    </div>
    <!--/banner-->
    <!--part-->
    <!--公司简介-->
    <div class="me-part me-part-intro maxw-750">
        <div class="me-part-titlebox">
            <span class="me-part-title">公司简介</span>
        </div>
        <div class="me-part-contentbox down">
            <div class="part-intro-contentbox">
                <div class="part-intro-content">
                    <?= $banner = $this->context->company['description']; ?>
                </div>
            </div>
            <a href="javascript:void(0);" class="part-intro-slide"><i class="icon-20 icon-slide"></i></a>
        </div>
    </div>
    <!--/公司简介-->
    <!--案例展示-->
    <div class="me-part me-part-caseshow maxw-750">
        <div class="me-part-titlebox">
            <span class="me-part-title">案例展示</span>
        </div>
        <div class="me-part-contentbox">
            <ul class="part-caseshow-list clearfix">
                <?php foreach($list as $key => $val):?>
                    <li class="col-xs-6">
                        <a href="<?= yii::$app->urlManager->createUrl("enterprise/work/detail");?>/<?= $val['id'] ?>">
                            <img src="<?= $val['work_url'] ?>">
                            <p><?= $val['work_name'] ?></p>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
            <div class="part-caseshow-morebox">
                <a href="/enterprise/work/list/<?= $banner = $this->context->company['username']?>" class="part-caseshow-morebtn">全部案例</a>
            </div>
        </div>
    </div>
    <!--/案例展示-->
    <!--操作按钮-->
<!--    <div class="me-part me-part-operate clearfix maxw-750">-->
<!--        <a href="javascript:void(0);" class="part-operate-share">推荐朋友</a>-->
<!--        <a href="javascript:void(0);" class="part-operate-hire">直接雇佣</a>-->
<!--    </div>-->
    <!--/操作按钮-->
    <!--/part-->
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
        $(function(){
            var _list = $(".part-caseshow-list"),
                _li = _list.find("li"),
                _img = _li.find("img"),
                wid = _li.eq(0).width(),
                ratio = 386 / 220;
            cutImg(_li, _img, wid, ratio);

            $(window).resize(function(event) {
                wid = _li.eq(0).width();
                cutImg(_li, _img, wid, ratio);
            });
        });

        function cutImg(_li, _img, wid, ratio){
            var _el,
                w,
                h,
                r,
                lh = parseInt(wid / ratio);
            _li.css('height', lh + 10 + 'px');
            _img.each(function(index, el) {
                _el = $(el);
                h = _el.outerHeight();
                r = wid / h;
                if(r > ratio)
                {
                    h = lh;
                    w = parseInt(h * r);
                }
                _el.css({
                    'width': w + 'px',
                    'height': h + 'px'
                });
            });
        }
    </script>
</body>

</html>