<!DOCTYPE html>
<html>
<head>
    <?php
        $_title = " 主页设置 | ".$user_info['nickname'];
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit"/>
    <link rel="shortcut icon" href="<?= $user_info['avatar'] ?>" type="image/x-icon"/>
    <title><?= $_title ?></title>
    <!--css-->
    <!--cookie domain-->
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.2.0/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="http://maker.vsochina.com/css/dreamSpace.css" />
    <link rel="stylesheet" type="text/css" href="/css/talent_comm.css">
    <script>
        var ua = navigator.userAgent;
        var ipad = ua.match(/(iPad).*OS\s([\d_]+)/),
            isIphone = !ipad && ua.match(/(iPhone\sOS)\s([\d_]+)/),
            isAndroid = ua.match(/(Android)\s+([\d.]+)/),
            isMobile = isIphone || isAndroid;
        var _ID = '<?= $username ?>';
        var _USERNAME = '<?= $username ?>';
        var _PCID = <?= $per_skin['pc_id'] ?>;
        var _MOBILEID = <?= $per_skin['mobile_id'] ?>;
        var _SKINID = isMobile?_MOBILEID:_PCID;
        var _SKINTYPE = isMobile?1:0;
    </script>

    <!--[if lt IE 9]>
    <script src="http://static.vsochina.com/libs/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--js-->
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="/js/talent_skin_edit.js"></script>
    <script type="text/javascript" src="http://maker.vsochina.com/js/dreamSpace.js"></script>


    <script src="http://static.vsochina.com/libs/jquery/1.9.1/jquery.min.js"></script>

    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
</head>

