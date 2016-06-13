<?php
use common\models\CommonIndustry;
use frontend\modules\project\models\ProjMember;
use frontend\modules\activity\models\SpringUtil;
$id = yii::$app->request->get('id');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?= isset($seo['seo_title']) ? $seo['seo_title'] : '《'.$cz_project['proj_name'].'》-创客空间-蓝海创意云'  ?></title>
    <meta name="keywords" content="<?= isset($seo['seo_title']) ? $seo['seo_keywords'] : ''  ?>"/>
    <meta name="description" content="<?= isset($seo['seo_desc']) ? $seo['seo_desc'] : ''  ?>"/>
    <meta name="renderer" content="webkit"/>
    <meta name="baidu-site-verification" content="NpzvG27pvo"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href='http://cz.vsochina.com/themes/creation/css/jquery.mCustomScrollbar.css'>
    <link rel="stylesheet" type="text/css" href="https://account.vsochina.com/static/css/login/common.css?v=20150831"/>
    <link rel="stylesheet" type="text/css" href="/css/detail.css" />
    <link rel="stylesheet" type="text/css" href="/css/kkpager_blue.css" />

    <script language="javascript" type="text/javascript" charset="utf-8" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="https://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="https://account.vsochina.com/static/js/referer_getter.js"></script>
    <script src='http://cz.vsochina.com/themes/creation/js/jquery.mCustomScrollbar.concat.min.js'></script>
    <?php
        $nickname = isset($user_info['nickname']) ? $user_info['nickname'] : '';
        $avatar = isset($user_info['avatar']) ? $user_info['avatar'] : '';
    ?>
    <script>
        var _ID = '<?= $id ?>';
        var _VSO_UNAME = '<?= $vso_uname ?>';
        var _AVATAR = '<?= $avatar ?>';
        var _NICK_NAME = '<?= $nickname ?>';
        var _TOTAL_PAGE = '<?= $totalPage ?>';
        var _PINDEX_URL = '<?= yii::$app->params['person_index_url'] ?>';
    </script>
    <script src='/js/project_comment.js'></script>

<!--    <script type="text/javascript" src="/js/kkpager.min.js"></script>-->
</head>
<body>
<!--header-top
<script type="text/javascript" charset="utf-8" src="http://account.vsochina.com/static/js/vsoheader.js"></script>
/header-top-->
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_header.php') ?>
<input type="hidden" id="proj_name" value="<?= $cz_project['proj_name'] ?>">

<!--bread-->
<div class="ds-1200 dreamspace-bread clearfix">
    <div class="pull-left">
        <i class="icon-16 icon-16-home"></i><a href="http://maker.vsochina.com">创意空间首页</a>  /   <span class="color-green"><?= $cz_project['proj_name'] ?></span>
    </div>
    <div class="pull-right">
        <i class="icon-16 icon-16-view"></i>浏览次数： <span class="bread-num"><?= $view_num ?></span> 次
    </div>
