<?php
    $user_info = $this->context->user_info;
;?>
<div class="rc-about">
    <ul class="rc-about-ul">
        <li><label>关于<?= $user_info['auth_sex']==1 ? '他' : '她' ?></label><?= $user_info['introduction'] ?></li>
        <li><label>行业</label><?= $user_info['indus_name'] ?></li>
<!--        <li><label>学校</label>中国传媒大学</li>-->
        <li><label>位置</label><?= $user_info['residency'] ?></li>
    </ul>
</div>
<!--/header-->
