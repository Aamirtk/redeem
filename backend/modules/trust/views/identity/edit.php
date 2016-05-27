<?php
use yii\helpers\Html;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户信用体系管理--身份特征</title>
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
                    <legend>身份特征维度 权重<?=$base['base_identity']?>% 分值<?=$base['base_point_identity']?>分</legend>
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
                            <label class="control-label">公安实名认证：</label>
                            <div class="controls">
                                <input id="identity_realname" name="identity_realname" class="" data-rules="{required:true,maxlength:2,min:0}" type="number" value="<?=$identity['identity_realname']?>" onblur="caculateBasePoint(this)"/>%&nbsp
                                <input id="identity_point_realname" disabled name="identity_point_realname" class="" type="text" value="<?=$identity['identity_point_realname']?>"/>分
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span">
                            <label class="control-label">工商企业认证：</label>
                            <div class="controls">
                                <input id="identity_enterprise" name="identity_enterprise" class="" data-rules="{required:true,maxlength:2,min:0}" type="number" value="<?=$identity['identity_enterprise']?>" onblur="caculateBasePoint(this)">%&nbsp
                                <input id="identity_point_enterprise" disabled name="identity_point_enterprise" class="" type="text" value="<?=$identity['identity_point_enterprise']?>"/>分

                            </div>
                        </div>
                        </div>
                    <div class="row">
                        <div class="span">
                            <label class="control-label">身份基本信息：</label>
                            <div class="controls">
                                <input id="identity_baseinfo" name="identity_baseinfo" class="" data-rules="{required:true,maxlength:2,min:0}" type="number" value="<?=$identity['identity_baseinfo']?>" onblur="caculateBasePoint(this)"/>%&nbsp
                                <input id="identity_point_baseinfo" disabled name="identity_point_baseinfo" class="" type="text" value="<?=$identity['identity_point_baseinfo']?>"/>分

                            </div>
                        </div>
                        </div>
                    <div class="row">
                        <div class="span">
                            <label class="control-label">信息稳定性：</label>
                            <div class="controls">
                                <input id="identity_stability" name="identity_stability" class="" data-rules="{required:true,maxlength:2,min:0}" type="number" value="<?=$identity['identity_stability']?>" onblur="caculateBasePoint(this)"/>%&nbsp
                                <input id="identity_point_stability" disabled name="identity_point_stability" class="" type="text" value="<?=$identity['identity_point_stability']?>"/>分
                            </div>
                            <label class="control-label"><a  href='javascript:void(0)' onclick="showDetails()">设置规则</a> </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span">
                            <input id="id" name="id" class="" type="hidden" value="<?=$base['id']?>"/>
                            <input id="base_identity" name="base_identity" class="" type="hidden" value="<?=$base['base_identity']?>"/>
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
                url : "<?= Yii::$app->urlManager->createUrl('trust/identity/update') ?>",
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
    * 校验身份特征权重分配范围

     * @param {type} obj
     * @returns {Boolean}     */
    function checkPointPecent()
    {
        var base_identity=parseInt($("#base_identity").val());
        var identity_realname=parseInt($("#identity_realname").val());
        var identity_enterprise=parseInt($("#identity_enterprise").val());
        var identity_baseinfo=parseInt($("#identity_baseinfo").val());
        var identity_stability=parseInt($("#identity_stability").val());
        var total_point=parseInt(identity_realname+identity_enterprise+identity_baseinfo+identity_stability);
        if(total_point!=base_identity)
        {
            BUI.Message.Alert('权重百分比之和必须是'+base_identity+'%',function() {
          },'error');
          return false;
        }
        return true;
    }
    /**
    * 计算身份特征权重对应分值

     * @param {type} obj
     * @returns {undefined}     */
    function caculateBasePoint(obj)
    {
        var base_point_interval=parseInt($("#base_point_interval").val());
        var identity_realname=parseInt($("#identity_realname").val());
        var identity_enterprise=parseInt($("#identity_enterprise").val());
        var identity_baseinfo=parseInt($("#identity_baseinfo").val());
        var identity_stability=parseInt($("#identity_stability").val());
        $("#identity_point_realname").val(parseInt(base_point_interval*identity_realname/100))
        $("#identity_point_enterprise").val(parseInt(base_point_interval*identity_enterprise/100))
        $("#identity_point_baseinfo").val(parseInt(base_point_interval*identity_baseinfo/100))
        $("#identity_point_stability").val(parseInt(base_point_interval*identity_stability/100))
    }
    /**
     * 编辑详情
     */
    function showDetails() {
        BUI.use(['bui/overlay','bui/form','bui/mask'],function(Overlay,Form){
            var form,
            dialog = new Overlay.Dialog({
                title:'信息稳定性',
                width:500,
                loader : {
                  url : 'edit?id=<?=$identity['id']?>',
                  autoLoad : true, //自动加载
                  lazyLoad : false,
                  callback : function(){
                    var node = dialog.get('el').find('form');//查找内部的表单元素
                    form = new Form.HForm({
                      srcNode : node,
                      autoRender : true
                    });
                  }
                },
                mask:true,
                success : function(){
                  //可以直接action 提交
                  saveDetail();
                  form && form.destroy();
                  this.close(); //也可以form.ajaxSubmit(params);
                }
              });
          dialog.show();
        });
    }
    </script>
</body>
</html>