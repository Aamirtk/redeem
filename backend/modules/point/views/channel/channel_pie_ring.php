<div class="demo-content">
    <div class="detail-section">
        <div id="channels_pie_ring">
        </div>
    </div>
</div>
<script type="text/javascript">
    BUI.use(['bui/data'],function (Data) {
        $.ajax({
            type: "GET",
            url: "<?= Yii::$app->urlManager->createUrl('point/channel/distribute') ?>",
            cache: false,
            dataType: "json",
            success: function (data) {

                var chart = new AChart({
                    id : 'channels_pie_ring',
                    width : 950,
                    height : 500,
                    title : {
                        text : '平台配比'
                    },
                    legend : null ,//不显示图例
                    seriesOptions : { //设置多个序列共同的属性
                        pieCfg : {
                            allowPointSelect : true,
                            //colors:["#81abda","#bcdcbc","#feb698","#ffde8d","#e5e5e5","#fef8f8"],
                            labels : {
                                distance : 40, //文本距离圆的距离
                                label : {
                                    //文本信息可以在此配置
                                },
                                renderer : function(value,item){ //格式化文本
                                    return value + ' ' + (item.point.percent * 100).toFixed(2)  + '%';
                                }
                            },
                            innerSize : '60%' //内部的圆，留作空白

                        }
                    },
                    tooltip : {
                        pointRenderer : function(point){
                            return (point.percent * 100).toFixed(2)+ '%';
                        }
                    },
                    series : [{
                        type: 'pie',
                        name: '平台比率为：',
                        data:data
                    }]
                });

                chart.render();
            }
        });
    });
</script>
