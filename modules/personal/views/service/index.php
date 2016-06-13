<!--瀑布流-->
<div class="masonry js-masonry">
    <?php if (!empty($services)) { ?>
        <?php foreach ($services as $service): ?>
            <div class="masonry-item">
                <div class="masonry-pic-dec">
                    <a target="_blank" href="/personal/service/view/<?= $service['service_id'] ?>">
                        <h2 class="masonry-pic-title"><?= $service['name'] ?></h2>
                        <img src="<?= $service['thumb'] ?>">
                    </a>

                    <div class="masonry-text">
                        <a target="_blank" href="/personal/service/view/<?= $service['service_id'] ?>">
                            <p><?= $service['description'] ?></p>
                        </a>
                    </div>
                    <a target="_blank" href="/personal/service/view/<?= $service['service_id'] ?>">
                        <div class="masonry-action">
                            <span class="label label-green pull-right">¥<?= $service['price'] ?></span>
                            <span>
                              <i class="icon-24 icon-24-message"></i><?= $service['comment_num'] ?><b class="icon-word">评论
                                    &nbsp;&nbsp;/</b>
                            </span>
                            <i class="icon-24 icon-24-heart"></i><?= $service['comment_like'] ?><b
                                class="icon-word">喜欢</b>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach ?>
    <?php } else { ?>
        <div class="empty">暂未找到服务！</div>
    <?php } ?>
</div>

<script type="text/javascript">
    $(function () {
        var container = $('.masonry');
        imagesLoaded(container, function () {
            container.masonry({
                itemSelector: '.masonry-item',
                columnWidth: <?=$columnWidth?>
            });
        });
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