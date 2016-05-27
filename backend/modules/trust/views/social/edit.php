<?php
use yii\helpers\Html;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户信用体系管理--社交关系</title>
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
                    <legend>社交关系维度 权重<?=$base['base_social']?>% 分值<?=$base['base_point_social']?>分</legend>
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
                            <label class="control-label">成长等级：</label>
                            <div class="controls">
                                <input id="social_growth_level" name="social_growth_level" class="" data-rules="{required:true,maxlength:2,min:0}" type="number" value="<?=$social['social_growth_level']?>" onblur="caculateBasePoint(this)"/>%&nbsp
                                <input id="social_point_growth_level" disabled name="social_point_growth_level" class="" type="text" value="<?=$social['social_point_growth_level']?>"/>分
                            </div>
                            <label class="control-label"><a  href='/trust/range-point/list-view?range_type=6'>设置规则</a> </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span">
                            <input id="id" name="id" class="" type="hidden" value="<?=$base['id']?>"/>
                            <input id="base_social" name="base_social" class="" type="hidden" value="<?=$base['base_social']?>"/>
                            <input id="base_point_interval" name="base_point_interval" class="" type="hidden" value="<?=$base['base_point_interval']?>"/>
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

  $(function () {
      BUI.use('bui/form',function(Form){
          new Form.Form({
            srcNode : '#details_form'
          }).render();
      });
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
                url : "<?= Yii::$app->urlManager->createUrl('trust/social/update') ?>",
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
    * 校验社会关系成长等级权重分配

     * @param {type} obj
     * @returns {Boolean}     */
    function checkPointPecent()
    {
        var base_social=parseInt($("#base_social").val());
        var social_growth_level=parseInt($("#social_growth_level").val());
        var total_point=parseInt(social_growth_level);
        if(total_point!=base_social)
        {
            BUI.Message.Alert('权重百分比之和必须是'+base_social+'%',function() {
          },'error');
          return false;
        }
        return true;
    }
    /**
    * 计算社会关系成长等级权重对应分值

     * @param {type} obj
     * @returns {undefined}     */
    function caculateBasePoint(obj)
    {
        var base_point_interval=parseInt($("#base_point_interval").val());
        var social_growth_level=parseInt($("#social_growth_level").val());
        $("#social_point_growth_level").val(parseInt(base_point_interval*social_growth_level/100));
    }
    </script>
</body>
</html>