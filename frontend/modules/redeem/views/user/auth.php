<!DOCTYPE html>
<html>
<head>
    <title>认证</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="browsermode" content="application">
    <meta name="x5-page-mode" content="app">
    <link rel="stylesheet" type="text/css" href="/css/header.css">
    <link rel="stylesheet" type="text/css" href="/css/renzheng.css">
    <script src="/js/jquery-1.11.3.min.js"></script>
    <script src="/js/tools.js"></script>
    <style type="text/css">
        .msg-error{
            color: darkorange;
            font-size: 12px;
            text-align: center;
            margin: 5px auto 10px auto;
        }
    </style>
</head>
<body>
<div class="body-All">
    <form id="auth">
        <div class="title">
            <span>用户认证</span>
        </div>
        <input type="hidden" name="uid" value="<?php echo $uid ?>">
        <div class="form-group">
            <label><span>*</span>真实姓名</label>
            <input type="text" name="name" placeholder="请输入您的真实姓名"/>
        </div>
        <div class="form-group">
            <label><span>*</span>手&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;机</label>
            <input type="text" name="mobile" placeholder="请输入您的手机号码"/>
        </div>
        <div class="form-group">
            <label><span>*</span>邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱</label>
            <input type="text" name="email" placeholder="请输入您的常用邮箱"/>
        </div>
        <div class="form-group">
            <div class="box">
                <div class="type">
                    <div class="left">用户类型</div>
                    <div class="right"><a href="">提交</a></div>
                </div>
                <div class="pic">
                    <div class="img">
                        <img src="/images/pic04.png">
                    </div>
                    <div class="img">
                        <img src="/images/pic04.png">
                    </div>
                    <div class="img">
                        <img src="/images/pic04.png">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="box">
                <div class="type">
                    <div class="left">附属类型</div>
                    <div class="right"><a href="">提交</a></div>
                </div>
                <div class="pic">
                    <div class="img">
                        <img src="/images/pic04.png">
                    </div>
                    <div class="img">
                        <img src="/images/pic04.png">
                    </div>
                    <div class="img">
                        <img src="/images/pic04.png">
                    </div>
                </div>
            </div>
        </div>
        <div class="pb"></div>
        <div class="button">
            <a href="javaScript:void(0);" id="submit" class="btn">确认</a>
        </div>
    </form>
</div>
</body>
<script>
    $("#submit").on('click', function(){
        var param = $._get_form_json('#auth');
        $._ajax('/redeem/user/auth', param, 'POST', 'JSON', function(json){
            var code = json.code;
            var msg = json.msg
            if(code > 0){
                window.location.href = '/redeem/home/index?uid=' + json.data.uid;
            }else if(code == -20001){
                var error = $('<p class="msg-error">'+ msg +'</p>');
                $("input[name=name]").closest('div').after(error);
                error.fadeOut(1500);
            }else if(code == -20002){
                var error = $('<p class="msg-error">'+ msg +'</p>');
                $("input[name=mobile]").closest('div').after(error);
                error.fadeOut(1500);
            }else if(code == -20003){
                var error = $('<p class="msg-error">'+ msg +'</p>');
                $("input[name=email]").closest('div').after(error);
                error.fadeOut(1500);
            }
        });
    });

</script>
</html>