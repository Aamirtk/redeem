<!DOCTYPE html>
<html>
<head>
    <title>【兑换】东芝U盘16G 速闪USB3.0 迷你防水创意车载优盘</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="browsermode" content="application">
    <meta name="x5-page-mode" content="app">
    <link rel="stylesheet" type="text/css" href="/css/header.css">
    <link rel="stylesheet" type="text/css" href="/css/gerenzhongxin.css">
    <script src="/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $('.back').click(function(){
                history.back();
            });
        });
    </script>
</head>
<body>
<div class="body-All">
    <header>
        <div class="back"><a><img src="/images/back.png"></a></div>
        个人中心
        <div class="home"><a href="index.html"><img src="/images/home.png"></a></div>
    </header>
    <div class="head_portrait">
        <img src="/images/head_portrait.png">
    </div>
    <div class="name">喵喵</div>
    <div class="integral"><img src="/images/heart.png">&nbsp;&nbsp;我的积分&nbsp;&nbsp;<span>1000</span></div>
    <div class="signature">
        <input type="text" placeholder="签名" />
    </div>
    <ul class="box">
        <a href="我的订单.html"><li>
                <img src="/images/icon01.png" class="icon">
                我的订单
                <img src="/images/go.png" class="go">
            </li></a>
        <a href="/redeem/my/address?uid=<?php echo $user['uid'] ?>"><li>
                <img src="/images/icon02.png" class="icon">
                我的地址
                <img src="/images/go.png" class="go">
            </li></a>
        <a href="/redeem/my/points/?uid=<?php echo $user['uid'] ?>"><li>
                <img src="/images/icon03.png" class="icon">
                积分管理
                <img src="/images/go.png" class="go">
            </li></a>
        <a href="关于我们.html"><li>
                <img src="/images/icon04.png" class="icon">
                关于我们
                <img src="/images/go.png" class="go">
            </li></a>
    </ul>
    <div class="button">
        <a class="btn" href="/redeem/user/logout" id="login-out" >退出登录</a>
    </div>
</div>
</body>

</html>