<?php
use yii\helpers\Html;

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="shortcut icon" href="<?= $user_info['avatar'] ?>" type="image/x-icon"/>
    <title><?= "作品上传 | ".$user_info['nickname'] ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit"/>
    <!--reset.css  header.css  footer.css-->
    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css"/>
    <!--css-->
    <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/libs/bootstrap/3.3.5/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/libs/webuploader/0.1.5/webuploader.css">
    <link type="text/css" rel="stylesheet" href="/css/rc_index.css">
    <link type="text/css" rel="stylesheet" href="/css/rc_case.css">
    <link type="text/css" rel="stylesheet" href="/css/rc_upload.css">
    <!--jquery-->
    <script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.all.js"></script>
    <script type="text/javascript" charset="utf-8" src="/plugins/ueditor/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/webuploader/0.1.5/webuploader.js"></script>
    <!--cookie domain-->
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
    <style>
        .upload-content-msg .upload-content-category .btn .caret {
            float: none;
            margin: auto;
        }
    </style>
</head>

<body class="bg-grey mw1200">
<!--header-->
<script type="text/javascript" src="http://account.vsochina.com/static/js/vsoheader.js"></script>
<!--/header-->

<!--content-->
<div class="rc-upload-wrap">
    <div class="rc-upload-box">
        <ul class="rc-upload-nav clear-float">
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
            <!--图片 -->
            <div class="rc-upload-content active">
                <form action="" method="post" class="_work_form">
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
                        <div class="upload-content-title flag-placeholder">
                            <input type="text" class="form-control" placeholder="标题（可不填）" name="work[name]"
                                   autocomplete="off"/>
                            <!-- <label>标题（可不填）</label> -->
                        </div>
                    </div>
                    <div class="upload-content-msg">
                        <div class="upload-content-category dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <span class="samplereels">选择所属作品集</span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu _work_group_list" aria-labelledby="dropdownMenu1">
                                <?php if (!empty($_work_group_list)): ?>
                                    <?php foreach ($_work_group_list as $val): ?>
                                        <li>
                                            <a href="javascript:void(0);" class="_chose_work_group"
                                               data="<?php echo $val['p_work_id']; ?>">
                                                <?php echo $val['work_name']; ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <li class="create-newworks">
                                    <input type="text" class="form-control _add_work_group" autocomplete="off"
                                           name="_work_group_name"
                                           placeholder="创建新作品集 回车添加">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="upload-content-msg">
                        <script type="text/plain" id="editor_upload_picture" name="work[content]"
                                style="margin:10px 0;"></script>
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

                                        <p class="copyright-desc">禁止看大图</p>
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
                                <li data="0">
                                    <a class="clearfix">
                                        <i class="copyright-icon copyright-icon-4"></i>

                                        <p class="copyright-desc">不限制作品用途</p>
                                    </a>
                                </li>
                                <li data="4">
                                    <a class="clearfix">
                                        <i class="copyright-icon copyright-icon-5"></i>

                                        <p class="copyright-desc">禁止-右键-商业使用</p>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <ul class="upload-content-sharebox clearfix">
                            <div class="bdsharebuttonbox">
                                <a title="分享到新浪微博" href="#" class="icon-24 icon-24-weibo" data-cmd="tsina"></a>
                                <a title="分享到QQ好友" href="#" class="icon-24 icon-24-qq" data-cmd="sqq"></a>
                                <a title="分享到QQ空间" href="#" class="icon-24 icon-24-qqzone" data-cmd="qzone"></a>
                                <a title="分享到微信" href="#" class="icon-24 icon-24-wechat" data-cmd="weixin"></a>
                            </div>
                        </ul>
                    </div>
                    <div class="upload-content-operate clearfix">
                        <input type="hidden" name="work[picorvideo]" value="1" autocomplete="off"/>
                        <input type="hidden" name="work[work_group_id]" value="" autocomplete="off"/>
                        <input type="hidden" name="work[open_status]" value="1" autocomplete="off"/>
                        <a class="operate-cancel _go_work_list" href="<?php echo yii::$app->urlManager->createUrl(['personal/index']) .'/'. $username;?>">返回</a>
                        <a class="operate-release _submit_work_form" href="javascript:void(0);">发布</a>
                    </div>
                </form>
            </div>
            <!--/图片 -->

            <!--视频 -->
            <div class="rc-upload-content">
                <form action="" method="post" class="_work_form">
                    <div id="uploader_videocover" class="clearfix">
                        <div id="rc_videoCoverPicker" class="up-before">
                            <p class="rc-videoCoverPicker-icon"><i class="icon-36 icon-36-upload"></i></p>

                            <p class="rc-videoCoverPicker-txt">上传封面</p>
                        </div>
                        <div class="videoCoverPicker-right first">10MB以内/RGB模式</div>
                        <div class="videoCoverPicker-right">支持尺寸：宽度240，高度不限</div>
                        <div class="videoCoverPicker-right">支持格式：jpg/png</div>
                    </div>
                    <div id="uploader_video">
                        <div class="uploader-video-link active">
                            <input type="text" class="form-control" name="work[work_link]" autocomplete="off"/>
                            <label><i class="icon-16 icon-16-link"></i></label>
                        </div>
                        <div id="rc_videoPicker" class="uploader-video-local">
                            <i class="icon-16 icon-16-cloud"></i>
                            点击添加本地文件
                        </div>
                    </div>
                    <div class="upload-content-msg">
                        <div class="upload-content-title flag-placeholder">
                            <input type="text" class="form-control" placeholder="标题（可不填）" name="work[name]"
                                   autocomplete="off"/>
                        </div>
                    </div>
                    <div class="upload-content-msg">
                        <div class="upload-content-category dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <span class="samplereels">选择所属作品集</span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu _work_group_list" aria-labelledby="dropdownMenu1">
                                <?php if (!empty($_work_group_list)): ?>
                                    <?php foreach ($_work_group_list as $val): ?>
                                        <li>
                                            <a href="javascript:void(0);" class="_chose_work_group"
                                               data="<?php echo $val['p_work_id']; ?>">
                                                <?php echo $val['work_name']; ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <li class="create-newworks">
                                    <input type="text" class="form-control _add_work_group" autocomplete="off"
                                           name="_work_group_name"
                                           placeholder="创建新作品集 回车添加">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="upload-content-msg">
                        <script type="text/plain" id="editor_upload_video" name="work[content]"
                                style="margin:10px 0;"></script>
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
                                <li data="0">
                                    <a class="clearfix">
                                        <i class="copyright-icon copyright-icon-4"></i>

                                        <p class="copyright-desc">不限制作品用途</p>
                                    </a>
                                </li>
                                <li data="4">
                                    <a class="clearfix">
                                        <i class="copyright-icon copyright-icon-5"></i>

                                        <p class="copyright-desc">禁止-商业使用</p>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <ul class="upload-content-sharebox clearfix">
                            <div class="bdsharebuttonbox">
                                <a title="分享到新浪微博" href="#" class="icon-24 icon-24-weibo" data-cmd="tsina"></a>
                                <a title="分享到QQ好友" href="#" class="icon-24 icon-24-qq" data-cmd="sqq"></a>
                                <a title="分享到QQ空间" href="#" class="icon-24 icon-24-qqzone" data-cmd="qzone"></a>
                                <a title="分享到微信" href="#" class="icon-24 icon-24-wechat" data-cmd="weixin"></a>
                            </div>
                        </ul>

                    </div>
                    <div class="upload-content-operate clearfix">
                        <input type="hidden" name="work[work_url]" value="" autocomplete="off"/>
                        <input type="hidden" name="work[picorvideo]" value="2" autocomplete="off"/>
                        <input type="hidden" name="work[work_group_id]" value="" autocomplete="off"/>
                        <input type="hidden" name="work[open_status]" value="1" autocomplete="off"/>
                        <a class="operate-cancel _go_work_list" href="<?php echo yii::$app->urlManager->createUrl(['personal/index']) .'/'. $username;?>">返回</a>
                        <a class="operate-release _submit_work_form" href="javascript:void(0);">发布</a>
                    </div>
                </form>
            </div>
            <!--/视频 -->
            <!--文字 -->
            <div class="rc-upload-content">
                <form action="" method="post" class="_work_form">
                    <div class="upload-content-msg">
                        <div class="upload-content-title flag-placeholder">
                            <input type="text" class="form-control" placeholder="标题（可不填）" name="work[name]"
                                   autocomplete="off"/>
                            <!-- <label>标题（可不填）</label> -->
                        </div>
                    </div>
                    <div class="upload-content-msg">
                        <div class="upload-content-category dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <span class="samplereels">选择所属作品集</span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu _work_group_list" aria-labelledby="dropdownMenu1">
                                <?php if (!empty($_work_group_list)): ?>
                                    <?php foreach ($_work_group_list as $val): ?>
                                        <li>
                                            <a href="javascript:void(0);" class="_chose_work_group"
                                               data="<?php echo $val['p_work_id']; ?>">
                                                <?php echo $val['work_name']; ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <li class="create-newworks">
                                    <input type="text" class="form-control _add_work_group" autocomplete="off"
                                           name="_work_group_name"
                                           placeholder="创建新作品集 回车添加">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="upload-content-msg">
                        <script type="text/plain" id="editor_upload_txt" name="work[content]"
                                style="margin:10px 0;"></script>
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
                                <li data="0">
                                    <a class="clearfix">
                                        <i class="copyright-icon copyright-icon-4"></i>

                                        <p class="copyright-desc">不限制作品用途</p>
                                    </a>
                                </li>
                                <li data="4">
                                    <a class="clearfix">
                                        <i class="copyright-icon copyright-icon-5"></i>

                                        <p class="copyright-desc">禁止-右键-商业使用</p>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <ul class="upload-content-sharebox clearfix">
                            <div class="bdsharebuttonbox">
                                <a title="分享到新浪微博" href="#" class="icon-24 icon-24-weibo" data-cmd="tsina"></a>
                                <a title="分享到QQ好友" href="#" class="icon-24 icon-24-qq" data-cmd="sqq"></a>
                                <a title="分享到QQ空间" href="#" class="icon-24 icon-24-qqzone" data-cmd="qzone"></a>
                                <a title="分享到微信" href="#" class="icon-24 icon-24-wechat" data-cmd="weixin"></a>
                            </div>
                        </ul>
                    </div>
                    <div class="upload-content-operate clearfix">
                        <input type="hidden" name="work[picorvideo]" value="3" autocomplete="off"/>
                        <input type="hidden" name="work[work_group_id]" value="" autocomplete="off"/>
                        <input type="hidden" name="work[open_status]" value="1" autocomplete="off"/>
                        <a class="operate-cancel _go_work_list" href="<?php echo yii::$app->urlManager->createUrl(['personal/index']) .'/'. $username;?>">返回</a>
                        <a class="operate-release _submit_work_form" href="javascript:void(0);">发布</a>
                    </div>
                </form>
            </div>
            <!--/文字 -->
        </div>
    </div>
    <div class="rc-overlayer"></div>
