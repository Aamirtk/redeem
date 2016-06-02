<style>
    .avatar_content{
        height: 120px;
        width: 140px;
        display: block;
        margin-bottom: 20px;
    }
    .avatar_img{
        height: auto;
        width: 100px;
        margin: 0 auto 80px 120px;
    }


</style>
<div id="content" style="display: block" >
    <form id="form" class="form-horizontal">
        <div class="row">

            <div class="control-group span8">
                <label class="control-label">微信昵称：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['nick'] ?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">真实姓名：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['name'] ?></span>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="control-group span8 avatar_content" >
                <label class="control-label">微信头像：</label>
                <div class="controls ">
                    <img class="avatar_img" src="<?php echo $auth['avatar'] ?>">
                </div>
            </div>
        </div>
        <div class="row">

            <div class="control-group span8">
                <label class="control-label">手机号码：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['mobile']?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">邮箱：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['email'] ?></span>
                </div>
            </div>

            <div class="control-group span8">
                <label class="control-label">微信公众号：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['wechat_openid'] ?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">用户类型：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['user_type'] ?></span>
                </div>
            </div>

            <div class="control-group span8">
                <label class="control-label">申请时间：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['create_at'] ?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">更新时间：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['update_at'] ?></span>
                </div>
            </div>

        </div>

    </form>
</div>