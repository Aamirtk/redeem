<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?=$_studio['studio_name']?> | 创意空间</title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="renderer" content="webkit"/>
    <meta name="baidu-site-verification" content="NpzvG27pvo" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.3.5/css/bootstrap.min.css?v1.4">
    <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/libs/webuploader/0.1.5/webuploader.css">
    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css?v1.4" />
    <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/font/userWork/font.css?v1.4" />
    <link rel="stylesheet" type="text/css" href="http://maker.vsochina.com/css/studio.css">
    <script type="text/javascript" charset="utf-8" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/webuploader/0.1.5/webuploader.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/jquery.lazyload/1.9.5/jquery.lazyload.js"></script>
    <script type="text/javascript" src="http://maker.vsochina.com/js/dreamSpace.js"></script>
</head>
<body>
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_header.php')?>
<?php
    use frontend\modules\talent\models\User;
    $username = User::getLoginedUsername();
?>
<!-- top -->
<div class="studio-top">
    <div class="studio-top-banner">
        <div class="studio-banner-img-mask"></div>
        <div class="studio-banner-img">
            <?php if(!empty($banner_img)):?>
                <img src="<?=$banner_img?>"  alt="<?= $_studio['studio_name']?>" style="left: <?=$dx?>px;top: <?=$dy?>px;" id="studio_banner">
            <?php else:?>
                <img src="/images/studio/demo1.jpg" alt="<?= $_studio['studio_name']?>" style="left: 0px;right: 0;" id="studio_banner">
            <?php endif;?>
        </div>

        <?php if($_studio['studio_owner'] == $username):?>
        <div class="studio-banner-edit">
            <div class="banner-edit-bg"></div>
            <a class="icon-26 icon-camera"></a>
        </div>
        <ul class="banner-edit-popout studio-hide">
            <li><a id="banner_localup">从本地上传图片</a></li>
<!--            <li><a>从云盘上传图片</a></li>-->
            <li><a class="studio-editpos">修改当前图片位置</a></li>
            <li><a id="banner_delete">移除当前图片</a></li>
        </ul>
        <div class="studio-banner-intro">
            <div class="banner-intro-bg"></div>
            拖拽确定选区
        </div>
        <div class="studio-banner-btn">
            <a class="studio-btn-green" id="drag_banner_save">保存</a>
            <a class="studio-btn-green" id="drag_banner_cancel">取消</a>
        </div>
        <? endif;?>
    </div>
    <ul class="studio-navlist studio-o50 clearfix">
        <li>
            <a href="http://maker.vsochina.com">
                <i class="icon-16 icon-home"></i>
                创意空间
            </a>
        </li>
        <li><i class="icon-gt">&gt;</i><a href="http://maker.vsochina.com/studiolist">工作室</a></li>
        <li><i class="icon-gt">&gt;</i><a href="javascript:void(0);"><?= $_studio['studio_name']?></a></li>
    </ul>
    <dl class="studio-info clearfix">
        <dt>
            <div class="studio-info-portrait">
                <div class="studio-portrait-img">
                    <img src="<?= $_studio['studio_icon']?>" alt="<?= $_studio['studio_name']?>" onerror="$(this).attr('src', '<?= yii::$app->params['cz_domain'] . '/themes/creation/images/header-none.png'?>')" id="icon_img">
                </div>
                <?php if($_studio['studio_owner'] == $username):?>
                <a class="studio-portrait-edit" id="icon_localup" href="http://cz.vsochina.com/project/project?tab=setting">
                        <div class="portrait-edit-bg"></div>
                    <i class="icon-26 icon-camera"></i>
                </a>
                <?php endif;?>
            </div>
            <ul class="studio-info-log clearfix">
                <li class="studio-firstitem">
                    <p class="studio-log-num"><?= $_studio['v_num']?></p>
                    <p class="studio-log-name">浏览</p>
                </li>
                <li>
                    <p class="studio-log-num studio-fans-num"><?= $_studio['f_num']?></p>
                    <p class="studio-log-name">粉丝</p>
                </li>
            </ul>
        </dt>
        <dd class="studio-info-name">
            <?php if($_studio['studio_owner'] == $username):?>
                <a href="http://cz.vsochina.com/project/project?tab=setting">
                    <h1><?= $_studio['studio_name']?></h1>
                </a>
                <a href="http://cz.vsochina.com/project/project?tab=setting">
                    <i class="icon-20 icon-setting"></i>
                </a>
            <?else:?>
                <a href="javascript:void(0);">
                    <h1><?= $_studio['studio_name']?></h1>
                </a>
            <?endif;?>
        </dd>
        <dd class="studio-info-tag">
            <?php foreach ($_studio['categories'] as $index => $ind): ?>
                <span><?= $ind['name']?></span>
                <?php if(count($_studio['categories']) != $index + 1): ?>
                    <span class="studio-cut">|</span>
                <?php endif;?>
            <?php endforeach; ?>
