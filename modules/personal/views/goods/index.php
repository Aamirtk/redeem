<!--瀑布流-->
<div class="masonry js-masonry">
    <?php if (!empty($goods)) { ?>
        <?php foreach ($goods as $good): ?>
            <div class="masonry-item">
                <div class="masonry-pic-dec">
                    <a target="_blank" href="<?=yii::$app->urlManager->createUrl('/personal-goods-'.$good['goods_id'])?>"
                       title="<?= $good['name'] ?>">
                        <h2 class="masonry-pic-title"><?= $good['name'] ?></h2>
                        <img
                            src="<?= $good['goods_type'] != 'audio' ? _get_thumbnail($good['username'], $good['thumb'], $imgWidth, '',false, 'fit') : Yii::$app->params['auto_goods_cover'] ?>">
                    </a>

                    <div class="masonry-text">
                        <a target="_blank" href="<?=yii::$app->urlManager->createUrl('/personal-goods-'.$good['goods_id'])?>"
                           title="<?= $good['name'] ?>">
<!--                            <p>--><?//= $good['description'] ?><!--</p>-->
                        </a>
                    </div>
                    <a target="_blank" href="<?=yii::$app->urlManager->createUrl('/personal-goods-'.$good['goods_id'])?>">
                        <div class="masonry-action">
                            <span class="label label-green pull-right">¥<?= $good['price'] ?></span>
                            <span>
                              <i class="icon-24 icon-24-message"></i><?= $good['comment_num'] ?><b class="icon-word">评论
                                    &nbsp;&nbsp;/</b>
                            </span>
                            <i class="icon-24 icon-24-heart"></i><?= $good['like_num'] ?><b class="icon-word">喜欢</b>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach ?>
    <?php } else { ?>
        <div class="empty">暂未找到商品！</div>
    <?php } ?>
</div>

<div class="pages">
    <?php echo $_page_mdl->showpage(false); ?>
</div>
<style>
    .pages {
        text-align: center;
    }

    .pagination > li > a{
        padding:10px 15px;
        color: #5acdb3;
    }

    .pagination > li.active > a{
        background:#5acdb3;
        border-color:#5acdb3;
    }
</style>

<!--购物车浮动层-->
<?php echo frontend\widgets\cart\CartWidget::widget(['_proxy_dir' => yiiParams('shop_frontendurl')]); ?>

<!--[if !IE]><!-->
<script type="text/javascript"
        src="http://static.vsochina.com/libs/imagesloaded/imagesloaded.pkgd.min.js"></script> <!--<![endif]-->
<!--[if gte IE 9]>
<script type="text/javascript"
        src="http://static.vsochina.com/libs/imagesloaded/imagesloaded.pkgd.min.js"></script> <![endif]-->
<script type="text/javascript">
    $(function () {
        var container = $('.masonry');
        var userAgent = window.navigator.userAgent.toLowerCase();
        var isIE8 = /msie 8\.0/i.test(userAgent);
        if (isIE8) {
            container.masonry({
                itemSelector: '.masonry-item',
                columnWidth: <?=$columnWidth?>
            });
        } else {
            imagesLoaded(container, function () {
                container.masonry({
                    itemSelector: '.masonry-item',
                    columnWidth: <?=$columnWidth?>
                });
            });
        }
    });
</script>
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?0d358b60914677adace468737a0f8ad8";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>
<div style="display: none;">
    <script type="text/javascript" charset="utf-8" src="http://account.vsochina.com/static/js/global_statistics.js"></script>
<div>