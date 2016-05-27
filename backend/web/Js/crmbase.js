/**
 * Created by LuChuang on 2015/11/27.
 * CRM　企业编辑模块
 */
/**
 * 校验企业认证信息
 * @param username
 */
function ajaxCheckUser(calllback) {
    username = $("[v-role=company-username]").val();
    var company_id = $("[v-role=company-company_id]").val();
    var tel = $("[v-role=company-tel]").val();
    var name = $("[v-role=company-name]").val();
    if (username == '' || company_id == '' || tel == '' || name == '') {
        return false;
    }

    $.ajax({
        type: "get",
        url: AJAXCHECKURL,
        data: {username: username, company_id: company_id, tel: tel, name: name, operation: CHECK_MODE},
        dataType: "json",
        success: function (json) {
            if (!json.result) {
                BUI.Message.Show({
                    msg: json.errorMessage.msg,
                    icon: 'error',
                    autoHide: true,
                    autoHideDelay: 3000
                });
                return false;
            } else {
                calllback();
            }
        }
    })
}

/**
 * 编辑时加载省份信息
 */
function _init_region_form_status() {
    if (PID > 0) {
        _get_child_region(PID, 'city');
    }
}

function _get_child_region(id, domname) {
    $.ajax({
        type: "get",
        url: CHILD_REGION_URL,
        data: {id: id},
        dataType: "json",
        success: function (d) {
            if (d.result == '0001') {
                if (id == '' && domname == 'city') {
                    code = '<option value="">请选择市</option>';
                }
                else {
                    if (domname == 'province') {
                        code = '<option value="">请选择省</option>';
                    }
                    else {
                        code = '<option value="">请选择市</option>';
                    }
                    $(d.data).each(function (k, v) {
                        code += '<option value="' + v.id + '">' + v.name + '</option>';
                    });
                }
                $('#' + domname).html(code).delay(500).show(function () {
                    if(PID>0) {
                        $('#province').val(PID);
                    }
                    if(CID>0) {
                        $('#city').val(CID);
                    }
                });
            }
        }
    })
}

/**
 * 上传头像
 * **/

function uploadAvatar() {
    BUI.use(['bui/overlay', 'bui/form'], function (Overlay, Form) {
        var dialog = new Overlay.Dialog({
            title: '上传企业Logo',
            width: 320,
            height: 280,
            closeAction: 'destroy',
            //配置DOM容器的编号
            contentId: 'company_logo_div',
            success: function () {
                var src = $("#avatar-input-logo-img").find("img").attr("src");//保存
                $("#company_logo_input").val(src);
                this.close();
            },
            fail: function () {
                this.close();
            },
            mask: true
        });
        dialog.show();
    });
}

$(function(){
    $("#company_logo_f input[name='attachment']").change(function(){
        $("#company_logo_f").submit();
    });
});
//保存文件url
function setfileurlfromcallbacklogo(fileurl) {
    $("#avatar-input-logo-img").find("img").attr("src", fileurl);
    $("#avatar-input-logo-img").find("a").attr("href", fileurl);
}

/**
 * 文件上传之后回调函数
 * @param file
 * @param message
 * @param status
 */
function uploadCallback(file, message, status) {
    //当设置了回调函数后，默认的上传进度条将不会显示，如果要让进度条显示，则调用shardUpload.tipDisplay(message,status)
    if (status == 'success') {
        //当status为success的时候，message返回的是服务端合并文件后返回的信息，一般为合并的文件名称
        setfileurlfromcallback(message)
    } else if (status == 'process') {
        //当status为process的时候，返回当前上传进度,返回0-100
        $("#output" + ptype).html(message);
    } else if (status == 'merge') {
        //当status为merge时，文件上传完成，通知服务端开始合并文件,message为正在合并文件
        $("#output" + ptype).html(message);
    } else if (status == 'failed') {
        $("#output" + ptype).html(message);
        //文件上传失败
    } else if (status == 'cancel') {
        //文件上传取消
    } else if (status == 'error') {
        //文件格式不正确
    }
}

/**
 * 上传模式切换
 * @param showid
 * @param hideid
 */
function uploadmode(showid, hideid) {
    $("#" + hideid).hide();
    $("#" + showid).show();
}

