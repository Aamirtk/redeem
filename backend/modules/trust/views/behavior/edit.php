<?php
use yii\helpers\Html;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户信用体系管理-行为偏好</title>
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
                    <legend>行为偏好维度 权重<?=$base['base_behavior']?>% 分值<?=$base['base_point_behavior']?>分</legend>
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
                            <label class="control-label">用户活跃度：</label>
                            <div class="controls">
                                <input id="behavior_activity" name="behavior_activity" class="" data-rules="{required:true,maxlength:2,min:0}" type="number" value="<?=$behavior['behavior_activity']?>" onblur="caculateBasePoint(this)"/>%&nbsp
                                <input id="behavior_point_activity" disabled name="behavior_point_activity" class="" type="text" value="<?=$behavior['behavior_point_activity']?>"/>分
                            </div>
                            <label class="control-label"><a  href='javascript:void(0)' onclick="showDetails(1)">设置规则</a> </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span">
                            <label class="control-label">发标：</label>
                            <div class="controls">
                                <input id="behavior_pub_task" name="behavior_pub_task" class="" data-rules="{required:true,maxlength:2,min:0}" type="number" value="<?=$behavior['behavior_pub_task']?>" onblur="caculateBasePoint(this)">%&nbsp
                                <input id="behavior_point_tender" disabled name="behavior_point_tender" class="" type="text" value="<?=$behavior['behavior_point_tender']?>"/>分
                            </div>
                            <label class="control-label"><a  href='javascript:void(0)' onclick="showDetails(2)">设置规则</a> </label>
                        </div>
                        </div>
                    <div class="row">
                        <div class="span">
                            <label class="control-label">投标：</label>
                            <div class="controls">
                                <input id="behavior_bid" name="behavior_bid" class="" type="number" data-rules="{required:true,maxlength:2,min:0}" value="<?=$behavior['behavior_bid']?>"  onblur="caculateBasePoint(this)"/>%&nbsp
                                <input id="behavior_point_bid" disabled name="behavior_point_bid" class="" type="text" value="<?=$behavior['behavior_point_bid']?>"/>分
                            </div>
                            <label class="control-label"><a  href='javascript:void(0)' onclick="showDetails(3)">设置规则</a> </label>
                        </div>
                        </div>
                    <div class="row">
                        <div class="span">
                            <label class="control-label">保证金托管：</label>
                            <div class="controls">
                                <input id="behavior_deposit" name="behavior_deposit" class="" data-rules="{required:true,maxlength:2,min:0}" type="number" value="<?=$behavior['behavior_deposit']?>"  onblur="caculateBasePoint(this)"/>%&nbsp
                                <input id="behavior_point_deposit" disabled name="behavior_point_deposit" class="" type="text" value="<?=$behavior['behavior_point_deposit']?>"/>分
                            </div>
                            <label class="control-label"><a  href='/trust/range-point/list-view?range_type=5'>设置规则</a> </label>
                        </div>
                        </div>
                    <div class="row">
                        <div class="span">
                            <label class="control-label">周期：</label>
                            <div class="controls">
                                <div id="s_behavior_cycle" >
                                    <input id="behavior_cycle" name="behavior_cycle" class="" type="hidden" value="<?=$behavior['behavior_cycle']?>"/>&nbsp
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span">
                            <input id="id" name="id" class="" type="hidden" value="<?=$behavior['id']?>"/>
                            <input id="base_behavior" name="base_behavior" class="" type="hidden" value="<?=$base['base_behavior']?>"/>
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
      BUI.use('bui/select',function(Select){
        var items = [
              {text:'1个月内',value:'1'},
              {text:'3个月内',value:'3'},
              {text:'6个月内',value:'6'},
              {text:'9个月内',value:'9'},
              {text:'12个月内',value:'12'},
              {text:'24个月内',value:'24'},
            ],
            select = new Select.Select({
              render:'#s_behavior_cycle',
              valueField:'#behavior_cycle',
              items:items
            });
        select.render();
      });
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
                url : "<?= Yii::$app->urlManager->createUrl('trust/behavior/update') ?>",
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
    * 校验行为偏好重分配范围

     * @param {type} obj
     * @returns {Boolean}     */
    function checkPointPecent()
    {
        var base_behavior=parseInt($("#base_behavior").val());
        var behavior_activity=parseInt($("#behavior_activity").val());
        var behavior_pub_task=parseInt($("#behavior_pub_task").val());
        var behavior_bid=parseInt($("#behavior_bid").val());
        var behavior_deposit=parseInt($("#behavior_deposit").val());
        var total_point=parseInt(behavior_activity+behavior_pub_task+behavior_bid+behavior_deposit);
        if(total_point!=base_behavior)
        {
            BUI.Message.Alert('权重百分比之和必须是'+base_behavior+'%',function() {
          },'error');
          return false;
        }
        return true;
    }
    /**
    * 计算行为偏好权重对应分值

     * @param {type} obj
     * @returns {undefined}     */
    function caculateBasePoint(obj)
    {
        var base_point_interval=parseInt($("#base_point_interval").val());
        var behavior_activity=parseInt($("#behavior_activity").val());
        var behavior_pub_task=parseInt($("#behavior_pub_task").val());
        var behavior_bid=parseInt($("#behavior_bid").val());
        var behavior_deposit=parseInt($("#behavior_deposit").val());
        $("#behavior_point_activity").val(parseInt(base_point_interval*behavior_activity/100))
        $("#behavior_point_pub_task").val(parseInt(base_point_interval*behavior_pub_task/100))
        $("#behavior_point_bid").val(parseInt(base_point_interval*behavior_bid/100))
        $("#behavior_point_deposit").val(parseInt(base_point_interval*behavior_deposit/100))
    }
    /**
     * 编辑详情
     */
    function showDetails(type) {
        BUI.use(['bui/overlay','bui/form','bui/mask'],function(Overlay,Form){
            var form,
            title=type==1?'用户活跃度规则':(type==2?'发布规则':'投标规则'),
            dialog = new Overlay.Dialog({
                title:title,
                width:500,
                loader : {
                  url : 'edit?id=<?=$behavior['id']?>'+'&type='+type,
                  autoLoad : true, //不自动加载
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