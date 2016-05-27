<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>信用体系管理后台--负面影响记录</title>
    <?= Html::cssFile('@web/assets/css/calendar-min.css') ?>
    <?= Html::cssFile('@web/assets/css/dpl-min.css') ?>
    <?= Html::cssFile('@web/assets/css/bui-min.css') ?>
    <?= Html::cssFile('@web/assets/css/page-min.css') ?>
    <?= Html::jsFile('@web/Js/jquery.js') ?>
    <?= Html::jsFile('@web/assets/js/bui-min.js') ?>
    <?= Html::jsFile('@web/Js/common/common.js?v=1.0.0') ?>
    <?= Html::jsFile('@web/Js/common/daterange.js') ?>
    <style type="text/css">
        .table{
            width: 200%;
        }
        .table td {
            width: 400px;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="main">
                        <div class="row">
                            <div class="span12 offset3 doc-content">
                                <table cellspacing="0" class="table table-bordered">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>账号</td>
                                        <td><?= isset($userinfo[0]['username']) ? $userinfo[0]['username'] : ''; ?></td>
                                        <td>姓名</td>
                                        <td><?= isset($userinfo[0]['truename']) ? $userinfo[0]['truename'] : ''; ?></td>
                                        <td>注册日期</td>
                                        <td><?= isset($userinfo[0]['create_time']) ? date('Y-m-d : H:i:s',$userinfo[0]['create_time']) : ''; ?></td>
                                    </tr>
                                    <tr>
                                        <td>用户等级</td>
                                        <td><?= isset($userinfo[0]['point_level']) ? $userinfo[0]['point_level'] : ''; ?></td>
                                        <td>信用分</td>
                                        <td><?= isset($userinfo[0]['trust']) ? $userinfo[0]['trust'] : ''; ?></td>
                                        <td>上期信用分</td>
                                        <td><?= isset($userinfo[1]['trust']) ? $userinfo[1]['trust'] : ''; ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                <div class="row">
                    <div class=" span8 doc-content" style="margin-left: 130px;width: 940px;">
                        <?php if (Yii::$app->session->hasFlash('success')): ?>
                            <div class="alert alert-success text">
                                <b><?= Yii::$app->session->getFlash('success') ?></b>
                            </div>
                        <?php endif ?>
                        <?php if (Yii::$app->session->hasFlash('error')): ?>
                            <div class="alert alert-error text">
                                <b><?= Yii::$app->session->getFlash('error') ?></b>
                            </div>
                        <?php endif ?>
                        <form class="form-horizontal well" action="/trust/user/negative-add" method="post">
                            <input type="hidden" name="username" value="<?= $username ?>" />
                            <div class="control-group">
                                <label class="control-label radio">
                                    <input type="radio" name="select_radio_trust" value="1"  checked="checked"> 选择扣分项
                                </label>
                            </div>
                            <div class="control-group">
                                <label class="control-label">选择扣分项目：</label>
                                <div class="controls">
                                    <select name="select_trust">
                                        <?php foreach ($rulesNegative as $v) { ?>
                                            <option value="<?= $v['id'] ?>"><?= $v['content'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label radio">
                                    <input type="radio" name="select_radio_trust" value="2"> 自定义扣分
                                </label>
                            </div>

                            <div class="control-group">
                                <label class="control-label">负面信息内容：</label>
                                <div class="controls"><input class="input-normal control-text" type="text" name="negative_content"></div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">负面信息分值：</label>
                                <div class="controls"><input class="input-normal control-text" type="text" name="negative_point"></div>
                            </div>

                            <div class="row">
                                <div class="form-actions offset3">
                                    <button type="submit" class="button button-primary">保存</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>