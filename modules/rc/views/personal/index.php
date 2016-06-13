<?php
use app\widgets\Personal\PersonalWidget;

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>人才库个人首页</title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit"/>
    <!--reset.css  header.css  footer.css-->
    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css"/>
    <!--css-->
    <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/libs/bootstrap/3.3.5/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="/css/rc_index.css">
    <!--jquery-->
    <script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!--cookie domain-->
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
    <style>
        .personal-banner-control ul li a img {
            width: 85px;
            height: 105px;
        }
        .personal-banner-graphic li a img {
            width: 200px;
            height: 266px;
        }
        .personal-talent-together .talent-together-bg img {
            width: 267px;
            height: 82px;
        }
        .personal-weekly-top img{
            width:913px;
            height:185px;
        }
        .personal-weekly-bottom .personal-bigger img{
            width:254px;
            height:185px;
        }
        .one-portrait-bg, .two-author-portrait, .two-portrait-bg {
            z-index: 99;
        }
        .two-author-name a {
            color: #ffffff;
        }
        .two-author-name a {
            color: #ffffff;
        }

    </style>
</head>

<body class="bg-grey mw1200">
<!--header-->
<script type="text/javascript" src="http://account.vsochina.com/static/js/vsoheader.js"></script>
<?php echo $_this_obj->renderPartial('//rc/index_header'); ?>

<!--content-->
<!--banner-->
<?php
if (!empty($_widgets_list[1]))
{
    foreach ($_widgets_list[1] as $val)
    {
        echo app\widgets\personal\PersonalWidget::widget(
            [
                '_temp_file_name' => $_temp_list[$val['temp_id']]['temp_file_name'],
                '_push_info' => empty($_push_info[1][$val['widget_id']]) ? [] : $_push_info[1][$val['widget_id']],
                '_widget_id' => $val['widget_id'],
            ]
        );
    }
}
?>
<!--/banner-->

<!--main-top-->
<div class="personal personal-mainpart-top">
    <div class="personal-slide">
        <div class="hd">
            <ul></ul>
        </div>
        <div class="bd">
            <ul class="_web_ad_" ad_data="{'b_id':9, 'row_num':2, 'hide_code':'true'}">
                <li><a target="_blank" href="{link}"><img src="{img}"></a></li>
            </ul>
        </div>
    </div>
</div>
<!--/main-top-->

<!--main-right-->
<div class="personal personal-mainpart-right">
    <?php
    if (!empty($_widgets_list[2]))
    {
        foreach ($_widgets_list[2] as $val)
        {
            echo app\widgets\personal\PersonalWidget::widget(
                [
                    '_temp_file_name' => $_temp_list[$val['temp_id']]['temp_file_name'],
                    '_push_info' => empty($_push_info[2][$val['widget_id']]) ? [] : $_push_info[2][$val['widget_id']],
                    '_widget_id' => $val['widget_id'],
                ]
            );
        }
    }
    ?>
</div>
<!--/main-right-->

<!--main-left-->
<div class="personal personal-mainpart-left">
    <?php
    if (!empty($_widgets_list[3]))
    {
        foreach ($_widgets_list[3] as $val)
        {
            echo app\widgets\personal\PersonalWidget::widget(
                [
                    '_temp_file_name' => $_temp_list[$val['temp_id']]['temp_file_name'],
                    '_push_info' => empty($_push_info[3][$val['widget_id']]) ? [] : $_push_info[3][$val['widget_id']],
                    '_widget_id' => $val['widget_id'],
                ]
            );
        }
    }
    ?>
</div>
<!--main-left-->
<!--/content-->
<script type="text/javascript" src="http://static.vsochina.com/libs/jquery.lazyload/1.9.5/jquery.lazyload.js"></script>
<script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>
<script type="text/javascript" src="/js/rc_index.js"></script>
<!--footer-->
<!--add experience-->
<script type="text/javascript" src="http://account.vsochina.com/static/js/experience.js?v=1"></script>
<?php echo $_this_obj->renderPartial('//rc/index_footer'); ?>
<script type="text/javascript">
    $(function () {
        var agent = navigator.userAgent.toLowerCase();
        if (/(msie\s|trident.*rv:)([\w.]+)/.test(agent) && !!document.documentMode) {
            $(".personal-talent-list li:nth-child(even)").css("background-color", "#edf0f3");
            $(".personal-banner-bg").removeClass('personal-blur').addClass('personal-static');
        }
        $('.personal-banner-control .control-unit').Tab({
            action: "hover",
            container: ".personal-banner-graphic li",
            className: "active",
            tabSwitch: function (mythis, index, container, className) {
                var _this = $(mythis);
                if (!_this.hasClass(className)) {
                    var _objs = $(container),
                        _obj = _objs.eq(index),
                        _bg = $(".personal-blur .personal-banner-img"),
                        _meta = $(".personal-banner-meta"),
                        imgSrc = _obj.find("img").attr("src"),
                        name = _this.attr("data-name"),
                        author = _this.attr("data-author"),
                        tag = _this.attr("data-tag").split(" "),
                        myhtml;
                    _this.addClass(className).siblings().removeClass(className);
                    _objs.stop(true, true).css({"display": "none", "opacity": "0", "margin-right": "-40px"});
                    _meta.find("h3 span").html(name);
                    _meta.find('h4 span').html(author);
                    if (tag.length > 0) {
                        myhtml = tag[0];
                        for (var i = 1; i < tag.length; i++) {
                            myhtml += ('<i class="icon-dot"></i>' + tag[i]);
                        }
                        _meta.find('h5').html(myhtml);
                    }
                    if (_bg.length > 0) {
                        imgSrc = "url(" + imgSrc + ")";
                        _bg.stop(true).css("opacity", "0");
                        setTimeout(function () {
                            _bg.stop(true).css("background-image", imgSrc).animate({'opacity': '1'}, 100);
                        }, 100);
                    }
                    _obj.stop(true, true).show().animate({"opacity": "1", "margin-right": "0"}, 100);
                }
            },
            tabSwitchClose: function (mythis, index, container, className) {
            }
        });
        $(".personal-banner-control .control-unit").eq(0).trigger('mouseover');
        var _slideObj = $(".personal-slide"),
            num = _slideObj.find(".bd ul li").length;
        if (num > 1) {
            _slideObj.find(".hd").show();
            _slideObj.slide({
                mainCell: ".bd ul",
                vis: 1,
                scroll: 1,
                autoPlay: true,
                effect: "leftLoop",
                easing: "swing",
                mouseOverStop: true,
                trigger: 'click',
                titCell: ".hd ul",
                autoPage: true
            });
        }
    });
</script>
</body>
</html>