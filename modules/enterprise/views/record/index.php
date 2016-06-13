<script type="text/javascript">
    <?php require_once(Yii::getAlias('@frontend') . '/webrc/js/enterprise/generation.js') ?>
    $(function(){
        general_ctl.initCtl(1, 2, 1, "<?= $username?>");
        general_ctl.generalList();

        $(".comment_ent").on("click",function(){
            var _this = $(this),
                index = $(_this).index();;
            var container = $(".tab-box-new .tab-content").eq(index);
            //清空并调用获取评价列表信息
            $(".theme-table:visible").html("");

            var type = $(_this).attr("data-type");
            var mark_status = $(container).find(".checked").attr("data-status");
            general_ctl.initCtl(1, type, mark_status);
            general_ctl.generalList();
            $(".m-warp").show();
        });

        $(".ds-category-type").on("click",function(){
            //
            $(".theme-table:visible").html("");

            var type = $(".w-box-title .active").attr("data-type");
            var mark_status = $(this).find(".checkbox").attr("data-status");
            general_ctl.initCtl(1, type, mark_status);
            general_ctl.generalList();

            var checkbox = $(this).find("i.checkbox");
            $(this).parent().find(".ds-category-type i.checkbox").removeClass("checked");
            $(this).find("input").prop("checked",true);
            checkbox.addClass("checked");
        });

        $("#ent_record").addClass("active");
        $("#ent_record_index").addClass("active");
    });
</script>
<!--content-->
<?php require_once(Yii::getAlias('@frontend') . '/modules/enterprise/views/layout/header.php')?>

<div class="enterprise-info clearfix">
    <div class="m-warp">
        <h2 class="enterprise-info-title">
            <span>交易评价</span>
        </h2>

        <div class="w-evaluation-box">
            <div class="w-evaluation-box_1">
                <div class="w-evaluation-left">完成质量：</div>
                <div class="w-evaluation-conter">
                    <div class="w-barline w-orange-star-gray">
                        <div class="w-charts w-orange-star"></div>
                    </div>
                </div>
                <div class="w-evaluation-right">
                    <span class="w-evaluation_view"><?= $gen_eval['quality_view']?>/5</span>
                </div>
            </div>
            <div class="w-evaluation-box_1">
                <div class="w-evaluation-left">服务态度：</div>
                <div class="w-evaluation-conter">
                    <div class="w-barline w-red-hart-gray">
                        <div class="w-charts w-red-hart"></div>
                    </div>
                </div>
                <div class="w-evaluation-right">
                    <span class="w-evaluation_view"><?= $gen_eval['attitude_view']?>/5</span>
                </div>
            </div>
            <div class="w-evaluation-box_1 w300">
                <div class="w-evaluation-left">交易量：</div>
                <div class="w-evaluation-conter"><?= $gen_eval['trans_count']?></div>
                <div class="w-evaluation-right">笔</div>
            </div>

            <div class="w-evaluation-box_1">
                <div class="w-evaluation-left">工作速度：</div>
                <div class="w-evaluation-conter">
                    <div class="w-barline w-green-star-gray">
                        <div class="w-charts w-green-star"></div>
                    </div>
                </div>
                <div class="w-evaluation-right">
                    <span class="w-evaluation_view"><?= $gen_eval['speed_view']?>/5</span>
                </div>
            </div>
            <div class="w-evaluation-box_1">
                <div class="w-evaluation-left">好评率：</div>
                <div class="w-evaluation-conter">
                    <div class="w-barline w-red-star-gray">
                        <div class="w-charts w-red-star"></div>
                    </div>
                </div>
                <div class="w-evaluation-right">
                    <span class="w-evaluation_view"><?= $gen_eval['user_rate']?>/5</span>
                </div>
            </div>
            <div class="w-evaluation-box_1 w300">
                <div class="w-evaluation-left">交易额：</div>
                <div class="w-evaluation-conter">¥<?= number_format(round($gen_eval['trans_cash'],2),2)?></div>
                <div class="w-evaluation-right">元</div>
            </div>
        </div>

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
    </div>
</div>

<!--/content-->
<script type="text/javascript">
    $('.theme-table tr:odd').css("backgroundColor","#f7f8fa");
    $(".w-charts").each(function(){
        var precessBar = $(this).parents(".w-evaluation-conter").next(".w-evaluation-right").find(".w-evaluation_view").html().split("/");
        var _precessBar = precessBar[0] / precessBar[1]; //进度条的比例
        var startWidth = 18; //每颗星星的距离
        var startSpace = 10; //星星和星星的间距
        var scale = 1/5; //每隔星星占的比例
        var startInteger = precessBar[0].substr(0, 1);
        var startFloat = precessBar[0] - startInteger;
        //var thisWidth = Math.floor(_precessBar/scale) * (startWidth+startSpace) + startWidth * (Math.floor(_precessBar/scale) * scale);
        var thisWidth = startInteger * (startWidth + startSpace) + startFloat * startWidth;
        $(this).width(thisWidth);
    });
</script>

