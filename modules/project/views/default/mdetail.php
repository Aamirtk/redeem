<?php
use frontend\modules\activity\models\SpringUtil;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="renderer" content="webkit"/>
        <title><?= isset($seo['seo_title']) ? $seo['seo_title'] : '《'.$cz_project['proj_name'].'》-创客空间-蓝海创意云'  ?></title>
        <meta name="keywords" content="<?= isset($seo['seo_title']) ? $seo['seo_keywords'] : '蓝海创意云'  ?>" />
        <meta name="description" content="<?= isset($seo['seo_desc']) ? $seo['seo_desc'] : '蓝海创意云'  ?>" />

        <!--reset.css  header.css  footer.css-->
        <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/public/resetcss/mreset.css"/>
        <link rel="stylesheet" type="text/css" href="/css/mdetail.css"/>
        <!--jquery-->
        <script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
        <!--cookie domain-->
        <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
        <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
        <script type="text/javascript" src="http://static.vsochina.com/public/fontSize/fontSize.js"></script>
    </head>
    <body>
        <!--顶部制作单位简介-->
        <input type="hidden" id="proj_name" value="<?= $cz_project['proj_name'] ?>">
        <div class="mobile-box mdetail mdetail-top clearfix" id="top">
            <dl class="mdetail-company">
                <dt>
                    <?php if (isset($project['user']['avatar']) && !empty($project['user']['avatar'])): ?>
                        <a href="/talent/<?= $project['username'] ?>" target="_blank" class="detail-portrait-50">
                            <img src="<?= $project['user']['avatar'] ?>" alt="<?= $project['user']['nickname'] ?>" />
                        </a>
                    <?php endif;?>
                </dt>
                <dd class="mdetail-company-name"><?= $project['user']['nickname'] ?></dd>
                <dd class="mdetail-company-category"><?= $project['user']['tag'] ?></dd>
            </dl>
            <div class="mdetail-praise">
                <div class="mdetail-praise-icon">
                    <?php if ($project['user']['favor_status']):?>
                        <a href="javascript:void(0);" class="icon-18 icon-18-praise" name="project_<?= $project['proj_id']?>" value="<?= $project['proj_id']?>" onclick="remove_favor_project(this)"></a>
                    <?php else:?>
                        <a href="javascript:void(0);" class="icon-18 icon-18-praise" name="project_<?= $project['proj_id']?>" value="<?= $project['proj_id']?>" onclick="favor_project(this)"></a>
                    <?php endif ?>
