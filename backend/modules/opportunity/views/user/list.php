<?php
use yii\helpers\Html;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>商机库--用户推送记录</title>
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
                    <label class="control-label">用户名称：</label>
                    <div class="controls">
                        <input id="s_username" name="s_username" class="" type="text"/>
                    </div>
                </div>
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
            </div>
            <div class="row" style="margin-top: 20px;">
                <div class="span">
                    <label class="control-label">结果排序：</label>
                    <select id="s_order_key" name="s_order_key" onchange="searchResults(this);">
                        <option value="id" selected="selected">ID</option>
                        <option value="username">用户名称</option>
                        <option value="recommend_cash">已推送金额</option>
                        <option value="recommend_count">推送条数</option>
                        <option value="view_count">已查看</option>
                        <option value="contact_count">已联系</option>
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
        $('#s_username').bind('keypress', function (event) {
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
        var username = '';
        if (search.username != '' && search.username != undefined) {
            username = search.username;
        }
        var created_range_start = '';
        if (search.created_range_start != "" && search.created_range_start != undefined) {
            created_range_start = search.created_range_start;
        }
        var created_range_end = '';
        if (search.created_range_end != "" && search.created_range_end != undefined) {
            created_range_end = search.created_range_end;
        }
        var url = "/opportunity/user/export" +
                    "?username=" + username +
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
        var username = $("#s_username").val();
        var createdRangeStart = $("#s_enter_time_start").val();
        var createdRangeEnd = $("#s_enter_time_end").val();
        if (username != "") {
            search.username = username;
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

    /**
     * 金额格式化
     * @param float cash 金额，单位元，两位小数
     * @returns float {string} 格式化后的金额，单位万元，保留一位小数
     */
    function cashFormat(cash) {
        return (cash / 10000).toFixed(1);
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
                url: "/opportunity/user/list-data",
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
                        title: '用户名',
                        dataIndex: 'username',
                        width: 80,
                        renderer: function (v, obj) {
                            return '<a target="_blank" href="http://www.vsochina.com/talent_detail/isname/1/member_id/' + v + '.html">' + v + '</a>';
                        }
                    },
                    {
                        title: '会员级别',
                        width: 80,
                        renderer: function (v, obj) {
                            if (obj.privileges) {
                                return obj.privileges.group_name ? obj.privileges.group_name : '';
                            }
                            else {
                                return '';
                            }
                        }
                    },
                    {
                        title: '金额上限（万元）',
                        width: 120,
                        renderer: function (v, obj) {
                            if (obj.privileges) {
                                return obj.privileges.business_push ? obj.privileges.business_push : 0;
                            }
                            else {
                                return 0;
                            }
                        }
                    },
                    {
                        title: '已推送金额（万元）',
                        dataIndex: 'recommend_cash',
                        width: 120,
                        renderer: function (v) {
                            return cashFormat(v);
                        }
                    },
                    {
                        title: '推送条数',
                        dataIndex: 'recommend_count',
                        width: 80
                    },
                    {
                        title: '已查看',
                        dataIndex: 'view_count',
                        width: 80
                    },
                    {
                        title: '已联系',
                        dataIndex: 'contact_count',
                        width: 80
                    },
                    {
                        title: '操作',
                        width: 300,
                        renderer: function (v, obj) {
                            return '<a target="_blank" href="/opportunity/record/list?username=' + obj.username + '">推送记录</a>';
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