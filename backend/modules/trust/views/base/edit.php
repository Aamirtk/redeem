<?php
use yii\helpers\Html;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户信用体系管理--权重分配</title>
    <?= Html::cssFile('@web/assets/css/calendar-min.css') ?>
    <?= Html::cssFile('@web/assets/css/dpl-min.css') ?>
    <?= Html::cssFile('@web/assets/css/bui-min.css') ?>
    <?= Html::cssFile('@web/assets/css/page-min.css') ?>
    <?= Html::jsFile('@web/Js/jquery.js') ?>
    <?= Html::jsFile('@web/assets/js/bui-min.js') ?>
    <?= Html::jsFile('@web/Js/common/common.js?v=1.0.0') ?>
    <?= Html::jsFile('@web/Js/common/daterange.js') ?>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="main">
                <form class="form-horizontal" id="details_form">
                <div class="search-bar form-horizontal well">
                    <div class="row">
                        <div class="span">
                            <div class="control-group">
                            <label class="control-label">分值范围：</label>
                            <div class="bui-form-group controls" data-rules="{numberRange:false}">
                                <input id="base_point_min" name="base_point_min" class="" type="number"  data-rules="{number : true,min:0,max:1000}"value="<?=$base['base_point_min']?>" onblur="caculateInterval(this)"/>~
                                <input id="base_point_max" name="base_point_max" class="" type="number"  data-rules="{number : true,min:0,max:1000}"value="<?=$base['base_point_max']?>" onblur="caculateInterval(this)"/>
                            </div>
                            </div>
                        </div>
                        <div class="span">
                            <label class="control-label">浮动范围：</label>
                            <div class="controls">
                                <label class="control-label"><span id="base_point_interval"><?=$base['base_point_interval']?></span>分</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span">
                            <label class="control-label">&nbsp</label>
                            <div class="controls">
                               <label class="control-label">* 数值范围0~1000</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="search-bar form-horizontal well">
                    <div class="row">
                        <div class="span">
                            <label class="control-label">&nbsp</label>
                            <div class="controls">
                                <label class="control-label">权重</label>
                                <label class="control-label">实际分值</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span">
                            <label class="control-label">身份特征：</label>
                            <div class="controls">
                                <input id="base_identity" name="base_identity" class="" data-rules="{required:true,maxlength:2}" type="number" value="<?=$base['base_identity']?>" onblur="caculateBasePoint()"/>%&nbsp
                                <input id="base_point_identity" disabled name="base_point_identity" class="" type="text" value="<?=$base['base_point_identity']?>"/>分
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span">
                            <label class="control-label">近期履约：</label>
                            <div class="controls">
                                <input id="base_recent_record" name="base_recent_record" class="" data-rules="{required:true,maxlength:2}" type="number" value="<?=$base['base_recent_record']?>" onblur="caculateBasePoint()">%&nbsp
                                <input id="base_point_recent_record" disabled name="base_point_recent_record" class="" type="text" value="<?=$base['base_point_recent_record']?>"/>分

                            </div>
                        </div>
                        </div>
                    <div class="row">
                        <div class="span">
                            <label class="control-label">历史信用：</label>
                            <div class="controls">
                                <input id="base_history_record" name="base_history_record" class="" data-rules="{required:true,maxlength:2}" type="number" value="<?=$base['base_history_record']?>" onblur="caculateBasePoint()"/>%&nbsp
                                <input id="base_point_history_record" disabled name="base_point_history_record" class="" type="text" value="<?=$base['base_point_history_record']?>"/>分

                            </div>
                        </div>
                        </div>
                    <div class="row">
                        <div class="span">
                            <label class="control-label">行为偏好：</label>
                            <div class="controls">
                                <input id="base_behavior" name="base_behavior" class="" data-rules="{required:true,maxlength:2}" type="number" value="<?=$base['base_behavior']?>" onblur="caculateBasePoint()"/>%&nbsp
                                <input id="base_point_behavior" disabled name="base_point_behavior" class="" type="text" value="<?=$base['base_point_behavior']?>"/>分
                            </div>
                        </div>
                        </div>
                    <div class="row">
                        <div class="span">
                            <label class="control-label">社交关系：</label>
                            <div class="controls">
                                <input id="base_social" name="base_social" class="" data-rules="{required:true,maxlength:2}" type="number" value="<?=$base['base_social']?>" onblur="caculateBasePoint()"/>%&nbsp
                                <input id="base_point_social" disabled name="base_point_social" class="" type="text" value="<?=$base['base_point_social']?>"/>分
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="span">
                            <input id="id" name="id" class="" type="hidden" value="<?=$base['id']?>"/>
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            <a class="button button-primary" href="javascript:void(0);" onclick="saveDetail()">保存</a>
                        </div>
                     </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- script start -->
    <script type="text/javascript">
      BUI.use('bui/form',function(Form){

      new Form.Form({
        srcNode : '#details_form'
      }).render();

  });

