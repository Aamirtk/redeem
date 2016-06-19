<!DOCTYPE html>
<html>
<head>
    <title><?php echo $goods['name'] ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="browsermode" content="application">
    <meta name="x5-page-mode" content="app">
    <link rel="stylesheet" type="text/css" href="/css/swiper-3.3.1.min.css">
    <link rel="stylesheet" type="text/css" href="/css/header.css">
    <link rel="stylesheet" type="text/css" href="/css/xiangqing.css">
    <script src="/js/jquery-1.11.3.min.js"></script>
    <script src="/js/swiper-3.3.1.jquery.min.js"></script>
    <script src="/js/tools.js"></script>
    <script type="text/javascript">
        $(function(){
            var mySwiper = new Swiper('.pic', {
                direction : 'horizontal',
            });

            $('.swiper-slide').height(mySwiper.width/1.4);
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
        <div class="left"><a href="index.html"><img src="/images/home.png"></a></div>
        <div class="right">
            <a href="/redeem/my/index"><img src="/images/icon07.png"></a>
            <a href="/redeem/cart/goods-list"><img src="/images/icon06.png"></a>
        </div>
    </header>
    <div class="box">
        <div class="pic">
            <div class="swiper-wrapper">
                <?php
                    $thumb_list = json_decode($goods['thumb_list']);
                    if(!empty($thumb_list)){
                        foreach($thumb_list as $val){
                ?>
                        <div class="swiper-slide"><img src="<?php echo yiiParams('img_host') . $val ?>"></div>
                <?php }} ?>
            </div>
        </div>
        <div class="title">
            <?php echo $goods['name'] ?>
        </div>
        <div class="integral">
            兑换积分：<span><?php echo $goods['redeem_pionts'] ?></span>分
        </div>
        <div class="prompt">
            温馨提示：兑换商品在下单之后3日内按照顺序安排发货。
        </div>
        <div class="details">
            <a href="/goods/detail?gid=<?php echo $goods['gid'] ?>">图文详情<span>（建议在wifi环境下进行浏览）</span>
                <img src="/images/go.png"></a>
        </div>
    </div>
    <div class="exchange">
        <div class="count">
            <img src="/images/+.png" onclick="numAdd(this)">
            <input type="text" name="number" value="1" />
            <img src="/images/-.png" onclick="numDec(this)">
        </div>
        <div class="button"><a href="javaScript:void(0)" class="btn redeem-now">立即兑换</a></div>
        <div class="button add"><a href="javaScript:void(0)" class="btn add-to-cart">加入购物车</a></div>
    </div>
</div>
<script>
    $(".redeem-now").click(function(){
        var count = parseInt($("input[name=number]").val());
        if(count <= 0){
            return
        }
        var param = {count: count, gid: <?php echo $goods['gid'] ?>};
        $._ajax('/redeem/cart/ajax-add-goods', param, 'POST', 'JSON', function(json){
            if(json.code > 0){
                window.location.href = '/redeem/cart/goods-list';
            }else{
                alert('添加失败');
            }
        });
    });

    $(".add-to-cart").click(function(){
        var count = parseInt($("input[name=number]").val());
        if(count <= 0){
            return
        }
        var param = {count: count, gid: <?php echo $goods['gid'] ?>};
        $._ajax('/redeem/cart/ajax-add-goods', param, 'POST', 'JSON', function(json){
            if(json.code > 0){
//                window.location.href = '/redeem/cart/goods-list';
            }else{
                alert('添加失败');
            }
        });
    });
</script>
</html>