<body>
    <div class="navbar">
        <div class="pull-left">
            <ul class="modal-select">
                <li><a href="javascript:;">模板选择</a></li>
                <li><a href="javascript:;">链接</a></li>
                <li><a href="javascript:;">手机模板</a></li>
                <li><a href="http://www.vsochina.com/index.php?do=ucenter">修改资料</a></li>
            </ul>
        </div>
        <div class="pull-right">
            <a href="javascript:void(0)" class="btn btn-green btn-sm" onclick="saveSkinAddClose()">保存并关闭</a>
            <a href="javascript:void(0)" class="btn btn-green btn-sm" onclick="saveSkinOnly()">保　存</a>
            <a href="javascript:void(0)" class="btn btn-green btn-sm" onclick="discardChanges()">取　消</a>
        </div>
        <div class="theme-tab-container">
            <div class="theme-tab theme-pc">
                <?php foreach ($pc_ids as $val) {?>
                    <div  class="pleft themeitem" id="skin1" skin-id="<?= $val['id'] ?>" skin-type="0">
                        <div class="themenail">
                            <img src="<?= $val['skin_thumb'] ?>" alt="">
                        </div>
                        <h2><?= $val['skin_name'] ?></h2>
                    </div>
                <?php } ?>
            </div>
            <div class="theme-tab theme-link">
                <input type="text" class="form-control theme-link_name" placeholder="链接名称">

                <input type="text" class="form-control theme-link_url" placeholder="链接url">
                <div class="theme-link-info">
                    <p>链接名称：</p>
                    <p>由您自定义。</p>
                    <p>例如：定义“个人网站”的链接名称为“我的个人网站”。</p>
                    <p>链接url：</p>
                    <p>由您自定义，通过该链接网址，跳转到您设置的目标网址。</p>
                    <p>例如：目标网址为个人网站，则链接网址可以定义为“http://vsochina.com/mywebsite”。</p>
                </div>
                <a href="javascript:void(0)" class="btn btn-green" onclick="addThemeLink(true)">确认</a>
                <a href="javascript:void(0)" class="btn btn-darkgrey pull-right" onclick="addThemeLink(false)">取消</a>
            </div>
            <div class="theme-tab theme-mobile">
                <?php foreach ($mobile_ids as $val) {?>
                    <div class="pleft themeitem" id="skin1" skin-id="<?= $val['id'] ?>" skin-type="1">
                        <div class="themenail">
                            <img src="<?= $val['skin_thumb'] ?>" alt="">
                        </div>
                        <h2><?= $val['skin_name'] ?></h2>
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>
    <div class="previewWrap">
        <div class="iframe-mask"></div>
        <iframe src="" frameborder="0" width="100%" height="100%" id="theme_preview"></iframe>
    </div>
<script src="http://static.vsochina.com/libs/mCustomScrollbar/3.1.1/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript">
    $(".themeitem").on("click",function (event) {
        var skinid = $(this).attr("skin-id");
        var skin_type = parseInt($(this).attr("skin-type"));
        if(!isMobile&&skin_type==0){//PC端
            $("#theme_preview").attr("src","/personal/skin/display-skin/?username="+_USERNAME+"&skinid="+skinid+"&skintype=0");
        }else if(isMobile&&skin_type==1){//移动端
            $("#theme_preview").attr("src","/personal/skin/display-skin/?username="+_USERNAME+"&skinid="+skinid+"&skintype=1");
        }
        $(this).addClass("active").siblings().removeClass("active");
        stopPropagation(event);
    })

    $(".theme-pc,.theme-mobile").mCustomScrollbar({
        axis:"y" ,// horizontal scrollbar
        theme:"dark"
    });
    $(".modal-select li").attr("show",1);
    $(".modal-select li").on("click",function(event){
        if($(this).attr("show")==1){
                var index = $(this).index();
                $(this).addClass("active").siblings().removeClass("active");
                $(".theme-tab-container .theme-tab").eq(index).show().siblings().hide();
                $(".iframe-mask").show();
                $(this).attr("show","0");
        }else{
                $(".theme-tab-container .theme-tab").hide();
                $(this).attr("show","1");
        }
        stopPropagation(event);
    });
    $(".theme-tab-container").on("click",function(event){stopPropagation(event);});

    $(document).on("click",function(){
        $(".theme-tab").hide();
        $(".modal-select li").removeClass("active");
        $(".modal-select li").attr("show",1);
    })
    /*阻止冒泡*/
    function stopPropagation(event){
        if (event.stopPropagation)  event.stopPropagation();
        else  event.cancelBubble = true;
    }

    /*
    保存皮肤
    */
    function saveSkinOnly(){
        saveSkin(function(){
//            window.location.href = "/personal/skin/index?username="+_USERNAME;
        });
    }
    /*
    保存和关闭皮肤
    */
    function saveSkinAddClose()
    {
        saveSkin(function(){
            window.location.href = "/personal/index/"+_USERNAME;
        });
    }
    /*
    取消
    */
    function discardChanges()
    {
        confirm("确定要取消吗？", function(){
            window.location.href = "/personal/index/"+_USERNAME;
        });
    }

    /*
    保存皮肤
    */
    function saveSkin(callback){
        var paras = {};
        paras.username = _USERNAME;
        paras.pc_id = $(".theme-pc").find(".active").attr("skin-id");
        paras.mobile_id = $(".theme-mobile").find(".active").attr("skin-id");
        $.ajax({
            type: "GET",
            url: "/personal/skin/save-skin",
            data: paras,
            dataType: "json",
            success: function(json){
                if(json.success){
                    alert(json.msg);
                    callback();
                }else{
                    alert(json.msg);
                }
            }
        });
    }

    /*
    保存链接
    */
    function addThemeLink(v){
        if(!v){
            $(".theme-link").find("input").val('');
            return;
        }
        var paras = {};
        paras.username = _USERNAME;
        paras.link_name = $(".theme-link_name").val();
        paras.link_url = $(".theme-link_url").val();
        if(paras.link_name==''||paras.link_url==''){
            return;
        }
        $.ajax({
            type: "GET",
            url: "/personal/skin/save-link",
            data: paras,
            dataType: "json",
            success: function(json){
                if(json.success){
                    alert(json.msg);
                    $(".theme-link").find("input").val('');
                }else{
                    alert(json.msg);
                }
            }
        });
    }


    $(function(){
        //加载默认的皮肤
        $("#theme_preview").attr("src","/personal/skin/display-skin/?username="+_USERNAME+"&skinid="+_SKINID+"&skintype="+_SKINTYPE);
        $(".theme-pc").find(".themeitem[skin-id="+_PCID+"]").addClass("active").siblings().removeClass("active");
        $(".theme-mobile").find(".themeitem[skin-id="+_MOBILEID+"]").addClass("active").siblings().removeClass("active");
    });
    /*
    $(".previewWrap").on("click",function(){
        if($(".theme-tab:visible").length==1){
            $(".theme-tab").css("opacity",0.3);
            $(".theme-tab").hide();
        }
    });*/
    /*
    $(".previewWrap").on("mouseover",function(){
        if($(".theme-tab:visible").length==1){
            $(".theme-tab").css("opacity",0.3);
        }
    });
    $(".theme-tab,.navbar").on("mouseover",function(){
        $(".theme-tab").css("opacity",1);
    });
    */
    $(".iframe-mask").on("click",function(){
        $(".theme-tab").hide();
        $(".iframe-mask").hide();
        $(".modal-select li").removeClass("active");
        $(".modal-select li").attr("show",1);
    });

</script>
</body>

</html>