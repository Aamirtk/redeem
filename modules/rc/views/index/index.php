<?php
use yii\base;
use yii\helpers\Html;
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $_page_title ?></title>
    <meta name="keywords" content="<?php echo $_page_keywords ?>"/>
    <meta name="description" content="<?php echo $_page_description ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit"/>
    <!--reset.css  header.css  footer.css-->
    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css?v=20150807"/>
    <!--css-->
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.2.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="/css/rc_index.css">
    <!--jquery-->
    <script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script src="http://static.vsochina.com/libs/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <!--cookie domain-->
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
    <style>
        img {
            display: inline-block;
        }

        .rslides li img {
            width: 1200px;
            height: 455px;
        }

        .talent-nav-last img {
            width: 143px;
            height: 29px;
        }

        .talent-classify-ad img {
            width: 244px;
            height: 150px;
        }

        .talent-fac-left a img {
            width: 293px;
            height: 183px;
        }

        .talent-fac-ul li a img {
            width: 148px;
            height: 79px;
        }

        .talent-modal-subject a img {
            width: 320px;
            height: 260px;
        }

        .recommend-imgbox img {
            width: 216px;
            height: 216px;
        }

        .talent-ad-list li a img {
            width: 130px;
            height: 90px;
        }

        .talent-step-dl dt img {
            width: 130px;
            height: 130px;
        }

        .talent-news-dl dt img {
            width: 140px;
            height: 30px;
        }

        .talent-logos-table td img {
            width: 159px;
            height: 47px;
            max-width: 175px;
            max-height: 50px;
        }

        .talent-step-dl-title i {
            overflow: hidden;
        }
    </style>
</head>
<body class="talent-gray-bg">
<!--header-->
<script type="text/javascript" src="http://account.vsochina.com/static/js/vsoheader.js"></script>

<?php echo $_this_obj->renderPartial('//rc/index_header'); ?>

<!--nav-->
<div class="talent-nav">
    <div class="m-warp">
        <ul class="clearfix">
            <?php echo _rep_tags(1, $_info, '<li class="talent-nav-first"><!--[word]--></li>'); ?>
            <?php $code = '';
            for ($i = 2; $i <= 9; $i++): ?>
                <?php $code .= _rep_tags(
                    $i,
                    $_info,
                    '<li class="<!--[active]-->"><a href="<!--[link]-->" <!--[target]-->><!--[word]--></a><b>/</b></li>'
                ); ?>
            <?php endfor;
            echo substr($code, 0, -13) . '</li>'; ?>

            <?php echo _rep_tags(
                10,
                $_info,
                '<li class="talent-nav-last"><img src="<!--[pic]-->" alt="<!--[alt]-->"></li>'
            ); ?>
        </ul>
    </div>
</div>
<!--/nav-->

