
<div class="m-quanzi-box" >
    <ul class="m-quanzi-ul">
        <?php foreach($circle as $v):?>
        <li>
            <a href="<?= $v['link']?>" class="clearfix">
                <div class="m-quanzi-img"><img src="<?= $v['banner']?>" alt="" ></div>
                <div class="m-quanzi-info">
                    <p class="m-quanzi-title"><?= $v['title']?></p>
                    <p class="m-quanzi-num">主题：<?= $v['post_num']?>个</p>
                </div>
            </a>
        </li>
        <?php endforeach;?>
    </ul>
</div>


<script type="text/javascript">

    $(".m-quanzi-box").css("min-height",$(window).height()-400/750*$(window).width());
</script>
