<link type="text/css" rel="stylesheet" href="/css/rc_case.css" />
<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.all.js"></script>
<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/lang/zh-cn/zh-cn.js"></script>

<script type="text/javascript">
    <?php require_once(Yii::getAlias('@frontend') . '/webrc/js/enterprise/news.js'); ?>
    $(function(){
        var umCompanyDesc = UE.getEditor('edit_news_txt');
        umCompanyDesc.ready(function(){
            umCompanyDesc.setShow();
            setContent(umCompanyDesc, <?= json_encode(['content' => $model['content']])?>);
        });
        $("#save_description_btn").on("click",function(){
            var title = $("#news_title").val();
            var content = umCompanyDesc.getContent();
            <?php if(isset($model)):?>
            news_ctl.editNews("<?= $model['id']?>", title, content);
            <?php else:?>
            news_ctl.addNews("<?= $this->context->company['id']?>", title, content);
            <?php endif;?>
        });
        $("#cancel_description_btn").on("click",function(){
            location.href = "<?php echo yii::$app->urlManager->createUrl('/enterprise/news/dynamic/' . $this->context->company['username']);?>";
        });
    });
    function setContent(uEdit,data){
        var content = data.content.replace(/\\r\\n/g,'\\n');
        uEdit.setContent(content);
    }
</script>

<!--banner-->
<?php require_once(Yii::getAlias('@frontend') . '/modules/enterprise/views/layout/banner.php')?>
<!--/banner-->

<!--topnav-->
<div class="dynamic-news case-top clear-float">
    <ul class="case-top-nav">
        <li>
            <a href="http://rc.vsochina.com/">
                <i class="icon-12 icon-12-home"></i>
                <span>人才库首页</span>
            </a>
        </li>
        <li>
            <a href="<?= yii::$app->urlManager->createUrl("enterprise");?>">
                <i class="top-nav-space">/</i>
                <span><?= $this->context->company['name']?></span></a>
        </li>
        <li>
            <a href="<?= ($model['obj_type'] == "site") ? 'javascript:void(0);' : yii::$app->urlManager->createUrl("/enterprise-news");?>">
                <i class="top-nav-space">/</i>
                <span>新闻·简介</span>
            </a>
        </li>
        <li class="cur">
            <a href="javascirpt:void(0);">
                <i class="top-nav-space">/</i>
                <span>
                    <?php if(isset($model)):?>
                        修改
                    <?php else:?>
                        新增
                    <?php endif;?>
                </span>
            </a>
        </li>
    </ul>
    <div class="case-top-title">
        <span>新闻动态</span>
    </div>
</div>
<!--/topnav-->
<!--content-->
<div class="dynamic-news case-content">
    <input type="hidden" id="news_id" value="<?= $model['id']?>">
    <div class="case-content-top clear-float">
        <div class="case-content-title">
            <label for="" class="col-xs-1">标题：</label>
            <div class="col-xs-11">
                <input type="text" class="form-control" id="news_title" placeholder="例如：2015年10月，阿里巴巴集团接管中国雅虎" value="<?= $model['title']?>">
            </div>

        </div>
    </div>
    <div class="case-content-mainpart">
        <div class="content-mainpart-detail">
            <script type="text/plain" id="edit_news_txt" name="edit_news_txt" style="width: 100%; height: 350px;"></script>

            <div class="edit-enterprise-btn-group" style="display: block;">
                <input id="cancel_description_btn" type="button" value="取消" class="btn btn-default">
                <input id="save_description_btn" type="button" value="保存" class="btn btn-blue">
            </div>
        </div>
    </div>
</div>
<!--/content-->
