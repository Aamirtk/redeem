<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <title>创意商城-蓝海创意云-vsochina.com</title>
    <meta name="keywords" content="创意云平台"/>
    <meta name="description" content="创意云平台"/>
    <!--公用样式-->
    <link rel="stylesheet" type="text/css" href="https://account.vsochina.com/static/css/base.css"/>
    <link rel="stylesheet" type="text/css" href="https://www.vsochina.com/resource/css/base.css"/>
    <!--弹框样式-->
    <link rel="stylesheet" type="text/css" href="https://account.vsochina.com/static/css/bomb.css"/>
    <link rel="stylesheet" type="text/css" href="https://account.vsochina.com/static/css/uc/dialog-new.css"/>

    <link rel="stylesheet" type="text/css"
          href="https://account.vsochina.com/static/kendo/styles/kendo.common.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="https://account.vsochina.com/static/kendo/styles/kendo.default.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://www.vsochina.com/resource/css/jquery-ui.min.css"/>

    <link rel="stylesheet" type="text/css" href="https://account.vsochina.com/static/css/login/common.css?v=20150810"/>
    <link rel="stylesheet" type="text/css" href="https://account.vsochina.com/static/font/login/iconfont.css"/>

    <link rel="stylesheet" type="text/css" href="https://account.vsochina.com/static/css/uc/usercenter.css">
    <link rel="stylesheet" type="text/css" href="https://mall.vsochina.com/static/css/user_shop.css">
    <link rel="stylesheet" type="text/css" href="https://mall.vsochina.com/static/css/popout.css">
    <link rel="stylesheet" type="text/css" href="/css/user_rc.css">

    <script src="https://account.vsochina.com/static/js/jquery-1.8.2.min.js"></script>
    <script src="https://account.vsochina.com/static/js/jquery-ui.min.js"></script>
    <script src="https://account.vsochina.com/static/js/cookie.js"></script>
    <script src="https://account.vsochina.com/static/kendo/js/kendo.web.min.js"></script>
    <script src="https://www.vsochina.com/control/admin/tpl/js/My97DatePicker/WdatePicker.js"></script>
    <script src="https://www.vsochina.com/resource/multi_uploadify/jquery.uploadify.js"></script>
    <script src="https://www.vsochina.com/resource/js/system/vs.js"></script>
    <script src="/js/tools.js"></script>
    <script src="https://mall.vsochina.com/static/js/popout.js"></script>
    <!-- global nav -->
</head>
<body>
<!-- header top start -->
<script type="text/javascript" charset="utf-8" src="https://account.vsochina.com/static/js/vsoheader.js"></script>
<div class="uc-hd clearfix">
    <div class="warp">
        <div class="uc-hd-left pull-left">
            <a href="http://www.vsochina.com"><img src="https://account.vsochina.com/static/images/uc/vso-logo-uc.png"></a>
            <span>用户中心</span>
        </div>

        <div class="uc-hd-right pull-right">
            <div class="task-search-bar uc-search-bar">
                <div class="task-search-fl uc-search-fl selected clearfix">
                    <span class="task-search-fl uc-search-fl span">
                        <b class="b">任务</b><i class="iconfont">&#xe606;</i>
                    </span>
                    <input id="search_content" class="search-input" type="text" value="请输入关键字" onkeydown="entersearch()"
                           style="color: rgb(155, 155, 155);">
                    <input class="search-btn" type="button" value="搜索" onclick="search()">
                </div>
                <div class="task-search-fl task-search-fl hot-service clearfix">热门搜索：
                    <a href="http://www.vsochina.com/index.php?do=task_list&task_searchh=漫画">漫画</a>
                    <a href="http://www.vsochina.com/index.php?do=task_list&task_searchh=原画">原画</a>
                    <a href="http://www.vsochina.com/index.php?do=task_list&task_searchh=Flash动画">Flash动画</a>
                    <a href="http://www.vsochina.com/index.php?do=task_list&task_searchh=游戏">游戏</a>
                    <a href="http://www.vsochina.com/index.php?do=task_list&task_searchh=网站建设">网站建设</a>
                    <a href="http://www.vsochina.com/index.php?do=task_list&task_searchh=室内设计">室内设计</a>
                    <a href="http://www.vsochina.com/index.php?do=task_list&task_searchh=网站建设">VI设计</a>
                    <a href="http://www.vsochina.com/index.php?do=task_list&task_searchh=网页设计">网页设计</a>
                    <a class="last" href="http://www.vsochina.com/index.php?do=task_list&task_searchh=音乐">音乐</a>
                </div>
                <ul class="task-search-ul uc-search-ul">
                    <li><a class="on" href="javascript:void(0);">任务</a></li>
                    <li><a href="javascript:void(0);">人才</a></li>
                    <li><a class="last" href="javascript:void(0);">商城</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- header top end -->
