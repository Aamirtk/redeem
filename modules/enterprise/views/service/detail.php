<link type="text/css" rel="stylesheet" href="/css/rc_case.css">
<link type="text/css" rel="stylesheet" href="/js/video/css/rc_case.css">
<link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/css/talent_comm.css">
<link rel="stylesheet" type="text/css" href="/css/talent_space.css">
<link rel="stylesheet" type="text/css" href='/resource/css/userWork/userwork.css' />
<script>
    var _IS_SELF = '<?= $this->context->is_self ?>';
    var _VSO_UNAME = '<?= $this->context->vso_uname ?>';
</script>
<script src="http://static.vsochina.com/libs/masonry/3.3.2/masonry.pkgd.min.js"></script>
<script src="/js/jquery.qrcode.min.js"></script>
<script src="/js/share.js"></script>
<script src="/js/enterprise/comment.js"></script>

<!--banner-->
<?php require_once(Yii::getAlias('@frontend') . '/modules/enterprise/views/layout/banner.php')?>
<!--/banner-->

<!--topnav-->
<div class="case-top clear-float">
    <ul class="case-top-nav">
        <li>
            <a href="http://rc.vsochina.com/">
                <i class="icon-12 icon-12-home"></i>
                <span>商城首页</span>
            </a>
        </li>
        <li>
            <a href="/enterprise/default/index/<?= $this->context->obj_username ?>">
                <i class="top-nav-space">/</i>
                <span><?= $this->context->user_info['nickname']?></span></a>
        </li>
        <li>
            <a href="/enterprise/service/list/<?= $this->context->obj_username ?>" >
                <i class="top-nav-space">/</i>
                <span>可售服务展示</span>
            </a>
        </li>
        <li class="cur">
            <a href="/enterprise/work/detail/<?= $service['service_id'] ?>">
                <i class="top-nav-space">/</i>
                <span><?= $service['name'] ?></span>
            </a>
        </li>
    </ul>
    <div class="case-top-title">
        <span><?= $service['name'] ?></span>
    </div>
    <div class="case-top-turn">
        <a href="<?= $besides['previous'] ? '/enterprise/service/view/' . $besides['previous']['service_id'] : 'javaScript:void(0)' ?>" title="<?= $besides['previous']['name'] ?>" class="top-turn-prev">
            <i class="icon-20 icon-20-prev"></i>
        </a>
        <a href="<?= $besides['next'] ? '/enterprise/service/view/' . $besides['next']['service_id'] : 'javaScript:void(0)' ?>" title="<?= $besides['next']['name'] ?>" class="top-turn-next">
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
        <?php foreach($hot_cases as $case): ?>
            <li>
                <div class="hotcase-list-img">
                    <a target="_blank" href="/enterprise/work/detail/<?= $case['id'] ?>" title="<?= $case['work_name'] ?>">
                        <img src="<?= $case['work_url'] ?>">
                    </a>
                </div>
                <div class="hotcase-list-desc">
                    <p class="hotcase-list-name"><a target="_blank" href="/enterprise/work/detail/<?= $case['id'] ?>" title="<?= $case['work_name'] ?>"><?= $case['work_name'] ?></a></p>
                    <p class="hotcase-list-price">类似服务价格：<span class="case-pricenum">&yen;<?= $case['work_price'] ?></span>起</p>
                </div>
            </li>
        <?php endforeach ?>
    </ul>
</div>

