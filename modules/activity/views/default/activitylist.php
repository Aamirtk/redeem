<!DOCTYPE html>
<?php
use frontend\modules\talent\models\User;
$site = \backend\modules\content\models\Site::find()->limit(1)->one();
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
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.3.5/css/bootstrap.min.css?v1.4">
    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css?v1.4" />
    <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/font/userWork/font.css?v1.4" />
    <script type="text/javascript" charset="utf-8" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
</head>
<body>
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_header.php')?>
<!--/new-top-->
    <div class="act-list clearfix">
        <div class="ds-1200">
            <?php if (!empty($banner)):?>
            <a target="_blank" href="<?php if (isset($banner['link']) &&!empty($banner['link'])): ?><?= $banner['link'] ?><?php endif;?>" style="display: inline-block">
                <?php if (isset($banner['img']) &&!empty($banner['img'])):?>
                <img src="<?= $banner['img'] ?>">
                <?php endif;?>
            </a>
            <?php endif;?>
            <div class="actlist-nav clearfix">
                <ul class="act-link">
                    <li><a class="active">全部活动</a></li>
<!--                    <li><a>节日活动</a></li>-->
<!--                    <li><a>抽奖活动</a></li>-->
<!--                    <li><a>创意活动</a></li>-->
<!--                    <li><a>经典活动</a></li>-->
                </ul>
                <div class="act-area">
                    <span class="fc-gray">地区切换：</span>
                    <div class="change_area"><a class="top_style">全国</a>
                        <ul class="sareabox" style="display: none;">
                            <li style="color: #b6b6b6;"><i class="switch"></i>切换地区</li>
                            <?php foreach($city as $k => $c):?>
                                <li><a href="javascript:;" onclick="Activity.changeCity('<?= $k;?>')"><?= $c;?></a></li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="act-commonbox-align clearfix">
                <?php foreach($activity_list as $a):?>
                    <div class="act-commonbox">
                        <a target="_blank" href="<?= $a['link']?>"><img width="210px;" height="120px;" src="<?= $a['banner']?>"></a>
                        <a target="_blank" href="<?= $a['link']?>" title="<?= $a['title']?>" class="act-title"><?= $a['title']?></a><br>
                        <p class="fc-gray"><?= date('Y-m-d', $a['start_time']); ?></p>
                        <p class="act-brief"><?= $a['desc']?></p>
                    </div>
                <?php endforeach;?>
            </div>
        </div>

        <div class="m-warp">
            <div id="mainsrp-pager">
                <div class="m-page g-clearfix mt0">
                    <div class="wraper activity-page-div" style="display: none;">
                        <div class="inner clearfix">
                            <ul class="items activity-page"></ul>
                            <div class="total">共 0 页，</div>
                            <div class="form">
                                <span class="text">到第</span>
                                <!--<input class="input" type="number" value="2" min="1" max="100" >-->
                                <input class="skip-value input" type="text" value="2">
                                <span class="text">页</span>
                                <span onclick="skipList()" tabindex="0" role="button" class="btn">确定</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    Date.prototype.Format = function(fmt)
    { //author: meizz
        var o = {
            "M+" : this.getMonth()+1,                 //月份
            "d+" : this.getDate(),                    //日
            "h+" : this.getHours(),                   //小时
            "m+" : this.getMinutes(),                 //分
            "s+" : this.getSeconds(),                 //秒
            "q+" : Math.floor((this.getMonth()+3)/3), //季度
            "S"  : this.getMilliseconds()             //毫秒
        };
        if(/(y+)/.test(fmt))
            fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
        for(var k in o)
            if(new RegExp("("+ k +")").test(fmt))
                fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
        return fmt;
    }
