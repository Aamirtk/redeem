<?php
use app\widgets\personal\HeaderWidget;
?>

<!--加载header-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>个人主页</title>
    <!--css-->
    <!--cookie domain-->
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.2.0/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="/css/talent_comm.css">
    <script>
        var _SKINID = <?php echo $skinid ?>;
        var _SKINTYPE = <?php echo $skintype ?>;
    </script>

    <!--[if lt IE 9]>
    <script src="http://static.vsochina.com/libs/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--js-->
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="/js/talent_skin_edit.js"></script>

    <script src="http://static.vsochina.com/libs/jquery/1.9.1/jquery.min.js"></script>

    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>

</head>
<body>
<?php
$obj_username = $info['obj_username'];  // 被访问用户
$vso_uname = $info['vso_uname'];    // 登录用户
$is_self = $info['is_self'];
$user_info = $info['user_info'];

?>
<div class="theme-nav-fixed hide">
    <a href="<?= yii::$app->params['rc_frontendurl'] ?>" class="btn btn-darkgrey pull-right"><i class="glyphicon glyphicon-cog"></i> &nbsp;返回首页</a>
    <?php if($info['is_self']){?>
        <a href="<?= yii::$app->params['rc_frontendurl'] ?>/personal/skin/index/<?= $obj_username ?>" class="btn btn-darkgrey pull-right"><i class="glyphicon glyphicon-home"></i> &nbsp;主页设置</a>
        <a href="<?= yii::$app->params['rc_frontendurl'] ?>/personal/work/create" class="btn btn-darkgrey pull-right"><i class="glyphicon glyphicon-send"></i> &nbsp;发布作品</a>
    <?php }?>
