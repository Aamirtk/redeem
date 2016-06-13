<?php
use yii\helpers\ArrayHelper;
;?>
<!--手机版首页-->
<!--slider-->
<div class="mobile-box swiper-container hide">
    <div class="swiper-wrapper">
        <?php foreach($this->context->banners as $banner){if($banner['obj_type']=='mobile_home'){ ?>
            <div class="swiper-slide">
                <a href="<?=$banner['link']?>"><img src="<?= $banner['img'] ?>"></a>
            </div>
        <?php }}; ?>

    </div>
    <div class="swiper-pagination"></div>
</div>
<!--/slider-->

<!--link-->
<div class="mobile-box mo-link hide">
    <ul class="mo-link-list clearfix">
        <li>
            <a href="http://maker.vsochina.com/project/default/create">
                <i class="icon-82 icon-penter"></i>
                <p>项目入驻</p>
            </a>
        </li>
        <li>
            <a href="http://rc.vsochina.com/rc/recruit/">
                <i class="icon-82 icon-renter"></i>
                <p>人才入驻</p>
            </a>
        </li>
        <li>
            <a href="http://rc.vsochina.com">
                <i class="icon-82 icon-talent"></i>
                <p>创意人才</p>
            </a>
        </li>
        <!--
        <li>
            <a href="http://www.vsochina.com/task.html">
                <i class="icon-82 icon-task"></i>
                <p>任务大厅</p>
            </a>
        </li>
        -->
        <li>
            <a href="http://create.vsochina.com/app/lst">
                <i class="icon-82 icon-tool"></i>
                <p>创作工具</p>
            </a>
        </li>
    </ul>
</div>
<!--/link-->

<!--hot project-->
<div class="mobile-box mo-project mo-project-hot clearfix hide">
    <div class="mo-title-box clearfix">
        <div class="mo-title clearfix">
            <i class="icon-39 icon-fire"></i>
            热门项目
        </div>
        <a href="http://maker.vsochina.com/home/default/mlist" class="mo-more">
            More
            <i class="icon-15 icon-gt"></i>
        </a>
    </div>
    <ul class="mo-project-list clearfix">
<?php foreach($hot_projs_top5 as $hot):?>
            <li>
                <a href="http://maker.vsochina.com/project/<?= $hot['proj_id']?>">
                    <div class="mo-project-img">
                        <img src="<?= $hot['img']?>">
                    </div>
                    <p class="mo-project-name"><?= $hot['title']?></p>
                    <p class="mo-project-tag"><?= $hot['tag']?></p>
                    <p class="mo-project-support"><span><?= $hot['fans_num'] ?></span>支持</p>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<!--/hot project-->

<!--incubation project-->
<div class="mobile-box mo-project mo-project-incubation hide">
    <div class="mo-title-box clearfix">
        <div class="mo-title clearfix">
            <i class="icon-39 icon-incubation"></i>
            孵化中项目
        </div>
        <a href="http://maker.vsochina.com/home/default/mlist" class="mo-more">
            More
            <i class="icon-15 icon-gt"></i>
        </a>
    </div>
    <ul class="mo-project-list clearfix">
        <?php foreach($all_projs as $v):?>
            <li>
                <a href="/project/<?= $v['proj_id'] ?>">
                    <div class="mo-project-img">
                        <img src="<?= $v['project']['proj_icon'] ?>">
                    </div>
                    <p class="mo-project-name"><?=$v['project']['proj_name']?></p>
                    <p class="mo-project-tag"><?=  $v['proj_tag']?></p>
                    <p class="mo-project-support"><span><?= $v['fans_num'] ?></span>支持</p>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<!--/incubation project-->

<!--all project-->
<div class="mobile-box mo-project mo-project-all hide">
    <a href="http://maker.vsochina.com/home/default/mlist">查看全部项目</a>
</div>
<!--/all project-->

<script src="http://static.vsochina.com/libs/swiper/js/swiper.min.js"></script>
<script type="text/javascript">
    $(function(){
        if(window.localStorage)
        {
            var storage = window.localStorage;
            var time = new Date().getTime();
            if(!storage.getItem("ads_mask") || (time - storage.getItem("ads_mask") > 0.5 * 3600 * 1000) || (time - storage.getItem("ads_mask") < 0))
            {
                storage.setItem("ads_mask", time);
                showAds();
            }
            else
            {
                $(".mo-ads").siblings().show();
                if($('.swiper-slide').length > 0)
                {
                    var swiper = new Swiper('.swiper-container', {
                        pagination: '.swiper-pagination',
                        paginationClickable: true,
                        loop: true,
                        autoHeight: true
                    });
                }
            }
        }
        else
        {
            showAds();
        }
    });

    function showAds()
    {
        var _ads = $(".mo-ads");
        _ads.show();
        var ratio = _ads.outerWidth() / _ads.outerHeight();
        if(ratio > 3 / 4)
        {
            _ads.css('background-image', 'url(/images/mobile/maskbg-1-1.jpg)');
        }
        else if(ratio > 2 / 3)
        {
            _ads.css('background-image', 'url(/images/mobile/maskbg-3-4.jpg)');
        }
        else if(ratio > 3 / 5)
        {
            _ads.css('background-image', 'url(/images/mobile/maskbg-2-3.jpg)');
        }
        else if(ratio > 9 / 16)
        {
            _ads.css('background-image', 'url(/images/mobile/maskbg-3-5.jpg)');
        }
        else
        {
            _ads.css('background-image', 'url(/images/mobile/maskbg-9-16.jpg)');
        }
        _ads.css('opacity', '1');
        setTimeout(function(){
            _ads.siblings().show();
            if($('.swiper-slide').length > 0)
            {
                var swiper = new Swiper('.swiper-container', {
                    pagination: '.swiper-pagination',
                    paginationClickable: true,
                    loop: true,
                    autoHeight: true
                });
            }
            _ads.fadeOut('400');
        }, 1500);
    }

    function is_weixin()
    {
        var ua = navigator.userAgent.toLowerCase();
        if(ua.match(/MicroMessenger/i) == "micromessenger")
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function stopPropagation(e)
    {
        if(e.stopPropagation())
        {
            e.stopPropagation();
        }
        else
        {
            e.cancelBubble = true;
        }
    }
</script>

