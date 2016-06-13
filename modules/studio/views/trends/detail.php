<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?=$_studio['studio_name']?> · <?=$_trends['name']?> | 创意空间</title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="renderer" content="webkit"/>
    <meta name="baidu-site-verification" content="NpzvG27pvo" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/jplayer/2.9.1/skin/blue.monday/jplayer.blue.monday.css" />
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.3.5/css/bootstrap.min.css?v1.4">
    <link rel="stylesheet" type="text/css" href="http://account.vsochina.com/static/css/login/common.css?v1.4" />
    <link rel="stylesheet" type="text/css" href="/css/kkpager_blue.css">
    <link rel="stylesheet" type="text/css" href="/css/studio.css">
    <script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
</head>
<body>
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_header.php')?>

<!-- content -->
    <div class="stuidio-contentbox">
        <div class="studio-middle-content">
            <div class="ds-1200 clearfix">
                <div class="trends-content-left pull-left">
                    <div class="trends-content-inner">
                        <div class="inner clearfix">
                            <div class="inner-top clearfix">
                                <i class="bread-home"></i>
                                <a href="http://maker.vsochina.com">创意空间</a> &gt;
                                <a href="http://maker.vsochina.com/studiolist">工作室</a> &gt;
                                <a href="http://maker.vsochina.com/studio/index/detail?s_id=<?=$_studio['s_id']?>"><?= $_studio['studio_name']?></a> &gt;
                                <span><?= $_trends['name']?></span>
                            </div>
                            <div class="inner-mid clearfix">
                                <div class="head clearfix">
                                    <h1><span class="green"></span><?= $_trends['name']?></h1>
                                    <div class="journal">
                                        阅读 <?= $_trends['v_num']?> <span class="s-journal">|</span>
                                        评论 <?= $_trends['c_num']?><span class="s-journal">|</span><?= date('Y-m-d H:i',$_trends['create_time'])?>
                                    </div>
                                </div>
                                <div class="contain clearfix">
                                    <?php if($_trends['type'] == 1):?>
                                        <!--图片作品-->
                                        <?php if ($_trends['images']):?>
                                            <?php foreach(json_decode($_trends['images']) as $img):?>
                                                <img class="picture1" src="<?=$img?>">
                                            <?php endforeach;?>
                                        <?php endif;?>
                                        <!--视频作品-->
                                        <?php elseif($_trends['type'] == 2):?>
                                            <?php if(!empty(json_decode($_trends['videos'])->video)):?>
                                                <div id="jp_container_1" class="jp-video jp-video-360p jp-video-width" role="application" aria-label="media player">
                                                    <div class="jp-type-single">
                                                        <div id="jquery_jplayer_1" class="jp-jplayer"></div>
                                                        <div class="jp-gui">
                                                            <div class="jp-video-play">
                                                                <button class="jp-video-play-icon" role="button" tabindex="0">play</button>
                                                            </div>
                                                                <div class="jp-interface">
                                                                    <div class="jp-progress">
                                                                        <div class="jp-seek-bar">
                                                                            <div class="jp-play-bar"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                                                                    <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                                                                    <div class="jp-controls-holder">
                                                                        <div class="jp-controls">
                                                                            <button class="jp-play" role="button" tabindex="0">play</button>
                                                                            <button class="jp-stop" role="button" tabindex="0">stop</button>
                                                                        </div>
                                                                        <div class="jp-volume-controls">
                                                                            <button class="jp-mute" role="button" tabindex="0">mute</button>
                                                                            <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                                                                            <div class="jp-volume-bar">
                                                                                <div class="jp-volume-bar-value"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="jp-toggles">
                                                                            <button class="jp-repeat" role="button" tabindex="0">repeat</button>
                                                                            <button class="jp-full-screen" role="button" tabindex="0">full screen</button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="jp-details">
                                                                        <div class="jp-title" aria-label="title">&nbsp;</div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <script>
                                                    $(function(){
                                                        $("#jquery_jplayer_1").jPlayer({
                                                                ready: function () {
                                                                    $(this).jPlayer("setMedia", {
                                                                        title: "",
                                                                        m4v: "<?=json_decode($_trends['videos'])->video?>",
                                                                        flv: "http://static.vsochina.com/media/Waliczky_Wheels-HD-demo.flv",
                                                                        poster: "static/images/video1.jpg"
                                                                    });
                                                                },
                                                                swfPath: "http://static.vsochina.com/libs/jplayer/2.9.1",
                                                                supplied: "m4v,flv",
                                                                size: {
                                                                    width: "580px",
                                                                    height: "320px",
                                                                    cssClass: "jp-video-360p"
                                                                },
                                                                cssSelectorAncestor: "#jp_container_1",
                                                                globalVolume: true,
                                                                useStateClassSkin: true,
                                                                autoBlur: false,
                                                                smoothPlayBar: true,
                                                                keyEnabled: true
                                                            });
                                                        });
                                                    </script>
                                            <?php else:?>
                                                <div id="media_container" fwin="display">
                                                    <div id="mediaplayer_wrapper" style="position: relative; width: 600px; height: 408px;" fwin="display">
                                                        <embed src="<?=json_decode($_trends['videos'])->link?>" quality="high" width="600" height="396" align="middle" allowScriptAccess="always" allowFullScreen="true" mode="transparent" type="application/x-shockwave-flash"></embed>
                                                    </div>
                                                </div>
                                            <?php endif;?>
                                    <?php endif;?>
                                    <div class="txt1">
                                        <?= $_trends['content']?>
                                    </div>
                                    <ul class="tags">
                                        <?php if(is_array(json_decode($_trends['tag']))):?>
                                            <?php foreach(json_decode($_trends['tag']) as $t):?>
                                                <li>#<?=$t;?></li>
                                            <?php endforeach;?>
                                        <?php endif;?>
                                </div>
                            </div>
                            <script>
                                var type = <?=$_trends['copyright']?>;
                                $(document).ready(function(){
                                    //状态1,2,5下禁用图片展示div的浏览器右键菜单功能
                                    if(type == 1 || type == 2 || type == 5)
                                    {
                                        $(".contain").bind("contextmenu",function(e){
                                            return false;
                                        });
                                    }
                                });
                            </script>
                            <div class="inner-foot clearfix">
                                <div class="inner-foot-share pull-left">
                                    <div class="p1"></div>
                                    <span class="prompt">分享</span>
                                    <div class="sharetrends">
                                        <a class="weibo" data-cmd="tsina" href="" target="_blank"></a>
                                        <a class="qq" data-cmd="qq" href="" target="_blank"></a>
                                        <a class="zoom" data-cmd="qzone" href="" target="_blank"></a>
                                        <a class="weixin" data-cmd="weixin">
                                            <div class="weixin-box">
                                                <div class="wx-triangle">
                                                    <span><em></em></span>
                                                </div>
                                                <div class="weixin-box-img"></div>
                                                <p>创意云微信公众号</p>
                                            </div>

                                        </a>
                                    </div>
                                </div>
                                <div class="upload-content-copyright dropup pull-left">
                                        <a class="copyright-btn _open_status_icon copyright-dark" href="javascript:void(0);">
                                            <i class="copyright-icon copyright-icon-<?=$_trends['copyright']?>"></i>
                                        <span class="copyright-desc">
                                            <?php switch($_trends['copyright']):
                                                case 1:?>
                                                    作品禁止看大图
                                                    <?php break;?>
                                                <?php case 2:?>
                                                    作品禁止右键另存为
                                                    <?php break;?>
                                                <?php case 3:?>
                                                    作品禁止商业使用
                                                    <?php break;?>
                                                <?php case 4:?>
                                                    不限制作品用途
                                                    <?php break;?>
                                                <?php case 5:?>
                                                    禁止右键另存和商业使用
                                                    <?php break;?>
                                                <?php endswitch;?>
                                        </span>
                                        </a>
                                    <ul class="dropdown-menu _chose_open_status" aria-labelledby="dLabel">
                                        <li data="1" <?=$_trends['copyright']==1?'class="copyright-selected"':''?>>
                                            <a class="clearfix">
                                                <i class="copyright-icon copyright-icon-1"></i>

                                                <p class="copyright-desc">禁止看大图</p>
                                            </a>
                                        </li>
                                        <li data="2" <?=$_trends['copyright']==2?'class="copyright-selected"':''?>>
                                            <a class="clearfix">
                                                <i class="copyright-icon copyright-icon-2"></i>

                                                <p class="copyright-desc">作品禁止右键另存为</p>
                                            </a>
                                        </li>
                                        <li data="3" <?=$_trends['copyright']==3?'class="copyright-selected"':''?>>
                                            <a class="clearfix">
                                                <i class="copyright-icon copyright-icon-3"></i>

                                                <p class="copyright-desc">作品禁止商业使用</p>
                                            </a>
                                        </li>
                                        <li data="4" <?=$_trends['copyright']==4?'class="copyright-selected"':''?>>
                                            <a class="clearfix">
                                                <i class="copyright-icon copyright-icon-4"></i>

                                                <p class="copyright-desc">不限制作品用途</p>
                                            </a>
                                        </li>
                                        <li data="5" <?=$_trends['copyright']==5?'class="copyright-selected"':''?>>
                                            <a class="clearfix">
                                                <i class="copyright-icon copyright-icon-5"></i>

                                                <p class="copyright-desc">禁止右键另存和商业使用</p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                    <?php if(isset($username) && !empty($username)):?>
                                        <?php if($_fav):?>
                                            <a class="ds-btn ds-btn-smallgreen ds-btn-loved pull-right" onclick="fav(this)"><i class="icon-nice"></i>&nbsp;点赞</a><!--ds-btn-loved-->
                                        <?php else:?>
                                            <a class="ds-btn ds-btn-smallgreen ds-btn-loved pull-right" onclick="unfav(this)"><i class="icon-nice"></i>&nbsp;取消赞</a><!--ds-btn-loved-->
                                        <?php endif;?>
                                    <?php else:?>
                                        <a class="ds-btn ds-btn-smallgreen ds-btn-loved pull-right" onclick="popLogin();"><i class="icon-nice"></i>&nbsp;点赞</a><!--ds-btn-loved-->
                                    <?php endif;?>
                            </div>
                        </div>
                    </div>
                    <div class="trends-content-inner reply-detail">
                        <p class="reply-detail-title">全部评论（<span class="reply-detail-num"><?=$_comment['all_total']?></span>）</p>
                        <?php if(isset($username) && !empty($username)):?>
                            <div class="reply-detail-entry comment_switch">
                                <span class="reply-detail-textarea-top" id="comment_count">[<?=$nickname?>] 评论 ：</span>
                                <div class="reply-detail-textarea"><span></span><textarea></textarea></div>
                            </div>
                            <input type="button" class="reply-detail-entry-btn" value="发布" nick_name="<?=$nickname?>" user_name="<?=$username?>" onclick="addReply(this)" t_id="<?=$_trends['id']?>">
                        <?php else:?>
                            <div class="reply-detail-entry comment_switch">
                                <span class="reply-detail-textarea-top" id="comment_count">游客您需要 <a href="javascript:popLogin()">登录</a> 才可以评论，没有账号请 <a target="_blank" href="http://www.vsochina.com/index.php?do=prom&u=34885&p=reg">注册</a> O(∩_∩)O~</span>
                            </div>
                            <input type="button" class="reply-detail-entry-btn" value="发布">
                        <?php endif;?>

                        <br class="clear">
                        <ul class="reply-detail-lst clearfix">
                            <?php foreach($_comment['items'] as $comm):?>
                                <li comment_id="<?=$comm['id']?>" class="reply-detail-lst-li">
                                    <a class="reply-detail-head" target="_blank" href="http://rc.vsochina.com/talent/<?=$comm['user']['username']?>"><img alt="" src="<?=$comm['user']['icon']?>"></a>
                                    <div comment_id="<?=$comm['id']?>" class="">
                                        <div class="reply-user-info">
                                            <a class="blue-14" target="_blank" href="http://rc.vsochina.com/talent/<?=$comm['user']['username']?>"><?=$comm['user']['nickname']?></a>
                                            <?php
                                                $passSeconds = time()-$comm['create_time'];
                                            ?>
                                            <?php if($passSeconds < 60):?>
                                                <?=$passSeconds.'秒前'?>
                                            <?php elseif($passSeconds / 60 < 60):?>
                                                <?=round($passSeconds / 60,0).'分钟前'?>
                                                <?php elseif($passSeconds / 60 / 60 < 24):?>
                                                <?=round($passSeconds / 60 / 60,0).'小时前';?>
                                                <?php elseif($passSeconds / 60 / 60 / 24 < 365):?>
                                                <?=round($passSeconds / 60 / 60 / 24,0).'天前';?>
                                                <?php else:?>
                                                <?=round($passSeconds / 60 / 60 / 24 / 365,0).'年前';?>
                                            <?php endif;?>
                                        <span class="reply-detail-action">
                                            <?php if(isset($username) && !empty($username)):?>
                                                <a nick_name="<?=$comm['user']['nickname']?>" user_name="<?=$comm['user']['username']?>" p_id="<?=$comm['id']?>" comment_id="<?=$comm['id']?>" onclick="addReplyContent(this)" class="reply-detail-add" href="javaScript:void(0)">回复</a>
                                            <?php endif;?>
                                        </span>
                                        </div>
                                        <div class="reply-user-txt"><?=$comm['content']?></div>
                                    </div>
                                    <?php if(count($comm['sub']) > 0):?>
                                    <div  class="replay-ul">
                                        <em class="triangle-up"></em>
                                        <i class="triangle-up"></i>
                                        <ul>
                                           <?php foreach($comm['sub'] as $su):?>
                                               <li reply_id="<?=$su['id']?>" class="clearfix">
                                                   <a class="replay-ul-head" href=""><img src="<?=$su['user']['icon']?>"></a>
                                                   <div class="reply-detail-action">
                                                       <?php if($username == $su['user']['username']):?>
                                                           <a reply_id="<?=$su['id']?>" onclick="deleteReply(this)" href="javaScript:void(0)">删除</a>
                                                       <?php endif;?>
                                                   </div>
                                                   <a target="_blank" href="http://rc.vsochina.com/talent/<?=$su['user']['username']?>"><?=$su['user']['nickname']?></a>
                                                   <span>回复</span>
                                                   <a target="_blank" href="http://rc.vsochina.com/talent/<?=$su['user']['username']?>"><?=$comm['user']['nickname']?></a>：说<?=$su['content']?>
                                               </li>
                                            <?php endforeach;?>
                                        </ul>

                                    </div>
                                    <?php endif;?>
                                </li>
                            <?php endforeach;?>
                        </ul>
                        <div style="margin-top: 15px;" id="mainsrp-pager">
                            <div id="kkpager">
                                <div>
                                    <span class="pageBtnWrap">
                                        <span class="disabled" page_no="">上一页</span>
                                        <span class="curr" page_no="1">1</span>
                                        <span class="disabled" page_no="">下一页</span>
                                    </span>
                                    <span class="infoTextAndGoPageBtnWrap">
                                        <span class="totalText">当前第<span class="currPageNum">1</span>页</span>
                                    </span>
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="trends-content-right pull-right" >
                    <div class="trends-content-inner">
                        <div class="trends-content-head">
                            <a href="http://maker.vsochina.com/studio/index/detail?s_id=<?=$_studio['s_id']?>">
                                <img src="<?= $_studio['studio_icon']?>" alt="<?= $_studio['studio_name']?>">
                            </a>
                        </div>
                        <p class="trends-content-title">
                            <a href="http://maker.vsochina.com/studio/index/detail?s_id=<?=$_studio['s_id']?>">
                                <?= $_studio['studio_name']?>
                            </a>
                        </p>
                        <p class="trends-content-item">
                        <?php foreach ($_studio['categories'] as $index => $ind): ?>
                            <span><?= $ind['name']?></span>
                            <?php if(count($_studio['categories']) != $index + 1): ?>
                            <span class="studio-cut">|</span>
                            <?php endif;?>
                        <?php endforeach; ?>
                        </p>

                        <?php if($username != $_studio['studio_owner']): //创建者无关注按钮?>
                            <div class="trends-content-inner-green">
                                <?php if($username && $_studio['is_f']):?>
                                    <a class="unfocus-btn"  onclick="unfocusStudio('<?=$_studio['s_id']?>', '<?=$username?>')" href="javascript:void(0);">取消关注</a>
                                    <a class="focus-btn" style="display: none;" onclick="focusStudio('<?=$_studio['s_id']?>', '<?=$username?>')" href="javascript:void(0);">关注</a>
                                <?php else:?>
                                    <a class="unfocus-btn" style="display: none;" onclick="unfocusStudio('<?=$_studio['s_id']?>', '<?=$username?>')" href="javascript:void(0);">取消关注</a>
                                    <a class="focus-btn" onclick="focusStudio('<?=$_studio['s_id']?>', '<?=$username?>')" href="javascript:void(0);">关注</a>
                                <?php endif;?>
                                <?php if(!($username && $_studio['is_m'])):?>
                                    <a href="" rel="nofollow">申请加入</a>
                                <?php endif;?>
                            </div>
                        <?php endif;?>
                        <ul class="trends-logo-box clearfix">
                            <li class="trends-first-item">
                                <p class="trends-content-num"><?= $_studio['v_num']?></p>
                                <p class="trends-content-browse">浏览</p>
                            </li>
                            <li>
                                <p class="trends-content-num studio-fans-num"><?= $_studio['f_num']?></p>
                                <p class="trends-content-browse">粉丝</p>
                            </li>
                        </ul>
                        <dl class="trends-content-tabox" id="other_trends">
                            <dd class="trends-tabox-title">TA的动态</dd>
                            <?php foreach($_others['_items'] as $oth):?>
                                <dd class="trends-list-name <?=($oth['type']==1)?'iconfont-pic':($oth['type']==2?'iconfont-shipin':'iconfont-mulu')?>">
                                    <a href="<?='http://maker.vsochina.com/studio/trends/detail?id='.$oth['id']?>"><?=$oth['name']?></a>
                                </dd>
                                <dd class="trends-list-comment">评论 <?=$oth['c_num']?> | 点赞 <?=$oth['f_num']?> | <?=date('Y.m.d',$oth['create_time'])?></dd>
                            <?php endforeach;?>
                        </dl>
                        <a href="http://maker.vsochina.com/studio/index/detail?s_id=<?=$_studio['s_id']?>" target="_self" class="trends-more">更多动态</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript" src="http://static.vsochina.com/libs/jplayer/2.9.1/jquery.jplayer.min.js"></script>
