<!DOCTYPE html>
<html>
<head>
    <title>尚飞积分商城</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="browsermode" content="application">
    <meta name="x5-page-mode" content="app">
    <link rel="stylesheet" type="text/css" href="/css/header.css">
    <link rel="stylesheet" type="text/css" href="/css/jifenguanli.css">
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
        积分管理
    </header>
    <div class="header-box">
        <div class="head_portrait">
            <img src="/images/head_portrait.png">
        </div>
        <div class="basic">
            <div class="name">张玛丽</div>
            <div class="integral">我的积分：<span>61000</span></div>
        </div>
    </div>
    <table class="box" cellspacing="0">
        <tr>
            <th>日期</th>
            <th>积分</th>
            <th>操作</th>
        </tr>
        <tr>
            <td>2016-05-06</td>
            <td>+10</td>
            <td>签到</td>
        </tr>
        <tr>
            <td>2016-05-06</td>
            <td>+560</td>
            <td>抽奖</td>
        </tr>
        <tr>
            <td>2016-05-06</td>
            <td>+80</td>
            <td>手机认证</td>
        </tr>
        <tr>
            <td>2016-05-06</td>
            <td>+980</td>
            <td>身份认证</td>
        </tr>
    </table>
</div>
</body>
</html>