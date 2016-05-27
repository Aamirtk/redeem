<!-- 编辑窗口-->
<div id="level_details_window" style="display: none;">
    <form id="level_details_form" class="form-horizontal" >
        <div class="control-group">
            <label class="control-label">编号：</label>
            <div class="controls">
                <span class="control-text" v-role="level_level_id"></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">等级：</label>
            <div class="controls">
                <span class="control-text" v-role="level_level"></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">升等所需值：</label>
            <div class="controls">
                <input name="distribute" class="control-text"  v-role="level_requirement" data-rules="{required:true}" type="text"/>
            </div>
        </div>
        <div class="row">
            <div class="offset5" style="margin-top: 5px;">
                <div class="button button-primary" onclick="saveLevelInfo()">保存</div>
            </div>
        </div>
    </form>
</div>
<!-- //编辑窗口-->
<script>
    $(function(){
        BUI.use('bui/overlay', function (Overlay) {
            var talentDetailsWindow = new Overlay.Dialog({
                title: '等级修改',
                width: 500,
                mask: true,//模态
                buttons: [],
                contentId: "level_details_window"
            });
            $("#level_details_window").data("BDialog", talentDetailsWindow);
        });
        BUI.use('bui/form',function(Form){
            var f = new Form.Form({
                srcNode : '#level_details_form'
            });
            f.render();
            $("#level_details_form").data("BForm", f);
        });
    });


    /**
     * 等级详情
     */
    function showLevelDetails(level_id) {
        $("body").data('BMask').show();
        initChannelDetails(level_id, function () {
            $("body").data('BMask').hide();
            $("#level_details_window").data("BDialog").show();
        });
    }

    //填充数据
    function initChannelDetails(level_id, fn){
        var f = $("#level_details_form");
        f.data('BForm').clearErrors();
        $.ajax({
            type:"get",
            url : "<?= Yii::$app->urlManager->createUrl('point/level/details') ?>" + '/' + level_id,
            dataType:"json",
            success:function(json){
                if(json.result){
                    f.find("[v-role=level_level_id]").text(json.level_id);
                    f.find("[v-role=level_level]").text(json.level);
                    f.find("[v-role=level_requirement]").val(json.requirement);
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
    function saveLevelInfo(){
        var f = $("#level_details_form");
        var params = {};
        if(f.data("BForm").isValid()){
            params.level_id= f.find("[v-role=level_level_id]").text();
            params.level = f.find("[v-role=level_level]").text();
            params.requirement = f.find("[v-role=level_requirement]").val();

            $.ajax({
                type:"post",
                url : "<?= Yii::$app->urlManager->createUrl('point/level/update') ?>",
                data:params,
                dataType:"json",
                success:function(json){
                    if(json.result){
                        BUI.Message.Alert('更新成功','success');
                        top.topManager.reloadPage();
                    }
                    else{
                        BUI.Message.Alert('保存失败','error');
                    }
                }
            });
        }
    }
</script>