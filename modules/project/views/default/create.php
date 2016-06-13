<?php
use frontend\modules\talent\models\User;
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <title>创客空间项目入驻</title>
    <meta name="keywords" content="创意空间">
    <meta name="description" content="创意空间">
    <meta content="uJnvSJU9WW" name="baidu-site-verification">
    <link type="text/css" rel="stylesheet" href="http://www.vsochina.com/resource/css/base.css"/>
    <!--reset.css  header.css  footer.css-->
    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css?t=20150810"/>
    <!--.css-->
    <link type="text/css" rel="stylesheet" href="/css/dreamSpace.css" />
    <link type="text/css" rel="stylesheet" href="/css/detail-model.css"/>
    <link type="text/css" rel="stylesheet" href="/plugins/uploadify/uploadify.css"/>
    <script type="text/javascript" src="http://www.vsochina.com/resource/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/jquery.lazyload/1.9.5/jquery.lazyload.js"></script>
    <script type="text/javascript" src="/js/dreamSpace.js"></script>
    <style type="text/css">
        .uploadify-queue {display: none;}
    </style>
</head>
<body>
<script type="text/javascript" charset="utf-8" src="http://account.vsochina.com/static/js/vsoheader.js"></script>
<script type="text/javascript" src="http://account.vsochina.com/static/js/jquery.validate.js"></script>
<script type="text/javascript" src="/js/project_action.js"></script>
<script type="text/javascript" charset="utf-8" src="/plugins/uploadify/jquery.uploadify.js"></script>
<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.all.js"></script>
<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/lang/zh-cn/zh-cn.js"></script>