</div>
<!--/content-->

<!--提示窗口-->
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
<!--提示窗口-->

<script type="text/javascript" src="http://static.vsochina.com/libs/jquery.lazyload/1.9.5/jquery.lazyload.js"></script>
<script type="text/javascript" src="http://www.vsochina.com/resource/js/index/jquery.SuperSlide.js"></script>
<script type="text/javascript" src="/js/rc_index.js"></script>
<!--footer-->
<script type="text/javascript" src="http://account.vsochina.com/static/js/vsofooter.js"></script>
<!--add experience-->
<script type="text/javascript" src="http://account.vsochina.com/static/js/experience.js?v=1"></script>
<?php echo Html::jsFile('@web/js/jquery.form.js'); ?>
<?php echo Html::jsFile('@web/js/jquery.ui.min.js'); ?>

<script>
    $(function () {
        $('._submit_work_form').click(function () {
            $(this).parents('._work_form').ajaxSubmit({
                url: '<?php echo yii::$app->urlManager->createUrl(['personal/work/create'])?>',
                data: $(this).serialize(),
                type: "POST",
                dataType: 'json',
                beforeSubmit: function () {
                    //检测必填字段
                    var _check_result = true;
                    var _work_group_id = $('input[name="work[work_group_id]"]').val();
                    if (_work_group_id == '' || _work_group_id == 'undefined') {
                        _show_tips_win('提示窗口', '请选择所属作品集', 3);
                        _check_result = false;
                    }
                    return _check_result;
                },
                success: function (data) {
                    if (data.ret == '0001') {
                        _show_tips_win('提示窗口', '作品添加成功！', 3, function (d) {
                            window.location.href = '<?php echo yii::$app->urlManager->createUrl(['personal/index']) .'/'. $username;?>';
                        }, data);
                    }
                    else {
                        _show_tips_win('提示窗口', data.msg, 3);
                    }
                }
            });
            return false;
        });
        $('._go_work_list').click(function () {
            if(!confirm('当前数据尚未保存，确定要返回作品列表？')){
                return false;
            }
        });
        //添加作品集
        $(document).on('keypress', '._add_work_group', function (event) {
            if (event.keyCode == "13") {
                $(this).parents('.upload-content-category').removeClass('open').children('.dropdown-toggle').attr('aria-expanded', 'false');
                var name = $(this).val();
                _ajax('<?php echo yii::$app->urlManager->createUrl(['personal/work/ajax_create_work_group'])?>', {name: name}, 'post', 'json', function (data) {
                    if (data.ret == '0001') {
                        _show_tips_win('提示窗口', '作品集添加成功！', 2, function (d) {
                            //增加
                            var _code = '<li><a data="' + d.data.work_group_id + '" class="_chose_work_group" href="javascript:void(0);">' + d.data.name + '</a></li>';
                            $('._work_group_list').prepend(_code);
                            $('._add_work_group').val('');
                        }, data);
                    }
                    else {
                        _show_tips_win('提示窗口', '作品集添加失败！', 0, function (d) {
                        }, data);
                    }
                });
            }
        });
        $(document).on('click', '._chose_work_group', function () {
            var _val = $(this).attr('data');
            var _text = $(this).text();
            if (_val) {
                $('input[name="work[work_group_id]"]').val(_val);
                $('.samplereels').html(_text);
            }
        });
        $('._chose_open_status > li').click(function () {
            var _val = $(this).attr('data');
            if (_val) {
                $('input[name="work[open_status]"]').val(_val);
            }
        });
    });
    //ajax请求
    function _ajax(url, data, type, datatype, callBackFun) {
        if (url) {
            $.ajax({
                url: url,
                data: data,
                cache: false,
                type: type,
                dataType: datatype,
                error: function () {
                },
                success: function (d) {
                    if (typeof (callBackFun) == "function") {
                        callBackFun(d);
                    }
                }
            });
        }
    }
    //提示窗口
    function _show_tips_win(title, msg, timeout, callBackFun, data) {
        if (!title) {
            title = '提示窗口';
        }
        $('#_tips_win').find('.modal-title').html(title);
        $('#_tips_win').find('#_tips_content').html('<p class="modal-tip">'+msg+'</p>');
        $('#_tips_win').modal({backdrop: 'static', keyboard: false});
        if (timeout > 0) {
            setTimeout(function () {
                _close_win('#_tips_win');
                if (typeof (callBackFun) == "function") {
                    callBackFun(data);
                }
            }, parseInt(timeout) * 1000);
        }
    }
    //关闭窗口
    function _close_win(dom_name) {
        $(dom_name).modal('hide');
    }
