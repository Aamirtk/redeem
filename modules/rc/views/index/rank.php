<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>排行榜·创意云·人才库</title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit"/>
    <!--reset.css  header.css  footer.css-->
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.2.0/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css?v=20150807"/>
    <link type="text/css" rel="stylesheet" href="http://www.vsochina.com/resource/mCustomScrollbar/jquery.mCustomScrollbar.min.css"/>
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.2.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="/css/rc_index.css">
    <link type="text/css" rel="stylesheet" href="/css/ranking.css"/>
    <link rel="stylesheet" type="text/css" href="/css/kkpager_blue.css" />
    <!--jquery-->
    <script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/libs/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/ranking.js"></script>
    <script type="text/javascript" src="/js/kkpager.min.js"></script>

    <!--cookie domain-->
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>

</head>
<body class="talent-gray-bg">
<!-- header -->
<script type="text/javascript" src="http://account.vsochina.com/static/js/vsoheader.js"></script>
<?php echo $_this_obj->renderPartial('//rc/index_header'); ?>

<!-- content -->
<div class="nav_wrap">
    <div class="recommend_center">
        <ul class="telent-navigater">
            <li class="nav_list default">
                <a href="javascript:;" class="telent-list">排行榜</a>
            </li>
            <li class="nav_list">
                <a href="<?php echo yii::$app->urlManager->createUrl(['rc/personal/weekly', 'w_id' => $_weekly_widget_id]) ?>" class="telent-list">创意周刊</a>
                <span style="position: absolute; top: 150px; display: none;">|</span>
            </li>
            <li class="nav_list">
                <a href="<?php echo yii::$app->urlManager->createUrl(['rc/personal/cover_story', 'w_id' => $_cover_story_widget_id]) ?>" class="telent-list">封面人物</a>
                <span style="position: absolute; top: 150px;">|</span>
            </li>
        </ul>
    </div>
</div>
<div class="nav-box">
<div id="tab_1" class="telent-content">
<div class="recommend_center">
<div class="con_left">
<ul class="tab-nav">
    <li><a style="color: #2281cb; border: 0;" href="http://rc.vsochina.com/rc/index/rank">总榜</a></li>
    <li><a href="http://rc.vsochina.com/rc/index/rank?industry=画师">画师榜</a></li>
    <li><a href="http://rc.vsochina.com/rc/index/rank?industry=CG">CG榜</a></li>
    <li><a href="http://rc.vsochina.com/rc/index/rank?industry=摄影">摄影榜</a></li>
    <li><a href="http://rc.vsochina.com/rc/index/rank?industry=UI设计">UI设计榜</a></li>
    <li><a href="http://rc.vsochina.com/rc/index/rank?industry=影视">影视榜</a></li>
    <li><a href="http://rc.vsochina.com/rc/index/rank?industry=游戏设计">游戏设计榜</a></li>