<!--content-->
<div class="case-content">
    <div class="case-content-top clear-float">
        <div class="content-top-case">
            <p class="content-top-title"><?= $service['name'] ?></p>
            <p class="content-top-date"><?= date("Y年m月d日", $service['create_time'])?></p>
        </div>
        <dl class="content-top-enterprise clear-float">
            <dt>
                <a href="/enterprise/default/index/<?= $this->context->obj_username ?>" target="_blank">
                    <img src="<?= $this->context->user_info['avatar'] ?>">
                </a>
            </dt>
            <dd class="content-top-name">
                <a href="/enterprise/default/index/<?= $this->context->obj_username ?>" target="_blank"><?= $this->context->user_info['nickname'] ?></a>
            </dd>
        </dl>
    </div>
    <div class="case-content-mainpart">
        <div class="content-mainpart-topwrap clearfix" style="display: none">
            <ul class="content-mainpart-action clearfix">
                <li><a><i class="icon-32 <?= $myPraise ? 'icon-gliked' : 'icon-glike'; ?>" onclick="return comment.addPraise(this)"></i><b></b></a></li>
                <li><a class="icon-share-box"><i class="icon-32 icon-share" ></i><b></b></a></li>
                <li><a><i class="icon-32 <?= $myCollection ? 'icon-collected' : 'icon-collect'; ?>" onclick="return comment.addCollect(this)"></i><b></b></a></li>
                <li><a><i class="icon-32 icon-warn"></i></a></li>
            </ul>
        </div>

        <div class="content-mainpart-detail">
            <div class="mainpart-detail-img">
                <img src="<?= $service['thumb'] ?>">
            </div>
            <?=  $service['description'] ;?>
        </div>
        <div class="clearfix" style="display: none">
            <span class="w-goodsdate"><?= date('Y-m-d H:i:s', $service['create_time']) ?></span>
            <div class="w-popularity">
                <a class="w-popularity-btn">
                    <i class="icon-16 icon-fire"></i>人气：<span id="fire_num"><?=  $service['hot_num'] ;?></span><i class="icon-16 icon-down"></i>
                </a>
                <ul class="w-popularity-down">
                    <li>浏览：<i id="view_num"><?= $service['views_num'] ?></i></li>
                    <li>收藏：<i id="collect_num"><?= $service['collection_num'] ?></i></li>
                    <li>喜欢：<i id="like_num"><?= $service['like_num'] ?></i></li>
                    <li>评论：<i id="comment_num"><?= $service['comment_num'] ?></i></li>
                    <li>购买：<i id="buy_num"><?= $service['buy_num'] ?></i></li>
                </ul>
            </div>
        </div>
        <div class="w-pay-box clearfix">

            <a href="javaScript:void(0);" onclick="checkHire();" rel="nofollow" class="w-pay-btn">
                直接雇佣
            </a>
            <span class="w-pay-price">&yen;<?= $service['price'] ;?></span>
        </div>

    </div>
    <div class="case-content-page">
        <div class="mainpart-page-last">
            <?php if(empty($besides['previous'])):?>
                <a href="javascript:void(0);" title="<?= $besides['previous']['name'] ?>">
                    上一篇：暂无
                </a>
            <?php else:?>
                <a href="/enterprise/service/view/<?= $besides['previous']['service_id'] ?>" title="<?= $besides['previous']['name'] ?>">
                    上一篇：<?= $besides['previous']['name'] ?>
                </a>
            <?php endif;?>
        </div>
        <div class="mainpart-page-next">
            <?php if(empty($besides['next'])):?>
                <a href="javascript:void(0);" title="<?= $besides['next']['name'] ?>">
                    下一篇：暂无
                </a>
            <?php else:?>
                <a href="/enterprise/service/view/<?= $besides['next']['service_id'] ?>" title="<?= $besides['next']['name'] ?>">
                    下一篇：<?= $besides['next']['name'] ?>
                </a>
            <?php endif;?>
        </div>
    </div>
    <!--评论-->
    <div class="comment_list goods-comment-list">
        <p class="nctitle">评论 ( <span name="count_comment"><?= $service['comment_num'] ?></span> )</p>
        <textarea name="content" id="content" class="textarea"></textarea>
        <div class="bcmtbtn clearfix">
            <input type="hidden" id="hidden_pid" name="hidden_pid" value="0">
            <button class="btn btn-darkgrey pull-right" id="create_comment" onclick="return comment.addComment()">发布</button>
            <span class="ztag color-red" style="display: none;">请输入评论内容</span>
        </div>
        <ul class="w-remarklist">
            <?php foreach($comments as $comment): ?>
                <li  class="w-commentitem" comment_id="<?= $comment['id'] ?>" username="<?= $comment['username'] ?>">
                    <a target="_blank" href="/talent/<?= $comment['username'] ?>">
                        <img src="<?= $comment['avatar'] ?>" alt="<?= $comment['nickname'] ?>">
                    </a>
                    <?php if($this->context->vso_uname <> '' && $this->context->vso_uname <> $comment['username']): ?>
                        <a href="javascript:;" class="w-reply" onclick="return comment.addReply(<?= $comment['id'] ?>, '<?= $comment['username'] ?>')" nickname="<?= $comment['nickname'] ?>" comment_id="<?= $comment['id'] ?>">回复</a>
                    <?php elseif($this->context->vso_uname <> '') : ?>
                        <a href="javascript:;" class="w-reply del_comment" onclick="return comment.delComment(<?= $comment['id'] ?>)" comment_id="<?= $comment['id'] ?>">删除</a>
                    <?php endif ?>
                    <p class="w-remarkdetail">
                        <a class="w-nickname" target="_blank" href="/talent/admin"><?= $comment['nickname'] ?></a>
                        <span class="w-towords" comment_id="<?= $comment['id'] ?>" ><?= $comment['content'] ?></span>
                    </p>
                </li>
                <?php foreach($comment['subComments'] as $subcomment): ?>
                    <li class="w-replyitem" p_id="<?= $comment['id'] ?>" comment_id="<?= $subcomment['id'] ?>" username="<?= $subcomment['username'] ?>">
                        <?php if($this->context->vso_uname <> '' && $this->context->vso_uname == $subcomment['username']): ?>
                            <a href="javascript:;" class="w-reply del_reply" onclick="return comment.delComment(<?= $subcomment['id'] ?>)" comment_id="<?= $subcomment['id'] ?>">删除</a>
                        <?php endif ?>
                        <a target="_blank" href="/talent/<?= $subcomment['username'] ?>">
                            <img src="<?= $subcomment['avatar'] ?>" alt="<?= $subcomment['nickname'] ?>">
                        </a>
                        <div class="w-remarkdetail">
                            <div class="w-replyto">
                                <a target="_blank" href="/talent/zhou81" class="w-nickname"><?= $subcomment['nickname'] ?></a>
                                <span><?= $subcomment['diftime'] ?></span>
                                <p>回复
                                    <a target="_blank" href="/talent/admin" class="w-replyname"><?= $comment['nickname'] ?></a>：
                                    <span class="p_content"><?= $comment['content'] ?></span>
                                </p>
                            </div>
                            <span class="w-replycontent w-towords"><?= $subcomment['content'] ?></span>
                        </div>
                    </li>
                <?php endforeach ?>
            <?php endforeach ?>
        </ul>
        <?php if(empty($comments)): ?>
            <div class="_comment_empty">暂无评论数据！</div>
        <?php endif ?>
        <?php if($pageSize < $service['comment_num']): ?>
            <div class="comment-list-more"><a href="javascript:void(0);" class="_more_comment" id="_show_more_comment" _now_page="<?= $page ?>" onclick="return comment.loadComments(this)">查看更多 ↓</a></div>
        <?php endif ?>
    </div>
