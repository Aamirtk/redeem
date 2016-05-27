<div id="details_window">
    <form class="form-horizontal" id="details_form">
        <input name="id" v-role="id" type="hidden" value="<?=isset($details["id"])?$details["id"]:''?>" />
        <input name="range_type" v-role="range_type" type="hidden" value="<?=isset($range_type)?$range_type:''?>" />
        <div class="control-group">
            <label class="control-label">范围：</label>
            <div class="bui-form-group controls" data-rules="{numberRange:false}">
                <input name="min_val" class="input-normal control-text"
                       data-rules="{required:true,min:0,maxlength:9}" type="number"
                       v-role="min_val" value="<?=isset($details["min_val"])?$details["min_val"]:''?>" />
                <input name="max_val" class="input-normal control-text"
                       data-rules="{required:true,min:0,maxlength:9}"  type="number"
                       v-role="max_val" value="<?=isset($details["max_val"])?$details["max_val"]:''?>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">分值：</label>
            <div class="controls">
                <input name="point" class="input-normal control-text"
                       data-rules="{required:true,min:0,max:1000}"
                       type="number" v-role="point" value="<?=isset($details["point"])?$details["point"]:''?>" />
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

            params.id = f.find("[v-role=id]").val();
            params.min_val= f.find("[v-role=min_val]").val();
            params.max_val= f.find("[v-role=max_val]").val();
            params.point = f.find("[v-role=point]").val();
            params.range_type = f.find("[v-role=range_type]").val();
            $.ajax({
                type:"post",
                url : "<?= Yii::$app->urlManager->createUrl('trust/range-point/update') ?>",
                data:params,
                dataType:"json",
                success:function(json){
                    if(json.result){
                        BUI.Message.Alert('更新成功','success');
                        refreshTalentGrid();
                        dialog.hide();
                    }
                    else{
                        BUI.Message.Alert('更新失败','error');
                    }
                }
            });
    }
    /**
     * 刷新列表
     */
    function refreshTalentGrid() {
        var store = $("#rules_grid").data("BGrid").get('store');
        var params = {};
        params.pageIndex = 0;//重置第一页(解决翻页搜索为空的问题）
        params.start = 0;//重置第一页(解决翻页搜索为空的问题）
        store.load(params);//刷新
    }
    </script>