<!--banner-->
<div class="talent-banner" style="position: relative; overflow: hidden;">
    <ul class="rslides">
        <?php for ($i = 11; $i <= 18; $i++): ?>
            <?php echo _rep_tags(
                $i,
                $_info,
                '<li style="background-color: <!--[bgcolor]-->;"><a href="<!--[link]-->" <!--[target]-->><img src="<!--[pic]-->" alt="<!--[alt]-->" /></a></li>'
            ); ?>
        <?php endfor; ?>
    </ul>
    <div class="m-warp">
        <!--分类-->
        <div class="talent-classify">
            <div class="talent-classify-bg"></div>
            <ul class="talent-classify-ul">
                <li>
                    <?php echo _rep_tags(10001, $_info, '<i class="icon-18 <!--[icon_class_name]-->"></i>'); ?>
                    <?php $code = '';
                    for ($i = 10002; $i <= 10005; $i++): ?>
                        <?php $code .= _rep_tags(
                            $i,
                            $_info,
                            '<a href="<!--[link]-->" <!--[target]-->><!--[word]--></a> / '
                        ); ?>
                    <?php endfor;
                    echo substr($code, 0, -3); ?>
                    <b class="talent-nav-arrow"></b>
                </li>
                <li>
                    <?php echo _rep_tags(10006, $_info, '<i class="icon-18 <!--[icon_class_name]-->"></i>'); ?>
                    <?php $code = '';
                    for ($i = 10007; $i <= 10010; $i++): ?>
                        <?php $code .= _rep_tags(
                            $i,
                            $_info,
                            '<a href="<!--[link]-->" <!--[target]-->><!--[word]--></a> / '
                        ); ?>
                    <?php endfor;
                    echo substr($code, 0, -3); ?>
                    <b class="talent-nav-arrow"></b>
                </li>
                <li>
                    <?php echo _rep_tags(10011, $_info, '<i class="icon-18 <!--[icon_class_name]-->"></i>'); ?>
                    <?php $code = '';
                    for ($i = 10012; $i <= 10015; $i++): ?>
                        <?php $code .= _rep_tags(
                            $i,
                            $_info,
                            '<a href="<!--[link]-->" <!--[target]-->><!--[word]--></a> / '
                        ); ?>
                    <?php endfor;
                    echo substr($code, 0, -3); ?>
                    <b class="talent-nav-arrow"></b>
                </li>
                <li>
                    <?php echo _rep_tags(10016, $_info, '<i class="icon-18 <!--[icon_class_name]-->"></i>'); ?>
                    <?php $code = '';
                    for ($i = 10017; $i <= 10020; $i++): ?>
                        <?php $code .= _rep_tags(
                            $i,
                            $_info,
                            '<a href="<!--[link]-->" <!--[target]-->><!--[word]--></a> / '
                        ); ?>
                    <?php endfor;
                    echo substr($code, 0, -3); ?>
                    <b class="talent-nav-arrow"></b>
                </li>
                <li>
                    <?php echo _rep_tags(10021, $_info, '<i class="icon-18 <!--[icon_class_name]-->"></i>'); ?>
                    <?php $code = '';
                    for ($i = 10022; $i <= 10025; $i++): ?>
                        <?php $code .= _rep_tags(
                            $i,
                            $_info,
                            '<a href="<!--[link]-->" <!--[target]-->><!--[word]--></a> / '
                        ); ?>
                    <?php endfor;
                    echo substr($code, 0, -3); ?>
                    <b class="talent-nav-arrow"></b>
                </li>
                <li>
                    <?php echo _rep_tags(10026, $_info, '<i class="icon-18 <!--[icon_class_name]-->"></i>'); ?>
                    <?php $code = '';
                    for ($i = 10027; $i <= 10030; $i++): ?>
                        <?php $code .= _rep_tags(
                            $i,
                            $_info,
                            '<a href="<!--[link]-->" <!--[target]-->><!--[word]--></a> / '
                        ); ?>
                    <?php endfor;
                    echo substr($code, 0, -3); ?>
                    <b class="talent-nav-arrow"></b>
                </li>
                <li>
                    <?php echo _rep_tags(10031, $_info, '<i class="icon-18 <!--[icon_class_name]-->"></i>'); ?>
                    <?php $code = '';
                    for ($i = 10032; $i <= 10035; $i++): ?>
                        <?php $code .= _rep_tags(
                            $i,
                            $_info,
                            '<a href="<!--[link]-->" <!--[target]-->><!--[word]--></a> / '
                        ); ?>
                    <?php endfor;
                    echo substr($code, 0, -3); ?>
                    <b class="talent-nav-arrow"></b>
                </li>
                <li>
                    <?php echo _rep_tags(10036, $_info, '<i class="icon-18 <!--[icon_class_name]-->"></i>'); ?>
                    <?php $code = '';
                    for ($i = 10037; $i <= 10040; $i++): ?>
                        <?php $code .= _rep_tags(
                            $i,
                            $_info,
                            '<a href="<!--[link]-->" <!--[target]-->><!--[word]--></a> / '
                        ); ?>
                    <?php endfor;
                    echo substr($code, 0, -3); ?>
                    <b class="talent-nav-arrow"></b>
                </li>
                <li>
                    <?php echo _rep_tags(10041, $_info, '<i class="icon-18 <!--[icon_class_name]-->"></i>'); ?>
                    <?php $code = '';
                    for ($i = 10042; $i <= 10045; $i++): ?>
                        <?php $code .= _rep_tags(
                            $i,
                            $_info,
                            '<a href="<!--[link]-->" <!--[target]-->><!--[word]--></a> / '
                        ); ?>
                    <?php endfor;
                    echo substr($code, 0, -3); ?>
                </li>
            </ul>
        </div>
        <!--/分类-->
        <!--分类内容-->
        <div class="talent-classify-box">
            <div class="talent-classify-content">
                <div class="talent-classify-left pull-left">
                    <?php echo _rep_tags(
                        10046,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10047; $i <= 10064; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10065,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10066; $i <= 10083; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10085,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10086; $i <= 10103; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10104,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10105; $i <= 10122; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10796,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10797; $i <= 10814; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <div class="talent-classify-right pull-right">
                    <?php echo _rep_tags(
                        10123,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10124; $i <= 10138; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php for ($i = 10139; $i <= 10140; $i++): ?>
                        <?php echo _rep_tags(
                            $i,
                            $_info,
                            '<a href="<!--[link]-->" class="talent-classify-ad" <!--[target]-->><img src="<!--[pic]-->" alt="<!--[alt]-->"></a>'
                        ); ?>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="talent-classify-content">
                <div class="talent-classify-left pull-left">
                    <?php echo _rep_tags(
                        10141,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10142; $i <= 10159; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10160,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10161; $i <= 10178; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10179,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10180; $i <= 10197; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10198,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10199; $i <= 10216; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10815,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10816; $i <= 10833; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <div class="talent-classify-right pull-right">
                    <?php echo _rep_tags(
                        10217,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10218; $i <= 10232; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <?php for ($i = 10233; $i <= 10234; $i++): ?>
                        <?php echo _rep_tags(
                            $i,
                            $_info,
                            '<a href="<!--[link]-->" class="talent-classify-ad" <!--[target]-->><img src="<!--[pic]-->" alt="<!--[alt]-->"></a>'
                        ); ?>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="talent-classify-content">
                <div class="talent-classify-left pull-left">
                    <?php echo _rep_tags(
                        10235,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10236; $i <= 10253; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10254,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10255; $i <= 10272; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10273,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10274; $i <= 10291; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10292,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10293; $i <= 10310; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10834,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10835; $i <= 10852; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <div class="talent-classify-right pull-right">
                    <?php echo _rep_tags(
                        10311,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10312; $i <= 10326; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <?php for ($i = 10327; $i <= 10328; $i++): ?>
                        <?php echo _rep_tags(
                            $i,
                            $_info,
                            '<a href="<!--[link]-->" class="talent-classify-ad" <!--[target]-->><img src="<!--[pic]-->" alt="<!--[alt]-->"></a>'
                        ); ?>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="talent-classify-content">
                <div class="talent-classify-left pull-left">
                    <?php echo _rep_tags(
                        10329,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10330; $i <= 10347; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10348,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10349; $i <= 10366; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10367,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10368; $i <= 10385; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10386,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10387; $i <= 10404; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10853,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10854; $i <= 10872; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <div class="talent-classify-right pull-right">
                    <?php echo _rep_tags(
                        10405,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10406; $i <= 10420; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <?php for ($i = 10421; $i <= 10422; $i++): ?>
                        <?php echo _rep_tags(
                            $i,
                            $_info,
                            '<a href="<!--[link]-->" class="talent-classify-ad" <!--[target]-->><img src="<!--[pic]-->" alt="<!--[alt]-->"></a>'
                        ); ?>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="talent-classify-content">
                <div class="talent-classify-left pull-left">
                    <?php echo _rep_tags(
                        10423,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10424; $i <= 10441; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10442,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10443; $i <= 10460; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10461,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10462; $i <= 10479; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10480,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10481; $i <= 10498; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10873,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10874; $i <= 10892; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <div class="talent-classify-right pull-right">
                    <?php echo _rep_tags(
                        10499,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10500; $i <= 10514; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <?php for ($i = 10515; $i <= 10516; $i++): ?>
                        <?php echo _rep_tags(
                            $i,
                            $_info,
                            '<a href="<!--[link]-->" class="talent-classify-ad" <!--[target]-->><img src="<!--[pic]-->" alt="<!--[alt]-->"></a>'
                        ); ?>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="talent-classify-content">
                <div class="talent-classify-left pull-left">
                    <?php echo _rep_tags(
                        10517,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10518; $i <= 10535; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10536,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10537; $i <= 10554; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10555,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10556; $i <= 10573; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10574,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10575; $i <= 10592; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10893,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10894; $i <= 10912; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <div class="talent-classify-right pull-right">
                    <?php echo _rep_tags(
                        10593,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10594; $i <= 10608; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <?php for ($i = 10609; $i <= 10610; $i++): ?>
                        <?php echo _rep_tags(
                            $i,
                            $_info,
                            '<a href="<!--[link]-->" class="talent-classify-ad" <!--[target]-->><img src="<!--[pic]-->" alt="<!--[alt]-->"></a>'
                        ); ?>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="talent-classify-content">
                <div class="talent-classify-left pull-left">
                    <?php echo _rep_tags(
                        10611,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10612; $i <= 10629; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10630,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10631; $i <= 10648; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10649,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10650; $i <= 10667; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10668,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10669; $i <= 10686; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10913,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10914; $i <= 10932; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <div class="talent-classify-right pull-right">
                    <?php echo _rep_tags(
                        10687,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10688; $i <= 10702; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <?php for ($i = 10703; $i <= 10704; $i++): ?>
                        <?php echo _rep_tags(
                            $i,
                            $_info,
                            '<a href="<!--[link]-->" class="talent-classify-ad" <!--[target]-->><img src="<!--[pic]-->" alt="<!--[alt]-->"></a>'
                        ); ?>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="talent-classify-content">
                <div class="talent-classify-left pull-left">
                    <?php echo _rep_tags(
                        10705,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10706; $i <= 10723; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10724,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10725; $i <= 10742; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10743,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10744; $i <= 10761; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10762,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10763; $i <= 10780; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php echo _rep_tags(
                        10933,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10934; $i <= 10952; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <div class="talent-classify-right pull-right">
                    <?php echo _rep_tags(
                        10781,
                        $_info,
                        '<p class="talent-classify-title"><b class="icon-5-black"></b><!--[word]--></p>'
                    ); ?>
                    <div class="talent-classify-tag-all clearfix">
                        <div class="talent-classify-tag">
                            <?php for ($i = 10782; $i <= 10795; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" class="<!--[active]-->" <!--[target]-->><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <?php for ($i = 10786; $i <= 10787; $i++): ?>
                        <?php echo _rep_tags(
                            $i,
                            $_info,
                            '<a href="<!--[link]-->" class="talent-classify-ad" <!--[target]-->><img src="<!--[pic]-->" alt="<!--[alt]-->"></a>'
                        ); ?>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
        <!--/分类内容-->
        <div class="_web_ad_" ad_data="{'b_id':2, 'row_num':1, 'hide_code':'true'}">
            <a href="{link}" class="talent-banner-ad" target="_blank">
                <img src="{img}" width="172" height="438"/>
            </a>
        </div>
    </div>
</div>
<!--/banner-->

<!--推荐服务商-->
<div class="talent-fac" name="more_partner" id="more_partner">
    <div class="m-warp">
        <p class="talent-fac-title">
            <?php echo _rep_tags(
                30001,
                $_info,
                '<a href="<!--[link]-->" <!--[target]--> class="pull-right"><!--[word]--></a>'
            ); ?>
            <?php echo _rep_tags(30026, $_info, '<i class="icon-20"><img src="<!--[pic]-->"></i>'); ?>
            <?php echo _rep_tags(30002, $_info, '<span class="maintitle"><!--[word]--></span>'); ?>
            <?php echo _rep_tags(30003, $_info, '<i class="subtitle"><!--[word]--></i>'); ?>
        </p>

        <div class="talent-fac-box clearfix">
            <div class="talent-fac-left pull-left">
                <?php echo _rep_tags(
                    30004,
                    $_info,
                    '<a href="<!--[link]-->" <!--[target]-->><img src="<!--[pic]-->" alt="<!--[alt]-->"></a>'
                ); ?>
                <?php echo _rep_tags(
                    30005,
                    $_info,
                    '<p class="talent-fac-name"><a <!--[target]--> href="<!--[link]-->"><!--[word]--></a></p>'
                ); ?>
                <?php echo _rep_tags(30006, $_info, '<p class="talent-fac-origin"><!--[word]--></p>'); ?>
            </div>
            <ul class="talent-fac-ul pull-right">
                <?php for ($i = 30007; $i <= 30024; $i++): ?>
                    <?php echo _rep_tags(
                        $i,
                        $_info,
                        '<li><a href="<!--[link]-->" <!--[target]-->><img src="<!--[pic]-->" alt="<!--[alt]-->"></a></li>'
                    ); ?>
                <?php endfor; ?>
            </ul>
        </div>

        <div style="height:auto;overflow: hidden" class="_web_ad_"
             ad_data="{'b_id':3, 'row_num':1, 'hide_code':'true'}"><a href="{link}"
                                                                      class="talent-banner-ad"
                                                                      target="_blank"><img
                    src="{img}" width="1200" height="90"/></a></div>
    </div>
</div>
<!--/推荐服务商-->

<?php
if (!empty($_word_group_order)):
    $key = 10;
    foreach ($_word_group_order as $val):
        echo '<label id=' . $val['temp_name'] . ' name=' . $val['temp_name'] . ' style="dispaly:none"></label>';
        echo app\widgets\work\WorkWidget::widget(['tmp_name' => $val['temp_name'], '_info' => $_info]);
    endforeach;
endif;
?>

<!--简单四步帮你寻找合适人才-->
<!--<div class="talent-step">
    <?php echo _rep_tags(20, $_info, '<p class="font22"><!--[word]--></p>'); ?>
    <?php echo _rep_tags(21, $_info, '<p><!--[word]--></p>'); ?>

    <div class="m-warp">
        <dl class="talent-step-dl">
            <?php echo _rep_tags(22, $_info, '<dt><img src="<!--[pic]-->" alt="<!--[alt]-->"></dt>'); ?>
            <dd class="talent-step-dl-title">
                <?php echo _rep_tags(
    23,
    $_info,
    '<i class="icon-42"><img src="<!--[pic]-->" /></i>'
); ?>
                <?php echo _rep_tags(24, $_info, '<span><!--[word]--></span></dd>'); ?>
            </dd>
            <?php echo _rep_tags(25, $_info, '<dd><!--[word]--></dd>'); ?>
        </dl>
        <dl class="talent-step-dl">
            <?php echo _rep_tags(26, $_info, '<dt><img src="<!--[pic]-->" alt="<!--[alt]-->"></dt>'); ?>
            <dd class="talent-step-dl-title">
                <?php echo _rep_tags(
    27,
    $_info,
    '<i class="icon-42"><img src="<!--[pic]-->" /></i>'
); ?>
                <?php echo _rep_tags(28, $_info, '<span><!--[word]--></span></dd>'); ?>
            </dd>
            <?php echo _rep_tags(29, $_info, '<dd><!--[word]--></dd>'); ?>
        </dl>
        <dl class="talent-step-dl">
            <?php echo _rep_tags(30, $_info, '<dt><img src="<!--[pic]-->" alt="<!--[alt]-->"></dt>'); ?>
            <dd class="talent-step-dl-title">
                <?php echo _rep_tags(
    31,
    $_info,
    '<i class="icon-42"><img src="<!--[pic]-->" /></i>'
); ?>
                <?php echo _rep_tags(32, $_info, '<span><!--[word]--></span></dd>'); ?>
            </dd>
            <?php echo _rep_tags(33, $_info, '<dd><!--[word]--></dd>'); ?>
        </dl>
        <dl class="talent-step-dl">
            <?php echo _rep_tags(34, $_info, '<dt><img src="<!--[pic]-->" alt="<!--[alt]-->"></dt>'); ?>
            <dd class="talent-step-dl-title">
                <?php echo _rep_tags(
    35,
    $_info,
    '<i class="icon-42"><img src="<!--[pic]-->" /></i>'
); ?>
                <?php echo _rep_tags(36, $_info, '<span><!--[word]--></span></dd>'); ?>
            </dd>
            <?php echo _rep_tags(37, $_info, '<dd><!--[word]--></dd>'); ?>
        </dl>
    </div>
</div>-->
<!--/简单四步帮你寻找合适人才-->
<!--新闻 -->
<div class="talent-news">
    <div class="m-warp">
        <dl class="talent-news-dl">
            <?php echo _rep_tags(38, $_info, '<dt><img src="<!--[pic]-->" alt="<!--[alt]-->"></dt>'); ?>
            <?php echo _rep_tags(39, $_info, '<dd><a href="<!--[link]-->" <!--[target]-->><!--[word]--></a></dd>'); ?>
        </dl>
        <dl class="talent-news-dl">
            <?php echo _rep_tags(40, $_info, '<dt><img src="<!--[pic]-->" alt="<!--[alt]-->"></dt>'); ?>
            <?php echo _rep_tags(41, $_info, '<dd><a href="<!--[link]-->" <!--[target]-->><!--[word]--></a></dd>'); ?>
        </dl>
        <dl class="talent-news-dl">
            <?php echo _rep_tags(42, $_info, '<dt><img src="<!--[pic]-->" alt="<!--[alt]-->"></dt>'); ?>
            <?php echo _rep_tags(43, $_info, '<dd><a href="<!--[link]-->" <!--[target]-->><!--[word]--></a></dd>'); ?>
        </dl>
    </div>
</div>
<!--/新闻-->
<!--logo -->
<div class="talent-logos">
    <?php echo _rep_tags(44, $_info, '<p class="font22"><!--[word]--><i class="icon-work-online"></i></p>'); ?>
    <?php echo _rep_tags(45, $_info, '<p><!--[word]--></p>'); ?>

    <div class="m-warp">
        <table class="talent-logos-table">
            <tr>
                <?php for ($i = 46; $i <= 50; $i++): ?>
                    <?php echo _rep_tags(
                        $i,
                        $_info,
                        '<td><img data-original="<!--[pic]-->" alt="<!--[alt]-->" class="lazy"></td>'
                    ); ?>
                <?php endfor; ?>
            </tr>
            <tr>
                <?php for ($i = 51; $i <= 55; $i++): ?>
                    <?php echo _rep_tags(
                        $i,
                        $_info,
                        '<td><img data-original="<!--[pic]-->" alt="<!--[alt]-->" class="lazy"></td>'
                    ); ?>
                <?php endfor; ?>
            </tr>
        </table>
    </div>
</div>
<!--/logo-->

<script src="http://static.vsochina.com/libs/responsiveslides/responsiveslides.min.js"></script>
<script>
    //去除幻灯片空连接鼠标手势
    $('.rslides').find('a').each(function () {
        if ($(this).attr('href') == 'javascript:void(0);') {
            $(this).css({cursor: 'default'});
        }
    });
    $(".rslides").responsiveSlides({
        auto: true,             // Boolean: 设置是否自动播放, true or false
        speed: 500,            // Integer: 动画持续时间，单位毫秒
        timeout: 4000,          // Integer: 图片之间切换的时间，单位毫秒
        pager: true,           // Boolean: 是否显示页码, true or false
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
</script>
<?php echo $_this_obj->renderPartial('//rc/index_footer'); ?>
<script type="text/javascript" charset="utf-8" src="http://static.vsochina.com/public/rightbox/vso.rightbox.js?v=4"></script>
</body>
</html>