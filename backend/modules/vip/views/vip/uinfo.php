<?php
error_reporting(E_ERROR);
use yii\helpers\Html;

?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>用户平台信息</title>
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
                    <div class="control-group">
                        <h2 class="offset1">用户平台信息</h2>
                    </div>
                    <div class="control-group">
                        <div class="control-group span7">
                            <label class="control-label">注册ID：</label>
                            <div class="controls">
                                <span class="control-text" v-role="company-tel"><?= $info['username'] ?></span>
                            </div>
                        </div>
                        <div class="control-group span7">
                            <label class="control-label">真实名称：</label>
                            <div class="controls">
                                <span class="control-text" v-role="company-tel"><?= $info['truename'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-group span7">
                            <label class="control-label">QQ：</label>
                            <div class="controls">
                                <span class="control-text" v-role="company-tel"><?= $info['qq'] ?></span>
                            </div>
                        </div>
                        <div class="control-group span7">
                            <label class="control-label">昵称：</label>
                            <div class="controls">
                                <span class="control-text" v-role="company-tel"><?= $info['nickname'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-group span7">
                            <label class="control-label">联系方式：</label>
                            <div class="controls">
                                <span class="control-text" v-role="company-tel"><?= $info['mobile'] ?></span>
                            </div>
                        </div>
                        <div class="control-group span7">
                            <label class="control-label">邮箱：</label>
                            <div class="controls">
                                <span class="control-text" v-role="company-tel"><?= $info['email'] ?></span>
                            </div>
                        </div>

                    </div>
                    <div class="control-group">
                        <div class="control-group span7">
                            <label class="control-label">通信地址：</label>
                            <div class="controls">
                                <span class="control-text" v-role="company-tel"><?= $info['address'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-group span7">
                            <label class="control-label">详细描述：</label>
                            <div class="controls">
                                <span class="control-text" v-role="company-tel"><?= $info['introduction'] ?></span>
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

</body>
</html>
