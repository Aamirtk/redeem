<?php
use yii\helpers\Html;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户成长体系管理--等级管理</title>
    <?= Html::cssFile('@web/assets/css/calendar-min.css') ?>
    <?= Html::cssFile('@web/assets/css/dpl-min.css') ?>
    <?= Html::cssFile('@web/assets/css/bui-min.css') ?>
    <?= Html::cssFile('@web/assets/css/page-min.css') ?>
    <?= Html::jsFile('@web/Js/jquery.js') ?>
    <?= Html::jsFile('@web/assets/js/bui-min.js') ?>
    <?= Html::jsFile('@web/assets/js/acharts.js') ?>
    <?= Html::jsFile('@web/Js/common/common.js?v=1.0.0') ?>
    <?= Html::jsFile('@web/Js/common/daterange.js') ?>
</head>
<body>
<div class="container">
    <div class="search-bar form-horizontal well">
    <div class="bui-grid-tbar">
        <!--<a class="button button-primary" href="<?/*= Yii::$app->urlManager->createUrl('point/channel/add') */?>">新增等级</a>-->
    </div>
    <div id="levels_grid">
    </div>
</div>
    <?php require yii::$app->getBasePath() . '/modules/point/views/level/level_edit.php'; ?>
<script type="text/javascript">
    top.topManager.setPageTitle("等级管理");

    $(function () {
        //设置表格属性
        BUI.use(['bui/grid', 'bui/data'], function (Grid, Data) {
            var Grid = Grid;
            var store = new Data.Store({
                url: "<?= Yii::$app->urlManager->createUrl('point/level/list') ?>",
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
                root: 'levels',//数据返回字段,支持深成次属性root : 'data.records',
                totalProperty: 'totalCount',//总计字段
                pageSize: <?= yii::$app->params['page_size'] ?>
            });
            var grid = new Grid.Grid({
                render: '#levels_grid',
                width:'100%',
                idField: 'level_id', //自定义选项 id 字段
                selectedEvent: 'click',
                columns: [
                    {title: '编号', dataIndex: 'level_id', elCls : 'center', width: 80},
                    {title: '等级', dataIndex: 'level', elCls : 'center', width: 100},
                    {title: '升等所需值', dataIndex: 'requirement', elCls : 'center', width: 200},
                    {
                        title: '创建时间',
                        dataIndex: 'created_at',
                        width: 130,
                        renderer: function (v) {
                            return v ? BUI.Date.format(new Date(v * 1000), 'yyyy-mm-dd HH:MM:ss') : '';
                        }
                    },
                    {
                        title: '更新时间',
                        dataIndex: 'updated_at',
                        width: 130,
                        renderer: function (v) {
                            return v ? BUI.Date.format(new Date(v * 1000), 'yyyy-mm-dd HH:MM:ss') : '';
                        }
                    },
                    {
                        title: '操作',
                        width: 300,
                        renderer: function (v, obj) {
                            return "<a class='button button-primary' href='javascript:void(0);' onclick=\"showLevelDetails('" + obj.level_id + "')\">编辑</a>&nbsp;&nbsp;";
                        }
                    }
                ],
                loadMask: true, //加载数据时显示屏蔽层
                store: store,
                // 底部工具栏
                bbar: {
                    pagingBar: true
                }
            });
            grid.render();

            $("#levels_grid").data("BGrid", grid);
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