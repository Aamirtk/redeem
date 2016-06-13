<!DOCTYPE html>
<?php
use frontend\modules\talent\models\User;
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?= $page_config['site_name'] ?></title>
    <meta name="keywords" content="<?= $page_config['seo_keywords'] ?>"/>
    <meta name="description" content="<?= $page_config['seo_desc'] ?>"/>
    <meta name="renderer" content="webkit"/>
    <meta name="baidu-site-verification" content="NpzvG27pvo" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.3.5/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css" />
    <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/font/userWork/font.css" />

    <script type="text/javascript" charset="utf-8" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
</head>
<body class="dsn-gray-bg">
<!--header-top-->

<script type="text/javascript" src="http://account.vsochina.com/static/js/jquery.validate.js"></script>
<!--/header-top-->
<!--new-top-->
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_header.php')?>
<!--/new-top-->

<div class="dsn-list-search clearfix">
    <div class="ds-1200">
        <div class="dsn-list-search-drop">
            <a href="javascript:;" class="dsn-list-search-link"><span class="dsn-list-search-word">全&nbsp; &nbsp;部</span>  <span class="dsn-triangle-up"></span></a>
            <ul class="dsn-list-search-drop-ul">
                <li data-type="0" class="active"><a href="javascript:;">全&nbsp; &nbsp;部</a></li>
                <?php foreach($indus as $in):?>
                    <?php if(isset($in['indus'])):?>
                        <li data-type="<?= $in['indus_pid']?>"><a href="javascript:;"><?= $in['indus']['name']?></a></li>
                    <?php endif;?>
                <?php endforeach;?>
            </ul>
        </div>
        <!--
        <a href="" class="dsn-list-search-link">编辑精选</a>
        <a href="" class="dsn-list-search-link">完成度</a>
        <a href="" class="dsn-list-search-link">最新上传</a>
        -->
        <a href="/project/default/create" class="dsn-btn-black pull-right">+ 新项目申请</a>
    </div>
</div>


<div class="dsn-caselist">
    <div class="ds-1200">
        <div class="row" id="list-body">

        </div>

        <a href="javascript:;" class="dsn-more dsn-more-1">加载更多</a>
        <a href="javascript:;" class="dsn-more dsn-more-2" style="display: none;">加载中...</a>

    </div>
</div>
<script type="text/javascript" src="http://static.vsochina.com/libs/jquery.lazyload/1.9.5/jquery.lazyload.js"></script>
<script type="text/javascript" src="/js/dreamSpace.js"></script>
<script type="text/javascript">

    /*导航栏 下拉菜单*/
    $(".dsn-list-search-drop").hover(function(){
        $(this).addClass("active");
        $(this).siblings().removeClass("active");
    },function(){
        $(this).removeClass("active");
    });


    $(".dsn-list-search-drop-ul li").on("click",function(){
        var text = $(this).find("a").text();
        $(this).addClass("active").siblings().removeClass("active");
        $(".dsn-list-search-drop .dsn-list-search-link .dsn-list-search-word").text(text);
        $(".dsn-list-search-drop").removeClass("active");
    });

    var milProjectCtl = {
        type : 0,
        page : 1,
        isLoading : false,
        initList : function(isAppend){
            var self = this;
            if(!self.isLoading){
                self.isLoading = true;
                if(isAppend){
                    this.page = this.page + 1;
                    $(".dsn-more-1").hide();
                    $(".dsn-more-2").show();
                }
                $.ajax({
                    type : "POST",
                    data:{
                        type : self.type,
                        page : self.page
                    },
                    url : '<?= yii::$app->urlManager->createUrl("project/default/act-list");?>',
                    dataType : "json",
                    success: function(json){
                        $(".dsn-more-1").show();
                        self.isLoading = false;
                        if(isAppend){
                            $(".dsn-more-1").show();
                            $(".dsn-more-2").hide();
                        }
                        if(json.list.length < parseInt("<?= yii::$app->params['home_list_page_size']?>")){
                            self.page = self.page - 1;
                            $(".dsn-more-1").hide();
                        }
                        var html = "";
                        if(!isAppend){
                            $("#list-body").html("");
                        }

                        $.each(json.list,function(index, element){
                            if($("[data-id='" + element.proj_id + "']").length == 0&&element.project){
                                html += self.loadHtml(element);
                            }
                        });

                        if(!isAppend){
                            $("#list-body").html(html);
                        }
                        else{
                            $("#list-body").append(html);
                        }

                        $(".col-xs-3:hidden").fadeIn(300);
                    }
                });
            }
        },
        loadHtml : function(data){
            var html = '<div class="col-xs-3" data-id="' + data.proj_id + '" style="display:none;">\
            <dl class="dsn-caselist-dl">\
            <dt><a href="/project/' + data.proj_id + '"><img src="' + data.project.proj_icon + '" alt="" width="289" height="165"></a></dt>\
            <dd class="ds-project-mark">\
            <!--<i class="ds-icon-16 icon-16-praise pull-right"></i>-->\
            <a href="/project/' + data.proj_id + '">' + data.project.proj_name + '</a></dd>\
            <dd class="ds-project-bread">' + data.proj_tag + '</dd>\
            <dd><span class="color-green">' + data.fans_num + '</span> 支持</dd>\
            </dl>\
            </div>';
            return html;
        }
    }

    $(function(){
        //初始化列表信息
        milProjectCtl.initList();

        //加载更多点击事件
        $(".dsn-more-1").on("click",function(){
            milProjectCtl.initList(true);
        });

        //切换类型初始化列表
        $(".dsn-list-search-drop-ul li").on("click", function(){
            milProjectCtl.page = 1;
            milProjectCtl.type = $(this).attr("data-type");
            milProjectCtl.initList(false);
        });
    });

</script>
<script type="text/javascript" src="/js/project_action.js"></script>
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_footer.php')?>
</body>
</html>