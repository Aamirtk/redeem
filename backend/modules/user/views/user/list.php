<?php
use yii\helpers\Html;
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>用户信息列表</title>
    <?= Html::cssFile('@web/assets/css/dpl-min.css') ?>
    <?= Html::cssFile('@web/assets/css/bui-min.css') ?>
    <?= Html::cssFile('@web/assets/css/page-min.css') ?>
    <?= Html::jsFile('@web/Js/jquery.js') ?>
    <?= Html::jsFile('@web/assets/js/bui-min.js') ?>
    <?= Html::jsFile('@web/Js/common/common.js?v=1.0.0') ?>
    <style>
        .user_avatar {
            height: auto;
            width: 80px;
            margin: 10px auto;
        }
    </style>
    <script>
        _BASE_LIST_URL =  "<?php echo yiiUrl('user/user/list?ajax=1') ?>";
    </script>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="search-bar form-horizontal well">
            <form id="usersearch" class="form-horizontal">
                <div class="row">
                    <div class="control-group span12">
                        <label class="control-label">时间范围：</label>
                        <div class="controls">
                            <input type="text" class="calendar calendar-time" name="uptimeStart"><span> - </span><input name="uptimeEnd" type="text" class="calendar calendar-time">
                        </div>
                    </div>
                    <div class="control-group span10">
                        <label class="control-label">用户等级：</label>
                        <div class="controls" >
                            <select name="grouptype" id="grouptype">
                                <option value="">请选择</option>
                                <?php foreach ([] as $key => $val): ?>
                                    <option value="<?= $val['id'] ?>"><?= $val['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group span12">
                        <label class="control-label">销售员：</label>
                        <div class="controls">
                            <input type="text" class="control-text" name="inputer" id="inputer">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="control-group span12">
                        <label class="control-label">用户：</label>
                        <div class="controls" data-type="city">
                            <select name="filtertype" id="filtertype">
                                <option value="">请选择</option>
                                <option value="1">用户注册ID</option>
                                <option value="2">用户名称</option>
                            </select>
                        </div>
                        <div class="controls">
                            <input type="text" class="control-text" name="filtercontent" id="name">
                        </div>
                    </div>
                    <div class="control-group span10">
                        <label class="control-label">审核状态：</label>
                        <div class="controls" >
                            <select name="checkstatus" id="checkstatus">
                                <option value="">请选择</option>
                                <?php foreach ([] as $key => $name): ?>
                                    <option value="<?= $key ?>"><?= $name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group span10">
                        <label class="control-label">所属公司：</label>
                        <div class="controls" >
                            <select name="inputercompany" id="inputercompany">
                                <option value="">请选择</option>
                                <?php foreach ([] as $key => $name): ?>
                                    <option value="<?= $key ?>"><?= $name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group span10">
                        <button type="button" id="btnSearch" class="button button-primary"  onclick="searchUsers()">查询</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="bui-grid-tbar">
            <a class="button button-primary page-action" title="添加用户"  href="#" data-href="<?= Yii::$app->urlManager->createUrl('user/user/add') ?>" id="addUser1">用户录入</a>
            <a class="button button-danger" href="javascript:void(0);" onclick="checkDeleteUsers()">批量删除</a>
        </div>
        <div id="users_grid">
        </div>
    </div>
</div>

<div id="reason_content" style="display: none" >
    <form id="reason_form" class="form-horizontal">
        <div class="control-group" >
            <div class="control-group" style="height: 80px">
                <label class="control-label"></label>
                <div class="controls ">
                    <textarea class="input-large" id="reason_text" style="height: 60px" data-rules="{required : true}" type="text"></textarea>
                </div>
            </div>
            <div class="control-group style="">
            <label class="control-label"></label>
            <div class="controls">
                <span><b>提示：</b>输入字数不能超过50个字</span>
            </div>
        </div>
    </form>
</div>

<script>
    $(function () {
        BUI.use('common/page');
        BUI.use('bui/form', function (Form) {
            var form = new Form.HForm({
                srcNode: '#usersearch'
            });
            form.render();
        });
        BUI.use('bui/calendar', function (Calendar) {
            var datepicker = new Calendar.DatePicker({
                trigger: '.calendar-time',
                showTime: true,
                autoRender: true
            });
        });
        //设置表格属性
        BUI.use(['bui/grid', 'bui/data'], function (Grid, Data) {
            var Grid = Grid;
            var store = new Data.Store({
                url: _BASE_LIST_URL,
                proxy: {//设置请求相关的参数
                    method: 'post',
                    dataType: 'json', //返回数据的类型
                    limitParam: 'pageSize', //一页多少条记录
                    pageIndexParam: 'page' //页码
                },
                autoLoad: true, //自动加载数据
                params: {
                },
                root: 'userList',//数据返回字段,支持深成次属性root : 'data.records',
                totalProperty: 'totalCount',//总计字段
                pageSize: 10// 配置分页数目,
            });
            var grid = new Grid.Grid({
                render: '#users_grid',
                idField: 'id', //自定义选项 id 字段
                selectedEvent: 'click',
                columns: [
                    {title: '用户编号', dataIndex: 'uid', width: 80},
                    {title: '微信昵称', dataIndex: 'nick', width: 90, elCls : 'center',},
                    {title: '真实姓名', dataIndex: 'name', width: 90, elCls : 'center',},
                    {
                        title: '微信头像',
                        width: 120,
                        elCls : 'center',
                        renderer: function (v, obj) {
                            return "<img class='user_avatar' src='"+ obj.avatar +"'>";
                        }
                    },
                    {title: '手机号码', dataIndex: 'mobile', width: 90},
                    {title: '积分', dataIndex: 'points', width: 80, elCls : 'center'},
                    {title: '微信公众号', dataIndex: 'wechat', width: 120},
                    {title: '用户类型', dataIndex: 'user_type', width: 80, elCls : 'center'},
                    {title: '用户状态', dataIndex: 'user_status', width: 80, elCls : 'center'},
                    {title: '录入人员', dataIndex: 'inputer', width: 80, elCls : 'center'},
                    {title: '录入时间', dataIndex: 'create_at', width: 130, elCls : 'center'},
                    {
                        title: '操作',
                        width: 300,
                        renderer: function (v, obj) {
                            return "<a class='button button-info' title='用户信息' href='javascript:void(0);' onclick='showUserBrief(" + obj.id + "," + obj.check_status + ")'>查看</a>" +
                            " <a class='button button-edit' onclick='enableUser(" + obj.id + ")'>启用</a>";
                            " <a class='button button-danger' onclick='disableUser(" + obj.id + ")'>禁用</a>";
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
                plugins: Grid.Plugins.CheckSelection,// 插件形式引入多选表格
            });
            grid.render();
            $("#users_grid").data("BGrid", grid);

        });

    });
</script>

<script>
/**
 * 搜索用户,刷新列表
 */
function searchUsers() {
    var search = {};
    var fields = $("#usersearch").serializeArray();//获取表单信息
    jQuery.each(fields, function (i, field) {
        if (field.value != "") {
            search[field.name] = field.value;
        }
    });
    var store = $("#users_grid").data("BGrid").get('store');
    var lastParams = store.get("lastParams");
    lastParams.search = search;
    store.load(lastParams);//刷新
}
/**
 * 获取过滤项
 */
function getUserGridSearchConditions() {
    var search = {};
    var upusername = $("#upusername").val();
    if (upusername != "") {
        search.upusername = upusername;
    }
    var username = $("#username").val();
    if (username != "") {
        search.username = username;
    }
    return search;
}
/**
 * 删除提示
 */
function checkDeleteUsers(userId) {
    //如果不传，表示删除勾选
    var userIds = [];
    if (userId) {
        userIds.push(userId);
    }
    else {
        userIds = $("#users_grid").data("BGrid").getSelectionValues();
    }
    if (userIds.length == 0) {
        return;
    }
    BUI.use('bui/overlay', function (Overlay) {
        BUI.Message.Show({
            title: '删除提示',
            msg: '您确定要删除选中用户吗？',
            icon: 'warning',
            buttons: [
                {
                    text: '确定',
                    elCls: 'button button-primary',
                    handler: function () {
                        deleteUsers(userIds);
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
 * 删除用户
 */
function deleteUsers(userIds) {
    $.ajax({
        type: "post",
        data: {ids: userIds},
        url: '/user/user/delete',
        dataType: "json",
        success: function (json) {
            if (json.result) {
                var grid = $("#users_grid").data("BGrid");
                grid.clearSelection();
                grid.get('store').load();//刷新
                BUI.Message.Alert('删除成功', 'success');
            }
            else {
                BUI.Message.Alert(json.message, 'error');
            }
        }
    });
}

/**
 * 显示用户详情
 */
function showUserBrief(id, status) {
    var width = 700;
    var height = 600;
    var Overlay = BUI.Overlay;
    var buttons = [];
    if(_PRIVILEGE == 'info' && (status == 0 || status == 2)){
        buttons =
        [
            {
                text:'确认',
                elCls : 'button button-success',
                handler : function(){
                    this.close();
                }
            },
            {
                text:'修改',
                elCls : 'button button-primary',
                handler : function(){
                    window.location.href = '/user/user/update/?mid=' + id;
                }
            }
        ];
    }else{
        buttons =
            [
                {
                    text:'确认',
                    elCls : 'button button-success',
                    handler : function(){
                        this.close();
                    }
                },
            ];
    }
    dialog = new Overlay.Dialog({
        title: '用户信息',
        width: width,
        height: height,
        closeAction: 'destroy',
        loader: {
            url: "/user/user/detail",
            autoLoad: true, //不自动加载
            params: {id: id},//附加的参数
            lazyLoad: false, //不延迟加载
        },
        buttons: buttons,
        mask: false
    });
    dialog.show();
    dialog.get('loader').load({id: id});
}

/**
 * 显示财务审核详情
 */
function FinanceCheck(id) {
    var width = 800;
    var height = 700;
    var Overlay = BUI.Overlay;
    dialog = new Overlay.Dialog({
        title: '用户信息',
        width: width,
        height: height,
        closeAction: 'destroy',
        loader: {
            url: "/user/user/finance-check",
            autoLoad: true, //不自动加载
            params: {id: id},//附加的参数
            lazyLoad: false, //不延迟加载
        },
        buttons:[],
        mask: true
    });
    dialog.show();
    dialog.get('loader').load({id: id});
}
/**
 * 显示运营审核详情
 */
function OperateCheck(id) {
    var width = 800;
    var height = 700;
    var Overlay = BUI.Overlay;
    dialog = new Overlay.Dialog({
        title: '用户信息',
        width: width,
        height: height,
        closeAction: 'destroy',
        loader: {
            url: "/user/user/operate-check",
            autoLoad: true, //不自动加载
            params: {id: id},//附加的参数
            lazyLoad: false, //不延迟加载
        },
        buttons:[],
        mask: true
    });
    dialog.show();
    dialog.get('loader').load({id: id});
}


</script>

</body>
</html>