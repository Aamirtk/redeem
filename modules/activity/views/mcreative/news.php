<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>百万创意创业大赛官网-创意空间maker.vsochina.com</title>
    <meta name="keywords" content="百万创意创业大赛,创意空间,创意项目"/>
    <meta name="description" content="百万大赛奖金、亿元创业资金支持；与文创及互联网大咖面对面碰撞；全程创业支持和辅导，免费对接行业资源。大赛面向全国征集优秀创意项目,寻找中国最具创意的年轻人和最具商业潜力的优秀项目。主办方蓝海创意云通过人才扶持、资金支持、免费提供在线软硬件资源、导师培养等多样化方式，采取线上入驻创意空间和线下入驻创客空间，对优秀创意项目进行孵化。"/>
    <meta name="renderer" content="webkit"/>
    <meta name="baidu-site-verification" content="NpzvG27pvo" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.3.5/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css" />
    <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/font/userWork/font.css" />
    <link type="text/css" rel="stylesheet" href="/css/activity-mcreative.css" />

    <script type="text/javascript" charset="utf-8" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
</head>
<body>
    <!-- header -->
    <script type="text/javascript" charset="utf-8" src="http://maker.vsochina.com/js/maker_header.js"></script>

    <div class="mcreative-banner">
        <a href="http://maker.vsochina.com" class="mcreative-logo"><img src="/images/activity/mcreative/vsologo.png" alt="创意空间"></a>
        <div class="mcreative-nav clearfix">
            <ul class="mcreative-navlist clearfix">
                <li>
                    <a href="index">
                        <p class="mcreative-navlist-ch">大赛首页</p>
                        <p class="mcreative-navlist-en">HOME</p>
                    </a>
                </li>
                <li class="cur">
                    <a href="javascript:void(0);">
                        <p class="mcreative-navlist-ch">赛事新闻</p>
                        <p class="mcreative-navlist-en">NEWS</p>
                    </a>
                </li>
                <li>
                    <a href="intro">
                        <p class="mcreative-navlist-ch">大赛介绍</p>
                        <p class="mcreative-navlist-en">INTRO</p>
                    </a>
                </li>
                <li>
                    <a href="rules">
                        <p class="mcreative-navlist-ch">赛事规则</p>
                        <p class="mcreative-navlist-en">RULE</p>
                    </a>
                </li>
                <!--<li>
                    <a href="index#mcreative_judge">
                        <p class="mcreative-navlist-ch">评委阵容</p>
                        <p class="mcreative-navlist-en">JUDGE</p>
                    </a>
                </li>-->
                <!--<li>
                    <a href="javascript:void(0);">
                        <p class="mcreative-navlist-ch">相关活动<i class="icon-hot">H</i></p>
                        <p class="mcreative-navlist-en">ACTIVITY</p>
                    </a>
                </li>-->
                <li>
                    <?php if($username):?>
                    <a href="https://cz.vsochina.com/project/project?t=mp">
                    <?php else:?>
                    <a href="javascript:openLoginpop()">
                        <?php endif;?>
                        <p class="mcreative-navlist-ch">项目审核<i class="icon-hot">H</i></p>
                        <p class="mcreative-navlist-en">CENSOR</p>
                    </a>
                </li>
            </ul>
            <?php if($username):?>
            <a href="https://cz.vsochina.com/project/project?t=mp" class="mcreative-entrance">
            <?php else:?>
            <a href="javascript:openLoginpop()" class="mcreative-entrance">
                <?php endif;?>
                <p class="mcreative-entrance-ch">报名入口</p>
                <p class="mcreative-entrance-en">ENTRANCE</p>
                <i class="icon-triangle-top"></i>
                <i class="icon-triangle-bottom"></i>
            </a>
        </div>
    </div>

    <div class="mcreative-part mcreative-whitepart">
        <div class="mcreative-titlebox ds-1200 clearfix">
            <div class="mcreative-title">
                <b></b>
                <span class="mcreative-title-ch">赛事新闻</span>
                <span class="mcreative-title-en">NEWS</span>
            </div>
        </div>
        <div class="mcreative-news-two ds-1200">
            <ul class="mcreative-newslist">
                <?php foreach($news as $new):?>
                    <li>
                        <a class="clearfix" href="<?=yii::$app->params['frontendurl'].'/studio/trends/detail?id='.$new['id']?>">
                            <i class="icon-dot"></i>
                            <span class="mcreative-newslist-type">官方新闻</span>
                            <i class="icon-separate">-</i>
                            <p class="mcreative-newslist-title"><?=$new['name']?></p>
                            <span class="mcreative-newslist-date"><?=date('Y/m/d',$new['create_time'])?></span>
                            <?php if(date('Y/m/d',$new['create_time']) == date('Y/m/d',time())):?>
                                <i class="icon-new">N</i>
                            <?php endif;?>
                        </a>
                    </li>
                <?php endforeach;?>
                <!--<li>
                    <a class="clearfix">
                        <i class="icon-dot"></i>
                        <span class="mcreative-newslist-type">官方新闻</span>
                        <i class="icon-separate">-</i>
                        <p class="mcreative-newslist-title">Pixel perfect design with</p>
                        <span class="mcreative-newslist-date">02/17</span>
                    </a>
                </li>
                <li>
                    <a class="clearfix">
                        <i class="icon-dot"></i>
                        <span class="mcreative-newslist-type">官方新闻</span>
                        <i class="icon-separate">-</i>
                        <p class="mcreative-newslist-title">Pixel perfect design with resposnive touch resposnive</p>
                        <span class="mcreative-newslist-date">02/17</span>
                        <i class="icon-new">N</i>
                    </a>
                </li>
                <li>
                    <a class="clearfix">
                        <i class="icon-dot"></i>
                        <span class="mcreative-newslist-type">官方新闻</span>
                        <i class="icon-separate">-</i>
                        <p class="mcreative-newslist-title">Pixel perfect design with resposnive touch resposnive touch resposnive</p>
                        <span class="mcreative-newslist-date">02/17</span>
                        <i class="icon-new">N</i>
                    </a>
                </li>
                <li>
                    <a class="clearfix">
                        <i class="icon-dot"></i>
                        <span class="mcreative-newslist-type">官方新闻</span>
                        <i class="icon-separate">-</i>
                        <p class="mcreative-newslist-title">Pixel perfect design with resposnive touch resposnive</p>
                        <span class="mcreative-newslist-date">02/17</span>
                    </a>
                </li>
                <li>
                    <a class="clearfix">
                        <i class="icon-dot"></i>
                        <span class="mcreative-newslist-type">官方新闻</span>
                        <i class="icon-separate">-</i>
                        <p class="mcreative-newslist-title">Pixel perfect design with resposnive touch resposnive</p>
                        <span class="mcreative-newslist-date">02/17</span>
                    </a>
                </li>
                <li>
                    <a class="clearfix">
                        <i class="icon-dot"></i>
                        <span class="mcreative-newslist-type">官方新闻</span>
                        <i class="icon-separate">-</i>
                        <p class="mcreative-newslist-title">Pixel perfect design with resposnive</p>
                        <span class="mcreative-newslist-date">02/17</span>
                    </a>
                </li>
                <li>
                    <a class="clearfix">
                        <i class="icon-dot"></i>
                        <span class="mcreative-newslist-type">官方新闻</span>
                        <i class="icon-separate">-</i>
                        <p class="mcreative-newslist-title">Pixel perfect design with resposnive touch resposnive Pixel perfect design with resposnive touch resposnive</p>
                        <span class="mcreative-newslist-date">02/17</span>
                        <i class="icon-new">N</i>
                    </a>
                </li>-->
            </ul>
        </div>
    </div>

    <!-- footer -->
    <?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_footer.php') ?>
</body>
</html>