//添加作品输入框--根据不同的行业
function showAddworkTab() {
    $("#industry_tab").empty();
    var Tab = BUI.Tab;
    var fis = $("input.first_level:checked");
    var items = new Array();
    if (fis.length == 0) {
        $("#upload").hide();
        return;
    }
    $("#upload").show();
    $.each(fis, function (i, el) {
        var item = {};
        item.value = $(el).val();
        if(ptype == 0){
            ptype = $(el).val();
        }
        item.title = $(el).attr('name');
        if (i == 0) {
            item.selected = 'selected';
            $("input[name=work_ptype]").val($(el).val());
        }
        items.push(item);
    });
    var panelTpl =
        '<table class="workuploadtb">' +
        '<tr id="link_{value}" style="display: none">' +
        '<td colspan="2">外链模式</td>' +
        '<td colspan="4"><input id="workname_{value}" name="workname_{value}" class="input-big control-text"  placeholder="作品名称" type="text" style="width: 100px;margin-right: 50px"/><input id="workfile_{value}" name="workfile_{value}" class="input-big control-text"  placeholder="http://请输入作品ＵＲＬ地址" type="text" style="width: 200px"/>' +
        '<input type="button" value="添加" onclick="addwork()"/> <input type="button" value="切换本地模式" onclick="uploadmode(\'local_{value}\',\'link_{value}\')"/>' +
        '</td>' +
        '</tr>' +
        '<tr id="local_{value}">' +
        '<td colspan="2">本地模式</td>' +
        '<td colspan="4" width="350"><input type="button"  name="workupload{value}"  id="workupload{value}" value="选择作品文件" >' +
        '<span id="output{value}"></span><input type="button" id="uploadbtn{value}" value="上传"  onclick="shardUpload.callupload();"/> ' +
        '</td><td><input type="button" value="切换外链模式" onclick="uploadmode(\'link_{value}\',\'local_{value}\')"/></td>' +
        '</tr>' +
        '</table>' +
        '<table><tr>' +
        '<td class="picList" id="Work_Layout{value}" colspan="6" align="center">暂无作品，你可以上传.</td>' +
        '</tr></table>';
    var tab = new Tab.TabPanel({
        render: '#industry_tab',
        elCls: 'nav-tabs',
        elStyle: {border: 'none'},
        //panelContainer : '#panel',//如果不指定容器的父元素，会自动生成
        panelTpl: panelTpl,//如果未设置panelContent时，使用此属性生成内容
        defaultChildCfg: {//配置子控件公用的属性
        },
        autoRender: true,
        children: items
    });
    tab.on('click', function () {
        var item = tab.getSelected();
        var ptype = item.get('value');
        $("input[name=work_ptype]").val(ptype);
    });
    tab.on('selectedchange', function () {
        var item = tab.getSelected();
        ptype = item.get('value');
        ajaxShowWork(ptype);
    });
    //设置username
    var username = $("input[v-role=company-username]").val();
    $("input[name=username]").val(username);
    //加载默认作品列表
    if(ptype ==0) {
        ptype = $("input[name=work_ptype]").val();
    }
    ajaxShowWork(ptype);
}

//添加作品
function addwork() {
    var work = {};
    var ptype = $("#work_ptype").val();
    work.username = username;// $("input[name=username]").val();
    work.work_ptype = ptype;
    work.workfile = $("input[name=workfile_" + ptype + "]").val();
    work.workname = $("input[name=workname_" + ptype + "]").val();
    $.ajax({
        type: "post",
        url: CRM_WROK_SAVE_URL,
        data: work,
        dataType: "json",
        success: function (json) {
            if (json.result) {
                BUI.Message.Alert('添加成功！', 'success');
                $("input[name=form_reset_" + ptype + "]").click();
                $("input[name=attachment]").val('');
                $("input[name=workfile]").val('');
                $("#show_upload_img" + ptype).html('');
                var uploadedWork = json.uploadedWork;
                var items = new Array()
                $.each(uploadedWork, function (i, val) {
                    var item = {};
                    item.id = val.id;
                    if (val.work_type == 1) {//图片
                        item.img = val.work_url;
                    } else if (val.work_type == 2) {//视频
                        item.img = ALTER_VIDEO_URL;
                    } else if (val.work_type == 5) {//音频
                        item.img = ALTER_AUDIO_URL;
                    } else if (val.work_type == 3) {//文本
                        item.img = ALTER_TXT_URL;
                    } else {
                        item.img = val.work_url;
                    }
                    item.src = val.work_url;
                    item.ptype = val.ptype;
                    item.username = val.username;
                    item.name = val.work_name;
                    item.work_price = val.work_price;
                    item.work_period = val.work_period;
                    items.push(item);
                });
                showWork(ptype, items);
                $("input[name=workname_" + ptype + "]").val("");
                $("input[name=workfile_" + ptype + "]").val("");

            }
            else {
                BUI.Message.Alert(json.errorMessage.msg, 'error');
            }
        }
    });
}

//编辑作品
function editWork(el){
    var paras = {};
    var dom = $(el).parents(".pic-content");
    paras.id = $(dom).find("input[name='workidArr[]']").val();
    paras.work_name = $(dom).find("input[name='worknameArr[]']").val();
    paras.work_price = $(dom).find("input[name='workpriceArr[]']").val();
    paras.work_period = $(dom).find("input[name='workperiodArr[]']").val();
    $.ajax({
        type: "post",
        url: CRM_WROK_EDIT_URL,
        data: paras,
        dataType: "json",
        success: function (json) {
            if(!json.result){
                BUI.Message.Alert(json.errorMessage.msg, 'error');
            }
        }
    });
}

//确认删除作品
function deleteWork(id) {
    BUI.Message.Confirm('确认删除此作品？', function () {
        doDeleteWork(id);
    }, 'question');
}

