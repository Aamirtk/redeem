<?php
error_reporting(E_ERROR);
use yii\helpers\Html;

?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>编辑会员行业分类</title>
    <link href="http://g.alicdn.com/bui/bui/1.1.21/css/bs3/dpl.css" rel="stylesheet">
    <link href="http://g.alicdn.com/bui/bui/1.1.21/css/bs3/bui.css" rel="stylesheet">
    <?= Html::jsFile('@web/Js/jquery.js') ?>
    <?= Html::jsFile('@web/Js/bui-min.js') ?>


    <script>

    </script>
    <style>
        /**内容超出 出现滚动条 **/
        .bui-stdmod-body{
            overflow-x : hidden;
            overflow-y : auto;
        }
    </style>
</head>

<body>
<div class="container" style="float: left">
    <div class="row">
        <div class="well">
            <!--  新增--基本信息  -->
            <div id="vip_content" style="display:block;">
                <form id="vip_form" class="form-horizontal" action="<?= Yii::$app->urlManager->createUrl('vip/vip/ajax-finance-check') ?>" method="post">
                    <div class="control-group">
                        <h2 class="offset1">会员行业分类</h2>
                    </div>
                    <div class="control-group">
                        <h3 class="offset1">  --  您现在会员等级为：<strong><?= $group_name ?></strong>；可以选择<strong><?= $proj_num_lv1 ?>个一级</strong>行业下面的共<strong><?= $proj_num_lv2 ?>个二级</strong>行业</h3>
                    </div>


                    <div class="control-group">
                        <div>
                            <button id="" onclick="return false;" class="button">选择行业</button>
                        </div>
                        <div id="t1">

                        </div>

                        <h3>已选中 <span id="ptype"><?= $proj_num_lv1 ?></span>个一级行业中的 <span id="stype"><?= $proj_num_lv1 ?></span>个二级行业</h3>
                        <div class="log well"></div>
                    </div>
                    <div class="control-group">
                        <div class="row actions-bar">
                            <div class="form-actions span2 offset3">
                                <input type="button"  class="button button-success click_submit" savetype="1" value="保存">
                            </div>
                            <div class="form-actions span2">
                                <input type="button"  class="button button-danger click_submit" savetype="0" value="取消">
                            </div>
                            <div class="form-actions span2">
<!--                                <button type="reset"  class="button button-primary reset_submit" >清空</button>-->
                            </div>

                        </div>
                    </div>

                </form>
            </div>



        </div>
    </div>


</div>
<script type="text/javascript">

    BUI.use(['bui/tree'],function (Tree) {
        var data = <?= $industryJson ?>;
        //数据缓冲类
        var data = <?= $industryJson ?>;
        var tree = new Tree.TreeList({
            render : '#t1',
            root : {                  //由于要显示根节点，所以需要配置根节点
                id : '0',
                text : '所有行业',
                expanded : true,
            },
            showLine : true,
            height:250,
            nodes : data,
            checkType : 'all',
            showRoot : true
        });
        tree.render();

        var levelArr = [];
        var level1_arr = [];
        var level2_arr = [];
        var level1_num = <?= $proj_num_lv1 ?>;
        var level2_num = <?= $proj_num_lv2 ?>;
        var username = '<?= $username ?>';
        tree.on('itemclick',function(ev){
            levelArr = [];
            level1_arr = [];
            level2_arr = [];
            var nodes = tree.getCheckedNodes();
            BUI.each(nodes, function(node, i){
                var leve = {};
                //一级行业
                if(node.level == 2 || (node.level == 1 && node.leaf == 1)){
                    $.inArray(node.ptype, level1_arr) == -1 ? level1_arr.push(node.ptype) : false;
                }
                //二级行业
                if(node.level == 2 || (node.level == 1 && node.leaf == 1)){//二级行业节点或者一级行业根节点
                    if($.inArray(node.stype, level2_arr) == -1){
                        level2_arr.push(node.stype);
                        leve.username = username;
                        leve.ptype = node.ptype;
                        leve.stype = node.stype;
                        leve.old_ptype = node.old_ptype;
                        leve.old_stype = node.old_stype;
                        levelArr.push(leve);
                    }
                }
            });

            var checkedNodes = tree.getCheckedNodes();
            var str = '';
            BUI.each(checkedNodes,function(node){
                if(node.level ==2){
                    str += node.ptype_name +'--' + node.stype_name  + ', ';
                }
            });
            $('.log').text(str);
            $("#ptype").text(level1_arr.length);
            $("#stype").text(level2_arr.length);
        });

        $(".click_submit").on('click', function(){
            var savetype = parseInt($(this).attr("savetype"));
            if(savetype == 0 ){
                window.location.href = '/vip/vip/list-info';
                return false;
            }
            if(level1_arr.length > level1_num){
                BUI.Message.Alert('一级行业不能超过' + level1_num + '个！', 'error');
                return false;
            }
            if(level2_arr.length > level2_num){
                BUI.Message.Alert('二级行业不能超过' + level2_num + '个！', 'error');
                return false;
            }
            if(!(level1_arr.length > level1_num) && !(level2_arr.length > level2_num)){
                ajaxSaveVipIndusties(levelArr, username);
            }
        });
        tree.fire('itemclick');
});
</script>
<script type="text/javascript">
    function ajaxSaveVipIndusties(indarr, username){
        $.ajax({
            type: "post",
            data: {indarr: indarr, username: username},
            url: '/vip/vip/ajax-save-vip-indust',
            dataType: "json",
            success: function (json) {
                if (json.result) {
                    BUI.Message.Alert('保存成功', function () {
                        window.location.href = '/vip/vip/list-info';
                    }, 'success');
                }
                else {
                    BUI.Message.Alert('保存失败', function () {
                        window.location.href = '/vip/vip/list-info';
                    }, 'error');
                }
            }
        });
    }
</script>
</body>
</html>
