<link type="text/css" rel="stylesheet" href="/css/rc_case.css">
<link type="text/css" rel="stylesheet" href="/js/video/css/rc_case.css">
<link type="text/css" rel="stylesheet" href="/plugins/video/video-js.css">
<script type="text/javascript">
    <?php require_once(Yii::getAlias('@frontend') . '/webrc/js/enterprise/enterprise.js') ?>
    $(function(){
        ent_ctl.hotCaseList("<?= $model['username']?>");
    });
    videojs.options.flash.swf = "/plugins/video/video-js.swf";
    var myPlayer = videojs('example_video_1');
    videojs("example_video_1").ready(function(){
        var myPlayer = this;
        myPlayer.play();
    });
</script>


<!--banner-->
<?php require_once(Yii::getAlias('@frontend') . '/modules/enterprise/views/layout/banner.php')?>
<!--/banner-->

<!--topnav-->
<div class="case-top clear-float">
    <ul class="case-top-nav">
        <li>
            <a href="<?php echo Yii::$app->params['rc_front_url'] ?>">
                <i class="icon-12 icon-12-home"></i>
                <span>人才库首页</span>
            </a>
        </li>
        <li>
            <a href="<?= yii::$app->urlManager->createUrl("enterprise");?>">
                <i class="top-nav-space">/</i>
                <span><?= $this->context->company['name']?></span></a>
        </li>
        <li>
            <a href="<?= yii::$app->urlManager->createUrl("enterprise-work");?>">
                <i class="top-nav-space">/</i>
                <span>案例展示</span>
            </a>
        </li>
        <li class="cur">
            <a href="<?= yii::$app->urlManager->createUrl("enterprise-work-" . $model['id']);?>">
                <i class="top-nav-space">/</i>
                <span><?= $model['work_name']?></span>
            </a>
        </li>
    </ul>
    <div class="case-top-title">
        <span><?= $model['work_name']?></span>
    </div>
    <div class="case-top-turn">
        <a href="<?= empty($prevModel) ? 'javascript:void(0);' : yii::$app->urlManager->createUrl("enterprise-work-" . $prevModel['id']); ?>" class="top-turn-prev">
            <i class="icon-20 icon-20-prev"></i>
        </a>
        <a href="<?= empty($nextModel) ? 'javascript:void(0);' : yii::$app->urlManager->createUrl("enterprise-work-" . $nextModel['id']); ?>" class="top-turn-next">
            <i class="icon-20 icon-20-next"></i>
        </a>
    </div>
</div>
<!--/topnav-->

<!--hotcase-->
<div class="case-hotcase clear-float">
    <div class="case-hotcase-top clear-float">
        <span class="hotcase-top-title">热门案例</span>
        <!--        <a href="javascript:void(0);" class="hotcase-top-operate">换一换</a>-->
    </div>
    <ul class="case-hotcase-list clear-float" id="hot_cases">

    </ul>
</div>
<!--/hotcase-->

<!--content-->
<div class="case-content">
    <div class="case-content-top clear-float">
        <div class="content-top-case">
            <p class="content-top-title"><?= $model['work_name']?></p>
            <p class="content-top-date"><?= date("Y年m月d日", $model['create_time'])?></p>
        </div>
        <dl class="content-top-enterprise clear-float">
            <dt>
                <a href="<?php echo yii::$app->urlManager->createUrl("/enterprise") ?>" target="_blank">
                    <img src="<?= $this->context->user_info['avatar'] ?>">
                </a>
            </dt>
            <dd class="content-top-name">
                <a href="<?php echo yii::$app->urlManager->createUrl("/enterprise") ?>"
                   target="_blank"><?= $this->context->user_info['nickname'] ?></a>
            </dd>
        </dl>
    </div>
    <div class="case-content-mainpart">
        <?php if(!empty($model['tag'])):?>
            <div class="content-mainpart-tag clear-float">
                <i class="icon-24 icon-24-tag"></i>
                <?php $tags = explode(',', $model['tag']);?>
                <?php foreach($tags as $k => $t){
                    if(empty($t)){
                        continue;
                    }
                    echo '<a target="_blank" href="javascript:void(0);" class="mainpart-tag-link">' . $t . '</a>';
                }
                ?>
            </div>
        <?php endif;?>
        <div class="content-mainpart-detail">
            <div class="mainpart-detail-img">
                <?php if($model['work_type'] == "1" || $model['work_type'] == "0"):?>
                    <img src="<?= $model['work_url'];?>">
                <?php elseif($model['work_type'] == "2"):?>
                    <!--                    <video id="example_video_1" class="video-js vjs-default-skin" controls preload="none" width="800" height="600"-->
                    <!--                           poster="http://video-js.zencoder.com/oceans-clip.png"-->
                    <!--                           data-setup="{}">-->
                    <!--                        <source src="--><?//= $model['work_url'];?><!--" type='video/mp4' />-->
                    <!--                        <source src="--><?//= $model['work_url'];?><!--" type='video/webm' />-->
                    <!--                        <source src="--><?//= $model['work_url'];?><!--" type='video/ogg' />-->
                    <!--                        <track kind="captions" src="demo.captions.vtt" srclang="en" label="English"></track>-->
                    <!--                        <track kind="subtitles" src="demo.captions.vtt" srclang="en" label="English"></track>-->
                    <!--                    </video>-->
                <?php else:?>
                    <div>
                        <?= $model['work_url'];?>
                    </div>
                <?php endif;?>
            </div>
            <?= $model['content'];?>
        </div>

        <div class="w-pay-box clearfix">
            <?php if($model['username'] == $vso_uname): ?>
                <a class="w-pay-btn" href="<?php echo yii::$app->params['shop_frontendurl'] . yii::$app->urlManager->createUrl(['/shop/goods/add','case_id'=>$model['id']]);?>" target="_blank"> + 同步到商品</a>
            <?php endif ?>
        </div>
    </div>
    <div class="case-content-page">
        <div class="mainpart-page-last">
            <?php if(empty($prevModel)):?>
                <a href="javascript:void(0);">
                    上一篇：暂无
                </a>
            <?php else:?>
                <a href="<?= yii::$app->urlManager->createUrl("enterprise-work-" . $prevModel['id']) ;?>">
                    上一篇：<?= $prevModel['work_name']?>
                </a>
            <?php endif;?>
        </div>
        <div class="mainpart-page-next">
            <?php if(empty($nextModel)):?>
                <a href="javascript:void(0);">
                    下一篇：暂无
                </a>
            <?php else:?>
                <a href="<?= yii::$app->urlManager->createUrl("enterprise-work-" . $nextModel['id']) ;?>">
                    下一篇：<?= $nextModel['work_name']?>
                </a>
            <?php endif;?>
        </div>
    </div>
</div>
<!--/content-->

<style>
    .w-pay-box .w-pay-btn {
        background-color: #f60;
        border-radius: 5px;
        color: #fff;
        display: inline-block;
        font-size: 16px;
        line-height: 50px;
        text-align: center;
        text-decoration: none;
        width: 210px;
    }
</style>

<script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>
<!--<script type="text/javascript" src="/plugins/video/video.js">-->