<div class="theme-white-box-50">
    <input type="hidden" id="work_id" name="work_id" value="<?= yii::$app->request->get('id') ?>">

    <div class="work_detail"></div>
    <div class="comment_list">
        <p class="nctitle">评论 ( <span name="count_comment">0</span> )</p>
        <textarea name="content" id="content" class="textarea"></textarea>

        <div class="bcmtbtn clearfix">
            <input type="hidden" id="hidden_pid" name="hidden_pid" value="0">
            <button class="btn btn-darkgrey pull-right" id="create_comment" onclick="create_comment()">发布</button>
            <span class="ztag color-red" style="display: none;">请输入评论内容</span>
        </div>
        <ul class="w-remarklist"></ul>

    </div>
</div>
<style>
    ._more_comment {
        text-align: center;
        line-height: 40px;
        display: block;
        margin-top: 10px;
    }

    ._more_comment:hover {
        background: #ffeeee;
    }

    ._comment_empty {
        text-align: center;
        line-height: 40px;
    }

    .w-pay-box .w-pay-btn {
        background-color: #f60;
        border-radius: 5px;
        color: #fff;
        display: inline-block;
        font-size: 16px;
        line-height: 50px;
        text-align: center;
        text-decoration: none;
        width: 210px;
    }
</style>
<div class="sharework" style="display: none;">
    <a data-cmd="qq" title="分享到qq"> <i class="qq"></i> </a>
    <a data-cmd="qzone" title="分享到qq空间"><i class="zoom"></i></a>
    <a data-cmd="tsina" title="分享到新浪微博"><i class="weibo"></i></a>
    <a data-cmd="weixin" title="分享到微信"><i class="weixin"></i>

        <div class="weixin-box">
            <div class="wx-triangle">
                <span><em></em></span>
            </div>
            <div class="weixin-box-img"></div>
            <p>创意云微信公众号</p>
        </div>
    </a>
</div>

