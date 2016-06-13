<?php
use app\widgets\home\HeaderWidget;
use app\widgets\home\FooterWidget;

$info = [
    'site'=>$this->context->site,
    'action' => yii::$app->controller->action->id,
    'user_info' => $this->context->user_info,
];
$_head_foot = in_array($info['action'], ['mindex', 'mlist', 'mquanzi', 'mrank', 'mactivity','mentry','registersucess']);
?>
<?php $this->beginPage() ?>
<?= $_head_foot ? HeaderWidget::widget($info) : ''; ?>
<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>
<?= $_head_foot ? FooterWidget::widget() : ''; ?>
