/**
 * Created by Qingwenjie on 2016/2/18.
 */
_get_form_json = function (form) {
    var o = {};
    var a = $(form).serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

//校验表单必填数据
_check_form = function (dom_name) {
    var i = 0;
    var _is_pass = true;
    $(dom_name).find('input.required, textarea.required, select.required').each(function () {
        var _this_dom = $(this);
        var _value = _this_dom.val();
        if (_value == '' || _value == undefined) {
            _this_dom.parent().addClass('has-error');
            if(_this_dom.attr('data-messages') != undefined && _this_dom.attr('data-messages') != '') {
                _this_dom.siblings("i.error_tip").remove();
                _this_dom.after('<i class="error_tip" style="color: #F51B0B;line-height: 36px;margin: 0 10px;">'+ _this_dom.attr('data-messages') +'</i>');
            }
            if(i ==0 )_scrollOffset(_this_dom.offset());
            _is_pass = false;
            i++;
        } else {
            _this_dom.siblings("i.error_tip").remove();
            _this_dom.parent().removeClass('has-error');
        }
    });
    return _is_pass;
};

//必填项处理
_form_notice_tips = function (dom_name) {
    $(dom_name).find('.required').each(function () {
        var _this_dom = $(this);
        _this_dom.on('blur', function () {
            var _value = $(this).val();
            if (_value == '' || _value == undefined) {
                $(this).parent().addClass('has-error');
            } else {
                $(this).siblings("i.error_tip").remove();
                $(this).parent().removeClass('has-error');
            }
        });
    });
};

//清除表单 id-表单id或者class,includeHidden 是否包含hidden的输入框
_clear_form = function(id, includeHidden){
    var form = $(id);
    if(form.length == 0){
        return false;
    }
    _clear_fields(form.find('input, select, textarea'), includeHidden);
}

//清除输入框
_clear_fields = function(dom, includeHidden) {
    var re = /^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i;
    return dom.each(function() {
        var t = this.type;
        tag = this.tagName.toLowerCase();
        if (re.test(t) || tag == 'textarea') {
            this.value = '';
        }
        else if (t == 'checkbox' || t == 'radio') {
            this.checked = false;
        }
        else if (tag == 'select') {
            this.selectedIndex = -1;
        }
        else if (t == "file") {
            if (/MSIE/.test(navigator.userAgent)) {
                $(this).replaceWith($(this).clone(true));
            } else {
                $(this).val('');
            }
        }
        else if (includeHidden) {
            if ( (includeHidden === true && /hidden/.test(t)) ||
                (typeof includeHidden == 'string' && $(this).is(includeHidden)) ) {
                this.value = '';
            }
        }
    });
}

//异步请求
_req = function (url, data, reqtype, rettype, callback) {
    if(url == '' || url == undefined){
        return
    }
    if ($(document).data(url) == false) {
        return
    }
    $(document).data(url, false);
    $.ajax({
        url: url,
        data: data,
        type: reqtype,
        dataType: rettype,
        success: function (d) {
            $(document).data(url, true);
            if (typeof callback == "function") {
                callback(d);
            }
        },
    });
};

//ajax方式实现异步跨域请求数据-jsonp
_jsonp = function (url, data, reqtype, callback) {
    if (url) {
        $.ajax({
            url: url,
            data: data,
            type: reqtype,
            dataType: 'jsonp',
            jsonp: 'callback',
            success: function (d) {
                if (typeof callback == "function") {
                    callback(d);
                }
            }
        });
    }
};

//模态框
_tips = function (title, content, time, callback) {
    if (title == '') {
        title = '提示窗口';
    }
    var code = '<div id="_j_dialog" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">' +
        '<div class="modal-dialog" role="document">' +
        '<div class="modal-content">' +
        '<div class="modal-header">' +
        '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
        '<h4 class="modal-title" id="myModalLabel">' + title + '</h4>' +
        '</div>' +
        '<div class="modal-body"> ' + content + '</div>' +
        '</div>' +
        '</div>' +
        '</div>';
    $('body').append(code);
    jQuery('#_j_dialog').modal();
    jQuery('#_j_dialog').on('hidden.bs.modal', function () {
        if (typeof callback == "function") {
            callback();
        }
    });
    if (parseInt(time) > 0) {
        setTimeout(function () {
            jQuery('#_j_dialog').modal('hide');
        }, parseInt(time) * 1000);
    }
};

//弹窗
_win = function (title, content, type) {
    var code = '<div class="win-wrap">\
                    <div class="popup-bg"></div>\
                    <div class="popup-content ' + type + '">\
                        <a class="popup-content-close">×</a>\
                        <div class="popup-content-top">\
                            <span class="popup-content-title">' + title + '</span>\
                        </div>\
                        <div class="popup-content-formbox">\
                            <div class="order_s_info">' + content + '</div>\
                        </div>\
                    </div>\
                </div>';
    $('body').append(code);
    $('.popup-content-close, .popup-bg').on('click', function (event) {
        $('.win-wrap').remove();
    });
};

//窗口滚动
_scrollOffset = function (scroll_offset) {
    $("body, html").animate({
        scrollTop: scroll_offset.top - 70
    }, 0);
}

//判断str字符数量，中文-2，英文和字符-1
_str_len = function (str) {
    str = $.trim(str);
    var len = 0;
    for (var i = 0; i < str.length; i++) {
        if (str[i].match(/[^\x00-\xff]/ig) != null) //全角
            len += 2;
        else
            len += 1;
    }
    return len;
}
//返回str在规定字节长度max内的值
_str_cut = function (str, max) {
    str = $.trim(str);
    var value = '';
    var length = 0;
    for (var i = 0; i < str.length; i++) {
        if (str[i].match(/[^\x00-\xff]/ig) != null){
            length += 2;
        }
        else{
            length += 1;
        }
        if (length > max){
            break;
        }
        value += str[i];
    }
    return value;
}


