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
    <link rel="stylesheet" type="text/css" href="/css/dingdanqueren.css">
    <script src="/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $('.back').click(function(){
                history.back();
            });
        });
        <!-- 增加数量 -->
        function numAdd(thi) {
            var num_root = $(thi).parents('.count').find('input');
            var num_add = parseInt(num_root.val())+1;
            num_root.val(num_add);

            // var total = parseFloat($("#price").text())*parseInt(num_root.val());
            // $("#totalPrice").html(total.toFixed(2));
        }
        <!-- 减少数量 -->
        function numDec(thi) {
            var num_root = $(thi).parents('.count').find('input');
            var num_dec = parseInt(num_root.val())-1;
            var num_name = num_root.attr('name');

            if((num_name=='2' && num_dec<3) || (num_name=='4' && num_dec<1) || num_dec<1){
                return false;
            }else{
                num_root.val(num_dec);
                // var total = parseFloat($("#price").text())*parseInt(num_root.val());
                // $("#totalPrice").html(total.toFixed(2));
            }
        }
    </script>
</head>
<body>
<div class="body-All">
    <header>
        <div class="back"><a><img src="///images/back.png"></a></div>
        我的订单
        <div class="home"><a href="index.html"><img src="///images/home.png"></a></div>
    </header>
    <?php if(!empty($cart_goods)): ?>
        <?php foreach($cart_goods as $val): ?>
            <div class="box" c_g_id="<?php echo $val['id'] ?>">
                <div class="pic"><img src="<?php echo yiiParams('img_host') . getValue($val, 'goods.thumb', '') ?>"></div>
                <div class="text">
                    <div class="title"><?php echo getValue($val, 'goods.name', '') ?></div>
                    <div>
                        <div class="integral">积分&nbsp;&nbsp;<span><?php echo getValue($val, 'goods.redeem_pionts', 0) ?></span></div>
                        <div class="count">
                            <span type="text"><?php echo $val['count'] ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    <?php endif ?>
    <div class="address-container">
        <div class="address">
            <div class="top">
                <span><?php echo getValue($address, 'receiver_name', '') ?></span>&nbsp;&nbsp;
                <div class="fr"><span><?php echo getValue($address, 'receiver_phone', '') ?></span>&nbsp;
                    <span class="default">默认</span></div>
            </div>
            <div class="middle">
                <span><?php echo getValue($address, 'province', '') ?></span>&nbsp;
                <span><?php echo getValue($address, 'city', '') ?></span>&nbsp;
                <span><?php echo getValue($address, 'county', '') ?></span>&nbsp;
                <span><?php echo getValue($address, 'detail', '') ?></span>
            </div>
            <div class="bottom">地址类型：<?php echo getValue($address, 'type_name', '') ?></div>
            <a href="/redeem/address/add"><div class="change">更换地址</div></a>
        </div>
    </div>
    <div class="button">
        <a href="" class="btn">立即支付</a>
    </div>
</div>
</body>
</html>