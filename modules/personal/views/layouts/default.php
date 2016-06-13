<?php
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use app\widgets\personal\HeaderWidget;
use app\widgets\personal\FooterWidget;
//use frontend\modules\personal\models\Person;
//use frontend\modules\talent\models\User;
AppAsset::register($this);
$info = [
    'user_info'=>$this->context->user_info,
    'obj_username'=>$this->context->obj_username,
    'is_self'=>$this->context->is_self,
    'vso_uname'=>$this->context->vso_uname,
    ];
?>
<?php $this->beginPage() ?>
<!--加载header-->
<?= HeaderWidget::widget($info) ?>
<!--加载内容-->
<?php $this->beginBody() ?>
<?= Alert::widget() ?>
<?= $content ?>
<?php $this->endBody() ?>
<!--加载footer-->
<?= FooterWidget::widget($info) ?>
