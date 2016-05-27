<?php

use yii\helpers\Html;
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>用户管理</title>
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
                <div class="search-bar form-horizontal well">
                    <form id="vipsearch" class="form-horizontal" action="<?= Yii::$app->urlManager->createUrl('user/user/export') ?>" method="post">
                            <div class="row">
                                <div class="span">
                                    <label class="control-label">用户信息：</label>
                                    <div class="controls">
                                        <div id="s_condition" >
                                            <input type="hidden" id="hide_condition" value="" name="hide_condition">
                                        </div>
                                    </div>
                                </div>
                                <div class="span">
                                    <div class="controls">    
                                        <input id="s_condition_value" name="s_condition_value" class="" type="text"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="span">
                                    <label class="control-label">会员特权：</label>
                                    <div class="controls">
                                        <div id="s_group" >
                                            <input type="hidden" id="s_group_value" value="" name="s_group_value">
                                        </div>
                                    </div>
                                </div>
                                <div class="span">
                                    <label class="control-label">认证状态：</label>
                                    <div class="controls">
                                        <div id="s_auth" >
                                            <input type="hidden" id="s_auth_value" value="" name="s_auth_value">
                                        </div>
                                    </div>
                                </div>
                                <div class="span">  
                                    <label class="control-label">账户状态：</label>
                                    <div class="controls">
                                        <div id="s_status" >
                                            <input type="hidden" id="s_status_value" value="" name="s_status_value">
                                        </div>
                                    </div>
                                </div>
                                <div class="span">
                                    <a class="button button-primary" href="javascript:void(0);" onclick="searchUsers()">搜索</a>
                                    <input type="submit" class="button button-primary" onclick="exportUsers()"  value="导出">
                                </div>

                            </div>
                            <!-- <div class="row">
                               <div class="span">    
                                    <label class="control-label">人才状态：</label>
                                    <div class="controls">
                                        <div id="s_rc" >
                                            <input type="hidden" id="s_rc_value" value="" name="s_rc_value">
                                        </div>
                                    </div>
                                </div>                               
                                <div class="span">
                                    <label class="control-label">店铺状态：</label>
                                    <div class="controls">
                                        <div id="s_shop" >
                                            <input type="hidden" id="s_shop_value" value="" name="s_shop_value">
                                        </div>
                                    </div>
                            </div>-->                                       
                    </form>
                    <div id="users_grid"></div>
                </div>
            </div>
        </div>
        <!-- script start -->
        <script type="text/javascript">
            /**
             * 搜索
             */
            function searchUsers() {
                var search = getConditions();
                var store = $("#users_grid").data("BGrid").get('store');
                var params = {};
                params.search = search;
                params.pageIndex = 0;//重置第一页
                params.start = 0;//重置第一页
                store.load(params);//刷新
            }
            /**
             * 导出
             */
            function exportUsers() {
                BUI.Message.Alert('正在导出前1000条搜索结果,请稍候','success');
            }
              
            /**
             * 获取过滤项
             */
            function getConditions() {
                var search = {};
                var s_condition = $("#hide_condition").val();
                var s_condition_value = $("#s_condition_value").val();
                var s_group_value = $("#s_group_value").val();
                var s_status_value = $("#s_status_value").val();
                var s_auth_value = $("#s_auth_value").val();
                if (s_condition != ""&&s_condition_value!="") {
                    search.s_condition = s_condition;
                    search.s_condition_value = s_condition_value;
                }
                if (s_group_value != "") {
                    search.group_id = s_group_value;
                }
                if (s_status_value != "") {
                    search.status = s_status_value;
                }
                if (s_auth_value != "") {
                    search.auth_type = s_auth_value;
                }
                return search;
            }
        $(function () {
            BUI.use('common/page');
            //设置表格属性
            BUI.use(['bui/grid', 'bui/data'], function (Grid, Data) {
                var Grid = Grid;
                var store = new Data.Store({
                    url: "<?= Yii::$app->urlManager->createUrl('user/user/list') ?>",
                    proxy: {//设置请求相关的参数
                        method: 'post',
                        dataType: 'json', //返回数据的类型
                        limitParam: 'pageSize', //一页多少条记录
                        pageIndexParam: 'page', //页码
                        //startParam : 'startNum' //起始记录
                    },
                    autoLoad: true, //自动加载数据
                    root: 'users', //数据返回字段,支持深成次属性root : 'data.records',
                    totalProperty: 'totalCount', //总计字段
                    pageSize: <?= yii::$app->params['page_size'] ?>
                });

                //定义表格title
                var grid = new Grid.Grid({
                    render: '#users_grid',
                    idField: 'username', //自定义选项 id 字段
                    selectedEvent: 'click',
                    columns: [
                        {title: 'ID', dataIndex: 'username', width : 80},
                        {title: '昵称', dataIndex: 'nickname', width : 100},
                        {title: '手机号', dataIndex: 'mobile', width : 100},
                        {title: '注册时间', dataIndex: 'create_time', width : 80,
                            renderer: function (v) {
                                return v>0 ? BUI.Date.format(new Date(v * 1000), 'yyyy-mm-dd') : '';
                            }
                        },
                        {title: '当前服务', dataIndex: 'group_name', width : 80},
                        {title: '服务到期日', dataIndex: 'valid_end', width : 80,
                            renderer: function (v) {
                                return v>0 ? BUI.Date.format(new Date(v * 1000), 'yyyy-mm-dd') : '无限期';
                            }
                        },
                        {title: '认证', dataIndex: 'auth', width : 80},
                        {title: '人才', dataIndex: 'rc', width : 80},
                        {title: '店铺', dataIndex: 'shop', width : 80},
                        {title: '最近登录', dataIndex: 'last_login_time', width : 80,
                            renderer: function (v) {
                                return v>0 ? BUI.Date.format(new Date(v * 1000), 'yyyy-mm-dd') : '';
                            }
                        },
                        {title: '状态', dataIndex: 'status', with : 80,
                            renderer: function (v) {
                                return v==1?'已激活':'未激活';
                            }},
                        {title: '操作', width : 300,
                            renderer: function (v, obj) {
                                return "<a class='button button-primary' href='javascript:void(0)' onclick='showMessage()'>修改</a> " +
                                        "<a class='button button-danger' href='javascript:void(0)' onclick='showMessage()'>删除</a> " +
                                        "<a class='button button-info' href='javascript:void(0)' onclick='showMessage()'>服务记录</a> ";
                            }
                        }
                    ],
                    loadMask: true, //加载数据时显示屏蔽层
                    store: store,
                    bbar: {
                        // pagingBar:表明包含分页栏
                        pagingBar: true
                    },
                    plugins: [Grid.Plugins.CheckSelection] // 插件形式引入多选表格
                });
                grid.render();
                $("#users_grid").data("BGrid", grid);
            });
            BUI.use('bui/select', function (Select) {
                var items = [
                    {text: '按昵称', value: 'nickname'},
                    {text: '按手机号', value: 'mobile'},
                    {text: '按用户id', value: 'username'},
                    {text: '按邮箱', value: 'email'}
                ],
                        select = new Select.Select({
                            render: '#s_condition',
                            valueField: '#hide_condition',
                            items: items
                        });
                select.render();
            });
            BUI.use('bui/select', function (Select) {
                var items = [
                    {text: '全部', value: ''},
                    {text: '个人认证', value: '1'},
                    {text: '企业认证', value: '2'},
                ],
                        select = new Select.Select({
                            render: '#s_auth',
                            valueField: '#s_auth_value',
                            items: items
                        });
                select.render();
            });
            BUI.use('bui/select', function (Select) {
                var items = [
                    {text: '全部', value: ''},
                    {text: '未入驻', value: '1'},
                    {text: '已入驻', value: '2'}
                ],
                        select = new Select.Select({
                            render: '#s_rc',
                            valueField: '#s_rc_value',
                            items: items
                        });
                select.render();
            });
            BUI.use('bui/select', function (Select) {
                var items = [
                    {text: '全部', value: ''},
                    {text: '未入驻', value: '1'},
                    {text: '已入驻', value: '2'}
                ],
                        select = new Select.Select({
                            render: '#s_shop',
                            valueField: '#s_shop_value',
                            items: items
                        });
                select.render();
            });
            BUI.use('bui/select', function (Select) {
                var items = [
                    {text: '全部', value: ''},
                    {text: '已激活', value: '1'},
                    {text: '未激活', value: '2'}
                ],
                        select = new Select.Select({
                            render: '#s_status',
                            valueField: '#s_status_value',
                            items: items
                        });
                select.render();
            });
            $.ajax({
                type: "GET",
                url: "/vip/group/get-groups",
                cache: false,
                dataType: "json",
                success: function (data) {
                    var items = data;
                    BUI.use(["bui/select"], function (Select) {
                        select = new Select.Select({
                            render: "#s_group",
                            valueField: "#s_group_value",
                            multipleSelect: false,
                            items: items
                        });
                    });
                    select.render();
                }
            });
        });
        function  showMessage()
        {
            alert('后期开发');
        }
        </script>
    </body>
</html>