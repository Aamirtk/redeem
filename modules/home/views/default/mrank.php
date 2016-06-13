<div class="m-rank-box" >
    <ul class="m-rank-ul">
        <?php foreach($hot_projs as $k => $v):?>
        <li>
            <a href="/project/<?= $v['proj_id'] ?>" class="clearfix">
                <div class="m-rank-img"><img src="<?= $v['proj_icon'] ?>" alt="" ></div>
                <div class="m-rank-info">
                    <p class="m-rank-title"><?= $v['proj_name'] ?></p>
                    <p class="m-rank-content"></p>
                    <p class="m-rank-num"><b class="color-green"><?= $v['fans_num'] ?></b> 支持</p>
                    <div class="rank-right rank-<?=$k+1?>">
                        <div class="triangle-topright"></div>
                        <?= sprintf('%02d',$k+1) ?>
                    </div>
                </div>
            </a>
        </li>
        <?php endforeach;?>
    </ul>
</div>


<script type="text/javascript">

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
