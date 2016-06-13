<?php
use yii\helpers\ArrayHelper;

$username = isset($this->context->user_info['username']) && !empty($this->context->user_info['username']) ? $this->context->user_info['username'] : '';
$mobile = isset($this->context->user_info['mobile']) && !empty($this->context->user_info['mobile']) ? $this->context->user_info['mobile'] : '';
?>

<style type="text/css">
    .mo-nav {
        display: none;
    }

    body {
        padding-top: 2.1rem;
    }
</style>

<?php if (empty($username)) : ?>
<div class="entry-login-before">
    <img src="http://maker.vsochina.com/images/mobile/moblie-person.png" alt="">
    <span>已有创意云账号,请<a href="http://account.vsochina.com/user/login" class="color-green">立即登录</a>可享受VIP服务。</span>
</div>
<?php endif; ?>

<form id="create_project_form" enctype="multipart/form-data" action="/home/default/mentry" method="post">
    <div class="file-list clearfix">
        <div id="fileList" name="fileList" class="clearfix">
            <a href="" class="add-img-btn">
                <input type="file" id="fileSecond" name="fileSecond[]" multiple accept="image/*" onchange="handleFiles(this)">
            </a>
        </div>
    </div>
    <dl class="add-project-img">
        <dt class="add-project-dt">
            <img src="http://maker.vsochina.com/images/mobile/add-img.png" alt="">
            <p>项目图片</p>
            <input type="file" id="fileFirst" name="fileFirst[]" multiple accept="image/*" onchange="handleFiles(this)">
        </dt>
        <dd class="add-project-title">蓝海创意云助你梦想成真！</dd>
        <dd class="add-project-txt">这里有千万扶持资金，为你的创意作品而等待；这里有多维度推广手段，让你的作品直达受众；这里还有各类人才，助你走上人生巅峰！</dd>
    </dl>
    <div class="entry-form">
        <input type="hidden" id="username" name="username" value="<?= $username; ?>">
        <div class="entry-form-group">
            <label for="" class="label">项目名称</label>
            <input type="text" id="proj_name" name="proj_name" placeholder="请简单的介绍一下项目名称" class="input-text" value="">
        </div>
        <div class="entry-form-group">
            <label for="" class="label">项目简介</label>
            <div class="entry-form-textarea">
                <span></span>
                <textarea id="proj_desc" name="proj_desc" placeholder="请简单的介绍一下项目情况"></textarea>
            </div>
        </div>
        <div class="entry-form-group">
            <label for="" class="label">成员介绍</label>
            <div class="entry-form-textarea">
                <span></span>
                <textarea id="team_desc" name="team_desc" placeholder="请简单介绍一下项目的成员简历"></textarea>
            </div>
        </div>
        <div class="entry-form-group">
            <label for="" class="label">手机号码</label>
            <input type="text" id="mobile" name="mobile" placeholder="此号码也会成为您的登录号码" class="input-text" value="<?= $mobile ?>" onblur="validateMobile()">
        </div>
        <?php if (empty($username)) : ?>
        <div class="entry-form-code">
            <label for="" class="label">初始密码</label>
            <a href="javascript:void(0);" id="mobile_register_a" class="color-green" onclick="mobileRegister(event)">获取初始密码</a>
            <input type="text" id="password" name="password" placeholder="" class="input-text" value="">
        </div>
        <?php endif; ?>
        <div class="entry-form-group-btn">
            <input type="button" value="申请入驻" onclick="validateForm()">
        </div>
    </div>
</form>

<!-- view larger -->
<div class="create-project-viewlarger">
    <div class="viewlarger-bg"></div>
    <div class="viewlarger-nav">
        <a class="viewlarger-back" href="javascript:void(0);">&lt; 返回</a>
        <span id="viewlarger_cur">1</span> &#47; <span id="viewlarger_total">2</span>
        <a class="viewlarger-delete" href="javascript:void(0);"><i class="icon-36 icon-delete"></i></a>
    </div>
    <!-- swiper -->
    <div class="viewlarger-content swiper-container">
        <div class="swiper-wrapper"></div>
    </div>
    <!--/ swiper -->
</div>
<!--/ view larger -->

