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
    <style>
        /**内容超出 出现滚动条 **/
        .bui-stdmod-body {
            overflow-x: hidden;
            overflow-y: auto;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="well">
            <!--  新增--基本信息  -->
            <div id="vip_content" style="display:block;">
                <form id="vip_form" class="form-horizontal" action="<?= Yii::$app->urlManager->createUrl('vip/vip/ajax-save-vip') ?>" method="post">
                    <!--其他参数-->
                    <input name="action_type" type="hidden" value="update"/>
                    <input name="mid" type="hidden" value="<?= $vip['id'] ?>"/>

                    <div class="control-group">
                        <h2 class="offset1">会员信息</h2>
                    </div>
                    <div class="control-group">
                        <div class="control-group span7">
                            <label class="control-label">会员名称：</label>
                            <div class="controls">
                                <span class="control-text" v-role="company-tel"><?= $vip['name'] ?></span>
                            </div>
                        </div>
                        <div class="control-group span7">
                            <label class="control-label">ID：</label>
                            <div class="controls">
                                <span class="control-text" v-role="company-tel"><?= $vip['username'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-group span7">
                            <label class="control-label">录入时间：</label>
                            <div class="controls">
                                <span class="control-text" v-role="company-tel"><?= $vip['input_time'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-group span7">
                            <label class="control-label">启用时间：</label>
                            <div class="controls">
                                <span class="control-text" v-role="company-tel"><?= $vip['valid_begin'] ?></span>
                            </div>
                        </div>
                        <div class="control-group span7">
                            <label class="control-label">结束时间：</label>
                            <div class="controls">
                                <span class="control-text" v-role="company-tel"><?= $vip['valid_end'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-group span7">
                            <label class="control-label">公司地址：</label>
                            <div class="controls">
                                <span class="control-text" v-role="company-tel"><?= $vip['address'] ?></span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="control-group span7">
                            <label class="control-label">审核状态：</label>
                            <div class="controls">
                                <span class="control-text" v-role="company-tel"><?= $vip['check_state'] ?></span>
                            </div>
                        </div>
                    </div>
                    <?php if(isset($vip['check_reason'])):?>
                        <div class="control-group">
                            <div class="control-group span7">
                                <label class="control-label">驳回原因：</label>
                                <div class="controls">
                                    <span class="control-text" v-role="company-tel"><?= $vip['check_reason'] ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <hr>
                    <div class="row">
                        <div class="control-group span7">
                            <label class="control-label">会员等级：</label>
                            <div class="controls">
                                <span class="control-text" v-role="company-tel"><?= $vip['group_name'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-group span7">
                            <label class="control-label">实缴纳金额：</label>
                            <div class="controls">
                                <span class="control-text" v-role="company-tel"><?= $vip['price'] ?>元</span>
                            </div>
                        </div>
                        <div class="control-group span7">
                            <label class="control-label">服务年限：</label>
                            <div class="controls">
                                <span class="control-text" v-role="company-tel"><?= $vip['buy_num'] ?>年</span>
                            </div>
                        </div>

                        <div class="control-group " style="width: auto;height: 300px ;">
                            <label class="control-label">增值服务点：</label>
                            <div class="controls" id="group_detail">
                            </div>
                        </div>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
<script type="text/javascript">

</script>
<script>
    function loadGroupDetail(id) {
        vip.loadGroupDetail(id);
    }
    $(function () {
        loadGroupDetail(<?= $vip['group_id'] ?>);
    });
</script>
</body>
</html>