<!--            <span>二维动画</span>-->
<!--            <span class="studio-cut">|</span>-->
<!--            <span>动画</span>-->
<!--            <span class="studio-cut">|</span>-->
<!--            <span>编辑制作</span>-->
        </dd>
        <dd class="studio-info-msg">
            <?php if ($_studio['intro']):?>
                “<?= $_studio['intro']?>”
            <?php endif;?>
        </dd>
        <dd class="studio-info-btn">
<!--

登录校验
    y
        是否为所有者
            y
                发布动态    ->发布动态
            n
                nothing
        是否是成员
            y
                进入工作室  -> cz
            n
                申请加入    -> 发消息->cz
        是否关注
            y
                取消关注    -> 取消关注
            n
                关注        ->关注
    n
        申请加入            ->登录弹窗
        关注                ->登录弹窗




-->
            <?php if($username):?>

                <?php if($_studio['studio_owner'] == $username):?>
                    <a class="studio-btn-orange" href="<?=yii::$app->params['frontendurl']?>/studio/index/upload?s_id=<?=$_studio['s_id']?>">发布新动态</a>
                <?php endif;?>

                <?php if($_studio['is_m']):?>
                    <a class="studio-btn-green" href="https://cz.vsochina.com">进入工作室</a>
                <?else:?>
                    <a class="studio-btn-green"  data-toggle="modal" data-target="#studio_modal">申请加入</a>
                <?php endif;?>

                <?php if($_studio['studio_owner'] != $username):?>
                            <?php if($_studio['is_f']):?>
                                <a class="studio-btn-green unfocus-btn"  onclick="unfocusStudio('<?=$_studio['s_id']?>', '<?=$username?>')" href="javascript:void(0);">取消关注</a>
                                <a class="studio-btn-green focus-btn" style="display: none;" onclick="focusStudio('<?=$_studio['s_id']?>', '<?=$username?>')" href="javascript:void(0);">关注</a>
                            <?else:?>
                                <a class="studio-btn-green unfocus-btn" style="display: none;" onclick="unfocusStudio('<?=$_studio['s_id']?>', '<?=$username?>')" href="javascript:void(0);">取消关注</a>
                                <a class="studio-btn-green focus-btn"  onclick="focusStudio('<?=$_studio['s_id']?>', '<?=$username?>')" href="javascript:void(0);">关注</a>
                            <?php endif;?>
                <?php endif;?>
            <?else:?>
                <a class="studio-btn-green focus-btn" onclick="openLoginpop()" href="javascript:void(0);">关注</a>
                <a class="studio-btn-green focus-btn" onclick="openLoginpop()" href="javascript:void(0);">申请加入</a>
            <?php endif;?>
        </dd>
    </dl>
</div>
<input type="hidden" value="<?=($_studio['studio_owner'] == $username)?'true':'false'?>" id="hidden_is_owner">
<!--/ top -->


<!-- middle -->
<div class="studio-middle-content">
    <div class="ds-1200 clearfix">
        <div class="studio-content-left pull-left">
            <div class="studio-content-top">
                <h2 class="studio-content-title studio-content-title-left">公开项目 <span class="color-green">· <?= $_project['_count']?></span></h2>
                <div class="studio-content-boxall">
                    <?php if($_project['_items']):?>
                    <?php foreach ($_project['_items'] as $p) :?>
                    <dl class="studio-content-top-box clearfix">
                        <dt class="w207-118"><img src="<?= $p['proj_icon']?>" alt="<?= $p['proj_name']?>">