//执行删除操作
function doDeleteWork(id) {
    $.ajax({
        type: "post",
        url: DEL_WORL_API_URL,
        data: {id: id},
        dataType: "json",
        success: function (json) {
            if (json.result) {
                BUI.Message.Alert('删除成功！', 'success');
                var uploadedWork = json.uploadedWork;
                var ptype = json.ptype;
                var items = new Array()
                $.each(uploadedWork, function (i, val) {
                    var item = {};
                    item.id = val.id;
                    if (val.work_type == 1) {//图片
                        item.img = val.work_url;
                    } else if (val.work_type == 2) {//视频
                        item.img = ALTER_VIDEO_URL;
                    } else if (val.work_type == 5) {//音频
                        item.img = ALTER_AUDIO_URL;
                    } else if (val.work_type == 3) {//文本
                        item.img = ALTER_TXT_URL;
                    } else {
                        item.img = val.work_url;
                    }
                    item.src = val.work_url;
                    item.name = val.work_name;
                    item.work_price = val.work_price;
                    item.work_period = val.work_period;
                    items.push(item);
                });
                showWork(ptype, items);
            }
            else {
                BUI.Message.Alert('删除失败！', 'error');
            }
        }
    });
}

//保存文件url
function setfileurlfromcallback(data) {
    if(data.result==1 && data.fileurl){
        ptype = $("#work_ptype").val();
        $("#workfile_"+ptype).val(data.fileurl);
        var workdata = data.workname.split('.');
        $("#workname_"+ptype).val(workdata[0]);
        addwork();
        $("#show_upload_img" + ptype).html('正在上传..请稍等..');
    }else{
        $("#show_upload_img" + ptype).html('上传失败，请稍后重试或先跳过此步。');
    }
    $("body").data('BMask').hide();
}

//充值输入框
function resetForm() {
    $("#loading")[0].reset();
}

//异步加载作品
function ajaxShowWork(ptype) {
    shardUpload.init('workupload' + ptype, SHARDUPLOADURL, {
        exts: WROKFILEEXT, //只允许上传mp4或flv格式
        chunk: 1 * 1024 * 1024, //按4M分割
        async: 2,//允许同时上传5个碎片
        parame: {"username": username, "objtype": "work", "appid": 1000, "token": 1000}
    });
    var param = {};
    param.ptype = ptype;
    param.username = $("input[v-role=company-username]").val();
    $.ajax({
        type: "post",
        url: LOAD_WORK_API_URL,
        data: param,
        dataType: "json",
        success: function (json) {
            if (json.result) {
                var uploadedWork = json.uploadedWork;
                var ptype = json.ptype;
                var items = new Array()
                $.each(uploadedWork, function (i, val) {
                    var item = {};
                    item.id = val.id;

                    if (val.work_type == 1) {//图片
                        item.img = val.work_url;
                    } else if (val.work_type == 2) {//视频
                        item.img = ALTER_VIDEO_URL;
                    } else if (val.work_type == 5) {//音频
                        item.img = ALTER_AUDIO_URL;
                    } else if (val.work_type == 3) {//文本
                        item.img = ALTER_TXT_URL;
                    } else {
                        item.img = val.work_url;
                    }

                    item.src = val.work_url;
                    item.name = val.work_name;
                    item.work_price = val.work_price;
                    item.work_period = val.work_period;
                    items.push(item);
                });
                showWork(ptype, items);
            }
            else {
            }
        }
    });
}

//展示作品
function showWork(ptype, items) {
    var ele = "#Work_Layout" + ptype;
    $(ele).empty();
    var tpl =   '<li style="margin-bottom: 25px;">' +
                '  <div class="pic"><a href="{src}" target="_blank"><img style="height:120px;max-width:100px" src="{img}" /></a><span style="position: relative; right: 16px;top: -47px;" class="x-icon x-icon-small x-icon-error" onclick="deleteWork({id})">×</span></div>' +
                '  <div class="pic-content">'+
                '       作品名称：<input name="workidArr[]" value="{id}" type="hidden" /><input  name="worknameArr[]" value="{name}" size="10" onblur="editWork(this)"/><br>'+
                '       作品报价：<input name="workpriceArr[]" value="{work_price}" size="10" onblur="editWork(this)"/><br>'+
                '       制作周期：<input  name="workperiodArr[]"  value="{work_period}" size="10" onblur="editWork(this)"/>'+
                '  </div>' +
                '</li>';
    BUI.use(['bui/layout'], function (Layout) {
        var layout = new Layout.Flow({
                columns: 4
            }),
            control = new BUI.Component.Controller({
                render: ele,
                elCls: 'layout-test',
                defaultChildCfg: {
                    xclass: 'controller',
                    tpl: tpl,
                    height: 200,
                    width: 150
                },
                children: items,
                plugins: [layout]
            });
        control.render();
    });
}

/**
 * 显示添加原创项目
 */
function checkOrigProj(val) {
    if (parseInt(val) == 1) {
        $(".origin_project").show();
        listOriginProject();
    } else {
        $(".origin_project").hide();
    }
}


/**
 * 展示原创项目
 */
function listOriginProject() {
    var params = {};
    params.company_id = COMPANY_ID;
    params.operation = 'list';
    $.ajax({
        type: "post",
        url: ORIG_PROJ_API_URL,
        data: params,
        dataType: "json",
        success: function (json) {
            if (json.result) {
                showOriginProjectList(json.all_proj);
            }
            else {
            }
        }
    });
}

