
    <form class="form-horizontal" id="rules_form">
        <input name="id" v-role="id" type="hidden" value="<?=isset($behavior["id"])?$behavior["id"]:''?>" />
        <input name="type" v-role="type" type="hidden" value="<?=$type?>" />
        <div style="display:<?=$type=='1'?'':'none'?>">
            <div class="control-group">
                <label class="control-label">最低在线次数：</label>
                <div class="controls">
                    <input id="behavior_min_online"  name="behavior_min_online" v-role="behavior_min_online" class="" data-rules="{required:true,min:0}" type="number" value="<?=$behavior['behavior_min_online']?>"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">得分比例：</label>
                <div class="controls">
                    <input id="behavior_activity_percent"  name="behavior_activity_percent"v-role="behavior_activity_percent"  class="" data-rules="{required:true,maxlength:2,min:0}" type="number" value="<?=$behavior['behavior_activity_percent']?>"/>%
                </div>
            </div>
        </div>
        <div style="display:<?=$type=='2'?'':'none'?>">
            <div class="control-group">
                <label class="control-label">最低发布次数：</label>
                <div class="controls">
                    <input id="behavior_min_tender"  name="behavior_min_tender" class=""v-role="behavior_min_tender"  data-rules="{required:true,min:0}" type="number" value="<?=$behavior['behavior_min_tender']?>"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">得分比例：</label>
                <div class="controls">
                    <input id="behavior_tender_percent"  name="behavior_tender_percent"v-role="behavior_tender_percent"  class="" data-rules="{required:true,maxlength:2,min:0}" type="number" value="<?=$behavior['behavior_tender_percent']?>"/>%
                </div>
            </div>
        </div>
        <div style="display:<?=$type=='3'?'':'none'?>">
            <div class="control-group">
                <label class="control-label">最低投标次数：</label>
                <div class="controls">
                    <input id="behavior_min_bid"  name="behavior_min_bid" class="" v-role="behavior_min_bid"  data-rules="{required:true,min:0}" type="number" value="<?=$behavior['behavior_min_bid']?>"/>
                </div>
            </div>    
            <div class="control-group">
                <label class="control-label">得分比例：</label>
                <div class="controls">
                    <input id="behavior_bid_percent"  name="behavior_bid_percent" v-role="behavior_bid_percent" class="" data-rules="{required:true,maxlength:2,min:0}" type="number" value="<?=$behavior['behavior_bid_percent']?>"/>%
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
        params.behavior_min_online= f.find("[v-role=behavior_min_online]").val();
        params.behavior_activity_percent= f.find("[v-role=behavior_activity_percent]").val();
        params.behavior_min_tender = f.find("[v-role=behavior_min_tender]").val();
        params.behavior_tender_percent = f.find("[v-role=behavior_tender_percent]").val();
        params.behavior_min_bid = f.find("[v-role=behavior_min_bid]").val();
        params.behavior_bid_percent = f.find("[v-role=behavior_bid_percent]").val();        
        $.ajax({
            type:"post",
            url : "<?= Yii::$app->urlManager->createUrl('trust/behavior/update') ?>",
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