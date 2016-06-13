<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>人才库案例编辑</title>
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
    <script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!--cookie domain-->
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
</head>

<body class="bg-grey1 mw1200">
    <script type="text/javascript" src="http://account.vsochina.com/static/js/vsoheader.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/jquery.validate.js"></script>
    <script type="text/javascript" charset="utf-8" src="/plugins/uploadify/jquery.uploadify.js"></script>
    <script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.all.js"></script>
    <script type="text/javascript" charset="utf-8" src="/plugins/ueditor/lang/zh-cn/zh-cn.js"></script>

    <!--content-->
    <div class="caseupload-content">
        <div class="caseupload-content-title">
            编辑案例
        </div>
        <form id="form" disableautocomplete="" autocomplete="off" action="">
            <input type="hidden" id="work_id" name="work_id" value="<?= $model['id'] ?>">
            <input type="hidden" id="obj_username" name="obj_username" value="<?= \frontend\modules\enterprise\models\CrmWork::getCrmUsernameByWorkId($model['id']) ?>">
            <div class="caseupload-form-box">
                <div class="caseupload-form-row clear-float">
                    <div class="caseupload-form-left fl">
                        <label>缩略图：</label>
                    </div>
                    <div class="caseupload-form-middle fl clear-float">
                        <div class="caseupload-form-thumbnail fl">
                            <p class="form-thumnail-icon">
                                <i class="icon-36 icon-36-upload"></i>
                            </p>
                            <div class="input-file-box">
                                <input type="file" class="input-file" id="work_url_upload" name="work_url_upload">
                            </div>
                            <img src="" class="caseupload-img" id="work_url_img" name="work_url_img" style="display: none;">
                        </div>
                        <div class="caseupload-form-desc fl">
                            <div class="form-desc-content">
                                （缩略图尺寸为292*183px，图片大小不超过200MB，支持jpg/png/gif文件格式。）
                            </div>
                        </div>
                        <input type="hidden" id="work_url" name="work_url">
                    </div>
                    <div class="caseupload-form-right h185 fl"></div>
                </div>

                <div class="caseupload-form-row clear-float">
                    <div class="caseupload-form-left fl">
                        <label>名称：</label>
                    </div>
                    <div class="caseupload-form-middle fl clear-float">
                        <input type="text" class="form-control" id="work_name" name="work_name" value="<?= $model['work_name'] ?>">
                    </div>
                    <div class="caseupload-form-right h36 fl"></div>
                </div>

                <div class="caseupload-form-row clear-float">
                    <div class="caseupload-form-left fl">
                        <label>分类：</label>
                    </div>
                    <div class="caseupload-form-middle fl clear-float">
                        <?php $indusArr = \common\models\CommonIndustry::getIndustryList();?>
                        <select id="indus_pid" name="indus_pid" class="form-control">
                            <?php foreach ($indusArr as $k => $v):?>
                                <option value="<?= $v['id'] ?>"<?php if($model['ptype'] == $v['id']):?> selected="selected"<?php endif;?>><?= $v['name'] ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="caseupload-form-right h36 fl"></div>
                </div>

                <div class="caseupload-form-row clear-float">
                    <div class="caseupload-form-left fl">
                        <label>参考价格：</label>
                    </div>
                    <div class="caseupload-form-middle fl clear-float">
                        <input type="text" class="form-control" id="work_price" name="work_price" value="<?= $model['work_price'] ?>">
                    </div>
                    <div class="caseupload-form-right h36 fl"></div>
                </div>

                <div class="caseupload-form-row detail-placement">
                </div>

            </div>
            <div class="caseupload-form-operate clear-float">
                <div class="form-operate-confirm fr">
                    <input type="submit" value="保存">
                </div>
                <div class="form-operate-cancel fr">
                    <input type="button" value="取消" name="cancel">
                </div>
            </div>
        </form>
        <div class="caseupload-form-row detail-placecontent clear-float">
            <div class="caseupload-form-left fl">
                <label>详情描述：</label>
            </div>
            <div class="caseupload-form-middle fl clear-float" >
                <script type="text/plain" id="editor_content" name="editor_content"></script>
            </div>
            <div class="caseupload-form-right h36 fl"></div>
        </div>
    </div>
    <!--/content-->

    <script type="text/javascript" src="http://static.vsochina.com/libs/jquery.lazyload/1.9.5/jquery.lazyload.js"></script>
    <script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>
    <script type="text/javascript" src="/js/rc_index.js"></script>
    <?php require_once(Yii::getAlias('@frontend') . '/webrc/layout/footer.php') ?>
    <style>
        #edui1 {
            width:480px;
            height:355px;
            overflow:scroll;
        }
    </style>
    <script type="text/javascript">
        var work_editor = UE.getEditor('editor_content');
        work_editor.ready(function(){
            work_editor.setContent('<?= $model['content'] ?>');
        });

        function updateWork() {
            var username = getCookie('vso_uname');
            if (username == '') {
                alert("登录后才能进行此操作");
                return false;
            }
            $.ajax({
                type: "POST",
                dataType: "json",
                async: false,
                data: {
                    "work_url": $.trim($("input[name='work_url']").val()),
                    'work_name': $.trim($("input[name='work_name']").val()),
                    "indus_pid": $.trim($("#indus_pid").val()),
                    "work_price": $.trim($("input[name='work_price']").val()),
                    "content": work_editor.getContent()
                },
                url: "/enterprise/work/update?id=" + $("input[name='work_id']").val(),
                success: function (json) {
                    if (json.result) {
                        window.location.href = "/enterprise/work/list/" + $("#obj_username").val();
                    }
                    else {
                        alert(json.msg);
                    }
                }
            });
        }

        $(function () {
            $('#work_url_upload').uploadify({
                'formData': {
                    'timestamp': '<?php echo time();?>',
                    'token': '<?php echo md5('unique_salt' . time());?>',
                    'upload_path': 'company'
                },
                'swf': '/plugins/uploadify/uploadify.swf',
                'uploader': '/plugins/uploadify/uploadify.php',
                'multi': false,
                'buttonText': '',
                //'buttonImage': '/images/rc/enterprise/icon-36-upload.png',
                'fileTypeDesc': '图片文件',
                'fileTypeExts': '*.jpg;*.jprg;*.png;*.bmp;*.gif',
                'fileSizeLimit': "<?= yii::$app->params['fileSizeLimit'] ?>",
                'removeCompleted': false,
                'overrideEvents': ['onUploadSuccess'],
                'width': 292,
                'height': 183,
                'onInit': function (instance) {
                    var data = "<?php if(isset($model['work_url'])):?><?= $model['work_url'] ?><?php endif;?>";
                    $("img[name='work_url_img']").attr("src", data).show();
                    $("#work_url").val(data);
                },
                'onUploadSuccess': function (file, data, response) {
                    if (response) {
                        $("label[for='work_url']").addClass("valid_success").html("").hide();
                        $("img[name='work_url_img']").attr("src", data).show();
                        $("#work_url").val(data);
                    }
                }
            });
        });

        $(function () {

            if ($("#form").length > 0) {
                jQuery.validator.addMethod("validateWorkPrice", function (value, element) {
                    return (/^(([1-9]\d*)|\d)(\.\d{1,2})?$/).test(value);
                }, '参考价格非法');

                jQuery.validator.addMethod("validateContent", function (value, element) {
                    return work_editor.hasContents();
                }, '请输入详情描述');
                $("#form").validate({
                    onsubmit: true,
                    onkeyup: false,
                    rules: {
                        work_url: {
                            required: function(){
                                return $("#work_url").val() == '' ? false : true;
                            }
                        },
                        work_name: {
                            required: true,
                            rangelength: [1, 20]
                        },
                        indus_pid: {
                            required: true
                        },
                        work_price: {
                            required: true,
                            validateWorkPrice: true,
                            max: 99999999.99
                        }
                    },
                    messages: {
                        work_url: {
                            required: "请上传缩略图"
                        },
                        work_name: {
                            required: "请输入案例名称",
                            rangelength: jQuery.validator.format("长度介于 {0} 和 {1} 之间")
                        },
                        indus_pid: {
                            required: "请选择案例分类"
                        },
                        work_price: {
                            required: "请输入参考价格",
                            max: jQuery.validator.format("最大值 {0} 元")
                        }
                    },
                    errorPlacement: function(error, element) {
                        error.appendTo(element.parents("div.caseupload-form-middle").next("div"));
                        //error.appendTo(element.parent());
                    },
                    submitHandler: function(form){
                        if (!work_editor.hasContents()) {
                            alert("请输入详情描述");
                            return false;
                        }
                        updateWork();
                    }
                });
            }
        });

        $("input[name='cancel']").on("click",function(){
            location.href = "<?= yii::$app->urlManager->createUrl('/enterprise/work/list/"+ $("#obj_username").val() +"');?>";
        });
    </script>
</body>

</html>