/**
 * 添加原创项目
 */
function addOriginProject(dom) {
    if(COMPANY_ID) {
        var params = {};
        var proj_name = $(dom).parents(".origin_project").find(".origin_project_input").val();
        params.company_id = COMPANY_ID;
        params.proj_name = proj_name;
        params.operation = 'add';
        $.ajax({
            type: "post",
            url: ORIG_PROJ_API_URL,
            data: params,
            dataType: "json",
            success: function (json) {
                if (json.result) {
                    BUI.Message.Alert(json.msg, function () {
                        showOriginProjectList(json.all_proj);
                    });
                }
                else {
                    BUI.Message.Alert(json.msg, 'error');
                }
            }
        });
    }else{
        var text = $(dom).parent("div").find("input").val();
        var html = '<div class="control-group">'+
            '   <label class="control-label">项目名称</label>'+
            '    <div class="controls">'+
            '       <input name="" class="input-normal control-text origin_project_input" value="'+text+'" type="text"/>'+
            '    </div>'+
            '    <span class="x-icon x-icon-normal" onclick="deleteOriginProject(this)">×</span>'+
            '</div>';
        $(dom).parent("div").find("input").val('');
        $(".origin_project").append(html);
    }
}

/**
 * 删除原创项目
 */
function deleteOriginProject(id) {
    BUI.Message.Confirm('确认删除？', function () {
        var params = {};
        params.id = id;
        params.company_id = COMPANY_ID;
        params.operation = 'delete';
        $.ajax({
            type: "post",
            url: ORIG_PROJ_API_URL,
            data: params,
            dataType: "json",
            success: function (json) {
                if (json.result) {
                    BUI.Message.Alert(json.msg, function () {
                        showOriginProjectList(json.all_proj);
                    });
                }
                else {
                    BUI.Message.Alert(json.msg, 'error');
                }
            }
        });
    }, 'question');
}

/**
 * 显示原创项目
 */
function showOriginProjectList(arr) {
    var html = '<div class="control-group">' +
        '   <label class="control-label">项目名称</label>' +
        '    <div class="controls">' +
        '       <input name="" class="input-normal control-text origin_project_input" value="" type="text"/>' +
        '    </div>' +
        '    <span class="x-icon x-icon-success" onclick="addOriginProject(this)">+</span>' +
        '</div>';
    $.each(arr, function (i, val) {
        html += '<div class="control-group">' +
        '   <label class="control-label">项目名称</label>' +
        '    <div class="controls">' +
        '       <input name="" class="input-normal control-text origin_project_input" value="' + val.proj_name + '" type="text"/>' +
        '    </div>' +
        '    <span class="x-icon x-icon-normal" onclick="deleteOriginProject(' + val.id + ')">×</span>' +
        '</div>';
    });
    $(".origin_project").html(html);
}


/**
 * 显示添加获奖经历
 */
function checkPrizeExp(val) {
    if (val == 1) {
        $(".prize_experience").show();
        listPrizeExperience();
    } else {
        $(".prize_experience").hide();
    }
}

/**
 * 展示获奖经历
 */
function listPrizeExperience() {
    var params = {};
    params.company_id = COMPANY_ID;
    params.operation = 'list';
    $.ajax({
        type: "post",
        url: PRIZEEX_API_URL,
        data: params,
        dataType: "json",
        success: function (json) {
            if (json.result) {
                showPrizeExperienceList(json.all_prize);
            }
            else {
            }
        }
    });
}
/**
 * 添加获奖经历
 */
function addPrizeExperience(dom) {
    if(COMPANY_ID) { //编辑状态下
        var params = {};
        var prize = $(dom).parents(".prize_experience").find(".prize_experience_input").val();
        params.company_id = COMPANY_ID;
        params.prize = prize;
        params.operation = 'add';
        $.ajax({
            type: "post",
            url: PRIZEEX_API_URL,
            data: params,
            dataType: "json",
            success: function (json) {
                if (json.result) {
                    BUI.Message.Alert(json.msg, function () {
                        showPrizeExperienceList(json.all_prize);
                    });
                }
                else {
                    BUI.Message.Alert(json.msg, 'error');
                }
            }
        });
    }else{
        var text = $(dom).parent("div").find("input").val();
        var html = '<div class="control-group">'+
            '   <label class="control-label">获奖经历</label>'+
            '    <div class="controls">'+
            '       <input name="" class="input-normal control-text prize_experience_input" value="'+text+'" type="text"/>'+
            '    </div>'+
            '    <span class="x-icon x-icon-normal" onclick="deletePrizeExperience(this)">×</span>'+
            '</div>';
        $(dom).parent("div").find("input").val('');
        $(".prize_experience").append(html);
    }
}

/**
 * 删除获奖经历
 */
function deletePrizeExperience(id) {
    BUI.Message.Confirm('确认删除？', function () {
        var params = {};
        params.id = id;
        params.company_id = COMPANY_ID;
        params.operation = 'delete';
        $.ajax({
            type: "post",
            url: PRIZEEX_API_URL,
            data: params,
            dataType: "json",
            success: function (json) {
                if (json.result) {
                    BUI.Message.Alert(json.msg, function () {
                        showPrizeExperienceList(json.all_prize);
                    });
                }
                else {
                    BUI.Message.Alert(json.msg, 'error');
                }
            }
        });
    }, 'question');
}

