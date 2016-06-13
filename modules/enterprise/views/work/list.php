<link type="text/css" rel="stylesheet" href="/css/rc_case.css">

<script type="text/javascript">
    <?php require_once(Yii::getAlias('@frontend') . '/webrc/js/enterprise/enterprise.js') ?>

    $(function(){
        ent_ctl.username = "<?= $username?>";
        ent_ctl.page = 1;
        ent_ctl.getList();
        $(".ins_type").click(function(){
            var type = $(this).attr("data-type");
            ent_ctl.type = type;
            ent_ctl.page = 1;
            ent_ctl.getList();
        });

        $(document).on("click", ".hotcase-list-tag", function(){
            var type = $(this).attr("data-type");
            ent_ctl.type = type;
            ent_ctl.page = 1;
            ent_ctl.getList();
        });

        $("#ent_case_list").addClass("active");
    });
</script>
<!--content-->
<?php require_once(Yii::getAlias('@frontend') . '/modules/enterprise/views/layout/header.php')?>

<div class="m-warp clearfix">
    <ul class="enterprise-tag-link pull-left ">
        <li class="tag-link-bg"><i class="icon-16 icon-16-tag"></i> 案例分类</li>
        <li class="ins_type" id="type_0" data-type="0"><a href="javascript:;">所有分类</a></li>
        <?php foreach($industryList as $key => $p):?>
            <li class="ins_type" id="type_<?= $p['industry']['id']?>" data-type="<?= $p['industry']['id']?>">
                <a href="javascript:;"><?= $p['industry']['name']?></a>
                <input type="hidden" id="ptype_<?= $p['industry']['id']?>" value="<?= $p['industry']['name']?>" />
            </li>
        <?php endforeach;?>
    </ul>
    <?php if($this->context->is_self):?>
    <a href="<?= yii::$app->urlManager->createUrl("/enterprise/work/create/" . $username);?>" class="btn btn-blue enterprise-case-upload"><span class="glyphicon glyphicon-cloud-download"></span>上传案例</a>
    <?php endif;?>
</div>

<div class="m-warp enterprise-case-list">
    <ul class="case-hotcase-list clear-float" id="main-case-list">
    </ul>
</div>

<div class="m-warp">
    <div id="mainsrp-pager">
        <div class="m-page g-clearfix mt0">
            <div class="wraper">
                <div class="inner clearfix pagelist">

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function confirmDeleteWork(id) {
        if(confirm("确定删除此案例？", ent_ctl.removeCase, id)){
        }
    }
</script>
<!--/content-->