</div>

<div class="sharework goods-sharework" style="display: none;">
    <a data-cmd="qq" title="分享到qq"> <i class="qq"></i> </a>
    <a data-cmd="qzone" title="分享到qq空间"><i class="zoom"></i></a>
    <a data-cmd="tsina" title="分享到新浪微博"><i class="weibo"></i></a>
    <a data-cmd="weixin" title="分享到微信"><i class="weixin"></i>
        <div class="weixin-box">
            <div class="wx-triangle">
                <span><em></em></span>
            </div>
            <div class="weixin-box-img"></div>
            <p>创意云微信公众号</p>
        </div>
    </a>
</div>
<!--/content-->

<script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>
<script type="text/javascript">
    $(function(){
        comment.username = '<?= $service['username'] ?>';
        comment.obj_id = <?= $service['service_id'] ?>;
        comment.page = 1;
        comment.vso_uname = '<?= $this->context->vso_uname ?>';
        comment.is_login = _VSO_UNAME != '' ? true : false;
        comment.is_self = _IS_SELF ? true : false;
        comment.pageSize = <?= $pageSize ?>;
        comment.type = <?= $comment_type ?>;
        comment.alter_praise_url = '/enterprise/service/ajax-alter-praise';
        comment.alter_collect_url = '/enterprise/service/ajax-alter-collect';
        comment.add_comment_url = '/enterprise/service/ajax-add-comment';
        comment.del_comment_url = '/enterprise/service/ajax-del-comment';
        comment.load_comments_url = '/enterprise/service/ajax-load-comments';
        comment.init();
    });

    function checkHire(){
        var auth = <?= $ent_auth_status ?>;
        var is_self = '<?= $this->context->is_self ?>' ? true : false;
        if(auth != 1){
            alert('您未通过企业认证，请认证通过后再发布雇佣项目！');
            return;
        }
        if(is_self == true){
            alert('对不起，您不能购买自己的商品！');
            return;
        }
        window.location.href = '<?= Yii::$app->params['create_service'] . $this->context->obj_username ?>';
        return;
    }
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