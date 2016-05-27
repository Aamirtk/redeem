<!-- 编辑窗口-->
<div id="channel_activate_window" style="display: none;">
    <form id="channel_activate_form" class="form-horizontal" >
        <input name="available"  v-role="channel_available" value="1"  type="hidden"/>
        <div class="control-group">
            <label class="control-label">频道名称：</label>
            <div class="controls">
                <div id="activate_channels" >
                    <input type="hidden" id="hide_activate_channels" value="" name="hide_activate_channels">
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">平台配比率：</label>
            <div class="controls">
                <input name="distribute" class="control-text"  v-role="channel_distribute" data-rules="{required:true}" type="text"/>
            </div>
        </div>
        <p>             说明：频道是预先定义好的，只可以激活和删除操作。</p>
        <div class="row">
            <div class="offset5" style="margin-top: 5px;">
                <div class="button button-primary" onclick="activateChannelInfo()">保存</div>
            </div>
        </div>
    </form>
</div>
<!-- //编辑窗口-->
<script>

    $(function(){
        BUI.use('bui/overlay', function (Overlay) {
            var activateChannelWindow = new Overlay.Dialog({
                title: '激活频道',
                width: 500,
                mask: true,//模态
                buttons: [],
                contentId: "channel_activate_window"
            });
            $("#channel_activate_window").data("BDialog", activateChannelWindow);
        });
        BUI.use('bui/form',function(Form){
            var f = new Form.Form({
                srcNode : '#channel_activate_form'
            });
            f.render();
            $("#channel_activate_form").data("BForm", f);
        });
    });


    /**
     * 激活频道
     */
    function activateChannel() {
        $("body").data('BMask').show();
        initActivateChannels(function () {
            $("body").data('BMask').hide();
            $("#channel_activate_window").data("BDialog").show();
        });
    }

    //填充数据
    function initActivateChannels(fn){
        var f = $("#channel_activate_form");
        f.data('BForm').clearErrors();
        $.ajax({
            type:"get",
            url : "<?= Yii::$app->urlManager->createUrl('point/channel/activate') ?>",
            dataType:"json",
            success:function(json){
                if(json){
                    var items =json;
                    BUI.use(["bui/select"], function (Select) {
                        select = new Select.Select({
                            render: "#activate_channels",
                            valueField: "#hide_activate_channels",
                            multipleSelect: false,
                            items: items
                        });
                    });
                    $("#activate_channels .bui-select").remove();
                    select.render();

                    if($.isFunction(fn)){
                        fn();
                    }
                }
            }
        });
    }

    /**
     * 激活频道
     */
    function activateChannelInfo(){
        var f = $("#channel_activate_form");
        var params = {};
        if(f.data("BForm").isValid()){
            params.chid= $("#hide_activate_channels").val();
            params.available = 1;
            params.distribute = f.find("[v-role=channel_distribute]").val();
            $.ajax({
                type:"post",
                url : "<?= Yii::$app->urlManager->createUrl('point/channel/update') ?>",
                data:params,
                dataType:"json",
                success:function(json){
                    if(json.result){
                        BUI.Message.Alert('激活成功','success');
                        top.topManager.reloadPage();//刷新页面
                    }
                    else{
                        BUI.Message.Alert('激活失败','error');
                    }
                }
            });
        }
    }
</script>