/**
 * 显示获奖经历
 */
function showPrizeExperienceList(arr) {
    var html = '<div class="control-group">' +
        '   <label class="control-label">获奖经历</label>' +
        '    <div class="controls">' +
        '       <input name="" class="input-normal control-text prize_experience_input" value="" type="text"/>' +
        '    </div>' +
        '    <span class="x-icon x-icon-success" onclick="addPrizeExperience(this)">+</span>' +
        '</div>';
    $.each(arr, function (i, val) {
        html += '<div class="control-group">' +
        '   <label class="control-label">获奖经历</label>' +
        '    <div class="controls">' +
        '       <input name="" class="input-normal control-text prize_experience_input" value="' + val.describe + '" type="text"/>' +
        '    </div>' +
        '    <span class="x-icon x-icon-normal" onclick="deletePrizeExperience(' + val.id + ')">×</span>' +
        '</div>';
    });
    $(".prize_experience").html(html);
}


/**
 * 更新时步骤控制
 */
function updateStep(step) {
    switch (step) {
        case 0: //取消
            $("#company_add_basicInfo").hide();
            break;
        case 1: //添加基本信息-下一步
            var check_status = true;
            var input_arr = ['reg_money', 'reg_time', 'nature', 'aptitude'];
            $.each(input_arr, function (k, v) {
                var this_dom = $('input[name="' + v + '"]');
                var this_val = $('input[name="' + v + '"]:checked').val();
                if (!this_val) {
                    this_dom.parents('.controls').children('.x-field-error').remove();
                    this_dom.parents('.controls').append('<span class="x-field-error"><span class="x-icon x-icon-mini x-icon-error">!</span><label class="x-field-error-text">请选择！</label></span>');
                    check_status = false;
                }
            });
            ajaxCheckUser(function () {
                if ($("#company_basicInfo_form").data("BForm").isValid() && check_status) {
                    $("#company_add_basicInfo").hide();
                    $("#company_add_industry").show();
                }
            });
            break;
        case 2: //添加行业-上一步
            $("#company_add_industry").hide();
            $("#company_add_basicInfo").show();
            break;
        case 3: //添加行业-下一步
            var ch_input = $(".first_level:checked");
            if (!ch_input.length) {
                BUI.Message.Alert('您至少要选择一个一级行业！', 'error')
            } else {
                $("#company_add_industry").hide();
                $("#company_add_work").show();
                showAddworkTab();
            }
            break;
        case 4: //添加作品-上一步
            $("#company_add_work").hide();
            $("#company_add_industry").show();
            break;
        case 5: //添加作品-下一步
            $("#company_add_work").hide();
            $("#company_add_other").show();
            break;
        case 6: //添加其他-上一步
            $("#company_add_other").hide();
            $("#company_add_work").show();
            break;
        case 7: //保存
            updateCompany();
            break;
    }
}

/**
 * 更新企业信息
 */
function updateCompany() {

    var basic = $("#company_basicInfo_form");
    var industry = $("#company_industry_form");
    var work = $("#company_work_form");
    var other = $("#company_other_form");
    var industry = getCheckedIndustry();
    var worklist = work.serializeArray();
    var params = {};
    if (basic.data("BForm").isValid()) {
        params.id = COMPANY_ID;
        params.name = basic.find("[v-role=company-name]").val();
        params.logo = $("#company_logo_input").val();
        params.username = basic.find("[v-role=company-username]").val();
        params.qq = basic.find("[v-role=company-qq]").val();
        params.tel = basic.find("[v-role=company-tel]").val();
        params.province = basic.find("select[v-role=company-province] option:selected").val();
        params.city = basic.find("select[v-role=company-city] option:selected").val();
        params.address = basic.find("[v-role=company-address]").val();
        params.contact_name = basic.find("[v-role=company-contact_name]").val();
        params.address = basic.find("[v-role=company-address]").val();
        params.contact_postion = basic.find("[v-role=company-contact_postion]").val();
        params.contact_wechat = basic.find("[v-role=company-contact_wechat]").val();
        params.contact_email = basic.find("[v-role=company-contact_email]").val();
        params.reg_money = basic.find("input[v-role=company-reg_money]:checked").val();
        params.reg_time = basic.find("input[v-role=company-reg_time]:checked").val();
        params.nature = basic.find("input[v-role=company-nature]:checked").val();
        params.aptitude = basic.find("input[v-role=company-aptitude]:checked").val();
        params.score_basic = getBasicScore();
        params.has_original = other.find("input[v-role=company-has_original]:checked").val();
        params.is_render = other.find("input[v-role=company-is_render]:checked").val();
        params.has_develop = other.find("input[v-role=company-has_develop]:checked").val();
        params.has_prize = other.find("input[v-role=company-has_prize]:checked").val();
        params.industry = industry;
        params.turnover_year = $("input[v-role=company-turnover_year]").val();
        params.turnover_month = $("input[v-role=company-turnover_month]").val();
        params.turnover_other = $("input[v-role=company-turnover_other]").val();
        params.output_year = $("input[v-role=company-output_year]").val();
        params.output_minute = $("input[v-role=company-output_minute]").val();
        params.output_other = $("input[v-role=company-output_other]").val();
        params.work_arr = worklist;
        $.ajax({
            type: "post",
            url: COMPANY_UPDATE_URL,
            data: params,
            dataType: "json",
            success: function (json) {
                if (json.result) {
                    BUI.Message.Alert('保存成功', function () {
                        window.location.href = COMPANY_LIST_MY;
                    }, 'info');
                }
                else {
                    BUI.Message.Alert(json.errorMessage.message, 'error');
                }
            }
        });
    }
}