<!--                    <a href="javascript:void(0);" class="icon-18 icon-18-praise"></a>-->
                </div>
                <div class="mdetail-praise-number">
                    <span id="focus_c"><?= $project['fans_num'] ?></span>
                </div>
            </div>
        </div>
        <!--/顶部制作单位简介-->

        <!--项目简介-->
        <div class="mobile-box mdetail mdetail-intro">
            <p class="mdetail-intro-title">《<?= $cz_project['proj_name'] ?>》项目简介</p>
            <div class="mdetail-edit">
                <!--具体内容用富文本编辑-->
                <?=$extend['proj_desc']?>
            </div>
        </div>
        <!--/项目简介-->

        <hr class="mdetail-cut mobile-box">

        <!--项目演示-->
        <?php
        $img_str = $project['img_str'];
        $img_arr = json_decode($img_str);
        ?>
        <div class="mobile-box mdetail mdetail-display">
            <p class="mdetail-intro-title">《<?= $cz_project['proj_name'] ?>》项目演示</p>
            <ul class="mdetail-display-list">
                <?php if(!empty($img_arr)):foreach($img_arr as $v):?>
                    <li>
                        <a href="javascript:void(0);">
                            <img src="<?= $v ?>" alt="<?= $cz_project['proj_name'] ?>" >
                        </a>
                    </li>
                <?php endforeach;?>
                <?php endif;?>
            </ul>
        </div>
        <!--/项目演示-->

        <!--微信分享到朋友圈-->
        <div class="mobile-box mdetail mdetail-wechat">
            <a href="javascript:void(0);" class="mdetail-wechat-share">
                <i class="icon-18 icon-18-weshare"></i>
                <span>分享到朋友圈</span>
            </a>
        </div>
        <!--/微信分享到朋友圈-->
        <!--微信分享到朋友圈提示蒙版-->
        <div class="mdetail-modal">
            <img src="/images/mobile/mdetail-weshare-hint.png">
        </div>
        <div class="mobile-box mdetail h5-line-box">
            <div class="h5-line"></div>
        </div>
        <!--/微信分享到朋友圈提示蒙版-->

        <!--具体项目-->
        <?php if(isset($next_proj)):?>
            <div class="mobile-box mdetail mdetail-case">
                <div class="mdetail-case-titlebox">
                    <div class="mdetail-case-title">
                        <span><?= $next_proj['project']['proj_name'] ?></span>
                    </div>
                </div>
                <div  class="mdetail-case-imagebox">
                    <a href="/project/<?= $next_proj['proj_id'] ?>">
                        <img src="<?=$next_proj['proj_pic']?>" alt="<?= $next_proj['project']['proj_name'] ?>">
                    </a>
                </div>
            </div>
        <?php endif; ?>
        <?php if(isset($next_proj2)):?>
            <div class="mobile-box mdetail mdetail-case">
                <div class="mdetail-case-titlebox">
                    <div class="mdetail-case-title">
                        <span><?= $next_proj2['project']['proj_name'] ?></span>
                    </div>
                </div>
                <div  class="mdetail-case-imagebox">
                    <a href="/project/<?= $next_proj2['proj_id'] ?>">
                        <img src="<?=$next_proj2['proj_pic']?>" alt="<?= $next_proj2['project']['proj_name'] ?>">
                    </a>
                </div>
            </div>
        <?php endif; ?>
        <!--/具体项目-->

        <!--热门项目-->
        <div class="mobile-box mdetail mdetail-hotcase clearfix">
            <div class="mdetail-case-titlebox">
                <div class="mdetail-case-title">
                    <span>热门项目</span>
                </div>
            </div>
            <ul class="mdetail-hotcase-list clearfix">
                <?php for($i=0;$i<4;$i++):?>
                   <li>
                       <?php
                       $t = $top[$i];
                       ?>
                        <a href="/project/<?= $t['proj_id'] ?>">
                            <img src="<?=$t['img']?>" alt="<?= $t ['title']?>">
                        </a>
                    </li>
                <?php endfor;?>
            </ul>
        </div>
        <!--/热门项目-->

        <!--版本切换-->
        <div class="mobile-box mdetail mdetail-version clearfix">
            <div class="mdetail-version-web">
                <a href="/project/<?= $cz_project['proj_id'] ?>">查看网页版</a>
            </div>
            <div class="mdetail-version-mobile current">
                <a href="#top">查看手机版</a>
            </div>
        </div>
        <!--/版本切换-->

        <!--底部-->
        <div class="mobile-box mdetail mdetail-foot">
            <a href="http://maker.vsochina.com/">
                <img src="/images/mobile/mdetail-footlogo.png?v=1">
            </a>
        </div>
        <form action="<?=yii::$app->urlManager->createUrl(['/activity/lucky/mlucky'])?>" method="post" id="spring_festivel_activity_switch_form">
            <input type="hidden" value="<?=SpringUtil::isSpringActivityAvaliable()?'true':'false'?>" id="spring_festivel_activity_switch">
            <input type="hidden" value="" id="qr_url" name="qr_url">
            <input type="hidden" value="<?=$cz_project['proj_name'] ?>" id="proj_name" name="proj_name">
        </form>
        <!--/底部-->
        <script type="text/javascript">
            $(function(){
                if(is_weixin())
                {
                    $(".mdetail-wechat").show();
                }
                else
                {
                    $(".h5-line-box").show();
                }

                $(".mdetail-wechat-share").on('click', function(event) {
                    stopPropagation(event);
                    $(".mdetail-modal").show();
                });

                $(".mdetail-modal").on('click', function(event) {
                    $(".mdetail-modal").hide();
                });
            });

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

            function remove_favor_project(_this) {
                var username = '<?=$username;?>';
                var name = $(_this).attr('name');
                var proj_id = $(_this).attr('value');
                if (username == '') {
                    loginLink();
                    return false;
                }
                if (proj_id == '') {
                    alert("缺少项目编号");
                    return false;
                }
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    async: false,
                    url: "/project/favor/remove-favor?id=" + proj_id,
                    success: function (json) {
                        alert(json.msg);
                        if (json.result) {
                            var widget_name = "#focus_c";
                            $(widget_name).html(json.fans_num);
                            var onclick = 'favor_project(this)';
                            $(_this).attr('onclick', onclick);
                        }
                    }
                });
            }

            function loginLink(){
                window.location.href = "http://account.vsochina.com/user/login";
            }
            // 关注项目
            function favor_project(_this) {
                var username = '<?=$username;?>';
                var name = $(_this).attr('name');
                var proj_id = $(_this).attr('value');
                if (username == '') {
                    loginLink();
                    return false;
                }
                if (proj_id == '') {
                    alert("缺少项目编号");
                    return false;
                }
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    async: false,
                    url: "/project/favor/favor?id=" + proj_id,
                    success: function (json) {
                        if (json.result) {
                            var widget_name = "#focus_c";
                            $(widget_name).html(json.fans_num);
                            var onclick = 'remove_favor_project(this)';
                            $(_this).attr('onclick','');
                            if($("#spring_festivel_activity_switch").val() == 'true'){
                                if(json.ticket != null)
                                {
                                    $("#qr_url").val(json.ticket);
                                    $("#spring_festivel_activity_switch_form").submit();
                                }
                            }
                        }
                    }
                });
            }
        </script>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?d426d199179c8a78bc6f6c2d577d9f91";
  var s = document.getElementsByTagName("script")[0];
  s.parentNode.insertBefore(hm, s);
})();
</script>
    </body>
</html>
