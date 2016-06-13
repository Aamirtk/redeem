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
        <title>人才库个人入驻</title>
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
                <span class="certification-top-title">个人入驻</span>
                <span class="certification-top-subtitle">（带有<i class="redstar">*</i>的项目是必填的哦）</span>
            </div>
            <div class="enterprise-certification-body">
                <form action="" method="post" enctype="multipart/form-data" id="info_form" >
                    <div class="rc-bind-form">
<!--                        <div class="form-group clear-float">
                            <label class="form-label">用户名：</label>
                            <label class="form-username-info"><?= $vso_uname ?></label>
                            <input type="hidden" name="username" value="<?= $vso_uname ?>" />
                        </div>-->
                        <input type="hidden" name="username" value="<?= $vso_uname ?>" />
                        <div class="form-group clear-float">
                            <label class="form-label"><i class="redstar">*</i>手机号码：</label>
                            <?php if((isset($applyInfo['data']['status'])&&($applyInfo['data']['status']==1))||(isset($userInfo['mobile'])&&!empty($userInfo['mobile']))){?>
                            <label class="form-username-info"><?= isset($applyInfo['data']['mobile'])?$applyInfo['data']['mobile']:$userInfo['mobile'] ?></label>
                            <input type="hidden" name="hiddenmobile" id="hiddenmobile" value="<?=$userInfo['mobile']?>"/>
                        </div>
                            <?php }else{?>
                        <input type="text" name="mobile" id="mobile" maxlength="11"  class="form-control w480" value="" placeholder="请输入手机号码" />

                        </div>
                        <div class="form-group clear-float">
                            <label class="form-label"><i class="redstar">*</i>验证码：</label>
                            <input type="text" name="valid_code" id="valid_code"  class="form-control w180" value="" placeholder="请输入验证码" />
                            <input type="button" value="点击发送验证码" class="ds-btn btn-yellow" id="info_form_code">
                        </div>
                        <?php }?>

                    <?php if((isset($applyInfo['data']['status'])&&($applyInfo['data']['status']==1))){?>
                    <div class="form-group clear-float" style="height:auto;">
                            <label class="form-label"><i class="redstar">*</i>上传作品：</label>
                            <img src="<?=$applyInfo['data']['work_url']?>" height="120" width="480" id="work_url_img">
                    </div>
                    <?php }else{?>
                        <div class="form-group form-group-placement">
                            <div class="placement-box"></div>
                            <input type="hidden" name="work_url"  id="work_url" value="" />
                        </div>
                    <?php }?>
                        <div class="form-group clear-float heightauto">
                            <label class="form-label"><i class="redstar">*</i>自我介绍：</label>
                            <?php if((isset($applyInfo['data']['status'])&&($applyInfo['data']['status']==1))){?>
                            <label class="form-username-info"><?= strip_tags($applyInfo['data']['introduction']) ?></label>
                            <?php }else{ ?>
                            <textarea name="introduction" id="introduction" cols="30" rows="10" maxlength="200" class="form-control w480" placeholder="快用简明的语言来介绍自己吧！  O(∩_∩)O"></textarea>
                            <?php }?>
                        </div>
                        <div class="form-group clear-float">
                            <label class="form-label"></label>
                            <?php if((isset($applyInfo['data']['status'])&&($applyInfo['data']['status']==1))){?>
                            <label  class="btn-submit">审核中</label>
                            <?php }else{ ?>
                            <input type="submit" class="btn-submit" value="提交认证" />
                            <?php }?>
                        </div>
                    </div>
                </form>
