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
                <legend>负面影响扣分规则设置</legend>
                <div class="search-bar form-horizontal well">
                    <div class="row">
                        <div class="span">
                            <label class="control-label">扣分规则内容：</label>
                            <div class="controls">
                                <input id="s_content" class="" type="text"/>
                            </div>
                        </div>
                        <div class="span">
                            <a class="button button-primary" href="javascript:void(0);" onclick="searchRules()">搜索</a>
                        </div>
                    </div>
                </div>
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
            url: "<?= Yii::$app->urlManager->createUrl('trust/negative/list') ?>",
            proxy: {//设置请求相关的参数
                method: 'post',
                dataType: 'json', //返回数据的类型
                limitParam: 'pageSize', //一页多少条记录
                pageIndexParam: 'page', //页码
                //startParam : 'startNum' //起始记录
            },
            autoLoad: true, //自动加载数据
            root: 'rules',//数据返回字段,支持深成次属性root : 'data.records',
            totalProperty: 'totalCount',//总计字段
            pageSize: <?= yii::$app->params['page_size'] ?>
        });

        //定义表格title
        var grid = new Grid.Grid({
            render: '#rules_grid',
            idField: 'id', //自定义选项 id 字段
            selectedEvent: 'click',
            columns: [
                {title: '编号', dataIndex: 'id', width: 100},
                {title: '扣分规则说明', dataIndex: 'content', width: 300},
                {title: '扣除分值', dataIndex: 'point', width: 100},
                {
                    title: '操作',
                    renderer: function (v, obj) {
                        return  "<a class='button button-primary' href='javascript:void(0);' onclick=\"showDetails('" + obj.id + "')\">编辑</a> "
                    }
                }
            ],
            loadMask: true, //加载数据时显示屏蔽层
            store: store,
            // 底部工具栏
            bbar: {
                // pagingBar:表明包含分页栏
                pagingBar: true
            },
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
                  url : 'edit?id='+id,
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
     * 搜索
     */
    function searchRules() {
        var search = getConditions();
        var store = $("#rules_grid").data("BGrid").get('store');
        var params = {};
        params.search = search;
        params.pageIndex = 0;//重置第一页
        params.start = 0;//重置第一页
        store.load(params);//刷新
    }
    /**
     * 获取过滤项
     */
    function getConditions() {
        var search = {};
        var s_content = $("#s_content").val();
        if (s_content != "") {
            search.content = s_content;
        }
        return search;
    }
    </script>
    </body>
</html>