<script src="http://static.vsochina.com/libs/swiper/js/swiper.min.js"></script>
<script type="text/javascript">
    var globalVar = {
        swiper: null,
        flagAdd: true,
        flagInit: false,
        h: window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight
    };
    globalVar.h = globalVar.h - 30 + "px";


    $(".entry-form-textarea textarea").on("keyup", function () {
        var val = $(this).val();
        $(this).prev("span").html(val);
    });


    $(function(){
        $(".viewlarger-content").css('height', globalVar.h);
        $(".viewlarger-content .swiper-slide").css('min-height', globalVar.h);

        $(document).on('click', '.view-larger', function(event) {
            $(".create-project-viewlarger").show();
            $("body").css('overflow', 'hidden');
            initSwiper($(this).index());
        });
        $(".viewlarger-back").on('click', function(event) {
            $(".create-project-viewlarger").hide();
            $("body").css('overflow', 'visible');
        });
        $(".viewlarger-delete").on('click', function(event) {
            var _total = $("#viewlarger_total"),
                total = parseInt(_total.html()),
                _cur = $("#viewlarger_cur"),
                cur = parseInt(_cur.html()) - 1;

            if(--total > 0)
            {
                globalVar.swiper.removeSlide(cur);
                $(".view-larger").eq(cur).remove();

                _total.html(total);
                if(cur == total)
                {
                    _cur.html(cur);
                }
            }
            else
            {
                $(".swiper-slide").remove();
                $(".view-larger").remove();

                $(".file-list").hide().next(".add-project-img").show();

                $(".create-project-viewlarger").hide();
                $("body").css('overflow', 'visible');
            }
        });
    });
    window.URL = window.URL || window.webkitURL;
    var fileFirst = document.getElementById("fileFirst"),
        fileList = document.getElementById("fileList");
    function handleFiles(obj, first) {
        var files = obj.files;
        for (var i = 0; i < files.length; i++) {
            var img = new Image();
            if (window.URL) {
                //alert(files[0].name + "," + files[0].size + " bytes");
                img.src = window.URL.createObjectURL(files[i]); //创建一个object URL，并不是你的本地路径
                img.onload = function (e) {
                    window.URL.revokeObjectURL(this.src); //图片加载后，释放object URL
                }
                // $(".add-img-btn").before(img);
                $(".add-img-btn").before('<a class="view-larger"><img src="' + img.src + '"></a>');
            }
            //opera不支持createObjectURL/revokeObjectURL方法。我们用FileReader对象来处理
            else if (window.FileReader) {
                var reader = new FileReader();
                reader.readAsDataURL(files[i]);
                reader.onload = function (e) {
                    img.src = this.result;
                    // $(".add-img-btn").before(img);
                    $(".add-img-btn").before('<a class="view-larger"><img src="' + img.src + '"></a>');
                }
            }
            //ie
            else {
                obj.select();
                obj.blur();
                var nfile = document.selection.createRange().text;
                document.selection.empty();
                img.src = nfile;
                // $(".add-img-btn").before(img);
                $(".add-img-btn").before('<a class="view-larger"><img src="' + img.src + '"></a>');
                //fileList.style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod='image',src='"+nfile+"')";
            }
            var appendHtml = '<div style="min-height: ' + globalVar.h + ';" class="swiper-slide">\
                                <div class="viewlarger-img">\
                                    <img src="' + img.src + '">\
                                </div>\
                            </div>';
            if(globalVar.flagInit)
            {
                globalVar.swiper.appendSlide(appendHtml);
            }
            else
            {
                $(".swiper-wrapper").append(appendHtml);
            }
            globalVar.flagAdd = true;
        }
        if (files.length > 0) {
            $(".add-project-img").hide();
            $(".file-list").show();
        }
        var _file = $(obj);
        _file.after(_file.clone().val(""));
        _file.remove();
    }
    /**
     * 手机号校验
     * 必填
     * 格式是否正确
     * 是否可用
     * @returns {boolean}
     */
    function validateMobile() {
        var mobile = $.trim($("#mobile").val());
        if (mobile == '' || mobile == null) {
            alert("请输入手机号码");
            return false;
        }
        var reg = /^1[34578][0-9]{9}$/;
        // 校验格式
        if (!reg.test(mobile)) {
            alert("请输入有效的手机号");
            return false;
        }
        var result = false;
        // 验证手机是否可用
        $.ajax({
            type: 'get',
            async: false,
            dataType: 'json',
            data: {
                mobile: mobile,
                username: $("#username").val()
            },
            url: '/api/user/is-available-mobile',
            success: function (json) {
                result = json.result;
                if (!result) {
                    alert(json.message);
                }
            }
        });
        return result;
    }

    // 验证密码是否正确
    function validatePassword() {
        var result = true;
        if ($("#password").length > 0) {
            result = false;
            var password = $.trim($("#password").val());
            if (password == '' || password == null || password.length == 0) {
                alert("请输入密码");
                return false;
            }
            $.ajax({
                type: "POST",
                async: false,
                dataType: "json",
                data: {
                    username: $("#username").val(),
                    mobile: $.trim($("#mobile").val()),
                    password: password
                },
                url: "/api/user/check-password",
                success: function (json) {
                    result = json.result;
                }
            });
        }
        if (!result) {
            alert("密码不正确");
        }
        return result;
    }

    // 表单数据校验
    function validateForm() {
        // 项目展示图片，第一张图默认作为项目封面
        var imgArr = [];
        $.each($("#fileList img"), function (idx, obj) {
            imgArr.push($(obj).attr("src"));
        });
        if (imgArr.length < 1) {
            alert("请上传项目图片");
            return false;
        }
        // 项目名称
        var proj_name = $.trim($("#proj_name").val());
        if (proj_name == '' || proj_name == null || proj_name.length == 0) {
            alert("请输入项目名称");
            return false;
        }
        if (proj_name.length > 20) {
            alert("项目名称最多承载20个字");
            return false;
        }
        // 项目简介
        var proj_desc = $.trim($("#proj_desc").val());
        if (proj_desc == '' || proj_desc == null || proj_desc.length == 0) {
            alert("请输入项目简介");
            return false;
        }
        // 成员介绍
        var team_desc = $.trim($("#team_desc").val());
        if (team_desc == '' || team_desc == null || team_desc.length == 0) {
            alert("请输入成员介绍");
            return false;
        }
        // 手机号码
        if (!validateMobile()) {
            return false;
        }
        // 初始密码
        if (!validatePassword()) {
            return false;
        }
        $("#create_project_form").submit();
    }

    // 手机注册
    function mobileRegister(event) {
        var mobile = $.trim($("#mobile").val());
        var _this = $(event.srcElement || event.target);
        if (validateMobile() && !_this.hasClass("disabled")) {
            var time = 60;
            var timeCode = setInterval(function () {
                _this.addClass("disabled").attr("disabled", true);
                if (time <= 0) {
                    clearInterval(timeCode);
                    _this.html("获取初始密码").removeClass("disabled").attr("disabled", false);
                    return false;
                }
                _this.html(time + "秒后重发");
                time--;
            }, 1000);
            $.ajax({
                type: "GET",
                async: false,
                dataType: "json",
                url: "/api/user/is-mobile-registed?mobile=" + mobile,
                success: function (json) {
                    _this.html("获取初始密码");
                    $("#username").val(json.username);
                },
                error: function (json) {
                    _this.html("获取初始密码");
                }
            });
        }
    }

    // 项目入驻
    function createProject() {
        if (validateForm()) {
            var imgArr = [];
            $.each($("#fileList img"), function (idx, obj) {
                imgArr.push($(obj).attr("src"));
                // 取项目展示的第一张图作为项目封面和项目缩略图
            });
            $.ajax({
                type: "POST",
                async: false,
                dataType: "json",
                data: {
                    username: $("#username").val(),
                    mobile: $("#mobile").val(),
                    img_arr: imgArr,
                    proj_name: $.trim($("#proj_name").val()),
                    proj_desc: $.trim($("#proj_desc").val()),
                    team_desc: $.trim($("#team_desc").val())
                },
                url: "/api/project/million-create",
                success: function (json) {
                    if (json.result) {
                        alert("创建成功！");
                        window.location.href = 'http://maker.vsochina.com/home/default/registersucess';
                    }
                    else {
                        alert("创建失败！");
                    }
                }
            });
        }
    }

    // 滑动插件初始化
    function initSwiper(index) {
        var len = $('.swiper-slide').length,
            _cur = $("#viewlarger_cur");
        if(globalVar.flagAdd)
        {
            var _total = $("#viewlarger_total"),
                _wrapper = $(".swiper-wrapper");
            _wrapper.css('width', 15 * len + 'rem');
            _total.html(len);
            globalVar.flagAdd = false;
        }
        if(!globalVar.flagInit && (len > 0))
        {
            globalVar.swiper = new Swiper(".swiper-container", {
                autoHeight: true,
                initialSlide: index,
                onTransitionEnd: function(swiper)
                {
                    _cur.html(swiper.activeIndex + 1);
                }
            });
            globalVar.flagInit = true;
        }
        _cur.html(index + 1);
        globalVar.swiper.slideTo(index, 10, false);
    }
</script>