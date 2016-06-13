<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>搜索<?= isset($search['keyword']) ? $search['keyword'] : '' ?>_人才库_创意云</title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit"/>
    <!--reset.css  header.css  footer.css-->
    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css?v=20150807"/>
    <!--css-->
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/rc_index.css">
    <link rel="stylesheet" type="text/css" href="/css/kkpager_blue.css"/>
    <!--jquery-->
    <script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/kkpager.min.js"></script>
    <!--cookie domain-->
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
</head>

<body class="talent-gray-bg">
<!--header-->
<script type="text/javascript" src="http://account.vsochina.com/static/js/vsoheader.js"></script>
<?php echo $_this_obj->renderPartial('//rc/index_header', $search); ?>
<!--/header-->
<!--crumb-->
<ul class="talent-crumb clearfix">
    <li class="talent-crumb-whole">全部</li>
    <li class="talent-crumb-subclass clearfix">
        <i class="icon-gt">&gt;</i>
        <?php if ($search['indus_id']) { ?>
            <div class="crumb-subclass-item">
                <?= $search['p_indus']['name'] ?>
                <a href="<?= $search['p_indus_url'] ?>" class="icon-7 icon-7-close"></a>
            </div>
        <?php } ?>
    </li>
    <?php if ($search['indus_id'] && !$search['isIndusRoot']) { ?>
        <li class="talent-crumb-subclass clearfix">
            <i class="icon-gt">&gt;</i>

            <div class="crumb-subclass-item">
                <?= $search['s_indus_name'] ?>
                <a href="<?= $search['s_indus_url'] ?>" class="icon-7 icon-7-close"></a>
            </div>
        </li>
    <?php } ?>
    <li class="talent-crumb-search">
        <?= $search['keyword'] ?>
        <i class="icon-14 icon-14-search"></i>
    </li>
    <li class="talent-crumb-msg">
        本次共搜到<span class="crumb-msg-num"><?= $search['totalCount']?></span>相关需求
    </li>
