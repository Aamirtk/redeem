<?php
use yii\helpers\Html;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户成长体系管理--配比管理</title>
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
                <div class="search-bar form-horizontal well">
                    <div class="row">
                        <div class="span">
                            <label class="control-label">行为名称：</label>
                            <div class="controls">
                                <input id="s_rulealias" class="" type="text"/>
                            </div>
                        </div>
                        <div class="span">
                            <label class="control-label">频道名称：</label>
                            <div class="controls">
                                <div id="s_channels" >
                                    <input type="hidden" id="hide_channels" value="" name="hide_channels">
                                </div>
                            </div>
                        </div>
                        <div class="span">
                            <label class="control-label">分值：</label>
                            <div class="controls">
                                <input id="s_point" class="" type="text"/>
                            </div>
                        </div>
                        <div class="span">
                            <a class="button button-primary" href="javascript:void(0);" onclick="searchRules()">搜索</a>
                        </div>
                    </div>
                </div>
                <div id="rules_grid"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    /**
     * 刷新列表
     */
    function refreshTalentGrid() {
        var search = getConditions();
        var store = $("#rules_grid").data("BGrid").get('store');
        var params = {};
        params.search = search;
        params.pageIndex = 0;//重置第一页(解决翻页搜索为空的问题）
        params.start = 0;//重置第一页(解决翻页搜索为空的问题）
        store.load(params);//刷新
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
        var s_rulealias = $("#s_rulealias").val();
        var s_chid = $("#hide_channels").val();
        var s_point = $("#s_point").val();
        if (s_rulealias != "") {
            search.rulealias = s_rulealias;
        }
        if (s_chid != "") {
            search.chid = s_chid;
        }
        if (s_point != "") {
            search.point = s_point;
        }
        return search;
    }

    /**
     * 编辑详情
     */
    function showDetails(rid) {
        BUI.use(['bui/overlay','bui/form','bui/mask'],function(Overlay,Form){
            var form,
            dialog = new Overlay.Dialog({
                title:'配比详情',
                width:500,
                loader : {
                  url : 'edit?rid='+rid,
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
    $(function () {
        $.ajax({
                type: "GET",
                url: "/point/allocation/get-channels",
                cache: false,
                dataType: "json",
                success: function (data) {
                    var all = {text:'--全部--',value:''};
                    data.unshift(all);
                    var items = data;
                    console.log(items);
                        BUI.use(["bui/select"], function (Select) {
                            select = new Select.Select({
                                render: "#s_channels",
                                valueField: "#hide_channels",
                                multipleSelect: false,
                                items: items
                            });
                        });
                        select.render();
                }
            });
        //设置表格属性
        BUI.use(['bui/grid', 'bui/data'], function (Grid, Data) {
            var Grid = Grid;
            var store = new Data.Store({
                url: "<?= Yii::$app->urlManager->createUrl('point/allocation/list') ?>",
                proxy: {//设置请求相关的参数
                    method: 'post',
                    dataType: 'json', //返回数据的类型
                    limitParam: 'pageSize', //一页多少条记录
                    pageIndexParam: 'page', //页码
                    //startParam : 'startNum' //起始记录
                },
                autoLoad: true, //自动加载数据
                params: { //配置初始请求的其他参数
                    //a : 'a1',
                    //b : 'b1'
                },
                root: 'rules',//数据返回字段,支持深成次属性root : 'data.records',
                totalProperty: 'totalCount',//总计字段
                pageSize: <?= yii::$app->params['page_size'] ?>
            });

            //定义表格title
            var grid = new Grid.Grid({
                render: '#rules_grid',
                idField: 'rid', //自定义选项 id 字段
                selectedEvent: 'click',
                columns: [
                    {title: '序号', dataIndex: 'rid', width: 100},
                    {title: '行为名称', dataIndex: 'rulealias', width: 220},
                    {title: '频道名称', dataIndex: 'channelname', width: 120},
                    {title: '分值', dataIndex: 'point', width: 100},
                    {title: '状态', dataIndex: 'available', width: 100,
                        renderer: function (v) {
                            return v=='1'?'已启用':'未启用';
                        }
                    },
                    {
                        title: '操作',
                        width: '30%',
                        renderer: function (v, obj) {
                            var ope = obj.available == 1 ? '停用' : '启用';
                            return "<a class='button button-danger' href='/point/allocation/active?availbale=" + obj.available + "&rids=" + obj.rid + "'\">" + ope + "</a> "
                                + "<a class='button button-primary' href='javascript:void(0);' onclick=\"showDetails('" + obj.rid + "')\">编辑</a> "
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
        //数据加载
        BUI.use(['bui/mask'], function (Mask) {
            var fullMask = new Mask.LoadMask({
                el: 'body',
                msg: 'loading...'
            });
            $("body").data('BMask', fullMask);
        });
//        BUI.use(['bui/overlay','bui/form'],function(Overlay,Form){
//            var dialog = new Overlay.Dialog({
//                title:'配比详情',
//                width:500,
//                mask:true,
//                buttons:[],
//                loader : {
//                  url : 'point/views/allocation/edit.php',
//                  autoLoad : false, //不自动加载
//                  lazyLoad : false,
//                  callback : function(){
//                    var node = dialog.get('el').find('form');//查找内部的表单元素
//                    form = new Form.HForm({
//                      srcNode : node,
//                      autoRender : true
//                    });
//                  }
//                },
//                contentId:"details_window"
//            });
//            $("#details_window").data("BDialog", dialog);
//        });
//        BUI.use('bui/form',function(Form){
//            var f = new Form.Form({
//                srcNode : '#details_form',
//                autoRender : true
//            });
//            f.render();
//            $("#details_form").data("BForm", f);
//        });
    });
</script>
</body>
</html>