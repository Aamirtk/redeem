
    <!--瀑布流-->
    <div class="masonry js-masonry">
        <?php if (!empty($works))
        { ?>
        <?php foreach ($works as $work)
        { ?>
            <div class="masonry-item">
                <?php if($work['work_name']&&('未命名作品'!=$work['work_name'])&&$work['cover_url']&&($work['pic_or_video']<>3)){
                ?>
                <div class="masonry-pic-dec">
                    <a target="_blank" href="<?=yii::$app->urlManager->createUrl('/personal-work-'.$work['work_id'])?>">
                        <h2 class="masonry-pic-title"><?= $work['work_name'] ?></h2>
                        <img src="<?= $work['cover_url'] ?>">
                    </a>
                <?php }
                elseif ((empty($work['work_name'])||('未命名作品'==$work['work_name']))&&$work['cover_url']&&($work['pic_or_video']<>3)){
                ?>
                      <div class="masonry-pic">
                          <a target="_blank" href="<?=yii::$app->urlManager->createUrl('/personal-work-'.$work['work_id'])?>">
                          <img src="<?=$work['cover_url']?>">
                          </a>
                <?php }
                else{
                ?>
                      <div class="masonry-word">
                <?php }
                ?>
                   <?php if($work['description']){?>
                    <div class="masonry-text">
                        <a target="_blank" href="<?=yii::$app->urlManager->createUrl('/personal-work-'.$work['work_id'])?>">
                        <p><?= strip_tags($work['description']) ?></p>
                        </a>
                    </div>
                    <?php }?>
                    <a target="_blank" href="<?=yii::$app->urlManager->createUrl('/personal-work-'.$work['work_id'])?>">
                    <div class="masonry-action">
                        <span class="label label-green pull-right"><?= empty($work['p_work_name'])?'未分类作品':$work['p_work_name'] ?></span>
                        <span> <i class="icon-24 icon-24-message"></i><?= $work['commentnum'] ?> <b class="icon-word">评论 &nbsp;&nbsp;/</b></span>
                        <i class="icon-24 icon-24-heart"></i><?= $work['likenum'] ?> <b class="icon-word">喜欢</b>
                    </div>
                    </a>
                <?php if($this->context->is_self){?>
                    <div class="masonry-action">
                        <a href="javascript:void(0)" onclick="showWorkDelete(event,'<?=$work['work_id']?>')" class="masonry-action-close pull-right">×</a>
                        <a href="<?=yii::$app->urlManager->createUrl("/personal/work/update?w_id=".$work['work_id'])?>"  target="_blank" class="masonry-action -edit">编辑</a> / <a href="javascript:void(0)" onclick="selectWork('<?=$work['work_id']?>')"class="masonry-action-change">更换作品集</a>
                    </div>
                    <?php }?>
                </div>
            </div>
        <?php }
    } ?>
    </div>
    <!--/瀑布流-->
    <input type="hidden" id="hidden_work_id" value=""><!--选择作品-->
        </div>
        <div class="content-first-bg"></div>
        <div class="content-second-bg"></div>
        <div class="content-third-bg"></div>
    </div>
<ul class="works-sample-ul">
    <?php if(isset($worklist)&&!empty($worklist)){
        foreach($worklist as $value)
        {
        ?>
    <li><a href="javascript:void(0)" onclick="changeWorklist('<?=$value['p_work_id']?>')"><?=$value['work_name']?></a></li>
    <?php }}?>
    <li class="works-sample-add" data-target="#myModal" data-toggle="modal"><a href="javascript:;">+</a></li>
</ul>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
       <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                       <h4 class="modal-title" id="myModalLabel">系统提示</h4>
                </div>
                <div class="modal-body clearfix">

                    <div class="text-center pd20">
                        <p class="modal-tip">您确认删除吗？</p>
                        <div class="form-group btn-works-group">
                            <button class="btn btn-darkgrey" onclick="deleteWork()"  >确定</button>
                            <button class="btn btn-darkgrey" onclick="hideWorkDelete()" >取消</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabelCreate">
           <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                           <h4 class="modal-title" id="myModalLabelCreate">创建作品集</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div class="col-xs-6 pull-right text-right width200">
                            <img src="" alt="" id="worklist_cover">
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                 <label for="" class="form-label">作品集名称</label>
                                 <input type="text" name="name" id="name" value="" maxlength="15" class="form-control" placeholder="">
                                 <input type="hidden" name="p_work_id" id="p_work_id" value="" class="form-control" placeholder="">
                                 <input type="hidden" name="cover" id="cover" value="" class="form-control" placeholder="">
                                 <input type="hidden" name="status" id="status" value="" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                 <label for="" class="form-label">作品集封面</label>
                                 <iframe src="" id="loading" name="loading" style="display: none" width="100px" height="100px"></iframe>
                                 <form name="upload" id="upload" method="POST" enctype="multipart/form-data" action="<?= yii::$app->params['workUploadUrl'] ?>?" target="loading">
                                    <input type="hidden" name="callback" value="<?= yii::$app->urlManager->hostInfo?>?"/>
                                    <input type="hidden" name="username" id="username" value="<?=$this->context->user_info['username']?>" class="form-control" placeholder="">
                                    <input type="hidden" name="objtype" value="work"/>
                                    <input type="hidden" name="appid" value="rc"/>
                                    <input type="hidden" name="token" value="rc"/>
                                 <div class="form-upload">
                                     <span>选择本地图片</span>
                                     <input type="file" id="attachment" name="attachment" onchange="uploadfile();">
                                 </div>
                                 </form>
                            </div>
                            <div class="form-group btn-works-group">
                                <input type="button" class="btn btn-darkgrey" onclick="updateWorklist()" value="确定"/>
                                <input type="button" class="btn btn-darkgrey" onclick="hideWorklist()" value="取消"/>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
        </div>
    <script type="text/javascript" src="/js/rc_work.js"></script>
    <!--[if !IE]><!--> <script type="text/javascript" src="http://static.vsochina.com/libs/imagesloaded/imagesloaded.pkgd.min.js"></script> <!--<![endif]-->
    <!--[if gte IE 9]> <script type="text/javascript" src="http://static.vsochina.com/libs/imagesloaded/imagesloaded.pkgd.min.js"></script> <![endif]-->
    <script type="text/javascript">
        $(function(){
            var container = $('.masonry');
            var userAgent = window.navigator.userAgent.toLowerCase();
            var isIE8 = /msie 8\.0/i.test(userAgent);
            if(isIE8){
                container.masonry({
                    itemSelector : '.masonry-item',
                    columnWidth : <?=$columnWidth?>
                });
            }else{
                imagesLoaded(container, function() {
                    container.masonry({
                        itemSelector : '.masonry-item',
                        columnWidth : <?=$columnWidth?>
                    });
                });
            }
        });
    </script>