</div>
<!--/bread-->
<!--detail-content-->
<div class="dreamspace-detail-content">
    <!--detail-banner-->
    <div class="detail-banner">
        <div class="detail-title fl">
            <h1><?= $cz_project['proj_name'] ?></h1>
            <p>
                <span><?= $project['proj_sub_name'] ?></span>
            </p>
        </div>
        <dl class="detail-producer fr">
            <dt class="fl">
                <?php if (isset($project['user']['avatar']) && !empty($project['user']['avatar'])): ?>
                    <a href="/talent/<?= $project['username'] ?>" target="_blank" class="detail-portrait-50">
                        <img src="<?= $project['user']['avatar'] ?>" alt="<?= $project['user']['nickname'] ?>" />
                    </a>
                <?php endif;?>
            </dt>
            <dd class="detail-producer-name"><?= $project['user']['nickname'] ?></dd>
            <dd class="detail-producer-desc">
                <span class="detail-first"><?= $project['user']['tag'] ?></span>
            </dd>
        </dl>
        <?php if(isset($extend['proj_banner']) && $extend['proj_banner']): ?>
            <div class="detail-graphic">
                <img src="<?= $extend['proj_banner'] ?>" alt="<?= $cz_project['proj_name'] ?>" width="1200" height="450" />
            </div>
        <?php endif;?>
    </div>
    <!--/detail-banner-->

    <!--detail-info-->
    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $cz_project['proj_name'] ?>》项目简介</h2>
                <p class="leftinfo-tpart-subhead entertime">项目入驻时间：<?= date('Y-m-d', $project['created_at'])?></p>
            </div>
            <div class="leftinfo-mpart">
                <p class="leftinfo-mpart-desc">
                    <?= $project['proj_short_desc'] ?>
                </p>
                <p class="leftinfo-mpart-category">
                    <span>项目类型</span>
                    <span>-</span>
                    <span class="category-content"><?= CommonIndustry::getIndusName($project['indus_pid']) ?></span>
                </p>
                <div class="leftinfo-mpart-operate">
                    <ul class="operate-support-box">
                        <li class="fl support-num">
                            <p class="support-firstline">
                                <span id="support_pno" class="favor_num_<?= $project['proj_id'] ?>"><?= $project['fans_num'] ?></span>人
                            </p>
                            <p class="support-secondline">点赞</p>
                        </li>
                        <li class="fl support-percentage">
                            <p class="support-firstline">
                                <span>进行中</span>
                            </p>
                            <p class="support-secondline">项目进度</p>
                        </li>
                    </ul>
                    <?php if ($project['user']['favor_status']):?>
                        <a href="javascript:void(0);" class="yellow-btn w120 focused" name="project_<?= $project['proj_id']?>" value="<?= $project['proj_id']?>" onclick="remove_favor_project(this)">已点赞</a>
                    <?php else:?>
                        <a href="javascript:void(0);" class="yellow-btn w120" name="project_<?= $project['proj_id']?>" value="<?= $project['proj_id']?>" onclick="favor_project(this)">点赞</a>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <div class="detail-rightpart detail-edit">
            <?= $project['proj_desc'] ?>
        </div>
    </div>

    <?php $count_member = count($project['member_list']);?>
    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $cz_project['proj_name'] ?>》团队介绍</h2>
                <?php if ($count_member) :?>
                    <p class="leftinfo-tpart-subhead groupnum">团队人数：<span><?= $count_member ?></span>人</p>
                <?php endif;?>
            </div>
            <div class="leftinfo-mpart">
                <div class="leftinfo-mpart-operate">
                    <?php if (!ProjMember::isProjMember($id)) :?>
                        <!--<a href="javascript:void(0);" class="yellow-btn apply-enter w125">申请加入团队</a>-->
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="detail-rightpart detail-edit">
            <?= $project['team_desc'] ?>
            <div class="rightinfo-groupmember mt35 num5">
                <table>
                    <?php $r = 0; ?>
                    <?php for($i = 0; $i < count($project['member_list']); $i++) :?>
                        <?php $r = $i % 5; $v = $project['member_list'][$i]; ?>
                        <?php if($r == 0) :?>
                            <tr>
                        <?php endif ?>
                        <td>
                            <div>
                                <a href="/talent/<?= $v['proj_member'] ?>" target="_blank" class="detail-portrait-64">
                                    <img src="<?= $v['avatar'] ?>" alt="<?= $v['nickname'] ?>" width="64px" height="64px"/>
                                </a>
                            </div>
                            <p class="groupmember-name"><?= $v['nickname'] ?></p>
                            <p class="groupmember-role"><?= $v['tag'] ?></p>
                        </td>
                        <?php if($r == 4) :?>
                            </tr>
                        <?php endif ?>
                    <?php endfor ?>
                    <?php if($r != 4) :?>
                        <?php for($j = $r; $j < 4; $j++) :?>
                            <td></td>
                        <?php endfor ?>
                        </tr>
                    <?php endif ?>
                </table>
            </div>
        </div>
    </div>

    <?php
    $img_str = $project['img_str'];
    $img_arr = json_decode($img_str);
    ?>
    <?php if(count($img_arr) > 0):?>
        <div class="detail-info detail-info-two">
            <div class="detail-leftpart">
                <div class="leftinfo-tpart">
                    <h2>《<?= $cz_project['proj_name'] ?>》项目演示</h2>
                </div>
            </div>
            <div class="detail-bannerpart new-m-castlist slideBox">
                <a class="detail-bannerpart-prev" href="javascript:void(0)"></a>
                <ul>
                    <?php foreach($img_arr as $v):?>
                        <li>
                            <a href="javascript:;">
                                <div class="slideBox-c">
                                    <img src="<?= $v ?>" alt="<?= $cz_project['proj_name'] ?>" />
                                </div>
                            </a>
                        </li>
                    <?php endforeach;?>
                </ul>
                <a class="detail-bannerpart-next" href="javascript:void(0)"></a>
            </div>
        </div>
    <?php endif;?>

    <div class="detail-info">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2 class="ml0">为什么选择入驻创客空间？</h2>
            </div>
        </div>
        <div class="detail-rightpart detail-edit">
            <?= $project['remarks'] ?>
        </div>
    </div>

    <?php if (isset($project['proj_risk']) && $project['proj_risk']):?>
        <div class="detail-riskbg">
            <div class="detail-info">
                <div class="detail-leftpart fl">
                    <div class="leftinfo-tpart">
                        <h2>《<?= $cz_project['proj_name'] ?>》项目风险</h2>
                    </div>
                </div>
                <div class="detail-rightpart detail-edit">
                    <?= $project['proj_risk'] ?>
                </div>
            </div>
        </div>
    <?php endif;?>

    <?php
    $qa_str = $project['qa_str'];
    $qa_arr = json_decode($qa_str);
    $count_qa = count($qa_arr);
    ?>
    <?php if($count_qa > 0):?>
        <div class="detail-info detail-info-one">
            <div class="detail-leftpart fl">
                <div class="leftinfo-tpart">
                    <h2>《<?= $cz_project['proj_name'] ?>》项目答疑解惑</h2>
                    <p class="leftinfo-tpart-subhead question">网友问题：<span><?= $count_qa; ?></span>个</p>
                </div>
                <div class="leftinfo-mpart">
                    <p class="leftinfo-mpart-desc">
                        阅读其网友提出的问题，帮助自己快速了解更多项目咨询。也欢迎您提出更多的问题，项目团队和创客空间官方客服人员会在第一时间回复问题，尽可能给出令您满意的答案。
                    </p>
                    <!--
                    <div class="leftinfo-mpart-operate">
                        <a href="javascript:void(0);" class="yellow-btn w120 ask-question">我要提问</a>
                    </div>
                    -->
                </div>
            </div>
            <div class="detail-rightpart detail-edit">
                <dl class="detail-rightpart-questionlist">
                    <?php foreach($qa_arr as $k => $v):?>
                        <dt>
                            <a href="javascript:void(0);">
                                <?= $v[0] ?>
                            </a>
                        </dt>
                        <dd>
                            <p class="indent0">
                                <?= $v[1] ?>
                            </p>
                        </dd>
                    <?php endforeach;?>
                </dl>
            </div>
        </div>
    <?php endif;?>
    <div class="page-p-n">
        <div class="ft-changeP">
            <?php if(isset($prev_proj)):?>
                <a href="/project/<?= $prev_proj['proj_id']?>">上一个：<?= $prev_proj['project']['proj_name'] ?></a>
            <?php else:?>
                <span>上一个：暂无</span>
            <?php endif;?>
            <?php if(isset($next_proj)):?>
                <a href="/project/<?= $next_proj['proj_id'] ?>">下一个：<?= $next_proj['project']['proj_name'] ?></a>
            <?php else:?>
                <span>下一个：暂无</span>
            <?php endif;?>
        </div>
        <div class="ft-changePline"></div>
    </div>
    <!--
    <div class="detail-info">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $cz_project['proj_name'] ?>》项目进度</h2>
            </div>
        </div>
        <div class="detail-rightpart detail-edit">
            <div class="leftinfo-mpart-operate">
                <a href="javascript:void(0);" class="yellow-btn w120">查看进度</a>
            </div>
        </div>
    </div>
    -->

    <!--detail-info-->
