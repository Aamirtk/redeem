<!--jquery-->
<script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
    <?php require_once(Yii::getAlias('@frontend') . '/webrc/js/enterprise/record.js') ?>
    $(function(){
        record_ctl.recordList("<?= $username?>", "2");
        $("#load_more").on("click",function(){
            record_ctl.recordList("<?= $username?>", "2");
        });
    });
</script>
<input id="load_more" type="button" value="加载"/>
<div id="record_list"></div>