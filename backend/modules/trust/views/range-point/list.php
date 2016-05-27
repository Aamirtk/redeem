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
                <legend><?=$range_name?>规则设置</legend>
                <div class="bui-grid-tbar">
                    <a class="button button-primary" href="javascript:void(0)" onclick="showDetails('')">添加</a>
                </div>
                <div id="rules_grid"></div>
            </div>
        </div>
    </div>
</div>
    <!-- script start -->
    <script type="text/javascript">
    //设置表格属性
    BUI.use(['bui/grid', 'bui/data'], function (Grid, Data) {
        var Grid = Grid;
        var store = new Data.Store({
            url: "<?= Yii::$app->urlManager->createUrl('trust/range-point/list') ?>",
            proxy: {//设置请求相关的参数
                method: 'post',
                dataType: 'json', //返回数据的类型
                limitParam: 'pageSize', //一页多少条记录
                pageIndexParam: 'page', //页码
                //startParam : 'startNum' //起始记录
            },
            params:{
                range_type:'<?=$range_type?>'
            },
            autoLoad: true, //自动加载数据
            root: 'data',//数据返回字段,支持深成次属性root : 'data.records',
        });

        //定义表格title
        var grid = new Grid.Grid({
            render: '#rules_grid',
            idField: 'id', //自定义选项 id 字段
            selectedEvent: 'click',
            columns: [
                {title: '范围起始值', dataIndex: 'min_val'},
                {title: '范围结束值（包含）', dataIndex: 'max_val'},
                {title: '分值', dataIndex: 'point'},
                {
                    title: '操作',
                    renderer: function (v, obj) {
                        return "<a class='button button-danger' href='javascript:void(0);' onclick=\"checkDeleteRules('" + obj.id + "')\">删除</a> "
                            + "<a class='button button-primary' href='javascript:void(0);' onclick=\"showDetails('" + obj.id + "')\">编辑</a> "
                    }
                }
            ],
            loadMask: true, //加载数据时显示屏蔽层
            store: store,
            forceFit : true,
            plugins: [Grid.Plugins.CheckSelection] // 插件形式引入多选表格
        });
        grid.render();
        $("#rules_grid").data("BGrid", grid);
    });
    /**
     * 编辑详情
     */
    function showDetails(id) {
        BUI.use(['bui/overlay','bui/form','bui/mask'],function(Overlay,Form){
            var form,
            dialog = new Overlay.Dialog({
                title:'规则详情',
                width:500,
                loader : {
                  url : 'edit?id='+id+'&range_type=<?=$range_type?>',
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
            /**
             * 删除提示
             */
            function checkDeleteRules(id) {
                //如果不传，表示删除勾选
                var Ids = [];
                if (id) {
                    Ids.push(id);
                }
                else {
                    Ids = $("#rules_grid").data("BGrid").getSelection();
                }
                if (Ids.length == 0) {
                    return;
                }

                BUI.use('bui/overlay', function (Overlay) {
                    BUI.Message.Show({
                        title: '删除提示',
                        msg: '您确定要删除选中规则吗？',
                        icon: 'warning',
                        buttons: [
                            {
                                text: '确定',
                                elCls: 'button button-primary',
                                handler: function () {
                                    deleteRule(Ids);
                                    this.close();
                                }
                            },
                            {
                                text: '取消',
                                elCls: 'button',
                                handler: function () {
                                    this.close();
                                }
                            }
                        ]
                    });
                });
            }
            /**
             * 删除规则
             */
            function deleteRule(id) {
                //console.info(bannerIds);
                $.ajax({
                    type: "post",
                    data: {ids: id},
                    url: "<?= Yii::$app->urlManager->createUrl('trust/range-point/delete') ?>",
                    dataType: "json",
                    success: function (json) {
                        if (json.result) {
                            var grid = $("#rules_grid").data("BGrid");
                            grid.clearSelection();
                            grid.get('store').load();//刷新
                            BUI.Message.Alert('删除成功', 'success');
                        }
                        else {
                            BUI.Message.Alert('删除失败', 'error');
                        }
                    }
                });
            }
    </script>
    </body>
</html>