<!--                            <a href="#" class="entry-project">进入项目</a>-->
                        </dt>
                        <dd class="studio-content-top-title font16">《<?= $p['proj_name']?>》项目简介</dd>
                        <dd class="studio-content-font12">项目入驻时间：<?= date('Y-m-d', $p['proj_created'])?></dd>
                        <dd class="studio-content-font14">
                            <?= $p['proj_desc']?>
                        </dd>
                    </dl>
                    <?php endforeach;?>
                    <?php else:?>
                    <div class="zanwu">
                        <?php if($_studio['studio_owner'] == $username):?>
                            <span class="color-lightblue">╮(╯▽╰)╭ </span>  您还没有公开项目，请您  <a class="color-lightblue">创建公开项目！</a>
                        <?php else:?>
                            <span class="color-lightblue">╮(╯▽╰)╭ </span>  该工作室没有公开项目！
                        <?php endif;?>
                    </div>
                    <?php endif;?>
                </div>
            </div>
            <div class="studio-content-bottom">
                <h2 class="studio-content-title studio-content-title-left">工作室动态 <span class="color-green">· <span class="trends-count"></span></span></h2>
                <div class="studio-content-boxall trends-list">
                    <dl class="studio-content-bottom-box clearfix" id="last_trends">
                        <dd class="font16">
                            <div>
                                <span></span>
                                "<?=$_studio['studio_name']?>"入驻创意空间
                            </div>
                        </dd>
                        <dd class="font12 color-gray"><?=date("Y.m.d",$_create_time);?></dd>
                        <dd class="font12"></dd>
                        <dd class="studio-content-icon">
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="content-bottom-more load-more-trends" style="display: none;"><a href="javascript:void(0);" onclick="loadMoreTrends()">更多...</a></div>
        </div>
        <div class="studio-content-right pull-right">
            <h2 class="studio-content-title">成员 <span class="color-green">· <span class="member-count"></span></span></h2>
            <div class="member overflowH">
                <div class="member-top clearfix">
                    <div class="member-list">
<!--                        <a href="" rel="nofollow"><img src="/images/studio/picture_03.png"></a>-->
                    </div>
                    <a href="javascript:;" onclick="loadMoreMember()" rel="nofollow" class="more">更多</a>
                </div>
                <div class="member-bottom overflowH">

                    <?php foreach($_public_projects as $pp):?>
                        <div class="project1 overflowH">
                            <div class="line1 overflowH">
                                <span></span>
                                <div class="txt">启动《<?=$pp['proj_name']?>》项目</div>
                            </div>
                            <div class="date"><?=date("Y.m.d",$pp['proj_created'])?></div>
                        </div>
                    <?php endforeach;?>

                    <div class="project2 overflowH">
                        <div class="line2 overflowH">
                            <span></span>
                            <div class="txt">"<?=$_studio['studio_name']?>"入驻创意空间</div>
                        </div>
                        <div class="date"><?=date("Y.m.d",$_create_time);?></div>
                    </div>

<!--                    <div class="project3 overflowH">-->
<!--                        <div class="line3 overflowH">-->
<!--                            <span></span>-->
<!--                            <div class="txt">滑板少年工作室成立</div>-->
<!--                        </div>-->
<!--                        <div class="date">2014.07.07</div>-->
<!--                    </div>-->

                </div>
            </div>
        </div>
    </div>
</div>
<!--/ middle -->

