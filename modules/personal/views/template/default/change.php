<!--jquery-->
<script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
    <?php require_once(Yii::getAlias('@frontend') . '/webrc/js/template/common.js') ?>
    $(function(){
        $(".change-temp").click(function(){
            var type = $(this).val();
            template.change_template(type);
        });
    });
</script>
<input class="change-temp" type="button" value="test" />
<input class="change-temp" type="button" value="default" />
<div id="main"></div>