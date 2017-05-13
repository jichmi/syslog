<?php

/* @var $this yii\web\View */
use miloschuman\highcharts\HighchartsAsset;

HighchartsAsset::register($this)->withScripts(['highstock', 'modules/exporting', 'modules/drilldown']);

$this->title = 'overview';
?>
<div class="site-index">
    <div id = "loginfo" style="min-width:800px;height:400px" onclick = "fnLogin();">hello</div>
</div>
<script>
function fnLogin(){
  $.ajax({
    url:"<?= Yii::$app->urlManager->createUrl('loginfo/count')?>",
    success:function(result){
      response = JSON.parse(result);
      console.log(response.date);
      console.log(response.user);
      var chart = new Highcharts.Chart('loginfo', {// 图表初始化函数，其中 container 为图表的容器 div 
      chart: {
        type: 'line'   //指定图表的类型，默认是折线图（line）
        },
        title: {
      text: 'loginfo' //指定图表标题
      },
      xAxis: {
        categories: response.date   //指定x轴分组
        },
        yAxis: {
      title: {
        text: 'count' //指定y轴的标题
        }
        },
        series:response.user
        });
      }
     });
}
</script>