</div>

<div class="ds-1200 reply-detail" style="display: <?php echo !empty($vso_uname) ? 'block' : 'block';?>">
    <p class="reply-detail-title">全部评论（<span class="reply-detail-num"><?= isset($comments['_count']) ? $comments['_count'] : 0 ?></span>）</p>
    <div class="reply-detail-entry comment_switch">
        <?php if(!empty($vso_uname)): ;?>
        <span class="reply-detail-textarea-top"><?= '[' . $nickname . '] ' . '评论：' ?></span>
        <div class="reply-detail-textarea"><span></span><textarea></textarea></div>
        <?php else: ;?>
        <span class="reply-detail-textarea-top">游客您需要 <a href="<?= yii::$app->params['loginUrl'] ?>" target="_blank">登录</a> 才可以评论，没有账号请 <a href="<?= yii::$app->params['registerUrl'] ?>" target="_blank">注册</a> O(∩_∩)O~</span>
        <?php endif ;?>
    </div>
    <input type="button"  onclick="addReply(this)" comment_id="-1" p_id="<?= $id ?>" user_name="<?= $vso_uname ?>" nick_name="<?= $nickname ?>" value="发布" class="reply-detail-entry-btn">
    <br class="clear" />
    <ul class="reply-detail-lst clearfix">
        <?php $commentArr = isset($comments['_items'])&&!empty($comments['_items']) ? $comments['_items'] : [] ;?>
        <?php foreach($commentArr as $k => $comment): ;?>
            <li class="reply-detail-lst-li" comment_id="<?= $comment['id'] ?>">
                <a href="<?= yii::$app->params['person_index_url'] . $comment['username'] ?>" target="_blank" class="reply-detail-head"><img src="<?= $comment['avatar'] ?>" alt=""></a>
                <div class="" comment_id="<?= $comment['id'] ?>">
                    <div class="reply-user-info">
                        <a href="<?= yii::$app->params['person_index_url'] . $comment['username'] ?>" target="_blank" class="blue-14"><?= $comment['nickname'] ?></a>  <?= $comment['diff_date'] ?>：
                        <span class="reply-detail-action">
                            <a href="javaScript:void(0)" class="reply-detail-add" onclick="addReplyContent(this)" comment_id="<?= $comment['id'] ?>" p_id="<?= $comment['p_id'] ?>" user_name="<?= $comment['username'] ?>" nick_name="<?= $comment['nickname'] ?>">回复</a>
                            <?php if($comment['username'] == $vso_uname): ?>
                            <a href="javaScript:void(0)" class="reply-detail-delete" onclick="deleteReply(this)" comment_id="<?= $comment['id'] ?>" p_id="<?= $comment['p_id'] ?>" user_name="<?= $comment['username'] ?>" nick_name="<?= $comment['nickname'] ?>">删除</a>
                            <?php endif ;?>
                        </span>
                    </div>
                    <div class="reply-user-txt">
                        <?= $comment['content'] ?>
                    </div>
                </div>
                <div class="replay-ul" comment_id="<?= $comment['id'] ?>" style="display: <?php echo $comment['_replay'] ? 'block' : 'none';?>" >
                    <em class="triangle-up"></em>
                    <i class="triangle-up"></i>
                    <ul>
                        <?php foreach($comment['_replay'] as $reply): ;?>
                            <li class="clearfix reply-detail-sub-li>" reply_id="<?= $reply['replay_id'] ?>">
                                <a href="<?= yii::$app->params['person_index_url'] . $reply['username'] ?>" target="_blank" class="replay-ul-head"><img src="<?= $reply['avatar'] ?>"></a>
                                <div class="reply-detail-action">
                                    <?php if($reply['username'] == $vso_uname): ?>
                                    <a href="javaScript:void(0)" onclick="deleteReply(this)" reply_id="<?= $reply['replay_id'] ?>">删除</a>
                                    <?php endif ;?>
                                </div>
                                <a href="<?= yii::$app->params['person_index_url'] . $reply['username'] ?>" target="_blank" ><?= $reply['nickname'] ?></a>
                                <span>回复</span>
                                <a href="<?= yii::$app->params['person_index_url'] . $reply['username'] ?>" target="_blank" ><?= $comment['nickname'] ?></a>：<?= $reply['content'] ?>.
                            </li>
                        <?php endforeach ;?>
                    </ul>
                </div>
            </li>
        <?php endforeach ;?>
    </ul>
    <div id="mainsrp-pager" style="margin-top: 15px; display: <?= $totalPage > 1 ? 'block' : 'none' ?>">
        <div id="kkpager">
            <div>
                <span class="pageBtnWrap">
                    <span page_no="" class="disabled">上一页</span>
                    <span page_no="1" class="curr">1</span>
                    <?php for($i=2;$i<=$totalPage; $i++): ?>
                    <a class="page_item" href="javaScript:void(0)" page_no="<?= $i ?>" onclick="ajaxLoadComment(this)" title="第<?= $i ?>页"><?= $i ?></a>
                    <?php endfor ;?>
                    <?php if($totalPage>1): ?>
                    <a href="javaScript:void(0)" page_no="2" onclick="ajaxLoadComment(this)" title="下一页">下一页</a>
                    <?php else: ;?>
                    <span page_no="" class="disabled">下一页</span>
                    <?php endif ;?>
                </span>
                <span class="infoTextAndGoPageBtnWrap">
                    <span class="totalText">当前第<span class="currPageNum">1</span>页</span>
                </span>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>
</div>

<input type="hidden" name="hidden_proj_id" value="<?= $id;?>" >
<input type="hidden" value="<?=SpringUtil::isSpringActivityAvaliable()?'true':'false'?>" id="spring_festivel_activity_switch">
<!--/detail-content-->
<script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>
<script type="text/javascript" src="/js/jquery.placeholder.min.js"></script>
<script type="text/javascript" src="http://static.vsochina.com/libs/jquery.lazyload/1.9.5/jquery.lazyload.js"></script>
<script type="text/javascript" src="/js/dreamSpace.js"></script>
<script type="text/javascript" src="/js/project_action.js"></script>
<script type="text/javascript" src="/js/project_detail.js"></script>
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_footer.php') ?>
<script type="text/javascript">
    function ajaxLoadComment(dom){
        comment.loadComment(dom);
    }
    function addReplyContent(dom) {
        comment.addReplyContent(dom);
    }
    function addReply(dom){
        comment.addReply(dom);
    }
    function deleteReply(dom){
        comment.deleteReply(dom);
    }
</script>
</body>
</html>
