<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?=$_studio['studio_name']?> · 动态发布 | 创意空间</title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="renderer" content="webkit"/>
    <meta name="baidu-site-verification" content="NpzvG27pvo" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css?v1.4" />
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.3.5/css/bootstrap.min.css?v1.4">
    <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/libs/webuploader/0.1.5/webuploader.css">
    <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/font/userWork/font.css?v1.4" />
    <link rel="stylesheet" type="text/css" href="http://maker.vsochina.com/css/studio.css">
    <script type="text/javascript" charset="utf-8" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/jquery.lazyload/1.9.5/jquery.lazyload.js"></script>
    <script type="text/javascript" charset="utf-8" src="http://maker.vsochina.com/plugins/ueditor2/ueditor.config.js?v=1"></script>
    <script type="text/javascript" charset="utf-8" src="http://maker.vsochina.com/plugins/ueditor2/ueditor.all.js?v=1"></script>
    <script type="text/javascript" charset="utf-8" src="http://maker.vsochina.com/plugins/ueditor2/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/webuploader/0.1.5/webuploader.js"></script>
    <script type="text/javascript" src="/js/dreamSpace.js"></script>
</head>
<body>
<?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_header.php')?>
<?php
    use frontend\modules\talent\models\User;
    $username = User::getLoginedUsername();
?>
    <div class="studio-dynamic-wrap clearfix">
        <!-- right part -->
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
                        <dd class="trends-list-name <?=($oth['type']==1)?'iconfont-pic':($oth['type']==2?'iconfont-shipin':'iconfont-mulu')?>"><a href="<?='http://maker.vsochina.com/studio/trends/detail?id='.$oth['id']?>"><?=$oth['name']?></a></dd>
                        <dd class="trends-list-comment">评论 <?=$oth['f_num']?> | 点赞 <?=$oth['f_num']?> | <?=date('Y.m.d',$oth['create_time'])?></dd>
                    <?php endforeach;?>
                </dl>
                <a href="http://maker.vsochina.com/studio/index/detail?s_id=<?=$_studio['s_id']?>" class="trends-more">更多动态</a>
            </div>
        </div>
        <!-- right part -->

        <!-- upload -->
        <!--content-->
        <div class="rc-upload-wrap pull-left">
            <ul class="studio-dynamic-bread studio-navlist clearfix">
                <li>
                    <a href="http://maker.vsochina.com">
                        <i class="icon-dhome"></i>
                        创意空间
                    </a>
                </li>
                <li><i class="icon-gt">&gt;</i><a href="http://maker.vsochina.com/studiolist">工作室</a></li>
                <li><i class="icon-gt">&gt;</i><a href="http://maker.vsochina.com/studio/index/detail?s_id=<?=$_studio['s_id']?>"><?= $_studio['studio_name']?></a> </li>
                <li><i class="icon-gt">&gt;</i><a href="javascript:void(0);">发布新动态</a></li>
            </ul>
            <div class="rc-upload-box">
                <ul class="rc-upload-nav clearfix">
                    <li class="active">
                        <a>
                            <p class="upload-nav-icon"><i class="icon-26 icon-21-camera"></i></p>

                            <p class="upload-nav-text">图片</p>
                        </a>
                    </li>
                    <li>
                        <a>
                            <p class="upload-nav-icon"><i class="icon-26 icon-26-video"></i></p>

                            <p class="upload-nav-text">视频</p>
                        </a>
                    </li>
                    <li>
                        <a>
                            <p class="upload-nav-icon"><i class="icon-26 icon-18-pencil"></i></p>

                            <p class="upload-nav-text">文字</p>
                        </a>
                    </li>
                </ul>
                <div>
                    <!--pic -->
                    <div class="rc-upload-content active">
                        <span class="red-star">*</span>
                        <form action="<?=yii::$app->urlManager->createUrl(['/studio/trends/upload-image/']);?>" method="post" class="_work_form" id="form_image">
                            <!-- 上传图片（正常） -->
                            <div id="uploader_picture">
                                <div id="rc_pictureList" class="uploader-list clearfix"></div>
                                <div id="rc_picturePicker">
                                    <p class="rc-picturePicker-icon"><i class="icon-41 icon-41-camera"></i></p>

                                    <p class="rc-picturePicker-txt">拖拽/点击添加本地文件</p>
                                </div>
                            </div>

                            <!--/ 上传图片（正常） -->
                            <!--/ 上传图片（多图） -->
                            <div class="upload-content-msg">
                                <span class="red-star">*</span>
                                <div class="upload-content-title flag-placeholder">
                                    <input type="text" class="form-control" placeholder="标题" name="title"
                                           autocomplete="off" maxlength="45"/>
                                    <!-- <label>标题（可不填）</label> -->
                                </div>
                            </div>
