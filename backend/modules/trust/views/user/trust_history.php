<?php
use yii\helpers\Html;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>信用体系管理后台--查看用户信用评分明细</title>
    <?= Html::cssFile('@web/assets/css/calendar-min.css') ?>
    <?= Html::cssFile('@web/assets/css/dpl-min.css') ?>
    <?= Html::cssFile('@web/assets/css/bui-min.css') ?>
    <?= Html::cssFile('@web/assets/css/page-min.css') ?>
    <?= Html::jsFile('@web/Js/jquery.js') ?>
    <?= Html::jsFile('@web/assets/js/bui-min.js') ?>
    <?= Html::jsFile('@web/Js/common/common.js?v=1.0.0') ?>
    <?= Html::jsFile('@web/Js/common/daterange.js') ?>
    <style type="text/css">
        .userinfo .table {
            width: 202%;
        }

        .userinfo .table td {
            width: 400px;
        }

        #history_grid {
            width: 950px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="span12  doc-content userinfo">
            <table cellspacing="0" class="table table-bordered">
                <thead>
                </thead>
                <tbody>
                <tr>
                    <td>账号</td>
                    <td><?= isset($userinfo[0]['username']) ? $userinfo[0]['username'] : ''; ?></td>
                    <td>姓名</td>
                    <td><?= isset($userinfo[0]['truename']) ? $userinfo[0]['truename'] : ''; ?></td>
                    <td>注册日期</td>
                    <td><?= isset($userinfo[0]['create_time']) ? date('Y-m-d : H:i:s',$userinfo[0]['create_time']) : ''; ?></td>
                </tr>
                <tr>
                    <td>用户等级</td>
                    <td><?= isset($userinfo[0]['point_level']) ? $userinfo[0]['point_level'] : ''; ?></td>
                    <td>信用分</td>
                    <td><?= isset($userinfo[0]['trust']) ? $userinfo[0]['trust'] : ''; ?></td>
                    <td>上期信用分</td>
                    <td><?= isset($userinfo[1]['trust']) ? $userinfo[1]['trust'] : ''; ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div id="history_grid">
    </div>
</div>
<script type="text/javascript">

    $(function () {
        //设置表格属性
        BUI.use(['bui/grid', 'bui/data'], function (Grid, Data) {
            var username = "<?= $username?>";
            var Grid = Grid;
            var store = new Data.Store({
                url: "<?= Yii::$app->urlManager->createUrl('trust/user/get-history-data?username=') ?>"+username,
                proxy: {//设置请求相关的参数
                    method: 'post',
                    dataType: 'json', //返回数据的类型
                    limitParam: 'pageSize', //一页多少条记录
                    pageIndexParam: 'page', //页码
                },
                autoLoad: true, //自动加载数据
                root: 'historys',//数据返回字段,支持深成次属性root : 'data.records',
                totalProperty: 'totalCount',//总计字段
                pageSize: <?= yii::$app->params['page_size'] ?>
            });
            var grid = new Grid.Grid({
                render: '#history_grid',
                width:'100%',
                idField: 'id', //自定义选项 id 字段
                selectedEvent: 'click',
                columns: [
                    {
                        title: '日期',
                        dataIndex: 'created_at',
                        width: 130,
                        renderer: function (v) {
                            return v ? BUI.Date.format(new Date(v * 1000), 'yyyy.mm') : '';
                        }
                    },
                    {title: '信用得分', dataIndex: 'trust', elCls : 'center', width: 300},
                    {title: '负面扣分', dataIndex: 'negative_point', elCls : 'center', width: 200}
                ],
                loadMask: true, //加载数据时显示屏蔽层
                store: store,
                // 底部工具栏
                bbar: {
                    pagingBar: true
                },
            });
            grid.render();
            $("#history_grid").data("BGrid", grid);
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