<!-- /content -->
    <script>
        $(".reply-detail-textarea textarea").on("keyup keydown keypress",function(){
            var text = $(this).val();
            if(text.length>0){$(".reply-detail-entry").css("border-color","#aaaaaa");}else $(".reply-detail-entry").css("border-color","red");
            $(this).prev("span").html(text);
        });


        //关注工作室
        function focusStudio(id, username) {
            if(username) {
                $.ajax({
                    url: '/studio/index/focus',
                    data: {
                        s_id: id
                    },
                    type: 'POST',
                    dataType: 'json',
                    success: function(json) {
                        if (json.result) {
                            // 关注数加1
                            $(".studio-fans-num").html(parseInt($(".studio-fans-num").html()) + 1);
                            // 切换按钮
                            $(".unfocus-btn").show();
                            $(".focus-btn").hide();
                        }
                    }
                })
            }
            else {
                // 弹出登录框
            }
        }

        //取消关注工作室
        function unfocusStudio(id, username) {
            if(username) {
                $.ajax({
                    url: '/studio/index/unfocus',
                    data: {
                        s_id: id
                    },
                    type: 'POST',
                    dataType: 'json',
                    success: function(json) {
                        if (json.result) {
                            // 关注数加1
                            $(".studio-fans-num").html(parseInt($(".studio-fans-num").html()) - 1);
                            // 切换按钮
                            $(".unfocus-btn").hide();
                            $(".focus-btn").show();
                        }
                    }
                })
            }
            else {
                // 弹出登录框
            }
        }

        //版权设置
        $(".upload-content-copyright .dropdown-menu li").on('click', function (event) {
            var _this = $(this),
                _obj = $(".upload-content-copyright .copyright-btn"),
                iconClass = _this.find('i').prop("className"),
                txt = _this.find('.copyright-desc').html();
            _this.addClass('copyright-selected').siblings().removeClass('copyright-selected');
//                    _obj.addClass('copyright-dark').find('i').removeClass().addClass(iconClass).next('.copyright-desc').html(txt);
            _obj.addClass('copyright-dark').find('i').attr('class', '').addClass(iconClass).next('.copyright-desc').html(txt);
        });

        $(function(){
            sharetrends();
            function sharetrends(){
                var url = window.location.href+"";
                console.info(url);
                var title ='<?= $_trends['name']?>';
                var desc = '<?=strip_tags($_trends['content'])?>';
                var pic ='<?=yii::$app->params['frontendurl'].$_trends['banner']?>';
                var summary = '<?=strip_tags($_trends['content'])?>';
                share(url,title,pic,desc,summary,$(".sharetrends"));
            }
        });

        /**
         * 点赞
         */
        function fav(btn)
        {
            $(btn).removeAttr("onclick");
            $.ajax({
                type:"POST",
                dataType:"json",
                data:{"t_id":<?=$_trends['id']?>},
                url:"<?=yii::$app->urlManager->createUrl(['/studio/trends/favor']);?>",
                success:function(json)
                {
                    if(json.fav_res)
                    {
                        $(btn).attr("onclick","unfav(this)");
                        $(btn).html("<i class='icon-nice'></i>&nbsp;取消赞");
                    }
                    else
                    {
                        alert(json.message);
                    }
                }
            });
        }

        /**
         * 取消赞
         */
        function unfav(btn)
        {
            $(btn).removeAttr("onclick");
            $.ajax({
                type:"POST",
                dataType:"json",
                data:{"t_id":<?=$_trends['id']?>},
                url:"<?=yii::$app->urlManager->createUrl(['/studio/trends/unfavor']);?>",
                success:function(json)
                {
                    if(json.unfav_res)
                    {
                        $(btn).attr("onclick","fav(this)");
                        $(btn).html("<i class='icon-nice'></i>&nbsp;点赞");
                    }
                    else
                    {
                        alert(json.message);
                    }
                }
            });
        }

        /**
         * 删除评论
         * @param btn 删除评论按钮
         */
        function deleteReply(btn)
        {
            var commId = $(btn).attr("reply_id");
            if(confirm("确定删除该评论?"))
            {
                $.ajax({
                    type:"POST",
                    dataType:"json",
                    data:{"id":commId},
                    url:"<?=yii::$app->urlManager->createUrl(['/studio/trends/delete-comment']);?>",
                    success:function(json)
                    {
                        if(json.res)
                        {
                            var li = $("li").find("[reply_id="+commId+"]");
                            var div = li.parent().parent();
                            li.remove();
                            if(div.find("ul").find("li").length == 0)
                            {
                                div.remove();
                            }
                        }
                    }
                });
            }
        }

        function addReplyContent(btn)
        {
            var subBtn = $(".reply-detail-entry-btn");
            subBtn.attr("p_id",$(btn).attr("p_id"));
            subBtn.attr("comment_id",$(btn).attr("comment_id"));
            subBtn.removeAttr("t_id");
            $(".reply-detail-textarea textarea").focus();
            $("#comment_count").html("["+subBtn.attr("nick_name")+"] 回复 ["+$(btn).attr("nick_name")+"] ：");
        }

        function addReply(btn)
        {
            console.info($(btn));
            var tid = $(btn).attr("t_id");
            var data = {"content":$("textarea").val()};
            if(tid == undefined)
            {
                data.p_id = $(btn).attr("p_id");
            }
            else
            {
                data.t_id = tid;
            }

            console.info(data);
            $.ajax({
                type:"POST",
                dataType:"json",
                data:data,
                url:"<?=yii::$app->urlManager->createUrl(['/studio/trends/add-comment']);?>",
                success:function(json)
                {
                    window.location.reload();
                }
            });
        }

        function popLogin()
        {
            $("#login_pop_redirect").val(window.location.href);
            openLoginpop();
        }
    </script>
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_footer.php')?>
</body>
</html>
