<?php
$agent = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : '';
if(strpos($agent,"MSIE 8.0") || strpos($agent,"MSIE 7.0") || strpos($agent,"MSIE 6.0"))
{
    require_once(Yii::getAlias('@frontend') . '/modules/enterprise/views/upload/default.php');
}
if(strpos($agent,'MSIE') !== false || strpos($agent,'rv:11')) //ie11判断
{
    require_once(Yii::getAlias('@frontend') . '/modules/enterprise/views/upload/index.php');
}
else if(strpos($agent,'Firefox') !== false)
{
    require_once(Yii::getAlias('@frontend') . '/modules/enterprise/views/upload/index.php');
}
else if(strpos($agent,'Chrome') !== false)
{
    require_once(Yii::getAlias('@frontend') . '/modules/enterprise/views/upload/index.php');
}
else if(strpos($agent,'Opera') !== false)
{
    require_once(Yii::getAlias('@frontend') . '/modules/enterprise/views/upload/index.php');
}
else if((strpos($agent,'Chrome') == false) && strpos($agent,'Safari') !== false)
{
    require_once(Yii::getAlias('@frontend') . '/modules/enterprise/views/upload/index.php');
}
else
{
    require_once(Yii::getAlias('@frontend') . '/modules/enterprise/views/upload/default.php');
}
?>
<div class="enterprise-banner" id="upload_bg">
    <?php
    $banner = $this->context->company['banner'];
    $logo = $this->context->company['logo'];
    if (empty($banner))
    {
        $banner = yii::$app->params['default_enterprise_banner'];
    }
    ?>
    <img src="<?= $banner ?>" alt="<?= $this->context->company['name']?>" class="enterprise-banner-bg">
    <div class="enterprise-banner-info">
        <input type="hidden" id="company_id" value="<?= $this->context->company['id']?>" />
        <div class="bg-img-div">
            <img src="<?= $logo ?>" title="<?= $this->context->company['name']?>" height="132" >
            <span class="vso-vip-20 vso-vip-<?= $this->context->company['user_vip_lv']?>" title="<?= $this->context->company['user_vip_lvname']?>"><?= $this->context->company['user_vip_lvname']?></span>
        </div>
        <p class="f26"><?= $this->context->company['name']?></p>
        <?php if($this->context->is_self):?>
        <a class="btn btn-black bg-img-div">
            <span class="glyphicon glyphicon-cog"></span>
            基础设置
        </a>
       <?php endif;?>
    </div>
</div>
<div class="enterprise-banner-nav">
    <div class="enterprise-nav-bg"></div>
    <ul>
        <li id="ent_index"><a href="/enterprise">企业首页</a></li>
        <li id="ent_case_list"><a href="/enterprise-work">案例展示</a></li>
        <? if($this->context->has_shop): ?>
        <li id="ent_goods_list"><a href="/enterprise-goods">可售商品</a></li>
        <!--<li id="ent_service_list"><a href="/enterprise/service/list/<?= $username?>">可售服务</a></li>-->
        <? endif ?>
        <li id="ent_record" <?php if(isset($this->context->company['record_is_show']) && $this->context->company['record_is_show'] !=1){echo "style='display:none;'";}?>>
            <div class="enterprise-nav-a">
                <?php if(yii::$app->controller->module->id == "enterprise" && yii::$app->controller->action->id == "mark"):?>
                    交易评价
                <?php else:?>
                    交易记录
                <?php endif;?>
                <span class="glyphicon glyphicon-triangle-bottom"></span>
                <div class="enterprise-nav-div">
                    <a id="ent_record_index" href="/enterprise-record-mark">交易评价</a>
                    <a id="ent_record_history" href="/enterprise-record">交易记录</a>
                </div>
            </div>
        </li>
        <li id="ent_dynamic"><a href="/enterprise-news">企业动态</a></li>
    </ul>
</div>