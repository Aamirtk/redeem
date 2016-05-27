<?php
use yii\helpers\Html;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户成长体系管理--积分赠送明细</title>
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
                            <label class="control-label">编号：</label>
                            <div class="controls">
                                <input id="rdid" class="" type="text"/>
                            </div>
                        </div>
                        <div class="span">
                            <label class="control-label">用户名：</label>
                            <div class="controls">
                                <input id="username" class="" type="text"/>
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
                            <label class="control-label">行为名称：</label>
                            <div class="controls">
                                <div id="s_rulealias" >
                                    <input type="hidden" id="hide_rulealias" value="" name="hide_rulealias">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span" id="date_range_search">
                            <label class="control-label">创建时间：</label>
                            <input v-role="date-range-nolimit" type="radio" name="enter_time_group" checked="checked"/><span>不限</span>
                            <input v-role="date-range-today" type="radio" name="enter_time_group"/><span>今天</span>
                            <input v-role="date-range-yesterday" type="radio" name="enter_time_group"/><span>昨天</span>
                            <input v-role="date-range-week" type="radio" name="enter_time_group"/><span>本周</span>
                            <input v-role="date-range-month" type="radio" name="enter_time_group"/><span>本月</span>
                            <input v-role="date-range-start" id="s_enter_time_start" type="text" class="calendar calendar-time"/>至
                            <input v-role="date-range-end" id="s_enter_time_end" type="text" class="calendar calendar-time"/>
                        </div>
                        <div class="span">
                            <a class="button button-primary" href="javascript:void(0);" onclick="searchProjects()">搜索</a>
                        </div>
                    </div>
                </div>
                <div class="tips tips-small tips-info" id="recode_user_info" style="display: none;">
                    <span class="x-icon x-icon-small x-icon-info"><i class="icon icon-white  icon-user"></i></span>
                    <div class="tips-content">
                        用户名：<span id="recode_user_name" style="color: blue;"></span>&nbsp;&nbsp;
                        等级：<span  id="recode_user_level" style="color: blue;"></span>&nbsp;&nbsp;
                        积分：<span id="recode_user_point" style="color: blue;"></span>
                    </div>
                </div>
                <div id="record_grid"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    /**
     * 搜索项目
     */
    function searchProjects() {
        var search = getProjectGridSearchConditions();
        var store = $("#record_grid").data("BGrid").get('store');
        var params = {};
        params.search = search;
        params.pageIndex = 0;//重置第一页(解决翻页搜索为空的问题）
        params.start = 0;//重置第一页(解决翻页搜索为空的问题）
        store.load(params,function(data){
            if(data.username){
                $.ajax({
                    type: "GET",
                    url: "/point/record/get-user-info?username="+data.username,
                    cache: false,
                    dataType: "json",
                    success: function (json) {
                        $("#recode_user_info").show();
                        $("#recode_user_name").text(json.username);
                        $("#recode_user_level").text(json.point_level);
                        $("#recode_user_point").text(json.point);
                    }
                });
            }
        });//刷新
    }
    /**
     * 获取过滤项
     */
    function getProjectGridSearchConditions() {
        var search = {};
        var rdid = $("#rdid").val();
        var username = $("#username").val();
        var s_chid = $("#hide_channels").val();
        var s_rid = $("#hide_rulealias").val();
        var createdRangeStart = $("#s_enter_time_start").val();
        var createdRangeEnd = $("#s_enter_time_end").val();

        if (rdid != "") {
            search.rdid = rdid;
        }
        if (username != "") {
            search.username = username;
        }
        if (s_chid != "") {
            search.chid = s_chid;
        }
        if (s_rid != "") {
            search.rid = s_rid;
        }
        if (createdRangeStart != "") {
            search.created_range_start = createdRangeStart;
        }
        if (createdRangeEnd != "") {
            search.created_range_end = createdRangeEnd;
        }
        return search;
    }

    $(function () {

        //频道名称
        $.ajax({
            type: "GET",
            url: "/point/allocation/get-channels",
            cache: false,
            dataType: "json",
            success: function (data) {
                var all = {text:'--全部--',value:''};
                data.unshift(all);
                var items =data;
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

        //行为名称
        $.ajax({
            type: "GET",
            url: "/point/record/get-rulealias",
            cache: false,
            dataType: "json",
            success: function (data) {
                var all = {text:'--全部--',value:''};
                data.unshift(all);
                var items =data;
                BUI.use(["bui/select"], function (Select) {
                    select = new Select.Select({
                        render: "#s_rulealias",
                        valueField: "#hide_rulealias",
                        multipleSelect: false,
                        items: items
                    });
                });
                select.render();
            }
        });

        //设置入驻时间选择器
        BUI.use('bui/calendar', function (Calendar) {
            var startPicker = new Calendar.DatePicker({
                trigger: '#s_enter_time_start',
                showTime: true,
                autoRender: true
            });
            var startPicker = new Calendar.DatePicker({
                trigger: '#s_enter_time_end',
                showTime: true,
                autoRender: true
            });
        });


        DateTimeRange($("#date_range_search"));

        //设置表格属性
        BUI.use(['bui/grid', 'bui/data'], function (Grid, Data) {
            var Grid = Grid;
            var store = new Data.Store({
                url: "<?= Yii::$app->urlManager->createUrl('point/record/point-list-data') ?>",
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
                root: 'records',//数据返回字段,支持深成次属性root : 'data.records',
                totalProperty: 'totalCount',//总计字段
                pageSize: <?= yii::$app->params['page_size'] ?>
            });

            //定义表格title
            var grid = new Grid.Grid({
                render: '#record_grid',
                idField: 'record_id', //自定义选项 id 字段
                selectedEvent: 'click',
                columns: [
                    {title: '编号', dataIndex: 'rdid', width: 80},
                    {title: '用户名', dataIndex: 'username', width: 100},
                    {title: '频道', dataIndex: 'channelname', width: 100},
                    {title: '行为', dataIndex: 'rulealias', width: 300},
                    {title: '积分值', dataIndex: 'point', width: 80},
                    {
                        title: '创建时间',
                        dataIndex: 'created_at',
                        width: 130,
                        renderer: function (v) {
                            return v ? BUI.Date.format(new Date(v * 1000), 'yyyy-mm-dd HH:MM:ss') : '';
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
            $("#record_grid").data("BGrid", grid);
        });

        //数据加载
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