<div style="min-height: 540px;" class="uc-main">
    <div class="uc-bread">
        <i>个人主页</i> -&gt; <i>主页设置</i> -&gt; <i> 域名管理</i>
    </div>
    <div class="uc-main-content">
        <!--content-->
        <h3 class="uc-bind-title"> 域名管理</h3>

        <div class="uc-bind">
            <!--步骤start-->
            <div class="step-box">
                <div class="step first <?php echo in_array($_check_info['step'], [1, 4, 5]) ? 'active' : '' ?>">
                    <div class="round">1</div>
                    <span class="step-word">设置个性域名</span>
                </div>
                <div class="step first <?php echo $_check_info['step'] == 2 ? 'active' : '' ?>">
                    <div class="round">2</div>
                    <span class="step-word">等待审核</span>
                </div>
                <div class="step last <?php echo $_check_info['step'] == 3 ? 'active' : '' ?>">
                    <div class="round">3</div>
                    <span class="step-word">审核通过</span>
                </div>
            </div>
            <!--步骤end-->
            <div class="uc-bind-form " id="subdomain_index">
                <div class="form-group">
                    <label class="form-label"><?php echo $_check_info['step'] == 1 ? '我的个人空间：' : '我的个性域名'?></label>
                    <label class="form-mobile-info">
                        <?php if (in_array($_check_info['step'], [1, 3, 5])): ?>
                            <a href="<?php echo 'http://' . $_check_info['my_domain'] ?>" target="_blank">
                                <?php echo $_check_info['my_domain'] ?>
                            </a>
                        <?php else: ?>
                            <?php echo $_check_info['my_domain'] ?>
                        <?php endif ?>
                    </label>
                    <?php if (!empty($_check_info['button'])): ?>
                        <span class="label label-orange"><i class=""></i> <? echo $_check_info['button'] ?></span>
                    <?php endif ?>
                </div>
                <?php if (in_array($_check_info['step'], [4, 5])): ?>
                    <div class="form-group">
                        <label class="form-label"><?php echo $_check_info['step'] == 4 ? '未通过原因' : '被重置原因' ?>：</label>
                        <label class="form-mobile-info"><?php echo isset($check['deny_reason']) ? $check['deny_reason'] : '' ?></label>
                    </div>
                <?php endif ?>
                <?php if (in_array($_check_info['step'], [1, 4, 5])): ?>
                    <div class="form-group form-group-btn">
                        <input class="btn btn-orange" id="apply_button" value="申请个性域名" onclick="" type="submit">
                    </div>
                <?php endif ?>
            </div>
        </div>

        <div class="uc-bind hide" id="subdomain_apply">
            <!--步骤start-->
            <div class="step-box">
                <div class="step first active">
                    <div class="round">1</div>
                    <span class="step-word">设置个性域名</span>
                </div>
                <div class="step first">
                    <div class="round">2</div>
                    <span class="step-word">等待审核</span>
                </div>
                <div class="step last">
                    <div class="round">3</div>
                    <span class="step-word">审核通过</span>
                </div>

            </div>
            <!--步骤end-->
            <form id="subdomain_form">
                <input value="" id="reflag" type="hidden">

                <div class="uc-bind-form">
                    <div class="form-group" style="padding-top: 25px;">
                        <label class="form-label">我的个性域名：</label>
                        <input name="subdomain" class="form-control" id="subdomain_input" value=""
                               placeholder="输入域名前缀" type="text" maxlength="15" style="width: 160px;" autocomplete="off">
                        <label class="form-label" style="margin-left: -20px;">.vsochina.com</label>
                    </div>
                    <div class="form-group">
                        <label class="form-label">&nbsp;</label>
                        <label style="color:#999;line-height: 36px;">域名长度为6~15个字符，可包含字母、数字、下划线，且不能以下划线开头或结尾。</label>
                    </div>
                    <div class="form-group">
                        <label class="form-label">&nbsp;</label>
                        <span class="role-upload j-role-upload">
                            <input type="checkbox" id="domain_checkbox" autocomplete="off"/>
                            <i class="mod-icon checkbox-select-little"></i>更改域名前请仔细阅读
                            <a target="_blank" href="http://www.vsochina.com/index.php?do=help&fpid=291">
                                《蓝海创意云子域名自助注册及使用规则》
                            </a>
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">&nbsp;</label>
                        <input class="btn btn-grey" id="button_cancel" value="取消" type="button">
                        <label class="form-label">&nbsp;</label>
                        <input class="btn btn-orange" id="button_submit" value="提交审核" type="button">
                    </div>
                </div>
            </form>
        </div>
        <div class="uc-bind-tip uc-rc-tip">
            <div class="subdomain-notice">
                <p class="uc-bind-tip-title"><b>提示：</b></p>

                <p class="uc-bind-tip-txt"> 1、域名仅支持更改一次；</p>

                <p class="uc-bind-tip-txt"> 2、域名不能少于6个字符，不能超过15个字符，只能包含“小写字母”、“数字”、“-”，且必须以“小写字母”开头，不能以“-”结尾；</p>

                <p class="uc-bind-tip-txt"> 3、已经被使用的域名是不能申请成功的；</p>

                <p class="uc-bind-tip-txt"> 4、相关网安词汇禁止注册；</p>

                <p class="uc-bind-tip-txt"> 5、涉及到相关非商品性品牌，行政区域名，著名城市地区名，专有词汇，著名网站等禁止注册；</p>

                <p class="uc-bind-tip-txt"> 6、相关驰名商标，以及受商标法约束的部分普通商标，禁止注册；</p>

                <p class="uc-bind-tip-txt"> 7、国内政治人物、事件名称禁止注册；</p>

                <p class="uc-bind-tip-txt"> 8、违背社会良俗的名称禁止注册；</p>

                <p class="uc-bind-tip-txt"> 9、域名所有者是蓝海创意云平台，蓝海创意云有权收回二级域名使用权，一般收回的情况包括但不限于：</p>

                <p class="uc-bind-tip-txt">
                    <?php echo str_repeat('&nbsp', 4); ?>
                    注册的域名涉及商标名。
                </p>

                <p class="uc-bind-tip-txt">
                    <?php echo str_repeat('&nbsp', 4); ?>
                    注册的域名涉及蓝海创意云知名会员的姓名拼音、英文用户名、中文用户名的拼音以及中文用户名的英文翻译。
                </p>

                <p class="uc-bind-tip-txt"> 10、二级域名的失效规则： 二级域名免费使用，只要平台子域名申请规则不变动并且符合域名注册使用规则，域名将一直存在。</p>

                <p style="font-weight: bold; padding-left: 20px;">
                    具体规则以
                    <a href="http://www.vsochina.com/index.php?do=help&fpid=291" target="_blank">
                        《蓝海创意云子域名自助注册及使用规则》
                    </a>
                    规定为准。请用户务必认真阅读并严格遵守。
                </p>
            </div>
        </div>

        <!--/content-->
    </div>