<!-- studio modal box -->
<div class="studio-modal" id="studio_modal">
    <div class="studio-modal-backdrop"></div>
    <div class="studio-modal-content">
        <a class="studio-modal-close"></a>
        <!-- left -->
        <div class="studio-modal-form">
            <div class="studio-modal-title">申请加入工作室</div>
            <form action="" method="post">
                <div class="form-group studio-form-group clearfix">
                    <label>工作室名称：</label>
                    <span class="studio-name"><?=$_studio['studio_name']?></span>
                </div>
                <div class="form-group clearfix">
                    <label for="">加入的原因：</label>
                    <textarea name="" id="studio-join-reason" class="form-control" placeholder="在此输入您加入该工作室的原因，请尽情发挥，畅所欲言；该工作室会受到您的请求，并根据内容决定您的加入请求。"></textarea>
                </div>
                <div class="form-group clearfix">
                    <label for="">您的Email：</label>
                    <input type="text" class="form-control" id="studio-join-email" placeholder="这非常重要，我们将通过邮件通知您关于申请的最新状态">
                </div>
                <div class="btn-box">
                    <button type="button" class="btn" id="studio-join-btn">提交申请</button>
                </div>
            </form>
        </div>
        <!--/ left -->
        <!-- right -->
        <div class="studio-modal-user">
            <div class="studio-user-title">他们也在使用创意空间：</div>
            <div class="studio-user-switch">
                <ul class="bd">
                    <li>
                        <div class="studio-oneuser">
                            <div class="studio-remarks">
                                非常新颖的协作工具，很不错，也很适合学生使用，希望以后变得越来越好。
                                <i class="studio-triangle"></i>
                            </div>
                            <table class="clearfix">
                                <tr>
                                    <td class="studio-portrait">
                                        <a href="http://www.vsochina.com/talent_detail/member_id/1187809.html">
                                            <img src="http://www.vsochina.com/data/avatar/001/18/78/09_avatar_small.jpg" alt="路盛章">
                                        </a>
                                    </td>
                                    <td>
                                        <dd>路盛章</dd>
                                        <dd class="studio-desc">奥运福娃宣传片总导演、中国传媒大学教授</dd>
                                    <td>
                                </tr>
                            </table>
                        </div>


                        <div class="studio-oneuser">
                            <div class="studio-remarks">
                                使用起来非常有趣，我也很乐意能够通过这样的协作方式进行创作。
                                <i class="studio-triangle"></i>
                            </div>
                            <table class="clearfix">
                                <tr>
                                    <td class="studio-portrait">
                                        <a href="http://www.vsochina.com/talent_detail/member_id/1985183.html">
                                            <img src="http://www.vsochina.com/data/avatar/001/98/51/83_avatar_small.jpg" alt="Tamas Waliczky">
                                        </a>
                                    </td>
                                    <td>
                                        <dd>Tamas Waliczky</dd>
                                        <dd class="studio-desc">新媒体艺术家，香港城市大学创意媒体系教授</dd>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </li>


                    <li>
                        <div class="studio-oneuser">
                            <div class="studio-remarks">
                                创作的魅力在于无限的可能，而创意云做到了这点。
                                <i class="studio-triangle"></i>
                            </div>
                            <table class="clearfix">
                                <tr>
                                    <td class="studio-portrait">
                                        <a href="http://www.vsochina.com/talent_detail/member_id/1023281.html">
                                            <img src="http://www.vsochina.com/data/avatar/001/02/32/81_avatar_small.jpg" alt="郭冶">
                                        </a>
                                    </td>
                                    <td>
                                        <dd>郭冶</dd>
                                        <dd class="studio-desc">著名肖像漫画家，杭州师范大学教授</dd>
                                    <td>
                                </tr>
                            </table>
                        </div>


                        <div class="studio-oneuser">
                            <div class="studio-remarks">
                                作为一个平台，用互联网的方式突破了传统的团队合作创模式的局限性，更加高效，更加便捷。
                                <i class="studio-triangle"></i>
                            </div>
                            <table class="clearfix">
                                <tr>
                                    <td class="studio-portrait">
                                        <a href="http://www.vsochina.com/talent_detail/member_id/885907.html">
                                            <img src="http://www.vsochina.com/data/avatar/000/88/59/07_avatar_small.jpg" alt="刘左锋">
                                        </a>
                                    </td>
                                    <td>
                                        <dd>刘左锋</dd>
                                        <dd class="studio-desc">海尔兄弟导演</dd>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </li>


                    <li>
                        <div class="studio-oneuser">
                            <div class="studio-remarks">
                                非常认同创意云的理念，今后在建筑方面的合作也会越来越多。
                                <i class="studio-triangle"></i>
                            </div>
                            <table class="clearfix">
                                <tr>
                                    <td class="studio-portrait">
                                        <a href="http://www.vsochina.com/talent_detail/member_id/1052709.html">
                                            <img src="http://www.vsochina.com/data/avatar/001/05/27/09_avatar_small.jpg" alt="汪孝安">
                                        </a>
                                    </td>
                                    <td>
                                        <dd>汪孝安</dd>
                                        <dd class="studio-desc">华东建筑设计研究院副总建筑师</dd>
                                    <td>
                                </tr>
                            </table>
                        </div>
                    </li>

                </ul>
                <div class="hd"><ul></ul></div>
            </div>
        </div>
        <!--/ right -->
    </div>
</div>
<!-- /studio modal box -->
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_footer.php')?>

