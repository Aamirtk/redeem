<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $_page_config['title']; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit"/>
    <!--reset.css  header.css  footer.css-->
    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css"/>
    <!--css-->
    <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/libs/bootstrap/3.3.5/css/bootstrap.min.css">
    <link href="http://static.vsochina.com/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <link type="text/css" rel="stylesheet" href="/css/rc_index.css">
    <link type="text/css" rel="stylesheet" href="/css/rc_case.css">
    <link type="text/css" rel="stylesheet" href="/css/rc_personal.css">
    <link type="text/css" rel="stylesheet" href="/css/ranking.css"/>
    <!--jquery-->
    <script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" href="http://static.vsochina.com/libs/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!--cookie domain-->
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
    <style>
        .detail img {
            width: 218px;
            height: 187px;
        }

        .character-timepicker-box {
            cursor: pointer;
        }

        .character-timepicker-box .character-timepicker-link {
            border: 1px solid #3297e7;
            box-sizing: border-box;
            color: #3297e7;
            display: inline-block;
            font-size: 14px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            text-decoration: none;
            width: 115px;
        }

        .character-timepicker-link .date_box {
            position: relative;
            background: #3297e7;
            color: #fff;
            text-align: left;
        }

        .date_box .date_list_month {
            position: absolute;
            right: -110px;
            top: 0px;
            background: #3297e7;
            width: 110px;
        }

        .date_list_year {
            text-align: center;
            color: #fff;
        }

        .date_list_year, .date_list_month, .date_box {
            display: none;
        }

        .date_list_month span {
            display: block;
            text-align: center;
            color: #fff;
        }

        .date_list_year:hover, .date_list_month span:hover {
            background: #ccc;
        }

        .character-coverlist .personal-cover-story .personal-cover-works {
            width: 672px;
        }

        .character-coverlist .character-coverlist-more, .character-coverlist .character-coverlist-more a {
            width: 287px;
        }

        .character-coverlist-more:hover {
            background: #ccc;
        }

        .character-banner {
            z-index: 0;
        }
    </style>
</head>

<body class="bg-darkgrey mw1200">
<!--header-->
<script type="text/javascript" src="http://account.vsochina.com/static/js/vsoheader.js"></script>
<?php echo $_this_obj->renderPartial('//rc/index_header'); ?>

<div class="nav_wrap">
    <div class="recommend_center">
        <ul class="telent-navigater">
            <li class="nav_list">
                <a class="telent-list" href="<?php echo yii::$app->urlManager->createUrl(['rc/index/rank']) ?>">排行榜</a>
            </li>
            <li class="nav_list">
                <a class="telent-list" href="<?php echo yii::$app->urlManager->createUrl(
                    ['rc/personal/weekly', 'w_id' => $_weekly_widget_id]
                ) ?>">创意周刊</a>
                <span style="position: absolute; top: 150px; display: block;">|</span>
            </li>
            <li class="nav_list active">
                <a class="telent-list"
                   href="<?php echo yii::$app->urlManager->createUrl(
                       ['rc/personal/cover_story', 'w_id' => $_widget_id]
                   ) ?>">封面人物</a>
                <span style="position: absolute; top: 150px; display: none;">|</span>
            </li>
        </ul>
    </div>
</div>
<!--banner-->
<div class="character-banner">
    <img src="/images/rc/enterprise/case-demo1.jpg">
</div>
<!--/banner-->

<!--topnav-->
<div class="character-top clear-float">
    <div class="character-top-title">
        <span class="top-title-headline">封面人物</span>

        <div class="character-timepicker-box">
            <div class="character-timepicker-link">
                <span id="now_date"><?php echo $_now_date; ?></span>
                <i class="icon-9 icon-9-down"></i>

                <div class="date_box">
                    <?php if (!empty($_date_list)): ?>
                        <?php foreach ($_date_list as $key => $val): ?>
                            <li class="date_list_year">
                                <?php echo $key ?> 年 >
                            </li>
                            <div class="date_list_month">
                                <?php if (!empty($val)): ?>
                                    <?php foreach ($val as $k => $v): ?>
                                        <a href="<?php echo yii::$app->urlManager->createUrl(
                                            ['rc/personal/cover_story', 'w_id' => $_widget_id, 'y' => $key, 'm' => $k]
                                        ); ?>">
                                                <span year="<?php echo $key; ?>" month="<?php echo $k ?>">
                                                    <?php echo $k ?> 月
                                                </span>
                                        </a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        <a href="<?php echo yii::$app->urlManager->createUrl(
                            ['rc/personal/cover_story', 'w_id' => $_widget_id]
                        ); ?>">
                            <li class="date_list_year">全部</li>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <p class="character-top-info">
        所谓常规人才则是常规思维占主导地位，创新意识、创新精神、创新能力不强，习惯于按照常规的方法处理问题的人才。创新型人才与通常所说的理论型人才、应用型人才、技艺型人才等是相互联系的，它们是按照不同的划分标准而产生的不同分类。
    </p>

    <div class="character-top-qrcode">
        <a href="javascript:void(0);">
            <img src="/images/rc/personal/vso-qrcode.jpg">
        </a>
    </div>