<!--                            <div class="upload-content-msg">-->
<!--                                <div class="upload-content-category dropdown">-->
<!--                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"-->
<!--                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">-->
<!--                                        <span class="samplereels">选择分类</span>-->
<!--                                        <span class="caret"></span>-->
<!--                                    </button>-->
<!--                                    <ul class="dropdown-menu _work_group_list" aria-labelledby="dropdownMenu1">-->
<!--                                        <li>-->
<!--                                            <a>啦啦啦</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a>啊啊啊</a>-->
<!--                                        </li>-->
<!--                                        <li class="create-newworks">-->
<!--                                            <input type="text" class="form-control _add_work_group" autocomplete="off"-->
<!--                                                   name="_work_group_name"-->
<!--                                                   placeholder="创建新分类 回车添加">-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="upload-content-msg">
                                <script type="text/plain" id="editor_upload_picture" name="content"></script>
                            </div>
                            <div class="upload-content-msg">
                                <div class="upload-content-tagwrap clearfix">
                                    <div class="upload-content-tag flag-placeholder clearfix">
                                        <input class="_tags" type="text" maxlength="20" autocomplete="off"/>
                                        <label>添加相关标签，用逗号分隔</label>
                                        <span class="hiddenSpan"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="upload-content-setting clearfix">
                                <div class="upload-content-copyright dropup">
                                    <a class="copyright-btn _open_status_icon" href="javascript:void(0);" data-toggle="dropdown"
                                       role="button"
                                       aria-haspopup="true" aria-expanded="false">
                                        <i class="copyright-icon copyright-icon-0"></i>
                                        <span class="copyright-desc">版权设置</span>
                                    </a>
                                    <ul class="dropdown-menu _chose_open_status" aria-labelledby="dLabel">
                                        <li data="1">
                                            <a class="clearfix">
                                                <i class="copyright-icon copyright-icon-1"></i>

                                                <p class="copyright-desc">作品禁止看大图</p>
                                            </a>
                                        </li>
                                        <li data="2">
                                            <a class="clearfix">
                                                <i class="copyright-icon copyright-icon-2"></i>

                                                <p class="copyright-desc">作品禁止右键另存为</p>
                                            </a>
                                        </li>
                                        <li data="3">
                                            <a class="clearfix">
                                                <i class="copyright-icon copyright-icon-3"></i>

                                                <p class="copyright-desc">作品禁止商业使用</p>
                                            </a>
                                        </li>
                                        <li data="4">
                                            <a class="clearfix">
                                                <i class="copyright-icon copyright-icon-4"></i>

                                                <p class="copyright-desc">不限制作品用途</p>
                                            </a>
                                        </li>
                                        <li data="5">
                                            <a class="clearfix">
                                                <i class="copyright-icon copyright-icon-5"></i>

                                                <p class="copyright-desc">禁止右键另存和商业使用</p>
                                            </a>
                                        </li>
                                    </ul>
                                    <input type="hidden" value="" name="copyright" id="copyright_image">
                                </div>
                            </div>
                            <div class="upload-content-operate clearfix">
                                <input type="hidden" name="s_id" value="<?=$s_id?>" autocomplete="off"/>
                                <input type="hidden" name="picorvideo" value="1" autocomplete="off"/>
                                <a class="operate-cancel _go_work_list" href="<?=yii::$app->params['frontendurl'].'/studio/index/detail?s_id='.$s_id?>">返回</a>
                                <a class="operate-release _submit_work_form" href="javascript:submitUploadImage()">发布</a>
                            </div>
                        </form>
                        <script>
                            function submitUploadImage()
                            {
                                if (!$("#form_image input[name=title]").val()) {
                                    alert("请输入标题!");
                                }
                                else if (!$("#form_image input[name='images[]']").val()){
                                    alert("请上传图片!");
                                }
                                else {
                                    $("#form_image").submit();
                                }
                            }
                        </script>
                    </div>
                    <!--/pic -->

                    <!--video -->
                    <div class="rc-upload-content">
                        <form action="<?=yii::$app->urlManager->createUrl(['/studio/trends/upload-video']);?>" method="post" class="_work_form" id="form_video">
                            <div id="uploader_videocover" class="clearfix">
                                <span class="red-star">*</span>
                                <div id="rc_videoCoverPicker" class="up-before">
                                    <p class="rc-videoCoverPicker-icon"><i class="icon-36 icon-36-upload"></i></p>

                                    <p class="rc-videoCoverPicker-txt">上传封面</p>
                                </div>
                                <div class="videoCoverPicker-right first">10MB以内/RGB模式</div>
                                <div class="videoCoverPicker-right">支持尺寸：530*300</div>
                                <div class="videoCoverPicker-right">支持格式：jpg/png</div>
                            </div>
                            <div id="uploader_video">
                                <span class="red-star">*</span>
                                <div class="uploader-video-link active">
                                    <input type="text" class="form-control" name="link" autocomplete="off"/>
                                    <label><i class="icon-16 icon-16-link"></i></label>
                                </div>
                                <div id="rc_videoPicker" class="uploader-video-local">
                                    <i class="icon-16 icon-16-cloud"></i>
                                    点击添加本地文件
                                </div>
                            </div>
                            <div class="upload-content-msg">
                                <span class="red-star">*</span>
                                <div class="upload-content-title flag-placeholder">
                                    <input type="text" class="form-control" placeholder="标题" name="title"
                                           autocomplete="off" maxlength="45"/>
                                </div>
                            </div>
