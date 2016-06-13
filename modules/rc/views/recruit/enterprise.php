<?php
if ($file_url)
{
    echo "<script>window.parent.setfileurl('$file_url');</script>";
    exit();
}
if (empty($vso_uname))
{
    echo "<script>window.location.href='".yii::$app->params['loginUrl']."';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>人才库企业入驻</title>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="renderer" content="webkit" />
        <!--reset.css  header.css  footer.css-->
        <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css" />
        <!--css-->
        <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/libs/bootstrap/3.3.5/css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="/css/rc_index.css">
        <link type="text/css" rel="stylesheet" href="/css/rc_case.css">
        <!--jquery-->
        <script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="http://account.vsochina.com/static/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <!--cookie domain-->
        <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
        <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
    </head>

    <body class="bg-darkgrey mw1200">
        <!--header-->
        <script type="text/javascript" src="http://account.vsochina.com/static/js/vsoheader.js"></script>
        <?php echo $_this_obj->renderPartial('//rc/index_header'); ?>
        <!--/header-->

        <!--banner-->
        <div class="enter-banner">
            <img src="/images/rc/enter-demo1.jpg">
        </div>
        <!--/banner-->

        <!--enterprise-certification-->
        <div class="enter-enterprise-certification">
            <div class="enterprise-certification-top">
                <span class="certification-top-title">企业入驻</span>
                <span class="certification-top-subtitle">（带有<i class="redstar">*</i>的项目是必填的哦）</span>
            </div>
            <div class="enterprise-certification-body">
                <form action="" method="post" enctype="multipart/form-data" id="info_form" >
                    <div class="rc-bind-form">
                        <div class="form-group clear-float">
                            <label class="form-label">用户名：</label>
                            <label class="form-username-info"><?= $vso_uname ?></label>
                            <input type="hidden" name="username" value="<?= $vso_uname ?>" />
                        </div>
                        <div class="form-group clear-float">
                            <label class="form-label"><i class="redstar">*</i>企业名：</label>
                            <input type="text" name="enterprise"  class="form-control w480" value="<?=isset($authInfo['company'])?$authInfo['company']:''?>" placeholder="请输入企业名" />
                            <!--                        <label class="error-msg">企业名已申请了认证，如非贵公司申请，请联系客服 400-164-7979</label>-->
                        </div>
                        <div class="form-group clear-float">
                            <label class="form-label"><i class="redstar">*</i>经营范围：</label>
                            <div class="select-group">
    <!--                           <select class="form-control w150"></select>
                               <select class="form-control w150"></select>
                               <select class="form-control w150"></select>-->
                                <select class="form-control w150" name="indus_pid" id="indus_pid">
                                    <option value="请选择行业">选择行业</option>
                                    <?php foreach ($data['indus_p_arr'] as $k => $v): ?>
                                        <option value="<?php echo $v['old_indus_id'] ?>" <?php if (isset($data['vsoInfo']['indus_pid']) && ($data['vsoInfo']['indus_pid'] == $v['old_indus_id'])): ?>selected="selected"<?php endif; ?>><?php echo $v['name']; ?></option>
<?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clear-float">
                            <label class="form-label"><i class="redstar">*</i>所属地区：</label>
                            <div class="select-group">
                                <select name="province" id="province" class="form-control w150"></select>
                                <select name="city" id="city" class="form-control w150"></select>
                                <select name="area" id="area" class="form-control w150"></select>
                            </div>
                        </div>
                        <div class="form-group clear-float">
                            <label class="form-label"><i class="redstar">*</i>登记注册号码：</label>
                            <input type="text" name="licen_num" class="form-control w480" value="<?=isset($authInfo['licen_num'])?$authInfo['licen_num']:''?>" placeholder="请输入登记注册号码" />
                        </div>
                        <div class="form-group form-group-placement">
                            <div class="placement-box"></div>
                            <input type="hidden" name="licen_pic"  id="licen_pic" value="<?=isset($authInfo['licen_pic'])?$authInfo['licen_pic']:''?>" /></div>
                        <div class="form-group clear-float">
                            <label class="form-label minor">法人真实姓名：</label>
                            <input type="text" class="form-control w480" value="<?=isset($authInfo['legal'])?$authInfo['legal']:''?>" name="legal" placeholder="请输入法人真实姓名" />
                        </div>
                        <div class="form-group clear-float">
                            <label class="form-label minor">法人身份证：</label>
                            <input type="text" class="form-control w480" value="<?=isset($authInfo['legal_id_card'])?$authInfo['legal_id_card']:''?>" name="legal_id_card" placeholder="请输入法人身份证" />
                        </div>
                        <div class="form-group clear-float">
                            <label class="form-label minor">公司电话：</label>
                            <input type="text" class="form-control w480" value="<?=isset($authInfo['telephone'])?$authInfo['telephone']:''?>" name="telephone" placeholder="请输入公司电话" />
                        </div>
                        <div class="form-group clear-float">
                            <label class="form-label"></label>
                            <input type="submit" class="btn-submit" value="提交认证" />
                        </div>
                    </div>
                </form>

                <iframe src="" id="loading" name="loading" style="display: none" width="100px" height="100px"></iframe>

                <form class="form-group-placeholder" name="upload" id="upload" method="POST" enctype="multipart/form-data" action="<?= yii::$app->params['workUploadUrl'] ?>?" target="loading">
                    <input type="hidden" name="callback" value="<?= yii::$app->params['rc_frontendurl'] ?><?= Yii::$app->urlManager->createUrl("rc/recruit/enterprise?") ?>"/>
                    <input type="hidden" name="username" value="<?= $vso_uname ?>"/>
                    <input type="hidden" name="objtype" value="user_cert"/>
                    <input type="hidden" name="appid" value="vsomaker"/>
                    <input type="hidden" name="token" value="vsomaker"/>
                    <div class="form-group height-auto clear-float">
                        <label class="form-label"><i class="redstar">*</i>营业执照图片：</label>
                        <div class="form-upload-box clear-float">
                            <!--当没有预览图片时，显示这个div-->
                            <div class="<?=isset($authInfo['licen_pic'])?'upload-box-after':'upload-box-before'?> upload-btn">
                                <input type="file" name="attachment" id="fileToUpload" class="rc-uploader" onchange="return uploadfile();" />
                                <img src="<?=isset($authInfo['licen_pic'])?$authInfo['licen_pic']:''?>" id="licen_pic_img" style="<?=isset($authInfo['licen_pic'])?'display:block;':'display:none;'?>">
                            </div>
                            <!--/当没有预览图片时，显示这个div-->
                            <!--当有预览图片时，显示这个div-->
<!--                            <div class="upload-box-after upload-btn" style="display:none;">-->
<!--                                <input type="file" name="attachment" id="fileToUpload" class="rc-uploader" />-->
<!--                                <input type="file" name="attachment" id="fileToUpload" class="rc-uploader" />-->

<!--                            </div>-->
                            <!--/当有预览图片时，显示这个div-->
                            <dl class="clear-float">
<!--                                <dt>
                                    <input type="button" id="fileuploadbt" class="upload-btn" value="开始上传" onclick="return uploadfile();"/>
                                </dt>-->
                                <dd>
                                    1. 请上传有效的营业执照图片，非证件图片不予受理。
                                </dd>
                                <dd>
                                    2. 证件必须是彩色原件电子版，可以是扫描件或者数码拍摄照片。
                                </dd>
                                <dd>
                                    3. 仅支持jpg,bmp,png,gif的图片格式。图片大小不超过2M。
                                </dd>
                            </dl>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--/enterprise-certification-->
        <script type="text/javascript" src="http://account.vsochina.com/static/js/jquery.validate.js"></script>
        <!--add province city area-->
        <script type="text/javascript" src="http://account.vsochina.com/static/js/auth/validate_idcard.js"></script>
        <script type="text/javascript" src="http://account.vsochina.com/static/js/PCASClass.js"></script>
        <script>
                    //跨越上传文件
                    function uploadfile() {
                        if(''==$("#fileToUpload").val())
                        {
                            alert('请先选择营业执照图片');
                            return false;
                        }
                        jQuery("#upload").submit();
                    }
                    function setfileurl(fileurl) {
                        $("#licen_pic").val(fileurl);
                        $(".<?=isset($authInfo['licen_pic'])?'upload-box-after':'upload-box-before'?> ").attr("class", "upload-box-after upload-btn");
                        $("#licen_pic_img").attr("src", fileurl).show();
                        //$(".upload-box-before").hide();
                        //$(".upload-box-after").show();
                    }

                    $(function () {

                        new PCAS("province", "city", "area", "<?php echo isset($data['vsoInfo']['local'][0]) ? $data['vsoInfo']['local'][0] : '' ?>", "<?php echo isset($data['vsoInfo']['local']['1']) ? $data['vsoInfo']['local'][0] : '' ?>", "<?php echo isset($data['vsoInfo']['local']['2']) ? $data['vsoInfo']['local']['2'] : '' ?>");

                        // 真实姓名验证
                        $.validator.addMethod("trueNameCheck", function (value, element) {
                            if (typeof (value) != "undefined" && value != '') {
                                return /^[\u4E00-\u9FFF]{2,4}$/.test(value);
                            } else {
                                return true;
                            }
                        }, "请输入正确的真实姓名");

                        // 身份证号 正则验证
                        $.validator.addMethod("isIdCard", function (value, element) {
                            if (typeof (value) != "undefined" && value != '') {
                                return isIdCardNo(value);
                            } else {
                                return true;
                            }

                        }, "请输入正确的身份证号");

                        $.validator.addMethod("imgSizeCheck", function (value, element) {
                            return validate_size;
                        }, "请上传正确的营业执照");

                        $.validator.addMethod('selectIndus', function (value, element) {
                            return this.optional(element) || (value != "请选择行业");
                        }, "选择行业");

                        $.validator.addMethod('selectProvince', function (value, element) {
                            return value == "" ? false : true;
                        }, "选择省份和城市");


                        //电话验证 支持0-9 -
                        $.validator.addMethod("isTelepone", function (value, element) {
                            if (typeof (value) != "undefined" && value != '') {
                                return /^\d+(-\d+)*$/.test(value);
                            } else {
                                return true;
                            }
                        }, "请输入正确的电话号码");

                        $("#info_form").validate({
                            onkeyup: false,
                            errorClass: "error-msg",
                            success: "valid_success",
                            rules: {
                                enterprise: {
                                    required: true,
                                    remote: "<?= yii::$app->params['rc_frontendurl'] ?>/rc/recruit/validate-enterprise-name"
                                },
                                licen_num: {
                                    required: true,
                                    rangelength: [5,30]
                                },
                                indus_pid: {
                                    selectIndus: true
                                },
                                telephone: {
                                    isTelepone: true
                                },
                                legal_id_card: {
                                    isIdCard: true
                                },
                                legal: {
                                    trueNameCheck: true
                                },
                                province: {
                                    selectProvince: true
                                },
                                licen_pic: {
                                    required:  true,
                                    accept: "jpg|bmp|png|gif",
                                }
                            },
                            messages: {
                                enterprise: {
                                    required: "请输入企业名称",
                                    remote: "企业名已申请了认证，如非贵公司申请，请联系客服 400-164-7979"
                                },
                                licen_num: {
                                    required: "请输入营业号",
                                    rangelength: "请输入合法的营业号"
                                },
                                licen_pic: {
                                    required: "请上传营业执照",
                                    accept: "请上传正确的图片格式"
                                }
                            },
                            errorPlacement: function(error, element) {
                                error.appendTo(element.closest(".form-group"));
                            },
                            submitHandler:function(form){

                                    createEnterprise();
                                    return false;
                            }
                        });

                    });

                    function createEnterprise()
                    {
                        $.ajax({
                            type: 'post',
                            url: "<?= yii::$app->params['rc_frontendurl'] ?>/rc/recruit/create-enterprise",
                            data: $('#info_form').serializeArray(),
                            dataType: 'json',
                            success: function (data) {
                                if (13830 == data.ret)
                                {
                                    alert('入驻申请提交成功,信息正在审核中,请耐心等待');
                                } else
                                {
                                    alert(data.message);
                                }
                            },
                            error: function () {
                                alert('系统繁忙,请稍候重试');
                            },
                        });
                        return false;
                    }
        </script>
        <script type="text/javascript" src="http://static.vsochina.com/libs/jquery.lazyload/1.9.5/jquery.lazyload.js"></script>
        <script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>
        <script type="text/javascript" src="/js/rc_index.js"></script>
        <!--footer-->
        <script type="text/javascript" src="http://account.vsochina.com/static/js/vsofooter.js"></script>
        <!--add experience-->
        <script type="text/javascript" src="http://account.vsochina.com/static/js/experience.js?v=1"></script>
        <div style="display: none;">
            <!--
                <script type="text/javascript" charset="utf-8" src="http://account.vsochina.com/static/js/global_statistics.js"></script>
            -->
            <div>

<?php echo $_this_obj->renderPartial('//rc/index_footer'); ?>
                </body>

                </html>