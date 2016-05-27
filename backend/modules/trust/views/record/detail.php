    <form class="form-horizontal" id="rules_form">
        <input name="id" v-role="id" type="hidden" value="<?=isset($record["id"])?$record["id"]:''?>" />
        <input name="record_type" v-role="record_type" type="hidden" value="<?=$record['record_type']?>" />
        <div class="control-group">
            <div class="span">                
                <div class="controls">
                    <label class="control-label-auto">甲方被评价付款速度占比：</label>
                    <input id="pay_speed" name="pay_speed" class="" v-role="pay_speed" data-rules="{required:true,maxlength:2,min:0}" type="number" value="<?=$record['pay_speed']?>"/>%
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="span">                
                <div class="controls">
                    <label class="control-label-auto">甲方被评价合作愉快占比：</label>
                    <input id="work_happy" name="work_happy" class=""  v-role="work_happy" data-rules="{required:true,maxlength:2,min:0}" type="number" value="<?=$record['work_happy']?>">%
                </div>
            </div>
            </div>
        <div class="control-group">
            <div class="span">                
                <div class="controls">
                    <label class="control-label-auto">乙方被评价完成质量占比：</label>
                    <input id="quality" name="quality" class=""  v-role="quality" data-rules="{required:true,maxlength:2,min:0}"type="number" value="<?=$record['quality']?>"/>%
                </div>
            </div>
            </div>
        <div class="control-group">
            <div class="span">                
                <div class="controls">
                    <label class="control-label-auto">乙方被评价工作时间占比：</label>
                    <input id="efficiency" name="efficiency" class=""  v-role="efficiency" data-rules="{required:true,maxlength:2,min:0}" type="number" value="<?=$record['efficiency']?>"/>%
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="span">                
                <div class="controls">
                    <label class="control-label-auto">乙方被评价服务态度占比：</label>
                    <input id="attitude" name="attitude" class=""  v-role="attitude" data-rules="{required:true,maxlength:2,min:0}" type="number" value="<?=$record['attitude']?>"/>%
                </div>
            </div>
        </div>                    
    </form>
<script>
    /**
     * 保存
     */
    function saveMerit(){
        var f = $("#rules_form");
        var params = {};
        params.id = parseInt(f.find("[v-role=id]").val());
        params.pay_speed= parseInt(f.find("[v-role=pay_speed]").val());
        params.work_happy= parseInt(f.find("[v-role=work_happy]").val());
        params.quality = parseInt(f.find("[v-role=quality]").val());
        params.efficiency = parseInt(f.find("[v-role=efficiency]").val());
        params.attitude = parseInt(f.find("[v-role=attitude]").val()); 
        var total_A_point;
        var total_B_point;
        var msg='';

        msg='甲方占比配置';
        total_A_point=parseInt(params.pay_speed+params.work_happy);
        if(total_A_point!=100)
        {
            BUI.Message.Alert(msg+'不等于100%',function() {
          },'error');
          return false;
        }

        msg='乙方占比配置';
        total_B_point=parseInt(params.quality+params.efficiency+params.attitude);
        if(total_B_point!=100)
        {
            BUI.Message.Alert(msg+'不等于100%',function() {
          },'error');
          return false;
        }        

        $.ajax({
            type:"post",
            url : "<?= Yii::$app->urlManager->createUrl('trust/record/update') ?>",
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
        return true;
    }    
    /**
    * 校验综合评分规则占比分配

     * @param {type} obj
     * @param {type} type
     * @returns {Boolean}     */
    function checkPecent()
    {
        var pay_speed=parseInt($("#pay_speed").val());
        var work_happy=parseInt($("#work_happy").val());
        var quality=parseInt($("#quality").val());
        var efficiency=parseInt($("#efficiency").val());
        var attitude=parseInt($("#attitude").val());
        var total_A_point;
        var total_B_point;
        var msg='';

        msg='甲方占比配置';
        total_A_point=parseInt(pay_speed+work_happy);
        if(total_A_point!==100)
        {
            BUI.Message.Alert(msg+'不等于100%',function() {
          },'error');
          return false;
        }

        msg='乙方占比配置';
        total_B_point=parseInt(quality+efficiency+attitude);
        if(total_B_point!==100)
        {
            BUI.Message.Alert(msg+'不等于100%',function() {
          },'error');
          return false;
        }
        return true;
    }    
    </script>