</script>
    <script type="text/javascript">
        function skipList () {
            var value = $('.skip-value').val();
            var v = parseInt(value);
            if (!v)
            {
                v = 1;
                $('.skip-value').val(v)
            }
            if (Activity.pageCount >= v)
            {
                Activity.changePage(v);
            }
        }
        var Activity = {
            page : 1,
            city : 0,
            pageSize : '<?= yii::$app->params['activity_list_page_size'];?>',
            count : 0,
            pageCount : 0,
            initList : function(){
                var _self = this;
                $.ajax({
                    type : "POST",
                    data:{
                        city : _self.city,
                        page : _self.page,
                        pageSize : _self.pageSize
                    },
                    url : '<?= yii::$app->urlManager->createUrl("activity/default/list");?>',
                    dataType : "json",
                    success: function(json){
                        _self.loadHtml(json.list);
                        _self.loadPage(json.count);
                    }
                });
            },
            loadHtml : function(data){
                $(".act-commonbox-align").empty();
                $.each(data, function() {
                    var html = '<div class="act-commonbox">\
                                    <a target="_blank" href="' + this.link + '"><img width="210px;" height="120px;" src="' + this.banner + '"></a>\
                                    <a target="_blank" title="' + this.title + '" href="' + this.link + '" class="act-title">' + this.title + '</a><br>\
                                    <p class="fc-gray">' + new Date(this.start_time * 1000).Format('yyyy-MM-dd')  + '</p>\
                                    <p class="act-brief">' + this.desc + '</p>\
                                </div>';
                    $(".act-commonbox-align").append(html);
                })
            },
            loadPage : function(count){
                var _self = this;
                _self.count = count;
                if (count == 0) {
                    $('.activity-page-div').hide();
                    return;
                }
                var prev =   '<li class="item prev">\
                                <span class="num"><span class="glyphicon glyphicon-menu-left"></span><span>上一页</span></span>\
                             </li>';

                var next = '<li class="item next">\
                                <a class="num"><span>下一页</span><span class="glyphicon glyphicon-menu-right"></span></a>\
                            </li>';

                // 中间数量算法
                var pageCount = Math.ceil(count / _self.pageSize);
                _self.pageCount = pageCount;
                $(".total").html('共 ' + pageCount + ' 页，');
                $(".skip-value").val("");
                var start = 1;
                var end = pageCount;
                if (pageCount > 10)
                {
                    if (_self.page <= 5)
                    {
                        end = 10;
                    }
                    else if ((_self.page + 5) <= count)
                    {
                        start = _self.page - 4;
                        end = _self.page + 5;
                    }
                    else
                    {
                        start = pageCount - 9;
                        end = pageCount;
                    }
                }

                var page = '';
                for(var i = start;i < end + 1; i++){
                    var a = '';
                    if (i == _self.page){
                        a = 'active';
                    }
                    var t = '<li class="count-page item ' + a + '">\
                                <span class="num">' + i + '</span>\
                             </li>'
                    page += t;
                }

                $(".activity-page").html(prev + page + next);
                // 禁用上一页与下一页
                if (_self.page <= 1) {
                    $(".activity-page .prev").addClass('disabled');
                }
                else {
                    // 绑定上一页
                    $(".activity-page .prev").on('click', function(){_self.prevList()});
                }
                if (_self.page == _self.pageCount) {
                    $(".activity-page .next").addClass('disabled');
                }
                else {
                    // 绑定下一页
                    $(".activity-page .next").on('click', function(){_self.nextList()});
                }
                $(".activity-page .count-page").on('click', function(){
                    var _t = $(this);
                    if (!_t.hasClass('active')) {
                        var page = _t.find('.num').html();
                        _self.changePage(page);
                    }
                })
                $('.activity-page-div').show();
            },
            changeCity : function(city){
                var _self = this;
                _self.city = city;
                _self.page = 1;
                _self.initList();
            },
            changePage : function(page){
                var _self = this;
                _self.page = parseInt(page);
                _self.initList();
            },
            prevList : function(){
                var _self = this;
                var page = _self.page - 1;
                if (page > 0) {
                    _self.page = page;
                    _self.initList();
                }
            },
            nextList : function(){
                var _self = this;
                var page = _self.page + 1;
                if (page > 0) {
                    _self.page = page;
                    _self.initList();
                }
            }
        }

    </script>

<?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_footer.php')?>
    <script type="text/javascript">
        $(function(){
            Activity.loadPage('<?= $activity_count;?>');
        })
        $(".top_style,.sareabox").mouseover(function() {
            $(".sareabox").css({"display": "block"});
            $(".top_style").addClass("change_style");
        }).mouseout(function() {
            $(".sareabox").css({"display": "none"});
            $(".top_style").removeClass("change_style");
        });
        $(".change_area li").click(function() {
            var t = $(this).find('a').html();
            $(".top_style").text(t);
//            var index = $(this).index();
//            if(index == 1) {
//                $(".top_style").text("全国");
//            }
//            else if(index == 2) {
//                $(".top_style").text("上海");
//            }
//            else if(index == 3) {
//                $(".top_style").text("苏州");
//            }
//            else if(index == 4) {
//                $(".top_style").text("北京");
//            }
//            else if(index == 5) {
//                $(".top_style").text("广州");
//            }
        })
        $(".act-link a").click(function() {
           $(this).addClass("active").parent().siblings().children().removeClass("active");
        });
        $(".m-page .item").click(function() {
            $(this).addClass("active").siblings().removeClass("active");
        })
    </script>
</body>
</html>