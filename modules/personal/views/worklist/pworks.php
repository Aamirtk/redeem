
            <div class="theme-works-all  clearfix">
                <?php if($this->context->is_self){?>
                <div class="theme-works"  onclick="showWorklist(event,'','','')">
                    <p class="theme-time works-add">&nbsp;</p>
                    <div class="theme-works-info">
                        <div class="theme-works-info-add">
                            <i class="theme-works-info-add-icon"></i>
                            <span class="theme-works-info-add-w">创建新作品集</span>
                          </div>
                          <div class="cover-line-1"></div>
                          <div class="cover-line-2"></div>
                    </div>
                </div>
                <?php }?>
                <?php if(isset($worklist) && !empty($worklist)){
                foreach ($worklist as $value)
                {?>
                <div class="theme-works" onclick='window.open("/personal/worklist/works/<?=$value['p_work_id']?>")'>
                    <p class="theme-time"><b>·</b><?=$value['work_name']?></p>
                    <div class="theme-works-info">
                        <a href="javascript:;">
                          <img src="<?=$value['work_cover']?$value['work_cover']:'/skin/pithy/images/works-title-bg.png'?>" alt="">
                          <?php if($this->context->is_self){?>
                          <div class="theme-works-action">
                              <span class="btn-action btn-green" onclick="showWorklist(event,'<?=$value['p_work_id']?>','<?=$value['work_name']?>','<?=$value['work_cover']?>')"><i class="icon-24 icon-edit"></i></span>
                              <span class="btn-action btn-red" onclick="showDelete(event,'<?=$value['p_work_id']?>','<?=$value['work_name']?>','<?=$value['work_cover']?>')"><i class="icon-24 icon-del"></i></span>
                          </div>
                          <?php }?>
                          <div class="theme-works-num">
                              <?=$value['work_count']?>
                          </div>
                        </a>
                        <div class="cover-line-1"></div>
                        <div class="cover-line-2"></div>
                    </div>
                </div>
                <?php }}?>
                <?php if(isset($no_worklist) && !empty($no_worklist)){
                ?>
                <div class="theme-works" onclick='window.open("/personal/worklist/nworks/<?=$no_worklist['username']?>")'>
                    <p class="theme-time"><b>·</b>未分类作品</p>
                    <div class="theme-works-info">
                        <a href="javascript:;">
                          <img src="<?=$no_worklist['work_cover']?$no_worklist['work_cover']:'/skin/pithy/images/works-title-bg.png'?>" alt="">
                          <div class="theme-works-num">
                              <?=$no_worklist['work_count']?>
                          </div>
                        </a>
                        <div class="cover-line-1"></div>
                        <div class="cover-line-2"></div>
                    </div>
                </div>
                <?php }?>
            </div>

        </div>
        <div class="content-first-bg"></div>
        <div class="content-second-bg"></div>
        <div class="content-third-bg"></div>
    </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabelCreate">
           <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                           <h4 class="modal-title" id="myModalLabelCreate">创建作品集</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div class="col-xs-6 pull-right text-right width200" >
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
                            <input type="button" class="btn btn-darkgrey" onclick="updateWorklist()"  value="确定"/>
                            <input type="button" class="btn btn-darkgrey" onclick="hideDelete()" value="取消"/>
                        </div>
                    </div>
                </div>
            </div>
          </div>
    </div>
    <script type="text/javascript" src="/js/rc_work.js"></script>