</script>
<div style="display: none;">
    <!--
        <script type="text/javascript" charset="utf-8" src="http://account.vsochina.com/static/js/global_statistics.js"></script>
    -->
    <div>

        <script type="text/javascript">
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
                    server: '<?php echo yii::$app->params['workUploadUrl'];?>',
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
                    fileVal: 'attachment',
                    formData: {
                        username: '<?php echo $username;?>',
                        objtype: 'work'
                    }
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
                        _input = '<input type="hidden" name="work[pic_list][]" value="' + _file_path + '" />';
                    }
                    var work_desc = '<div class="uploader-listitem-remarkbox">\
                                    <span class="remarkbox-triangle"></span>\
                                    <div class="remarkbox-input">\
                                        <input name="work[work_desc][]" type="text" class="form-control" placeholder="TO：对单个作品描述">\
                                    </div>\
                                    <div class="remarkbox-btngroup clearfix">\
                                    </div>\
                                </div>';
                    var _list = $("#rc_pictureList"),
                        _li = $("#" + file.id),
                        _img;
                    if (_list.find(".uploader-listitem").length == 1) {
//                        _li.html('<img><p>其余部分发布后可完全显示</p>' + _input + '<a class="uploader-listitem-close" href="javascript:void(0);">×</a>');
                        _li.html('<img>' + _input + '<a class="uploader-listitem-close" href="javascript:void(0);">×</a>');
                        _img = _li.find('img');
                    }
                    else if (_list.find(".uploader-listitem").length == 2) {
                        var _prev = _li.prev(".uploader-listitem");
                        if (_prev.find("p").length > 0) {
                            _prev.append($('<a class="showremark-btn uploader-listitem-noremark" href="javascript:void(0);"></a>')).find("p").remove();
                        }
                        _li.html('<img><a class="showremark-btn uploader-listitem-noremark" href="javascript:void(0);"></a>' + _input + work_desc + '<a class="uploader-listitem-close" href="javascript:void(0);">×</a>');
                        _img = _li.find('img');
                    }
                    else {
                        _li.html('<img><a class="showremark-btn uploader-listitem-noremark" href="javascript:void(0);"></a>' + _input + work_desc + '<a class="uploader-listitem-close" href="javascript:void(0);">×</a>');
                        _img = _li.find('img');
                    }
                    picUploader.makeThumb(file, function (error, src) {
                        if (error) {
                            _img.replaceWith('<span>不能预览</span>');
                            return;
                        }
                        _img.attr('src', src);
                    }, 600, 450);
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
                    len = _list.find(".uploader-listitem").length;
                    if (len == 0) {
                        _list.next("#rc_picturePicker").find(".webuploader-pick").html(
                            '<p class="rc-picturePicker-icon"><i class="icon-41 icon-41-camera"></i></p>\
                            <p class="rc-picturePicker-txt">拖拽/点击添加本地文件</p>');
                        _list.closest('.uploader-one').removeClass('uploader-one');
                    }
                    else if (len == 1) {
                        _list.find('.uploader-listitem').append('<p>其余部分发布后可完全显示</p>').find('.showremark-btn').remove();
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
                    server: '<?php echo yii::$app->params['workUploadUrl'];?>',
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
                    fileVal: 'attachment',
                    formData: {
                        username: '<?php echo $username;?>',
                        objtype: 'work'
                    }
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
                    }, 310, 145);
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
                    server: '<?php echo yii::$app->params['workUploadUrl'];?>',
                    pick: '#rc_videoPicker',
                    accept: {
                        title: 'Videos',
                        extensions: 'avi,3gp,mp4,rmvb,wmv',
                        mimeTypes: 'video/*'
                    },
                    dnd: undefined,
                    disableGlobalDnd: true,
                    multiple: false,
