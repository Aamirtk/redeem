<?php
use common\models\CommonIndustry;
use frontend\modules\project\models\ProjMember;
$id = yii::$app->request->get('id');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>《<?= $project['proj_name'] ?>》-创客空间-蓝海创意云</title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="renderer" content="webkit"/>
    <meta name="baidu-site-verification" content="NpzvG27pvo"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <link rel="stylesheet" type="text/css" href="http://account.vsochina.com/static/css/login/common.css?v=20150831"/>
    <link rel="stylesheet" type="text/css" href="/css/dreamSpace.css"/>
    <link rel="stylesheet" type="text/css" href="/css/detail.css" />

    <script language="javascript" type="text/javascript" charset="utf-8" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
</head>
<body>
<!--header-top-->
<script type="text/javascript" charset="utf-8" src="http://account.vsochina.com/static/js/vsoheader.js"></script>
<!--/header-top-->
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/header.php') ?>
<!--detail-content-->
<div class="dreamspace-detail-content">
    <!--detail-banner-->
    <div class="detail-banner">
        <div class="detail-title fl">
            <h1><?= $project['proj_name'] ?></h1>
            <p>
                <span><?= $project['proj_sub_name'] ?></span>
            </p>
        </div>
        <dl class="detail-producer fr">
            <dt class="fl">
                <?php if (isset($project['user']['avatar']) && !empty($project['user']['avatar'])): ?>
                    <a href="<?= yii::$app->params['user_center_url'] ?><?= $project['username']?>.html" target="_blank" class="detail-portrait-50">
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
            <img src="<?= $extend['proj_banner'] ?>" alt="<?= $project['proj_name'] ?>" width="1200" height="450" />
        </div>
        <?php endif;?>
    </div>
    <!--/detail-banner-->

    <!--detail-info-->
    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》项目简介</h2>
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
                            <p class="support-secondline">关注</p>
                        </li>
                        <li class="fl support-percentage">
                            <p class="support-firstline">
                                <span>进行中</span>
                            </p>
                            <p class="support-secondline">项目进度</p>
                        </li>
                    </ul>
                    <?php if ($project['user']['favor_status']):?>
                        <a href="javascript:void(0);" class="yellow-btn w120 focused" name="project_<?= $project['proj_id']?>" value="<?= $project['proj_id']?>" onclick="remove_favor_project(this)">已关注</a>
                    <?php else:?>
                        <a href="javascript:void(0);" class="yellow-btn w120" name="project_<?= $project['proj_id']?>" value="<?= $project['proj_id']?>" onclick="favor_project(this)">关注</a>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <div class="detail-rightpart">
            <?= $extend['proj_desc'] ?>
        </div>
    </div>

    <?php if (!empty($project['member_list'])):?>
        <?php $count_member = count($project['member_list']);?>
        <div class="detail-info detail-info-one">
            <div class="detail-leftpart fl">
                <div class="leftinfo-tpart">
                    <h2>《<?= $project['proj_name'] ?>》团队介绍</h2>
                    <p class="leftinfo-tpart-subhead groupnum">团队人数：<span><?= $count_member ?></span>人</p>
                </div>
                <div class="leftinfo-mpart">
                    <div class="leftinfo-mpart-operate">
                        <?php if (!ProjMember::isProjMember($id)) :?>
                            <!--<a href="javascript:void(0);" class="yellow-btn apply-enter w125">申请加入团队</a>-->
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="detail-rightpart">
                <?= $extend['team_desc'] ?>
                <ul class="rightinfo-groupmember mt35 num3">
                    <?php foreach ($project['member_list'] as $k => $v): ?>
                        <li>
                            <div>
                                <a href="<?= yii::$app->params['user_center_url'] ?><?= $v['username'] ?>.html" target="_blank" class="detail-portrait-100">
                                    <img src="<?= $v['avatar'] ?>" alt="<?= $v['nickname'] ?>" width="64px" height="64px"/>
                                </a>
                            </div>
                            <p class="groupmember-name"><?= $v['nickname'] ?></p>
                            <p class="groupmember-role"><?= $v['tag'] ?></p>
                        </li>
                    <? endforeach ?>
                </ul>
            </div>
        </div>
    <?php endif;?>

    <?php
    $img_str = $extend['img_str'];
    $img_arr = json_decode($img_str);
    ?>
    <?php if(count($img_arr) > 0):?>
    <div class="detail-info detail-info-two">
        <div class="detail-leftpart">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》项目演示</h2>
            </div>
        </div>
        <div class="detail-bannerpart new-m-castlist slideBox">
            <a class="detail-bannerpart-prev" href="javascript:void(0)"></a>
            <ul>
                <?php foreach($img_arr as $v):?>
                <li>
                    <a target="_blank" href="javascript:;">
                        <div class="slideBox-c">
                            <img src="<?= $v ?>" alt="<?= $project['proj_name'] ?>" />
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
        <div class="detail-rightpart">
            <?= $extend['remarks'] ?>
        </div>
    </div>

    <?php if (isset($extend['proj_risk']) && $extend['proj_risk']):?>
    <div class="detail-riskbg">
        <div class="detail-info">
            <div class="detail-leftpart fl">
                <div class="leftinfo-tpart">
                    <h2>《<?= $project['proj_name'] ?>》项目风险</h2>
                </div>
            </div>
            <div class="detail-rightpart">
                <?= $extend['proj_risk'] ?>
            </div>
        </div>
    </div>
    <?php endif;?>

    <?php
    $qa_str = $extend['qa_str'];
    $qa_arr = json_decode($qa_str);
    $count_qa = count($qa_arr);
    ?>
    <?php if($count_qa > 0):?>
    <div class="detail-info detail-info-one">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》项目答疑解惑</h2>
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
        <div class="detail-rightpart">
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

    <!--
    <div class="detail-info">
        <div class="detail-leftpart fl">
            <div class="leftinfo-tpart">
                <h2>《<?= $project['proj_name'] ?>》项目进度</h2>
            </div>
        </div>
        <div class="detail-rightpart">
            <div class="leftinfo-mpart-operate">
                <a href="javascript:void(0);" class="yellow-btn w120">查看进度</a>
            </div>
        </div>
    </div>
    -->

    <!--detail-info-->
</div>
<input type="hidden" name="hidden_proj_id" value="<?= $id;?>" >
<!--/detail-content-->

<script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>
<script type="text/javascript" src="/js/jquery.placeholder.min.js"></script>

<script type="text/javascript" src="/js/dreamSpace.js"></script>
<script type="text/javascript" src="/js/project_action.js"></script>
<script type="text/javascript" src="/js/project_detail.js"></script>
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/footer.php') ?>
</body>
</html>