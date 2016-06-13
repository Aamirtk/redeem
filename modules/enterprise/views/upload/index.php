<?php if ($this->context->is_self): ?>
    <link type="text/css" rel="stylesheet" href="/plugins/cropper/css/main.css">
    <link type="text/css" rel="stylesheet" href="/plugins/cropper/dist/cropper.min.css">
    <script type="text/javascript" src="/plugins/cropper/js/main.js"></script>
    <script type="text/javascript" src="/plugins/cropper/dist/cropper.min.js"></script>

    <input type="hidden" id="company_banner" value=""/>
    <input type="hidden" id="company_logo" value=""/>
    <div class="container" id="crop-avatar">
        <!-- Cropping modal -->
        <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog"
             tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="avatar-modal-label">基础设置</h4>
                    </div>
                    <div class="modal-body">
                        <div class="avatar-body">
                            <!-- form1 -->
                            <form class="avatar-form" action="/plugins/cropper/crop.php" enctype="multipart/form-data"
                                  method="post">
                                <!-- Upload image and data -->
                                <p class="setting-title">企业logo</p>

                                <div class="clearfix">
                                    <div class="avatar-upload">
                                        <input type="hidden" class="avatar-src" name="avatar_src">
                                        <input type="hidden" class="avatar-data" name="avatar_data">
                                        <input type="file" class="avatar-input" id="avatarInput" name="myfile">
                                    </div>
                                    <p class="color-orange">* 10MB以内？RBG模式 &nbsp;&nbsp; 支持格式：JPG/GIF/PNG</p>
                                </div>
                                <!-- Crop and preview -->
                                <div class="clearfix">
                                    <div class="setting-title-bg">
                                        <span class="glyphicon glyphicon-picture"></span>

                                        <div class="avatar-wrapper"></div>
                                    </div>
                                    <div class="setting-title-bg-right pull-left">
                                        <div class="setting-title-bg-sm">
                                            <span class="glyphicon glyphicon-picture"></span>

                                            <div class="avatar-preview preview-lg"></div>
                                        </div>
                                        <div class="setting-title-bg-sm-sm">
                                            <span class="glyphicon glyphicon-picture"></span>

                                            <div class="avatar-preview preview-sm"></div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <p class="setting-title">替换背景图</p>

                            <form action="" method="post" id="save_config">
                                <div class="upload-enterprise-banner" id="image_picker_local">
                                    <?php
                                    $banner = $this->context->company['banner'];
                                    $logo = $this->context->company['logo'];
                                    if (empty($banner)) {
                                        $banner = yii::$app->params['default_enterprise_banner'];
                                    }
                                    ?>
                                    <img class="avatar-input-banner-img "
                                         src="<?= !empty($banner) ? $banner : '/images/rc/enterprise/case-demo1.jpg' ?>"
                                         alt="" style="width: auto; height: 122px">
                                </div>
                                <p class="color-orange">* 20MB以内？RBG模式 支持尺寸：1920x455，支持格式：JPG/GIF/PNG</p>

                                <p class="setting-title">交易设置</p>
                                <?php
                                if (isset($this->context->company['record_is_show']) && $this->context->company['record_is_show'] == 1) {
                                    $isShow = true;
                                } else {
                                    $isShow = false;
                                }
                                ?>
                                <label class="setting-trade"><input type="radio" name="record_is_show"
                                                                    value="1" <?php if ($isShow) {
                                        echo " checked ";
                                    } ?>>显示交易记录</label>
                                <label class="setting-trade"><input type="radio" name="record_is_show"
                                                                    value="2" <?php if (!$isShow) {
                                        echo " checked ";
                                    } ?>>隐藏交易记录</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-blue" id="sub_btn">确定</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal -->

        <!-- Loading state -->
        <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
    </div>
    <script type="text/javascript" src="http://static.vsochina.com/libs/webuploader/0.1.5/webuploader.js"></script>
    <script>

        var _savr_config = function (_this) {
            var company_id = $("#company_id").val();
            var logo = $("#company_logo").val();
            var banner = $("#company_banner").val();
            var record_is_show = $("[name='record_is_show']:checked").val();
            $.ajax({
                url: '<?php echo yii::$app->urlManager->createUrl('/enterprise/default/edit-company')?>',
                type: 'post',
                dataType: 'json',
                data: {
                    id: company_id,
                    logo: logo,
                    banner: banner,
                    record_is_show: record_is_show
                },
                success: function () {
                    $('#avatar-modal').modal('hide');
                    if (banner != "" && banner != undefined) {
                        $(".enterprise-banner-bg").attr("src", banner);
                    }
                    if (logo != "" && banner != logo) {
                        $(".company-logo").attr("src", logo);
                    }
                    if (record_is_show == 1) {
                        $("#ent_record").show(200);
                    }
                    else {
                        $("#ent_record").hide(200);
                    }
                }
            });
        };

        $('#sub_btn').click(function () {
            var _this = $(this);
            var form_data = new FormData($(".avatar-form")[0]);
            $.ajax({
                url: '/plugins/cropper/crop.php',
                type: 'post',
                data: form_data,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function () {
                },
                success: function (data) {
                    if (data.state == 200) {
                        if(data.result){
                            $("#company_logo").val(data.result);
                            $(".bg-img-div").find('img').attr('src', data.result);
                        }
                        _savr_config(_this);
                    } else {
                        alert('裁剪失败，请稍后再试！');
                    }
                }
            });
            return false;
        });

        var _file_upload_notice = function (handler) {
            switch (handler) {
                case 'Q_TYPE_DENIED':
                    alert('文件类型不正确！');
                    break;
                case 'Q_EXCEED_SIZE_LIMIT':
                    alert('上传文件总大小超过限制！');
                    break;
                case 'Q_EXCEED_NUM_LIMIT':
                    alert('上传文件总数量超过限制！');
                    break;
            }
        };

        $(document).on('click', '.webuploader-pick', function () {
            $('.webuploader-element-invisible').trigger('click');
        });
        $(function () {
            var picUploader = WebUploader.create({
                auto: true,
                fileVal: 'attachment',
                swf: 'http://static.vsochina.com/static/webuploader/Uploader.swf',
                server: '/upload_file',
                pick: '#image_picker_local',
                fileNumLimit: 1,
                fileSizeLimit: 2 * 1024 * 1024,
                accept: {
                    title: 'Images',
                    extensions: 'jpg,jpeg,png',
                    mimeTypes: ''
                },
                formData: {
                    objtype: 'rc',
                    username: '<?php echo $this->context->obj_username?>'
                }
            });
            picUploader.on('error', function (handler) {
                _file_upload_notice(handler);
            });

            picUploader.on('beforeFileQueued', function (handler) {
                picUploader.reset();
            });

            picUploader.on('fileQueued', function (file) {
            });
            picUploader.on('uploadProgress', function (file, percentage) {
            });
            picUploader.on('uploadSuccess', function (file, response) {
                if (typeof (response.ret) == 'undefined') {
                    var _file_ret = $(response._raw).find('ret').text();
                    var _file_path = $(response._raw).find('file_url').text();
                }
                else {
                    var _file_ret = response.ret;
                    var _file_path = response.data.file_url;
                }

                if (_file_ret == '13900') {
                    $("#company_banner").val(_file_path);
                    $('.avatar-input-banner-img').attr('src', _file_path);
                }
            });
            picUploader.on('uploadError', function (file) {
                alert('图片上传失败，请稍后再试！');
            });
        });
    </script>
<?php endif ?>
