<?php
use yii\helpers\Html;
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>企业录入</title>
    <?= Html::cssFile('@web/assets/css/calendar-min.css') ?>
    <?= Html::cssFile('@web/assets/css/dpl-min.css') ?>
    <?= Html::cssFile('@web/assets/css/bui-min.css') ?>
    <?= Html::cssFile('@web/assets/css/page-min.css') ?>
    <?= Html::jsFile('@web/Js/jquery.js') ?>
    <?= Html::jsFile('@web/assets/js/bui-min.js') ?>
    <?= Html::jsFile('@web/Js/common/common.js?v=1.0.0') ?>
    <?= Html::jsFile('@web/Js/common/daterange.js') ?>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="well">
            <!--  新增  -->
            <form id="groups_form" class="form-horizontal" action="<?= Yii::$app->urlManager->createUrl('vip/group/update') ?>" method="post">
                <div class="detail-section">
                    <h3>基本信息</h3>
                    <div class="control-group">
                        <input name="id" type="hidden" value="<?= isset($groups['id']) ? $groups['id'] : '' ?>"/>
                        <?php if (isset($groups['id'])) { ?><label class="control-label">ID：&nbsp;&nbsp;&nbsp;<?= isset($groups['id']) ? $groups['id'] : '' ?></label><?php } ?>
                        <label class="control-label">状态：</label>
                        <div class="controls">
                            <label class="radio" for=""><input type="radio" name="status" value="1" <?= isset($groups['status']) ? ($groups['status'] == 1 ? 'checked' : '') : '' ?>>有效</label>&nbsp;&nbsp;&nbsp;
                            <label class="radio" for=""><input type="radio" name="status" value="0" <?= isset($groups['status']) ? ($groups['status'] == 0 ? 'checked' : '') : '' ?>>无效</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">名称：</label>
                        <div class="controls">
                            <input name="name" class="input-normal control-text"
                                   data-rules="{required:true,maxlength:15}" type="text"
                                   value="<?= isset($groups['name']) ? $groups['name'] : '' ?>"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">售价：</label>
                        <div class="controls">
                            <input name="price" class="input-normal control-text"
                                   data-rules="{required:true,min:0,maxlength:11}" type="number"
                                   value="<?= isset($groups['price']) ? $groups['price'] : '' ?>"/>
                        </div>
                    </div>
                </div>
                <div class="detail-section">
                    <h3>服务商库</h3>
                    <div class="control-group">
                        <label class="control-label">商机推送：</label>
                        <div class="controls">
                            <input name="business_push" class="input-normal control-text"
                                   data-rules="{required:true,min:0,maxlength:11}" type="number"
                                   value="<?= isset($groups['business_push']) ? $groups['business_push'] : '' ?>"/> 万元
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">商铺类型：</label>
                        <div class="controls">
                            <label class="radio" for=""><input type="radio" name="shop_type" value="1" <?= isset($groups['shop_type']) ? ($groups['shop_type'] == 1 ? 'checked' : '') : '' ?>>普通版</label>&nbsp;&nbsp;&nbsp;
                            <label class="radio" for=""><input type="radio" name="shop_type" value="2" <?= isset($groups['shop_type']) ? ($groups['shop_type'] == 2 ? 'checked' : '') : '' ?>>高级版</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">可入住类目数量</label>
                        <div class="controls">
                            <input name="proj_num_lv1" class="input-normal control-text"
                                   data-rules="{required:true,min:0,maxlength:11}" type="number"
                                   value="<?= isset($groups['proj_num_lv1']) ? $groups['proj_num_lv1'] : '' ?>"/>一级
                            <input name="proj_num_lv2" class="input-normal control-text"
                                   data-rules="{required:true,min:0,maxlength:11}" type="number"
                                   value="<?= isset($groups['proj_num_lv2']) ? $groups['proj_num_lv2'] : '' ?>"/>二级
                        </div>
                    </div>
                </div>
                <div class="detail-section">
                    <h3>渲染</h3>
                    <div class="control-group">
                        <label class="control-label">渲染时长：</label>
                        <div class="controls">
                            <input name="render_time" class="input-normal control-text"
                                   data-rules="{required:true,min:0,maxlength:11}" type="number"
                                   value="<?= isset($groups['render_time']) ? $groups['render_time'] : '' ?>"/>分钟
                        </div>
                    </div>
                </div>
                <div class="detail-section">
                    <h3>虚拟工作室</h3>
                    <div class="control-group">
                        <label class="control-label">项目上限：</label>
                        <div class="controls">
                            <input name="proj_limit" class="input-normal control-text"
                                   data-rules="{required:true,min:0,maxlength:11}" type="number"
                                   value="<?= isset($groups['proj_limit']) ? $groups['proj_limit'] : '' ?>"/>个
                        </div>
                        <label class="control-label">项目成员数量上限：</label>
                        <div class="controls">
                            <input name="proj_user_limit" class="input-normal control-text"
                                   data-rules="{required:true,min:0,maxlength:11}" type="number"
                                   value="<?= isset($groups['proj_user_limit']) ? $groups['proj_user_limit'] : '' ?>"/>个
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">可加入工作室上限：</label>
                        <div class="controls">
                            <input name="studio_limit" class="input-normal control-text"
                                   data-rules="{required:true,min:0,maxlength:11}" type="number"
                                   value="<?= isset($groups['studio_limit']) ? $groups['studio_limit'] : '' ?>"/>个
                        </div>
                        <label class="control-label">工作室人数上限：</label>
                        <div class="controls">
                            <input name="studio_user_limit" class="input-normal control-text"
                                   data-rules="{required:true,min:0,maxlength:11}" type="number"
                                   value="<?= isset($groups['studio_user_limit']) ? $groups['studio_user_limit'] : '' ?>"/>个
                        </div>
                    </div>
                    <hr>
                    <div class="control-group offset1">
                        <div class="controls">
                            <input class="button button-primary centered" type="submit" value="提交"/>
                            <a class="button button-primary centered " type="button"
                               href="<?= Yii::$app->urlManager->createUrl('vip/group/list-view') ?>">返回会员类型列表</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    BUI.use('bui/form', function (Form) {
        new Form.Form({
            srcNode: '#groups_form',
            submitType: 'ajax',
            callback: function (json) {
                if (json.result) {
                    BUI.Message.Alert('保存成功', 'success');
                    top.topManager.reloadPage();
                }
                else {
                    BUI.Message.Alert('保存失败', 'error');
                }
            }
        }).render();
    });
    /**
     * 保存
     */
    function saveGroups() {
        var f = $("#groups_form");
        $.ajax({
            type: "post",
            url: "<?= Yii::$app->urlManager->createUrl('vip/group/update') ?>",
            data: f.serialize(),
            dataType: "json",
            success: function (json) {
                if (json.result) {
                    BUI.Message.Alert('保存成功', 'success');
                    top.topManager.reloadPage();
                }
                else {
                    BUI.Message.Alert('保存失败', 'error');
                }
            }
        });
    }
</script>
</body>
</html>
