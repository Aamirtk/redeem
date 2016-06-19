<!DOCTYPE html>
<html>
<head>
    <title>物流配送</title>
    <meta charset="utf-8">
    <meta content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="browsermode" content="application">
    <meta name="x5-page-mode" content="app">
    <meta name="msapplication-tap-highlight" content="no">
    <link rel="stylesheet" type="text/css" href="/css/header.css">
    <link rel="stylesheet" type="text/css" href="/css/wuliupeisong.css">
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
        物流配送
    </header>
    <div class="box">
        <div class="top">
            <div class="pic"><img src="/images/pic01.png"></div>
            <div class="text">
                <div>物流状态&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="state"><?php echo $log_list['deliverystatus'] == 3 ? '已签收' : '派送中'  ?></span></div>
                <div>物流公司&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $express['name']  ?></div>
                <div>运单编号&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $log_list['number']  ?></div>
                <div>官方电话&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $express['tel']  ?></div>
            </div>
        </div>
        <ul>
            <?php  foreach($log_list['list'] as $key => $val): ?>
                <li class="<?php if($key == 0){echo 'active';} ?>"><img src="/images/point01.png"><?php echo $val['status'] ?><br><?php echo $val['time'] ?></li>
            <?php  endforeach ?>
        </ul>
    </div>
</div>
</body>
</html>