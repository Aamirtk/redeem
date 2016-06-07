<style>
    .avatar_content{
        height: 120px;
        width: 140px;
        display: block;
        margin-bottom: 20px;
        margin-right: 80px;
    }
    .avatar_img{
        height: auto;
        width: 100px;
        margin: 0 auto 80px 120px;
    }
</style>
<!--<link rel="stylesheet" href="/plugins/webuploader/webuploader.css" type="text/css"/>-->
<script src="/plugins/webuploader/webuploader.js" type="text/javascript"></script>
<div id="content" style="display: block" >
    <form id="form" class="form-horizontal">
        <div class="row">

            <div class="control-group span8">
                <label class="control-label">微信昵称：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['nick'] ?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">真实姓名：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['name'] ?></span>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="control-group span10 avatar_content" >
                <label class="control-label">微信头像：</label>
                <div class="controls ">
                    <img class="avatar_img" src="<?php echo $auth['avatar'] ?>">
                </div>
            </div>
            <div id="upload_img" class="control-group span10 avatar_content " >
                <label class="control-label">名片：点击更改</label>
                <div class="controls ">
                    <img class="avatar_img" src="<?php echo $auth['avatar'] ?>">
                </div>
            </div>
        </div>
        <div class="row">

            <div class="control-group span8">
                <label class="control-label">手机号码：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['mobile']?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">邮箱：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['email'] ?></span>
                </div>
            </div>

            <div class="control-group span8">
                <label class="control-label">微信公众号：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['wechat_openid'] ?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">用户类型：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['user_type'] ?></span>
                </div>
            </div>

            <div class="control-group span8">
                <label class="control-label">申请时间：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['create_at'] ?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">更新时间：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['update_at'] ?></span>
                </div>
            </div>

        </div>

    </form>
</div>

<script>

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
            swf: '/plugins/webuploader/Uploader.swf',
            server: "/common/upload/upload",
            pick: '#upload_img',
            fileNumLimit: 2,
            fileSizeLimit: 2 * 1024 * 1024,
            accept: {
                title: 'Images',
                extensions: 'jpg,jpeg,png',
                mimeTypes: ''
            },
            formData: {
                objtype: 'user',
                username: '1221'
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