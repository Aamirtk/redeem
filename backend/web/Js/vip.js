var vip = {
    id : null,
    username : null,
    loadGroupDetail : function(id){
        var params = {};
        params.id = id;
        var html = '';
        $.ajax({
            type: "post",
            data: params,
            url: '/vip/vip/ajax-load-group-detail',
            dataType: "json",
            success: function (json) {
                if (json.result) {
                    var record = json.record;
                    html += '<p>1.<span>商机推送</span>&nbsp;&nbsp;&nbsp;&nbsp;'+ record.business_push +'万元</p>';
                    html += '<p>2.<span>可入驻一级类目数量上限</span>&nbsp;&nbsp;&nbsp;&nbsp;'+ record.proj_num_lv1 +'个</p>';
                    html += '<p>3.<span>可入驻二级类目数量上限</span>&nbsp;&nbsp;&nbsp;&nbsp;'+ record.proj_num_lv2 +'个</p>';
                    html += '<p>4.<span>渲染时长上限</span>&nbsp;&nbsp;&nbsp;&nbsp;'+ record.render_time +'分钟</p>';
                    html += '<p>5.<span>虚拟工作室项目数量上限</span>&nbsp;&nbsp;&nbsp;&nbsp;'+ record.proj_limit +'个</p>';
                    html += '<p>6.<span>可加入虚拟工作室上限</span>&nbsp;&nbsp;&nbsp;&nbsp;'+ record.studio_limit +'个</p>';
//                    html += '<p><span>工作室人数上限</span>&nbsp;&nbsp;&nbsp;&nbsp;'+ record.studio_user_limit +'</p>';
                    $("#group_detail").html(html);

                    var price = parseFloat(record.price);
                    var buy_num = parseInt($("#buy_num").find("option:selected").val());
                    $("#per_price").val(price);
                    $("input[name=price]").val((price * buy_num).toFixed(2));
                }
                else {
                }
            }
        });
    },

    /**
     * 加载用户详情
     */
    loadUserInfo : function(username){
        var width = 700;
        var height = 450;
        var Overlay = BUI.Overlay;
        dialog = new Overlay.Dialog({
            title: '用户平台信息',
            width: width,
            height: height,
            closeAction: 'destroy',
            loader: {
                url: "/vip/vip/ajax-get-user-info",
                autoLoad: true, //不自动加载
                params: {username: username},//附加的参数
                lazyLoad: false, //不延迟加载
            },
            buttons:[
                {
                    text:'确认',
                    elCls : 'button button-success',
                    handler : function(){
                        this.close();
                    }
                }
            ],
            mask: false
        });
        dialog.show();
        dialog.get('loader').load({username: username});
    },


};