</ul>
<div class="tab-box-1">
    <?php
    $data = $rank['rc'];
    ?>
    <?php for ($i = 0;
    $i < count($data);
    $i++): ?>
    <?php
    $ran = $data[$i];
    $num = ($i + 1) + ($pno-1)*$pageSize;
    $colorNum = $num > 3 ? 4 : $num;
    ?>

    <div class="rank-box" id="rank<?= $num ?>">
        <div class="rank-character">
            <p class="numbox Tcolor<?= $colorNum ?>"><?= $num ?></p>
            <!--<img src="/images/rc/personal/rank/upper-icon.png"/>-->

            <p class="numbox vip"><a href="http://rc.vsochina.com/talent/<?= $ran['username'] ?>" target="_blank"  title="点击查看TA的空间"><img src="<?= $ran['avatar'] ?>" width="62" height="62"/></a> </p>
            <?php if( $ran['isvip'] ) {?><img class="vip-icons" src="/images/rc/personal/rank/vip-icon.png"/><?php }?>

            <p class="nickname"><a href="http://rc.vsochina.com/talent/<?= $ran['username'] ?>" target="_blank" title="点击查看TA的空间"><?= $ran['nickname'] ?></a></p>

            <p class="signiture"><?= $ran['signture'] ? $ran['signture'] : '这家伙太懒,什么也没写' ?></p>
        </div>
        <div class="sharebox">

            <a class="weibo" onclick="shareTSina('高大上！<?= $ran['username'] ?>的个人人才空间，来自蓝海创意云的创意人才。','http://rc.vsochina.com/enterprise/default/index/<?= $ran['username'] ?>', '蓝海创意云-一个云端的创客空间', '<?= $ran['avatar'] ?>')"></a>
            <a class="zoom" onclick="shareQzone('高大上！<?= $ran['username'] ?>的个人人才空间，来自蓝海创意云的创意人才。','http://rc.vsochina.com/enterprise/default/index/<?= $ran['username'] ?>', '蓝海创意云-一个云端的创客空间', '<?= $ran['avatar'] ?>')"></a>
            <a class="qq" onclick="shareQQ('高大上！<?= $ran['username'] ?>的个人人才空间，来自蓝海创意云的创意人才。','http://rc.vsochina.com/enterprise/default/index/<?= $ran['username'] ?>', '蓝海创意云-一个云端的创客空间', '<?= $ran['avatar'] ?>')"></a>
            <a class="weixin" onclick="shareWechat('<?= $ran['username'] ?>')">
                <div class="wx-erweima">
                    <div class="wx-triangle">
                        <span><em></em></span>
                    </div>
                    <div id="qrcode_<?= $ran['username'] ?>"></div>
                </div>
            </a>
        </div>
    </div>

    <?php if ($i == 0): ?>
    <div class="topinfo" style="display: block">
        <?php else: ?>
        <div class="topinfo">
            <?php endif; ?>
            <div class="infoleft">
                <?php
                //获取用户身份证号码
                if (isset($ran['idcard']) && !empty($ran['idcard']))
                {
                    $idCard = $ran['idcard'];
                }
                else
                {
                    $idCard = $ran['identity'];
                }
                if ($idCard)
                {
                    $birthDay = substr($idCard, 6, 8);
                    //从身份证号码中获取用户出生年代
                    $generatrion = substr($birthDay, 2, 1) == '' ? null : substr($birthDay, 2, 1);
                    //获取出生年月,计算星座
                    $month = (int)substr($birthDay, 4, 2);
                    $day = (int)substr($birthDay, 6, 2);
                    //星座信息
                    $constellation = getConstellation($month, $day);
                }
                $location = isset($ran['residency_name'])?$ran['residency_name']:$ran['residency'];
                //所在地区按逗号分隔为数组
                if (strlen($location) > 0)
                {
                    $tempLocationArray = explode(',', $location);
                    //数组首节为xxx市,说明地区为直辖市,直接使用城市名称
                    if (isset($tempLocationArray[0])&&strpos('市', $tempLocationArray[0]))
                    {
                        $location = $tempLocationArray[0];
                    }
                    else
                    {
                        //非直辖市使用数组第二节的城市名称数据
                        $location = isset($tempLocationArray[1])?$tempLocationArray[1]:[];
                        //去除最后一个'市'字,不包含'市'字的特殊城市名称不处理
                        if (isset($tempLocationArray[1])&&strpos($location, '市'))
                        {
                            $location = substr($location, 0, strpos($location, '市'));
                        }
                    }
                }
                $skill = $ran['skill_ids'];
                $city=  !empty($location) ? $location : '';
                $generatrion =  !empty($generatrion) ? $generatrion : '';
                $constellation =  !empty($constellation) ? $constellation : '';
                ?>
                <p class="brief">
                    <?=($city=='市辖区'?'':$city) ?><?=($city&&$generatrion) ? ' · ':''?><?= $generatrion ?><?= empty($generatrion)?'':'0后 ' ?><?= (!empty($generatrion)&&!empty($constellation)) ? ' · ':'' ?><?= $constellation ?>
                    <?php if ($ran['sex'] == '女'): ?>
                        <img src="/images/rc/personal/rank/sex.png"/>
                    <?php elseif ($ran['sex'] == '男'): ?>
                        <img src="/images/rc/personal/rank/sex-male.png"/>
                    <?php endif; ?>
                </p>

                <p class="cor1 mt5"><?php if (strlen($skill) > 0): ?><?= str_replace(',', '/', $skill) ?><?php endif; ?></p>

                <p class="cor2 mt5">粉丝：
                    <span class="allcount" id="fan_count_<?= $ran['id'] ?>"><?= $ran['focus_num'] ?></span>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;作品：
                    <span class="allcount"><?= $ran['work_count'] ?></span></p>

                <?php if (in_array($ran['username'], $favors)): ?>
                    <a class="refer concerns visited" href="javascript:void(0)" onclick="unfavor('<?= $ran['username'] ?>','<?= $ran['id'] ?>')">取消关注</a>
                <?php elseif (!empty($vso_uname)): ?>
                    <a href="javascript:void(0)" onclick="favor('<?= $ran['username'] ?>','<?= $ran['id'] ?>')" class="refer concerns" id="<?= $ran['username'] ?>">
                        &nbsp;&nbsp;加关注
                    </a>
                <?php
                else: ?>
                    <a href="<?= $loginUrl ?>" class="refer concerns" id="<?= $ran['username'] ?>">
                        &nbsp;&nbsp;加关注</a>
                <?php endif; ?>

                <!--                <a href="#" class="refer concerns">&nbsp;&nbsp;加关注</a>-->

                <?php if (empty($vso_uname)): ?>
                    <a href="<?= $loginUrl ?>" class="refer employed">&nbsp;&nbsp;直接雇佣</a>
                <?php else: ?>
                    <a href="javascript:void(0)" class="refer employed"
                       onclick="dxtender('<?= $ran['username'] ?>')">
                        &nbsp;&nbsp;直接雇佣</a>
                <?php endif; ?>

                <!--<a href="#" class="refer privateletter">&nbsp;&nbsp;私信</a>-->
            </div>
            <div class="inforight">
                <?php $ranWorks = $ran['work']['rc'];
                $j = 0;
                ?>
                <?php foreach ($ranWorks as $w): ?>
                    <?php if ($j < 3):
                            /**
                             * 作品图片修改为显示230尺寸的缩略图,不显示原图
                             */
                            $url = '/images/rc/index/nopic.jpg';
                            if (strpos($w['work_url'], "vsochina.com") === false || strpos($w['work_url'], ".gif") != false ) { //肯定是外联
                                $url = $w['work_url']; //外链方式
                            }else {
                                switch ($w['pic_or_video']) {
                                    case 1:
                                        $url = $w['work_url'];
                                        if ($url) {
                                            $urlArray = explode('.', $url);
                                            $ext = $urlArray[count($urlArray) - 1];
                                            $url = substr($url, 0, strlen($url) - (strlen($ext) + 1));
                                            $url = $url . '_230.' . $ext;
                                        } else {
                                            $url = '/images/rc/index/nopic.jpg';
                                        }
                                        break;
                                    case 2:
                                        $url = $w['cover_url'];
                                        if ($url) {
                                            $urlArray = explode('.', $url);
                                            $ext = $urlArray[count($urlArray) - 1];
                                            $url = substr($url, 0, strlen($url) - (strlen($ext) + 1));
                                            $url = $url . '_230.' . $ext;
                                        } else {
                                            $url = '/images/rc/index/nopic.jpg';
                                        }
                                        break;
                                    case 3:
                                        $url = '/images/rc/index/nopic.jpg';
                                        break;
                                    case 4:
                                        $url = $work['work_url'];
                                        if ($url) {
                                            $urlArray = explode('.', $url);
                                            $ext = $urlArray[count($urlArray) - 1];
                                            $url = substr($url, 0, strlen($url) - (strlen($ext) + 1));
                                            $url = $url . '_230.' . $ext;
                                        } else {
                                            $url = '/images/rc/index/nopic.jpg';
                                        }
                                        break;
                                    case 5:
                                        $url = $work['cover_url'];
                                        if ($url) {
                                            $urlArray = explode('.', $url);
                                            $ext = $urlArray[count($urlArray) - 1];
                                            $url = substr($url, 0, strlen($url) - (strlen($ext) + 1));
                                            $url = $url . '_230.' . $ext;
                                        } else {
                                            $url = '/images/rc/index/nopic.jpg';
                                        }
                                }
                            }
                        ?>
                        <div class="work-show">
                            <a href="http://www.vsochina.com/index.php?do=talent_detail&member_id=<?=$w['uid']?>&view=works&work_id=<?=$w['id']?>" target="_blank"><div class="table-cell"><img class="ws-imgs" src="<?= $url?$url:'/images/rc/index/nopic.jpg' ?>"/></div></a>
                        </div>
                        <?php $j++; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <?php endfor; ?>


        <!--<div class="rank-box" id="rank01">
            <div class="rank-character">
                <p class="numbox Tcolor1">01</p>
                <img src="/images/rc/personal/rank/upper-icon.png"/>

                <p class="numbox vip"><img src="/images/rc/personal/rank/portrait01.jpg"/></p>
                <img class="vip-icons" src="/images/rc/personal/rank/vip-icon.png"/>

                <p class="nickname">画师本命CP</p>

                <p class="signiture">漂亮妹子求勾搭，求约稿，求投食</p>
            </div>
            <div class="sharebox">
                <a class="weixin"></a>
                <a class="weibo"></a>
                <a class="zoom"></a>
                <a class="qq"></a>
				<a class="add"></a>
            </div>
			<div class="weixin-box" style="display: none;">
                            <div class="exp-triggle">
                                <span><em></em></span>
                            </div>
                            <img src="/images/erweima.png" />
                            <p style="color: #666;">创意云微信公众号</p>
                        </div>
        </div>
        <div class="topinfo" style="display: block">
            <div class="infoleft">
                <p class="brief">苏州&nbsp;·&nbsp;90后&nbsp;·&nbsp;金牛座<?php /**/ ?>
                    <img src="/images/rc/personal/rank/sex.png"/></p>

                <p class="cor1 mt5">原画师/插画师/UI设计</p>

                <p class="cor2 mt5">粉丝：
                    <span class="allcount" id="allcount_<? /*= $ran->id */ ?>">156499</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;作品：
                    <span class="allcount">485</span></p>
                <a href="#" class="refer concerns">&nbsp;&nbsp;加关注</a>
                <a href="#" class="refer employed">&nbsp;&nbsp;直接雇佣</a>
                <a href="#" class="refer privateletter">&nbsp;&nbsp;私信</a>
            </div>
            <div class="inforight">
                <img src="/images/rc/personal/rank/top1banner01.jpg"/>
                <img src="/images/rc/personal/rank/top1banner02.jpg"/>
                <img src="/images/rc/personal/rank/top1banner03.jpg"/>
            </div>
        </div>-->
        <div id="mainsrp-pager" style="margin-top: 15px; display: <?= count($rank['rc'])==0 ? 'none' : 'block' ?>">
            <div id="kkpager"></div>
        </div>
    </div>