<!--                            <div class="upload-content-msg">-->
<!--                                <div class="upload-content-category dropdown">-->
<!--                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"-->
<!--                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">-->
<!--                                        <span class="samplereels">选择分类</span>-->
<!--                                        <span class="caret"></span>-->
<!--                                    </button>-->
<!--                                    <ul class="dropdown-menu _work_group_list" aria-labelledby="dropdownMenu1">-->
<!--                                        <li>-->
<!--                                            <a>啦啦啦</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a>啊啊啊</a>-->
<!--                                        </li>-->
<!--                                        <li class="create-newworks">-->
<!--                                            <input type="text" class="form-control _add_work_group" autocomplete="off"-->
<!--                                                   name="_work_group_name"-->
<!--                                                   placeholder="创建新分类 回车添加">-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="upload-content-msg">
                                <script type="text/plain" id="editor_upload_video" name="content"></script>
                            </div>
                            <div class="upload-content-msg">
                                <div class="upload-content-tagwrap clearfix">
                                    <div class="upload-content-tag flag-placeholder clearfix">
                                        <input class="_tags" type="text" maxlength="20" autocomplete="off"/>
                                        <label>添加相关标签，用逗号分隔</label>
                                        <span class="hiddenSpan"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="upload-content-setting clearfix">
                                <div class="upload-content-copyright dropup">
                                    <a class="copyright-btn _open_status_icon" href="javascript:void(0);" data-toggle="dropdown"
                                       role="button"
                                       aria-haspopup="true" aria-expanded="false">
                                        <i class="copyright-icon copyright-icon-0"></i>
                                        <span class="copyright-desc">版权设置</span>
                                    </a>
                                    <ul class="dropdown-menu _chose_open_status" aria-labelledby="dLabel">
                                        <li data="3">
                                            <a class="clearfix">
                                                <i class="copyright-icon copyright-icon-3"></i>

                                                <p class="copyright-desc">作品禁止商业使用</p>
                                            </a>
                                        </li>
                                        <li data="4">
                                            <a class="clearfix">
                                                <i class="copyright-icon copyright-icon-4"></i>

                                                <p class="copyright-desc">不限制作品用途</p>
                                            </a>
                                        </li>
                                        <li data="5">
                                            <a class="clearfix">
                                                <i class="copyright-icon copyright-icon-5"></i>

                                                <p class="copyright-desc">禁止右键另存和商业使用</p>
                                            </a>
                                        </li>
                                    </ul>
                                    <input type="hidden" value="" name="copyright" id="copyright_video">
                                </div>
                            </div>
                            <div class="upload-content-operate clearfix">
                                <input type="hidden" name="s_id" value="<?=$s_id?>" autocomplete="off"/>
                                <input type="hidden" value="" id="video_cover" name="video_cover">
                                <input type="hidden" name="picorvideo" value="2" autocomplete="off"/>
                                <input type="hidden" name="videos" id="videos"/>
                                <a class="operate-cancel _go_work_list" href="<?=yii::$app->params['frontendurl'].'/studio/index/detail?s_id='.$s_id?>">返回</a>
                                <a class="operate-release _submit_work_form" href="javascript:submitUploadVideo();">发布</a>
                            </div>
                        </form>
                        <script>
                            function submitUploadVideo()
                            {
                                if (!$("#form_video input[name=title]").val()) {
                                    alert("请输入标题!");
                                }
                                else if (!$("#form_video input[name=video_cover]").val()) {
                                    alert("请上传封面!");
                                }
                                else if (!$("#form_video input[name=videos]").val() && !$("#form_video input[name=link]").val()) {
                                    alert("请上传视频文件或输入视频链接!");
                                }
                                else {
                                    $("#form_video").submit();
                                }
                            }
                        </script>
                    </div>
                    <!--/video -->

                    <!--text -->
                    <div class="rc-upload-content">
                        <form action="<?=yii::$app->urlManager->createUrl(['/studio/trends/upload-text']);?>" method="post" class="_work_form" id="form_text">
                            <div class="upload-content-msg">
                                <span class="red-star">*</span>
                                <div class="upload-content-title flag-placeholder">
                                    <input type="text" class="form-control" placeholder="标题" name="title"
                                           autocomplete="off" maxlength="45"/>
                                    <!-- <label>标题（可不填）</label> -->
                                </div>
                            </div>