</div>
<div class="content-bg">
<div class="theme-left">
    <div class="talent-info-table">
        <div class="talent-info-cell">
            <div class="talent-info">
                <div class="talent-top-left">
                                <span href="javascript:void(0)" class="head-130">
                                    <img src="<?= $user_info['avatar'] ?>" alt="">
                                </span>
                    <p class="username-p">
                                <span class="username">
                                    <?= $user_info['nickname'] ?>
                                    <i class="icon-20 <?= $user_info['auth_sex'] == 1 ? 'icon-gender-boy' : ($user_info['auth_sex'] == 2 ? 'icon-gender-girl' : '') ?>"></i>
                                    <i class="icon-20 <?= $user_info['isvip'] ? 'icon-vip' : '' ?>"></i>
                                </span>
                    </p>
                    <p class="mold-p">
                        <?= $user_info['indus_name'] ?>
                    </p>

                    <div class="message-p visitor">
                        <div class="message-p-bg"></div>
                        <p class="message-p-msg"><?php echo !empty($user_info['signture'])?$user_info['signture']:'这个人很懒，什么也没留下...' ?></p>
                    </div>
                </div>
                <script type="text/javascript">
                    $(function(){
                        $(".message-p-input").outerWidth($('.message-p-txt').outerWidth());
                        $(".message-p-input").on('keydown', function(event) {
                            var _input = $(this),
                                myHtml = _input.val(),
                                _span = _input.next('.message-p-txt'),
                                spanW;
                            _span.html(myHtml);
                            spanW = _span.outerWidth() + 10;
                            if(_span.outerWidth() <= 430)
                            {
                                _input.outerWidth(spanW);
                            }
                            else
                            {
                                _input.outerWidth(430);
                            }
                        });
                        $(".message-p-input").on('keyup', function(event) {
                            var _input = $(this),
                                _span = _input.next('.message-p-txt'),
                                myHtml = _input.val(),
                                spanW;
                            _span.html(myHtml);
                            spanW = _span.outerWidth() + 10;
                            if(_span.outerWidth() <= 430)
                            {
                                _input.outerWidth(spanW);
                            }
                            else
                            {
                                _input.outerWidth(430);
                            }
                        });
                    });

                    function checkEmpty(el)
                    {
                        var _this  = $(el),
                            _span = _this.next(".message-p-txt"),
                            value = _this.val();
                        if($.trim(value) == "")
                        {
                            _this.val("写点什么吧");
                            _span.html("写点什么吧");
                            _this.outerWidth(_span.outerWidth());
                        }
                    }
                </script>
                <div class="talent-top-right">
                    <?php if(!$info['is_self']){?>
                        <p class="action-p clearfix">

                            <a href="javascript:;" onclick="showMessageWindow()"> <i class="icon-24 icon-24-mail"></i> 私信</a>
                            <?php if(in_array($obj_username,$my_favors)){?>                                                                     <a href="javascript:void(0)"onclick="unfavor('<?=$obj_username?>','<?=$user_info['uid']?>')" id="<?=$obj_username?>" ><i class="icon-24 icon-24-hart"></i> 取消关注</a>
                            <?php } elseif(!empty($vso_uname)) {?>
                                <a href="javascript:void(0)" onclick="favor('<?=$obj_username?>','<?=$user_info['uid']?>')" id="<?=$obj_username?>"><i class="icon-24 icon-24-hart"></i> 加关注</a>
                            <?php } else {?>
                                <a href="<?=yii::$app->params['loginUrl']?>"><i class="icon-24 icon-24-hart"></i> 加关注</a>
                            <?php }?>
                            <?php if(empty($vso_uname)) {?>
                                <a href="<?=yii::$app->params['loginUrl']?>"><i class="icon-24 icon-24-hire"></i>雇佣</a>
                            <?php } else {?>
                                <a href="javascript:void(0)" onclick="dxtender('<?=$obj_username?>')" ><i class="icon-24 icon-24-hire"></i>雇佣</a>
                            <?php }?>
                            <i class="icon-square"></i>
                        </p>
                    <?php } ?>
                    <?php
                    $city=$user_info['city'] ? $user_info['city'] : ($user_info['province'] ? $user_info['province']: '');
                    $auth_page_post= $user_info['auth_age_post'] ? $user_info['auth_age_post'] : '';
                    $auth_constellation= $user_info['auth_constellation'] ? $user_info['auth_constellation'] : '';
                    if($city||$auth_page_post||$auth_constellation)
                    {
                        ?>
                        <p class="info-p clearfix">
                                <span class="pull-right font14">
                                    <?=$city ?><?=($city&&$auth_page_post)?' · ':''?><?=$auth_page_post ?><?=empty($auth_page_post)?'':' · '?><?=$auth_constellation?></span>
                            <i class="icon-square"></i>
                        </p>
                    <?php }?>
                    <?php if (!empty($user_info['lable']))
                    { ?>
                        <p class="info-p clearfix">
                            <?php foreach ($user_info['lable'] as $lable)
                            { ?>
                                <label for="" class="label-clarity"><?= $lable ?></label>
                            <?php } ?>
                            <i class="icon-square"></i>
                        </p>
                    <?php } ?>
                    <!--    暂无                -->
                    <div class="info-p-left clearfix">
                        <!--
                            <p class="info-p clearfix">
                                <span class="pull-right">32</span>
                                <span class="pull-left" >人才排名</span>
                            </p>
                            <p class="info-p clearfix">
                                <span class="pull-right">1232</span>
                                <span class="pull-left" >热度</span>
                            </p>
                        -->
                        <p class="info-p clearfix">
                            <span class="pull-right" id="focus_num"><?= $user_info['focus_num'] ?></span>
                            <span class="pull-left">粉丝数</span>

                        </p>
                        <i class="icon-square"></i>
                    </div>


                    <div class="info-p clearfix">
                                    <span class="pull-right">
                                        <div class="sharebox-new">
                                            <a class="weibo" data-cmd="tsina"></a>
                                            <a class="qq" data-cmd="qq"></a>
                                            <a class="zoom" data-cmd="qzone"></a>
                                            <a class="weixin" data-cmd="weixin">
                                                <div class="weixin-box">
                                                    <div class="pwx-triangle">
                                                        <span><em></em></span>
                                                    </div>
                                                    <div class="weixin-box-img"></div>
                                                    <p>创意云微信公众号</p>
                                                </div>
                                            </a>
                                        </div>
                                    </span>
                        <span class="pull-left" >分享至&nbsp;&nbsp;&nbsp;</span>
                        <i class="icon-square"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="theme-right">
    <div class="gradient-border"></div>
    <!--导航栏-->
    <div class="theme-nav">
        <?php if (($this->context->id=='index'||($this->context->id=='worklist'
                    &&$this->context->action->id=='works'))&&($info['is_self'])) { ?>
            <div id="manage_action_before" class="pull-right">
                <!--
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon2">
                    <span class="input-group-addon btn-green" id="basic-addon2"><i class="glyphicon glyphicon-search"></i></span>
                </div>
                -->
                <a href="javascript:;" class="btn btn-green pull-right" id="manage_works"> <i class="glyphicon glyphicon-th"></i> &nbsp; 管理作品</a>
            </div>
            <div id="manage_action" class="pull-right">
                <a href="javascript:;" class="btn btn-green pull-right" id="manage_action_save"> <i class="glyphicon glyphicon-log-in"></i> &nbsp; 退出管理</a>
            </div>
        <?php } ?>
        <a href="javaScript:void(0)" class="active">动态</a> /
        <a href="javaScript:void(0">作品集</a> /
        <a href="javaScript:void(0)">交易记录</a>
        <?php $count_personal_links = count($user_info['personal_links']);?>
        <?php if ($count_personal_links > 0):?> /
            <?php foreach($user_info['personal_links'] as $k => $val) {?>
                <a href="<?= $val['link_url'] ?>"><?= $val['link_name'] ?></a> <?php if ($k != $count_personal_links - 1):?> / <?php endif;?>
            <?php } ?>
        <?php endif;?>
        <br class="clear">
    </div>
    <!--/导航栏-->
    <p class="theme-time"><b>·</b>2015年6月</p>
    <!--瀑布流-->
    <!--<div class="masonry js-masonry" data-masonry-options='{ "itemSelector": ".masonry-item", "columnWidth":  360}'><!--350-->
    <div class="masonry js-masonry"><!--350-->
        <div class="masonry-item">
            <div class="masonry-pic-dec">
                <h2 class="masonry-pic-title">想，你一定会对蓝海创意云一见倾心</h2>
                <img src="/images/rc/demo-1.jpg">
                <div class="masonry-text">
                    <p>有没有一个人的空间让你流连忘返，有没有一副作品让你魂牵梦绕，有没有一句回复让你欢喜不已…在这个维度，唯有这里将永远对你毫无保留。</p>
                </div>
                <div class="masonry-action masonry-action-self ">
                    <a href="" class="masonry-action-close pull-right" data-target="#deleteModal" data-toggle="modal" data-target="#myModal" data-toggle="modal">×</a>
                    <a href="" class="masonry-action masonry-action-self">编辑</a> / <a href="javascript:;" class="masonry-action-change">更换作品集</a>
                </div>
                <div class="masonry-action">
                    <span class="label label-green pull-right">小说</span> <br />
                    <span> <i class="icon-24 icon-24-message"></i>30 <b class="icon-word">评论 &nbsp;&nbsp;/</b></span>
                    <i class="icon-24 icon-24-heart"></i>324 <b class="icon-word">喜欢</b>
                </div>
            </div>
        </div>
        <div class="masonry-item">
            <div class="masonry-pic-dec">
                <h2 class="masonry-pic-title">只为记下你的时光</h2>
                <img src="/images/rc/demo-2.jpg">
                <div class="masonry-text">
                    <p>没有图片的空间总是略显孤单。</p>
                    <p>偶尔，会默默期待，天堂是座挂满照片的花园。</p>
                </div>
                <div class="masonry-action masonry-action-self">
                    <a href="" class="masonry-action-close pull-right" data-target="#deleteModal" data-toggle="modal">×</a>
                    <a href="" class="masonry-action masonry-action-self">编辑</a> / <a href="javascript:;" class="masonry-action-change">更换作品集</a>
                </div>
                <div class="masonry-action">
                    <span class="label label-green pull-right">心情故事</span> <br />
                    <span> <i class="icon-24 icon-24-message"></i>30 <b class="icon-word">评论 &nbsp;&nbsp;/</b></span>
                    <i class="icon-24 icon-24-heart"></i>324 <b class="icon-word">喜欢</b>
                </div>
            </div>
        </div>
        <div class="masonry-item">
            <div class="masonry-word">
                <h2 class="masonry-pic-title">你看，你在我的世界光芒万丈</h2>
                <div class="masonry-text">
                    <p>这个世界上，总有些人拍了片不知道给谁看，画了画不知道放哪里保存，把作品发到微博似乎有点冷清，转去微信又太多的不相干。可我们总是需要分享，总是需要观众，我们都是群居动物，终究无法独活。</p>
                    <p>于是，有了这里——蓝海创意云 · 个人空间</p>

                </div>
                <div class="masonry-action masonry-action-self ">
                    <a href="" class="masonry-action-close pull-right" data-target="#deleteModal" data-toggle="modal">×</a>
                    <a href="" class="masonry-action masonry-action-self">编辑</a> / <a href="javascript:;" class="masonry-action-change">更换作品集</a>
                </div>
                <div class="masonry-action">
                    <span class="label label-green pull-right">分享</span> <br />
                    <span> <i class="icon-24 icon-24-message"></i>30 <b class="icon-word">评论 &nbsp;&nbsp;/</b></span>
                    <i class="icon-24 icon-24-heart"></i>324 <b class="icon-word">喜欢</b>
                </div>
            </div>

        </div>
        <div class="masonry-item">
            <div class="masonry-pic-dec">
                <h2 class="masonry-pic-title">蓝海创意云个人空间——专注创作的空间</h2>
                <img src="/images/rc/demo-3.jpg">
                <div class="masonry-text">
                    <p>蓝海创意云的个人空间全面升级，提供多款模板搭配，和个性化页面设置，只为创作的你提供最优的服务。</p>
                    <p>极简风格：蓝海创意云 · 个人空间追求细致的视觉体验，每个像素，每个角度，每寸目光所及，都是独具匠心之作。</p>
                    <p>精致品质：蓝海创意云 · 个人空间只为展示你，为你隔开其他琐碎又无关的打扰，也希望通过你的推荐分享，帮助我们打造一个精致又充实的空间环境。</p>
                    <p>人性功能：蓝海创意云 · 个人空间提供直接雇佣功能，方便双方邀约创作。在这个大千世界，虽未相熟，但下一秒也许就有人向你发布专属的任务信息。</p>
                </div>
                <div class="masonry-action masonry-action-self ">
                    <a href="" class="masonry-action-close pull-right" data-target="#deleteModal" data-toggle="modal">×</a>
                    <a href="" class="masonry-action masonry-action-self">编辑</a> / <a href="javascript:;" class="masonry-action-change">更换作品集</a>
                </div>
                <div class="masonry-action">
                    <span class="label label-green pull-right">个性化</span> <br />
                    <span> <i class="icon-24 icon-24-message"></i>30 <b class="icon-word">评论 &nbsp;&nbsp;/</b></span>
                    <i class="icon-24 icon-24-heart"></i>324 <b class="icon-word">喜欢</b>
                </div>
            </div>
        </div>
        <div class="masonry-item">
            <div class="masonry-pic-dec">
                <h2 class="masonry-pic-title">花影缭乱，雀鸟迁徙</h2>
                <img src="/images/rc/demo-4.jpg">
                <div class="masonry-text">
                    <p>总爱丢东西，做过的事情也总记不住，需要经常记录下来，似乎应该感谢创造互联网的人，感谢起码有这样一个地方能够永远保留些什么下来。</p>
                    <p>码字或者是画画对我而言算不上多大的追求，但是因为这些认识了很多形形色色的人。我的作品也从一个空间搬到了下一个空间，记不住密码登录名成为了首要原因。后来就总呆在微博之类的发发图了。但是渐渐的，似乎微博也仅仅成了聊八卦的地方，看图看文的人也少了。</p>
                    <p>遇到蓝海创意云是个偶然，有小伙伴对我说这里和其他的网站不太一样，我带着怀疑进来看了看，确突然感到熟悉的温暖。这里没有那些喧嚣嘈杂，有的是纯粹的创作热情。有人看上你的作品，可以很简单的就邀约你作画。传传作品，码码文字，接点小活，找点伙伴，生活终于得以以充实而鲜活起来。</p>
                </div>
                <div class="masonry-action masonry-action-self ">
                    <a href="" class="masonry-action-close pull-right" data-target="#deleteModal" data-toggle="modal">×</a>
                    <a href="" class="masonry-action masonry-action-self">编辑</a> / <a href="javascript:;" class="masonry-action-change">更换作品集</a>
                </div>
                <div class="masonry-action">
                    <span class="label label-green pull-right">随记</span> <br />
                    <span> <i class="icon-24 icon-24-message"></i>30 <b class="icon-word">评论 &nbsp;&nbsp;/</b></span>
                    <i class="icon-24 icon-24-heart"></i>324 <b class="icon-word">喜欢</b>
                </div>
            </div>
        </div>
        <div class="masonry-item">
            <div class="masonry-pic-dec">
                <h2 class="masonry-pic-title">小确幸</h2>
                <img src="/images/rc/demo-5.jpg">
                <div class="masonry-text">
                    <p>- 跑龙套的小群众是无法打倒怪兽的。</p>
                    <p style="position:relative; left:50%;">谁说的，怪兽那么可爱为什么要打倒。-</p>
                </div>
                <div class="masonry-action masonry-action-self ">
                    <a href="" class="masonry-action-close pull-right" data-target="#deleteModal" data-toggle="modal">×</a>
                    <a href="" class="masonry-action masonry-action-self">编辑</a> / <a href="javascript:;" class="masonry-action-change">更换作品集</a>
                </div>
                <div class="masonry-action">
                    <span class="label label-green pull-right">创意记</span> <br />
                    <span> <i class="icon-24 icon-24-message"></i>30 <b class="icon-word">评论 &nbsp;&nbsp;/</b></span>
                    <i class="icon-24 icon-24-heart"></i>324 <b class="icon-word">喜欢</b>
                </div>
            </div>
        </div>
    </div>
    <!--/瀑布流-->

