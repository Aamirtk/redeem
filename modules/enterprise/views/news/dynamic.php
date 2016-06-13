<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.all.js"></script>
<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
    <?php require_once(Yii::getAlias('@frontend') . '/webrc/js/enterprise/enterprise.js') ?>
    <?php require_once(Yii::getAlias('@frontend') . '/webrc/js/enterprise/news.js') ?>
    var umCompanyDesc = "";
    $(function(){
        $("#ent_dynamic").addClass("active");

        //实例化编辑器
        umCompanyDesc = UE.getEditor('edit_description_txt');
        umCompanyDesc.ready(function(){
            umCompanyDesc.setHide();
        });

        /**
         * 开始编辑简介
         * */
        $("#edit_description_btn").on("click",function(){
            $(this).hide();
            $("#edit_description_txt_show").hide();
            $(".edit-enterprise-btn-group").fadeIn();
            var edit_val = $("#edit_description_txt_show").html();
            umCompanyDesc.setContent(edit_val);
            $(".edui-editor").hide().slideDown(500,function(){
                umCompanyDesc.setShow();
                umCompanyDesc.focus(true);
            });
        });

        /**
        * 保存简介
        * */
        $("#save_description_btn").on("click",function(){
            var desc = umCompanyDesc.getContent();
            ent_ctl.editDesc("<?= $this->context->company['id'];?>", desc);
        });

        /**
        * 取消编辑简介
        * */
        $("#cancel_description_btn").on("click", function(){
            var old = $("#edit_description_txt_show").html();
            $(".edit-enterprise-btn-group").fadeOut(100,function(){
                $("#edit_description_btn").fadeIn(100);
            });
            $(".edui-editor").slideUp(200,function(){
                umCompanyDesc.setContent(old);
                umCompanyDesc.setHide();
                $("#edit_description_txt_show").show();
            });
        });

        /**
        * 删除新闻动态
        * */
        $(".enterprise-action-delete").on("click",function(){
            var _this = $(this);
            var id = _this.attr("data-id");
            if(confirm("确认要删除此新闻动态吗?",deleteNews, id)){
                deleteNews(id);
            }
        });
    });
    function deleteNews(id){
        news_ctl.removeNews(id);
    }
</script>

<!--content-->
<?php require_once(Yii::getAlias('@frontend') . '/modules/enterprise/views/layout/header.php')?>

<div class="enterprise-info clearfix">
    <div class="m-warp">
        <h2 class="enterprise-info-title">
            <span>新闻动态</span>
        </h2>
        <ul class="enterprise-info-list">
            <?php foreach($newslist as $key => $value): ?>
                <li id="news_<?= $value['id']?>"><b>●</b>　<a href="<?= yii::$app->urlManager->createUrl("enterprise-news-" . $value['id']) ;?>" target="_blank"><?= $value['title']?></a>
                <?php if($this->context->is_self):?>
                    <a class="pull-right enterprise-action-edit enterprise-action-delete" href="javascript:;" data-id="<?= $value['id']?>">删除</a>
                    <a class="pull-right enterprise-action-edit" href="<?= yii::$app->urlManager->createUrl("enterprise/news") . "/edit/" . $value['id'];?>">编辑</a>
                <?php endif?>
                </li>
            <?php endforeach;?>
        </ul>
        <?php if($this->context->is_self):?>
            <a href="<?= yii::$app->urlManager->createUrl("enterprise/news") . "/add/" . $username;?>" class="enterprise-blue"> + 新增动态</a>
        <?php endif?>
    </div>
    <div class="m-warp">
        <h2 class="enterprise-info-title">
            <span>企业简介</span>
        </h2>
        <div id="edit_description_txt_show"><?= $this->context->company['description']?></div>
        <?php if($this->context->is_self):?>
            <script type="text/plain" id="edit_description_txt" name="edit_description_txt" style="width: 100%; height: 250px;"></script>
            <div class="edit-enterprise-btn-group">
                <input id="cancel_description_btn" type="button" value="取消" class="btn btn-default">
                <input id="save_description_btn" type="button" value="保存" class="btn btn-blue">
            </div>
            <a href="javascript:;" class="enterprise-blue" id="edit_description_btn"><?php if(empty($this->context->company['description'])):?> + 新增简介<?php else:?> - 编辑简介<?php endif;?></a>
        <?php endif?>
    </div>
</div>

