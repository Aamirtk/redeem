<?php
error_reporting(E_ERROR);
use yii\helpers\Html;

?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>会员编辑</title>
    <?= Html::cssFile('@web/css/bs3_dpl.css') ?>
    <?= Html::cssFile('@web/css/bui-min.css') ?>
    <?= Html::cssFile('@web/css/page-min.css') ?>
    <?= Html::jsFile('@web/Js/jquery.js') ?>
    <?= Html::jsFile('@web/Js/bui-min.js') ?>
    <?= Html::jsFile('@web/Js/vip.js') ?>
    <script>

    </script>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="well">
            <!--  新增--基本信息  -->
            <div id="vip_content" style="display:block;">
                <form id="vip_form" class="form-horizontal"
                      action="<?= Yii::$app->urlManager->createUrl('vip/vip/ajax-save-vip') ?>" method="post">
                    <!--其他参数-->
                    <input name="action_type" type="hidden" value="update"/>
                    <input name="mid" type="hidden" value="<?= $vip['id'] ?>"/>

                    <div class="control-group">
                        <h2 class="offset1">客户信息录入</h2>
                    </div>
                    <div class="row offset1">
                        <div class="control-group">
                            <label class="control-label"><s>*</s>客户名称：</label>
                            <div class="controls">
                                <span class="control-text" v-role="company-tel"><?= $vip['name'] ?></span>
                                <input name="name" class="input-normal control-text" v-role="name"
                                       data-rules="{required:true,valid_name:5}" value="<?= $vip['name'] ?>"
                                       type="hidden"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><s>*</s>用户ID：</label>
                            <div class="controls ">
                                <span class="control-text" v-role="company-tel"><?= $vip['username'] ?></span>
                                <input name="username" class="input-normal control-text" v-role="username"
                                       data-rules="{required:true}" value="<?= $vip['username'] ?>" type="hidden"/>
                            </div>
                            <div class="control-group ">
                                <label class="control-label"></label>
                                <div class="controls">
                                    <a href="javaScript:void(0)" id="vip_logo_upload" onclick="loadUserInfo()">【查看用户平台信息】</a>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label"><s>*</s>联系人：</label>

                            <div class="controls">
                                <input name="contact" class="input-normal control-text" v-role="contact"
                                       data-rules="{required:true}" value="<?= $vip['contact'] ?>" type="text"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><s>*</s>联系方式：</label>

                            <div class="controls">
                                <input name="phone" class="input-normal control-text" v-role="phone"
                                       data-rules="{required:true}" value="<?= $vip['phone'] ?>" type="text"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><s>*</s>通信地址：</label>

                            <div class="controls">
                                <input name="address" class="input-normal control-text" v-role="address"
                                       data-rules="{required:true}" value="<?= $vip['address'] ?>" type="text"/>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="control-group ">
                        <h2 class="offset1">会员等级信息录入</h2>
                    </div>
                    <div class="row offset1">
                        <div class="control-group">
                            <label class="control-label"><s>*</s>会员等级：</label>

                            <div class="controls">
                                <?php foreach ($groups as $k => $v)
                                {
                                    ; ?>
                                    <?php $selected = ($v['id'] == $vip['group_id']) ? 'checked="checked"' : '' ?>
                                    <label class="radio">
                                        <input type="radio" name="group_id" v-role="group_id" class="basic_score_value"
                                               data-rules="{required:true}"
                                               value="<?= $v['id'] ?>" <?= $selected ?>
                                               onclick="loadGroupDetail(<?= $v['id'] ?>);"><?= $v['name'] ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </label>
                                <?php }; ?>
                            </div>
                        </div>
                        <div class="control-group " style="width: auto;height: 300px ;">
                            <label class="control-label">增值服务点：</label>

                            <div class="controls" id="group_detail">
                            </div>
                        </div>
                        <div class="control-group ">
                            <label class="control-label"><s>*</s>会员年限：</label>

                            <div class="controls">
                                <select name="buy_num" id="buy_num">
                                    <?php foreach ($durations as $key => $val): ?>
                                        <?php $selected = ($key == 1) ? 'selected="selected"' : '' ?>
                                        <option value="<?= $key ?>" <?= $selected ?>><?= $val ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">会员服务费用（元）：</label>
                            <input type="hidden" id="per_price" value="0">
                            <div class="controls">
                                <input name="price" class="input-normal control-text " v-role="price"
                                       disabled="disabled" data-rules="{required:true}" value="<?= $vip['price'] ?>"
                                       type="text"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label"><s>*</s>实缴纳金额（元）：</label>

                            <div class="controls">
                                <input name="pay" class="input-normal control-text" v-role="pay"
                                       data-rules="{required:true}" value="<?= $vip['pay'] ?>" type="text"/>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="row actions-bar">
                        <input type="hidden" name="sub_type" id="sub_type" value="1">
                        <div class="form-actions span2 offset3">
                            <button type="submit"  class="button button-primary save_submit">提交</button>
                        </div>
                        <div class="form-actions">
                            <button type="submit"  class="button button-primary save_draft">存草稿</button>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    BUI.use('bui/form', function (Form) {
        var form = new Form.HForm({
            srcNode: '#vip_form',
            submitType: 'ajax',
            callback: function (data) {
                var form = this;
                if (!data.result && data.errorMessage.errors) {
                    var errors = data.errorMessage.errors;
                    BUI.each(errors, function (v, k) {
                        var field = form.getField(k);
                        if (field) {
                            field.showErrors(v);
                        }
                    });
                }
                else {
                    BUI.Message.Alert('更新成功', function () {
                        window.location.href = '/vip/vip/list';
                    }, 'success');
                }
            }
        }).render();
        //添加 名字为 valid_name的校验规则
        Form.Rules.add({
            name: 'valid_name1',  //规则名称
            msg: '请填写{0}数字的学生编号。',//默认显示的错误信息
            validator: function (value, baseValue, formatMsg) { //验证函数，验证值、基准值、格式化后的错误信息
                var regexp = new RegExp('^\\d{' + baseValue + '}$');
                if (value && !regexp.test(value)) {
                    return formatMsg;
                }
            }
        });

        $(".save_submit").click(function(){
            $("#sub_type").val(1);
        });
        $(".save_draft").click(function(){
            $("#sub_type").val(0);
        });
        $("#buy_num").change(function(){
            var price = $("#per_price").val();
            var buy_num = $(this).find("option:selected").val();
            $("input[name=price]").val((parseFloat(price) * parseInt(buy_num)).toFixed(2));
        });
    });
</script>
<script>
    /**
     * 加载等级信息
     */
    function loadGroupDetail(id) {
        vip.loadGroupDetail(id);
    }
    /**
     * 加载用户详情
     */
    function loadUserInfo() {
        var username = $("input[name=username]").val();
        vip.loadUserInfo(username);
    }

    $(function () {
        loadGroupDetail(<?= $vip['group_id'] ?>);
    });

</script>
</body>
</html>
