<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>《<?=$proj_name?>》团队赠送您一次抽红包的机会</title>
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/public/resetcss/mreset.css"/>
    <link rel="stylesheet" type="text/css" href="/css/mdetail.css?v=1"/>
    <script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/public/fontSize/fontSize.js"></script>
</head>
<body>
    <div class="packets-bg">
        <div class="packets-box">
            <p class="packets-title">为了感谢您的支持</p>
            <p class="packets-name">《<?=$proj_name?>》团队赠送您一次抽红包的机会</p>
            <img src="<?=$src?>">
        </div>
    </div>
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
            var url = "http://maker.vsochina.com/activity/lucky/mluckymoney";
            //重置分享到朋友圈链接
            wx.onMenuShareTimeline({
                title: '点赞拜年送红包-速来蓝海创意云领现金红包', // 分享标题
                link: url, // 分享链接
                imgUrl: 'http://maker.vsochina.com/images/spring_share_logo.jpg', // 分享图标
                desc: '蓝海创意云助力原创项目，发猴年新春拜年红包!',
                success: function ()
                {
                },
                cancel: function ()
                {
                }
            });

            //重置分享到微信好友的链接
            wx.onMenuShareAppMessage({
                title: '点赞拜年送红包-速来蓝海创意云领现金红包', // 分享标题
                link: url, // 分享链接
                imgUrl: 'http://maker.vsochina.com/images/spring_share_logo.jpg', // 分享图标
                desc: '蓝海创意云助力原创项目，发猴年新春拜年红包!',
                success: function ()
                {
                },
                cancel: function ()
                {
                }
            });

            wx.onMenuShareQQ({
                title: '点赞拜年送红包-速来蓝海创意云领现金红包', // 分享标题
                link: url, // 分享链接
                imgUrl: 'http://maker.vsochina.com/images/spring_share_logo.jpg', // 分享图标
                desc: '蓝海创意云助力原创项目，发猴年新春拜年红包!',
                success: function ()
                {
                },
                cancel: function ()
                {
                }
            });

            wx.onMenuShareWeibo({
                title: '点赞拜年送红包-速来蓝海创意云领现金红包', // 分享标题
                link: url, // 分享链接
                imgUrl: 'http://maker.vsochina.com/images/spring_share_logo.jpg', // 分享图标
                desc: '蓝海创意云助力原创项目，发猴年新春拜年红包!',
                success: function ()
                {
                },
                cancel: function ()
                {
                }
            });

            wx.onMenuShareQZone({
                title: '点赞拜年送红包-速来蓝海创意云领现金红包', // 分享标题
                link: url, // 分享链接
                imgUrl: 'http://maker.vsochina.com/images/spring_share_logo.jpg', // 分享图标
                desc: '蓝海创意云助力原创项目，发猴年新春拜年红包!',
                success: function ()
                {
                },
                cancel: function ()
                {
                }
            });
        });
    </script>
</body>
</html>