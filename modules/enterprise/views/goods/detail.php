<link type="text/css" rel="stylesheet" href="/css/rc_case.css">
<link type="text/css" rel="stylesheet" href="/js/video/css/rc_case.css">
<link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/css/jplayer.css"/>
<link rel="stylesheet" type="text/css" href="/css/talent_comm.css">
<link rel="stylesheet" type="text/css" href="/css/talent_space.css">
<link rel="stylesheet" type="text/css" href='/resource/css/userWork/userwork.css'/>
<link type="text/css" rel="stylesheet" href="http://static.vsochina.com/libs/webuploader/0.1.5/webuploader.css">
<link rel="stylesheet" type="text/css" href="/css/popup.css">
<link rel="stylesheet" type="text/css" href="/css/iconfont.css">
<style>
    .popup-form-item textarea {
        padding: 5px;
    }

    .goods_attr {
        width: 100%;
        /*margin-top:20px;*/
        margin: 20px 0;
        padding-right: 30px;
    }

    .goods_attr table {
        width: 100%;
        border-top: 1px solid #ccc;
        border-left: 1px solid #ccc;
    }

    .goods_attr table thead {
        background: #efefef;
    }

    .goods_attr table thead td {
        font-weight: bold;
        font-size: 16px;
    }

    .goods_attr table td {
        padding: 10px;
        border-right: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
    }
</style>
<script>
    var _USER_NAME = '<?= $good['username'] ?>';
    var _GOODS_ID = '<?= $good['goods_id'] ?>';
    var _USER_NICK = '<?= isset($user_info['nickname']) ? $user_info['nickname'] : '' ?>';
    var _GOODS_NAME = '<?= $good['name'] ?>';
    var _IS_SELF = '<?= $this->context->is_self ?>';
    var _VSO_UNAME = '<?= $this->context->vso_uname ?>';
    var _PAGE_SIZE = <?= $pageSize ?>;
    var _COMMENT_TYPE = <?= $comment_type ?>;
    var _SAVE_REPORT_URL = '<?php echo Yii::$app->params['rc_front_url']?>/rc/report/ajax-save-report';
</script>
<script src="http://static.vsochina.com/libs/masonry/3.3.2/masonry.pkgd.min.js"></script>
<script src="/js/jquery.qrcode.min.js"></script>
<script src="/js/share.js"></script>
<script src="/js/tools.js"></script>
<script src="/js/enterprise/comment.js"></script>
<script type="text/javascript" src="http://static.vsochina.com/libs/webuploader/0.1.5/webuploader.js"></script>
<!--banner-->
<?php require_once(Yii::getAlias('@frontend') . '/modules/enterprise/views/layout/banner.php') ?>
<!--/banner-->

<!--topnav-->
<div class="case-top clear-float">
    <ul class="case-top-nav">
        <li>
            <a href="<?php echo Yii::$app->params['shop_frontendurl'] ?>">
                <i class="icon-12 icon-12-home"></i>
                <span>商城首页</span>
            </a>
        </li>
        <li>
            <a href="<?= yii::$app->urlManager->createUrl("enterprise"); ?>">
                <i class="top-nav-space">/</i>
                <span><?= $this->context->company['name'] ?></span></a>
        </li>
        <li>
            <a href="<?= yii::$app->urlManager->createUrl("enterprise-goods"); ?>">
                <i class="top-nav-space">/</i>
                <span>可售商品</span>
            </a>
        </li>
        <li class="cur">
            <a href="<?= yii::$app->urlManager->createUrl("enterprise-goods-" . $good['goods_id']); ?>"
               title="<?= $good['name'] ?>">
                <i class="top-nav-space">/</i>
                <span><?= $good['name'] ?></span>
            </a>
        </li>
    </ul>
    <div class="case-top-title">
        <span><?= $good['name'] ?></span>
    </div>
    <div class="case-top-turn">
        <a href="<?= $besides['previous'] ? '/enterprise-goods-' . $besides['previous']['goods_id'] : 'javaScript:void(0)' ?>"
           class="top-turn-prev" title="<?= $besides['previous']['name'] ?>">
            <i class="icon-20 icon-20-prev"></i>
        </a>
        <a href="<?= $besides['next'] ? '/enterprise-goods-' . $besides['next']['goods_id'] : 'javaScript:void(0)' ?>"
           class="top-turn-next" title="<?= $besides['next']['name'] ?>">
            <i class="icon-20 icon-20-next"></i>
        </a>
    </div>