<script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>
<script type="text/javascript">
    $(function(){
        if($(".studio-user-switch .bd li").length > 1)
        {
            $(".studio-user-switch").slide({
                mainCell: ".bd",
                titCell: ".hd ul",
                vis: 1,
                autoPage: true,
                autoPlay: true,
                effect: "leftLoop"
            });
        }

        var uploader = WebUploader.create({
            auto: true,
            swf: 'http://static.vsochina.com/libs/webuploader/0.1.5/Uploader.swf',
            server: '/webuploader/fileuploader.php',
            pick: '#banner_localup',
            accept: {
                        title: 'Images',
                        extensions: 'gif,jpg,jpeg,bmp,png',
                        mimeTypes: 'image/*'
                    },
            resize: false
        });
        uploader.on( 'beforeFileQueued', function( file ) {
            uploader.reset();
        });
        // 缩略图预览
//        uploader.on( 'fileQueued', function( file ) {
////            _img = $(".studio-banner-img").empty();
//            uploader.makeThumb( file, function( error, src ) {
//                if ( error ) {
//                    alert('不能预览');
//                    return;
//                }
//                $("#studio_banner").attr("src",src);
////                _img.append('<img src="' + src + '">');
//            }, 1, 1);
//        });
        uploader.on('uploadSuccess', function (file, response) {
            $("#studio_banner").css("top","0px").css("left","0px")
            dx=0;
            dy=0;
            $("#studio_banner").attr("src",response.src);
            // 默认移动位置
            $(".studio-editpos").click();
            $.ajax({
                type:"POST",
                dataType:"json",
                url:"<?=yii::$app->urlManager->createUrl(['/studio/index/edit-banner']);?>",
                data:{"s_id":<?=$_studio['s_id']?>,"src":response.src},
                success:function(json){
                    if(json.editResult)
                    {
                        $("#studio_banner" ).show();
                    }
                }
            });
        });
//        var iconUploder = WebUploader.create({
//            auto: true,
//            swf: 'http://static.vsochina.com/libs/webuploader/0.1.5/Uploader.swf',
//            server: '/webuploader/fileuploader.php',
//            pick: '#icon_localup',
//            accept: {
//                title: 'Images',
//                extensions: 'gif,jpg,jpeg,bmp,png',
//                mimeTypes: 'image/*'
//            },
//            resize: false
//        });
//
//        iconUploder.on( 'beforeFileQueued', function( file ) {
//            uploader.reset();
//        });
//        // 缩略图预览
//        iconUploder.on( 'fileQueued', function( file ) {
////            _img = $(".studio-banner-img").empty();
//            iconUploder.makeThumb( file, function( error, src ) {
//                if ( error ) {
//                    alert('不能预览');
//                    return;
//                }
//                $("#icon_img").attr("src",src);
////                _img.append('<img src="' + src + '">');
//            }, 1, 1);
//        });
//        iconUploder.on('uploadSuccess', function (file, response) {
//            $("#icon_img").attr("src",response.src);
//            $.ajax({
//                type:"POST",
//                dataType:"json",
//                url:"<?//=yii::$app->urlManager->createUrl(['/studio/index/edit-icon']);?>//",
//                data:{"s_id":<?//=$_studio['s_id']?>//,"icon":response.src},
//                success:function(json){
//                    if(json.editResult)
//                    {
//                    }
//                }
//            });
//        });


        // 上传成功后预览
        // uploader.on('uploadSuccess', function(file, response) {
        //     _img = $(".studio-banner-img").empty();
        //     _img.append('<img src="' + response.src + '">');
        // });


        $("#banner_delete").on('click', function(event) {
            $("#studio_banner" ).hide();
        });

        $("#studio-join-btn").on('click', function(){
            var reason = $("#studio-join-reason").val();
            var email = $("#studio-join-email").val();

            if(reason == ""){
                alert("请输入原因");
                return;
            }
            if(email == ""){
                alert("请输入邮箱");
                return;
            }
            if(!emailCheck(email)){
                alert("邮箱格式错误");
                return;
            }
            var s_id = "<?= $_studio['s_id']?>";

            $("#studio-join-reason").val("");
            $("#studio-join-email").val("");
            $("#studio_modal").modal("hide");
            $.ajax({
                url: '/studio/index/join-studio',
                type: 'post',
                dataType: 'json',
                data: {
                    s_id: s_id,
                    reason: reason,
                    email: email
                },
                success: function (json) {

                }
            });

        });
        $(document).on('click', '.studio-modal-backdrop, .studio-modal-close', function(event) {
            $("#studio_modal").modal("hide");
        });

        $(".studio-banner-edit").on('click', function(event) {
            stopPropagation(event);
            $(".banner-edit-popout").removeClass('studio-hide');
        });

        $(document).on('click', function(event) {
            $(".banner-edit-popout").addClass('studio-hide');
        });

        $(".trends-list").on('click','.dynamic-edit-btn', function(event) {
            stopPropagation(event);
            $(".dynamic-edit-popout").hide();
            $(this).next(".dynamic-edit-popout").show();
        });

        $(document).on('click', function(event) {
            $(".dynamic-edit-popout").hide();
        });

        $(".studio-editpos").on('click', function(event) {
            var _this = $(this),
                _banner = _this.closest('.studio-top-banner');
            _banner.children('.studio-banner-edit').hide().siblings(".studio-banner-intro, .studio-banner-btn").show();
            _banner.siblings().hide();
        });
        //拖拽banner图片后取消
        $("#drag_banner_cancel").on('click', function(event) {
            var _this = $(this),
                _banner = _this.closest('.studio-top-banner');
            _banner.children('.studio-banner-edit').show().siblings(".studio-banner-intro, .studio-banner-btn").hide();
            _banner.siblings().show();
            //返回原始位置： 假设 0  0
            $(".studio-banner-img img").css({"left":<?=$dx?>,"top":<?=$dy?>});

        });
        //拖拽banner图片后保存
        $("#drag_banner_save").on('click', function(event) {
            dragpic = false;
            var _this = $(this),
                _banner = _this.closest('.studio-top-banner');
            _banner.children('.studio-banner-edit').show().siblings(".studio-banner-intro, .studio-banner-btn").hide();
            _banner.siblings().show();
            //保存当前banner图片拖拽的位置,并加以记录
            $.ajax({
                type:"POST",
                dataType:"json",
                data:{"dx":dx,"dy":dy,"s_id":"<?=$_studio['s_id']?>","path":"/images/studio/demo1.jpg"},
                url:"<?=yii::$app->urlManager->createUrl(['/studio/index/drag-banner'])?>",
                success:function(json)
                {
                }
            });
        });

        ;(function($){
            var Placeholder,
                inputHolder = 'placeholder' in document.createElement('input'),
                textareaHolder = 'placeholder' in document.createElement('textarea');
                Placeholder = {
                    ini:function () {
                        if (inputHolder && textareaHolder) {
                            return false;
                        }
                        this.el = $(':text[placeholder],:password[placeholder],textarea[placeholder]');
                        this.setHolders();
                    },
                    setHolders: function(obj){
                        var el = obj ? $(obj) : this.el;
                        if (el) {
                            var self = this;
                            el.each(function() {
                                var span = $('<label />');
                                span.text( $(this).attr('placeholder') );
                                span.css({
                                    color: '#ccc',
                                    fontSize: $(this).css('fontSize'),
                                    fontFamily: $(this).css('fontFamily'),
                                    fontWeight: $(this).css('fontWeight'),
                                    position: 'absolute',
                                    top: "43px",
                                    left: "10px",
                                    width: $(this).width(),
                                    height: $(this).outerHeight(),
                                    lineHeight: $(this).css('line-height'),
                                    textIndent: $(this).css('textIndent'),
                                    paddingLeft: $(this).css('borderLeftWidth'),
                                    paddingTop: $(this).css('borderTopWidth'),
                                    paddingRight: $(this).css('borderRightWidth'),
                                    paddingBottom: $(this).css('borderBottomWidth'),
                                    display: 'inline',
                                    overflow: 'hidden',
                                    textAlign:'left'
                                })
                                if (!$(this).attr('id')) {
                                    $(this).attr('id', self.guid());
                                }
                                span.attr('for', $(this).attr('id'));
                                $(this).after(span);
                                self.setListen(this, span);
                                //span.each(function(){
                                    var label = $(span);
                                    $(span).on("click", function(){
                                        label.prev("input[type='text']").focus();
                                //    });
                                });
                                /*
                                span.on("click",function(){
                                    _this.parent().first().focus();
                                });
                                */

                            })
                        }
                    },
                    setListen : function(el, holder) {
                        if (!inputHolder || !textareaHolder) {
                            el = $(el);
                            el.bind('keydown', function(e){
                                    if (el.val() != '') {
                                        holder.hide(0);
                                    } else if ( /[a-zA-Z0-9`~!@#\$%\^&\*\(\)_+-=\[\]\{\};:'"\|\\,.\/\?<>]/.test(String.fromCharCode(e.keyCode)) ) {
                                        holder.hide(0);
                                    } else {
                                        holder.show(0);
                                    }
                            });
                            el.bind('keyup', function(e){
                                    if (el.val() != '') {
                                        holder.hide(0);
                                    } else {
                                        holder.show(0);
                                    }

                            })
                        }
                    },
                    guid: function() {
                        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                            var r = Math.random()*16| 0,
                                v = c == 'x' ? r : (r&0x3|0x8);
                            return v.toString(16);
                        }).toUpperCase();
                    }
                }

            $.fn.placeholder = function () {
                if (inputHolder && textareaHolder) {
                    return this;
                }
                Placeholder.setListen(this);
                return this;
            }

            $.placeholder = Placeholder;

        })(jQuery);
        jQuery(function($){$.placeholder.ini();});

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
    });
    var dx = 0;
    var dy = 0;
    var dragpic= false;
    dragBanner($(".studio-banner-img-mask"),$(".studio-banner-img img"));
    function dragBanner(dragObj,imgObj){
        var dragpicx= 0,//记录拖动的实际距离  x
            dragpicy= 0,//记录拖动的实际距离  y
            dragleft =  imgObj.position().left, //记录拖动过程中的图片位置  x
            dragtop =  imgObj.position().top,  //记录拖动过程中的图片位置 y
            dqsb = 0,
            dqsby =0 ;

        dragObj.bind({
            mousedown: function(e){
                //e=event?event:window.event;
                dragpicx=e.pageX || (e.clientX);
                dragpicy=e.pageY || (e.clientY);
                dragleft = imgObj.position().left;
                dragtop = imgObj.position().top;
                if (e.stopPropagation){
                    // this code is for Mozilla and Opera
                    e.stopPropagation();
                    e.preventDefault();
                };
                dragpic=true;
            },
            mouseup: function(){
                dragpic=false;
            },mousemove: function(e){
                if(dragpic){
                    //e=event?event:window.event;
                    dqsb=e.pageX || (e.clientX );
                    dqsby=e.pageY || (e.clientY );
                    imgObj.css({"left":dragleft+(dqsb-dragpicx)+"px","top":dragtop+(dqsby-dragpicy)+"px"});
                }
                dx = dragleft+(dqsb-dragpicx);
                dy = dragtop+(dqsby-dragpicy)
            },mouseout: function(){
                //dragpic=false;
            }
        });
    }

    // 加载成员
    function loadMember(id, page, limit) {
        $.ajax({
            url : '/studio/index/member-list',
            type : 'get',
            dataType : 'json',
            data : {
                s_id : id,
                page : page,
                limit : limit
            },
            success : function(json) {
                if (json.result) {
                    var data = json.data;
                    $(".member-count").html(data._count);
                    $(".member-list").html("");
                    $.each(data._items, function() {
                        $(".member-list").append(
                            '<a target="_blank" class="member-info" rel="nofollow" alt="' + this.nickname + '" href="http://www.vsochina.com/talent_detail/isname/1/member_id/'+this.member_username+'.html">\
                                <img width="72" height="72" src="' + this.icon + '">\
                        </a>');
                    })
                    //全部加载时移除更多按钮
                    if (data._count == $(".member-list .member-info").length) {
                        $(".member-top .more").remove();
                    }
                }
            }
        })
    }
    var cMemberPage = 1;
    loadMember('<?= yii::$app->request->get('s_id')?>', cMemberPage, 6);
    function loadMoreMember() {
        cMemberPage += 1;
        loadMember('<?= yii::$app->request->get('s_id')?>', 1, 10000);
    }

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

    // 加载成员
    function loadTrends(id, page, limit) {
        $.ajax({
            url : '/studio/trends/list',
            type : 'get',
            dataType : 'json',
            data : {
                s_id : id,
                page : page,
                limit : limit
            },
            success : function(json) {
                if (json.result) {
                    var data = json.data;
                    $(".trends-count").html(parseInt(data._count)+1);
//                    if(data._items.length==0){
//                        $(".trends-list").append('<div class="zanwu">暂无工作室动态...</div>');
//                        return false;
//                    }
                    var lastT = $("#last_trends");
                    lastT.remove();
                    if(data._items.length == 0)
                    {
                        $(".load-more-trends").hide();
                        $(".trends-list").append(lastT);
                        return;
                    }
                    $.each(data._items, function() {
                        //文字动态不显示图片
                        if(this.type != 3)
                        {
                            trendHtml = '<dl class="studio-content-bottom-box clearfix" id="trend_'+this.id+'">\
                                                    <dt class="w530-303"><a target="_blank" href="/studio/trends/detail?id=' + this.id + '" class="studio-content-blue" ><img width="530" height="303" src="' + this.banner + '" alt="' + this.name + '"></a></dt>\
                                            <dd class="font16 p-relative"><a target="_blank" href="/studio/trends/detail?id=' + this.id + '" class="studio-content-blue two-ellipsis" >' + (this.name ? this.name : '') + '</a>';
                                            if($("#hidden_is_owner").val() == 'true')
                                            {
                                                trendHtml += '<a class="dynamic-edit-btn p-absolute"></a>';
                                            }
                                            trendHtml += '<ul class="dynamic-edit-popout">\
                                                    <li><a href="javascript:deleteTrend(' + parseInt(this.id) + ');" rel="nofollow">删除动态</a></li>\
                                                </ul>\
                                            </dd>\
                                            <dd class="font12 color-gray">发布于 '+this.create_time+'</dd>\
                                            <dd class="font12" style="max-height:200px; overflow:hidden;">' + (this.content ? this.content : '')+ '</dd>\
                                            <dd><a target="_blank" href="/studio/trends/detail?id=' + this.id + '" class="studio-content-blue" >阅读更多</a></dd>\
                                        </dl>';
                            $(".trends-list").append(trendHtml);
                        }
                        else
                        {
                            trendHtml = '<dl class="studio-content-bottom-box clearfix" id="trend_'+this.id+'">\
                            <dd class="font16 p-relative"><a target="_blank" href="/studio/trends/detail?id=' + this.id + '" class="studio-content-blue text-ellipsis" >' + (this.name ? this.name : '') + '</a>';
                            if($("#hidden_is_owner").val() == 'true')
                            {
                                trendHtml += '<a class="dynamic-edit-btn p-absolute"></a>';
                            }
                            trendHtml +='<ul class="dynamic-edit-popout">\
                                    <li><a href="javascript:deleteTrend(' + parseInt(this.id) + ');" rel="nofollow">删除动态</a></li>\
                                </ul>\
                            </dd>\
                            <dd class="font12 color-gray">发布于 '+this.create_time+'</dd>\
                            <dd class="font12 two-ellipsis">' + (this.content ? this.content : '') + '</dd>\
                            <dd><a target="_blank" href="/studio/trends/detail?id=' + this.id + '" class="studio-content-blue" >阅读更多</a></dd>\
                        </dl>';
                            $(".trends-list").append(trendHtml);
                        }
                    });
                    $(".trends-list").append(lastT);
                    //全部加载时移除更多按钮
                    if (data._count == $(".trends-list .studio-content-bottom-box").length) {
                        $(".load-more-trends").hide();
                    }
                    else {
                        $(".load-more-trends").show();
                    }
                    //初次加载完成后,控制更多按钮显示
                    if(data._items.length < limit)
                    {
                        $(".load-more-trends").hide();
                    }
                    else {
                        $(".load-more-trends").show();
                    }
                }
            }
        })
    }
    // 当前动态页数
    var cTrendsPage = 1;
    loadTrends('<?= yii::$app->request->get('s_id')?>', cTrendsPage, 5);
    function loadMoreTrends() {
        cMemberPage += 1;
        loadTrends('<?= yii::$app->request->get('s_id')?>', cMemberPage, 5);
    }

    function deleteTrend(id){
        confirm("确定删除本条动态?",deleteFunction,id);
    }

    var deleteFunction = function(id){
        $.ajax({
            type:"post",
            dataType:"json",
            data:{"id":id},
            url:"<?=yii::$app->urlManager->createUrl(['/studio/trends/delete-trend'])?>",
            success:function(json){
                if(json.ret)
                {
                    $("#trend_"+id).remove();
                    //window.location.reload();
                }
            }
        });
    };


    function emailCheck(labelName) {
        var pattern = /[\w!#$%&'*+/=?^_`{|}~-]+(?:\.[\w!#$%&'*+/=?^_`{|}~-]+)*@(?:[\w](?:[\w-]*[\w])?\.)+[\w](?:[\w-]*[\w])?/;
        if (!pattern.test(labelName)) {
            return false;
        }
        return true;
    }
</script>
</body>
</html>