<script>
    var _IS_SELF = '<?= $this->context->is_self ?>';
    var _VSO_UNAME = '<?= $this->context->vso_uname ?>';
</script>
<script src="http://static.vsochina.com/libs/masonry/3.3.2/masonry.pkgd.min.js"></script>
<script src="/js/jquery.qrcode.min.js"></script>
<script src="/js/share.js"></script>
<script src="/js/personal/comment.js"></script>
<div class="theme-white-box-50">
    <input type="hidden" id="work_id" name="work_id" value="19792">
    <div class="work_detail">
        <div class="theme-action" style="display: none">
            <a href="javascript:;" title="点赞" ><i class="icon-24 icon-heart <?= $myPraise ? 'on' : ''; ?>" onclick="return comment.addPraise(this)"></i></a>
            <a href="javascript:;" class="icon-share-box"><i class="icon-24 icon-share"></i></a>
            <a href="javascript:;" class="<?= $myCollection ? 'active' : ''; ?>" onclick="return comment.addCollect(this)"><i class="icon-24 icon-collect"></i></a>
            <a><i class="icon-24 icon-warn"></i></a>
            <a class="active"><i class="icon-24 icon-warn"></i></a>
        </div>
        <div class="img-600">
            <a target="_blank" class="w-imgbox" href="<?= $service['thumb'] ?>">
                <img src="<?= $service['thumb'] ?>" alt="<?= $service['name'] ?>">
            </a>
        </div>
        <? foreach(json_decode($service['thumb_list']) as $thumb): ?>
            <? if($thumb == $service['thumb'])continue; ?>
            <div class="img-600" style="margin-top: 0px;">
                <a target="_blank" class="w-imgbox" href="<?= $thumb ?>">
                    <img src="<?= $thumb ?>" alt="<?= $service['name'] ?>">
                </a>
            </div>
        <? endforeach ?>
        <div class="masonry-text"><p><?= $service['description'] ?></p></div>
        <div class="commercial-tip-div" style="display: none;">
            <span>禁止商业使用</span>
        </div>
        <div>
            <span class="work-title" title="企鹅"><?= $service['name'] ?></span>
        </div>
        <div class="theme-info box" style="display: none">
            <span class="date"><?= date('Y-m-d H:i:s' ,$service['create_time']) ?></span>
            <div class="w-popularity pull-right">
                <a class="w-popularity-btn">
                    <i class="icon-16 icon-fire"></i>人气：<span id="fire_num"><?= $service['views_num'] + $service['comment_num'] + $service['collection_num'] + $service['like_num'] + $service['buy_num']?></span>
                    <i class="icon-16 icon-down"></i>
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
            <a href="javaScript:void(0);" rel="nofollow" class="w-pay-btn" onclick="checkHire();">
                直接雇佣
            </a>
            <span class="w-pay-price">&yen;<?= $service['price'] ?>/<?= $service['unit'] ?></span>
        </div>


        <div class="theme-pager clearfix">
            <?php if(isset($besides[
                    'previous']) && !empty($besides['previous'])): ?>
                <a class="pull-left" href="/personal/service/view/<?= $besides['previous']['service_id'] ?>" >&lt; 上一篇 </a>
            <?php endif ?>
            <?php if(isset($besides['next']) && !empty($besides['next'])): ?>
                <a class="pull-right" href="/personal/service/view/<?= $besides['next']['service_id'] ?>" >下一篇 &gt;</a>
            <?php endif ?>
        </div>
        <div class="theme-square-pic clearfix">
            <?php foreach(json_decode($service['thumb_list']) as $thumb ):?>
                <a href="<?= $thumb ?>" title="<?= $service['name'] ?>" target="_blank"><img src="<?= \common\lib\Helper::_get_thumb($thumb, '_125', '_600') ?>" ></a>
            <?php endforeach ?>
        </div>
    </div>
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
<div class="sharework" style="display: none;">
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

<script type="text/javascript">

    $(function(){
        //参数初始化
        comment.username = '<?= $service['username'] ?>';
        comment.user_nick = '<?= isset($user_info['nickname']) ? $user_info['nickname'] : '' ?>';
        comment.obj_id = <?= $service['service_id'] ?>;
        comment.obj_name = '<?= $service['name'] ?>';
        comment.page = 1;
        comment.vso_uname = '<?= $this->context->vso_uname ?>';
        comment.is_login = _VSO_UNAME != '' ? true : false;
        comment.is_self = _IS_SELF ? true : false;
        comment.pageSize = <?= $pageSize ?>;
        comment.type = <?= $comment_type ?>;
        comment.alter_praise_url = '/personal/service/ajax-alter-praise';
        comment.alter_collect_url = '/personal/service/ajax-alter-collect';
        comment.add_comment_url = '/personal/service/ajax-add-comment';
        comment.del_comment_url = '/personal/service/ajax-del-comment';
        comment.load_comments_url = '/personal/service/ajax-load-comments';
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