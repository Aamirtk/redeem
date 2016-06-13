<?php $userInfo=$this->context->user_info;?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="renderer" content="webkit"/>
        <title></title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />

        <!--reset.css  header.css  footer.css-->
        <link rel="stylesheet" href="http://static.vsochina.com/libs/swiper/css/swiper.min.css">
        <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/public/resetcss/mreset.css"/>
        <link rel="stylesheet" type="text/css" href="/css/rc_mobile_person.css"/>
        <!--jquery-->
        <script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="http://static.vsochina.com/public/fontSize/fontSize.js"></script>
        <!--cookie domain-->
        <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
        <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
    </head>
    <body class="rc-grey-bg">
        <input type="hidden" id="work_id" name="work_id" value="<?=$work_id ?>">
        <div class="rc-works-detail">
        </div>

        <div class="rc-comment" style="display: none">
            <p class="rc-comment-title">评论（0）</p>
            <div class="clearfix">
                <div class="rc-comment-textarea">
                    <span></span>
                    <input type="hidden" id="hidden_pid" name="hidden_pid" value="0">
                    <textarea placeholder="请输入评论内容" name="content" id="content" ></textarea>
                </div>
                <a href="javascript:void(0)" class="rc-mobile-btn rc-btn-green pull-right" onclick="create_comment()">发布</a>
            </div>
            <div class="show">
                <ul class="rc-comment-list">
                </ul>
            </div>
            <div class="rc-comment-none">
            </div>
        </div>


        <div class="share-box">
            <div class="share-box-style">
                <p class="share-box-title">
                    <span>分享至</span>
                    <span class="pull-right rc-close-btn"><i class="icon-30 icon-30-close"></i></span>
                </p>
                <ul class="share-list">
                    <li>
                        <a class="qq" data-cmd="qq" href="" target="_blank"></a>
                    </li>
                    <li>
                        <a class="zoom" data-cmd="qzone" href="" target="_blank"></a>
                    </li>
                    <li>
                        <a class="weibo" data-cmd="tsina" href="" target="_blank"></a>
                    </li>
                </ul>
            </div>
        </div>

        <!--weixin-->
        <div class="mdetail-modal">
            <img src="http://maker.vsochina.com/images/mobile/mdetail-weshare-hint.png">
        </div>
        <!--/weixin-->

        <script type="text/javascript" src="http://rc.vsochina.com/js/jquery.qrcode.min.js"></script>
        <script type="text/javascript" src="http://rc.vsochina.com/js/share.js"></script>

        <script type="text/javascript">

            $(function () {
                if (is_weixin())
                {
                    $(".rc-works-action .rc-share").on('click', function (event) {
                        stopPropagation(event);
                        $(".mdetail-modal").show();
                    });

                    $(".mdetail-modal").on('click', function (event) {
                        $(".mdetail-modal").hide();
                    });
                }
                else
                {
                    shareWork();
                    $(".rc-works-action .rc-share").on("click", function (e) {
                        $(".share-box").show();
                        stopPropagation(e);
                    });
                    $(".share-box-title .rc-close-btn").on("click", function (e) {
                        $(".share-box").hide();
                        stopPropagation(e);
                    });
                    $(".share-box-style").on("click", function (e) {
                        stopPropagation(e);
                    });
                    $(".share-box").on("click", function () {
                        $(".share-box").hide();
                        stopPropagation(e);
                    });
                }

            });

            function is_weixin()
            {
                var ua = navigator.userAgent.toLowerCase();
                if (ua.match(/MicroMessenger/i) == "micromessenger")
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }

            function shareWork() {
                var url = window.location.href;
                var username = $.trim($(".rc-works-timer span.usename").text());
                var title = username + "的作品";
                var desc = null;
                var pic = null;
                var summary = "高大上！" + username + "的作品，来自蓝海创意云的创意人才。蓝海创意云-一个云端的创客空间";
                var workname = $.trim($(".rc-works-title").text());
                if (workname != "") {
                    summary = "高大上！" + username + "的作品:" + workname + "，来自蓝海创意云的创意人才。蓝海创意云-一个云端的创客空间";
                }
                share(url, title, pic, desc, summary, $(".share-list"));
            }

            function stopPropagation(e)
            {
                if (e.stopPropagation())
                {
                    e.stopPropagation();
                }
                else
                {
                    e.cancelBubble = true;
                }
            }

            function preventDefault(e)
            {
                if (e.preventDefault())
                {
                    e.preventDefault();
                }
                else
                {
                    e.returnValue = false;
                }
            }

