<link type="text/css" rel="stylesheet" href="/css/rc_case.css">
<script>
    var _USER_NAME = '<?= $this->context->obj_username ?>';
    var _IS_SELF = '<?= $this->context->is_self ?>';
    var _VSO_UNAME = '<?= $this->context->vso_uname ?>';
    var _PAGE_SIZE = <?= $pageSize ?>;
    var _PAGE = <?= 1 ?>;
    var _TOTAL_PAGE = <?= $totalPage ?>;
</script>
<script type="text/javascript">
</script>
<!--content-->
<?php require_once(Yii::getAlias('@frontend') . '/modules/enterprise/views/layout/header.php') ?>
<script src="/js/enterprise/comment.js"></script>
<div class="m-warp clearfix">

</div>

<div class="m-warp enterprise-case-list enterprise-goods-list">
    <ul class="case-hotcase-list clear-float">
        <?php if (!empty($services)) { ?>
            <?php foreach ($services as $service): ?>
                <li>
                    <div class="hotcase-list-img">
                        <a target="_blank" href="/enterprise/service/view/<?= $service['service_id'] ?>" title="<?= $service['name'] ?>">
                            <img src="<?= $service['thumb'] ?>">
                        </a>
                    </div>
                    <div class="hotcase-list-desc">
                        <p class="hotcase-list-name">
                            <a href="javascript:void(0);" class="hotcase-list-tag"
                               data-type="1"><?= $service['category'] ?></a>
                            <a target="_blank" href="/enterprise/service/view/<?= $service['service_id'] ?>"
                               title="<?= $service['name'] ?>"><?= $service['name'] ?></a>
                        </p>

                        <div class="goods-list-msg clearfix">
                            <a target="_blank" href="/enterprise/service/view/<?= $service['service_id'] ?>" title="<?= $service['name'] ?>">
                                <span class="goods-list-remarks"><i
                                        class="icon-16 icon-remarks "></i><?= $service['comment_num'] ?></span>
                            </a>
                            <a target="_blank" href="/enterprise/service/view/<?= $service['service_id'] ?>" title="<?= $service['name'] ?>">
                                <span class="goods-list-like"><i
                                        class="icon-16 icon-like"></i><?= $service['like_num'] ?></span>
                            </a>
                            <span class="goods-list-price">&yen;<?= $service['price'] ?></span>
                        </div>
                    </div>
                </li>
            <?php endforeach ?>
        <?php } else { ?>
            <div class="empty">未找到服务！</div>
        <?php } ?>
    </ul>

</div>

<div class="m-warp">
    <div id="mainsrp-pager">
        <div class="m-page g-clearfix mt0">
            <div class="wraper">
                <div class="inner clearfix pagelist">

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("#ent_service_list").addClass("active");

        comment.username = _USER_NAME;
        comment.vso_uname = _VSO_UNAME;
        comment.is_self = _IS_SELF ? true : false;
        comment.page = 1;
        comment.type = 0;
        comment.pageSize = _PAGE_SIZE;
        comment.totalPage = _TOTAL_PAGE;
        comment.list_url = '/enterprise/service/ajax-list';
        comment.en_init();
    })
</script>
<!--/content-->

<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?0d358b60914677adace468737a0f8ad8";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>