<div class="stripe-bg">
    <div class="work-upload j-upload-wrapper">
        <div class="maker-logo">
            <a href="<?= yii::$app->defaultRoute ?>">
                <img src="/images/createNew/logo.png">
            </a>
        </div>
        <div class="work-upload-inner">
            <div class="upload-step j-upload-step">
                <ul class="step-tabs clearfix">
                    <li class="step-item step_first step-cur"><span class="step-no">1</span>基础信息</li>
                    <li class="step-item step_second"><span class="step-no">2</span>项目故事</li>
                    <!--<li class="step-item step_third"><span class="step-no">3</span>等待审核</li>-->
                </ul>
            </div>
            <div class="work-upload-bd">
                <!--基础信息-->
                <div class="upload-main" id="step_basicmsg">
                    <form id="basic_form" disableautocomplete="" autocomplete="off" action="">
                        <div class="upload-area">
                            <div class="table-cell">
                                <div class="form_box">
                                    <label>项目名称：</label>
                                    <input type="text" id="proj_name" name="proj_name" value="" class="form-control">
                                    <span class="form-intro">最多承载20个字</span>
                                    <br class="clear"/>
                                </div>
                                <div class="form_box">
                                    <label>项目副标题：</label>
                                    <input type="text" id="proj_sub_name" name="proj_sub_name" value="" class="form-control">
                                    <span class="form-intro">最多承载30个字</span>
                                    <br class="clear"/>
                                </div>
                                <div class="form_box">
                                    <label>项目分类：</label>
                                    <?php $indusArr = \common\models\CommonIndustry::getIndustryList();?>
                                    <select id="indus_pid" name="indus_pid" class="form-control">
                                        <?php foreach ($indusArr as $k => $v):?>
                                            <option value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <br class="clear"/>
                                </div>
                                <div class="form_box project-cover">
                                    <label>项目封面：</label>
                                    <div class="upload-result fl mt10">
                                        <div class="upload-icon-box upload-img">
                                            <span class="upload-icon upload-img-icon">
                                                <input type="file" id="proj_thumb" name="proj_thumb" class="upload-file" accept=".jpg,.jpeg,.png,.bmp,.gif" multiple="false">
                                            </span>
                                            <img name="proj_thumb_span_img" src="" style="display: none;">
                                        </div>
                                        <div class="upload-rightbox">
                                            <div class="upload-arrow"></div>
                                            <div class="upload-rightbox-main">
                                                <div class="upload-rightbox-img">
                                                    <p>尺寸400x228</p>
                                                    <p>格式JPG、PNG、GIF</p>
                                                    <img name="proj_thumb_img" src="" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                        <br class="clear"/>
                                    </div>
                                    <br class="clear"/>
                                </div>
                                <div class="form_box">
                                    <label>预计周期：</label>
                                    <input type="text" id="expected_period" name="expected_period" value="" class="form-control w100">
                                    <span class="font-bottom ml5 form-intro">天</span>
                                    <span class="form-intro">1到1000之间的整数</span>
                                    <br class="clear"/>
                                </div>
                                <div class="form_box">
                                    <label>项目标签：</label>
                                    <input type="text" id="proj_tag" name="proj_tag" value="" class="form-control">
                                    <span class="form-intro">最多五个标签，请用逗号隔开！</span>
                                    <br class="clear"/>
                                </div>
                                <?php $username = User::getLoginedUsername();?>
                                <?php if (empty($username)):?>
                                    <div class="form_box">
                                        <label>手机号码：</label>
                                        <input id="mobile" name="mobile" class="form-control">
                                        <input type="button" value="发送验证码" class="ds-btn fl" onclick="send_valid_code(event)">
                                        <br class="clear"/>
                                    </div>
                                    <div class="form_box">
                                        <label>验证码：</label>
                                        <input id="valid_code" name="valid_code" class="form-control">
                                        <br class="clear"/>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="upload-op clearfix">
                            <div class="btn-box-next">
                                <input type="submit" class="mod-btn" value="下一步">
                            </div>
                        </div>
                    </form>
                </div>
                <!--/基础信息-->

                <!--项目故事-->
                <div class="upload-main" id="step_projectstory" style="display: none;">
                    <form id="extend_form" method="post" actoin="">
                        <div class="upload-area">
                            <div class="table-cell">
                                <div class="form_box project-banner">
                                    <label>项目横幅：</label>
                                    <div class="upload-result">
                                        <div class="upload-icon-box upload-img">
                                            <span class="upload-icon upload-img-icon">
                                                <input type="file" id="proj_banner" name="proj_banner" class="upload-file" accept=".jpg,.jpeg,.png,.bmp,.gif">
                                            </span>
                                            <img name="proj_banner_img" src="" style="display: none;">
                                        </div>
                                        <p class="form-intro w280 fl mt70">横幅尺寸1200x450</p>
                                        <p class="form-intro w280 fl">横幅格式JPG、PNG、BMP、JPEG、GIF</p>
                                        <br class="clear"/>
                                    </div>
                                    <br class="clear"/>
                                </div>
                                <div class="form_box">
                                    <label>项目介绍：</label>
                                    <script type="text/plain" id="editor_proj_desc" name="editor_proj_desc" style="width: 480px; height: 250px;margin-left:150px;"></script>
                                    <br class="clear"/>
                                </div>
                                <div class="form_box">
                                    <label>团队介绍：</label>
                                    <script type="text/plain" id="editor_team_desc" name="editor_team_desc" style="width: 480px; height: 250px;margin-left:150px;"></script>
                                    <br class="clear"/>
                                </div>
                                <div class="form_box">
                                    <label>团队成员：</label>
                                    <input type="text" id="proj_member_str" name="proj_member_str" class="form-control" value="" placeholder="请输入平台注册账号，逗号分隔">
                                    <span class="form-intro">请输入平台注册账号，逗号分隔</span>
                                    <br class="clear">
                                </div>
                                <div class="form_box project-show">
                                    <label>项目演示：</label>
                                    <div class="upload-result fl">
                                        <div class="upload-icon-box upload-img">
                                            <span class="upload-icon upload-img-icon">
                                                <input type="file" id="demo_img" name="demo_img" class="upload-file" accept=".jpg,.jpeg,.png,.bmp,.gif">
                                            </span>
                                        </div>
                                        <br class="clear demo_img_br"/>
                                    </div>
                                    <p class="form-intro w280 fl mt50">可上传多张图片</p>
                                    <p class="form-intro w280 fl">演示图尺寸530x325</p>
                                    <p class="form-intro w280 fl">演示图格式JPG、PNG、BMP、JPEG、GIF</p>
                                    <br class="clear"/>
                                </div>
                                <div class="form_box">
                                    <label>为何入驻：</label>
                                    <script type="text/plain" id="editor_remarks" name="editor_remarks" style="width: 480px; height: 250px;margin-left:150px;"></script>
                                    <br class="clear"/>
                                </div>
                                <div class="form_box">
                                    <label>项目风险：</label>
                                    <script type="text/plain" id="editor_proj_risk" name="editor_proj_risk" style="width: 480px; height: 250px;margin-left:150px;"></script>
                                    <br class="clear"/>
                                </div>
                                <div class="form_box">
                                    <label>答疑解惑：</label>
                                    <div class="project-qa fl">
                                        <input type="text" name="proquestion" placeholder="疑问？" class="form-control proquestion" maxlength="30">
                                        <span class="form-intro fl">最多承载30个字</span>
                                        <textarea name="proanswer" placeholder="解答：" cols="30" rows="10" class="form-control proanswer fl" maxlength="200"></textarea>
                                        <a href="javascript:void(0);" class="add-qa">新增问题</a>
                                    </div>
                                    <br class="clear"/>
                                </div>
                            </div>
                        </div>
                        <div class="upload-op clearfix">
                            <div class="btn-box-prev">
                                <input type="button" class="mod-btn" value="上一步" onclick="prevStep()">
                            </div>
                            <div class="btn-box-next">
                                <input type="button" class="mod-btn" value="下一步" onclick="checkProjExt()">
                            </div>
                        </div>
                    </form>
                </div>
                <!--/项目故事-->

                <!--等待审核-->
                <div class="upload-main" id="step_verifymsg" style="display: none;">
                    <div class="upload-area">
                        <div class="table-cell">
                            <div class="verifymsg-loading">
                                <p class="verifymsg-loading-en">loading</p>
                                <p class="verifymsg-loading-zh">
                                    预计<span class="font-red">1-4</span>小时给您回复，届时请您查看邮箱及站内信息！
                                </p>
                            </div>
                            <div class="verifymsg-info">
                                <span>
                                    现在您还可以<a href="http://www.vsochina.com/index.php?do=ucenter&view=accountcenter&op=manage_work">上传作品</a>完善个人主页或返回<a href="http://maker.vsochina.com">创客空间</a>
                                </span>
                                <span>
                                    如：有问题请致电免费电话<span class="font-blue mh10">4009287979</span>或联系
                                    <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=2773398623&amp;site=www.vsochina.com&amp;menu=yes" target="_blank">QQ客服</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!--<div class="upload-op clearfix">
                        <div class="btn-box-next">
                            <a href="javascript:void(0);" class="mod-btn">下一步</a>
                        </div>
                    </div>-->
                </div>
                <!--/等待审核-->
            </div>
        </div>
    </div>