<!--                            <div class="upload-content-msg">-->
<!--                                <div class="upload-content-category dropdown">-->
<!--                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"-->
<!--                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">-->
<!--                                        <span class="samplereels">选择分类</span>-->
<!--                                        <span class="caret"></span>-->
<!--                                    </button>-->
<!--                                    <ul class="dropdown-menu _work_group_list" aria-labelledby="dropdownMenu1">-->
<!--                                        <li>-->
<!--                                            <a>啦啦啦</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a>啊啊啊</a>-->
<!--                                        </li>-->
<!--                                        <li class="create-newworks">-->
<!--                                            <input type="text" class="form-control _add_work_group" autocomplete="off"-->
<!--                                                   name="_work_group_name"-->
<!--                                                   placeholder="创建新分类 回车添加">-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="upload-content-msg">
                                <script type="text/plain" id="editor_upload_txt" name="content"></script>
                            </div>
                            <div class="upload-content-msg">
                                <div class="upload-content-tagwrap clearfix">
                                    <div class="upload-content-tag flag-placeholder clearfix">
                                        <input class="_tags" type="text" maxlength="20" autocomplete="off"/>
                                        <label>添加相关标签，用逗号分隔</label>
                                        <span class="hiddenSpan"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="upload-content-setting clearfix">
                                <div class="upload-content-copyright dropup">
                                    <a class="copyright-btn _open_status_icon" href="javascript:void(0);" data-toggle="dropdown"
                                       role="button"
                                       aria-haspopup="true" aria-expanded="false">
                                        <i class="copyright-icon copyright-icon-0"></i>
                                        <span class="copyright-desc">版权设置</span>
                                    </a>
                                    <ul class="dropdown-menu _chose_open_status" aria-labelledby="dLabel">
                                        <li data="2">
                                            <a class="clearfix">
                                                <i class="copyright-icon copyright-icon-2"></i>

                                                <p class="copyright-desc">作品禁止右键另存为</p>
                                            </a>
                                        </li>
                                        <li data="3">
                                            <a class="clearfix">
                                                <i class="copyright-icon copyright-icon-3"></i>

                                                <p class="copyright-desc">作品禁止商业使用</p>
                                            </a>
                                        </li>
                                        <li data="4">
                                            <a class="clearfix">
                                                <i class="copyright-icon copyright-icon-4"></i>

                                                <p class="copyright-desc">不限制作品用途</p>
                                            </a>
                                        </li>
                                        <li data="5">
                                            <a class="clearfix">
                                                <i class="copyright-icon copyright-icon-5"></i>

                                                <p class="copyright-desc">禁止右键另存和商业使用</p>
                                            </a>
                                        </li>
                                    </ul>
                                    <input type="hidden" value="" name="copyright" id="copyright_text">
                                </div>
                            </div>
                            <div class="upload-content-operate clearfix">
                                <input type="hidden" name="s_id" value="<?=$s_id?>" autocomplete="off"/>
                                <input type="hidden" name="picorvideo" value="3" autocomplete="off"/>
                                <a class="operate-cancel _go_work_list" href="<?=yii::$app->params['frontendurl'].'/studio/index/detail?s_id='.$s_id?>">返回</a>
                                <a class="operate-release _submit_work_form" href="javascript:submitUploadText();">发布</a>
                            </div>
                        </form>
                        <script>
                            function submitUploadText()
                            {
                                if (!$("#form_text input[name=title]").val()) {
                                    alert("请输入标题!");
                                }
                                else {
                                    $("#form_text").submit();
                                }
                            }
                        </script>
                    </div>
                    <!--/text -->
                </div>
            </div>
            <div class="rc-overlayer"></div>
        </div>
        <!--/content-->

        <!--modal-->
        <div id="_tips_win" class="modal fade" tabindex="-1" role="dialog"
             aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">提示窗口</h4>
                    </div>
                    <div class="modal-body" id="_tips_content"></div>
                </div>
            </div>
        </div>
        <!--/modal-->
        <!-- /upload -->
    </div>

