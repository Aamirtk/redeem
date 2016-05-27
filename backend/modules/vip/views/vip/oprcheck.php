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
                <form id="vip_form" class="form-horizontal" action="<?= Yii::$app->urlManager->createUrl('vip/vip/ajax-operate-check') ?>" method="post">
                    <!--其他参数-->
                    <input name="mid"  type="hidden" value="<?= $vip['id'] ?>"/>
                    <input name="username"  type="hidden" value="<?= $vip['username'] ?>"/>
                    <input name="check_status"  type="hidden" value="<?= $vip['check_status'] ?>"/>

                    <div class="control-group">
                        <h2 class="offset1">会员审核  --  运营</h2>
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
                        <div class="control-group span7">
                            <label class="control-label">财务：</label>
                            <div class="controls">
                                <span class="control-text" v-role="vip-tel"><?= $vip['checker_name'] ?></span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="control-group">
                        <div class="control-group">
                            <label class="control-label">流水编号：</label>
                            <div class="controls">
                                <span class="control-text" v-role="company-tel"><?= $vip['serial_num'] ?></span></div>
                                <input name="serial_num" value="<?= $vip['serial_num'] ?>" type="hidden"/>
                        </div>
                    </div>
                    <div class="control-group " style="width: 400px; height: 300px;padding: 10px 50px;">
                        <input id="vip_logo_input" name="serial_img" value="<?= $vip['serial_img'] ?>" type="hidden" />
                        <div class="control-group">
                            <label class="control-label"></label>
                            <div class="controls" id="serial_imgzone">
                                <a href="<?= $vip['serial_img'] ?>" target="_blank" title="点击查看原图"><img src="<?= $vip['serial_img'] ?>" style="width: auto; height: 300px;"></a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="control-group">
                        <input type="hidden" name="sub_type" id="sub_type" value="1">
                        <input type="hidden" name="unpassed_reason" id="unpassed_reason" value="">
                        <div class="form-actions span2 offset3">
                            <input type="button"  class="button button-success click_submit" savetype="5" value="审核">
                        </div>
                        <div class="form-actions span2">
                            <input type="button"  class="button button-danger click_submit" savetype="4" value="驳回">
                        </div>
                        <div class="form-actions span2">
                            <button type="reset"  class="button button-primary reset_submit" >取消</button>
                        </div>
                    </div>
                </form>
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
                        window.location.href = '/vip/vip/list-operate';
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
            if(savetype == 4){
                dialog.show();
            }else if(savetype == 5){
                form.submit();
            }
        });

    });
</script>
<script type="text/javascript">

</script>
</body>
</html>