</div>
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/footer.php') ?>

<script type="text/javascript">
    var umProjDesc = '';//UM.getEditor('editor_proj_desc');      // 项目介绍
    var umTeamDesc = '';//UM.getEditor('editor_team_desc');    // 团队描述
    var umRemarks = '';//UM.getEditor('editor_remarks');   // 为何入驻
    var umProjRisk = '';//UM.getEditor('editor_proj_risk');      // 项目风险

    if ($("#proj_tag").length > 0) {
        $("#proj_tag").on("blur", function () {
            var tag = $(this).val();
            tag = tag.replace(/，/gm, ',');
            tag = $.trim(tag);
            tag = tag.replace(/,$/g, "");
            $(this).val(tag);
        });
    }

    function prevStep() {
        $(".step_first").addClass("step-cur");
        $(".step_second").removeClass("step-done").addClass("step-cur");

        $("#step_projectstory").hide();
        $("#step_basicmsg").show();
    }

    $(".add-qa").on("click", function () {
        if ($.trim($(this).siblings(".proquestion").last().val()) == '') {
            return false;
        }
        if ($.trim($(this).siblings(".proanswer").last().val()) == '') {
            return false;
        }
        var html = '<input type="text" name="proquestion" placeholder="疑问？" class="form-control proquestion clear-l" maxlength="30">\
                    <span class="form-intro fl">最多承载30个字</span>\
                    <textarea name="proanswer" placeholder="解答：" cols="30" rows="10" class="form-control proanswer fl" maxlength="200"></textarea>\
                    <a href="javascript:void(0);" class="delete-qa">删除问题</a>';
        $(this).before(html);
    });

    $(document).on("click", ".delete-qa", function () {
        $(this).prev().remove();
        $(this).prev().remove();
        $(this).prev().remove();
        $(this).remove();
    });

    $(function () {
        $('#proj_thumb').uploadify({
            'formData': {
                'timestamp': '<?php echo time();?>',
                'token': '<?php echo md5('unique_salt' . time());?>',
                'upload_path': 'projects'
            },
            'swf': '/plugins/uploadify/uploadify.swf',
            'uploader': '/plugins/uploadify/uploadify.php',
            'multi': false,
            'buttonImage': '/images/createNew/upload-img.png',
            'buttonText': '',
            'fileTypeDesc': '图片文件',
            'fileTypeExts': '*.jpg;*.jprg;*.png;*.bmp;*.gif',
            'fileSizeLimit': "<?= yii::$app->params['fileSizeLimit'] ?>",
            //'removeCompleted': false,
            'overrideEvents': ['onUploadSuccess'],
            'width': 250,
            'height': 140,
            'onUploadSuccess': function (file, data, response) {
                if (response) {
                    $("label[for='proj_thumb']").addClass("valid_success").html("").hide();
                    $("img[name='proj_thumb_span_img']").attr("src", data).show();
                    $("img[name='proj_thumb_img']").attr("src", data).show();
                }
            }
        });
    });

    $(function () {
        $('#proj_banner').uploadify({
            'formData': {
                'timestamp': '<?php echo time();?>',
                'token': '<?php echo md5('unique_salt' . time());?>',
                'upload_path': 'projects'
            },
            'swf': '/plugins/uploadify/uploadify.swf',
            'uploader': '/plugins/uploadify/uploadify.php',
            'multi': false,
            'buttonImage': '/images/createNew/upload-img.png',
            'buttonText': '',
            'fileTypeDesc': '图片文件',
            'fileTypeExts': '*.jpg;*.jprg;*.png;*.bmp;*.gif',
            'fileSizeLimit': "<?= yii::$app->params['fileSizeLimit'] ?>",
            'overrideEvents': ['onUploadSuccess'],
            'width': 480,
            'height': 180,
            'onUploadSuccess': function (file, data, response) {
                if (response) {
                    $("img[name='proj_banner_img']").attr("src", data).show();
                }
            }
        });
    });

    $(function () {
        $('#demo_img').uploadify({
            'formData': {
                'timestamp': '<?php echo time();?>',
                'token': '<?php echo md5('unique_salt' . time());?>',
                'upload_path': 'projects'
            },
            'swf': '/plugins/uploadify/uploadify.swf',
            'uploader': '/plugins/uploadify/uploadify.php',
            'buttonImage': '/images/createNew/upload-img.png',
            'buttonText': '',
            'fileTypeDesc': '图片文件',
            'fileTypeExts': '*.jpg;*.jprg;*.png;*.bmp;*.gif',
            'fileSizeLimit': "<?= yii::$app->params['fileSizeLimit'] ?>",
            'removeCompleted': false,
            'overrideEvents': ['onUploadSuccess'],
            'width': 150,
            'height': 150,
            'onUploadSuccess': function (file, data, response) {
                if (response) {
                    var html = '<div id="' + file.id + '" name="' + file.id + '" class="upload-result-img demo_img_div">\
                                <img src="' + data + '">\
                                    <a href="javascript:void(0);" class="delete-img" onclick="deleteQueue(this)">\
                                </div>';
                    $(".demo_img_br").before(html);
                }
            }
        });
    });

    function deleteQueue(_this) {
        var file_id = $(_this).parent().attr("id");
        $("div[name='" + file_id + "']").remove();
    }

    $(function () {
        if ($("#basic_form").length > 0) {
            jQuery.validator.addMethod("validateProjName", function (value, element) {
                var reg = /^[\u4E00-\u9FFFa-zA-Z0-9_]{1,20}$/;
                return reg.test(value);
            }, '最多承载20个字，允许中文，字母，数字，下划线');

            // 短信验证码
            jQuery.validator.addMethod("isMobile", function (value, element) {
                return /^1[34578][0-9]{9}$/.test(value);
            }, "请输入正确的手机号");
            // 短信验证码

            jQuery.validator.addMethod("validatePeriod", function (value, element) {
                var reg = /^([1-9]\d{0,2}|1000)$/;
                return reg.test(value);
            }, "1到1000之间的整数");

            jQuery.validator.addMethod("validateProjTag", function (value, element) {
                var reg = /^[\u4E00-\u9FFFa-zA-Z0-9_,，]+$/;
                if (!reg.test(value)) {
                    return false;
                }
                var tag = $.trim(value);
                var tagArr = tag.split(",");
                return tagArr.length < 6 ? true : false;
            }, '最多五个标签，请用逗号隔开！');

            $("#basic_form").validate({
                onsubmit: true,
                onkeyup: false,
                success: "valid_success",
                rules: {
                    proj_name: {
                        required: true,
                        rangelength: [1, 20],
                        validateProjName: true
                    },
                    proj_sub_name: {
                        required: true,
                        rangelength: [2, 30]
                    },
                    indus_pid: {
                        required: true
                    },
                    expected_period: {
                        required: true,
                        validatePeriod: true
                    },
                    proj_tag: {
                        required: true,
                        validateProjTag: true
                    },
                    mobile: {
                        required: function () {
                            return "<?php if(empty($username))?>" ? true : false;
                        },
                        isMobile: true
                    },
                    valid_code: {
                        required: function () {
                            return "<?php if(empty($username))?>" ? true : false;
                        }
                    }
                },
                messages: {
                    proj_name: {
                        required: "请输入项目名称",
                        rangelength: $.validator.format("长度介于 {0} 和 {1} 之间")
                    },
                    proj_sub_name: {
                        required: "请输入项目副标题",
                        rangelength: $.validator.format("长度介于 {0} 和 {1} 之间")
                    },
                    indus_pid: {
                        required: "请选择项目分类"
                    },
                    expected_period: {
                        required: "请输入项目周期"
                    },
                    proj_tag: {
                        required: "请输入项目标签"
                    },
                    mobile: {
                        required: "请输入手机号"
                    },
                    valid_code: {
                        required: "请输入验证码"
                    }
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent());
                },
                submitHandler: function(form){
                    // 校验项目封面地址
                    if ($("img[name='proj_thumb_img']").attr("src") == '') {
                        alert("请上传项目封面");
                        return false;
                    }
                    // 校验手机验证码
                    if (username == '' && !check_valid_code()){
                        alert("验证码不正确");
                        return false;
                    }
                    $(".step_first").removeClass("step-cur").addClass("step-done");
                    $(".step_second").addClass("step-cur");

                    $("#step_basicmsg").hide();
                    $("#step_projectstory").show();
                    $("#proj_member_str").val(username);
                    //实例化编辑器
                    umProjDesc = UE.getEditor('editor_proj_desc');  // 项目介绍
                    umTeamDesc = UE.getEditor('editor_team_desc');  // 团队描述
                    umRemarks = UE.getEditor('editor_remarks');     // 为何入驻
                    umProjRisk = UE.getEditor('editor_proj_risk');  // 项目风险
                }
            });
        }
    });

    // 项目故事，错误信息
    function getProjectExtErrorMsg() {
        // 项目横幅
        if ($("img[name='proj_banner_img']").attr("src") == '') {
            return '请上传项目横幅';
        }
        if (!umProjDesc.hasContents()) {
            return '请输入项目介绍';
        }
        if (!umTeamDesc.hasContents()) {
            return '请输入团队介绍';
        }
        // 项目演示
        var imgArr = [];
        $.each($(".demo_img_div img"), function (idx, obj) {
            imgArr.push($(obj).attr("src"));
        });
        if (imgArr.length < 1) {
            return '请上传项目演示';
        }
        if (!umRemarks.hasContents()) {
            return '请输入入驻理由';
        }
        if (!umProjRisk.hasContents()) {
            return '请输入项目风险';
        }
        if ($.trim($(".add-qa").siblings(".proquestion").last().val()) == '') {
            return '请输入疑问';
        }
        if ($.trim($(".add-qa").siblings(".proanswer").last().val()) == '') {
            return '请输入解答';
        }
        return '';
    }

    // 申请项目，项目基本信息 + 项目故事
    function create_project() {
        // 项目演示
        var imgArr = [];
        $.each($(".demo_img_div img"), function (idx, obj) {
            imgArr.push($(obj).attr("src"));
        });
        // 疑难解答
        var qaArr = [];
        $.each($(".project-qa input"), function (idx, obj) {
            qaArr[idx] = [];
            qaArr[idx].push($(obj).val());
        });
        $.each($(".project-qa textarea"), function (idx, obj) {
            qaArr[idx].push($(obj).val());
        });
        var mobile = '';
        if ($("#mobile").length > 0) {
            mobile = $.trim($("#mobile").val());
        }
        $.ajax({
            type: "POST",
            dataType: "json",
            async: false,
            data: {
                'username': username,
                'proj_name': $.trim($("input[name='proj_name']").val()),
                'proj_sub_name': $.trim($("input[name='proj_sub_name']").val()),
                "indus_pid": $.trim($("#indus_pid").val()),
                "proj_thumb": $.trim($("img[name='proj_thumb_img']").attr("src")),
                "expected_period": $.trim($("input[name='expected_period']").val()),
                'proj_tag': $.trim($("input[name='proj_tag']").val()),
                'mobile': mobile,
                'proj_desc': umProjDesc.getContent(),
                'team_desc': umTeamDesc.getContent(),
                'remarks': umRemarks.getContent(),
                'proj_risk': umProjRisk.getContent(),
                'proj_banner': $("img[name='proj_banner_img']").attr("src"),
                'imgArr': JSON.stringify(imgArr),
                'qaArr': JSON.stringify(qaArr),
                'proj_member_str': $.trim($("#proj_member_str").val())
            },
            url: "/project/default/create",
            success: function (json) {
                if (json.result) {
                    window.location.href = "/project/default/my-project";
                }
                else {
                    alert(json.msg);
                }
            }
        });
    }

    function checkProjExt() {
        var msg = getProjectExtErrorMsg();
        if (msg != '') {
            alert(msg);
            return false;
        }
        var msg = validateProjMember();
        if (msg != '') {
            alert(msg);
            return false;
        }
        create_project();
    }

    // 项目成员，用户名格式化
    if ($("#proj_member_str").length > 0) {
        $("#proj_member_str").on("blur", function () {
            var memberStr = $(this).val();
            memberStr = memberStr.replace(/，/gm, ',');
            memberStr = $.trim(memberStr);
            memberStr = memberStr.replace(/,$/g, "");
            $(this).val(memberStr);
            var errorMsg = validateProjMember();
            if (errorMsg != '') {
                alert(errorMsg);
            }
        });
    }

    // 项目成员用户名合法性校验
    function validateProjMember() {
        var errMsg = '请输入平台注册账号，逗号分隔';
        var memberStr = $.trim($("#proj_member_str").val());
        var reg = /^[a-zA-Z0-9_,，]+$/;
        if (!reg.test(memberStr)) {
            return errMsg;
        }
        if (memberStr != '') {
            $.ajax({
                type: "POST",
                dataType: "json",
                async: false,
                data: {memberStr: memberStr},
                url: "/talent/default/validate-proj-member",
                success: function (json) {
                    errMsg = json.msg;
                }
            });
        }
        return errMsg;
    }
</script>
</body>
</html>
