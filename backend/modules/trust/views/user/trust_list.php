<?php
use yii\helpers\Html;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>信用体系管理后台--查询用户信用评分</title>
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
    <div class="search-bar form-horizontal well">
        <div class="row">
            <div class="span">
                <label class="control-label">账号：</label>
                <div class="controls">
                    <input id="s_username" class="" type="text"/>
                </div>
            </div>
            <div class="row">
                <div class="span">
                    <a class="button button-primary" href="javascript:void(0);" onclick="searchTrusts()">搜索</a>
                </div>
            </div>
        </div>
        <div id="trusts_grid">
        </div>
    </div>
    <script type="text/javascript">
        /**
         * 搜索项目
         */
        function searchTrusts() {
            var search = getTalentGridSearchConditions();
            var store = $("#trusts_grid").data("BGrid").get('store');
            var params = {};
            params.search = search;
            params.pageIndex = 0;//重置第一页(解决翻页搜索为空的问题）
            params.start = 0;//重置第一页(解决翻页搜索为空的问题）
            store.load(params);//刷新
        }
        /**
         * 获取过滤项
         */
        function getTalentGridSearchConditions() {
            var search = {};
            var username = $("#s_username").val();
            if (username != "") {
                search.username = username;
            }
            return search;
        }

        $(function () {
            //设置表格属性
            BUI.use(['bui/grid', 'bui/data'], function (Grid, Data) {
                var Grid = Grid;
                var store = new Data.Store({
                    url: "<?= Yii::$app->urlManager->createUrl('trust/user/get-trust-data') ?>",
                    proxy: {//设置请求相关的参数
                        method: 'post',
                        dataType: 'json', //返回数据的类型
                        limitParam: 'pageSize', //一页多少条记录
                        pageIndexParam: 'page', //页码
                    },
                    autoLoad: true, //自动加载数据
                    root: 'trusts',//数据返回字段,支持深成次属性root : 'data.records',
                    totalProperty: 'totalCount',//总计字段
                    pageSize: <?= yii::$app->params['page_size'] ?>
                });
                var grid = new Grid.Grid({
                    render: '#trusts_grid',
                    width:'100%',
                    idField: 'username', //自定义选项 id 字段
                    selectedEvent: 'click',
                    columns: [
                        {title: '账号', dataIndex: 'username', elCls : 'center', width: 80},
                        {title: '昵称', dataIndex: 'nickname', elCls : 'center', width: 300},
                        {
                            title:'行为偏向',
                            width:100,
                            dataIndex: 'identity_type',
                            renderer:function(v, obj){
                                if(v == 1){
                                    return '偏甲方';
                                }else{
                                    return '偏乙方';
                                }
                            }
                        },
                        {title: '信用分', dataIndex: 'trust', elCls : 'center', width: 200},
                        {title: '负面影响数量', dataIndex: 'negative_count', elCls : 'center', width: 200},
                        {
                            title: '操作',
                            width: 300,
                            renderer: function (v, obj) {
                                return "<a class='button button-primary' href='/trust/user/trust-record?username=" + obj.username + "' >查看</a>&nbsp;&nbsp;"
                                        + " <a class='button button-info' href='/trust/user/trust-history?username=" + obj.username + "' >查看历史</a>&nbsp;&nbsp;"
                                        + "<a class='button button-danger' href='/trust/user/trust-negative?username=" + obj.username + "' >增加负面</a>";
                            }
                        }
                    ],
                    loadMask: true, //加载数据时显示屏蔽层
                    store: store,
                    // 底部工具栏
                    bbar: {
                        pagingBar: true
                    },
                });
                grid.render();
                $("#trusts_grid").data("BGrid", grid);
            });

            BUI.use(['bui/mask'], function (Mask) {
                var fullMask = new Mask.LoadMask({
                    el: 'body',
                    msg: 'loading...'
                });
                $("body").data('BMask', fullMask);
            });
        });
    </script>
</body>
</html>