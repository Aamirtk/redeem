    <input type="hidden" id="page_num" value="1">
    <div class="rc-works-box">

        <a href="javaScript:void(0)" class="rc-mobile-more" onclick="loadMore()">查看加载更多</a>
        <div class="m-no-works hide">
            <div class="table">
                <div class="table-cell">
                    <i class="icon-no-works"></i>
                    <span>暂无作品</span>
                </div>
            </div>
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

    <!--/header-->

    <script type="text/javascript">

        function stopPropagation(e)
        {
            if(e.stopPropagation())
            {
                e.stopPropagation();
            }
            else
            {
                e.cancelBubble = true;
            }
        }

        function isNull(data){
            return (data == "" || data == undefined || data == null) ? "暂无" : data;
        }

        function loadMore (){
            var page = parseInt($("#page_num").val());
            var pageSize = <?= yii::$app->params['mper_case_index_page_size'] ?>;
            var works = <?= json_encode($works) ?>;
            var praiseWorkids = <?= json_encode($praiseWorkids) ?>;
            var beginNum = (page-1)*pageSize;
            var _length = works.length;
            var endNum = 0;
            var html = '';
            if(_length==0){
                $(".m-no-works").show();
                $(".rc-mobile-more").hide();
                return;
            }
            if(beginNum>=_length){
                $(".rc-mobile-more").hide();
                return;
            }else if(_length - pageSize <= beginNum && beginNum < _length){
                endNum = _length;
                $("#page_num").val(page+1);
                $(".rc-mobile-more").hide();
            }else{
                $(".rc-mobile-more").text("查看加载更多");
                endNum = beginNum+pageSize;
                $("#page_num").val(page+1);
            }
            var workids=[];
            for(var i = beginNum; i < endNum; i++){
                var w = works[i];
                workids[i]=w.work_id;
                var lableStr = '';
                var cover_url = $.inArray(parseInt(w.pic_or_video), [2, 3, 5])>-1 ? w.cover_url : w.work_url;
                if(w.lable){
                    lableArr = w.lable.split(',');
                    $.each(lableArr, function(j, lb){
                        lableStr+='<span>#'+ lb +'</span>';
                    });
                }
                var txt_des = isNull(w.description).replace(/<[^>]+>/g,"");
                var praiseStatus=$.inArray(w.work_id,praiseWorkids)>-1?' active':'';
                var praiseEvent=$.inArray(w.work_id,praiseWorkids)>-1?' setPraiseStatus(0,'+w.work_id+')':' setPraiseStatus(1,'+w.work_id+')';
                txt_des = isNull(w.description).replace(/<[^>]+>/g,"");
                var messageStatus=w.commentnum>0?'active':'';
                html += '<div class="rc-works" >'+
                        '       <a class="rc-works-img" href="<?= yii::$app->params['rc_frontendurl'] ?>/personal/work/view/'+ w.work_id+ '" class="rc-works-img">'+
                        '        <img src="'+ cover_url +'">'+
                        '       </a>'+
                        '       <a class="rc-works-title" href="<?= yii::$app->params['rc_frontendurl'] ?>/personal/work/view/'+ w.work_id+ '">'+ isNull(w.work_name) +'</a>'+
                        '       <p class="rc-works-username hide">'+ w.username +'</p>'+
                        '       <p class="rc-works-txt">'+ isNull(txt_des) +'</p>'+
                        '       <p class="rc-works-tab">'+ isNull(lableStr) +'</p>'+
                        '       <p class="rc-works-action">'+
                        '       <span class="rc-works-message"><i class="icon-36 icon-rc-message '+messageStatus+'"></i> '+ w.commentnum +'</span>'+
                        '       <span onclick="'+praiseEvent+'" id="praise'+w.work_id+'"><i class="icon-36 icon-rc-heart '+praiseStatus+'"></i> '+ w.likenum +'</span>'+
                        '       <span class="rc-share pull-right"><i class="icon-36 icon-rc-share"></i> 分享</span>'+
                        '       </p>'+
                        '</div>';
            }
            $(".rc-mobile-more").before(html);
            $(".rc-works-txt").find("img").css("width", "10px");
        }

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

        function shareWork(dom) {
            var url = dom.find(".rc-works-img").attr("href");
            var username = '<?= $this->context->obj_username ?>';
            var title = username + "的作品";
            var desc = null;
            var pic = null;
            var summary = "高大上！" + username + "的作品，来自蓝海创意云的创意人才。蓝海创意云-一个云端的创客空间";
            var workname = dom.find(".rc-works-title").text();

            if (workname != "") {
                summary = "高大上！" + username + "的作品:" + workname + "，来自蓝海创意云的创意人才。蓝海创意云-一个云端的创客空间";
            }
            share(url, title, pic, desc, summary, $(".share-list"));
        }
    function setPraiseStatus(status,work_id) {
        var username = getCookie('vso_uname');
        if (username == '') {
            window.location.href="http://account.vsochina.com/user/login";
            return false;
        }
        //$(".icon-heart").parent().attr("disabled", true);
        $.ajax({
            type: "POST",
            dataType: "JSON",
            async: false,
            data: {
                'status': status
            },
            url: "/personal/work/praise?id=" + work_id,
            success: function (json) {
                //$(".icon-rc-heart").parent().removeAttr("disabled");
                if (json.result) {
                    //$("i.icon-rc-heart").parent().attr("title", json.data.praise_title);
                    var onclick = '';
                    if (json.data.praise_status==1) {
                        onclick = 'setPraiseStatus(0,'+work_id+')';
                        //$(".icon-rc-heart").addClass("active");
                        $("#praise"+work_id).html('<i class="icon-36 icon-rc-heart active"></i> '+json.data.praise);
                    }
                    else {
                        onclick = 'setPraiseStatus(1,'+work_id+')';
                        //$(".icon-rc-heart").removeClass("active");
                        $("#praise"+work_id).html('<i class="icon-36 icon-rc-heart"></i> '+json.data.praise);
                    }
                    $("#praise"+work_id).attr("onclick", onclick);
                }
            }
        });
    }
        $(function(){
            $("#page_num").val(1);
            loadMore();
            $(".rc-works-message").on('click', function(){
                var url = $(this).parents(".rc-works").find(".rc-works-img").attr("href");
                window.location.href = url;
            });

            if (is_weixin())
            {
                $(".rc-works .rc-share").on('click', function (event) {
                    stopPropagation(event);
                    $(".mdetail-modal").show();
                });

                $(".mdetail-modal").on('click', function (event) {
                    $(".mdetail-modal").hide();
                });
            }
            else
            {
                $(".rc-works .rc-share").on("click", function (e) {
                    var _dom = $(this).parents(".rc-works");
                    $(".share-box").show();
                    stopPropagation(e);
                    shareWork(_dom);
                });
                $(".share-box-title .rc-close-btn").on("click", function (e) {
                    var _dom = this;
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
    </script>
