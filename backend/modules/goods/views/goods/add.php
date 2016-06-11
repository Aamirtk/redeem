<?php
use yii\helpers\Html;
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>用户审核信息列表</title>

    <link href="/css/dpl.css" rel="stylesheet">
    <link href="/css/bui.css" rel="stylesheet">
    <link href="/css/page-min.css" rel="stylesheet">
    <link rel="stylesheet" href="/plugins/webuploader/webuploader.css" type="text/css"/>
    <script src="/js/jquery.js" type="text/javascript"></script>
    <script src="/js/bui-min.js" type="text/javascript"></script>
    <script src="/js/common.js" type="text/javascript"></script>
    <script src="/js/tools.js" type="text/javascript"></script>
    <script src="/plugins/webuploader/webuploader.js" type="text/javascript"></script>
    <style>
        .user_avatar {
            width: 120px;
            height: 80px;
            margin: 10px auto;
        }
        .demo-content{
            margin: 40px 60px;
        }

        .layout-outer-content{
            padding: 15px;
            margin: 10px 0px 40px 100px;
            width: 700px;
            background-color: #f6f6fb;
            border: 1px solid #c3c3d6;
        }
        .layout-content{
            width: 700px;
            margin: 10px 120px;
        }
        .img-content-li{
            width: 200px;
            height: 150px;
            margin-left: -50px;
        }
        .img-content-li img{
            width: 120px;
            height:90px;
        }
        .img-delete{
            position: relative;
            top:17px;
            left: 91px;
        }

    </style>
    <script>
        _BASE_LIST_URL =  "<?php echo yiiUrl('auth/auth/list') ?>";
    </script>
</head>

<body>
<div class="demo-content">
    <form id="Goods_Form" action="" class="form-horizontal" onsubmit="return false;" >
        <h2>添加商品</h2>
        <div class="control-group">
            <label class="control-label"><s>*</s>商品名称：</label>
            <div class="controls">
                <input name="goods[name]" type="text" class="input-medium" data-rules="{required : true}">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><s>*</s>缩略图：</label>
            <div class="controls">
                <input name="goods[thumb]" type="text" class="input-medium" data-rules="{required : true}">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><s>*</s>缩略图：</label>
            <div id="thumbpic" class="controls">
                <button class="button button-primary">上传图片</button>
            </div>
        </div>

        <div class="row " >
            <div id="J_Layout" class="span16 layout-outer-content">
                <div class="layout-content " aria-disabled="false" aria-pressed="false" >
                    <div class=" pull-left img-content-li">
                        <span class="label label-important img-delete">删除</span>
                        <div aria-disabled="false"  class="" aria-pressed="false">
                            <img  src="http://img.taobaocdn.com/bao/uploaded/i2/334181946/T1J3RPXBBhXXaH.X6X.JPEG_210x1000.jpg">
                            <p>还是很喜欢.</p>
                        </div>
                    </div>
                    <div class=" pull-left img-content-li">
                        <span class="label label-important img-delete">删除</span>
                        <div aria-disabled="false"  class="" aria-pressed="false">
                            <img  src="http://img.taobaocdn.com/bao/uploaded/i2/334181946/T1J3RPXBBhXXaH.X6X.JPEG_210x1000.jpg">
                            <p>还是很喜欢.</p>
                        </div>
                    </div>
                    <div class=" pull-left img-content-li">
                        <span class="label label-important img-delete">删除</span>
                        <div aria-disabled="false"  class="" aria-pressed="false">
                            <img  src="http://img.taobaocdn.com/bao/uploaded/i2/334181946/T1J3RPXBBhXXaH.X6X.JPEG_210x1000.jpg">
                            <p>还是很喜欢.</p>
                        </div>
                    </div>
                    <div class=" pull-left img-content-li">
                        <span class="label label-important img-delete">删除</span>
                        <div aria-disabled="false"  class="" aria-pressed="false">
                            <img  src="http://img.taobaocdn.com/bao/uploaded/i2/334181946/T1J3RPXBBhXXaH.X6X.JPEG_210x1000.jpg">
                            <p>还是很喜欢.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><s>*</s>商品图片：</label>
            <div class="controls">
                <input name="goods[thumb_list]" type="text" class="input-medium" data-rules="{required : true}">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><s>*</s>兑换积分：</label>
            <div class="controls">
                <input name="goods[redeem_pionts]" type="text" class="input-medium" data-rules="{number:true}">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">商品描述：</label>
            <div class="controls  control-row-auto">
                <textarea name="goods[description]" id="" class="control-row3 input-medium" data-rules="{required : true}"></textarea>
            </div>
        </div>
        <div class="row actions-bar">
            <div class="form-actions span13 offset3">
                <button type="submit" class="button button-primary" id="save-goods">保存</button>
                <button type="reset" class="button" id="cancel-goods">返回</button>
            </div>
        </div>
    </form>

    <!-- script start -->
    <script type="text/javascript">
        BUI.use('bui/form',function(Form){
            var form = new Form.Form({
                srcNode : '#Goods_Form'
            });
            form.render();

            //保存
            $("#save-goods").on('click', function(){
                if(form.isValid()){
                    var param = $._get_form_json("#Goods_Form");
                    $._ajax('/goods/goods/add', param, 'POST', 'JSON', function(json){
                        if(json.code > 0){
                            BUI.Message.Alert(json.msg, function(){
                                window.location.href = '/goods/goods/list';
                            }, 'success');

                        }else{
                            BUI.Message.Alert(json.msg, 'error');
                            this.close();
                        }
                    });
                }
            });
            //返回
            $("#cancel-goods").on('click', function(){
                window.location.href = '/goods/goods/list';
            });
        });



    </script>
    <!-- script end -->
</div>
</body>
</html>