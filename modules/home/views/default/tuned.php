<!DOCTYPE html>
<?php
use frontend\modules\talent\models\User;
$site = \backend\modules\content\models\Site::find()->limit(1)->one();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?= $page_config['site_name'] ?></title>
    <meta name="keywords" content="<?= $page_config['seo_keywords'] ?>"/>
    <meta name="description" content="<?= $page_config['seo_desc'] ?>"/>
    <meta name="renderer" content="webkit"/>
    <meta name="baidu-site-verification" content="NpzvG27pvo" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.3.5/css/bootstrap.min.css?v1.4">
    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css?v1.4" />
    <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/font/userWork/font.css?v1.4" />
    <script type="text/javascript" charset="utf-8" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
</head>
<body>
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_header.php')?>
<!--/new-top-->

<div class="tuned-box">
    <div class="table-cell" style="min-height:420px;">
        <div class="tuned-img">
            <img src="/images/home/tuned.jpg" alt="">
            <div class="tuned-img-w">
                <p class="font26">版块建设中…</p>
                <a href="http://maker.vsochina.com">返回首页》</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(".tuned-box").height($(window).height()-89-335);
    $(window).resize(function(){$(".tuned-box").height($(window).height()-89-335);});
</script>

<?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_footer.php')?>

</body>
</html>