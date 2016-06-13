<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $_page_config['title']; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit"/>
    <!--reset.css  header.css  footer.css-->
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.2.0/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css?v=20150807"/>
    <link type="text/css" rel="stylesheet" href="http://www.vsochina.com/resource/mCustomScrollbar/jquery.mCustomScrollbar.min.css"/>
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.2.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="/css/rc_index.css">
    <link type="text/css" rel="stylesheet" href="/css/origWeekly.css"/>
    <link type="text/css" rel="stylesheet" href="/css/rc_personal.css"/>
    <link type="text/css" rel="stylesheet" href="/css/ranking.css"/>
    <!--jquery-->
    <script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script src="http://static.vsochina.com/libs/bootstrap/3.2.0/js/bootstrap.min.js"></script>
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

        .date_box .date_list_year {
            position: relative;
            text-align: center;
            color: #fff;
        }

        .date_box .date_list_month {
            position: absolute;
            right: -110px;
            top: 0px;
            background: #3297e7;
            width: 110px;
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

        .browsermore {
            width: 320px;
            padding-left: 150px;
            text-align: center;
        }

        .browsermore:hover {
            background: #ccc;
        }

        .skanmore .word {
            width: 10px;
            display: block;
            padding-top: 40px;
            color: #ffffff;
            text-align: center;
        }

    </style>
</head>
<body class="bg-darkgrey mw1200">
<!-- header -->
<script type="text/javascript" src="http://account.vsochina.com/static/js/vsoheader.js"></script>
<?php echo $_this_obj->renderPartial('//rc/index_header'); ?>

<div class="nav_wrap">
    <div class="recommend_center">
        <ul class="telent-navigater">
            <li class="nav_list">
                <a class="telent-list" href="<?php echo yii::$app->urlManager->createUrl(['rc/index/rank']) ?>">排行榜</a>
            </li>
            <li class="nav_list active">
                <a class="telent-list" href="<?php echo yii::$app->urlManager->createUrl(
                    ['rc/personal/weekly', 'w_id' => $_widget_id]
                ) ?>">创意周刊</a>
                <span style="position: absolute; top: 50px; display: none;">|</span>
            </li>
            <li class="nav_list">
                <a class="telent-list"
                   href="<?php echo yii::$app->urlManager->createUrl(
                       ['rc/personal/cover_story', 'w_id' => $cover_story_widget_id]
                   ) ?>">封面人物</a>
                <span style="position: absolute; top: 50px; display: none;">|</span>
            </li>
        </ul>
    </div>
</div>

<div class="bannertop">
    <div class="banner1-wrap"></div>
    <div class="recommend_center">
        <div class="banner-intruduce">
            <p class="inner-title">创意人才周刊</p>

            <div class="character-timepicker-box">
                <div class="character-timepicker-link">
                    <span id="now_date"><?php echo $_now_date; ?></span>
                    <i class="icon-9 icon-9-down"></i>

                    <div class="date_box">
                        <?php if (!empty($_date_list)): ?>
                            <?php foreach ($_date_list as $key => $val): ?>
                                <li class="date_list_year">
                                    <?php echo $key ?> 年 >

                                    <div class="date_list_month">
                                        <?php if (!empty($val)): ?>
                                            <?php foreach ($val as $k => $v): ?>
                                                <a href="<?php echo yii::$app->urlManager->createUrl(
                                                    [
                                                        'rc/personal/weekly',
                                                        'w_id' => $_widget_id,
                                                        'y' => $key,
                                                        'm' => $k
                                                    ]
                                                ); ?>">
                                                <span year="<?php echo $key; ?>" month="<?php echo $k ?>">
                                                    <?php echo $k ?> 月
                                                </span>
                                                </a>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                            <a href="<?php echo yii::$app->urlManager->createUrl(
                                ['rc/personal/weekly', 'w_id' => $_widget_id]
                            ); ?>">
                                <li class="date_list_year">全部</li>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!--<div class="character-timepicker-box">
                <a href="javascript:void(0);" class="character-timepicker-link">
                    <span id="now_date">2015年1月</span>
                    <i class="icon-9 icon-9-down"></i>
                </a>
                <input class="form_datetime" type="text" value="2015 1" data-date-format="yyyy年m月" readonly
                       onfocus="javascript:this.blur()">
            </div>-->
            <p class="inner-brief">
                所谓常规人才则是常规思维占主导地位，创新意识、创新精神、创新能力不强，习惯于按照常规的方法处理问题的人才。创新型人才与通常所说的理论型人才、应用型人才、技艺型人才等是相互联系的，它们是按照不同的划分标准而产生的不同分类。
            </p>
        </div>
        <div class="twodimension-code">
            <img src="/images/rc/enterprise/pubnumber.jpg"/>
        </div>
    </div>
