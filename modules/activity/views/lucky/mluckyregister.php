<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>为我点赞，《<?= $proj_name ?>》给您送现金红包</title>
    <meta name="keywords" content=""/>
    <meta name="description" content="我是中国原创小鲜肉，给我点赞，送你红包，动一动手指，支持我们"/>
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/public/resetcss/mreset.css"/>
    <link rel="stylesheet" type="text/css" href="/css/mluckyRegister.css"/>
    <script type="text/javascript" src="http://static.vsochina.com/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/public/fontSize/fontSize.js"></script>
</head>
<body>
<img src="/images/activity/luckyRegister/project/<?= $proj_id ?>.jpg" alt="" class="packets-img">
<div class="packets-box">
    <div class="packets-top"></div>
    <h2 class="font36">做文化创意,上蓝海创意云！</h2>

    <p class="font30">创意空间·专注文创项目孵化</p>

        <div class="packets-input clearfix">
            <input type="text" placeholder="请输入手机号码" class="packets-text" id="register_mobile" name="name">
        </div>
        <div class="packets-input pr260 clearfix">
            <input type="password" placeholder="请输入初始密码" class="packets-text" name="password" id="password">
            <input type="button" value="获取初始密码" class="packets-code-btn">
        </div>
        <div class="packets-submit-btn clearfix">
            <input type="hidden" name="project" id="project" value="<?= $proj_id ?>">
            <input type="button" value="为TA点赞并获取红包" class="packets-btn" onclick="login(this)">
        </div>
    <div class="packets-radio">
            <span class="packets-radio-span checked">
                <span>
                    <input type="radio">
                </span>
                我已阅读并同意蓝海创意云创意空间
            </span>
        <a href="http://maker.vsochina.com/m/activity/luckymoney20160205">【活动规则】</a>
    </div>

</div>
<div class="packets-footer">
    <img src="/images/activity/luckyRegister/logo-blue.png">

    <p>客服热线：<a href="tel:400-164-7979">400-164-7979</a></p>
</div>
<form method="post" action="<?=yii::$app->urlManager->createUrl(['activity/lucky/mlucky'])?>" id="success_form">
    <input type="hidden" value="" name="proj_name" id="form_proj_name">
    <input type="hidden" value="" name="qr_url" id="form_qr_url">
</form>
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    wx.config({
        debug: false,
        appId: '<?=$sdk['appId'];?>',
        timestamp: <?=$sdk['timestamp'];?>,
        nonceStr: '<?=$sdk['nonceStr'];?>',
        signature: '<?=$sdk['signature'];?>',
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'onMenuShareQZone'
        ]
    });

    wx.ready(function ()
    {
        var url = "http://maker.vsochina.com/activity/lucky/mluckyregister?proj_id=<?=$proj_id?>";
        var title='为我点赞，《<?= $proj_name ?>》给您送现金红包';
        var desc = '我是中国原创小鲜肉，给我点赞，送你红包，动一动手指，支持我们';
        var img = 'http://maker.vsochina.com/images/activity/luckyRegister/project/<?= $proj_id ?>.jpg';
        //重置分享到朋友圈链接
        wx.onMenuShareTimeline({
            title:title, // 分享标题
            link: url, // 分享链接
            imgUrl: img, // 分享图标
            desc: desc,
            success: function ()
            {
            },
            cancel: function ()
            {
            }
        });

        //重置分享到微信好友的链接
        wx.onMenuShareAppMessage({
            title:title, // 分享标题
            link: url, // 分享链接
            imgUrl: img, // 分享图标
            desc: desc,
            success: function ()
            {
            },
            cancel: function ()
            {
            }
        });

        wx.onMenuShareQQ({
            title:title, // 分享标题
            link: url, // 分享链接
            imgUrl: img, // 分享图标
            desc: desc,
            success: function ()
            {
            },
            cancel: function ()
            {
            }
        });

        wx.onMenuShareWeibo({
            title:title, // 分享标题
            link: url, // 分享链接
            imgUrl: img, // 分享图标
            desc: desc,
            success: function ()
            {
            },
            cancel: function ()
            {
            }
        });

        wx.onMenuShareQZone({
            title:title, // 分享标题
            link: url, // 分享链接
            imgUrl: img, // 分享图标
            desc: desc,
            success: function ()
            {
            },
            cancel: function ()
            {
            }
        });
    });
</script>
<script type="text/javascript">
    $(function () {
        $(".packets-code-btn").on("click", function () {
            var _this = $(this);
            if ($(this).hasClass("disabled")) {
                return false;
            } else {
                var mobile = $("#register_mobile").val();
                if (!mobile) {
                    alert("请填写手机号码");
                    return;
                }
                if ($(".checked").length == 0) {
                    alert("请您阅读协议   ");
                    return;
                }
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: {"mobile": mobile},
                    url: "<?=yii::$app->urlManager->createUrl(['/activity/lucky/register'])?>",
                    success: function (json) {
                        console.info(json);
                        if (json.ret != 13760) {
                            alert("注册失败," + json.message);
                        }
                        else {
                            var username = json.data.username;
                            $("#username").val(username);
                            _this.addClass("disabled");
                            var time = 60;
                            var timer = setInterval(function () {
                                if (time >= 1) {
                                    _this.val(time + "s后重新发送");
                                    time--;
                                }
                                else {
                                    clearInterval(timer);
                                    _this.val("获取初始密码").removeClass("disabled")
                                }
                            }, 1000);
                        }
                    },
                    beforeSend: function () {
                    }
                });
            }
        });
        $(".packets-radio-span").on("click", function () {
            if ($(this).hasClass("checked")) {

                $(this).removeClass("checked");
                $(this).find("input").prop("checked", false);
            } else {
                $(this).addClass("checked");
                $(this).find("input").prop("checked", true);
            }
        });
    });

    function login(btn)
    {
        var name = $("#register_mobile").val();
        var password = $("#password").val();
        var project = $("#project").val();

        if($.trim(name) == '')
        {
            alert("请填写手机号");
            return;
        }
        if(password == '')
        {
            alert("请填写初始密码");
            return;
        }
        if($(".checked").length == 0)
        {
            alert("请阅读并同意活动规则");
        }
        $.ajax({
            type:"POST",
            dataType:"json",
            data:{"name":name,"password":password,"project":project},
            url:"<?= yii::$app->urlManager->createUrl(['/activity/lucky/login']) ?>",
            success:function(json)
            {
                if(json.result)
                {
                    $("#form_proj_name").val(json.proj_name);
                    $("#form_qr_url").val(json.ticket);
                    $("#success_form").submit();
                }
                else
                {
                    alert(json.message);
                    $(btn).removeAttr("disabled");
                }
            },
            beforeSend:function()
            {
                $(btn).attr("disabled","disabled");
            }
        });
    }
</script>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?d426d199179c8a78bc6f6c2d577d9f91";
  var s = document.getElementsByTagName("script")[0];
  s.parentNode.insertBefore(hm, s);
})();
</script>
</body>
</html>