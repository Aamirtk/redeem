<script type="text/javascript">
    $(function(){
        $("#ent_index").addClass("active");
    });
</script>

<!--content-->
<?php require_once(Yii::getAlias('@frontend') . '/modules/enterprise/views/layout/header.php')?>
<div class="enterprise-title text-center">
    <p class="font24">Case Show</p>
    <p class="font20">案例展示</p>
</div>
<div class="enterprise-shows">
    <div class="m-warp">
        <ul class="enterprise-shows-ul row clearfix">
            <?php foreach($list as $key => $value): ?>
                <li class="col-xs-4"><a href="<?= yii::$app->urlManager->createUrl("enterprise-work-" . $value['id']);?>"><img src="<?= $value['work_url']?>" alt=""><span><?= $value['work_name']?></span></a></li>
            <?php endforeach;?>
        </ul>
    </div>

</div>
<div class="enterprise-title text-center">
    <p class="font24">LATEST NEWS</p>
    <p class="font20">公司动态</p>
</div>

<div class="enterprise-news clearfix">
    <div class="m-warp clearfix">
        <dl class="enterprise-news-dl">
            <dt>
                <img class="company-logo" src="<?= $this->context->company['logo']?>" alt="" style="<?php if(empty($this->context->company['logo'])):?>display: none;<?php endif;?>">
            </dt>
            <dd class="enterprise-news-dl-title"><?= $this->context->company['name']?></dd>
            <!--<dd class="enterprise-news-dl-time">2015-11-12</dd>-->
            <dd>
                <?= strip_tags($this->context->company['description']);?>
                <div><a href="<?php echo Yii::$app->urlManager->createUrl("enterprise-news") ?>">查看完整</a></div>
            </dd>
        </dl>
        <div class="enterprise-news-cut"></div>
        <ul class="enterprise-news-list">
            <?php foreach($newslist as $key => $value): ?>
                <li class="clearfix"><b>●</b>　<a href="<?= yii::$app->urlManager->createUrl("enterprise-news-" . $value['id']) ;?>" target="_blank"><?= $value['title']?></a></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>