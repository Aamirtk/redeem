<h3 style="cursor: move;" id="fctrl_report" class="flb">
    <em>
        举报提交
    </em>
  <span>
    <a href="javascript:;" class="flbc" onclick="hideWindow('report');" title="close">
        关闭
    </a>
  </span>
</h3>
<link href="http://www.vsochina.com/resource/kendoui/css/examples-offline.css" rel="stylesheet" type="text/css">
<link href="http://www.vsochina.com/resource/kendoui/css/kendo.common.min.css" rel="stylesheet" type="text/css">
<link href="http://www.vsochina.com/resource/kendoui/css/kendo.default.min.css" rel="stylesheet" type="text/css">
<link href="http://www.vsochina.com/resource/kendoui/css/kendo.silver.min.css" rel="stylesheet" type="text/css">
<link href="http://www.vsochina.com/resource/kendoui/css/upload.css" rel="stylesheet" type="text/css">
<link href="http://account.vsochina.com/static/css/uc/dialog-new.css" rel="stylesheet" type="text/css">
<link type="text/css" rel="stylesheet" href="http://static.vsochina.com/libs/webuploader/0.1.5/webuploader.css">
<script src="http://static.vsochina.com/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="http://static.vsochina.com/libs/webuploader/0.1.5/webuploader.js"></script>

<!-- studio upload file start -->
<div fwin="report" id="window_up_big" style="width: 496px; height: 520px; position: absolute; left: 395px; top: 521px; z-index: -1;">
</div>
<!-- studio upload file end -->
<style type="text/css">
    .file {
        position:relative;
        font-size:23px;
        filter:alpha(opacity:0);
        -moz-opacity:0;
        opacity:0;
        z-index:2;
        height:40px;
        width:100px;
        cursor:pointer;
    }
    div.fileinputs {
        position:relative;
    }
    div.fakefile {
        left:5px;
        position:relative;
        z-index:1;
        margin:8px 0px;
    }
    #upload {
        position:absolute;
        font-size:23px;
        filter:alpha(opacity:0);
        -moz-opacity:0;
        opacity:0;
        z-index:2;
        height:28px;
        width:85px;
        cursor:pointer;
        top:0px;
        left:0px;
    }
    .fakefile_new .upload_btns {
        margin:0px;
    }

</style>
<div class="winbody">
    <div class="clearfix blue_style">
        <!--from表单 start-->
        <form fwin="report" method="post" id="frm_report" name="frm_report" action="">
            <input name="obj" value="product" type="hidden">
            <input name="obj_id" value="40044" type="hidden">
            <input name="type" value="2" type="hidden">
            <input name="to_uid" value="1733748" type="hidden">
            <input name="to_username" value="86750006" type="hidden">
            <div fwin="report" class="rowElem clearfix" id="upload_tip">
                <!-- 修改人：李晓夏 修改时间：2012-07-09 修改说明：将页面lang变量写死为字符串，防止字符串无法被编译显示出现空白窗体的问题
                -->
                <label class="fl_l t_r" style="margin-top:10px;margin-left:10px;">
                    附件上传：
                </label>
                <div class="fl_l fileinputs">
                    <input fwin="report" name="file_url" id="file_url" type="hidden">
                    <div class="fakefile fakefile_new" style="display:inline-block">
                        <div class="upload_btns clearfix file_upload">
                            <div fwin="report" class="uploadify-queue" id="upload_accessory_queue_repot-queue">
                            </div>
                            <div fwin="report"   class="uploadify" id="">
                                <div onclick="" id="filepicker_local" class="uploadify-button ">
                                  <a class="uploadify-button-text" >
                                    上传文件
                                  </a>
                                </div>
                            </div>
                            <a class="upload_btn_s" id="filepicker_studio">
                                工作室上传
                            </a>
                            <ul id="sc_file_uplist" class="uploader-list clearfix"></ul>
                        </div>
                    </div>
                    <!-- 修改人：陈雪 修改时间：20120915 修改说明：调整文字位置，使其美观、整齐 -->
                    <div style="margin-left:5px; line-height: 19px;">
                        <div style="margin-bottom:0">
                            只允许上传一个附件
                        </div>
                        <div style="margin-bottom:0">
                            支持格式为:.doc,.docx,.rar,.zip(上限500MB)
                        </div>
                    </div>
                </div>
            </div>



            <!-- <div class="rowElem clearfix">
            <ul id="upfile" class="mt_10 mb_10" style="padding-left:60px;width:400px"></ul>
            </div>
            -->
            <!-- 修改人：陈雪 修改时间：20120920 修改说明：调整了“原因”的格式 -->
            <!-- <label class="fl_l t_r">举报原因： </label> -->
            <label class="fl_l t_r" style="width:60px;;margin-left:10px;">
                原&nbsp;&nbsp;&nbsp;&nbsp;因：
            </label>
            <div fwin="report" class="" style="padding-left:60px;width:400px" id="desc">
                <div class="clearfix">
                    <textarea fwin="report" rows="3" name="tar_content" id="tar_content" class="clearfix"
                              maxlength="100" onkeyup="check_(this,'length_show')" style="width: 341px; border:1px solid #ccc;">
                    </textarea>
                    <div class="clear">
                    </div>
                    <div fwin="report" class="c999" id="length_show" style="margin-left:9px;">
                        已输入长度:0,还可以输入:100
                    </div>
                </div>
            </div>
            <div class="rowElem clearfix" style="padding-left:70px;width:400px">
                <div class="messages clearfix" style="height: auto;">
      <span class="icon16" style="margin-top:7px;">
      </span>
                    <label>
                        交易维权
                    </label>
                    <div class="pl_10">
                        <ul>
                            <li class="clearfix">
                                1.与被维权人有实际交易，但发现其在[“创意云”在线创作平台]上有违规情况，可以通过维权途径告知网站，维权为实名。
                            </li>
                            <li class="clearfix">
                                2.与他人无实际交易产生，但发现其在[“创意云”在线创作平台]上有违规情况，可以通过举报、投诉途径告知网站，举报、投诉为匿名。
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="rowElem clearfix form_button" style="padding-top:10px;margin-right:16px;">
                <button type="button" class="button" value="保存" onclick="subReport()">
      <span class="check icon">
      </span>
                    保存
                </button>
                <button type="button" class="button" style="margin-right:0px" value="取消"
                        onclick="hideWindow('report')">
      <span class="reload icon">
      </span>
                    取消
                </button>
            </div>
        </form>
        <!--from表单 end-->
    </div>
