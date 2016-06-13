<?php
use yii\widgets\LinkPager;
use common\models\CommonIndustry;
use frontend\modules\project\models\Project;
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <title>创客空间我的项目</title>
    <meta name="keywords" content="创客空间我的项目">
    <meta name="description" content="创客空间我的项目">
    <meta content="uJnvSJU9WW" name="baidu-site-verification">
    <link type="text/css" rel="stylesheet" href="http://www.vsochina.com/resource/css/base.css"/>
    <!--reset.css  header.css  footer.css-->
    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css?t=20150810"/>
    <!--.css-->
    <link rel="stylesheet" type="text/css" href="/css/dreamSpace.css"/>
    <link type="text/css" rel="stylesheet" href="/css/detail-model.css"/>
    <script type="text/javascript" src="http://www.vsochina.com/resource/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/jquery.validate.js"></script>
</head>
<body>
    <!--头部-->
    <script type="text/javascript" charset="utf-8" src="http://account.vsochina.com/static/js/vsoheader.js"></script>
    <?php require_once(Yii::getAlias('@frontend') . '/web/layout/header.php') ?>
    <!--/头部-->
    <div class="myproject-wrap">
        <div class="myproject-box">
            <a target="_blank" class="myproject-new" href="/project/default/create">
                <i class="icon-add icon-14"></i>
                创建新项目申请
            </a>
            <div class="myproject-tab">
                <ul class="myproject-tab-nav">
                    <li<?php if($type=='all'):?> class="active"<?php endif;?>><a href="/project/default/my-project?type=all">所有项目</a></li>
                    <li<?php if($type=='wait'):?> class="active"<?php endif;?>><a href="/project/default/my-project?type=wait">审核中</a></li>
                    <li<?php if($type=='pass'):?> class="active"<?php endif;?>><a href="/project/default/my-project?type=pass">已通过审核</a></li>
                    <li<?php if($type=='not_pass'):?> class="active"<?php endif;?>><a href="/project/default/my-project?type=not_pass">未通过审核</a></li>
                </ul>
                <div class="myproject-tab-box">
                    <div class="myproject-tab-content" style="display: block;">
                        <table class="myproject-prolist">
                            <thead>
                                <tr>
                                    <th class="w15"></th>
                                    <th class="w425">项目名称</th>
                                    <th class="w145">项目编号</th>
                                    <th class="w180">行业分类</th>
                                    <th class="w140">入驻时间</th>
                                    <th class="w180">当前状态</th>
                                    <th class="w100">操作</th>
                                    <th class="w15"></th>
                                </tr>
                            </thead>
                            <?php if(count($projects) > 0):?>
                            <tbody>
                                <?php foreach($projects as $k => $v):?>
                                <tr>
                                    <td class="w15 bn"></td>
                                    <td class="ta-l">
                                        <?php if ($v['proj_status'] == Project::STATUS_PASS):?>
                                        <a target="_blank" href="/project/default/view?id=<?= $v['proj_id'] ?>" class="proname-img">
                                            <img src="<?= $v['proj_thumb'] ?>" alt="<?= $v['proj_name'] ?>">
                                        </a>
                                        <a target="_blank" href="/project/default/view?id=<?= $v['proj_id'] ?>" class="proname-text">《<?= $v['proj_name'] ?>》</a>
                                        <?php else:?>
                                        <a href="javascript:;" class="proname-img">
                                            <img src="<?= $v['proj_thumb'] ?>" alt="<?= $v['proj_name'] ?>">
                                        </a>
                                        <a href="javascript:;" class="proname-text">《<?= $v['proj_name'] ?>》</a>
                                        <?php endif;?>
                                    </td>
                                    <td><?= $v['proj_id'] ?></td>
                                    <td><?= CommonIndustry::getIndusName($v['indus_pid']) ?></td>
                                    <td><?php if($v['created_at']):?><?= date('Y-m-d H:i:s', $v['created_at']) ?><?php endif;?></td>
                                    <td><span class="prolist-<?= $v['proj_status'] ?>"><?= Project::getProjStatusArr($v['proj_status']) ?></span></td>
                                    <td class="prolist-operate">
                                        <?php if ($v['proj_status'] == Project::STATUS_PASS):?>
                                        <a target="_blank" href="/project/default/view?id=<?= $v['proj_id'] ?>" class="op-green">查看</a>
                                        <?php endif;?>
                                        <a target="_blank" href="/project/default/update?id=<?= $v['proj_id'] ?>" class="op-green">编辑</a>
                                        <a href="javascript:void(0);" class="op-red" onclick="confirmDeleteProj(<?= $v['proj_id'] ?>)">删除</a>
                                    </td>
                                    <td class="w15 bn"></td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                            <?php endif;?>
                        </table>
                        <div class="page">
                            <?= LinkPager::widget(['pagination' => $pages]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--尾部-->
    <?php require_once(Yii::getAlias('@frontend') . '/web/layout/footer.php') ?>
    <!--/尾部-->
    <script type="text/javascript" src="/js/dreamSpace.js"></script>
    <script type="text/javascript">
        ;(function ($) {
            var defaults = {
                action: "click",
                container: ".tab-box .tab-content"
            };
            //创建对象
            $.fn.Tab = function (options) {
                var options = $.extend(defaults, options || {});
                return this.each(function () {
                    var tabAction = getAction(defaults.action);
                    var container = options.container;
                    var _this = this;
                    if (tabAction == "onmousemove") {
                        this.onmousemove = function () {
                            var index = $(_this).index();
                            tabSwitch(_this, index, container);
                        }
                    }
                    if (tabAction == "onclick") {
                        this.onclick = function () {
                            var index = $(_this).index();
                            tabSwitch(_this, index, container);
                        }
                    }
                });
            };
            //tab切换方法
            var tabSwitch = function (_this, index, container) {
                $(_this).addClass("active").siblings().removeClass("active");
                $(container).eq(index).show().siblings().hide();
            };
            //获得某些参数的方法
            function getAction(action) {
                var tabAction;
                switch (action) {
                    case "click":
                        tabAction = "onclick";
                        break;
                    case "hover":
                        tabAction = "onmousemove";
                        break;
                }
                return tabAction;
            };
        })(jQuery);

        function confirmDeleteProj(proj_id) {
            var username = getCookie('vso_uname');
            if (username == '') {
                alert("请登录后再进行此操作");
                return false;
            }
            if(confirm("确定删除此项目？")) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    async: false,
                    url: "/project/default/delete?id=" + proj_id,
                    success: function (json) {
                        alert(json.msg);
                        if (json.result) {
                            window.location.reload();
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>