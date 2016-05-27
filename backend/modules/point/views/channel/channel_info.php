<div id="channel_info_window" style="display: none;">
    <div id="channel_info_grid">
    </div>
</div>
<script>

    function showChannelsInfo(chid){
        $("body").data('BMask').show();
        $.ajax({
            type:"post",
            url : "<?= Yii::$app->urlManager->createUrl('point/channel/rules') ?>",
            data:{chid:chid},
            dataType:"json",
            success:function(json){
                $("body").data('BMask').hide();
                if(json.result){
                    var grid = $("#channel_info_grid").data("BGrid");
                    grid.get('store').setResult(json.channels);
                    $("#channel_info_window").data("BDialog").show();
                }
                else{
                    BUI.Message.Alert('获取信息失败', 'error');
                }
            }
        });
    }
    $(function(){
        BUI.use('bui/overlay',function(Overlay){
            var studioProjectsWindow = new Overlay.Dialog({
                title:'频道详情',
                width:500,
                mask:true,//模态
                buttons:[],
                contentId:"channel_info_window"
            });
            $("#channel_info_window").data("BDialog", studioProjectsWindow);
        });
    });
</script>