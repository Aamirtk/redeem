<script>
    //防止百度收录
    var oMeta = document.createElement('meta');
    oMeta.name='robots';
    oMeta.content='noindex,nofollow';
    document.getElementsByTagName('head')[0].appendChild(oMeta);
</script>
<div class="theme-white-box">
    <p class="w-box-title">交易评价</p>
    <div class="w-evaluation-box">
        <div class="w-evaluation-box_1">
            <div class="w-evaluation-left">完成质量：</div>
            <div class="w-evaluation-conter">
                <div class="w-barline w-orange-star-gray">
                    <div class="w-charts w-orange-star"></div>
                </div>
            </div>
            <div class="w-evaluation-right">
                <span class="w-evaluation_view"><?= isset($eval['quality_view'])?$eval['quality_view']:5.0 ?>/5</span>
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
                <span class="w-evaluation_view"><?= isset($eval['user_rate'])?$eval['user_rate']:5.0 ?>/5</span>
            </div>
        </div>
        <div class="w-evaluation-box_1">
            <div class="w-evaluation-left">工作速度：</div>
            <div class="w-evaluation-conter">
                <div class="w-barline w-green-star-gray">
                    <div class="w-charts w-green-star"></div>
                </div>
            </div>
            <div class="w-evaluation-right">
                <span class="w-evaluation_view"><?= isset($eval['speed_view'])?$eval['speed_view']:5.0 ?>/5</span>
            </div>
        </div>
        <div class="w-evaluation-box_1">
            <div class="w-evaluation-left">交易量：</div>
            <div class="w-evaluation-conter"><?= number_format(isset($eval['trans_count'])?$eval['trans_count']:5) ?></div>
            <div class="w-evaluation-right">笔</div>
        </div>
        <div class="w-evaluation-box_1">
            <div class="w-evaluation-left">服务态度：</div>
            <div class="w-evaluation-conter">
                <div class="w-barline w-red-hart-gray">
                    <div class="w-charts w-red-hart"></div>
                </div>
            </div>
            <div class="w-evaluation-right">
                <span class="w-evaluation_view"><?= isset($eval['attitude_view'])?$eval['attitude_view']:5.0?>/5</span>
            </div>
        </div>
        <div class="w-evaluation-box_1">
            <div class="w-evaluation-left">交易额：</div>
            <div class="w-evaluation-conter">¥<?= number_format(isset($eval['trans_cash'])?$eval['trans_cash']:0, 2) ?></div>
            <div class="w-evaluation-right">元</div>
        </div>
    </div>
</div>

<div class="theme-white-box">
    <ul class="w-box-title clearfix">
        <li class="comment_ent active" data-username="<?= $this->context->obj_username ?>" data-type="2">
            <a href="javascript:;">来自雇主的评价</a>
            <b>|</b>
        </li>
        <li class="comment_ent" data-username="<?= $this->context->obj_username ?>" data-type="1">
            <a href="javascript:;">来自雇员的评价</a>
        </li>
    </ul>
    <div class="tab-box-new">
        <div class="tab-content" style="display: block;">
            <div class="tab-choice">
                <span class="ds-category-type">
                    <i class="checkbox checked" data-status="1"><b></b></i>
                    <input type="radio" name="mark_status" checked value="好评">好评
                </span>
                <span class="ds-category-type">
                    <i class="checkbox" data-status="2"><b></b></i>
                    <input type="radio" name="mark_status" value="中评">中评
                </span>
                <span class="ds-category-type">
                    <i class="checkbox" data-status="3"><b></b></i>
                    <input type="radio" name="mark_status" value="差评">差评
                </span>
            </div>
            <table class="theme-table" id="general_list2">
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="tab-content">
            <div class="tab-choice">
                <span class="ds-category-type">
                    <i class="checkbox checked" data-status="1"><b></b></i>
                    <input type="radio" name="mark_status" checked value="好评">好评
                </span>
                <span class="ds-category-type">
                    <i class="checkbox" data-status="2"><b></b></i>
                    <input type="radio" name="mark_status" value="中评">中评
                </span>
                <span class="ds-category-type">
                    <i class="checkbox" data-status="3"><b></b></i>
                    <input type="radio" name="mark_status" value="差评">差评
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
<script src="http://static.vsochina.com/libs/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="http://static.vsochina.com/libs/masonry/3.3.2/masonry.pkgd.min.js"></script>
<script src="/js/talent_space.js"></script>
<script type="text/javascript">
    <?php require_once(Yii::getAlias('@frontend') . '/webrc/js/personal/generation.js') ?>
    $(function(){
        general_ctl.initCtl(1, 2, 1, "<?= $this->context->obj_username;?>");
        general_ctl.generalList();

        $(".comment_ent").on("click",function(){
            var _this = $(this),
                index = $(_this).index();
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
    });
</script>