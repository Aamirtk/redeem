<?php
use yii\helpers\Html;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户信用体系管理</title>
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
                    <legend><?=$record['record_type']==1?'近期履约':'历史信用'?>维度
                        权重<?=$record['record_type']==1?$base['base_recent_record']:$base['base_history_record']?>%
                        分值<?=$record['record_type']==1?$base['base_point_recent_record']:$base['base_point_history_record']?>分</legend>
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
                            <label class="control-label">完成任务的累计金额：</label>
                            <div class="controls">
                                <input id="record_amount" name="record_amount" class="" data-rules="{required:true,maxlength:2,min:0}" type="number" value="<?=$record['record_amount']?>" onblur="caculateBasePoint(this)"/>%&nbsp
                                <input id="record_point_amount" disabled name="record_point_amount" class="" type="text" value="<?=$record['record_point_amount']?>"/>分
                            </div>
                            <label class="control-label"><a  href='/trust/range-point/list-view?range_type=<?=$record['record_type']==1?'1':'3'?>'>设置规则</a> </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span">
                            <label class="control-label">完成任务的累计次数：</label>
                            <div class="controls">
                                <input id="record_count" name="record_count" class=""  data-rules="{required:true,maxlength:2,min:0}"type="number" value="<?=$record['record_count']?>" onblur="caculateBasePoint(this)">%&nbsp
                                <input id="record_point_count" disabled name="record_point_count" class="" type="text" value="<?=$record['record_point_count']?>"/>分
                            </div>
                            <label class="control-label"><a  href='/trust/range-point/list-view?range_type=<?=$record['record_type']==1?'2':'4'?>'>设置规则</a> </label>
                        </div>
                        </div>
                    <div class="row">
                        <div class="span">
                            <label class="control-label">完成任务的综合评分：</label>
                            <div class="controls">
                                <input id="record_overall_merit" name="record_overall_merit" class=""  data-rules="{required:true,maxlength:2,min:0}"type="number" value="<?=$record['record_overall_merit']?>" onblur="caculateBasePoint(this)"/>%&nbsp
                                <input id="record_point_overall_merit" disabled name="record_point_overall_merit" class="" type="text" value="<?=$record['record_point_overall_merit']?>"/>分
                            </div>
                            <label class="control-label"><a  href='javascript:void(0)' onclick="showMerit()">设置规则</a> </label>
                        </div>
                        </div>
                    <div class="row">
                        <div class="span">
                            <label class="control-label">周期：</label>
                            <div class="controls">
                                <div id="s_record_cycle" >
                                    <input id="record_cycle" name="record_cycle" class="" type="hidden" value="<?=$record['record_cycle']?>"/>&nbsp
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span">
                            <input id="id" name="id" class="" type="hidden" value="<?=$record['id']?>"/>
                            <input id="base_record" name="base_record" class="" type="hidden" value="<?=$record['record_type']==1?$base['base_recent_record']:$base['base_history_record']?>"/>
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
              render:'#s_record_cycle',
              valueField:'#record_cycle',
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
                url : "<?= Yii::$app->urlManager->createUrl('trust/record/update') ?>",
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
    * 校验近期/历史履约权重范围分配

     * @param {type} obj
     * @returns {Boolean}     */
    function checkPointPecent()
    {
        var base_record=parseInt($("#base_record").val());
        var record_amount=parseInt($("#record_amount").val());
        var record_count=parseInt($("#record_count").val());
        var record_overall_merit=parseInt($("#record_overall_merit").val());
        var total_point=parseInt(record_amount+record_count+record_overall_merit);
        if(total_point!=base_record)
        {
            BUI.Message.Alert('权重百分比之和必须是'+base_record+'%',function() {
          },'error');
          return false;
        }
        return true;
    }
    /**
    * 计算近期/历史履约权重对应分值

     * @param {type} obj
     * @returns {undefined}     */
    function caculateBasePoint()
    {
        var base_point_interval=parseInt($("#base_point_interval").val());
        var record_amount=parseInt($("#record_amount").val());
        var record_count=parseInt($("#record_count").val());
        var record_overall_merit=parseInt($("#record_overall_merit").val());
        $("#record_point_amount").val(parseInt(base_point_interval*record_amount/100));
        $("#record_point_count").val(parseInt(base_point_interval*record_count/100));
        $("#record_point_overall_merit").val(parseInt(base_point_interval*record_overall_merit/100));
    }
    /**
     * 编辑详情
     */
    function showRules(type) {
        BUI.use(['bui/overlay','bui/form','bui/mask'],function(Overlay,Form){
            var form,
            dialog = new Overlay.Dialog({
                title:'规则设置',
                width:800,
                loader : {
                  url : '/trust/range-point/edit?range_type='+type,
                  autoLoad : true, //不自动加载
                  lazyLoad : false,
                },
                buttons:[],
                mask:true,
                success : function(){
                  //可以直接action 提交
                  form && form.submit(); //也可以form.ajaxSubmit(params);
                }
              });
          dialog.show();
        });
    }

    /**
     * 编辑详情
     */
    function showMerit() {
        BUI.use(['bui/overlay','bui/form','bui/mask'],function(Overlay,Form){
            var form,
            title='<?=$record['record_type']==1?'近期综合评分规则':'历史综合评分规则'?>',
            dialog = new Overlay.Dialog({
                title:title,
                width:500,
                loader : {
                  url : 'edit?id=<?=$record['id']?>'+'&record_type=<?=$record['record_type']?>',
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
                  if(saveMerit())
                  {
                      form && form.destroy();
                      this.close();
                  }
                }
              });
          dialog.show();
        });
    }
    </script>
</body>
</html>