</div>
<!--/topnav-->

<!--content-->
<ul class="character-coverlist mt44">
    <?php if ($_info_list): ?>
        <?php foreach ($_info_list as $key => $val): ?>
            <?php foreach ($val as $v)
            {
                $num_date = '-';
                if (!empty($v['date']))
                {
                    $num_date = date('Y/m/d', strtotime($v['date']));
                    break;
                }
            } ?>
            <li>
                <div class="personal-cover-story clear-float">
                    <div class="personal-cover-left fl">
                        <a target="_blank" href="<?php echo !empty($val[4]['link']) ? $val[4]['link'] : ''; ?>">
                            <img src="<?php echo !empty($val[4]['image']) ? $val[4]['image'] : ''; ?>">
                        </a>

                        <div class="cover-left-number">
                            <p class="cover-left-title">
                                第<span style="font-size: 28px; font-family: 'Arial'"><?php echo $key; ?></span>期
                            </p>

                            <p class="cover-left-subtitle"><?php echo $num_date; ?></p>

                            <div class="cover-bottom-bg"></div>
                        </div>
                    </div>
                    <div class="personal-cover-intro fl">
                        <i class="personal-triangle"></i>

                        <div class="cover-intro-left fl">
                            <p class="cover-intro-author"><?php echo !empty($val[5]['word']) ? $val[5]['word'] : ''; ?></p>

                            <p class="cover-intro-tag"><?php echo !empty($val[6]['word']) ? $val[6]['word'] : ''; ?></p>

                            <p class="cover-intro-fans"><?php echo !empty($val[7]['word']) ? $val[7]['word'] : ''; ?></p>
                        </div>
                        <div class="cover-intro-right fr">
                            <p>
                                <?php echo !empty($val[8]['word']) ? $val[8]['word'] : ''; ?>
                                <a target="_blank" href="<?php echo !empty($val[9]['link']) ? $val[9]['link'] : ''; ?>"
                                   class="personal-readmore"><?php echo !empty($val[9]['word']) ? $val[9]['word'] : ''; ?></a>
                            </p>
                        </div>
                    </div>
                    <ul class="personal-cover-works fl">
                        <li>
                            <a target="_blank" href="<?php echo !empty($val[10]['link']) ? $val[10]['link'] : ''; ?>"
                               class="personal-bigger">
                                <img src="<?php echo !empty($val[10]['image']) ? $val[10]['image'] : ''; ?>">
                            </a>
                        </li>
                        <li>
                            <a target="_blank" href="<?php echo !empty($val[11]['link']) ? $val[11]['link'] : ''; ?>"
                               class="personal-bigger">
                                <img src="<?php echo !empty($val[11]['image']) ? $val[11]['image'] : ''; ?>">
                            </a>
                        </li>
                        <li>
                            <a target="_blank" href="<?php echo !empty($val[12]['link']) ? $val[12]['link'] : ''; ?>"
                               class="personal-bigger">
                                <img src="<?php echo !empty($val[12]['image']) ? $val[12]['image'] : ''; ?>">
                            </a>
                        </li>
                        <li>
                            <a target="_blank" href="<?php echo !empty($val[13]['link']) ? $val[13]['link'] : ''; ?>"
                               class="personal-bigger">
                                <img src="<?php echo !empty($val[13]['image']) ? $val[13]['image'] : ''; ?>">
                            </a>
                        </li>
                    </ul>
                    <div class="character-coverlist-more fl">
                        <a href="<?php echo !empty($val[4]['link']) ? $val[4]['link'] : ''; ?>">
                            <p class="coverlist-more-txt">查看更多</p>

                            <p class="coverlist-more-icon"><i class="icon-18 icon-18-arrow"></i></p>
                        </a>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>
<!--/content-->

<script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.pure.js" charset="UTF-8"></script>
<script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>

<?php echo $_this_obj->renderPartial('//rc/index_footer'); ?>

<script type="text/javascript">
    $(function () {
        $('.character-timepicker-link').click(function (event) {
            var _status = $(this).attr('status');
            if (_status == '1') {
                $('.date_box, .date_list_year').hide();
                $(this).attr('status', '0');
            }
            else {
                $('.date_box, .date_list_year').show();
                $(this).attr('status', '1');
            }
            stopPropagation(event);
        });
        $('.date_list_year').mouseenter(function (event) {
            $('.date_list_month').hide();
            $(this).next('.date_list_month').show();
            stopPropagation(event);
        });
        $('.date_list_month').mouseleave(function (event) {
            $(this).hide();
            stopPropagation(event);
        });
        $(document).on("click",function(){
            $('.character-timepicker-link').attr('status',0);
            $('.date_box, .date_list_year').hide();
        });
    });
</script>
</body>

</html>