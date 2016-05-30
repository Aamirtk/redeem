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
    <script>
        var _PRIVILEGE = "<?= $privilege ?>";
        var _ACTMARK="list";
        var _BASE_LIST_URL = '';
        if(_PRIVILEGE == 'info'){
            _BASE_LIST_URL =  "<?= Yii::$app->urlManager->createUrl('vip/vip/list-info?ajax=1') ?>";
        }else if(_PRIVILEGE == 'finance'){
            _BASE_LIST_URL =  "<?= Yii::$app->urlManager->createUrl('vip/vip/list-finance?ajax=1') ?>";
        }else if(_PRIVILEGE == 'operate'){
            _BASE_LIST_URL =  "<?= Yii::$app->urlManager->createUrl('vip/vip/list-operate?ajax=1') ?>";
        }else{
            _BASE_LIST_URL =  "<?= Yii::$app->urlManager->createUrl('user/user/list?ajax=1') ?>";
        }
    </script>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="search-bar form-horizontal well">
            <form id="vipsearch" class="form-horizontal">
                <div class="row">
                    <div class="control-group span12">
                        <label class="control-label">时间范围：</label>
                        <div class="controls">
                            <input type="text" class="calendar calendar-time" name="uptimeStart"><span> - </span><input name="uptimeEnd" type="text" class="calendar calendar-time">
                        </div>
                    </div>
                    <div class="control-group span10">
                        <label class="control-label">会员等级：</label>
                        <div class="controls" >
                            <select name="grouptype" id="grouptype">
                                <option value="">请选择</option>
                                <?php foreach ($groupList as $key => $val): ?>
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
                                <?php foreach ($checkSatus as $key => $name): ?>
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
                                <?php foreach ($companyList as $key => $name): ?>
                                    <option value="<?= $key ?>"><?= $name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group span10">
                        <button type="button" id="btnSearch" class="button button-primary"  onclick="searchVips()">查询</button>
                    </div>
                </div>
            </form>
        </div>
        <?php if($privilege == 'info'):?>
            <div class="bui-grid-tbar">
                <a class="button button-primary page-action" title="添加会员"  href="#" data-href="<?= Yii::$app->urlManager->createUrl('vip/vip/add') ?>" id="addVip1">会员录入</a>
                <a class="button button-danger" href="javascript:void(0);" onclick="checkDeleteVips()">批量删除</a>
            </div>
        <?php endif ?>
        <div id="vips_grid">
        </div>
    </div>
