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
    <link rel="stylesheet" type="text/css" href="/css/xinzengdizhi.css">
    <script src="/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $('.back').click(function(){
                history.back();
            });
            $('.type-bottom span').click(function(){
                $('.type-bottom span').removeClass('active');
                $(this).addClass('active');
            });
            $('.time-bottom span').click(function(){
                $('.time-bottom span').removeClass('active');
                $(this).addClass('active');
            });
            $('.checkbox').click(function(){
                $(this).toggleClass('checked');
            });
        });
    </script>
</head>
<body>
<div class="body-All">
    <header>
        <div class="back"><a><img src="/images/back.png"></a></div>
        新增地址
        <div class="determine">确定</div>
    </header>
    <div class="box">
        <div class="form-group">
            <label>收货人姓名</label>
            <input type="text" placeholder="请输入收货人姓名" />
        </div>
        <div class="form-group">
            <label>收货人手机</label>
            <input type="text" placeholder="请输入收货人手机号码" />
        </div>
        <div class="address">
            <div>收货地址</div>
            <div class="mt">
                <label>省份</label>
                <select>
                    <option>请选择</option>
                </select>
            </div>
            <div class="mt">
                <label>城市</label>
                <select>
                    <option>请选择</option>
                </select>
            </div>
            <div class="mt">
                <label>区县</label>
                <select>
                    <option>请选择</option>
                </select>
            </div>
            <div class="mt">
                <label>详细<br>地址</label>
                <textarea></textarea>
            </div>
            <div class="mt">
                <div class="top">地址类型</div>
                <div class="type-bottom bottom">
                    <span class="active">家庭地址</span>
                    <span>公司地址</span>
                    <span>其他</span>
                </div>
            </div>
            <div class="mt">
                <div class="top">常用收货时间</div>
                <div class="time-bottom bottom">
                    <span class="active">一周七日</span>
                    <span>工作日</span>
                    <span>双休及节假</span>
                </div>
            </div>
            <div class="mt checkbox">
                <input type="checkbox"/>设为默认地址
            </div>
        </div>
    </div>
    <div class="button">
        <a href="" class="btn">保存</a>
    </div>
</div>
</body>
</html>