//                    sendAsBinary: true,
//                    chunked: true,
//                    chunkSize: 5*1024*1024,
                    fileVal: 'attachment',
                    formData: {
                        username: '<?php echo $username;?>',
                        objtype: 'work'
                    }
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
                        _li.attr('id', file.id).css('width', '0').find('.icon-progress').html('');
                    }
                });
                // 文件上传过程中创建进度条实时显示(视频)
                videoUploader.on('uploadProgress', function (file, percentage) {
                    var _li = $("#" + file.id);
                    _li.css('width', percentage * 100 + '%');
                });
                // 文件上传返回时触发(视频)
                videoUploader.on('uploadAccept',function(object, response){
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
                    var _li = $("#" + file.id);
                    _li.find('.icon-progress').html('100%');
                });
                // 文件上传失败(视频)
                videoUploader.on('uploadError', function (file) {
                    var _li = $('#' + file.id);
                    _li.find('.icon-progress').html('失败');
                });
                //富文本编辑器
                var editorTxt = UE.getEditor("editor_upload_txt");
                editorTxt.ready(function(){
                    editorTxt.setHeight(300);
                });
                var editorVideo = UE.getEditor("editor_upload_video");
                editorVideo.ready(function(){
                    editorVideo.setHeight(300);
                });
                var editorPicture = UE.getEditor("editor_upload_picture");
                editorPicture.ready(function(){
                    editorPicture.setHeight(300);
                });
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
                        myHtml = '<span class="upload-content-token">' + myHtml + '<input type="hidden" name="work[tags][]" value="' + myHtml + '"></span>';
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
                    $(".uploader-listitem-remarkbox").hide();
                    $(this).siblings(".uploader-listitem-remarkbox").show();
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
                    $(".uploader-listitem-remarkbox").hide();
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
        <script>
            //百度分享插件
            window._bd_share_config = {
                "common": {
                    "bdSnsKey": {},
                    "bdText": "",
                    "bdMini": "2",
                    "bdMiniList": false,
                    "bdPic": "",
                    "bdStyle": "2",
                    "bdSize": "24"
                },
                "share": {}
            };
            with (document)0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];
        </script>
        <style>
            .bdshare-button-style2-24 a, .bdshare-button-style2-24 .bds_more {
                background: none;
            }

            .bdsharebuttonbox .icon-24-weibo {
                background: rgba(0, 0, 0, 0) url("/images/rc/personal/space/icon-24-weibo.png") no-repeat scroll center center;
            }

            .bdsharebuttonbox .icon-24-qq {
                background: rgba(0, 0, 0, 0) url("/images/rc/personal/space/icon-24-qq.png") no-repeat scroll center center;
            }

            .bdsharebuttonbox .icon-24-qqzone {
                background: rgba(0, 0, 0, 0) url("/images/rc/personal/space/icon-24-qqzone.png") no-repeat scroll center center;
            }

            .bdsharebuttonbox .icon-24-wechat {
                background: rgba(0, 0, 0, 0) url("/images/rc/personal/space/icon-24-wechat.png") no-repeat scroll center center;
            }

            .dropdown-menu {
                z-index: 1060;
            }

            .modal {
                z-index: 9999;
            }

            .modal-body {
                padding: 15px;
            }

            .uploader-listitem-remarkbox {
                display: none;
            }

            .uploader-listitem .uploader-listitem-remarkbox {
                height: auto;
            }

            .modal-header {
                padding: 15px;
            }
        </style>
</body>

</html>