<div class="uc-content clearfix">
    <div class="warp">
        <div class="uc-top-content clearfix">
            <div class="warp">
                <div class="uc-nav">
                    <ul class="pull-left">
                        <li class="uc-mainpage "><a href="https://account.vsochina.com/home"><i
                                    class="uc-icon icon-main"></i>首页</a></li>
                        <li class="uc-account-setting "><a href="http://www.vsochina.com/index.php?do=ucenter"><i
                                    class="uc-icon icon-setting"></i>账户设置</a></li>
                        <li class="uc-task-hall "><a
                                href="http://www.vsochina.com/index.php?do=ucenter&amp;view=taskcenter&amp;op=employer"><i
                                    class="uc-icon icon-hall"></i>我的任务</a></li>
                        <li id="shop" class="uc-task-hall  "><a
                                href="http://mall.vsochina.com/account-config?show=ucentershopbaseinfo"><i
                                    class="uc-icon icon-shop"></i>创意商城</a></li>
                        <li class="uc-create "><a href="http://create.vsochina.com/ucenter/meeting/lst"><i
                                    class="uc-icon icon-create"></i>创意空间</a></li>
                        <li class="uc-my_home uc-top-nav-on"><a
                                href="http://www.vsochina.com/index.php?do=ucenter&amp;view=accountcenter&amp;op=setting"><i
                                    class="uc-icon icon-myhome"></i>个人主页</a></li>
                    </ul>
                    <ul class="uc-nav-right pull-right">
                        <li class="uc-my_render"><a target="_blank" href="http://render1.vsochina.com/">我的渲染</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- header top end -->
        <!-- ucenter  content navigation start -->
        <div class="uc-menu" id="sidebar_menu">
            <div class="menu-group uc-nav-active"><h3 class="menu-header clearfix"><a><i class="uc-icon icon-user"></i>主页设置</a>
                    <span class="open-close"><i class="uc-icon icon-minus"></i></span></h3>

                <div class="menu-content">
                    <ul>
                        <li>
                            <a href="http://www.vsochina.com/index.php?do=ucenter&amp;view=accountcenter&amp;op=setting">资料设置</a>
                        </li>
                        <li>
                            <a href="http://rc.vsochina.com/ucenter-subdomain-apply">域名管理</a>
                        </li>
                        <li>
                            <a href="http://www.vsochina.com/index.php?do=ucenter&amp;view=accountcenter&amp;op=manage_work">作品管理</a>
                        </li>
                        <li><a href="http://www.vsochina.com/talent_detail/isname/1/member_id/zhou81.html">个人主页</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- ucenter  content navigation end -->
        <?php $this->beginPage() ?>
        <?php $this->beginBody() ?>
        <?php $this->head() ?>
        <?php echo $content; ?>
        <?php $this->endBody() ?>
        <?php $this->endPage() ?>
    </div>
</div>

<script type="text/javascript" src="https://account.vsochina.com/static/js/vsofooter.js"></script>
<script type="text/javascript" src="https://account.vsochina.com/static/js/common.js"></script>
<script type="text/javascript" src="https://account.vsochina.com/static/js/experience.js?v=1"></script>
<div style="display: none;">
    <script type="text/javascript" src="https://account.vsochina.com/static/js/global_statistics.js"></script>
</div>
<script>
    $('#sidebar_menu').find('.menu-content').each(function () {
        $(this).find('a').each(function () {
            var href = $(this).attr('href');
            sidebar_uri = window.location.href;
            if (sidebar_uri == href) {
                $(this).addClass('on');
            }
        });
    });

    $(function () {
        var h = $(window).height() - 348;
        $('.uc-main').css('min-height', h + 'px');
        $(".open-close").on("click", function () {
            if ($(this).children(".uc-icon").hasClass("icon-plus")) {
                $(this).find(".uc-icon").removeClass("icon-plus").addClass("icon-minus");
                $(this).parents(".menu-group").addClass("uc-nav-active");
            }
            else {
                $(this).find(".uc-icon").addClass("icon-plus").removeClass("icon-minus");
                $(this).parents(".menu-group").removeClass("uc-nav-active");
            }
        });
    });
</script>
</body>
</html>