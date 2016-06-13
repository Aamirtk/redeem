<?php
$banner = $this->context->company['banner'];
$logo = $this->context->company['logo'];
if (empty($banner))
{
    $banner = yii::$app->params['default_enterprise_banner'];
}
?>
<!--banner-->
<div class="dynamic-news case-banner">
    <img src="<?= $banner?>">
</div>
<!--/banner-->