/**
 * 添加时步骤控制
 */
function companyAddStep(step) {
    switch (step) {
        case 0: //取消
            $("#company_add_basicInfo").hide();
            break;
        case 1: //添加基本信息-下一步
            var check_status = true;
            var check_arr = ['reg_money', 'reg_time', 'nature', 'aptitude'];
            $.each(check_arr, function (k, v) {
                var this_dom = $('input[name="' + v + '"]');
                var this_val = $('input[name="' + v + '"]:checked').val();
                if (!this_val) {
                    this_dom.parents('.controls').children('.x-field-error').remove();
                    this_dom.parents('.controls').append('<span class="x-field-error"><span class="x-icon x-icon-mini x-icon-error">!</span><label class="x-field-error-text">请选择！</label></span>');
                    check_status = false;
                }
            });
            ajaxCheckUser(function () {
                if ($("#company_basicInfo_form").data("BForm").isValid() && check_status) {
                    $("#company_add_basicInfo").hide();
                    $("#company_add_industry").show();
                }
            });
            break;
        case 2: //添加行业-上一步
            $("#company_add_industry").hide();
            $("#company_add_basicInfo").show();
            break;
        case 3: //添加行业-下一步 ,行业信息必填一项
            var ch_input = $(".first_level:checked");
            if (!ch_input.length) {
                BUI.Message.Alert('您至少要选择一个一级行业！', 'error')
            } else {
                $("#company_add_industry").hide();
                $("#company_add_work").show();
                ptype = $(".first_level:checked")[0].attributes.value;
                showAddworkTab();
            }
            break;
        case 4: //添加作品-上一步
            $("#company_add_work").hide();
            $("#company_add_industry").show();
            break;
        case 5: //添加作品-下一步
            $("#company_add_work").hide();
            $("#company_add_other").show();
            break;
        case 6: //添加其他-上一步
            $("#company_add_other").hide();
            $("#company_add_work").show();
            break;
        case 7: //保存
            saveCompany();
            break;
    }
}
/**
 * 保存编辑
 */
function saveCompany() {
    $("#lastsave").hide();
    $("#postloading").show();
    var basic = $("#company_basicInfo_form");
    var industry = $("#company_industry_form");
    var work = $("#company_work_form");
    var other = $("#company_other_form");
    var industry = getCheckedIndustry();
    var worklist = work.serializeArray();
    var params = {};
    if (basic.data("BForm").isValid()) {
        params.name = basic.find("[v-role=company-name]").val();
        params.logo = $("#company_logo_input").val();
        params.username = basic.find("[v-role=company-username]").val();
        params.qq = basic.find("[v-role=company-qq]").val();
        params.tel = basic.find("[v-role=company-tel]").val();
        params.province = basic.find("select[v-role=company-province] option:selected").val();
        params.city = basic.find("select[v-role=company-city] option:selected").val();
        params.address = basic.find("[v-role=company-address]").val();
        params.contact_name = basic.find("[v-role=company-contact_name]").val();
        params.address = basic.find("[v-role=company-address]").val();
        params.contact_postion = basic.find("[v-role=company-contact_postion]").val();
        params.contact_wechat = basic.find("[v-role=company-contact_wechat]").val();
        params.contact_email = basic.find("[v-role=company-contact_email]").val();
        params.reg_money = basic.find("input[v-role=company-reg_money]:checked").val();
        params.reg_time = basic.find("input[v-role=company-reg_time]:checked").val();
        params.nature = basic.find("input[v-role=company-nature]:checked").val();
        params.aptitude = basic.find("input[v-role=company-aptitude]:checked").val();
        params.score_basic = getBasicScore();
        params.has_original = other.find("input[v-role=company-has_original]:checked").val();
        params.is_render = other.find("input[v-role=company-is_render]:checked").val();
        params.has_develop = other.find("input[v-role=company-has_develop]:checked").val();
        params.has_prize = other.find("input[v-role=company-has_prize]:checked").val();
        params.industry = industry;
        params.turnover_year = $("input[v-role=company-turnover_year]").val();
        params.turnover_month = $("input[v-role=company-turnover_month]").val();
        params.turnover_other = $("input[v-role=company-turnover_other]").val();
        params.output_year = $("input[v-role=company-output_year]").val();
        params.output_minute = $("input[v-role=company-output_minute]").val();
        params.output_other = $("input[v-role=company-output_other]").val();
        params.work_arr = worklist;
        //获奖原创项目
        var origin_proj = new Array();
        var doms = $(".origin_project_input");
        $.each(doms, function (i, dom) {
            var o_p = {};
            o_p.name = $(dom).val();
            if (o_p.name.length) {
                origin_proj.push(o_p);
            }
        });
        $("input[name=has_original]:checked").val() == 1 ? params.origin_proj = origin_proj : false;

        //获奖原创项目
        var prize_exp = new Array();
        var els = $(".prize_experience_input");
        $.each(els, function (i, el) {
            var o_p = {};
            o_p.describe = $(el).val();
            if (o_p.describe.length) {
                prize_exp.push(o_p);
            }
        });
        $("input[name=has_prize]:checked").val() == 1 ? params.prize_exp = prize_exp : false;
        $.ajax({
            type: "post",
            url: COMPANY_ADD_URL,
            data: params,
            dataType: "json",
            success: function (json) {
                if (json.result) {
                    BUI.Message.Show({
                        title: '系统提示',
                        msg: '企业信息录入成功，请点击以下按钮继续 ',
                        icon: 'info',
                        buttons: [
                            {
                                text: '返回我的企业列表',
                                elCls: 'button button-primary',
                                handler: function () {
                                    window.location.href = COMPANY_LIST_MY;
                                }
                            },
                            {
                                text: '继续企业录入',
                                elCls: 'button',
                                handler: function () {
                                    top.topManager.reloadPage()
                                }
                            }

                        ]
                    });
                }
                else {
                    $("#lastsave").show();
                    $("#postloading").hide();
                    BUI.Message.Alert(json.errorMessage.message, 'error');
                }
            }
        });
    }
}
/**
 * 获取已选择行业信息
 * @return Array 元素为[v1, v2, v3]
 * size-人员规模
 * v1-一级分类
 * v2-二级分类
 * v3-三级分类
 * 如果只有一级目录，那么v2,v3=0
 * 如果只有一级二级目录，那么v3=0
 */