</div>
<div class="con_right">
    <div class="_web_ad_" ad_data="{'b_id':11, 'row_num':2}">
        <a href="{link}" target="_blank">
            <img src="{img}" width="267"/>
        </a>
    </div>
    <!--<div class="rule-explain">
        <p class="rule-tit">排行榜规则说明</p>

        <p style="margin-top: 15px;">（1）榜单收录的MV为六周以内发行的官方MV，老歌新拍MV也可 以打榜。现场版、饭制版不参与打榜。</p>

        <p>（2）MV预告、MV花絮、网络翻唱视频、歌词剪辑版，不参与打榜。</p>

        <p>（3）同一首歌曲不同版本的MV均可以参与打榜，但如果对比两支MV，画面场景大同小异，则不重复打榜。</p>

        <p>（4）与音悦Tai有官方合作的纯影视画面剪辑的主题曲MV可参与打榜。</p>

        <p>（5）广告宣传片，公益歌曲，群星助阵某大型活动宣传类的MV，均不参与打榜。</p>

        <p>
            （6）如果唱片公司用录音室画面，演唱会画面，后台画面，巡演花絮等内容剪辑后作为某首歌曲的唯一官方MV，则可以作为正式MV参与打榜；但如果该歌曲有正式的MV，则录音室版本，演唱会花絮剪辑版本的MV不再参与打榜。</p>
    </div>-->
