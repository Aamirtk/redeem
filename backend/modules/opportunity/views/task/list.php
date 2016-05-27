<?php
use yii\helpers\Html;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>商机库--任务推送记录</title>
    <?= Html::cssFile('@web/assets/css/bui-min.css') ?>
    <?= Html::cssFile('@web/assets/css/dpl-min.css') ?>
    <?= Html::cssFile('@web/assets/css/page-min.css') ?>
    <?= Html::jsFile('@web/Js/jquery.js') ?>
    <?= Html::jsFile('@web/assets/js/bui-min.js') ?>
    <?= Html::jsFile('@web/Js/common/daterange.js') ?>
</head>
<body>
<div class="container">
    <div class="search-bar form-horizontal well">
        <form id="searchForm" class="form-horizontal" style="outline: medium none;" aria-disabled="false" aria-pressed="false" action="" autocomplete="off">
            <div class="row">
                <div class="span">
                    <label class="control-label" style="width: auto;">旧版任务编号（5位）：</label>
                    <div class="controls">
                        <input id="s_task_id" name="s_task_id" class="" type="text"/>
                    </div>
                </div>
                <div class="span">
                    <label class="control-label" style="width: auto;">新版任务编号（13位）：</label>
                    <div class="controls">
                        <input id="s_task_wid" name="s_task_wid" class="" type="text"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="span" id="date_range_search">
                    <label class="control-label">商机推送时间：</label>
                    <input v-role="date-range-nolimit" type="radio" name="enter_time_group" checked="checked"/><span>不限</span>
                    <input v-role="date-range-today" type="radio" name="enter_time_group"/><span>今天</span>
                    <input v-role="date-range-yesterday" type="radio" name="enter_time_group"/><span>昨天</span>
                    <input v-role="date-range-week" type="radio" name="enter_time_group"/><span>本周</span>
                    <input v-role="date-range-month" type="radio" name="enter_time_group"/><span>本月</span>
                    <input v-role="date-range-start" id="s_enter_time_start" name="s_enter_time_start" type="text" class="calendar calendar-time"/>至
                    <input v-role="date-range-end" id="s_enter_time_end" name="s_enter_time_end" type="text" class="calendar calendar-time"/>
                </div>
                <div class="span">
                    <label class="control-label">结果排序：</label>
                    <select id="s_order_key" name="s_order_key" onchange="searchResults(this);">
                        <option value="id" selected="selected">ID</option>
                        <option value="task_id">任务编号</option>
                        <option value="recommend_count">推送会员数量</option>
                    </select>
                    <select id="s_order_direction" name="s_order_direction" onchange="searchResults(this);">
                        <option value="desc" selected="selected">降序</option>
                        <option value="asc">升序</option>
                    </select>
                </div>
                <div class="span">
                    <a class="button button-primary" href="javascript:void(0);" onclick="resetSearchForm()">重置</a>
                    <a class="button button-primary" href="javascript:void(0);" onclick="searchResults()">搜索</a>
                </div>
            </div>
        </form>
    </div>
    <div class="bui-grid-tbar">
        <a class="button button-primary" onclick="exportCsv()" style="float: right;">导出</a>
    </div>
    <div id="grid">
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#s_task_id,#s_task_wid').bind('keypress', function (event) {
            if (event.keyCode == "13") {
                searchResults();
            }
        });
    });

    function resetSearchForm() {
        $('#searchForm')[0].reset();
        searchResults();
    }

    /**
     * 搜索项目
     */
    function searchResults() {
        var search = getGridSearchConditions();
        var store = $("#grid").data("BGrid").get('store');
        var params = {};
        params.search = search;
        params.pageIndex = 0;
        params.start = 0;
        store.load(params);
    }

    function exportCsv() {
        var search = getGridSearchConditions();
        var task_id = '';
        if (search.task_id != '' && search.task_id != undefined) {
            task_id = search.task_id;
        }
        var task_wid = '';
        if (search.task_wid != '' && search.task_wid != undefined) {
            task_wid = search.task_wid;
        }
        var created_range_start = '';
        if (search.created_range_start != "" && search.created_range_start != undefined) {
            created_range_start = search.created_range_start;
        }
        var created_range_end = '';
        if (search.created_range_end != "" && search.created_range_end != undefined) {
            created_range_end = search.created_range_end;
        }
        var url = "/opportunity/task/export" +
                    "?task_id=" + task_id +
                    "&task_wid=" + task_wid +
                    "&created_range_start=" + created_range_start +
                    "&created_range_end=" + created_range_start +
                    "&order_key=" + search.order_key +
                    "&order_direction=" + search.order_direction;
        window.open(url, '_blank');
    }

    /**
     * 获取过滤项
     */
    function getGridSearchConditions() {
        var search = {};
        var task_id = $.trim($("#s_task_id").val());
        var task_wid = $.trim($("#s_task_wid").val());
        var createdRangeStart = $("#s_enter_time_start").val();
        var createdRangeEnd = $("#s_enter_time_end").val();
        if (task_id != "") {
            search.task_id = task_id;
        }
        if (task_wid != "") {
            search.task_wid = task_wid;
        }
        if (createdRangeStart != "") {
            search.created_range_start = createdRangeStart;
        }
        if (createdRangeEnd != "") {
            search.created_range_end = createdRangeEnd;
        }
        search.order_key = $("#s_order_key").val();
        search.order_direction = $("#s_order_direction").val();
        return search;
    }

    /**
     * 日期格式化
     * @param timestamp 时间戳
     * @returns {String}
     */
    function timeFormat(timestamp) {
        return timestamp > 0 ? BUI.Date.format(new Date(timestamp * 1000), 'yyyy-mm-dd HH:MM:ss') : '';
    }

    $(function () {
        //设置入驻时间选择器
        BUI.use('bui/calendar', function (Calendar) {
            var startPicker = new Calendar.DatePicker({
                trigger: '#s_enter_time_start',
                autoRender: true
            });
            var startPicker = new Calendar.DatePicker({
                trigger: '#s_enter_time_end',
                autoRender: true
            });
        });

        DateTimeRange($("#date_range_search"));

        //设置表格属性
        BUI.use(['bui/grid', 'bui/data'], function (Grid, Data) {
            var Grid = Grid;
            var store = new Data.Store({
                url: "/opportunity/task/list-data",
                proxy: {//设置请求相关的参数
                    method: 'post',
                    dataType: 'json', //返回数据的类型
                    limitParam: 'pageSize', //一页多少条记录
                    pageIndexParam: 'page'
                },
                autoLoad: true, //自动加载数据
                params: { //配置初始请求的其他参数
                },
                root: 'list',//数据返回字段,支持深成次属性root : 'data.records',
                totalProperty: 'totalCount',//总计字段
                pageSize: <?= yii::$app->params['page_size'] ?>
            });
            var grid = new Grid.Grid({
                render: '#grid',
                forceFit: true,
                idField: 'id', //自定义选项 id 字段
                selectedEvent: 'click',
                columns: [
                    {
                        title: 'ID',
                        dataIndex: 'id',
                        width: 80
                    },
                    {
                        title: '任务名称',
                        width: 180,
                        renderer: function (v, obj) {
                            if (obj.task) {
                                return '<a target="_blank" href="http://www.vsochina.com/index.php?do=task&task_id=' + obj.task_id + '">' + obj.task.task_title + '</a>';
                            }
                            else {
                                return '';
                            }
                        }
                    },
                    {
                        title: '发布人',
                        width: 80,
                        renderer: function (v, obj) {
                            if (obj.task) {
                                return '<a target="_blank" href="http://www.vsochina.com/talent_detail/isname/1/member_id/' + obj.task.username + '.html">' + obj.task.username + '</a>';
                            }
                            else {
                                return '';
                            }
                        }
                    },
                    {
                        title: '发布人昵称',
                        dataIndex: 'nickname',
                        width: 150
                    },
                    {
                        title: '行业一级分类',
                        dataIndex: 'indus_pid_name',
                        width: 80
                    },
                    {
                        title: '行业二级分类',
                        dataIndex: 'indus_id_name',
                        width: 80
                    },
                    {
                        title: '发布日期',
                        width: 130,
                        renderer: function (v, obj) {
                            return timeFormat(obj.task.start_time);
                        }
                    },
                    {
                        title: '任务类型',
                        dataIndex: 'model_name',
                        width: 80
                    },
                    {
                        title: '截止日期',
                        dataIndex: 'end_time',
                        width: 130,
                        renderer: function (v, obj) {
                            return timeFormat(obj.task.end_time);
                        }
                    },
                    {
                        title: '推送会员数量',
                        dataIndex: 'recommend_count',
                        width: 80
                    },
                    {
                        title: '状态',
                        dataIndex: 'task_status_alias',
                        width: 80
                    },
                    {
                        title: '推送时间',
                        dataIndex: 'created_at',
                        width: 130,
                        renderer: function (v, obj) {
                            return timeFormat(v);
                        }
                    },
                    {
                        title: '操作',
                        width: 300,
                        renderer: function (v, obj) {
                            return '<a target="_blank" href="/opportunity/record/list?task_id=' + obj.task_id + '">推送记录</a>';
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
                plugins: [Grid.Plugins.CheckSelection], // 插件形式引入多选表格
                emptyDataTpl : '<div class="centered"><img alt="Crying" src="http://img03.taobaocdn.com/tps/i3/T1amCdXhXqXXXXXXXX-60-67.png"><h2>查询的数据不存在</h2></div>'
            });
            grid.render();
            $("#grid").data("BGrid", grid);
        });
    });
</script>
</body>
</html>