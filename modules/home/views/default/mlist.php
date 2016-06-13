<!--project-->
<div id="mlist_project_wrapper"  class="mobile-box mo-project mlist-project">
    <ul class="mo-project-list clearfix">
        <?php foreach($list as $v):?>
        <li>
            <a href="/project/<?= $v['proj_id'] ?>">
                <div class="mo-project-img">
                    <img src="<?= $v['project']['proj_icon'] ?>">
                </div>
                <p class="mo-project-name"><?= $v['project']['proj_name'] ?></p>
                <p class="mo-project-tag"><?=  $v['proj_tag']?></p>
                <p class="mo-project-support"><span><?= $v['fans_num'] ?></span>支持</p>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    <div class="mo-project-all">
        <a class="mo-project-more" href="javascript:void(0);">查看更多项目</a>
    </div>
</div>
<!--/project-->

<script src="http://static.vsochina.com/libs/swiper/js/swiper.min.js"></script>
<script type="text/javascript">
    var milProjectCtl = {
        type : 0,
        page : 1,
        isLoading : false,
        initList : function(isAppend){
            var self = this;
            if(!self.isLoading){
                self.isLoading = true;
                if(isAppend){
                    self.page = self.page + 1;
                }
                $.ajax({
                    type : "POST",
                    data:{
                        type : self.type,
                        page : self.page
                    },
                    url : '<?= yii::$app->urlManager->createUrl("project/default/act-list");?>',
                    dataType : "json",
                    success: function(json){
                        self.isLoading = false;
                        if(json.list.length < parseInt("<?= yii::$app->params['home_list_page_size']?>")){
                            $(".mo-project-more").hide();
                        }
                        var html = "";
                        if(!isAppend){
                            $(".mo-project-list").html("");
                        }

                        $.each(json.list,function(index, element){
                            if($("[data-id='" + element.proj_id + "']").length == 0&&element.project){
                                html += self.loadHtml(element);
                            }
                        });
                        if(!isAppend){
                            $(".mo-project-list").html(html);
                        }
                        else{
                            $(".mo-project-list").append(html);
                        }
//
//                        $(".col-xs-3:hidden").fadeIn(300);
                    }
                });
            }
        },
        loadHtml : function(data){
//            var html = '<div class="col-xs-3" data-id="' + data.proj_id + '" style="display:none;">\
//            <dl class="dsn-caselist-dl">\
//            <dt><a href="/project/' + data.proj_id + '"><img src="' + data.project.proj_icon + '" alt="" width="289" height="165"></a></dt>\
//            <dd class="ds-project-mark">\
//            <!--<i class="ds-icon-16 icon-16-praise pull-right"></i>-->\
//            <a href="">' + data.project.proj_name + '</a></dd>\
//            <dd class="ds-project-bread">' + data.proj_tag + '</dd>\
//            <dd><span class="color-green">' + data.fans_num + '</span> 支持</dd>\
//            </dl>\
//            </div>';
    var myHtml = '<li>\
                            <a href="/project/' + data.proj_id + '">\
                                <div class="mo-project-img">\
                                    <img src="' + data.project.proj_icon + '">\
                                </div>\
                                <p class="mo-project-name">' + data.project.proj_name + '</p>\
                                <p class="mo-project-tag">' + data.proj_tag + '</p>\
                                <p class="mo-project-support"><span>' + data.fans_num + '</span>支持</p>\
                            </a>\
                        </li>';
            return myHtml;
        }
    }
    $(function(){
        $(".mo-project-more").on('click', function(event) {
            milProjectCtl.initList(true);
        });
    });

    function is_weixin()
    {
        var ua = navigator.userAgent.toLowerCase();
        if(ua.match(/MicroMessenger/i) == "micromessenger")
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function stopPropagation(e)
    {
        if(e.stopPropagation())
        {
            e.stopPropagation();
        }
        else
        {
            e.cancelBubble = true;
        }
    }
</script>