</div>

<div class="content-first-bg"></div>
<div class="content-second-bg"></div>
<div class="content-third-bg"></div>
</div>
<ul class="works-sample-ul">
    <li><a href="">原画角色</a></li>
    <li><a href="">原画场景</a></li>
    <li><a href="">物件联系</a></li>
    <li class="works-sample-add" data-target="#myModal" data-toggle="modal"><a href="javascript:;">+</a></li>
</ul>
<!--
<div class="modal fade" id="sendMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                       <h4 class="modal-title" id="myModalLabel">创建作品集</h4>
                </div>
                <div class="modal-body">
                     <div class="input-group">
                        <input type="text" class="form-control" placeholder="作品集名称" aria-describedby="basic-addon2">
                        <span class="input-group-addon btn-green" id="basic-addon2">确定</span>
                    </div>
                    <div id="uploader">
                        <div class="queueList">
                            <div id="dndArea" class="placeholder">
                                <div id="filePicker"></div>
                                <p>或将照片拖到这里，单次最多可选1张</p>
                            </div>
                        </div>
                        <div class="statusBar" style="display:none;">
                            <div class="progress">
                                <span class="text">0%</span>
                                <span class="percentage"></span>
                            </div><div class="info"></div>
                            <div class="btns">
                                <div id="filePicker2"></div><div class="uploadBtn">开始上传</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
    </div>
    -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">创建作品集</h4>
            </div>
            <div class="modal-body clearfix">
                <div class="col-xs-6 pull-right text-right">
                    <img src="/images/rc/personal/space/demo-1.jpg" alt="">
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="" class="form-label">作品集名称</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">作品集封面</label>
                        <div class="form-upload">
                            <span>从本地上传</span>
                            <input type="file">
                        </div>
                    </div>
                    <div class="form-group btn-works-group">
                        <button class="btn btn-darkgrey">保存</button>
                        <button class="btn btn-darkgrey">取消</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">系统提示</h4>
            </div>
            <div class="modal-body clearfix">

                <div class="text-center pd20">
                    <p class="modal-tip">您确认删除吗？</p>
                    <div class="form-group btn-works-group">
                        <button class="btn btn-darkgrey">确定</button>
                        <button class="btn btn-darkgrey">取消</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="sendMessage" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">私信：012375968（012375968）</h4>
            </div>
            <div class="modal-body clearfix">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="" class="form-label">消息标题：</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">发送短信：</label>
                        <textarea class="form-control" placeholder=""></textarea>
                        <div class="message-details">
                            <span id="message_content_tip" class="tip">已输入长度0，还可以输入1000字</span>
                        </div>
                    </div>
                    <div class="form-group btn-works-group text-right">
                        <button class="btn btn-darkgrey">发 送</button>
                        <button class="btn btn-darkgrey">重 置</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="http://static.vsochina.com/libs/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="http://static.vsochina.com/libs/masonry/3.3.2/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="http://static.vsochina.com/libs/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="/js/talent_space.js"></script>
