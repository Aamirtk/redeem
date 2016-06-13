<link type="text/css" rel="stylesheet" href="/css/rc_case.css">
<script type="text/javascript">
    <?php require_once(Yii::getAlias('@frontend') . '/webrc/js/enterprise/news.js') ?>
    $(function(){
        news_ctl.hotNewsList("<?= $model['obj_id'];?>");
    })
</script>
<!--banner-->
<?php require_once(Yii::getAlias('@frontend') . '/modules/enterprise/views/layout/banner.php')?>
<!--/banner-->

<!--topnav-->
<div class="dynamic-news case-top clear-float">
    <ul class="case-top-nav">
        <li>
            <a href="http://rc.vsochina.com/">
                <i class="icon-12 icon-12-home"></i>
                <span>人才库首页</span>
            </a>
        </li>
        <li>
            <a href="<?php echo yii::$app->urlManager->createUrl("/enterprise") ?>">
                <i class="top-nav-space">/</i>
                <span><?= $this->context->company['name']?></span></a>
            </a>
        </li>
        <li>
            <a href="<?= ($model['obj_type'] == "site") ? 'javascript:void(0);' : yii::$app->urlManager->createUrl("enterprise-news")  ?>">
                <i class="top-nav-space">/</i>
                <span>新闻·简介</span>
            </a>
        </li>
        <li class="cur">
            <a href="javascript:;">
                <i class="top-nav-space">/</i>
                <span><?= $model['title']?></span>
            </a>
        </li>
    </ul>
    <div class="case-top-title">
        <span><?= $model['title']?></span>
    </div>
    <div class="case-top-turn">
        <a href="<?= empty($prevModel) ? 'javascript:void(0);' : yii::$app->urlManager->createUrl("enterprise-news-" . $prevModel["id"]) ?>" class="top-turn-prev">
            <i class="icon-20 icon-20-prev"></i>
        </a>
        <a href="<?= empty($nextModel) ? 'javascript:void(0);' : yii::$app->urlManager->createUrl("enterprise-news-" . $nextModel["id"]) ?>" class="top-turn-next">
            <i class="icon-20 icon-20-next"></i>
        </a>
    </div>
</div>
<!--/topnav-->

<!--hotcase-->
<div class="dynamic-news case-hotcase clear-float">
    <div class="case-hotcase-top clear-float">
        <span class="hotcase-top-title">热门动态</span>
<!--        <a href="javascript:void(0);" class="hotcase-top-operate">换一换</a>-->
    </div>
    <ul class="hot-news-list clear-float" id="hot_news">

    </ul>
<!--    <ul class="hot-news-imglist">-->
<!--        <li>-->
<!--            <a target="_blank" href="javascript:void(0);">-->
<!--                <img src="/images/rc/enterprise/case-demo2.jpg">-->
<!--            </a>-->
<!--        </li>-->
<!--        <li>-->
<!--            <a target="_blank" href="javascript:void(0);">-->
<!--                <img src="/images/rc/enterprise/case-demo2.jpg">-->
<!--            </a>-->
<!--        </li>-->
<!--    </ul>-->
</div>
<!--/hotcase-->

<!--content-->
<div class="dynamic-news case-content">
    <div class="case-content-top clear-float">
        <div class="content-top-case">
            <p class="content-top-title"><?= $model['title']?></p>
            <p class="content-top-subtitle clear-float">
                <span><?= date("Y-m-d", $model['created_at'])?></span>
                <b>|</b>
                <!--<span>5153浏览人数 暂无</span>
                <b>|</b>-->
                <?php if (isset($user['nickname'])):?>
                <span><?= $user['nickname']?></span>
                <?php endif;?>
            </p>
        </div>
        <!-- <dl class="content-top-enterprise clear-float">
            <dt>
                <a href="javascript:void(0);">
                    <img src="/images/rc/enterprise/case-demo3.png">
                </a>
            </dt>
            <dd class="content-top-name">苏州和氏设计有限公司</dd>
            <dd class="content-top-tel">400-164-7979</dd>
        </dl> -->
    </div>
    <div class="case-content-mainpart">
        <div class="content-mainpart-detail">
            <?= $model['content']?>
        </div>
    </div>
    <div class="case-content-page">
        <div class="mainpart-page-last">
            <?php if(empty($prevModel)):?>
                <a href="javascript:void(0);">
                    上一篇：暂无
                </a>
            <?php else:?>
                <a href="<?= yii::$app->urlManager->createUrl("enterprise-news-" . $prevModel['id']) ?>">
                    上一篇：<?= $prevModel['title']?>
                </a>
            <?php endif;?>
        </div>
        <div class="mainpart-page-next">
            <?php if(empty($nextModel)):?>
                <a href="javascript:void(0);">
                    下一篇：暂无
                </a>
            <?php else:?>
                <a href="<?= yii::$app->urlManager->createUrl("enterprise-news-" . $nextModel['id']) ?>">
                    下一篇：<?= $nextModel['title']?>
                </a>
            <?php endif;?>
        </div>
    </div>
</div>
<!--/content-->

<script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>