<!--/分享-->
<script src="http://static.vsochina.com/libs/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="http://static.vsochina.com/libs/masonry/3.3.2/masonry.pkgd.min.js"></script>
<script src="/js/jquery.qrcode.min.js"></script>
<script src="/js/share.js"></script>
<script src="/js/talent_space.js"></script>
<!--<script type="text/javascript" src="http://www.vsochina.com/resource/js/userWork/jquery.history.js"></script>-->
<script type="text/javascript">
    var work_id = $("#work_id").val();
    loadWorkById(work_id);

    $("#content").on("keyup", function () {
        if ($.trim($(this).val()) == '') {
            $(".color-red").show();
        }
        else {
            $(".color-red").hide();
        }
    });

    $(document).on('click', '#_show_more_comment', function () {
        var now_page = $(this).attr('_now_page');
        if (!now_page) {
            return false;
        }
        var next_page = parseInt(now_page) + 1;
        loadComment(next_page);
    });

    function setPraiseStatus(status) {
        var username = getCookie('vso_uname');
        if (username == '') {
            alert("登录后才能进行此操作");
            return false;
        }
        $(".icon-heart").parent().attr("disabled", true);
        $.ajax({
            type: "POST",
            dataType: "JSON",
            async: false,
            data: {
                'status': status
            },
            url: "/personal/work/praise?id=" + $("#work_id").val(),
            success: function (json) {

                $(".icon-heart").parent().removeAttr("disabled");
                if (json.result) {
                    $("i.icon-heart").parent().attr("title", json.data.praise_title);
                    var onclick = '';
                    if (json.data.praise_status == 1) {
                        onclick = 'setPraiseStatus(0)';
                        $(".icon-heart").addClass("on")
                    }
                    else {
                        onclick = 'setPraiseStatus(1)';
                        $(".icon-heart").removeClass("on")
                    }
                    $("i.icon-heart").parent().attr("onclick", onclick);
                    // 更新热度
                    $("#hidden_praise_num").val(parseInt(json.data.praise));
                    $("span[name='hot_num']").html(parseInt(json.data.praise) + parseInt($("span[name='count_comment']").html()));
                    $("span[name='praise_num']").html(parseInt(json.data.praise));
                }
            }
        });
    }

    function loadWorkById(work_id) {
        $("#work_id").val(work_id);
        /*var url = "/personal/work/view/" + work_id;
         var userAgent = window.navigator.userAgent.toLowerCase();
         $.browser.msie9 = $.browser.msie && /msie 9\.0/i.test(userAgent);
         $.browser.msie8 = $.browser.msie && /msie 8\.0/i.test(userAgent);
         var url_ie = "http://www.vsochina.com" + url;
         if (($.browser.msie9 || $.browser.msie8) && (window.location.href != url_ie)) {
         window.location.href = url_ie;
         }
         else if (window.location.href != url_ie) {
         window.history.pushState({url: url}, document.title, url);
         }*/
        loadWorkDetail();
        loadWorkPraiseStatus();
        ajaxGetLike();
        loadComment();
        shareWork();
    }

    function loadWorkDetail() {
        $.ajax({
            type: "GET",
            dataType: "JSON",
            async: false,
            url: "/personal/work/load-work-detail?id=" + $("#work_id").val(),
            success: function (json) {
                $(".work_detail").empty();
                var work_detail_div_html =
                    '<div class="theme-action">\
                        <a href="javascript:;"><i class="icon-24 icon-heart"></i></a>\
                        <a href="javascript:;" class="icon-share-box"><i class="icon-24 icon-share"></i></a>\
                    </div>\
                    <div class="img-600"></div>\
                    <div class="masonry-text"></div>\
                    <div class="commercial-tip-div" style="display: none;">\
                        <span>禁止商业使用</span>\
                    </div>\
                    <div>\
                        <span class="work-title" title="' + json.work_name + '">' + json.work_name + '</span>\
                    </div>\
                    <div class="theme-info box">\
                        <span class="date">' + json.on_time + '</span>\
                        <span class="cmt">评论：（<span name="count_comment" style="margin-right: 0px;">0</span>）</span>\
                        <span class="hotnum">热度：（<span name="hot_num" style="margin-right: 0px;">0</span>）</span>\
                        <span class="praisenum">点赞：（<span name="praise_num" style="margin-right: 0px;">0</span>）</span>\
                        <input type="hidden" id="hidden_praise_num" name="hidden_praise_num" value="0">\
                    </div>';
                if (json.username == '<?php echo $this->context->vso_uname  ?>') {
                    work_detail_div_html += '<div class="w-pay-box clearfix"><a class="w-pay-btn" href="<?php echo yii::$app->params['shop_frontendurl'] . yii::$app->urlManager->createUrl(['/shop/goods/add','work_id'=>$work_id]);?>" target="_blank"> + 同步到商品</a></div>';
                }
                work_detail_div_html += '<div class="theme-pager clearfix"></div>\
                    <div class="theme-square-pic clearfix"></div>';

                $(".work_detail").append(work_detail_div_html);
                if (json.lable.length > 0) {
                    $("div.theme-info").append('<br>');
                    $.each(json.lable, function (idx, obj) {
                        $("div.theme-info").append('<span class="tag">#' + obj + '</span>');
                    });
                }
                if (json) {
                    var html = '';
                    if (json.pic_or_video == 1 || json.pic_or_video == 4) {
                        html += getCopyrightHtml(json);
                    }
                    else if (json.pic_or_video == 2 || json.pic_or_video == 5) {
                        if (json.work_url == '' || json.work_url == null) {
                            var videoExt = GetFileExt(json.work_link);
                            if (videoExt == 'mp4' || videoExt == 'webm' || videoExt == 'ogg') {
                                html = '<video width="600" height="396" controls="controls">\
                                            <source src="' + json.work_link + '" type="video/ogg">\
                                        <source src="' + json.work_link + '" type="video/mp4">\
                                        <source src="' + json.work_link + '" type="video/webm">\
                                        </video>';
                            }
                            else {
                                html = '<div id="media_container" fwin="display">\
                                            <div id="mediaplayer_wrapper" style="position: relative; width: 600px; height: 408px; margin: 0 auto;" fwin="display">\
                                                <embed src="' + json.work_link + '" quality="high" width="600" height="396" align="middle" allowScriptAccess="always" allowFullScreen="true" mode="transparent" type="application/x-shockwave-flash"></embed>\
                                            </div>\
                                        </div>';
                            }
                        }
                        else {
                            var videoExt = GetFileExt(json.work_url);
                            if (videoExt == 'mp4' || videoExt == 'webm' || videoExt == 'ogg') {
                                html = '<video width="600" height="408" controls="controls">\
                                        <source src="' + json.work_url + '" type="video/ogg">\
                                    <source src="' + json.work_url + '" type="video/mp4">\
                                    <source src="' + json.work_url + '" type="video/webm">\
                                    </video>';
                            }
                            else {
                                html = '<div id="media_container" fwin="display">\
                                            <div id="mediaplayer_wrapper" style="position: relative; width: 600px; height: 408px; margin: 0 auto;" fwin="display">\
                                                <object width="100%" height="100%" type="application/x-shockwave-flash" data="http://www.vsochina.com/resource/js/jwplayer/player.swf" bgcolor="#000000" id="mediaplayer" name="mediaplayer" tabindex="0" fwin="display">\
                                                    <param name="allowfullscreen" value="true">\
                                                    <param name="allowscriptaccess" value="always">\
                                                    <param name="seamlesstabbing" value="true"><param name="wmode" value="opaque">\
                                                    <param name="flashvars" value="netstreambasepath=http%3A%2F%2Fwww.vsochina.com%2Findex.php%3Fdo%3Dactivity%26view%3Dprize%26op%3Dprize_all&amp;id=mediaplayer&amp;file=' + json.work_url + '&amp;image=&amp;autostart=false&amp;controlbar.position=over">\
                                                </object>\
                                            </div>\
                                        </div>';
                            }
                        }
                    }
                    else if (json.pic_or_video == 3) {
                        html = json.description;
                    }
                    $(".img-600").append(html);
                    if (json.work_name == '' || json.work_name == null) {
                        $(".work-title").parent().hide();
                    }
                    if (json.pic_or_video != 3 && json.description) {
                        $(".masonry-text").append('<p>' + json.description + '</p>');
                    }
                    $("#hidden_praise_num").val(parseInt(json.likenum));
                    $("span[name='hot_num']").html(parseInt(json.likenum) + parseInt($("span[name='count_comment']").html()));
                    $("span[name='praise_num']").html(parseInt(json.likenum));
                    if (json.prev) {
                        $(".theme-pager").append('<a class="pull-left" href="/personal/work/view/' + json.prev + '">上一篇 &gt;</a>');
                    }
                    if (json.next) {
                        $(".theme-pager").append('<a class="pull-right" href="/personal/work/view/' + json.next + '">下一篇 &gt;</a>');
                    }
                    if (json.sliders.length > 0) {
                        $.each(json.sliders, function (idx, obj) {
                            $(".theme-square-pic").append('<a href="/personal/work/view/' + obj.work_id + '" title="' + obj.work_name + '"><img src="' + obj.img_src + '"></a>');
                        });
                    }
                }
            }
        });
    }
    /**
     * 作品详情，版权设置html
     * @param copyright （0=>无，1=>禁止看大图，2=>禁止右键，3=>禁止商业，4=>禁止123）
     */
    function getCopyrightHtml(work) {
        var html = '';
        switch (work['copyright']) {
            case "0":
                html = '<a target="_blank" class="w-imgbox" href="' + work['work_url'] + '"><img src="' + work['img_src'] + '" alt="' + work['work_name'] + '"></a>';
                break;
            case "1":
                html = '<img src="' + work['img_src'] + '" alt="' + work['work_name'] + '">';
                break;
            case "2":
                html = '<img src="' + work['img_src'] + '" alt="' + work['work_name'] + '">';
                disableRightClickMenu();
                break;
            case "3":
                html = '<img src="' + work['img_src'] + '" alt="' + work['work_name'] + '">'
                $(".commercial-tip-div").show();
                break;
            case "4":
                html = '<img src="' + work['img_src'] + '" alt="' + work['work_name'] + '">';
                $(".commercial-tip-div").show();
                disableRightClickMenu();
                break;
        }
        return html;
    }

    function disableRightClickMenu() {
        $(document).ready(function () {
            $(document).bind("contextmenu", function (e) {
                return false;
            });
            $(document).bind("selectstart", function (e) {
                return false;
            });
        });
    }

    function loadWorkPraiseStatus() {
        $.ajax({
            type: "GET",
            dataType: "JSON",
            async: false,
            url: "/personal/work/load-work-praise-status?id=" + $("#work_id").val(),
            success: function (json) {
                $("i.icon-heart").parent().attr("title", json.praise_title);
                var onclick = '';
                if (json.praise_type == 0) {
                    if (json.praise_status == 1) {
                        onclick = 'setPraiseStatus(0)';
                        $("i.icon-heart").addClass("on");
                    }
                    else {
                        onclick = 'setPraiseStatus(1)';
                        $("i.icon-heart").removeClass("on");
                    }
                } else {//json.praise_type==1
                    onclick = 'setPraiseStatusNew(event)';
                    $("i.icon-heart").addClass("on");
                }

                $("i.icon-heart").parent().attr("onclick", onclick);
            }
        });
    }

    function ajaxGetLike() {
        $.ajax({
            type: "GET",
            dataType: "JSON",
            async: false,
            url: "/personal/work/ajax-get-like?workid=" + $("#work_id").val(),
            success: function (json) {
                $("span[name='praise_num']").html(parseInt(json.like_num));
                $("span[name='hot_num']").html(parseInt($("span[name='praise_num']").html()) + parseInt($("span[name='count_comment']").html()));
            }
        });
    }

    function loadComment(page) {
        if (typeof (page) == 'undefined') {
            page = 1;
        }
        $.ajax({
            type: "GET",
            dataType: "JSON",
            async: false,
            url: '<?php echo yii::$app->urlManager->createUrl(['/personal/work/load-comment-list','id' => $work_id]);?>&page=' + page,//"/personal/work/load-comment-list?id=" + $("#work_id").val(),
            success: function (data) {
                var html = '';
                var json = data.data.list;
                if (json.length > 0) {
                    $("span[name='count_comment']").html(json.length);
                    $("span[name='hot_num']").html(parseInt(json.length) + parseInt($("#hidden_praise_num").val()));
                    $.each(json, function (idx, obj) {
                        var delete_html = '';
                        var reply_html = '';
                        if (getCookie('vso_uname') == obj.username) {
                            delete_html = '<a href="javascript:;" class="w-reply" onclick="delete_comment(' + obj.comment_id + ')">删除</a>';
                            reply_html = '';
                        }
                        else {
                            delete_html = '';
                            reply_html = '<a class="w-reply" href="javascript:;" onclick="reply_comment(' + obj.comment_id + ')"><span>回复</span></a>';
                        }
                        html +=
                            '<li data-id="' + obj.comment_id + '">\
                            <a target="_blank" href="/talent/' + obj.username + '">\
                                <img src="' + obj.avatar + '" alt="' + obj.nickname + '">\
                                </a>' + delete_html + reply_html + '\
                                <p class="w-remarkdetail">\
                                    <a class="w-nickname" target="_blank" href="/talent/' + obj.username + '">' + obj.nickname + '</a>\
                                    <span class="w-towords">' + obj.content + '</span>\
                                </p>\
                            </li>';
                        if (obj.sub.length > 0) {
                            $.each(obj.sub, function (sidx, sobj) {
                                var sdelete_html = '';
                                if (getCookie('vso_uname') == sobj.username) {
                                    sdelete_html = '<a href="javascript:;" class="w-reply" onclick="delete_comment(' + sobj.comment_id + ')">删除</a>';
                                }
                                else {
                                    sdelete_html = '';
                                }
                                html +=
                                    '<li class="w-replyitem" data-id="' + sobj.comment_id + '">\
                                    <a target="_blank" href="/talent/' + sobj.username + '">\
                                        <img src="' + sobj.avatar + '" alt="' + sobj.nickname + '">\
                                        </a>' + sdelete_html + '\
                                        <div class="w-remarkdetail">\
                                            <div class="w-replyto">\
                                                <a target="_blank" href="/talent/' + sobj.username + '" class="w-nickname">' + sobj.nickname + '</a>\
                                                <span>' + sobj.str_on_time + '</span>\
                                                <p>回复\
                                                    <a target="_blank" href="/talent/' + obj.username + '" class="w-replyname">' + obj.nickname + '</a>：\
                                                    <span>' + obj.content + '</span>\
                                                </p>\
                                            </div>\
                                            <span class="w-replycontent w-towords">' + sobj.content + '</span>\
                                        </div>\
                                    </li>';
                            });
                        }
                    });
                    html += '<a href="javascript:void(0);" class="_more_comment" id="_show_more_comment" _now_page="' + data._now_page + '">查看更多 ↓</a>';
                } else {
                    if (page == 1) {
                        html += '<div class="_comment_empty">暂无评论数据！</div>';
                    } else {
                        html += '<div class="_comment_empty">没有数据了！</div>';
                    }

                }
                if (page == 1) {
                    $('.w-remarklist > li, .w-remarklist > a').remove();
                }
                $('#_show_more_comment').remove();
                $('.w-remarklist').append(html);
                $("span[name='count_comment']").text(parseInt(data.data.total_count));
            }
        });
    }

    function create_comment() {
        var username = getCookie('vso_uname');
        if (username == '') {
            alert("登录后才能进行此操作");
            return false;
        }
        var content = $.trim($("#content").val());
        if (content == '') {
            $(".color-red").show();
            $("#content").focus();
            return false;
        }
        else {
            $(this).removeAttr("disabled");
            $(".color-red").hide();
        }
        $("#create_comment").attr("disabled", true);
        $.ajax({
            type: "POST",
            dataType: "json",
            async: false,
            data: {
                'work_id': $("#work_id").val(),
                'content': $("#content").val(),
                'pid': $("#hidden_pid").val()
            },
            url: "/personal/work/create-comment",
            success: function (json) {
                $("#create_comment").removeAttr("disabled");
                if (json.result) {
                    $("#hidden_pid").val(0);
                    $("#content").val("");
                    loadComment();
                }
                else {
                    alert(json.msg);
                }
            }
        });
    }

    function reply_comment(id) {
        if (getCookie('vso_uname') == '') {
            alert("登录后才能进行此操作");
            return false;
        }
        $("#hidden_pid").val(id);
        $("#content").focus();
    }

    function delete_comment(id) {
        if (getCookie('vso_uname') == '') {
            alert("登录后才能进行此操作");
            return false;
        }
        $.ajax({
            type: "POST",
            dataType: "json",
            async: false,
            data: {
                'comment_id': id
            },
            url: "/personal/work/delete-comment",
            success: function (json) {
                if (json.result) {
                    loadComment();
                }
                else {
                    alert(json.msg);
                }
            }
        });
    }

    function GetFileExt(filepath) {
        return filepath.substring(filepath.lastIndexOf('.') + 1);
    }


    function shareWork() {
        var url = window.location.href;
        var username = $.trim($(".username").text());
        var title = username + "的作品";
        var desc = null;
        var pic = null;
        var summary = "高大上！" + username + "的作品，来自蓝海创意云的创意人才。蓝海创意云-一个云端的创客空间";
        var workname = $.trim($(".work_detail img").attr("alt"));
        if (workname != "") {
            summary = "高大上！" + username + "的作品:" + workname + "，来自蓝海创意云的创意人才。蓝海创意云-一个云端的创客空间";
        }
        share(url, title, pic, desc, summary, $(".sharework"));
    }

    $(document).on("mouseenter", ".icon-share-box", function (event) {
        var self = $(this);
        var top = self.offset().top;
        var left = self.offset().left + 45;
        $(".sharework").css({"top": top + "px", "left": left + "px"}).show();
    });
    $(document).on("mouseleave ", ".icon-share-box", function (event) {

        $(".sharework").hide();
    });
    $(document).on("mouseenter", ".sharework", function () {
        $(this).show();
    });
    $(document).on("mouseleave", ".sharework", function () {
        $(this).hide();
    });

    function setPraiseStatusNew(event) {
        var self = $(event.target || event.srcElement),
            clone = self.clone();
        var work_id = $("#work_id").val();

        self.children(".icon-heart").addClass("on");
        $(".w-like-new").addClass('w-liked');
        $("body").append(clone);
        var offsetLeft = self.offset().left;
        var offsetTop = self.offset().top;
        clone.addClass("w-liked heart").css({
            "left": offsetLeft + "px",
            "top": offsetTop + "px"
        });
        clone.animate({"opacity": 0, "top": (offsetTop - 30) + "px"}, 400, function () {
            clone.remove();
        });
        $.ajax({
            type: 'get',
            url: '/personal/work/ajax-like',
            data: {workid: work_id},
            dataType: 'json',
            success: function (json) {
                $("span[name='praise_num']").html(parseInt(json.like_num));
                $("span[name='hot_num']").html(parseInt($("span[name='praise_num']").html()) + parseInt($("span[name='count_comment']").html()));
            }
        });

    }
</script>