<?php if(!(isset($applyInfo['data']['status'])&&($applyInfo['data']['status']==1))){?>
                <iframe src="" id="loading" name="loading" style="display: none" width="100px" height="100px"></iframe>

                <form class="form-group-placeholder top188" name="upload" id="upload" method="POST" enctype="multipart/form-data" action="<?= yii::$app->params['workUploadUrl'] ?>?" target="loading"
                      <?=(isset($userInfo['mobile'])&&!empty($userInfo['mobile']))?'style="top:80px"':'style="top:140px"'?>>
                    <input type="hidden" name="callback" value="<?= yii::$app->params['rc_frontendurl'] ?><?= Yii::$app->urlManager->createUrl("rc/recruit/personal?") ?>"/>
                    <input type="hidden" name="username" value="<?= $vso_uname ?>"/>
                    <input type="hidden" name="objtype" value="work"/>
                    <input type="hidden" name="appid" value="vsomaker"/>
                    <input type="hidden" name="token" value="vsomaker"/>
                    <div class="form-group height-auto clear-float">
                        <label class="form-label"><i class="redstar">*</i>上传作品：</label>
                        <div class="form-upload-box clear-float">
                            <!--当没有预览图片时，显示这个div-->
                            <div class="upload-box-before upload-btn">
                                <input type="file" name="attachment" id="fileToUpload" class="rc-uploader"  onchange="return uploadfile();"/>
                                <img src="" id="work_url_img" style="display:none">
                            </div>
                            <!--/当有预览图片时，显示这个div-->
                            <dl class="clear-float">
<!--                                <dt class="mt2">
                                    <input type="button" id="fileuploadbt" class="upload-btn" value="开始上传" onclick="return uploadfile();"/>
                                </dt>-->
                                <dd>
                                   1. 作品可上传一张图片。
                                </dd>
                                <dd>
                                    2. 仅支持jpg,bmp,png,gif的图片格式。图片大小不超过2M。
                                </dd>
                            </dl>
                        </div>
                    </div>
                </form>
<?php }?>
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
                    alert('请先选择作品图片');
                    return false;
                }
                jQuery("#upload").submit();
            }
            function setfileurl(fileurl) {
                $("#work_url").val(fileurl);
                $(".upload-box-before").attr("class", "upload-box-after upload-btn");
                $("#work_url_img").attr("src", fileurl).show();
                //$(".upload-box-before").hide();
                //$(".upload-box-after").show();
            }

            $(function () {

                //电话验证 支持0-9 -
                $.validator.addMethod("isTelepone", function (value, element) {
                    if (typeof (value) != "undefined" && value != '') {
                        var length = value.length;
                        return this.optional(element) || length == 11 && /^1[34578]\d{9}$/.test(value);
                    } else {
                        return true;
                    }
                }, "请输入正确的手机号码");

                $("#info_form").validate({
                    onkeyup: false,
                    errorClass: "error-msg",
                    success: "valid_success",
                    rules: {
                        mobile: {
                            required: true,
                            isTelepone: true,
                            remote: "<?= yii::$app->params['rc_frontendurl'] ?>/rc/recruit/validate-personal-mobile"
                        },
                        valid_code: {
                            required: true,
                        },
                        work_url: {
                            required:  true,
                            accept: "jpg|bmp|png|gif",
                        },
                        introduction: {
                            required:  true,
                        },
                    },
                    messages: {
                        mobile: {
                            required: "请输入手机号码",
                            remote: "手机号码已申请了认证，如非本人申请，请联系客服 400-164-7979"
                        },
                        valid_code: {
                            required: "请输入验证码",
                        },
                        introduction: {
                            required: "请输入自我介绍",
                        },
                        work_url: {
                            required: "请上传作品图片",
                            accept: "请上传正确的图片格式"
                        }
                    },
                    errorPlacement: function(error, element) {
                        error.appendTo(element.closest(".form-group"));
                    },
                    submitHandler:function(form){

                            createPersonal();
                            return false;
                    }
                });

            });

            function createPersonal()
            {
                $.ajax({
                    type: 'post',
                    url: "<?= yii::$app->params['rc_frontendurl'] ?>/rc/recruit/create-personal",
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

            $("#info_form_code").on("click",function(){
                var timerCode = "";
                var _this = $(this) ;
                if(!$(this).hasClass("disabled")){
                    var mobile=$("#mobile").val();
                    $.ajax({
                    type: 'post',
                    url: "<?= yii::$app->params['rc_frontendurl'] ?>/rc/recruit/send-valid-code",
                    data: {'mobile':mobile},
                    dataType: 'json',
                    success: function (data) {
                        if (13520 == data.ret)
                        {
                            var num = 60;
                            timerCode = setInterval(function(){
                                if(num <=1 ){
                                    clearInterval(timerCode);
                                    _this.removeClass("disabled");
                                    _this.val("点击发送验证码");
                                    return false;
                                }
                                num--;
                                _this.val(num+"秒后重新发送");
                                _this.addClass("disabled");
                            },1000);
                        } else
                        {
                            alert(data.message);
                        }
                    },
                    error: function () {
                        alert('系统繁忙,请稍候重试');
                    },
                });

                }
            });
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