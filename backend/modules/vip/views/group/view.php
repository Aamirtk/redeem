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
    <div class="detail-page">
        <div class="detail-section">
            <h3>基本信息</h3>
            <div class="row detail-row">
                <input name="id" type="hidden" value="<?= isset($groups['id']) ? $groups['id'] : '' ?>"/>
                <?php if (isset($groups['id'])) { ?>
                    <div class="span8"><label class="control-label">ID：&nbsp;&nbsp;&nbsp;<?= isset($groups['id']) ? $groups['id'] : '' ?></label>
                    </div>
                <?php } ?>
                <div class="span8">
                    <label class="control-label">状态：<?= isset($groups['status']) ? ($groups['status'] == 1 ? '有效' : '') : '无效' ?></label>
                </div>
            </div>
            <div class="row detail-row">
                <div class="span8">
                    <label class="control-label">名称：<?= isset($groups['name']) ? $groups['name'] : '' ?></label>
                </div>
                <div class="span8">
                    <label class="control-label">售价：<?= isset($groups['price']) ? $groups['price'] : '0' ?>元</label>
                </div>
            </div>
        </div>
        <div class="detail-section">
            <h3>服务商库</h3>
            <div class="row detail-row">
                <div class="span8">
                    <label class="control-label">商机推送：<?= isset($groups['business_push']) ? $groups['business_push'] : '0' ?>万元</label>
                </div>
            </div>
            <div class="row detail-row">
                <div class="span8">
                    <label class="control-label">商铺类型：<?= isset($groups['shop_type']) ? ($groups['shop_type'] == 1 ? '普通版' : '高级版') : '' ?></label>
                </div>
            </div>
            <div class="row detail-row">
                <div class="span8">
                    <label class="control-label">可入住类目数量：<?= isset($groups['proj_num_lv1']) ? $groups['proj_num_lv1'] : '0' ?>个一级&nbsp;&nbsp;&nbsp;<?= isset($groups['proj_num_lv2']) ? $groups['proj_num_lv2'] : '' ?>个二级</label>
                </div>
            </div>
        </div>
        <div class="detail-section">
            <h3>渲染</h3>
            <div class="row detail-row">
                <div class="span8">
                    <label class="control-label">渲染时长：<?= isset($groups['render_time']) ? $groups['render_time'] : '0' ?>分钟</label>
                </div>
            </div>
        </div>
        <div class="detail-section">
            <h3>虚拟工作室</h3>
            <div class="row detail-row">
                <div class="span8">
                    <label class="control-label">项目上限：<?= isset($groups['proj_limit']) ? $groups['proj_limit'] : '' ?>个</label>
                </div>
                <div class="span8">
                    <label class="control-label">项目成员数量上限：<?= isset($groups['proj_user_limit']) ? $groups['proj_user_limit'] : '0' ?>人</label>
                </div>
            </div>
            <div class="row detail-row">
                <div class="span8">
                    <label class="control-label">可加入工作室上限：<?= isset($groups['studio_limit']) ? $groups['studio_limit'] : '0' ?>人</label>
                </div>
                <div class="span8">
                    <label class="control-label">工作室人数上限：<?= isset($groups['studio_user_limit']) ? $groups['studio_user_limit'] : '0' ?>人</label>
                </div>
            </div>
            <hr>
            <div class="row detail-row offset1">
                <div class="controls">
                    <a class="button button-primary centered " type="button"
                       href="<?= Yii::$app->urlManager->createUrl('vip/group/edit?id=' . (isset($groups['id']) ? $groups['id'] : '')) ?>">修改</a>
                    <a class="button button-primary centered " type="button"
                       href="<?= Yii::$app->urlManager->createUrl('vip/group/list-view') ?>">返回会员类型列表</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