</div>
<!--/topnav-->

<div class="case-hotcase clear-float">
    <div class="case-hotcase-top clear-float">
        <span class="hotcase-top-title">热门案例</span>
        <!--        <a href="javascript:void(0);" class="hotcase-top-operate">换一换</a>-->
    </div>
    <ul class="case-hotcase-list clear-float" id="hot_cases">
        <?php foreach ($hot_cases as $case): ?>
            <li>
                <div class="hotcase-list-img">
                    <a target="_blank" href="/enterprise-work-<?= $case['id'] ?>" title="<?= $case['work_name'] ?>">
                        <img src="<?= $case['work_url'] ?>">
                    </a>
                </div>
                <div class="hotcase-list-desc">
                    <p class="hotcase-list-name">
                        <a target="_blank" href="/enterprise-work-<?= $case['id'] ?>"
                           title="<?= $case['work_name'] ?>"><?= $case['work_name'] ?></a>
                    </p>

                    <p class="hotcase-list-price">类似服务价格：<span
                            class="case-pricenum">&yen;<?= $case['work_price'] ?></span>起</p>
                </div>
            </li>
        <?php endforeach ?>
    </ul>
</div>

<!--content-->
<div class="case-content">
    <div class="case-content-top clear-float">
        <div class="content-top-case">
            <p class="content-top-title"><?= $good['name'] ?></p>

            <p class="content-top-date"><?= date("Y年m月d日", $good['create_time']) ?></p>
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
        <div class="content-mainpart-topwrap clearfix">
            <?php if (!empty($tags)): ?>
                <div class="content-mainpart-tag clear-float">
                    <i class="icon-24 icon-24-tag"></i>
                    <?php foreach($tags as $tag): ?>
                        <?php if(empty($tag))continue; ?>
                        <a href="<?php echo yiiParams('shop_frontendurl') . '/search?' . http_build_query(['cid' => 0, 'keyword' => urlencode($tag)]) ?>"
                           class="mainpart-tag-link" target="_blank" title="<?php echo '点击搜索包含关键词&quot;' . $tag . '&quot;的商品' ?>"><?php echo $tag ?></a>
                    <?php endforeach ?>
                </div>
            <?php endif; ?>
            <ul class="content-mainpart-action clearfix">
                <li><a href="javascript:;" title="点赞"><i
                            class="icon-32 <?= $myPraise ? 'icon-gliked' : 'icon-glike'; ?>"
                            onclick="return comment.addPraise(this)"></i><b></b></a></li>
                <li><a class="icon-share-box" href="javascript:;" title="分享"><i
                            class="icon-32 icon-share"></i><b></b></a></li>
                <li><a href="javascript:;" title="收藏"><i
                            class="icon-32 <?= $myCollection ? 'icon-collected' : 'icon-collect'; ?>"
                            onclick="return comment.addCollect(this)"></i><b></b></a></li>
                <li><a class="popup-btn" href="javaScript:;" title="举报"><i class="icon-32 icon-warn  "></i></a></li>
            </ul>
        </div>

        <div class="content-mainpart-detail">
            <div class="mainpart-detail-img">
                <?php if ($good['goods_type'] == 'image'): ?>
                    <div class="img-600" style="margin-top: 0px;">
                        <img
                            src="<?php echo $good['goods_type'] != 'audio' ? _get_thumbnail($good['username'], $good['thumb_original'], 600, '', true, 'fit')
                                : Yii::$app->params['auto_goods_cover']; ?>" alt="<?= $good['name'] ?>">

                    </div>

                <?php elseif ($good['goods_type'] == 'video'): ?>
                    <div id="video_container" class="jp-video jp-video-360p jp-video-width" role="application"
                         aria-label="media player">
                        <div class="jp-type-single">
                            <div id="video_player" class="jp-jplayer"></div>
                            <div class="jp-gui">
                                <div class="jp-interface">
                                    <div class="jp-interface-bg"></div>
                                    <div class="jp-progress">
                                        <div class="jp-progress-bar"></div>
                                        <div class="jp-seek-bar">
                                            <div class="jp-play-bar"></div>
                                        </div>
                                    </div>
                                    <div class="jp-controls-holder">
                                        <div class="jp-controls">
                                            <button class="jp-play" role="button" tabindex="0">play</button>
                                        </div>
                                        <div class="jp-toggles">
                                            <button class="jp-full-screen" role="button" tabindex="0">full screen
                                            </button>
                                        </div>
                                        <div class="jp-timebox">
                                            <span class="jp-current-time" role="timer" aria-label="time">&nbsp;</span>
                                            /
                                            <span class="jp-duration" role="timer" aria-label="duration">&nbsp;</span>
                                        </div>
                                        <div class="jp-volume-controls">
                                            <button class="jp-mute" role="button" tabindex="0">mute</button>
                                            <div class="jp-volume-bar">
                                                <div class="jp-volume-bar-value"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="jp-details">
                                        <div class="jp-title" aria-label="title"><?= $good['name'] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php elseif ($good['goods_type'] == 'audio'): ?>
                    <div id="audio_player" class="jp-jplayer"></div>
                    <div id="audio_container" class="jp-audio" role="application" aria-label="media player">
                        <div class="jp-audio-bg"></div>
                        <div class="jp-type-single">
                            <div class="jp-gui jp-interface">
                                <div class="jp-interface-bg"></div>
                                <div class="jp-volume-controls">
                                    <button class="jp-mute" role="button" tabindex="0">mute</button>
                                    <div class="jp-volume-bar">
                                        <div class="jp-volume-bar-value"><i class="jp-dot"></i></div>
                                    </div>
                                </div>
                                <div class="jp-controls-holder">
                                    <div class="jp-controls">
                                        <button class="jp-play" role="button" tabindex="0">play</button>
                                        <button class="jp-stop" role="button" tabindex="0">stop</button>
                                    </div>
                                    <div class="jp-progress">
                                        <div class="jp-progress-bar"></div>
                                        <div class="jp-seek-bar">
                                            <div class="jp-play-bar"></div>
                                        </div>
                                    </div>
                                    <div class="jp-toggles">
                                        <button class="jp-repeat" role="button" tabindex="0">repeat</button>
                                    </div>
                                    <div class="jp-timebox">
                                        <span class="jp-current-time" role="timer" aria-label="time">&nbsp;</span>
                                        /
                                        <span class="jp-duration" role="timer" aria-label="duration">&nbsp;</span>
                                    </div>
                                </div>
                            </div>
                            <div class="jp-details">
                                <div class="jp-title" aria-label="title"><?= $good['name'] ?></div>
                            </div>
                            <div class="jp-no-solution">
                                <span>需要升级</span>
                                您可以通过升级浏览器或<a href="http://get.adobe.com/flashplayer/" target="_blank">插件</a>来试听音频。
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <img
                        src="<?php echo $good['goods_type'] != 'audio' ? _get_thumbnail($good['username'], $good['thumb_original'], 600, '', true, 'fit')
                            : Yii::$app->params['auto_goods_cover']; ?>" alt="<?= $good['name'] ?>">
                <?php endif ?>
            </div>
            <?= $description; ?>

        </div>

        <div class="goods_attr">
            <table border="0" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <td colspan="4">文件属性：</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td width="44%">商品分类：<?php echo implode('-', $good_cat); ?></td>
                    <td width="28%">素材格式：<?php echo strtoupper($good['file_ext']); ?></td>
                    <td width="28%">文件大小：<?php echo _format_size($good['file_size']); ?></td>
                </tr>

                <?php if (!empty($auth['auth_scope'])) { ?>
                    <tr>
                        <td colspan="3">
                            授权范围：<?php echo join(' , ', $auth['auth_scope']) ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="clearfix">
            <span class="w-goodsdate"><?= date('Y-m-d H:i:s', $good['create_time']) ?></span>

            <div class="w-popularity">
                <a class="w-popularity-btn">
                    <i class="icon-16 icon-fire"></i>人气：<span id="fire_num"><?= $good['hot_num']; ?></span><i
                        class="icon-16 icon-down"></i>
                </a>
                <ul class="w-popularity-down">
                    <li>浏览：<i id="view_num"><?= $good['views_num'] ?></i></li>
                    <li>收藏：<i id="collect_num"><?= $good['collection_num'] ?></i></li>
                    <li>喜欢：<i id="like_num"><?= $good['like_num'] ?></i></li>
                    <li>评论：<i id="comment_num"><?= $good['comment_num'] ?></i></li>
                    <li>购买：<i id="buy_num"><?= $good['buy_num'] ?></i></li>
                </ul>
            </div>
        </div>
        <div class="w-pay-box clearfix">
            <a href="javascript:void(0)" rel="nofollow" class="w-pay-btn"
               onclick="openBlank('<?php echo yii::$app->params['shop_frontendurl'] ?>/order/goods/buy',{id:'<?= $good['goods_id'] ?>'},true);">
                立即购买
            </a>
            <a href="javascript:;" goods-id="<?php echo $good['goods_id'] ?>" class="_add_to_cart w-pay-btn"
               rel="nofollow">
                加入购物车
            </a>
            <span class="w-pay-price">&yen;<?= $good['price']; ?></span>
        </div>
        <div class="upload-content-copyright dropup">
            <a class="copyright-btn _open_status_icon" href="javascript:void(0);" data-toggle="dropdown"
               role="button"
               aria-haspopup="true" aria-expanded="false">
                <i class="icon iconfont copyright-icon"><?= $auth['icon'] ?></i>

                <p class="copyright-desc"><?= $auth['text'] ?></p><br>
            </a>
        </div>
    </div>
    <div class="case-content-page">
        <div class="mainpart-page-last">
            <?php if (empty($besides['previous'])): ?>
                <a href="javascript:void(0);">
                    上一篇：暂无
                </a>
            <?php else: ?>
                <a href="/enterprise-goods-<?= $besides['previous']['goods_id'] ?>"
                   title="<?= $besides['previous']['name'] ?>">
                    上一篇：<?= $besides['previous']['name'] ?>
                </a>
            <?php endif; ?>
        </div>
        <div class="mainpart-page-next">
            <?php if (empty($besides['next'])): ?>
                <a href="javascript:void(0);">
                    下一篇：暂无
                </a>
            <?php else: ?>
                <a href="/enterprise-goods-<?= $besides['next']['goods_id'] ?>" title="<?= $besides['next']['name'] ?>">
                    下一篇：<?= $besides['next']['name'] ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <!--评论-->
    <div class="comment_list goods-comment-list">
        <p class="nctitle">评论 ( <span name="count_comment"><?= $good['comment_num'] ?></span> )</p>
        <textarea name="content" id="content" class="textarea"></textarea>

        <div class="bcmtbtn clearfix">
            <input type="hidden" id="hidden_pid" name="hidden_pid" value="0">
            <button class="btn btn-darkgrey pull-right" id="create_comment" onclick="return comment.addComment()">发布
            </button>
            <span class="ztag color-red" style="display: none;">请输入评论内容</span>
        </div>
        <ul class="w-remarklist">
            <?php foreach ($comments as $comment): ?>
                <li class="w-commentitem" comment_id="<?= $comment['id'] ?>" username="<?= $comment['username'] ?>">
                    <a target="_blank" href="/talent/<?= $comment['username'] ?>">
                        <img src="<?= $comment['avatar'] ?>" alt="<?= $comment['nickname'] ?>">
                    </a>
                    <?php if ($this->context->vso_uname <> '' && $this->context->vso_uname <> $comment['username']): ?>
                        <a href="javascript:;" class="w-reply"
                           onclick="return comment.addReply(<?= $comment['id'] ?>, '<?= $comment['username'] ?>')"
                           nickname="<?= $comment['nickname'] ?>" comment_id="<?= $comment['id'] ?>">回复</a>
                    <?php elseif ($this->context->vso_uname <> '') : ?>
                        <a href="javascript:;" class="w-reply del_comment"
                           onclick="return comment.delComment(<?= $comment['id'] ?>)"
                           comment_id="<?= $comment['id'] ?>">删除</a>
                    <?php endif ?>
                    <p class="w-remarkdetail">
                        <a class="w-nickname" target="_blank" href="/talent/admin"><?= $comment['nickname'] ?></a>
                        <span class="w-towords" comment_id="<?= $comment['id'] ?>"><?= $comment['content'] ?></span>
                    </p>
                </li>
                <?php foreach ($comment['subComments'] as $subcomment): ?>
                    <li class="w-replyitem" p_id="<?= $comment['id'] ?>" comment_id="<?= $subcomment['id'] ?>"
                        username="<?= $subcomment['username'] ?>">
                        <?php if ($this->context->vso_uname <> '' && $this->context->vso_uname == $subcomment['username']): ?>
                            <a href="javascript:;" class="w-reply del_reply"
                               onclick="return comment.delComment(<?= $subcomment['id'] ?>)"
                               comment_id="<?= $subcomment['id'] ?>">删除</a>
                        <?php endif ?>
                        <a target="_blank" href="/talent/<?= $subcomment['username'] ?>">
                            <img src="<?= $subcomment['avatar'] ?>" alt="<?= $subcomment['nickname'] ?>">
                        </a>

                        <div class="w-remarkdetail">
                            <div class="w-replyto">
                                <a target="_blank" href="/talent/zhou81"
                                   class="w-nickname"><?= $subcomment['nickname'] ?></a>
                                <span><?= $subcomment['diftime'] ?></span>

                                <p>回复
                                    <a target="_blank" href="/talent/admin"
                                       class="w-replyname"><?= $comment['nickname'] ?></a>：
                                    <span class="p_content"><?= $comment['content'] ?></span>
                                </p>
                            </div>
                            <span class="w-replycontent w-towords"><?= $subcomment['content'] ?></span>
                        </div>
                    </li>
                <?php endforeach ?>
            <?php endforeach ?>
        </ul>
        <?php if (empty($comments)): ?>
            <div class="_comment_empty">暂无评论数据！</div>
        <?php endif ?>
        <?php if ($pageSize < $good['comment_num']): ?>
            <div class="comment-list-more"><a href="javascript:void(0);" class="_more_comment" id="_show_more_comment"
                                              _now_page="<?= $page ?>" onclick="return comment.loadComments(this)">查看更多
                    ↓</a></div>
        <?php endif ?>
    </div>
</div>

<div class="sharework goods-sharework" style="display: none;">
    <a data-cmd="qq" title="分享到qq"> <i class="qq"></i> </a>
    <a data-cmd="qzone" title="分享到qq空间"><i class="zoom"></i></a>
    <a data-cmd="tsina" title="分享到新浪微博"><i class="weibo"></i></a>
    <!--    <a data-cmd="weixin" title="分享到微信"><i class="weixin"></i>

            <div class="weixin-box">
                <div class="wx-triangle">
                    <span><em></em></span>
                </div>
                <div class="weixin-box-img"></div>
                <p>创意云微信公众号</p>
            </div>
        </a>-->
</div>
<!--/content-->
<!--举报弹出框-->
<div class="popup-wrap">
    <div class="popup-bg"></div>
    <div class="popup-content">
        <a class="popup-content-close">×</a>

        <div class="popup-content-top">
            <span class="popup-content-title">举报提交</span>
        </div>
        <div class="popup-content-formbox">
            <form id="report_form" action="" method="">
                <div class="popup-form-group clearfix">
                    <label for="" class="popup-form-label">附件上传：</label>

                    <div class="popup-form-item">
                        <div class="popup-form-upload">
                            <div class="clearfix">
                                <div id="upload_attachment_local" class="popup-upload-btn btn-local">
                                    <a>本地上传</a>
                                </div>
                                <!--<div id="upload_attachment_studio" class="popup-upload-btn btn-studio">
                                    <a onclick="">工作室上传</a>
                                </div>-->
                            </div>
                            <ul id="upload_list" class="uploader-list clearfix"></ul>
                        </div>
                        <div>支持rar,zip,doc,docx格式，文件小于4M，不支持批量上传。</div>
                    </div>
                </div>
                <div class="popup-form-group clearfix">
                    <label for="" class="popup-form-label">原因：</label>

                    <div class="popup-form-item">
                        <textarea row="3" maxlength="100" name="report_desc"></textarea>

                        <div>最多可以输入100个字符</div>
                    </div>
                </div>
                <div class="popup-form-group clearfix">
                    <label for="" class="popup-form-label">交易维权：</label>

                    <div class="popup-form-item">
                        <div class="popup-form-intro">
                            1.与被维权人有实际交易，但发现其在[“创意云”在线创作平台]上有违规情况，可以通过维权途径告知网站，维权为实名。
                        </div>
                        <div class="popup-form-intro">
                            2.与他人无实际交易产生，但发现其在[“创意云”在线创作平台]上有违规情况，可以通过举报、投诉途径告知网站，举报、投诉为匿名。
                        </div>
                    </div>
                </div>
                <div class="popup-form-group popup-form-btnbox">
                    <button class="popup-form-confirm" onclick="saveReport()">保存</button>
                    <button class="popup-form-cancel" onclick="cancelReport()">取消</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--购物车浮动层-->
<?php echo frontend\widgets\cart\CartWidget::widget(['_proxy_dir' => yiiParams('shop_frontendurl')]); ?>
<style>
    .popup-form-item textarea {
        padding: 5px;
    }
</style>

<script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>
<script type="text/javascript">
    $(function () {
        comment.username = _USER_NAME;
        comment.obj_id = _GOODS_ID;
        comment.page = 1;
        comment.vso_uname = _VSO_UNAME;
        comment.is_login = _VSO_UNAME != '' ? true : false;
        comment.is_self = _IS_SELF ? true : false;
        comment.pageSize = _PAGE_SIZE;
        comment.type = _COMMENT_TYPE;
        comment.alter_praise_url = '<?php echo yii::$app->urlManager->createUrl("/enterprise/goods/ajax-alter-praise");?>';
        comment.alter_collect_url = '<?php echo yii::$app->urlManager->createUrl("/enterprise/goods/ajax-alter-collect");?>';
        comment.add_comment_url = '<?php echo yii::$app->urlManager->createUrl("/enterprise/goods/ajax-add-comment");?>';
        comment.del_comment_url = '<?php echo yii::$app->urlManager->createUrl("/enterprise/goods/ajax-del-comment");?>';
        comment.load_comments_url = '<?php echo yii::$app->urlManager->createUrl("/enterprise/goods/ajax-load-comments");?>';
        comment.init();
    });
</script>

<!--举报-->
<script type="text/javascript" src="http://static.vsochina.com/libs/jplayer/2.9.1/jquery.jplayer.min.js"></script>
<script type="text/javascript">
    // 试听
    $("#audio_player").jPlayer({
        ready: function (event) {
            $(this).jPlayer("setMedia", {
                title: "<?= $good['name'] ?>",
                mp3: "<?= $good['trial_path']; ?>",
                wav: "<?= $good['trial_path']; ?>",
                wma: "<?= $good['trial_path']; ?>"
            });
        },
        swfPath: "http://static.vsochina.com/libs/jplayer/2.9.1",
        supplied: "mp3,wav,wma",
        wmode: "window",
        cssSelectorAncestor: "#audio_container",
        useStateClassSkin: true,
        autoBlur: false,
        smoothPlayBar: true,
        keyEnabled: true,
        remainingDuration: false,
        toggleDuration: true
    });

    // 试看
    $("#video_player").jPlayer({
        ready: function () {
            $(this).jPlayer("setMedia", {
                title: "",
                avi: "<?= $good['trial_path']; ?>",
                mov: "<?= $good['trial_path']; ?>",
                m4v: "<?= $good['trial_path']; ?>",
                flv: "<?= $good['trial_path']; ?>",
                wmv: "<?= $good['trial_path']; ?>",
                poster: "<?= _get_thumbnail($good['username'],$good['thumb']) ?>"
            });
        },
        swfPath: "http://static.vsochina.com/libs/jplayer/2.9.1",
        supplied: "m4v,flv",
        size: {
            width: "600px",
            height: "400px",
            cssClass: "jp-video-360p"
        },
        cssSelectorAncestor: "#video_container",
        globalVolume: true,
        useStateClassSkin: true,
        autoBlur: false,
        smoothPlayBar: true,
        keyEnabled: true
    });

    var _file_upload_notice = function (handler) {
        switch (handler) {
            case 'Q_TYPE_DENIED':
                alert('文件类型不正确！');
                break;
            case 'Q_EXCEED_SIZE_LIMIT':
                alert('上传文件总大小超过限制！');
                break;
            case 'Q_EXCEED_NUM_LIMIT':
                alert('上传文件总数量超过限制！');
                break;
        }
    };

    var uploader;
    $('.popup-btn').on('click', function (event) {
        if (_VSO_UNAME == '') {
            alert('登录后才能进行此操作');
            return false;
        }
        $('.popup-wrap').show();
        uploader = WebUploader.create({
            auto: true,
            fileVal: 'attachment',
            swf: '/static/webuploader/Uploader.swf',
            server: '/upload_file',
            pick: '#upload_attachment_local',
            accept: {
                title: 'attachment',
                extensions: 'doc,docx,rar,zip',
                mimeTypes: ''
            },
            fileNumLimit: 1,
            fileSizeLimit: 4 * 1024 * 1024,
            formData: {
                username: _VSO_UNAME,
                objtype: 'goods'
            }
        });

        uploader.on('error', function (handler) {
            _file_upload_notice(handler);
        });

        uploader.on('fileQueued', function (file) {
            var _list = $("#upload_list"),
                _li = $('<li id="' + file.id + '" title="' + file.name + '">\
                                    <span class="icon-progress">0%</span>\
                                    <a class="uploader-list-op uploader-delete">×</a>\
                                </li>');
            _list.append(_li);
            $(".uploader-delete").on('click', function (event) {
                var _this = $(this),
                    _obj = _this.closest('li'),
                    fileId = _obj.attr('id');
                uploader.removeFile(fileId, true);
                _obj.remove();
            });
        });

        uploader.on('uploadProgress', function (file, percentage) {
            $("#" + file.id).find('.icon-progress').html((percentage * 100).toFixed(2) + '%');
        });

        uploader.on('uploadSuccess', function (file, response) {
            if (typeof (response.ret) == 'undefined') {
                var _file_ret = $(response._raw).find('ret').text();
                var _file_path = $(response._raw).find('file_url').text();
            }
            else {
                var _file_ret = response.ret;
                var _file_path = response.data.file_url;
            }

            var _li = $("#" + file.id),
                _percent = _li.find('.icon-progress');
            if (_file_ret == '13900') {
                var _input = '<input type="hidden" name="report_file" value="' + _file_path + '" />';
                _percent.html(file.name + '上传成功！' + _input).attr('href', _file_path);
            } else {
                _percent.html(file.name + '上传失败！');
            }
        });

        uploader.on('uploadError', function (file) {
            $('#' + file.id).find('.icon-progress').html('失败');
        });
    });

    $(document).on('click', '.popup-content-close, .popup-bg', function (event) {
        $('.popup-wrap').hide();
    });

    $(".popup-form-confirm, .popup-form-cancel").on('click', function (e) {
        e.preventDefault();
    });

    function stopPropagation(e) {
        if (e.stopPropagation()) {
            e.stopPropagation();
        }
        else {
            e.cancelBubble = true;
        }
    }

    function cancelReport() {
        _clear_form('#report_form', true);
        $('#upload_list').html('');
        $('.popup-wrap').hide();
    }

    function saveReport() {
        var report_file = $.trim($('input[name=report_file]').val());
        var report_desc = $.trim($('textarea[name=report_desc]').val());
        if (report_file == '') {
            alert('请您上传文件');
            return false;
        }
        if (report_desc == '') {
            alert('请您填写原因');
            return false;
        }

        var params = params || {};
        params.username = _USER_NAME,
            params.to_username = _VSO_UNAME,
            params.obj = 'goods',
            params.obj_id = _GOODS_ID,
            params.origin_id = _GOODS_ID,
            params.user_type = 1,
            params.report_desc = report_desc,
            params.report_file = report_file,
            _jsonp(_SAVE_REPORT_URL, params, 'GET', function (json) {
                if (json.result) {
                    alert('举报成功');
                    _clear_form('#report_form', true);
                    $('#upload_list').html('');
                    $('.popup-wrap').hide();
                } else {
                    alert('举报失败');
                }
            });
    }

    function openBlank(action, data, n) {
        var _form = $("<form/>").attr('action', action).attr('method', 'post');
        if (n) {
            _form.attr('target', '_blank');
        }
        var input = '';
        $.each(data, function (i, n) {
            input += '<input type="hidden" name="' + i + '" value="' + n + '" />';
        });
        _form.append(input).appendTo("body").css('display', 'none').submit();
        _form.remove();
    }
</script>

<script>
    var _hmt = _hmt || [];
    (function () {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?0d358b60914677adace468737a0f8ad8";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>
<div style="display: none;">
    <script type="text/javascript" charset="utf-8" src="http://account.vsochina.com/static/js/global_statistics.js"></script>
<div>