</div>

<style>
    .role-upload {
        line-height: normal;
    }

    .uc-bind-form .form-group {
        margin-bottom: 10px;
    }

    .subdomain-notice {
        margin: 10px;
        padding: 20px;
        border: 2px dashed #ccc;
        line-height:25px;
    }
</style>

<script>
    $("#apply_button").on('click', function () {
        $("#subdomain_index").hide();
        $("#subdomain_apply").show();
    });

    $("#button_cancel").on('click', function () {
        window.location.reload();
    });

    $("#button_submit").on('click', function () {
        var subdomain = $.trim($("input[name=subdomain]").val());
        if (!$("#domain_checkbox").is(':checked')) {
            showDialog('请仔细阅读并勾选《蓝海创意云子域名自助注册及使用规则》', 'notice', "操作提示");
            return false;
        }
        if (subdomain == '' || subdomain == undefined) {
            showDialog('输入不能为空', 'notice', "操作提示");
            return false;
        }

        var _url = '<?php echo yiiUrl('/ucenter/subdomain/ajax-add-check') ?>';
        _req(_url, {subdomain: subdomain}, 'POST', 'JSON', function (json) {
            if (json.code > 0) {
                showDialog(json.msg, 'notice', "提示信息", function () {
                    window.location.reload();
                });
            } else {
                showDialog(json.msg, 'notice', "操作提示");
            }
        });
    });

    /*
     * 同意规则点击效果
     */
    $(".j-role-upload").on("click", function () {
        if ($(this).hasClass("checked")) {
            $(this).removeClass("checked");
            $(this).find("input[type='checkbox']").removeAttr('checked');
        }
        else {
            $(this).addClass("checked").removeClass("nochecked");
            $(this).find("input[type='checkbox']").attr("checked", true);
        }
    });

</script>