function getCheckedIndustry() {
    var industry = new Array()
    var first = $(".classify-yi").find("input:checked");
    $.each(first, function (j, f) {
        var v1 = $(f).val();//一级分类
        var m = 0; //判断该一级分类下面有没有二级分类
        var num = $(f).parent().attr("rowspan");
        var index = $(f).parents("tr").index();
        var size = $(".classify-table tr").eq(index + 1).find("input:checked").val();
        for (var i = index + 1; i < (parseInt(index) + parseInt(num)); i++) {//每个二级分类
            se = $(".classify-table tr").eq(i).find(".classify-er");//每个二级分类
            if ($(se).find("span input:checked").length) {//被选中的二级分类
                m++;
                v2 = $(se).find("span input:checked").val();//二级分类
                third = $(se).find(".classify-san input:checked");
                if (third.length) {
                    $.each(third, function (k, t) {
                        v3 = $(t).val();//三级分类
                        industry.push([size, v1, v2, v3]);
                    });
                }
                else {
                    industry.push([size, v1, v2, 0]);
                }
            }
        }
        if (m == 0) {//只有一级分类
            industry.push([size, v1, 0, 0]);
        }
    });
    return industry;
}

/**
 * 获取基础得分
 * */
function getBasicScore() {
    var basics = $("input.basic_score_value:checked ");
    var basic_score = 0;
    $.each(basics, function (i, el) {
        basic_score += parseInt($(el).attr("score_value"));
    });
    return basic_score;
}

/**
 * 录入时校验
 * @param dom
 */
function checkInputValid(dom) {
    var val = $(dom).val();
    if (!val.length) {
        $(dom).parent('.controls').children('.x-field-error').remove();
        $(dom).parent('.controls').append('<span class="x-field-error"><span class="x-icon x-icon-mini x-icon-error">!</span><label class="x-field-error-text">不能为空！</label></span>');
    } else {
        $(dom).parent('.controls').children('.x-field-error').remove();
    }
}
/**
 * 初始化
 * */
function init() {
    var basics = $("input.basic_score_value:checked ");
    var basic_score = 0;
    $.each(basics, function (i, el) {
        basic_score += parseInt($(el).attr("score_value"));
    });
    return basic_score;
}
/**
 * 添加时步骤控制
 */
function companyAddStep(step) {
    switch (step) {
        case 0: //取消
            $("#company_add_basicInfo").hide();
            break;
        case 1: //添加基本信息-下一步
            var check_status = true;
            var check_arr = ['reg_money', 'reg_time', 'nature', 'aptitude'];
            $.each(check_arr, function (k, v) {
                var this_dom = $('input[name="' + v + '"]');
                var this_val = $('input[name="' + v + '"]:checked').val();
                if (!this_val) {
                    this_dom.parents('.controls').children('.x-field-error').remove();
                    this_dom.parents('.controls').append('<span class="x-field-error"><span class="x-icon x-icon-mini x-icon-error">!</span><label class="x-field-error-text">请选择！</label></span>');
                    check_status = false;
                }
            });
            ajaxCheckUser(function () {
                if ($("#company_basicInfo_form").data("BForm").isValid() && check_status) {
                    $("#company_add_basicInfo").hide();
                    $("#company_add_industry").show();
                }
            });
            break;
        case 2: //添加行业-上一步
            $("#company_add_industry").hide();
            $("#company_add_basicInfo").show();
            break;
        case 3: //添加行业-下一步 ,行业信息必填一项
            var ch_input = $(".first_level:checked");
            if (!ch_input.length) {
                BUI.Message.Alert('您至少要选择一个一级行业！', 'error')
            } else {
                $("#company_add_industry").hide();
                $("#company_add_work").show();
                showAddworkTab();
            }
            break;
        case 4: //添加作品-上一步
            $("#company_add_work").hide();
            $("#company_add_industry").show();
            break;
        case 5: //添加作品-下一步
            $("#company_add_work").hide();
            $("#company_add_other").show();
            break;
        case 6: //添加其他-上一步
            $("#company_add_other").hide();
            $("#company_add_work").show();
            break;
        case 7: //保存
//                            $("#company_add_other").hide();
            addCompany();
            break;
    }
}
/**
 * 保存编辑
 */