<script>
    $(function()
    {
        var container = $('.masonry');
        imagesLoaded(container, function() {
            container.masonry(<?php echo isset($meta['css'])?$meta['css']['meta_value']:'{itemSelector : ".masonry-item", columnWidth : 360' ?>);
        });
    });
    $(".masonry-action-change").on("click",function (event) {
        var offsetTop = $(this).offset().top;
        var offsetLeft = $(this).offset().left;
        var offsetHeight = $(this).height();
        var _this = $(this);
        if($(".works-sample-ul:visible").length>=1 && $(this).hasClass("active")){
            $(".works-sample-ul").slideUp();
            _this.removeClass("active");
        }else if($(".works-sample-ul:visible").length>=1 && !$(this).hasClass("active")){
            $(".works-sample-ul").slideUp(100,function(){
                $(".works-sample-ul").css({"left":offsetLeft+"px","top":(offsetTop+offsetHeight)+"px"}).slideDown();
                $(".masonry-action-change").removeClass("active");
                _this.addClass("active");
            });
        }else{
            $(".works-sample-ul").css({"left":offsetLeft+"px","top":(offsetTop+offsetHeight)+"px"}).slideDown();
            $(".masonry-action-change").removeClass("active");
            $(this).addClass("active");
        }
        stopPropagation(event);
    });
    $(document).on("click",function(){
        $(".works-sample-ul").slideUp(100,function(){
            $(".masonry-action-change").removeClass("active");
        });
    })
    $("#manage_works").on("click",function(){
        $(".masonry-action").hide();
        $(".masonry-action-self").show();
        $("#manage_action").show();
        $("#manage_action_before").hide();
        $('[data-link="true"]').attr("data-link","false");
    });
    $("#manage_action_save").on("click",function(){
        $("#manage_action").hide();
        $("#manage_action_before").show();
        $(".masonry-action").show();
        $(".masonry-action-self").hide();
        $('[data-link="false"]').attr("data-link","true");
    });
    /*阻止冒泡*/
    function stopPropagation(event){
        if (event.stopPropagation)  event.stopPropagation();
        else  event.cancelBubble = true;
    }

    $(document).on("click",'[data-link="true"]',function(){
        var url = $(this).attr("data-link-url");
        window.open(url);
    });
</script>
</body>
</html>