</script>
    <script>
    /**
     * 保存
     */
    function saveDetail(){
        if(checkPointPecent())
        {
            var f = $("#details_form");
            $.ajax({
                type:"post",
                url : "<?= Yii::$app->urlManager->createUrl('trust/base/update') ?>",
                data:f.serialize(),
                dataType:"json",
                success:function(json){
                    if(json.result){
                        BUI.Message.Alert('保存成功','success');
                        top.topManager.reloadPage();
                    }
                    else{
                        BUI.Message.Alert('保存失败','error');
                    }
                }
            });
        }
    }
    /**
    * 校验权重分配范围

     * @param {type} obj
     * @returns {Boolean}     */
    function checkPointPecent()
    {
        var base_point_min=parseInt($("#base_point_min").val());
        var base_point_max=parseInt($("#base_point_max").val());
        if((base_point_max>1000) ||(base_point_min>1000))
        {
            BUI.Message.Alert('分值不能超过1000！',function() {
          },'error');
          return false;
        }
        if((base_point_max-base_point_min)<0)
        {
            BUI.Message.Alert('最高分值不能小于起始分值！',function() {
          },'error');
          return false;
        }
        var base_identity=parseInt($("#base_identity").val());
        var base_recent_record=parseInt($("#base_recent_record").val());
        var base_history_record=parseInt($("#base_history_record").val());
        var base_behavior=parseInt($("#base_behavior").val());
        var base_social=parseInt($("#base_social").val());
        var total_point=parseInt(base_identity+base_recent_record+base_history_record+base_behavior+base_social);
        if(total_point!=100)
        {
            BUI.Message.Alert('权重百分比之和必须是100%',function() {
          },'error');
          return false;
        }
        return true;
    }
    /**
    * 计算区间范围修改后权重以及对应分值

     * @param {type} obj
     * @returns {undefined}     */
    function caculateInterval()
    {
        var base_point_min=parseInt($("#base_point_min").val());
        var base_point_max=parseInt($("#base_point_max").val());
        var base_point_interval=parseInt(base_point_max-base_point_min);
        $("#base_point_interval").html(base_point_interval);
        var base_identity=parseInt($("#base_identity").val());
        var base_recent_record=parseInt($("#base_recent_record").val());
        var base_history_record=parseInt($("#base_history_record").val());
        var base_behavior=parseInt($("#base_behavior").val());
        var base_social=parseInt($("#base_social").val());
        $("#base_point_identity").val(parseInt(base_point_interval*base_identity/100));
        $("#base_point_recent_record").val(parseInt(base_point_interval*base_recent_record/100));
        $("#base_point_history_record").val(parseInt(base_point_interval*base_history_record/100));
        $("#base_point_behavior").val(parseInt(base_point_interval*base_behavior/100));
        $("#base_point_social").val(parseInt(base_point_interval*base_social/100));
    }
    /**
    * 计算权重对应得分

     * @param {type} obj
     * @returns {undefined}     */
    function caculateBasePoint()
    {
        var base_point_interval=parseInt($("#base_point_interval").html());
        var base_identity=parseInt($("#base_identity").val());
        var base_recent_record=parseInt($("#base_recent_record").val());
        var base_history_record=parseInt($("#base_history_record").val());
        var base_behavior=parseInt($("#base_behavior").val());
        var base_social=parseInt($("#base_social").val());
        $("#base_point_identity").val(parseInt(base_point_interval*base_identity/100));
        $("#base_point_recent_record").val(parseInt(base_point_interval*base_recent_record/100));
        $("#base_point_history_record").val(parseInt(base_point_interval*base_history_record/100));
        $("#base_point_behavior").val(parseInt(base_point_interval*base_behavior/100));
        $("#base_point_social").val(parseInt(base_point_interval*base_social/100));
    }
    </script>
</body>
</html>