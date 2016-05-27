<div id="details_window">
    <form class="form-horizontal" id="details_form">
        <input name="rid" v-role="rid" type="hidden" value="<?=$details["rid"]?>" />
        <div class="control-group">
            <label class="control-label">行为名称：</label>
            <div class="controls">
                <input name="rulealias" class="input-normal control-text" data-rules="{required:true,maxlength:20}" type="text" v-role="rulealias" value="<?=$details["rulealias"]?>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">频道名称：</label>
            <div class="controls">
                <input name="channelname" disabled class="input-normal control-text" type="text" v-role="channelname" value="<?=$details["channelname"]?>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">分值：</label>
            <div class="controls">
                <input name="point" class="input-normal control-text" data-rules="{required:true,min:0,number:true}" type="text" v-role="point" value="<?=$details["point"]?>" />
            </div>
        </div>
        <div class="row">
            <div class="offset5" style="margin-top: 10px;">
                <div class="button button-primary" onclick="saveDetail()">保存</div>
            </div>
        </div>
    </form>
</div>
<script>
    /**
     * 保存
     */
    function saveDetail(){
        var f = $("#details_form");
        var params = {};

            params.rid = f.find("[v-role=rid]").val();
            params.rulealias= f.find("[v-role=rulealias]").val();
            params.point = f.find("[v-role=point]").val();
            $.ajax({
                type:"post",
                url : "<?= Yii::$app->urlManager->createUrl('point/allocation/update') ?>",
                data:params,
                dataType:"json",
                success:function(json){
                    if(json.result){
                        BUI.Message.Alert('更新成功','success');
                        top.topManager.reloadPage();
                    }
                    else{
                        BUI.Message.Alert('更新失败','error');
                    }
                }
            });
    }    
    </script>