<?php
use yii\helpers\Html;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户成长体系管理--频道管理</title>
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
        <div class="row">
            <div class="span">
                <label class="control-label">编号：</label>
                <div class="controls">
                    <input id="chid" class="" type="text"/>
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
        <div class="row">
            <div class="span">
                <a class="button button-primary" href="javascript:void(0);" onclick="searchTalents()">搜索</a>
                <a class="button button-info" href="javascript:void(0);" onclick="searchTalents('all')">全部</a>
            </div>
        </div>
    </div>
    <div class="bui-grid-tbar">
        <a class="button button-primary" href='javascript:void(0);' onclick="activateChannel()" >激活频道</a>
        <a class="button button-primary" href="<?= Yii::$app->urlManager->createUrl('point/channel/add') ?>">新增频道</a>
    </div>
    <div id="channels_grid">
    </div>
</div>
<?php require yii::$app->getBasePath() . '/modules/point/views/channel/channel_activate.php'; ?>
<?php require yii::$app->getBasePath() . '/modules/point/views/channel/channel_edit.php'; ?>
<?php require yii::$app->getBasePath() . '/modules/point/views/channel/channel_info.php'; ?>
<?php require yii::$app->getBasePath() . '/modules/point/views/channel/channel_pie_ring.php'; ?>
<script type="text/javascript">
    top.topManager.setPageTitle("频道管理");
    /**
     * 刷新列表
     */
    function refreshTalentGrid(condition = '') {
        var search = getTalentGridSearchConditions();
        var store = $("#channels_grid").data("BGrid").get('store');
        var params = {};
        params.search = search;
        params.pageIndex = 0;//重置第一页(解决翻页搜索为空的问题）
        params.start = 0;//重置第一页(解决翻页搜索为空的问题）
        store.load(params);//刷新
    }
    /**
     * 搜索项目
     */
    function searchTalents(condition = '') {
        if(condition == 'all'){
            var search = {};
        }else{
            var search = getTalentGridSearchConditions();
        }
        var store = $("#channels_grid").data("BGrid").get('store');
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
        var chid = $("#chid").val();
        var s_chid = $("#hide_channels").val();
        if (s_chid != "") {
            search.s_chid = s_chid;
        }
        if (chid != "") {
            search.chid = chid;
        }
        return search;
    }

    /**
     * 删除提示
     */
    function checkDeleteChannel(id,name) {
        //如果不传，表示删除勾选
        if(!id || typeof(id) =="undefined" )
        {
            return;
        }

        BUI.use('bui/overlay', function (Overlay) {
            BUI.Message.Show({
                title: '删除提示',
                msg: '您确定要删 《'+name+'频道》 吗？',
                icon: 'warning',
                buttons: [
                    {
                        text: '确定',
                        elCls: 'button button-primary',
                        handler: function () {
                            deleteChannel(id);
                            this.close();
                        }
                    },
                    {
                        text: '取消',
                        elCls: 'button',
                        handler: function () {
                            this.close();
                        }
                    }
                ]
            });
        });
    }


    /**
     * 删除频道
     */
    function deleteChannel(chid) {
        $.ajax({
            type: "post",
            data: {chid: chid},
            url: "<?= Yii::$app->urlManager->createUrl('point/channel/delete') ?>",
            dataType: "json",
            success: function (json) {
                if (json.result) {
                    var grid = $("#channels_grid").data("BGrid");
                    grid.clearSelection();
                    grid.get('store').load();
                    BUI.Message.Alert('删除成功', 'success');
                }
                else {
                    BUI.Message.Alert('删除失败', 'error');
                }
            }
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

        //设置表格属性
        BUI.use(['bui/grid', 'bui/data'], function (Grid, Data) {
            var Grid = Grid;
            var store = new Data.Store({
                url: "<?= Yii::$app->urlManager->createUrl('point/channel/list') ?>",
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
                root: 'channels',//数据返回字段,支持深成次属性root : 'data.records',
                totalProperty: 'totalCount',//总计字段
                pageSize: <?= yii::$app->params['page_size'] ?>
            });
            var grid = new Grid.Grid({
                render: '#channels_grid',
                width:'100%',
                idField: 'chid', //自定义选项 id 字段
                selectedEvent: 'click',
                columns: [
                    {title: '编号', dataIndex: 'chid', elCls : 'center', width: 80},
                    {title: '频道名称', dataIndex: 'channelname', elCls : 'center', width: 300},
                    {title: '平台配比率', dataIndex: 'distribute', elCls : 'center', width: 200},
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
                            return "<a class='button button-primary' href='javascript:void(0);' onclick=\"showChannelDetails('" + obj.chid + "')\">编辑</a>&nbsp;&nbsp;"
                                + " <a class='button button-info' href='javascript:void(0);' onclick=\"showChannelsInfo('"+ obj.chid + "')\">查看</a>&nbsp;&nbsp;"
                                + "<a class='button button-danger' href='javascript:void(0);' onclick=\"checkDeleteChannel('" + obj.chid + "','" + obj.channelname + "')\">删除</a>";
                        }
                    }
                ],
                loadMask: true, //加载数据时显示屏蔽层
                store: store,
                // 底部工具栏
                bbar: {
                    pagingBar: true
                },
                //plugins: [Grid.Plugins.CheckSelection] // 插件形式引入多选表格
            });
            grid.render();
            $("#channels_grid").data("BGrid", grid);

            var channelsStore = new Data.Store({
                autoLoad:true,
                pageSize:5,
                data:[]
            });

            var channelsGrid = new Grid.Grid({
                render:'#channel_info_grid',
                idField : 'chid', //自定义选项 id 字段
                selectedEvent : 'click',
                emptyDataTpl:"<div>无数据</div>",
                columns : [
                    {title : '行为名称',dataIndex : 'rulealias',width:200},
                    {title : '积分值',dataIndex : 'point',width:100},
                    {title: '状态', dataIndex: 'available', width: 100,
                        renderer: function (v) {
                            return v=='1'?'已启用':'未启用';
                        }
                    },
                ],
                store: channelsStore,
                bbar:{
                    pagingBar:true
                },
            });
            channelsGrid.render();
            $('#channel_info_grid').data("BGrid", channelsGrid);
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