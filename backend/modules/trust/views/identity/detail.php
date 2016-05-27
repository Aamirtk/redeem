    <form class="form-horizontal" id="rules_form">
        <input name="id" v-role="id" type="hidden" value="<?=isset($identity["id"])?$identity["id"]:''?>" />
        <div class="control-group">
            <div class="span">   
                <label class="control-label">周期：</label>
                <div class="controls">
                    <select class="input-normal" id="identity_cycle" name="identity_cycle" v-role="identity_cycle">
                        <option value="1" <?=$identity['identity_cycle']==1?'selected':''?>>1个月内</option>
                        <option value="3" <?=$identity['identity_cycle']==3?'selected':''?>>3个月内</option>
                        <option value="6" <?=$identity['identity_cycle']==6?'selected':''?>>6个月内</option>
                        <option value="9" <?=$identity['identity_cycle']==9?'selected':''?>>9个月内</option>
                        <option value="12 <?=$identity['identity_cycle']==12?'selected':''?>">12个月内</option>
                    </select>
                </div>                
            </div>
        </div>
        <div class="control-group">
            <div class="span">  
                <label class="control-label">最多修改次数：</label>
                <div class="controls">
                    
                    <input id="identity_max_modifications" name="identity_max_modifications" class=""  v-role="identity_max_modifications" data-rules="{required:true,maxlength:2,min:0}" type="number" value="<?=$identity['identity_max_modifications']?>">
                </div>
            </div>
        </div>                   
    </form>
<script>
    /**
     * 保存
     */
    function saveDetail(){
        var f = $("#rules_form");
        var params = {};
        params.id = f.find("[v-role=id]").val();
        params.identity_cycle= f.find("[v-role=identity_cycle]").val();
        params.identity_max_modifications= f.find("[v-role=identity_max_modifications]").val();  
        if(params.identity_max_modifications<0)
        {
            BUI.Message.Alert('更新失败，分值不能小于0','error');
            return false;
        }
        $.ajax({
            type:"post",
            url : "<?= Yii::$app->urlManager->createUrl('trust/identity/update') ?>",
            data:params,
            dataType:"json",
            success:function(json){
                if(json.result){
                    BUI.Message.Alert('更新成功','success');                                                
                    dialog.hide();
                }
                else{
                    BUI.Message.Alert('更新失败','error');
                }
            }
        });
    }      
    </script>