</ul>
<!--/crumb-->
<!--content-->
<div class="talent-content">
    <div class="m-warp clearfix">
        <div class="col-xs-9">
            <div class="row">
                <div class="talent-search-area clearfix">
                    <span>行业分类：</span>
                    <ul class="talent-search-area-ul">
                        <?= $search['industries'] ?>
                    </ul>
                </div>
                <div class="talent-search-area clearfix">
                    <span for="">人才类型：</span>
                    <ul class="talent-search-area-ul">
                        <?= $search['user_type_li'] ?>
                    </ul>
                </div>
            </div>
            <div class="talent-list-sort clearfix">
                <?= $search['orderby_li'] ?>
                <span class="serach-page-pull-right">
                        <?= $search['topPage_li'] ?>
                    </span>
                <div class="pull-right location">
                    <?= $residency ? $residency : '所在地' ?><span class="glyphicon glyphicon-menu-down"></span>

                    <div class="location-section">
                        <?= $provinces ?>
                    </div>
                </div>
            </div>
            <div class="list-bar">
                <?php if (!empty($talents['rc'])) { ?>
                    <?php foreach ($talents['rc'] as $talent) { ?>
                        <div class="talent-list clearfix ">
                            <dl class="talent-list-dl">
                                <dt>
                                    <a target="_blank" href="/talent/<?= $talent['username'] ?>"><img
                                            src="<?= $talent['avatar'] ? $talent['avatar'] : 'http://static.vsochina.com//data/avatar/default/man_middle.jpg' ?>"
                                            alt="" width="100" height="100">
                                        <!--                                    <i class="icon-16 icon-16-vip"></i>-->
                                    </a>
                                </dt>
                                <dd class="talent-list-name"><a target="_blank"
                                                                href="/talent/<?= $talent['username'] ?>"><?= $talent['nickname'] ?></a>
                                </dd>
                                <dd class="talent-list-classify"> <?= $talent['user_type'] == 2 ? '企业' : '个人' ?></dd>
                                <dd class="talent-list-btn">

                                    <?php if (in_array($talent['username'], $favors)) { ?>
                                        <a href="javascript:void(0)" class="btn btn-darkgrey"
                                           id="<?= $talent['username'] ?>"
                                           onclick="unfavor('<?= $talent['username'] ?>','<?= $talent['id'] ?>')">
                                            <span class="glyphicon glyphicon-ok"></span> 取消关注</a>
                                    <?php } elseif (!empty($vso_uname)) { ?>
                                        <a href="javascript:void(0)"
                                           onclick="favor('<?= $talent['username'] ?>','<?= $talent['id'] ?>')"
                                           class="btn btn-darkgrey" id="<?= $talent['username'] ?>">
                                            <span class="glyphicon glyphicon-plus"></span> 加关注</a>
                                    <?php } else { ?>
                                        <a href="<?= $loginUrl ?>" class="btn btn-darkgrey"
                                           id="<?= $talent['username'] ?>">
                                            <span class="glyphicon glyphicon-plus"></span> 加关注</a>
                                    <?php } ?>
                                    <?php if (empty($vso_uname)) { ?>
                                        <a href="<?= $loginUrl ?>" class="btn btn-blue"><i
                                                class="icon-16 icon-16-peoples"></i>直接雇佣</a>
                                    <?php } else { ?>
                                        <a href="javascript:void(0)" onclick="dxtender('<?= $talent['username'] ?>')"
                                           class="btn btn-blue"><i class="icon-16 icon-16-peoples"></i>直接雇佣</a>
                                    <?php } ?>
                                </dd>
                            </dl>
                            <?php if (!empty($talent['work']['rc'])) {
                                $i = 0;
                                foreach ($talent['work']['rc'] as $work) {
                                    if (!$work['url']) continue;
                                    $ext = strtolower(pathinfo( $work['url'], PATHINFO_EXTENSION));
                                    if(!in_array($ext,['jpg','gif','jpeg','png','bmp'])){
                                        continue;
                                    }

                                    if(strpos($work['url'],"http") === false && '/images/rc/index/nopic.jpg'!=$work['url']){
                                        $work['url'] = 'http://static.vsochina.com/'. $work['url'];
                                    }
                                    ?>
                                    <a href="http://www.vsochina.com/index.php?do=talent_detail&member_id=<?= $work['uid'] ?>&view=works&work_id=<?= $work['id'] ?>"
                                       class="talent-list-case" target="_blank">
                                        <div class="table-cell">
                                            <div class="w-230">
                                                <img src="<?= $work['url'] ?>">
                                            </div>
                                        </div>
                                    </a>

                                    <?php $i++;
                                    if ($i == 3) break;
                                }
                            } else { ?>
                                <div class="talent-list-nopic">
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="no-result"><img src="/images/rc/index/no-result.png" alt=""><span>亲，没有找到相关的人才，或许您可以尝试下其他搜索条件哦~</span>
                    </div>
                <?php } ?>
            </div>
            <div id="mainsrp-pager">
                <div id="kkpager"></div>
            </div>
            <div class="talent-other">
                <span>你是不是想找</span>
                    <span class="_web_ad_" ad_data="{'b_id':7, 'row_num':8}">
                    <a href="<?= yii::$app->params['rc_frontendurl'] ?>/rc/search?keyword={word}"
                       class="active">{word}</a>
                    </span>
            </div>
            <h2 class="official-recommend">官方推荐</h2>

            <div class="list-block-new clearfix ">
                <?php
                $j = 0;
                foreach ($talents['rec_users'] as $rc_user) {
                    if (5 < $j) {
                        break;
                    }
                    ?>

                    <div class="talent-list-block">
                        <?php
                        if (!empty($rc_user['work']['rc'])) {
                            foreach ($rc_user['work']['rc'] as $value) {
                                if(!$value['url']) continue;
                                if(strpos($value['url'],"http") === false && '/images/rc/index/nopic.jpg'!=$work['url']  ){
                                    $value['url'] = 'http://static.vsochina.com/'. $value['url'];
                                }
                                ?>
                                <a href="http://www.vsochina.com/index.php?do=talent_detail&member_id=<?= $value['uid'] ?>&view=works&work_id=<?= $value['id'] ?>"
                                   target="_blank"><img src="<?= $value['url'] ?>" alt="" width="290" height="180">
                                </a>
                                <?php
                                break;
                            }
                        } else {
                            ?>
                            <a href="/talent/<?= $rc_user['username'] ?>" target="_blank">
                                <img src="/images/rc/index/nopic.jpg" alt="<?= $rc_user['username'] ?>" width="290"
                                     height="180">
                            </a>
                        <?php } ?>
                        <dl class="talent-list-block-dl">
                            <dt>
                                <a href="/talent/<?= $rc_user['username'] ?>" target="_blank"><img
                                        src="<?= $rc_user['avatar'] ?>" alt="">
                                    <!--                                    <i class="icon-16 icon-16-vip"></i>-->
                                </a>
                            </dt>
                            <dd class="talent-list-name"
                                title="<?= $rc_user['nickname'] ?>"><?= $rc_user['nickname'] ?></dd>
                            <dd class="talent-list-classify"><?= $rc_user['user_type'] == 2 ? '企业' : '个人' ?></dd>
                            <dd class="talent-list-btn">
                                <?php if (in_array($rc_user['username'], $favors)) { ?>
                                    <a href="javascript:void(0)" class="btn btn-darkgrey"
                                       id="<?= $rc_user['username'] ?>"
                                       onclick="unfavor('<?= $rc_user['username'] ?>','<?= $rc_user['id'] ?>')">
                                        <span class="glyphicon glyphicon-ok"></span> 取消关注</a>

                                <?php } elseif (!empty($vso_uname)) { ?>
                                    <a href="javascript:void(0)"
                                       onclick="favor('<?= $rc_user['username'] ?>','<?= $rc_user['id'] ?>')"
                                       class="btn btn-darkgrey" id="<?= $rc_user['username'] ?>">
                                        <span class="glyphicon glyphicon-plus"></span> 加关注</a>
                                <?php } else { ?>
                                    <a href="<?= $loginUrl ?>" class="btn btn-darkgrey"
                                       id="<?= $rc_user['username'] ?>">
                                        <span class="glyphicon glyphicon-plus"></span> 加关注</a>
                                <?php } ?>
                                <?php if (empty($vso_uname)) { ?>
                                    <a href="<?= $loginUrl ?>" class="btn btn-blue"><i
                                            class="icon-16 icon-16-peoples"></i>
                                        直接雇佣</a>
                                <?php } else { ?>
                                    <a href="javascript:void(0)" onclick="dxtender('<?= $rc_user['username'] ?>')"
                                       class="btn btn-blue"><i class="icon-16 icon-16-peoples"></i>
                                        直接雇佣</a>
                                <?php } ?>
                            </dd>
                        </dl>
                    </div>
                    <?php $j++;
                } ?>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="row">
                <?= $search['rightBannerLi'] ?>
            </div>
        </div>
    </div>
</div>
<!--footer-->
<!--add experience-->
<script type="text/javascript" src="http://account.vsochina.com/static/js/experience.js?v=1"></script>
<script>
    function favor(obj_name, id) {
        if ('' === $.trim('<?=$vso_uname?>')) {
            window.location.href = '<?=$loginUrl?>';
        }
        $.ajax({
            url: "<?=yii::$app->params['rc_frontendurl']?>/rc/search/favor",
            dataType: 'json',
            data: {obj_name: obj_name, id: id, redirect: '<?=yii::$app->params['rc_frontendurl'].$currentUrl?>'},
            success: function (data) {
                if (data.ret === 13380) {
                    $('#' + obj_name).removeAttr("onclick");
                    $('#' + obj_name).html("<span class='glyphicon glyphicon-ok'></span> 取消关注");
                    $('#' + obj_name).attr("onclick", "unfavor('" + obj_name + "','" + id + "')");
                    $('.focus_num' + obj_name).html(data.focus_num);
                } else if (data.ret === 13381 || data.ret === 13382) {
                    window.location.href = '<?=$loginUrl?>';
                } else {
                    alert(data.message);
                }
            }
        });
    }
    function unfavor(obj_name, id) {
        if ('' === $.trim('<?=$vso_uname?>')) {
            window.location.href = '<?=$loginUrl?>';
        }
        $.ajax({
            url: "<?=yii::$app->params['rc_frontendurl']?>/rc/search/un-favor",
            dataType: 'json',
            data: {obj_name: obj_name, id: id, redirect: '<?=yii::$app->params['rc_frontendurl'].$currentUrl?>'},
            success: function (data) {
                if (data.ret === 13400) {
                    $('#' + obj_name).removeAttr("onclick");
                    $('#' + obj_name).html("<span class='glyphicon glyphicon-ok'></span> 加关注");
                    $('#' + obj_name).attr("onclick", "favor('" + obj_name + "','" + id + "')");
                    $('.focus_num' + obj_name).html(data.focus_num);
                } else if (data.ret === 13381 || data.ret === 13382) {
                    window.location.href = '<?=$loginUrl?>';
                } else {
                    alert(data.message);
                }
            }
        });
    }
    function dxtender(obj_name) {
        if ('' === $.trim('<?=$vso_uname?>')) {
            window.location.href = '<?=$loginUrl?>';
        }
        $.ajax({
            url: "<?=yii::$app->params['rc_frontendurl']?>/rc/search/dxtender",
            dataType: 'json',
            data: {redirect: '<?=yii::$app->params['rc_frontendurl'].$currentUrl?>'},
            success: function (res) {
                if ("1" === res.data.auth_status) {
                    window.location.href = "http://www.vsochina.com/index.php?do=task_dxtender&bid_username=" + obj_name;
                } else {
                    alert('您未通过企业认证，请认证通过后再发布雇佣项目！');
                }
            }
        });
    }
    function getParameter(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r != null) return unescape(r[2]);
        return null;
    }
    //init
    $(function () {
        var totalPage = <?=$search['totalPage']?>;
        var totalRecords = <?=$search['totalCount']?>;
        var pageNo = getParameter('pno');
        if (!pageNo) {
            pageNo = 1;
        }
        //7条记录时显示分页控件
        if (7 < totalRecords) {
            //生成分页
            //有些参数是可选的，比如lang，若不传有默认值
            kkpager.generPageHtml({
                pno: pageNo,
                //总页码
                total: totalPage,
                //总数据条数
                totalRecords: totalRecords,
                //链接前部
                hrefFormer: '<?php
                                if(stripos($currentUrl,'&pno'))
                                {
                                    echo preg_replace('/(&|\?)pno=[^&]+/', '', $currentUrl);
                                }
                                else{
                                    echo $currentUrl;
                                }
                                ?>',
                //链接尾部
                hrefLatter: '',
                getLink: function (n) {
                    return this.hrefFormer + this.hrefLatter + "&pno=" + n;
                }
            });
        }

    });
    $(".location").hover(function () {
        $(this).addClass("location-hover");
    }, function () {
        $(this).removeClass("location-hover");
    });
</script>
<?php echo $_this_obj->renderPartial('//rc/index_footer'); ?>
</body>
</html>