</div>

<?php if (!empty($_info_list)): ?>
    <?php $i = 1; ?>
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
        <div class="periodbox <?php if ($i == 1)
        {
            echo('offset');
        }
        else
        {
            echo('style="background-color: #f5f5f5;"');
        } ?>">
            <div class="recommend_center">
                <a href="<?php echo !empty($val[4]['link']) ? $val[4]['link'] : ''; ?>">
                    <div class="themebox"
                         style="background-image:url('<?php echo !empty($val[4]['image']) ? $val[4]['image'] : ''; ?>'); filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo !empty($val[4]['image']) ? $val[4]['image'] : ''; ?>',sizingMethod='scale'); ">
                        <div class="banner2-wrap"></div>
                        <div style="position: relative;">
                            <div class="period-demon">
                                <p style="font-size: 14px;">第&nbsp;&nbsp;
                                    <span style="font-size: 28px; font-family: 'Arial'"><?php echo $key; ?></span>&nbsp;&nbsp;期
                                </p>

                                <p><?php echo $num_date; ?></p>
                            </div>
                            <?php if(!empty($val[4]['word'])): ?>
                                <hr>
                            <?php endif ?>
                            <p class="m_heading ml"><?php echo !empty($val[4]['word']) ? $val[4]['word'] : ''; ?></p>

                            <p class="ml mt5">
                                <?php echo !empty($val[4]['word2']) ? $val[4]['word2'] : ''; ?>
                            </p>

                            <p class="ml mt28">
                                <?php echo !empty($val[4]['word3']) ? $val[4]['word3'] : ''; ?>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div style="background-color: #f5f5f5;">
                <div class="main-content">
                    <div class="detail color1">
                        <?php if(!empty($val[5]['word'])): ?>
                            <hr>
                        <?php endif ?>
                        <p class="detail-title">
                            <span class="hidefont">
                                <?php echo !empty($val[5]['word']) ? $val[5]['word'] : ''; ?>
                            </span>
                        </p>

                        <p class="mt5 ml20"><?php echo !empty($val[6]['word']) ? $val[6]['word'] : ''; ?></p>

                        <p class="mt28 ml20"><?php echo !empty($val[7]['word']) ? $val[7]['word'] : ''; ?></p>
                    </div>
                    <div class="detail">
                        <a href="<?php echo !empty($val[8]['link']) ? $val[8]['link'] : ''; ?>">
                            <img src="<?php echo !empty($val[8]['image']) ? $val[8]['image'] : ''; ?>"/>
                        </a>
                    </div>
                    <div class="detail color2">
                        <?php if(!empty($val[9]['word'])): ?>
                            <hr>
                        <?php endif ?>
                        <p class="detail-title"><?php echo !empty($val[9]['word']) ? $val[9]['word'] : ''; ?></p>

                        <p class="ml20 mt5"><?php echo !empty($val[10]['word']) ? $val[10]['word'] : ''; ?></p>

                        <p class="ml20 mt28"><?php echo !empty($val[11]['word']) ? $val[11]['word'] : ''; ?></p>
                    </div>
                    <div class="detail">
                        <a href="<?php echo !empty($val[12]['link']) ? $val[12]['link'] : ''; ?>">
                            <img src="<?php echo !empty($val[12]['image']) ? $val[12]['image'] : ''; ?>"/>
                        </a>
                    </div>

                    <a href="<?php echo !empty($val[4]['link']) ? $val[4]['link'] : ''; ?>">
                        <div class="browsermore skanmore">
                            <span class="word">查看更多
                            <i style="margin-left: -3px;">
                                <img src="/images/rc/enterprise/arrowright.png"/>
                            </i>
                            </span>
                        </div>
                    </a>

                </div>
            </div>
        </div>
        <?php $i++; ?>
    <?php endforeach; ?>

<?php else: ?>
    暂无数据！
<?php endif; ?>

<script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.pure.js" charset="UTF-8"></script>
<!-- footer -->

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
            $(this).children('.date_list_month').show();
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
