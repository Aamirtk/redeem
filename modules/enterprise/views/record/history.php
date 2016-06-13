<script type="text/javascript">
    <?php require_once(Yii::getAlias('@frontend') . '/webrc/js/enterprise/record.js') ?>
    $(function(){
        /*初始化*/
        record_ctl.initCtl(1, 1, "<?= $username?>");
        record_ctl.recordList();
        $(".record_ent").on("click",function(){
            var _this = $(this);

            //清空并调用获取评价列表信息
            $(".theme-table:visible tr").remove();

            /*初始化*/
            var type = $(_this).attr("data-type");
            record_ctl.initCtl(1, type);
            record_ctl.recordList();
        });

        $("#ent_record").addClass("active");
        $("#ent_record_history").addClass("active");
    });
</script>

<!--content-->
<?php require_once(Yii::getAlias('@frontend') . '/modules/enterprise/views/layout/header.php')?>

<div class="enterprise-info clearfix">
    <div class="m-warp">
        <h2 class="enterprise-info-title">
            <span>交易记录</span>
        </h2>

        <div class="theme-white-box">
            <ul class="w-box-title clearfix">
                <li class="record_ent active" data-type="1" data-username="<?= $username?>"><a href="javascript:;">我的中标</a><b>|</b></li>
                <li class="record_ent" data-type="2" data-username="<?= $username?>"><a href="javascript:;">我的雇佣</a></li>
            </ul>
            <div class="tab-box-new">
                <div class="tab-content" style="display: block;">
                    <table class="theme-table" id="record_list1">
                        <tr>
                            <th>雇主</th>
                            <th>任务</th>
                            <th>类型</th>
                            <th>收入</th>
                            <th>成交时间</th>
                        </tr>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="tab-content" >
                    <table class="theme-table" id="record_list2">
                        <tr>
                            <th>雇主</th>
                            <th>任务</th>
                            <th>类型</th>
                            <th>收入</th>
                            <th>成交时间</th>
                        </tr>
                        <tbody></tbody>
                    </table>
                </div>
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
        </div>


    </div>
</div>