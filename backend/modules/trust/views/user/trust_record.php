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

        #negative_grid {
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
    <div class="row">
        <div class="span12  doc-content">
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                <tr>
                    <th>项目</th>
                    <th>参考值</th>
                    <th>得分</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                </tr><tr>
                    <td>公安实名认证</td>
                    <td><?= isset($identity['realname_value']) ? ($identity['realname_value']==1?'Yes':'No' ): ''; ?></td>
                    <td><?= isset($identity['realname_point']) ? $identity['realname_point'] : ''; ?></td>
                </tr>
                <tr>
                    <td>工商企业认证</td>
                    <td><?= isset($identity['enterprise_value']) ? ($identity['enterprise_value']==1?'Yes':'No' ): ''; ?></td>
                    <td><?= isset($identity['enterprise_point']) ? $identity['enterprise_point'] : ''; ?></td>
                </tr>
                <tr>
                    <td>身份基本信息</td>
                    <td><?= isset($identity['baseinfo_value']) ? $identity['baseinfo_value'] : ''; ?>
                    /<?= isset($identity['baseinfo_key']) ? $identity['baseinfo_key'] : ''; ?></td>
                    <td><?= isset($identity['baseinfo_point']) ? $identity['baseinfo_point'] : ''; ?></td>
                </tr>
                <tr>
                    <td>信息稳定性</td>
                    <td><?= isset($identity['stability_value']) ? $identity['stability_value'] : ''; ?></td>
                    <td><?= isset($identity['stability_point']) ? $identity['stability_point'] : ''; ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="span12  doc-content">
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                <tr>
                    <th>项目</th>
                    <th>参考值</th>
                    <th>得分</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                </tr><tr>
                    <td>近期交易额</td>
                    <td><?= isset($recents['amount_value']) ? $recents['amount_value'] : ''; ?></td>
                    <td><?= isset($recents['amount_point']) ? $recents['amount_point'] : ''; ?></td>
                </tr>
                <tr>
                    <td>近期交易次数</td>
                    <td><?= isset($recents['count_value']) ? $recents['count_value'] : ''; ?></td>
                    <td><?= isset($recents['count_point']) ? $recents['count_point'] : ''; ?></td>
                </tr>
                <tr>
                    <td>近期综合评分</td>
                    <td><?= isset($recents['merit_point']) ? $recents['merit_point'] : ''; ?></td>
                    <td><?= isset($recents['merit_point']) ? $recents['merit_point'] : ''; ?></td>
                </tr>
                <tr>
                    <td>近期负面扣分</td>
                    <td><?= isset($recents['negative_point']) ? $recents['negative_point'] : ''; ?></td>
                    <td><?= isset($recents['negative_point']) ? $recents['negative_point'] : ''; ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="span12  doc-content">
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                <tr>
                    <th>项目</th>
                    <th>参考值</th>
                    <th>得分</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                </tr><tr>
                    <td>用户活跃度</td>
                    <td><?= isset($behaviors['activity_value']) ? $behaviors['activity_value'] : ''; ?></td>
                    <td><?= isset($behaviors['activity_point']) ? $behaviors['activity_point'] : ''; ?></td>
                </tr>
                <tr>
                    <td>发标</td>
                    <td><?= isset($behaviors['tender_value']) ? $behaviors['tender_value'] : ''; ?></td>
                    <td><?= isset($behaviors['tender_point']) ? $behaviors['tender_point'] : ''; ?></td>
                </tr>
                <tr>
                    <td>投标</td>
                    <td><?= isset($behaviors['bid_value']) ? $behaviors['bid_value'] : ''; ?></td>
                    <td><?= isset($behaviors['bid_point']) ? $behaviors['bid_point'] : ''; ?></td>
                </tr>
                <tr>
                    <td>保证金托管</td>
                    <td><?= isset($behaviors['deposit_value']) ? $behaviors['deposit_value'] : ''; ?></td>
                    <td><?= isset($behaviors['deposit_point']) ? $behaviors['deposit_point'] : ''; ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="span12  doc-content">
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                <tr>
                    <th>项目</th>
                    <th>参考值</th>
                    <th>得分</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                </tr><tr>
                    <td>历史交易额</td>
                    <td><?= isset($historys['amount_value']) ? $historys['amount_value'] : ''; ?></td>
                    <td><?= isset($historys['amount_point']) ? $historys['amount_point'] : ''; ?></td>
                </tr>
                <tr>
                    <td>历史交易次数</td>
                    <td><?= isset($historys['count_value']) ? $historys['count_value'] : ''; ?></td>
                    <td><?= isset($historys['count_point']) ? $historys['count_point'] : ''; ?></td>
                </tr>
                <tr>
                    <td>历史综合评分</td>
                    <td><?= isset($historys['merit_point']) ? $historys['merit_point'] : ''; ?></td>
                    <td><?= isset($historys['merit_point']) ? $historys['merit_point'] : ''; ?></td>
                </tr>
                <tr>
                    <td>历史负面扣分</td>
                    <td><?= isset($historys['negative_point']) ? $historys['negative_point'] : ''; ?></td>
                    <td><?= isset($historys['negative_point']) ? $historys['negative_point'] : ''; ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="span12  doc-content">
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                <tr>
                    <th>项目</th>
                    <th>参考值</th>
                    <th>得分</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                </tr><tr>
                    <td>成长等级</td>
                    <td><?= isset($socials['level_value']) ? $socials['level_value'] : ''; ?></td>
                    <td><?= isset($socials['level_point']) ? $socials['level_point'] : ''; ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div id="negative_grid">
    </div>
</div>
<script type="text/javascript">

    $(function () {
        //设置表格属性
        BUI.use(['bui/grid', 'bui/data'], function (Grid, Data) {
            var username = "<?= $username?>";
            var Grid = Grid;
            var store = new Data.Store({
                url: "<?= Yii::$app->urlManager->createUrl('trust/user/get-negative-data?username=') ?>"+username,
                proxy: {//设置请求相关的参数
                    method: 'post',
                    dataType: 'json', //返回数据的类型
                    limitParam: 'pageSize', //一页多少条记录
                    pageIndexParam: 'page', //页码
                },
                autoLoad: true, //自动加载数据
                root: 'negatives',//数据返回字段,支持深成次属性root : 'data.records',
                totalProperty: 'totalCount',//总计字段
                pageSize: <?= yii::$app->params['page_size'] ?>
            });
            var grid = new Grid.Grid({
                render: '#negative_grid',
                width:'100%',
                idField: 'id', //自定义选项 id 字段
                selectedEvent: 'click',
                columns: [
                    {title: '负面信息编号', dataIndex: 'id', elCls : 'center', width: 80},
                    {title: '负面信息内容', dataIndex: 'negative_content', elCls : 'center', width: 300},
                    {title: '扣分', dataIndex: 'negative_point', elCls : 'center', width: 200},
                    {
                        title: '创建日期',
                        dataIndex: 'created_at',
                        width: 130,
                        renderer: function (v) {
                            return v ? BUI.Date.format(new Date(v * 1000), 'yyyy-mm-dd HH:MM:ss') : '';
                        }
                    },
                    {title: '操作人', dataIndex: 'operator', elCls : 'center', width: 200}
                ],
                loadMask: true, //加载数据时显示屏蔽层
                store: store,
                // 底部工具栏
                bbar: {
                    pagingBar: true
                },
            });
            grid.render();
            $("#negative_grid").data("BGrid", grid);
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