<?php
use yii\helpers\Html;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>会员管理</title>
    <?= Html::cssFile('@web/assets/css/calendar-min.css') ?>
    <?= Html::cssFile('@web/assets/css/dpl-min.css') ?>
    <?= Html::cssFile('@web/assets/css/bui-min.css') ?>
    <?= Html::cssFile('@web/assets/css/page-min.css') ?>
    <?= Html::jsFile('@web/Js/jquery.js') ?>
    <?= Html::jsFile('@web/assets/js/bui-min.js') ?>
    <?= Html::jsFile('@web/Js/common/common.js?v=1.0.0') ?>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="main">
                <div class="search-bar form-horizontal well">
                    <div class="row">
                        <div class="span">
                            <label class="control-label">标题：</label>

                            <div class="controls">
                                <input id="s_name" class="" type="text"/>
                            </div>
                        </div>
                        <div class="span">
                            <label class="control-label">状态：</label>

                            <div class="controls">
                                <div id="s_status">
                                    <input type="hidden" id="hide_status" value="" name="hide_status">
                                </div>
                            </div>
                        </div>
                        <div class="span">
                            <a class="button button-primary" href="javascript:void(0);" onclick="searchGroups()">搜索</a>
                        </div>
                    </div>
                </div>
                <div class="bui-grid-tbar">
                    <a class="button button-primary" href="<?= Yii::$app->urlManager->createUrl('vip/group/edit') ?>">添加</a>
                </div>
                <div id="groups_grid"></div>
            </div>
        </div>
    </div>
</div>
<!-- script start -->
<script type="text/javascript">
    /**
     * 搜索
     */
    function searchGroups() {
        var search = getConditions();
        var store = $("#groups_grid").data("BGrid").get('store');
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
        var s_name = $("#s_name").val();
        var s_status = $("#hide_status").val();
        if (s_name != "") {
            search.name = s_name;
        }
        if (s_status != "") {
            search.status = s_status;
        }
        return search;
    }
    //设置表格属性
    BUI.use(['bui/grid', 'bui/data'], function (Grid, Data) {
        var Grid = Grid;
        var store = new Data.Store({
            url: "<?= Yii::$app->urlManager->createUrl('vip/group/list') ?>",
            proxy: {//设置请求相关的参数
                method: 'post',
                dataType: 'json', //返回数据的类型
                limitParam: 'pageSize', //一页多少条记录
                pageIndexParam: 'page', //页码
                //startParam : 'startNum' //起始记录
            },
            autoLoad: true, //自动加载数据
            root: 'groups',//数据返回字段,支持深成次属性root : 'data.records',
            totalProperty: 'totalCount',//总计字段
            pageSize: <?= yii::$app->params['page_size'] ?>
        });
        //定义表格title
        var grid = new Grid.Grid({
            render: '#groups_grid',
            idField: 'id', //自定义选项 id 字段
            selectedEvent: 'click',
            columns: [
                {title: 'ID', dataIndex: 'id'},
                {
                    title: '标题', dataIndex: 'name',
                    renderer: function (v, obj) {
                        return "<a class='' href='<?= Yii::$app->urlManager->createUrl('vip/group/view?id=') ?>" + obj.id + "'>" + v + "</a> "
                    }
                },
                {title: '售价', dataIndex: 'price'},
                {
                    title: '创建时间', dataIndex: 'created_at',
                    renderer: function (v) {
                        return v ? BUI.Date.format(new Date(v * 1000), 'yyyy-mm-dd HH:MM:ss') : '';
                    }
                },
                {
                    title: '状态', dataIndex: 'status',
                    renderer: function (v) {
                        return v == '1' ? '有效' : '无效';
                    }
                },
                {
                    title: '操作',
                    renderer: function (v, obj) {
                        return "<a class='button button-primary' href='<?= Yii::$app->urlManager->createUrl('vip/group/edit?id=') ?>" + obj.id + "'>修改</a> "
                    }
                }
            ],
            loadMask: true, //加载数据时显示屏蔽层
            store: store,
            forceFit: true,
            plugins: [Grid.Plugins.CheckSelection] // 插件形式引入多选表格
        });
        grid.render();
        $("#groups_grid").data("BGrid", grid);
    });
    BUI.use('bui/select', function (Select) {
        var items = [
                {text: '全部状态', value: ''},
                {text: '有效', value: '1'},
                {text: '无效', value: '0'}
            ],
            select = new Select.Select({
                render: '#s_status',
                valueField: '#hide_status',
                items: items
            });
        select.render();
    });
</script>
</body>
</html>