<!DOCTYPE html>
<?php
use frontend\modules\talent\models\User;
$site = \backend\modules\content\models\Site::find()->limit(1)->one();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit"/>
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/public/resetcss/mreset.css"/>
    <link rel="stylesheet" type="text/css" href="/css/maker-mobile.css"/>
    <!--jquery-->
    <script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/public/fontSize/fontSize.js"></script>
</head>
<body>
<style type="text/css">
    .mo-nav ,.mo-footer{
        display: none;
    }
</style>
<!--/new-top-->
<div class="register-auto">
    <h2 class="font48"><i class="iconfont-83 iconfont-chenggong"></i>提交成功</h2>
    <p class="font36">客服人员将会在2个工作日内与您联系，请耐心等待...</p>
    <p class="font30">将于 <span class="color-green register-timer">5</span> 秒后返回首页，也可 <a class="color-green" href="http://maker.vsochina.com">立即跳转</a> </p>
</div>



<script>
      var timer = 5;
      var registerTimer = setInterval(function(){

        if(timer<=0){
            clearInterval(registerTimer);
            window.location.href = 'http://maker.vsochina.com';
        }
        else{
            $(".register-timer").html(timer);
        }
        timer--;

      },1000);
</script>


</body>
</html>