</div>
</div>
</div>
</div>
<script type="text/javascript">
    function getParameter(name) {
        var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r!=null) return unescape(r[2]); return null;
    }
    //init
    $(function(){
        var totalPage = 100;
        var totalRecords = 100;
        var pageNo = getParameter('pno');
        if(!pageNo){
            pageNo = 1;
        }
        <?php $currentUrl = 'http://rc.vsochina.com/rc/index/rank';?>

        //7条记录时显示分页控件
        if(10<totalRecords){
            //生成分页
            //有些参数是可选的，比如lang，若不传有默认值
            kkpager.generPageHtml({
                pno : pageNo,
                //总页码
                total : <?= $totalPage ?>,
                //总数据条数
                totalRecords : <?= $totalCount ?>,
                //链接前部
                hrefFormer : '<?php
                                if(stripos($currentUrl,'?pno'))
                                {
                                    echo preg_replace('/(&|\?)pno=[^&]+/', '', $currentUrl);
                                }
                                else{
                                    echo $currentUrl;
                                }
                                ?>',
                //链接尾部
                hrefLatter : '',
                getLink : function(n){
                    return this.hrefFormer + this.hrefLatter + "?pno="+n;
                }
            });
        }

    });

</script>
<script>
    function dxtender(obj_name)
    {
        if ('' == $.trim('<?=$vso_uname?>'))
        {
            window.location.href = '<?=$loginUrl?>';
        }
        $.ajax({
            url: "<?=yii::$app->params['rc_frontendurl']?>/rc/search/dxtender",
            dataType: 'json',
            data:{redirect:'<?=yii::$app->params['rc_frontendurl'].yii::$app->request->getUrl()?>'},
            success: function (res)
            {
                if ("1"===res.data.auth_status)
                {
                    window.location.href = "http://www.vsochina.com/index.php?do=task_dxtender&bid_username=" + obj_name;
                }
                else
                {
                    alert('您未通过企业认证，请认证通过后再发布雇佣项目！');
                }
            }
        });
    }

    /**
     * 分享到新浪微博
     * @param title
     * @param rLink
     * @param site
     * @param pic
     */
    function shareTSina(title, rLink, site, pic)
    {
        var top = window.screen.height / 2 - 250;
        var left = window.screen.width / 2 - 300;

        window.open("http://service.weibo.com/share/share.php?pic=" + encodeURIComponent(pic) + "&title=" +
            encodeURIComponent(title.replace(/&nbsp;/g, " ").replace(/<br \/>/g, " ")) + "&url=" + encodeURIComponent(rLink),
            "分享至新浪微博",
            "height=500,width=600,top=" + top + ",left=" + left + ",toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no");
    }

    /**
     * 分享到qq空间
     * @param title
     * @param rLink
     * @param summary
     * @param site
     * @param pic
     */
    function shareQzone(title, rLink, summary, site, pic)
    {
        var top = window.screen.height / 2 - 250;
        var left = window.screen.width / 2 - 300;
        window.open('http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?title=' +
        encodeURIComponent(title) + '&url=' + encodeURIComponent(rLink) + '&summary=' +
        encodeURIComponent(summary) + '&site=' + encodeURIComponent(site), '_blank', 'scrollbars=no,width=600,height=450,left=' + left + ',top=' + top + ',status=no,resizable=yes');

    }

    /**
     * 生成微信分享二维码
     * @param username
     */
    function shareWechat(username)
    {
        $("canvas").hide();
        $('#qrcode_' + username).html("");
        $('#qrcode_' + username).hide();
        $('#qrcode_' + username).qrcode({
            width: 200,
            height: 200,
            text: 'http://rc.vsochina.com/enterprise/default/index/' + username,
            correctLevel: 3,
            typeNumber: -1
        });
        $('#qrcode_' + username).show();
        $('.wx-triangle').show();
    }

    /**
     * 分享到qq好友
     * @param title
     * @param rLink
     * @param summary
     * @param site
     * @param pic
     */
    function shareQQ(title, rLink, summary, site, pic)
    {
        var top = window.screen.height / 2 - 300;
        var left = window.screen.width / 2 - 400;
        window.open('http://connect.qq.com/widget/shareqq/index.html?url=' + encodeURIComponent(rLink) + '&showcount=0&desc=' + encodeURIComponent(summary + '-' + title) + '&summary=' + encodeURIComponent(summary) + '&title=' + encodeURIComponent(title) + '&site=' + encodeURIComponent(site) + '&pics=' + pic, '_blank', 'scrollbars=no,width=800,height=600,left=' + left + ',top=' + top + ',status=no,resizable=yes');
    }

    /**
     * 加关注
     */
    function favor(obj_name, id)
    {
        if ('' == $.trim('<?=$vso_uname?>'))
        {
            window.location.href = '<?=$loginUrl?>';
        }
        $.ajax({
            url: "<?=yii::$app->params['rc_frontendurl']?>/rc/search/favor",
            dataType: 'json',
            data: {obj_name: obj_name, id: id,redirect:'<?=yii::$app->params['rc_frontendurl'].yii::$app->request->getUrl()?>'},
            success: function (data)
            {
                if (data.ret == 13380)
                {
                    $('#' + obj_name).removeAttr("onclick");
                    $('#' + obj_name).html("取消关注");
                    $('#' + obj_name).addClass("visited");
                    $('#' + obj_name).attr("onclick", "unfavor('" + obj_name + "','" + id + "')");
                    $('#fan_count_' + id).html(data.focus_num);
                }else if(data.ret===13381||data.ret===13382){
                        window.location.href='<?=$loginUrl?>';
                }
                else
                {
                    alert(data.message);
                }
            }
        });
    }


    /**
     * 取消关注
     * @param username
     * @param obj_name
     * @param id
     */
    function unfavor(obj_name, id)
    {
        if ('' == $.trim('<?=$vso_uname?>'))
        {
            window.location.href = '<?=$loginUrl?>';
        }
        $.ajax({
            url: "<?=yii::$app->params['rc_frontendurl']?>/rc/search/un-favor",
            dataType: 'json',
            data: {obj_name: obj_name, id: id,redirect:'<?=yii::$app->params['rc_frontendurl'].yii::$app->request->getUrl()?>'},
            success: function (data)
            {
                if (data.ret == 13400)
                {
                    $('#' + obj_name).removeAttr("onclick");
                    $('#' + obj_name).html("&nbsp;&nbsp;加关注");
                    $('#' + obj_name).removeClass("visited");
                    $('#' + obj_name).attr("onclick", "favor('" + obj_name + "','" + id + "')");
                    $('#fan_count_' + id).html(data.focus_num);
                }else if(data.ret===13381||data.ret===13382){
                        window.location.href='<?=$loginUrl?>';
                }
                else
                {
                    alert(data.message);
                }
            }
        });
    }

</script>
<script src="http://static.vsochina.com/libs/jquery.qrcode/1.0.0/jquery.qrcode.min.js"></script>
    <?php echo $_this_obj->renderPartial('//rc/index_footer'); ?>
</body>
</html>
<?php
function getConstellation($month, $day)
{
    if ($month < 1 || $month > 12 || $day < 1 || $day > 31)
    {
        return false;
    }
    $signs = array(array('20' => '宝瓶座'), array('19' => '双鱼座'), array('21' => '白羊座'), array('20' => '金牛座'), array('21' => '双子座'), array('22' => '巨蟹座'), array('23' => '狮子座'), array('23' => '处女座'), array('23' => '天秤座'), array('24' => '天蝎座'), array('22' => '射手座'), array('22' => '摩羯座'));
    list($start, $name) = each($signs[$month - 1]);
    if ($day < $start)
    {
        list($start, $name) = each($signs[($month - 2 < 0) ? 11 : $month - 2]);
    }
    return $name;
}

?>