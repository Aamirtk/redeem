<?php
error_reporting(E_ERROR);
use yii\helpers\Html;

?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>财务审核</title>
    <?= Html::cssFile('@web/css/bs3_dpl.css') ?>
    <?= Html::cssFile('@web/css/bui-min.css') ?>
    <?= Html::cssFile('@web/css/page-min.css') ?>
    <?= Html::jsFile('@web/Js/jquery.js') ?>
    <?= Html::jsFile('@web/Js/bui-min.js') ?>
    <?= Html::jsFile('@web/Js/vip.js') ?>
    <script>

    </script>
    <style>
        /**内容超出 出现滚动条 **/
        .bui-stdmod-body{
            overflow-x : hidden;
            overflow-y : auto;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="well">
            <!--  新增--基本信息  -->
            <div id="vip_content" style="display:block;">
                <form id="vip_form" class="form-horizontal" action="<?= Yii::$app->urlManager->createUrl('vip/vip/ajax-finance-check') ?>" method="post">
                    <!--其他参数-->
                    <input name="mid"  type="hidden" value="<?= $vip['id'] ?>"/>
                    <input name="username"  type="hidden" value="<?= $vip['username'] ?>"/>
                    <input name="check_status"  type="hidden" value="<?= $vip['check_status'] ?>"/>

                    <div class="control-group">
                        <h2 class="offset1">会员审核  --  财务</h2>
                    </div>
                    <div class="control-group">
                        <div class="control-group span7">
                            <label class="control-label">会员名称：</label>
                            <div class="controls">
                                <span class="control-text" v-role="vip-tel"><?= $vip['name'] ?></span>
                            </div>
                        </div>
                        <div class="control-group span7">
                            <label class="control-label">ID：</label>
                            <div class="controls">
                                <span class="control-text" v-role="vip-tel"><?= $vip['username'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-group span7">
                            <label class="control-label">录入时间：</label>
                            <div class="controls">
                                <span class="control-text" v-role="vip-tel"><?= $vip['input_time'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-group span7">
                            <label class="control-label">启用时间：</label>
                            <div class="controls">
                                <span class="control-text" v-role="vip-tel"><?= $vip['valid_begin'] ?></span>
                            </div>
                        </div>
                        <div class="control-group span7">
                            <label class="control-label">结束时间：</label>
                            <div class="controls">
                                <span class="control-text" v-role="vip-tel"><?= $vip['valid_end'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-group span7">
                            <label class="control-label">销售：</label>
                            <div class="controls">
                                <span class="control-text" v-role="vip-tel"><?= $vip['inputer_name'] ?></span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="control-group">
                        <div class="control-group">
                            <label class="control-label">流水编号截图：</label>
                            <div class="controls">
                                <a href="javaScript:void(0)" id="vip_logo_upload" onclick="uploadAvatar()">【上传/更改】图片</a>
                                <input id="vip_logo_input" name="serial_img" value="<?= $vip['serial_img'] ?>" type="hidden" />
                            </div>
                        </div>
                    </div>
                    <div class="control-group " style="width: 400px; height: 300px;padding: 10px 50px;">
                        <div class="control-group">
                            <label class="control-label"></label>
                            <div class="controls" id="serial_imgzone">
                                <a href="<?= $vip['serial_img'] ?>" target="_blank" title="点击查看原图"><img src="<?= $vip['serial_img'] ?>" style="width: auto; height: 300px;"></a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="control-group">
                        <div class="control-group">
                            <label class="control-label"><s>*</s>流水编号：</label>
                            <div class="controls">
                                <input name="serial_num" class="input-normal control-text" v-role="serial_num" placeholder="请输入流水编号"
                                       data-rules="{required:true}" data-messages="{required:'流水编号不能为空'}" value="<?= $vip['serial_num'] ?>" type="text"/>
                            </div>
                        </div>

                    </div>
                    <div class="control-group">
                        <input type="hidden" name="sub_type" id="sub_type" value="1">
                        <input type="hidden" name="unpassed_reason" id="unpassed_reason" value="">
                        <div class="form-actions span2 offset3">
                            <input type="button"  class="button button-success click_submit" savetype="3" value="审核">
                        </div>
                        <div class="form-actions span2">
                            <input type="button"  class="button button-danger click_submit" savetype="2" value="驳回">
                        </div>
                        <div class="form-actions span2">
                            <button type="reset"  class="button button-primary reset_submit" >取消</button>
                        </div>
                    </div>
                </form>
            </div>

            <!--流水编号-->
            <div class="avatar-body" id="vip_logo_div" style="display: none">
                <div class="avatar-body" id="company_logo_div" style="display: none">
                    <?php $logo = "/Images/nopic.jpg" ?>
                    <iframe src="" id="company_logo_if_h" name="company_logo_if_h" style="display: none" width="100px" height="100px"></iframe>
                    <form id="company_logo_f" class="avatar-form" action="http://api.vsochina.com/file/index/upload" enctype="multipart/form-data" method="post" target="company_logo_if_h" style="text-align: center">
                        <div id="avatar-input-logo-img" style="display: inline-block"><a href="<?= $vip['serial_img'] ?>" target="_blank"><img class="" src="<?= $vip['serial_img'] ?>" alt="" style="width: auto;height: 100px; margin: 15px;"></a></div>
                        <div class="upload-enterprise-banner logo_div" style="display: inline-block">
                            <input type="hidden" name="appid" value="vsomaker">
                            <input type="hidden" name="token" value="vsomaker">
                            <input type="hidden" name="callback"
                                   value="<?= Yii::$app->params['backend_url'] ?>/vip/vip/add-serial-img?action=setfileurlfromcallbacklogo">
                            <input type="file" name="attachment" class="avatar-input-banner" value="" style="width: 100%;" >
                            <input type="hidden" name="username" value="rc">
                            <input type="hidden" name="objtype" value="rc">
                        </div>
                        <p class="color-orange">* 20MB以内，RBG模式， 支持尺寸：1920x455，  支持格式：JPG/GIF/PNG</p>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <div id="reason_content" style="display: none">
        <form id="reason_form" class="horizontal" >
            <div class="row">
                <div class="control-group span15">
                    <label class="control-label">请输入驳回的原因：</label>
                    <div class="controls control-row4">
                        <textarea data-tip="" id="reason_textarea" data-rules="{required:true}" name="reason_textarea"
                                  class="input-large" type="text"><?= $vip['unpassed_reason'] ?></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>


</div>
<script>
BUI.use(['bui/overlay','bui/form'],function(Overlay,Form){

    var rform = new Form.HForm({
        srcNode : '#reason_form'
    }).render();

    var form = new Form.HForm({
        srcNode : '#vip_form',
        submitType : 'ajax',
        callback : function(data){
            var form = this;
            if(!data.result && data.errorMessage.errors){
                var errors = data.errorMessage.errors;
                BUI.each(errors,function(v, k){
                    var field = form.getField(k);
                    if(field){
                        field.showErrors(v);
                    }
                });
            }else{
                BUI.Message.Alert('保存成功', function () {
                    window.location.href = '/vip/vip/list-finance';
                }, 'success');
            }
        }
    }).render();

    var dialog = new Overlay.Dialog({
        title:'请输入审核驳回的原因',
        width:600,
        height:400,
        contentId:'reason_content',
        success: function () {
            var reason = $.trim($("#reason_textarea").val());
            if(reason == ''){
                BUI.Message.Alert('原因不能为空', 'error');
                return false;
            }
            $("#unpassed_reason").val(reason);
            form.submit();
            this.close();
        },
        fail: function () {
            this.close();
        }
    });

    $(".reset_submit").click(function(){
        window.location.href = '/vip/vip/list-finance';
    });
    $(".click_submit").click(function(){
        var savetype = parseInt($(this).attr("savetype"));
        $("#sub_type").val(savetype);
        if(savetype == 2){
            dialog.show();
        }else if(savetype == 3){
            form.submit();
        }
    });

});
</script>
<script type="text/javascript">
/**
 * 上传流水编号截图
 * **/
function uploadAvatar() {
    BUI.use(['bui/overlay', 'bui/form'], function (Overlay, Form) {
        var dialog = new Overlay.Dialog({
            title: '上传流水编号截图',
            width: 320,
            height: 280,
            closeAction: 'destroy',
            //配置DOM容器的编号
            contentId: 'company_logo_div',
            buttons: [
                {
                    text: '确定',
                    elCls: 'button button-success',
                    handler: function () {
                        this.close();
                    }
                },
                {
                    text: '取消',
                    elCls: 'button button-danger',
                    handler: function () {
                        var src = '<?= $vip['serial_img'] ?>';
                        setfileurlfromcallbacklogo(src);
                        this.close();
                    }
                }
            ],
            mask: true
        });

        dialog.show();
    });


}

//保存文件url
function setfileurlfromcallbacklogo(fileurl) {
    $("#avatar-input-logo-img").find("img").attr("src", fileurl);
    $("#avatar-input-logo-img").find("a").attr("href", fileurl);
    $("#serial_imgzone").find("img").attr("src", fileurl);
    $("#serial_imgzone").find("a").attr("href", fileurl);
    $("input[name=serial_img]").val(fileurl);

}

$(function(){
    $("#company_logo_f input[name='attachment']").change(function(){
        $("#company_logo_f").submit();
    });
});
</script>
</body>
</html>