//            $(document).on("click", ".reply-btn", function () {
//                var html = '<div class="rc-add-comment">\
//                                <div class="rc-comment-textarea">\
//                                    <span></span>\
//                                    <textarea placeholder="请输入评论内容" id=''></textarea>\
//                                </div>\
//                                <a href="javascript:void(0)" class="rc-mobile-btn rc-btn-green pull-right" onclick="create_comment()">确认回复</a>\
//                            </div>';
//                if (!$(this).next(".rc-add-comment").length > 0) {
//                    $(".reply-btn").text("回复");
//                    $(this).text("取消");
//                    $(".rc-add-comment").remove();
//                    $(this).after(html);
//                } else {
//                    $(this).text("回复");
//                    $(this).next(".rc-add-comment").remove();
//                }
//            });
        </script>
<script type="text/javascript">
    var work_id = $("#work_id").val();
    loadWorkById(work_id);

    $("#content").on("keyup", function () {
        if ($.trim($(this).val()) == '') {
            $("#content").focus();
        }
    });
    function setPraiseStatus(status) {
        var username = getCookie('vso_uname');
        if (username == '') {
            window.location.href="http://account.vsochina.com/user/login";
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
                $(".icon-rc-heart").parent().removeAttr("disabled");
                if (json.result) {
                    $("i.icon-rc-heart").parent().attr("title", json.data.praise_title);
                    var onclick = '';
                    if (json.data.praise_status==1) {
                        onclick = 'setPraiseStatus(0)';
                        //$(".icon-rc-heart").addClass("active");
                        $("i.icon-rc-heart").parent().html('<i class="icon-36 icon-rc-heart active"></i> '+json.data.praise);
                    }
                    else {
                        onclick = 'setPraiseStatus(1)';
                        //$(".icon-rc-heart").removeClass("active");
                        $("i.icon-rc-heart").parent().html('<i class="icon-36 icon-rc-heart"></i> '+json.data.praise);
                        $("i.icon-rc-heart").parent().attr("onclick", onclick);
                    }
                    $("i.icon-rc-heart").parent().attr("onclick", onclick);
                }
            }
        });
    }

    function loadWorkById(work_id) {
        $("#work_id").val(work_id);
        loadWorkDetail();
        loadWorkPraiseStatus();
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
                $(".rc-works-detail").empty();
                var work_detail_div_html =
                    '<p class="rc-works-title">'+json.work_name+'</p>\
            <p class="rc-works-timer"><span class="usename"><?=$userInfo['nickname']?></span>\
             <span class="pull-right">'+json.on_time.substring(0, 10)+'</span></p>';
            if (json.pic_or_video == 1||json.pic_or_video == 4) {
                work_detail_div_html +=getCopyrightHtml(json);
            }else if(json.pic_or_video == 2||json.pic_or_video == 5)
            {
                if (json.work_url == '' || json.work_url == null) {
                    var videoExt = GetFileExt(json.work_link);
                    if (videoExt == 'mp4' || videoExt == 'webm' || videoExt == 'ogg') {
                        work_detail_div_html+= '<video width="100%" height="auto" controls="controls">\
                                    <source src="' + json.work_link + '" type="video/ogg">\
                                <source src="' + json.work_link + '" type="video/mp4">\
                                <source src="' + json.work_link + '" type="video/webm">\
                                </video>';
                    }
                    else {
                        work_detail_div_html+= '<div id="media_container" fwin="display">\
                                    <div id="mediaplayer_wrapper" style="position: relative; width: 100%; height: auto; margin: 0 auto;" fwin="display">\
                                        <embed src="' + json.work_link + '" quality="high" width="100%" height="auto" align="middle" allowScriptAccess="always" allowFullScreen="true" mode="transparent" type="application/x-shockwave-flash"></embed>\
                                    </div>\
                                </div>';
                    }
                }
                else {
                            var videoExt = GetFileExt(json.work_url);
                            if (videoExt == 'mp4' || videoExt == 'webm' || videoExt == 'ogg') {
                                work_detail_div_html += '<video width="100%" height="auto" controls="controls">\
                                        <source src="' + json.work_url + '" type="video/ogg">\
                                    <source src="' + json.work_url + '" type="video/mp4">\
                                    <source src="' + json.work_url + '" type="video/webm">\
                                    </video>';
                            }
                        }
            }
            work_detail_div_html+='<p class="rc-works-txt">'+json.description.replace(/<[^>]+>/g,"")+'</p>\
            <p class="rc-works-tab"></p>\
            <p class="rc-works-action clearfix">\
                <span class="rc-works-message"><i class="icon-36 icon-rc-message"></i> 0</span>\
                <span><i class="icon-36 icon-rc-heart"></i> '+json.likenum+'</span>\
                <span class="rc-share pull-right"><i class="icon-36 icon-rc-share"></i> 分享</span>\
            </p>';
                $(".rc-works-detail").append(work_detail_div_html);
                if (json.lable.length > 0) {
                    $.each(json.lable, function (idx, obj) {
                        $(".rc-works-tab").append('<span>#' + obj + '</span>');
                    });
                }
            }
        });
    }

    function loadWorkPraiseStatus() {
        $.ajax({
            type: "GET",
            dataType: "JSON",
            async: false,
            url: "/personal/work/load-work-praise-status?id=" + $("#work_id").val(),
            success: function (json) {
                var onclick = '';
                if (json.praise_status==1) {
                    onclick = 'setPraiseStatus(0)';
                    $("i.icon-rc-heart").addClass("active");
                }
                else {
                    onclick = 'setPraiseStatus(1)';
                    $("i.icon-rc-heart").removeClass("active");
                }
                $("i.icon-rc-heart").parent().attr("onclick", onclick);
            }
        });
    }

    function loadComment(page) {
        if(typeof (page) == 'undefined')
        {
            page = 1;
        }
        $.ajax({
            type: "GET",
            dataType: "JSON",
            async: false,
            url: '<?php echo yii::$app->urlManager->createUrl(['/personal/work/load-comment-list','id' => $work_id]);?>&page='+ page,//"/personal/work/load-comment-list?id=" + $("#work_id").val(),
            success: function (data) {
                var html = '';
                var json = data.data.list;
                $(".rc-comment-title").html('评论（'+parseInt(data.data.total_count)+'）');
                if (json.length > 0) {
                    $(".rc-works-message").html('<i class="icon-36 icon-rc-message  active"></i> '+parseInt(data.data.total_count));
                    $.each(json, function (idx, obj) {
                        var delete_html = '';
                        var reply_html = '';
                        if (getCookie('vso_uname') == obj.username) {
                            delete_html = '<a class="color-green pull-right reply-btn" href="javascript:;" onclick="delete_comment(' + obj.comment_id + ')">删除</a>';
                            reply_html = '';
                        }
                        else {
                            delete_html = '';
                            reply_html = '<a class="color-green pull-right reply-btn" href="javascript:;" onclick="reply_comment('+ obj.comment_id +')">回复</a>';
                        }
                        html +=
                            '<li class="clearfix" data-id="' + obj.comment_id + '">\
                                <div class="clearfix rc-comment-list-top">\
                                    <a target="_blank" class="rc-comment-list-head" href="/talent/' + obj.username + '">\
                                    <img src="' + obj.avatar + '"/></a>' + obj.nickname + '\
                                </div>\
                                <div class="rc-comment-list-txt">'+obj.content+'</div>\
                                <div class="clearfix">' + delete_html + reply_html + '</div>\
                            </li>';
                        if (obj.sub.length > 0) {
                            $.each(obj.sub, function (sidx, sobj) {
                                var sdelete_html = '';
                                if (getCookie('vso_uname') == sobj.username) {
                                    sdelete_html = '<a href="javascript:;" class="color-green pull-right reply-btn" onclick="delete_comment(' + sobj.comment_id + ')">删除</a>';
                                }
                                else {
                                    sdelete_html = '';
                                }
                                html +=
                                    '<li class="clearfix" data-id="' + sobj.comment_id + '">\
                                        <div class="clearfix rc-comment-list-top">\
                                            <a target="_blank" class="rc-comment-list-head" href="/talent/' + sobj.username + '">\
                                            <img src="' + sobj.avatar + '"/></a>\
                                               ' + sobj.nickname + '<span class="color-grey">回复</span>' + obj.nickname +'</div>\
                                        <div class="rc-comment-list-txt">'+ sobj.content+'</div>\
                                        <div class="clearfix">' + sdelete_html + '</div>\
                                    </li>';
                            });
                        }
                    });
                    var morehtml = '<a href="javascript:void(0);" class="rc-mobile-more" onclick="loadMoreComment(' + data._now_page + ')">查看更多评论</a>';
                    if (page==1)
                    {
                        $('.rc-comment-list').html(html);
                    }
                    else
                    {
                        $('.rc-comment-list').append(html);
                    }
                } else {
                    if (page==1) {
                        morehtml = '暂无评论';
                    } else {
                        morehtml = '没有评论了';
                    }

                }
                //var morehtml = '<a href="javascript:void(0);" class="_more_comment" id="_show_more_comment" _now_page="' + data._now_page + '">查看更多 ↓</a>';
                //$('.rc-mobile-more').html(morehtml);
                //$('#_show_more_comment').remove();
                $('.rc-comment-none').html(morehtml);
            }
        });
        $('.rc-comment').show();
    }

    function create_comment() {
        var username = getCookie('vso_uname');
        if (username == '') {
            window.location.href="http://account.vsochina.com/user/login";
            return false;
        }
        var content = $.trim($("#content").val());
        if (content == '') {
            $("#content").val(content);
            $("#content").focus();
            return false;
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
            }
        });
    }

    function reply_comment(id) {
        if (getCookie('vso_uname') == '') {
            window.location.href="http://account.vsochina.com/user/login";
            return false;
        }
        $("#hidden_pid").val(id);
        $("#content").focus();
    }
    function GetFileExt(filepath) {
        return filepath.substring(filepath.lastIndexOf('.') + 1);
    }
    function delete_comment(id) {
        if (getCookie('vso_uname') == '') {
            window.location.href="http://account.vsochina.com/user/login";
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
            }
        });
    }
    function loadMoreComment(now_page)
    {
        if(!now_page){
            return false;
        }
        var next_page = parseInt(now_page) + 1;
        loadComment(next_page);
    }
/**
     * 作品详情，版权设置html
     * @param copyright （0=>无，1=>禁止看大图，2=>禁止右键，3=>禁止商业，4=>禁止123）
     */
    function getCopyrightHtml(work) {
        var html = '';
        switch (work['copyright']) {
            case "0":
                html = '<div class="rc-works-img">\
                    <a target="_blank" href="' + work['work_url'] + '"><img src="'+work['img_src']+'" width="100%"></a>\
                </div>';
                //html = '<a target="_blank" class="w-imgbox" href="' + work['work_url'] + '"><img src="' + work['img_src'] + '" alt="' + work['work_name'] + '"></a>';
                break;
            case "1":
                html = '<div class="rc-works-img">\
                    <img src="'+work['img_src']+'" width="100%">\
                </div>';
                break;
            case "2":
                html = '<div class="rc-works-img">\
                    <img src="'+work['img_src']+'" width="100%">\
                </div>';
                break;
            case "3":
                html = '<div class="rc-works-img">\
                    <img src="'+work['img_src']+'" width="100%">\
                </div>';
                break;
            case "4":
                html = '<div class="rc-works-img">\
                    <img src="'+work['img_src']+'" width="100%">\
                </div>';
                break;
        }
        return html;
    }
</script>
    </body>
</html>