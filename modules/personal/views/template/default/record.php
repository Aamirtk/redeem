<!--jquery-->
<script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
    <?php require_once(Yii::getAlias('@frontend') . '/webrc/js/template/record_temp.js') ?>
    <?php require_once(Yii::getAlias('@frontend') . '/webrc/js/template/generation_temp.js') ?>
    $(function(){
        /*交易记录 初始化*/
        record_ctl.initCtl(1, 1, "<?= $username?>");
        record_ctl.recordList();

        /*交易评价 初始化*/
        <!--
        general_ctl.initCtl(1, 2, 1, "<?= $username?>");
        general_ctl.generalList();
        -->
    });
</script>
<!--交易记录-->

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


<!--交易评价-->
<!--
<div class="theme-white-box">
    <ul class="w-box-title clearfix">
        <li class="comment_ent active" data-type="2" data-username="<?= $username?>"><a href="javascript:;">来自雇主的评价</a><b>|</b></li>
        <li class="comment_ent" data-type="1" data-username="<?= $username?>"><a href="javascript:;">来自雇员的评价</a></li>
    </ul>
    <div class="tab-box-new">
        <div class="tab-content" style="display: block;">
            <div class="tab-choice">
                            <span class="ds-category-type">
                                <i class="checkbox checked" data-status="1"><b></b></i>
                                <input type="radio" name="indus_name" checked value="好评">
                                <i class="icon-24 icon-24-favourable"></i>
                                好评
                            </span>
                            <span class="ds-category-type">
                                <i class="checkbox" data-status="2"><b></b></i>
                                <input type="radio" name="indus_name" value="中评">
                                <i class="icon-24 icon-24-rating"></i>
                                中评
                            </span>
                            <span class="ds-category-type">
                                <i class="checkbox" data-status="3"><b></b></i>
                                <input type="radio" name="indus_name" value="差评">
                                <i class="icon-24 icon-24-bad"></i>
                                差评
                            </span>
            </div>
            <table class="theme-table" id="general_list2">
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="tab-content" >
            <div class="tab-choice">
                <span class="ds-category-type">
                    <i class="checkbox checked" data-status="1"><b></b></i>
                    <input type="radio" name="indus_name" checked value="好评">
                    <i class="icon-24 icon-24-favourable"></i>
                    好评
                </span>
                <span class="ds-category-type">
                    <i class="checkbox" data-status="2"><b></b></i>
                    <input type="radio" name="indus_name" value="中评">
                    <i class="icon-24 icon-24-rating"></i>
                    中评
                </span>
                <span class="ds-category-type">
                    <i class="checkbox" data-status="3"><b></b></i>
                    <input type="radio" name="indus_name" value="差评">
                    <i class="icon-24 icon-24-bad"></i>
                    差评
                </span>
            </div>
            <table class="theme-table" id="general_list1">
                <tbody>
                </tbody>
            </table>
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
-->