<?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_footer.php')?>

<script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>
<script type="text/javascript" src="http://rc.vsochina.com/js/rc_index.js"></script>
<script type="text/javascript">
var editorTxt = null;
var editorVideo = null;
var editorPicture = null;
    "use strict";
    $(function () {
        //图片、视频、文字切换
        $(".rc-upload-nav li").Tab({
            action: "click",
            container: ".rc-upload-box .rc-upload-content",
            className: "active",
            tabSwitch: function (myThis, index, container, className) {
                var _this = $(myThis);
                _this.addClass(className).siblings().removeClass(className);
                $(container).eq(index).addClass(className).siblings().removeClass(className);
            }
        });
        // web-uploader(图片)
        // 初始化(图片)
        var picUploader;
        picUploader = WebUploader.create({
            auto: true,
            swf: 'http://static.vsochina.com/libs/webuploader/0.1.5/Uploader.swf',
            server: '/webuploader/fileuploader.php',
            pick: '#rc_picturePicker',
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },
            dnd: '#rc_picturePicker',
            disableGlobalDnd: true,
//                    chunked: true,
//                    chunkSize: '5',
            fileVal: 'file',
            compress:false
        });
        // 文件添加进来的时候(图片)
        picUploader.on('fileQueued', function (file) {
            var _list = $("#rc_pictureList"),
                _li = $('<div id="' + file.id + '" class="uploader-listitem"><div class="uploader-progress"><i class="icon-progress">0%</i></div></div>');
            _list.append(_li);
            if (_list.find(".uploader-listitem").length == 1) {
                _list.next("#rc_picturePicker").find(".webuploader-pick").html('<p class="rc-picturePicker-txt"><i class="icon-13 icon-13-blueadd"></i>继续添加</p>').closest('#uploader_picture').addClass('uploader-one');
            }
            else if (_list.find(".uploader-listitem").length == 2) {
                _list.closest('#uploader_picture').removeClass('uploader-one').addClass('uploader-more');
            }
        });
        // 文件上传过程中创建进度条实时显示(图片)
        picUploader.on('uploadProgress', function (file, percentage) {
            var _li = $("#" + file.id),
                _percent = _li.find('.icon-progress');
            _percent.html(percentage * 100 + '%');
        });
        // 文件上传成功(图片)
        picUploader.on('uploadSuccess', function (file, response) {
            $("#"+file.id).html("<img src='"+response.src+"'>");
            $("#form_image").append("<input type='hidden' value='"+response.src+"' name='images[]' id='hidden_file_"+file.id+"'>");
//            return;
//            if (typeof (response.ret) == 'undefined') {
//                var _file_ret = $(response._raw).find('ret').text();
//                var _file_path = $(response._raw).find('file_url').text();
//            }
//            else {
//                var _file_ret = response.ret;
//                var _file_path = response.data.file_url;
//            }
//            var _input = '';
//            if (_file_ret == '13900') {
//                _input = '<input type="hidden" name="work[pic_list][]" value="' + _file_path + '" />';
//            }
//            var work_desc = '<div class="uploader-listitem-remarkbox">\
//                            <span class="remarkbox-triangle"></span>\
//                            <div class="remarkbox-input">\
//                                <input name="work[work_desc][]" type="text" class="form-control" placeholder="TO：对单个作品描述">\
//                            </div>\
//                            <div class="remarkbox-btngroup clearfix">\
//                            </div>\
//                        </div>';
            var _list = $("#rc_pictureList"),
                _li = $("#" + file.id),
                _img;
            if (_list.find(".uploader-listitem").length == 1) {
                _li.html(_li.html()+'<a class="uploader-listitem-close" href="javascript:void(0);">×</a>');
                _img = _li.find('img');
            }
            else if (_list.find(".uploader-listitem").length == 2) {
                var _prev = _li.prev(".uploader-listitem");
                if (_prev.find("p").length > 0) {
                    _prev.append($('<a class="showremark-btn uploader-listitem-noremark" href="javascript:void(0);"></a>')).find("p").remove();
                }
                _li.html(_li.html()+'<a class="uploader-listitem-close" href="javascript:void(0);">×</a>');
                _img = _li.find('img');
            }
            else {
                _li.html(_li.html()+'<a class="uploader-listitem-close" href="javascript:void(0);">×</a>');
                _img = _li.find('img');
            }
//            picUploader.makeThumb(file, function (error, src) {
//                if (error) {
//                    _img.replaceWith('<span>不能预览</span>');
//                    return;
//                }
//                _img.attr('src', src);
//            }, 750, 430);
        });
        //上传成功后点击叉号删除文件(图片)
        $(".uploader-list").on('click', '.uploader-listitem-close', function (event) {
            var _this = $(this),
                _obj = _this.closest('.uploader-listitem'),
                _list = $("#rc_pictureList"),
                fileId = _obj.attr('id'),
                len;
            picUploader.removeFile(fileId, true);
            _obj.remove();
            $("#hidden_file_"+fileId).remove();
            len = _list.find(".uploader-listitem").length;
            if (len == 0) {
                _list.next("#rc_picturePicker").find(".webuploader-pick").html(
                    '<p class="rc-picturePicker-icon"><i class="icon-41 icon-41-camera"></i></p>\
                    <p class="rc-picturePicker-txt">拖拽/点击添加本地文件</p>');
                _list.closest('.uploader-one').removeClass('uploader-one');
            }
            else if (len == 1) {
                _list.find('.uploader-listitem').append('').find('.showremark-btn').remove();
                _list.closest('.uploader-more').removeClass('uploader-more').addClass('uploader-one');
            }
        });
        // 文件上传失败(图片)
        picUploader.on('uploadError', function (file) {
            var _li = $('#' + file.id);
            _li.find('.icon-progress').html('失败');
        });
        // web-uploader(视频封面)
        // 初始化(视频封面)
        var coverUploader;
        coverUploader = WebUploader.create({
            auto: true,
            swf: 'http://static.vsochina.com/libs/webuploader/0.1.5/Uploader.swf',
            server: '/webuploader/fileuploader.php',
            pick: '#rc_videoCoverPicker',
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },
            dnd: undefined,
            disableGlobalDnd: true,
            multiple: false,
//                    chunked: true,
//                    chunkSize: '5',
            fileVal: 'file'
        });
        // 文件添加进来的时候(视频封面)
        coverUploader.on('fileQueued', function (file) {
            if (!$('.up-after').length) {
                var _list = $("#uploader_videocover"),
                    _li = $('<div  class="rc-videoCoverList" id="' + file.id + '"><div class="uploader-progress"><i class="icon-progress">0%</i></div></div>'),
                    _obj = $("#rc_videoCoverPicker.up-before");
                _obj.next('.first').removeClass('first');
                _obj.removeClass('up-before').addClass('up-after').wrap('<div class="videoCoverPicker-right"></div>').find('.webuploader-pick').html('修改封面');
                _list.prepend(_li);
            }
            else {
                var _li = $('.rc-videoCoverList');
                _li.attr('id', file.id).html('<div class="uploader-progress"><i class="icon-progress">0%</i></div>')
            }
        });
        // 文件上传过程中创建进度条实时显示(视频封面)
        coverUploader.on('uploadProgress', function (file, percentage) {
            var _li = $("#" + file.id),
                _percent = _li.find('.icon-progress');
            _percent.html(percentage * 100 + '%');
        });
        // 文件上传成功(视频封面)
        coverUploader.on('uploadSuccess', function (file, response) {
            $("#"+file.id).html("<img src='"+response.src+"'>");
            $("#video_cover").val(response.src);
            return;
            if (typeof (response.ret) == 'undefined') {
                var _file_ret = $(response._raw).find('ret').text();
                var _file_path = $(response._raw).find('file_url').text();
            }
            else {
                var _file_ret = response.ret;
                var _file_path = response.data.file_url;
            }
            var _input = '';
            if (_file_ret == '13900') {
                _input = '<input type="hidden" name="work[workcover]" value="' + _file_path + '" />';
            }
            var _li = $("#" + file.id),
                _img;
            _li.html("<img>" + _input);
            _img = _li.find('img');
            coverUploader.makeThumb(file, function (error, src) {
                if (error) {
                    _img.replaceWith('<span>不能预览</span>');
                    return;
                }
                _img.attr('src', src);
            }, 282, 160);
        });
        // 文件上传失败(视频封面)
        coverUploader.on('uploadError', function (file) {
            var _li = $('#' + file.id);
            _li.find('.icon-progress').html('失败');
        });
        // web-uploader(视频)
        // 初始化(视频)
        var videoUploader;
        videoUploader = WebUploader.create({
            auto: true,
            swf: 'http://static.vsochina.com/libs/webuploader/0.1.5/Uploader.swf',
            server: '/webuploader/fileuploader.php',
            pick: '#rc_videoPicker',
            accept: {
                title: 'Videos',
                extensions: 'avi,3gp,mp4,rmvb,wmv',
                mimeTypes: 'video/*'
            },
            dnd: undefined,
            disableGlobalDnd: true,
            multiple: false,
            sendAsBinary: true,
            chunked: true,
//                    chunkSize: 5*1024*1024,
            fileVal: 'file'
        });
        // 文件添加进来的时候(视频)
        videoUploader.on('fileQueued', function (file) {
            var _list = $('#rc_videoPicker .webuploader-pick'),
                _li = _list.find('.uploader-progress');
            if (!_li.length) {
                var _li = $('<div class="uploader-progress" id="' + file.id + '"><i class="icon-progress"></i></div>');
                _list.append(_li).next().css('z-index', 5);
            }
            else {
                _li.attr('id', file.id).find('.icon-progress').html(file.name);
            }
        });
        // 文件上传过程中创建进度条实时显示(视频)
        videoUploader.on('uploadProgress', function (file, percentage) {
            var _li = $("#" + file.id);
            _li.css('width', percentage * 100 + '%');
        });
        // 文件上传返回时触发(视频)
        videoUploader.on('uploadAccept',function(object, response){
            console.info(response.src);
            $("#videos").val(response.src);return;
            if (typeof (response.ret) == 'undefined') {
                var _file_ret = $(response._raw).find('ret').text();
                var _file_path = $(response._raw).find('file_url').text();
            }
            else {
                var _file_ret = response.ret;
                var _file_path = response.data.file_url;
            }
            if (_file_ret == '13900') {
                $('input[name="work[work_url]"]').val(_file_path);
            }
        });
        // 文件上传成功(视频)
        videoUploader.on('uploadSuccess', function (file, response) {
            console.info(response.src);
            $("#videos").val(response.src);return;
//            if (typeof (response.ret) == 'undefined') {
//                var _file_ret = $(response._raw).find('ret').text();
//                var _file_path = $(response._raw).find('file_url').text();
//            }
//            else {
//                var _file_ret = response.ret;
//                var _file_path = response.data.file_url;
//            }
//            if (_file_ret == '13900') {
//                $('input[name="work[work_url]"]').val(_file_path);
//            }
//            var _li = $("#" + file.id);
//            _li.find('.icon-progress').html('100%');
        });
        // 文件上传失败(视频)
        videoUploader.on('uploadError', function (file) {
            var _li = $('#' + file.id);
            _li.find('.icon-progress').html('失败');
        });
        //富文本编辑器
        var config = {
            toolbars: [
                ['paragraph','bold','italic','underline','strikethrough','forecolor', 'attachment', 'insertimage','|' , 'insertorderedlist','insertunorderedlist','blockquote', 'source', 'justifyleft', 'justifyright', 'justifycenter', '|' , 'link', 'horizontal','inserttable']
            ],
            // iframeCssUrl:'/static/css/discussion/index.css',
            initialFrameHeight : 400
        };
        editorTxt = UE.getEditor("editor_upload_txt", config);
        editorVideo = UE.getEditor("editor_upload_video", config);
        editorPicture = UE.getEditor("editor_upload_picture", config);
        //添加标签
        $(".upload-content-tagwrap input").on('focus', function (event) {
            $(this).next("label").addClass('hide');
        });
        $(".upload-content-tagwrap input").on('blur', function (event) {
            var _this = $(this),
                _label = _this.next("label");
            if ((_this.val() == '') && (!(_this.closest(".upload-content-tagwrap").find(".upload-content-token").length > 0)) && (_label.hasClass('hide'))) {
                _label.removeClass('hide');
            }
        });
        $(".upload-content-tagwrap").on('click', function (event) {
            $(this).find('input').focus();
        });
        $(".upload-content-tagwrap").on('keydown', function (event) {
            var _this = $(this),
                _input = _this.find('input'),
                myHtml = _input.val(),
                code = event.keyCode,
                _span = _this.find('.hiddenSpan'),
                spanW = _span.width();
            spanW += 10;
            _span.html(myHtml);
            if (_span.width() > 60) {
                _input.width(spanW);
            }
        });
        $(".upload-content-tagwrap").on('keyup', function (event) {
            var _this = $(this),
                _span = _this.find('.hiddenSpan'),
                _input = _this.find('._tags'),
                myHtml = _input.val(),
                code = event.keyCode;
            if ((code == 188) || (code == 13)) {
                _input.val("").width(60);
                _span.html("");
                myHtml = myHtml.replace(/\,/g, "").replace(/\，/g, "");
                myHtml = '<span class="upload-content-token">' + myHtml + '<input type="hidden" name="tags[]" value="' + myHtml + '"></span>';
                _this.find(".upload-content-tag").before(myHtml);
                return;
            }
            else if ((myHtml == "") && (code == 8)) {
                var _lastToken = _this.find(".upload-content-token:last");
                if (_lastToken.length > 0) {
                    _lastToken.remove();
                }
            }
            var spanW = _span.width();
            spanW += 10;
            _span.html(myHtml);
            if (_span.width() > 60) {
                _input.width(spanW);
            }
        });
        //版权设置
        $(".upload-content-copyright .dropdown-menu li").on('click', function (event) {
            var _this = $(this),
                _obj = $(".upload-content-copyright .copyright-btn"),
                iconClass = _this.find('i').prop("className"),
                txt = _this.find('.copyright-desc').html();
            _this.parent().parent().find("input:hidden").val(_this.attr("data"));
            _this.addClass('copyright-selected').siblings().removeClass('copyright-selected');
//                    _obj.addClass('copyright-dark').find('i').removeClass().addClass(iconClass).next('.copyright-desc').html(txt);
            _obj.addClass('copyright-dark').find('i').attr('class', '').addClass(iconClass).next('.copyright-desc').html(txt);
        });
        //选择所属作品集
        $(".upload-content-category .dropdown-menu a").on('click', function (event) {
            var _this = $(this),
                _obj = $(".upload-content-category .btn");
            _obj.find('.samplereels').html(_this.html());
        });
        //单个作品评论弹出框
        $(".uploader-list").on('click', '.showremark-btn', function (event) {
            var _this = $(this);
            $(".uploader-listitem-remarkbox").hide();
            _this.siblings(".uploader-listitem-remarkbox").show();
            _this.closest('.uploader-listitem').addClass('showremark');
            $(".rc-overlayer").show();
            return;
            stopPropagation(event);
            var _obj = $(".uploader-listitem-remarkbox");
            if (!(_obj.length > 0)) {
                var _this = $(this),
                    myHtml = '<div class="uploader-listitem-remarkbox">\
                            <span class="remarkbox-triangle"></span>\
                            <div class="remarkbox-input">\
                                <input name="work[work_desc][]" type="text" class="form-control" placeholder="TO：对单个作品描述">\
                            </div>\
                            <div class="remarkbox-btngroup clearfix">\
                            </div>\
                        </div>';
                _obj = $(myHtml);
                _this.closest('.uploader-listitem').addClass('showremark').append(_obj);
                $(".rc-overlayer").show();
            }
        });
        $(document).on('click', function (event) {
            var _obj = $(".uploader-listitem-remarkbox");
            _obj.hide();
            _obj.closest('.uploader-listitem').removeClass('showremark');
            $(".rc-overlayer").hide();
            return;
            var _obj = $(".uploader-listitem-remarkbox");
            if (_obj.length > 0) {
                _obj.closest('.uploader-listitem').removeClass('showremark');
                _obj.remove();
                $(".rc-overlayer").hide();
            }
        });
        //单个作品描述确认,取消
        $('.remarkbox-confirm').on('click', function () {
            $(this).parents('.uploader-listitem-remarkbox').hide();
        });
        $(".uploader-list").on('click', function (event) {
            stopPropagation(event);
        });
        //外链，本地视频
        $('.uploader-video-link input').on('focus', function (event) {
            $(this).next("label").addClass('hide');
        });
        $(".uploader-video-link input").on('blur', function (event) {
            var _this = $(this),
                _label = _this.next("label");
            if ((_this.val() == '') && (_label.hasClass('hide'))) {
                _label.removeClass('hide');
            }
        });
        $('.uploader-video-link, .uploader-video-local').on('click', function (event) {
            var _this = $(this);
            if (!_this.hasClass('active')) {
                _this.addClass('active').siblings().removeClass('active').find('.form-control').val('').next('label').removeClass('hide');
            }
        });
    });
    /*阻止冒泡*/
    function stopPropagation(event){
        if (event.stopPropagation)  event.stopPropagation();
        else  event.cancelBubble = true;
    }
</script>
</body>
</html>