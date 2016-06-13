<?php if($this->context->is_self):?>
    <script>
        $(function(){
            //弹出层
            $(".bg-img-div").click(function(){
                $("#avatar-modal").modal('show');
                $(".avatar-input-banner-img").attr("src",$(".enterprise-banner-bg").attr("src"));
                $(".avatar-input-logo-img").attr("src",$(".bg-img-div").attr("src"));
            });

            //选择图片后就上传到服务器
            $("#company_banner_f input[name='attachment']").change(function(){
                $(".banner_div").loading(true);
                $("#company_banner_f").submit();
            });
            $("#company_logo_f input[name='attachment']").change(function(){
                $(".logo_div").loading(true);
                $("#company_logo_f").submit();
            });

            //点击图片就弹出选择文件框
            $(".avatar-input-banner-img,.avatar-input-logo-img").click(function(){
                $(this).parent().find("[name='attachment']").click();
            });

            //保存信息
            $("#submit_btn").click(function(){
                var company_id = $("#company_id").val();
                var logo = $("#company_logo").val();
                var banner = $("#company_banner").val();
                var record_is_show =$("[name='record_is_show']:checked").val();
                //提交按钮
                $.ajax({
                    url : '<?php echo yii::$app->urlManager->createUrl("/enterprise/default/edit-company");?>',
                    type : 'post',
                    dataType : 'json',
                    data : {
                        id : company_id,
                        logo : logo,
                        banner : banner,
                        record_is_show : record_is_show
                    },
                    success : function(){
                        $("#avatar-modal").modal('hide');
                        $("#company_banner").val("");
                        $("#company_logo").val("");

                        if(banner != "" && banner != undefined){
                            $(".enterprise-banner-bg").attr("src", banner);
                        }
                        if(logo != "" && banner != logo){
                            $(".company-logo").attr("src", logo).show();
                            $(".bg-img-div img").attr("src", logo).show();
                        }
                        if(record_is_show == 1){
                            $("#ent_record").show(200);
                        }
                        else{
                            $("#ent_record").hide(200);
                        }
                    }
                });
            });
        });

        //保存文件url
        function setfileurlfromcallbacklogo(fileurl) {
            $(".avatar-input-logo-img").attr("src", fileurl).show();
            $("#company_logo").val(fileurl);
            $(".logo_div").loading(false);
        }
        //保存文件url
        function setfileurlfromcallbackbanner(fileurl) {
            $(".avatar-input-banner-img").attr("src", fileurl).show();
            $("#company_banner").val(fileurl);
            $(".banner_div").loading(false);
        }
    </script>
    <input type="hidden" id="company_banner" value="" />
    <input type="hidden" id="company_logo" value="" />
    <div class="container" id="crop-avatar">
        <!-- Cropping modal -->
        <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="avatar-modal-label">基础设置</h4>
                    </div>
                    <div class="modal-body">
                        <div class="avatar-body">
                            <?php
                            $banner = $this->context->company['banner'];
                            $logo = $this->context->company['logo'];
                            if (empty($banner))
                            {
                                $banner = yii::$app->params['default_enterprise_banner'];
                            }
                            ?>
                            <iframe src="" id="company_logo_if_h" name="company_logo_if_h" style="display: none" width="100px" height="100px"></iframe>
                            <form id="company_logo_f" class="avatar-form" action="<?= yii::$app->params['upload_file_front'];?>" enctype="multipart/form-data" method="post" target="company_logo_if_h">
                                <p class="setting-title">企业logo</p>
                                <div class="upload-enterprise-banner logo_div">
                                    <img class="avatar-input-logo-img" src="<?= $logo?>" alt="" height="130px">
                                    <input type="hidden" name="appid" value="rc">
                                    <input type="hidden" name="token" value="rc">
                                    <input type="hidden" name="callback"
                                           value="/enterprise/default/upload-success?action=setfileurlfromcallbacklogo">
                                    <input type="file" name="attachment" class="avatar-input-banner" value="" style="width: 100%;" unselectable="on">
                                    <input type="hidden" name="username" value="<?= $this->context->company['username']?>">
                                    <input type="hidden" name="objtype" value="rc">
                                    <!--
                                    <input type="file" name="filedata" class="avatar-input-banner" value="">-->
                                </div>
                                <p class="color-orange">* 20MB以内？RBG模式    支持尺寸：1920x455，  支持格式：JPG/GIF/PNG</p>
                            </form>

                            <iframe src="" id="company_banner_if_h" name="company_banner_if_h" style="display: none" width="100px" height="100px"></iframe>
                            <form id="company_banner_f" class="avatar-form" action="<?= yii::$app->params['upload_file_front'];?>" enctype="multipart/form-data" method="post" target="company_banner_if_h">
                                <p class="setting-title">替换背景图</p>
                                <div class="upload-enterprise-banner banner_div">
                                    <img class="avatar-input-banner-img" src="<?= $banner?>" alt="" height="122px">
                                    <input type="hidden" name="appid" value="rc">
                                    <input type="hidden" name="token" value="rc">
                                    <input type="hidden" name="callback"
                                           value="<?= yii::$app->params['rc_front_url'] ?><?= yii::$app->urlManager->createUrl("enterprise/default/upload-success?action=setfileurlfromcallbackbanner");?>">
                                    <input type="file" name="attachment" class="avatar-input-banner" value="" style="width: 100%;" unselectable="on">
                                    <input type="hidden" name="username" value="<?= $this->context->company['username']?>">
                                    <input type="hidden" name="objtype" value="rc">
                                    <!--
                                    <input type="file" name="filedata" class="avatar-input-banner" value="">-->
                                </div>
                                <p class="color-orange">* 20MB以内？RBG模式    支持尺寸：1920x455，  支持格式：JPG/GIF/PNG</p>
                            </form>

                            <p class="setting-title">交易设置</p>
                            <?php
                            if(isset($this->context->company['record_is_show']) && $this->context->company['record_is_show'] == 1)
                            {
                                $isShow = true;
                            }
                            else{
                                $isShow = false;
                            }
                            ?>
                            <label class="setting-trade"><input type="radio" name="record_is_show" value="1" <?php if($isShow){echo " checked ";}?>>显示交易记录</label>
                            <label class="setting-trade"><input type="radio" name="record_is_show" value="2" <?php if(!$isShow){echo " checked ";}?>>隐藏交易记录</label>
                            <!--
                            <div class="row avatar-btns">
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary btn-block avatar-save">确认</button>
                                </div>
                            </div>
                            -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-blue" id="submit_btn">确定</button>
                    </div>

                </div>
            </div>
        </div><!-- /.modal -->

        <!-- Loading state -->
        <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
    </div>

<?php endif?>