</div>
<script>

    //上传素材
    var fileUploader;
    fileUploader = WebUploader.create({
        auto: true,
        fileVal: 'attachment',
        swf: '/static/webuploader/Uploader.swf',
        server: 'http://api.vsochina.com/file/index/upload',
        pick: '#filepicker_local',
        fileNumLimit: 1,
        fileSizeLimit: 200 * 1024 * 1024,
        accept: {
            title: 'CompressedFiles',
            extensions: 'rar,zip',
            mimeTypes: 'application/octet-stream, application/x-rar-compressed, application/zip'
        },
        formData: {
            appid: 1001,
            token: 'yr9hPHTrSgK98Hj0HiLm9jRjMTUwMDQ4ZGY3ODNmYWIxNDdjNzc1NTU0MTgyMzc4',
            username: 'admin',
            objtype: 'shop'
        }
    });
    fileUploader.on('fileQueued', function (file) {
        var _list = $("#sc_file_uplist"),
            _li = $('<li class="goods_file_path" id="' + file.id + '" title="' + file.name + '">\
                        <a class="icon-progress">0%</a>\
                        <i><a class="uploader-delete" href="javascript:void(0);">删除</a></i>\
                    </li>');
        _list.append(_li);
        $(".uploader-delete").on('click', function (event) {
            var _this = $(this),
                _obj = _this.closest('li'),
                fileId = _obj.attr('id');
            fileUploader.removeFile(fileId, true);
            _obj.remove();
        });
    });
    fileUploader.on('uploadProgress', function (file, percentage) {
        $("#" + file.id).find('.icon-progress').html(percentage * 100 + '%');
    });
    fileUploader.on('uploadSuccess', function (file, response) {

        if (typeof (response.ret) == 'undefined') {
            var _file_ret = $(response._raw).find('ret').text();
            var _file_path = $(response._raw).find('file_url').text();
        }
        else {
            var _file_ret = response.ret;
            var _file_path = response.data.file_url;
        }

        var _li = $("#" + file.id),
            _percent = _li.find('.icon-progress');
        if (_file_ret == '13900') {
            var _input = _input = '<input type="hidden" name="goods[goods_path][' + file.id + ']" value="' + _file_path + '" />';
            _percent.html(file.name + '上传成功！' + _input).attr('href', _file_path);
        } else {
            _percent.html(file.name + '上传失败！');
        }
    });
    fileUploader.on('uploadError', function (file) {
        $('#' + file.id).find('.icon-progress').html('失败');
    });


</script>