function addCompany() {
    $("#lastsave").hide();
    $("#postloading").show();
    var basic = $("#company_basicInfo_form");
    var industry = $("#company_industry_form");
    var work = $("#company_work_form");
    var other = $("#company_other_form");
    var industry = getCheckedIndustry();
    var worklist = work.serializeArray();
    var params = {};
    if (basic.data("BForm").isValid()) {
        params.name = basic.find("[v-role=company-name]").val();
        params.username = basic.find("[v-role=company-username]").val();
        params.logo = $("#company_logo_input").val();
        params.qq = basic.find("[v-role=company-qq]").val();
        params.tel = basic.find("[v-role=company-tel]").val();
        params.province = basic.find("select[v-role=company-province] option:selected").val();
        params.city = basic.find("select[v-role=company-city] option:selected").val();
        params.address = basic.find("[v-role=company-address]").val();
        params.contact_name = basic.find("[v-role=company-contact_name]").val();
        params.address = basic.find("[v-role=company-address]").val();
        params.contact_postion = basic.find("[v-role=company-contact_postion]").val();
        params.contact_wechat = basic.find("[v-role=company-contact_wechat]").val();
        params.contact_email = basic.find("[v-role=company-contact_email]").val();
        params.reg_money = basic.find("input[v-role=company-reg_money]:checked").val();
        params.reg_time = basic.find("input[v-role=company-reg_time]:checked").val();
        params.nature = basic.find("input[v-role=company-nature]:checked").val();
        params.aptitude = basic.find("input[v-role=company-aptitude]:checked").val();
        params.score_basic = getBasicScore();
        params.has_original = other.find("input[v-role=company-has_original]:checked").val();
        params.is_render = other.find("input[v-role=company-is_render]:checked").val();
        params.has_develop = other.find("input[v-role=company-has_develop]:checked").val();
        params.has_prize = other.find("input[v-role=company-has_prize]:checked").val();
        params.industry = industry;
        params.turnover_year = $("input[v-role=company-turnover_year]").val();
        params.turnover_month = $("input[v-role=company-turnover_month]").val();
        params.turnover_other = $("input[v-role=company-turnover_other]").val();
        params.output_year = $("input[v-role=company-output_year]").val();
        params.output_minute = $("input[v-role=company-output_minute]").val();
        params.output_other = $("input[v-role=company-output_other]").val();
        params.work_arr = worklist;
        //获奖原创项目
        var origin_proj = new Array();
        var doms = $(".origin_project_input");
        $.each(doms, function (i, dom) {
            var o_p = {};
            o_p.name = $(dom).val();
            if (o_p.name.length) {
                origin_proj.push(o_p);
            }
        });
        $("input[name=has_original]:checked").val() == 1 ? params.origin_proj = origin_proj : false;

        //获奖原创项目
        var prize_exp = new Array();
        var els = $(".prize_experience_input");
        $.each(els, function (i, el) {
            var o_p = {};
            o_p.describe = $(el).val();
            if (o_p.describe.length) {
                prize_exp.push(o_p);
            }
        });
        $("input[name=has_prize]:checked").val() == 1 ? params.prize_exp = prize_exp : false;
        $.ajax({
            type: "post",
            url: COMPANY_ADD_URL,
            data: params,
            dataType: "json",
            success: function (json) {
                if (json.result) {
                    BUI.Message.Show({
                        title: '系统提示',
                        msg: '企业信息录入成功，请点击以下按钮继续 ',
                        icon: 'info',
                        buttons: [
                            {
                                text: '返回我的企业列表',
                                elCls: 'button button-primary',
                                handler: function () {
                                    window.location.href = COMPANY_LIST_MY;
                                }
                            },
                            {
                                text: '继续企业录入',
                                elCls: 'button',
                                handler: function () {
                                    top.topManager.reloadPage()
                                }
                            }

                        ]
                    });
                }
                else {
                    $("#lastsave").show();
                    $("#postloading").hide();
                    BUI.Message.Alert(json.errorMessage.message, 'error');
                }
            }
        });
    }
}
$(document).on('change', 'input[name="reg_money"],input[name="reg_time"],input[name="nature"],input[name="aptitude"]', function () {
    var _this_dom = $(this);
    _this_dom.parents('.controls').children('.x-field-error').remove();
});