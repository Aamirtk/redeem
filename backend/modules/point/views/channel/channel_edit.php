<!-- 编辑窗口-->
<div id="channel_details_window" style="display: none;">
    <form id="channel_details_form" class="form-horizontal" >
        <div class="control-group">
            <label class="control-label">编号：</label>
            <div class="controls">
                <span class="control-text" v-role="channel_chid"></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">频道名称：</label>
            <div class="controls">
                <input name="channelname" class="control-text"  v-role="channel_channelname" data-rules="{required:true}" type="text"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">平台配比率：</label>
            <div class="controls">
                <input name="distribute" class="control-text"  v-role="channel_distribute" data-rules="{required:true}" type="text"/>
            </div>
        </div>
        <div class="row">
            <div class="offset5" style="margin-top: 5px;">
                <div class="button button-primary" onclick="saveChannelInfo()">保存</div>
            </div>
        </div>
    </form>
</div>
<!-- //编辑窗口-->
<script>
    $(function(){
        BUI.use('bui/overlay', function (Overlay) {
            var talentDetailsWindow = new Overlay.Dialog({
                title: '频道修改',
                width: 500,
                mask: true,//模态
                buttons: [],
                contentId: "channel_details_window"
            });
            $("#channel_details_window").data("BDialog", talentDetailsWindow);
        });
        BUI.use('bui/form',function(Form){
            var f = new Form.Form({
                srcNode : '#channel_details_form'
            });
            f.render();
            $("#channel_details_form").data("BForm", f);
        });
    });


    /**
     * 频道详情
     */
    function showChannelDetails(chid) {
        $("body").data('BMask').show();
        initChannelDetails(chid, function () {
            $("body").data('BMask').hide();
            $("#channel_details_window").data("BDialog").show();
        });
    }

    //填充数据
    function initChannelDetails(chid, fn){
        var f = $("#channel_details_form");
        f.data('BForm').clearErrors();
        $.ajax({
            type:"get",
            url : "<?= Yii::$app->urlManager->createUrl('point/channel/details') ?>" + '/' + chid,
            dataType:"json",
            success:function(json){
                if(json.result){
                    f.find("[v-role=channel_chid]").text(json.chid);
                    f.find("[v-role=channel_channelname]").val(json.channelname);
                    f.find("[v-role=channel_distribute]").val(json.distribute);
                    if($.isFunction(fn)){
                        fn();
                    }
                }
            }
        });
    }

    /**
     * 保存编辑
     */
    function saveChannelInfo(){
        var f = $("#channel_details_form");
        var params = {};
        if(f.data("BForm").isValid()){
            params.chid= f.find("[v-role=channel_chid]").text();
            params.channelname = f.find("[v-role=channel_channelname]").val();
            params.distribute = f.find("[v-role=channel_distribute]").val();

            $.ajax({
                type:"post",
                url : "<?= Yii::$app->urlManager->createUrl('point/channel/update') ?>",
                data:params,
                dataType:"json",
                success:function(json){
                    if(json.result){
                        BUI.Message.Alert('更新成功','success');
                        top.topManager.reloadPage();//刷新页面
                    }
                    else{
                        BUI.Message.Alert('保存失败','error');
                    }
                }
            });
        }
    }
</script>