</div>
<script>
    $(function () {
        BUI.use('common/page');
        BUI.use('bui/form', function (Form) {
            var form = new Form.HForm({
                srcNode: '#vipsearch'
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
                params: { privilege : _PRIVILEGE
                },
                root: 'vipList',//数据返回字段,支持深成次属性root : 'data.records',
                totalProperty: 'totalCount',//总计字段
                pageSize: 10// 配置分页数目,
            });
            var grid = new Grid.Grid({
                render: '#vips_grid',
                idField: 'id', //自定义选项 id 字段
                selectedEvent: 'click',
                columns: [
                    {title: '会员编号', dataIndex: 'id', width: 80},
                    {title: '用户注册ID', dataIndex: 'username', width: 90},
                    {title: '客户名称', dataIndex: 'name', width: 90},
                    {title: '缴纳金额', dataIndex: 'pay', width: 80},
                    {title: '售价', dataIndex: 'price', width: 80},
                    {title: '会员等级', dataIndex: 'vipgroup', width: 80},
                    {title: '联系人', dataIndex: 'contact', width: 80},
                    {title: '联系方式', dataIndex: 'phone', width: 100},
                    {title: '销售员', dataIndex: 'inputer', width: 80},
                    {title: '所属会员', dataIndex: 'inputer_compamy', width: 120},
                    {title: '录入时间', dataIndex: 'created_at', width: 130},
                    {
                        title: '操作',
                        width: 400,
                        renderer: function (v, obj) {
                            if (_PRIVILEGE == 'add') { //查看入口
                                return "<a class='button button-info' title='会员信息' href='javascript:void(0);' onclick='showVipBrief(" + obj.id + "," + obj.check_status + ")'>查看</a>";
                            }
                            else if (_PRIVILEGE == 'info') {//销售，录入人员入口
                                var dom = '';
                                dom += "<a class='button button-info' title='会员信息' href='javascript:void(0);' onclick='showVipBrief(" + obj.id + "," + obj.check_status + ")'>查看</a>";
                                //草稿状态或者财务审核驳回状态，可以编辑
                                if(obj.check_status == 0 || obj.check_status == 2){
                                    dom += " <a class='button button-primary page-action'  title='编辑会员信息' href='/vip/vip/update/?mid=" + obj.id + "' data-href='/vip/vip/update/?mid=" + obj.id + "'>修改</a>";
                                }
                                //运营审核通过，可以编辑行业分类
                                if(obj.check_status == 5){
                                    dom += " <a class='button button-primary page-action'  title='编辑会员行业信息' href='/vip/vip/edit-industries/?u=" + obj.username + "' data-href='/vip/vip/edit-industries/?u=" + obj.username + "'>编辑行业</a>";
                                }
                                dom += " <a class='button button-danger' onclick='checkDeleteVips(" + obj.id + ")'>删除</a>";
                                return dom;
                            }
                            else if (_PRIVILEGE == 'finance') {//财务审核入口
                                return "<a class='button button-primary' title='会员信息' href='javascript:void(0);' onclick='FinanceCheck(" + obj.id + ")'>查看</a>";
                            }
                            else if (_PRIVILEGE == 'operate') {//运营审核入口
                                return "<a class='button button-primary' title='会员信息' href='javascript:void(0);' onclick='OperateCheck(" + obj.id + ")'>查看</a>";
                            }
                            else {
                                return "<a class='button button-info' title='会员信息' href='javascript:void(0);' onclick='showVipBrief(" + obj.id + "," + obj.check_status + ")'>详情</a>" +
                                " <a class='button button-primary page-action'   title='编辑会员信息' href='/vip/vip/update/?id=" + obj.id + "' data-href='/vip/vip/update/?id=" + obj.id + "'>编辑</a>" +
                                " <a class='button button-danger' onclick='checkDeleteVips(" + obj.id + ")'>删除</a>"
                            }
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
                plugins: [_ACTMARK == 'list' ? Grid.Plugins.CheckSelection : ''] // 插件形式引入多选表格
            });
            grid.render();
            $("#vips_grid").data("BGrid", grid);
            if(_PRIVILEGE == 'info'){
                grid.addColumn({
                    title: '状态',
                    dataIndex: 'checker',
                    width: 130,
                    renderer: function (v) {
                        return v.check_status;
                    }
                }, 11);
            }else if(_PRIVILEGE == 'finance'){
                grid.addColumn({
                    title: '财务审核',
                    dataIndex: 'checker',
                    width: 130,
                    renderer: function (v) {
                        return v.check_status;
                    }
                }, 11);
            }else if(_PRIVILEGE == 'operate'){
                grid.addColumn({
                    title: '运营审核',
                    dataIndex: 'checker',
                    width: 130,
                    renderer: function (v) {
                        return v.check_status;
                    }
                }, 11);

            }
            else if(_PRIVILEGE == 'add'){
                grid.addColumn({
                    title: '审核状态',
                    dataIndex: 'checker',
                    width: 130,
                    renderer: function (v) {
                        return v.check_status;
                    }
                }, 11);

            }
        });

    });
</script>

<script>
/**
 * 搜索会员,刷新列表
 */
function searchVips() {
    var search = {};
    var fields = $("#vipsearch").serializeArray();//获取表单信息
    jQuery.each(fields, function (i, field) {
        if (field.value != "") {
            search[field.name] = field.value;
        }
    });
    var store = $("#vips_grid").data("BGrid").get('store');
    var lastParams = store.get("lastParams");
    lastParams.search = search;
    store.load(lastParams);//刷新
}
/**
 * 获取过滤项
 */
function getVipGridSearchConditions() {
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
function checkDeleteVips(vipId) {
    //如果不传，表示删除勾选
    var vipIds = [];
    if (vipId) {
        vipIds.push(vipId);
    }
    else {
        vipIds = $("#vips_grid").data("BGrid").getSelectionValues();
    }
    if (vipIds.length == 0) {
        return;
    }
    BUI.use('bui/overlay', function (Overlay) {
        BUI.Message.Show({
            title: '删除提示',
            msg: '您确定要删除选中会员吗？',
            icon: 'warning',
            buttons: [
                {
                    text: '确定',
                    elCls: 'button button-primary',
                    handler: function () {
                        deleteVips(vipIds);
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
 * 删除会员
 */
function deleteVips(vipIds) {
    $.ajax({
        type: "post",
        data: {ids: vipIds},
        url: '/vip/vip/delete',
        dataType: "json",
        success: function (json) {
            if (json.result) {
                var grid = $("#vips_grid").data("BGrid");
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
 * 显示会员详情
 */
function showVipBrief(id, status) {
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
                    window.location.href = '/vip/vip/update/?mid=' + id;
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
        title: '会员信息',
        width: width,
        height: height,
        closeAction: 'destroy',
        loader: {
            url: "/vip/vip/detail",
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
        title: '会员信息',
        width: width,
        height: height,
        closeAction: 'destroy',
        loader: {
            url: "/vip/vip/finance-check",
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
        title: '会员信息',
        width: width,
        height: height,
        closeAction: 'destroy',
        loader: {
            url: "/vip/vip/operate-check",
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