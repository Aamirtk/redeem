        <div class="m-activity-box" >
            <?php $city = \backend\modules\content\models\Activity::getActivityCity()?>
            <?php foreach($activity as $k => $value):?>
            <ul class="m-activity-ul" id="city-<?=$k?>" style="display:none">
                <li class="first">
                    <a class="cur_city" >
                        当前城市：<span class="color-green"><?=$city[$k]?></span>
                    </a>
                </li>
                <?php foreach($value as $v):?>
                <li>
                    <a href="<?= $v['link']?>" class="clearfix">
                        <p class="m-activity-title"><?= $v['title']?> <i class="icon-bg <?php echo (empty($v['end_time'])||($v['end_time']>time()))?'hot':'end'?>"><?php echo (empty($v['end_time'])||($v['end_time']>time()))?'HOT':'END'?></i></p>
                        <div class="m-activity-img"><img src="<?= $v['banner']?>" alt="" ></div>
                        <div class="m-activity-info">
                            <p class="m-activity-content"><?= $v['desc']?></p>
                            <p class="m-activity-num"><span class="color-green"></span>
                                <span class="pull-right"><?= date('Y.m.d', $v['start_time']).(!empty($v['end_time'])?' - '.date('Y.m.d', $v['end_time']):'')?></span></p>
                        </div>
                    </a>
                </li>
                <?php endforeach;?>
            </ul>
            <?php endforeach;?>
        </div>


        <div class="fixed-window">
            <p class="fixed-window-title" >当前城市</p>
            <span class="address-btn">
                <i class="icon-locationfill"></i>
                <span id="cur_city"></span>
            </span>
            <br class="clear">
            <p class="fixed-window-title">热门城市</p>
            <a href="javascript:void(0)" class="address-btn">全国</a>
            <a href="javascript:void(0)" class="address-btn">苏州</a>
            <a href="javascript:void(0)" class="address-btn">北京</a>
            <a href="javascript:void(0)" class="address-btn">上海</a>
            <a href="javascript:void(0)" class="address-btn">广州</a>
            <a href="javascript:void(0)" class="address-btn">香港</a>
        </div>
        <script type="text/javascript">
            $(".m-activity-box").css("min-height",$(window).height()-390/750*$(window).width());

            $(".cur_city").on("click",function(){
                $(".fixed-window").show();
                $("body").css("overflow","hidden");
            });
            $(".fixed-window a").on("click",function(){
                var old_cur_city=$('#cur_city').html();
                var curcity = $(this).html();
                var cities=['全国','苏州','北京','上海','广州','香港'];
                var old_index=cities.indexOf(old_cur_city);
                var cindex=cities.indexOf(curcity);
                $('#city-'+old_index).hide();
                $('#city-'+cindex).show();
                $('#cur_city').html(curcity);
                $(".fixed-window").hide();
                $("body").css("overflow","auto");
            });
            $(".fixed-window").on("click",function(){
                $(".fixed-window").hide();
                $("body").css("overflow","auto");
            });
        </script>
        <script type="text/javascript">
        $(function(){
        //新浪IP取城市信息接口
        $.getScript('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js', function(_result) {
            var cities=['全国','苏州','北京','上海','广州','香港'];
            var cindex=cities.indexOf(remote_ip_info.city);
            if (remote_ip_info.ret == '1'&&cindex>-1) {
                $('#city-'+cindex).show();
                $('#cur_city').html(remote_ip_info.city);
            } else {
                $('#city-0').show();
                $('#cur_city').html('全国');
            }
        });
        })
</script>
