<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $_page_config['title'] ?></title>
    <meta name="keywords" content="<?php echo $_page_config['keyword'] ?>"/>
    <meta name="description" content="<?php echo $_page_config['description'] ?>"/>
    <meta name="renderer" content="webkit"/>
    <meta name="baidu-site-verification" content="NpzvG27pvo"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link type="text/css" rel="stylesheet"
          href="http://static.vsochina.com/libs/bootstrap/3.3.5/css/bootstrap.min.css?v1.4">
    <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/font/userWork/font.css?v1.4"/>
    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css?v1.4"/>
    <link type="text/css" rel="stylesheet" href="/css/studiolist.css">
    <script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
</head>
<body>
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_header.php') ?>

<!-- content -->
<div class="stuidio-contentbox">
    <div class="stuidio-content">
        <div class="stuidio-top overflowH">
            <a href="http://maker.vsochina.com"><img src="http://maker.vsochina.com/images/list-page/shome.png">创意空间</a><span>&nbsp;>&nbsp;工作室</span>
            <!--
            <div class="t-search overflowH">
                <input class="input" type="text" placeholder="搜索团队" name="username" value autocomplete="off">
                <input class="searchButton" type="button">
            </div>-->
        </div>
        <div class="stuidio-bottom overflowH">
            <div class="stuidio-left overflowH">
                <!--
                <div class="stuidio-l-top overflowH">
                    <h1>工作室分类</h1>

                    <div class="list">
                        <a class="list-p1 cur" href=""><span class="p1"></span>所有分类（25）</a>
                        <a class="list-p2" href=""><span class="p2"></span>影视综艺</a>
                        <a class="list-p3" href=""><span class="p3"></span>原创漫画</a>
                        <a class="list-p4" href=""><span class="p4"></span>独立游戏</a>
                        <a class="list-p5" href=""><span class="p5"></span>网络文学</a>
                        <a class="list-p6" href=""><span class="p6"></span>原创音乐</a>
                    </div>
                </div>
                -->
                <div class="stuidio-l-bottom">
                    <h2>立刻加入创意空间</h2>

                    <div class="list2">
                        <p><span></span>成立属于自己的在线工作室</p>

                        <p><span></span>创建原创项目，填写项目资料</p>

                        <p><span></span>寻找/邀请合作伙伴共同创作</p>

                        <p><span></span>获得免费的创作工具与基础服务</p>

                        <p><span></span>展示项目精彩内容，寻求孵化机会</p>

                        <p><span></span>与项目粉丝互动，与投资人见面</p>
                    </div>
                    <div class="button-box">
                        <?php if($username):?>
                            <a href="https://cz.vsochina.com/project/project" rel="nofollow" class="button">成立工作室</a>
                        <?php else:?>
                            <a href="javascript:openLoginpop()" rel="nofollow" class="button">成立工作室</a>
                        <?php endif;?>
                    </div>
                </div>

            </div>
            <div class="stuidio-right overflowH">
                <?php if (!empty($_studio_list['_items'])): ?>
                    <?php foreach ($_studio_list['_items'] as $val): ?>
                        <a class="room" href="/studio/index/detail?s_id=<?= $val['s_id']?>" title="<?php echo $val['user']['username']?>的工作室">
                            <?php if (!empty($val['icon'])):?>
                                <img src="<?php echo $val['icon']; ?>">
                                <?php else:?>
                                <img src="http://maker.vsochina.com/images/list-page/color-purple.png" />
                            <?php endif;?>
                            <span><?=$val['studio_name']; ?></span>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- /content -->

<?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_footer.php') ?>
</body>
</html>