<?php

/* @var $this yii\web\View */
use miloschuman\highcharts\HighchartsAsset;

HighchartsAsset::register($this)->withScripts(['highstock', 'modules/exporting', 'modules/drilldown']);

$this->title = 'overview';
?>

<div class="site-index">
    <div id = "timeline" style="min-width:800px;height:400px;border:1px solid #D3D3D3" >timeline</div>
    <div id = "pie" style="min-width:800px;height:400px;border:1px solid #D3D3D3" >pie</div>
</div>
<script>
function funtimeline(){
  $.ajax({
    url:"<?= Yii::$app->urlManager->createUrl('message/timeline')?>",
    success:function(result){
      response = JSON.parse(result);
      console.log(response.user);
      var chart = new Highcharts.Chart('timeline', {
      credits: {
             enabled: false
      },
      exporting: {
                    enabled:false
      },
      chart: {
        type: 'line' 
        },
        title: {
      text: '日志数量时间轴' //指定图表标题
      },
      xAxis: {
        categories: response.date   //指定x轴分组
        },
        yAxis: {
      title: {
        text: 'count' //指定y轴的标题
        }
        },
      plotOptions: {
        series: {
          cursor: 'pointer',
          events: {
            click: function(event) {
             // window.location.href="http://syslog.hust.edu.jcm/index.php?LoginfoSearch%5Bdatetime%5D="+event.point.category+"&LoginfoSearch%5Blast%5D=&LoginfoSearch%5Bstatus%5D=&LoginfoSearch%5Bip%5D=&LoginfoSearch%5Bter%5D=&LoginfoSearch%5Bname%5D="+this.name+"&r=loginfo%2F";
            }
          }
        }
      },
        series:response.user
        });
      }
     });
}

function funpierate(){
  $.ajax({
    url:"<?= Yii::$app->urlManager->createUrl('message/rate')?>",
    success:function(result){
      response = JSON.parse(result);
      console.log(response);
      var chart = new Highcharts.Chart('pie', {
      credits:{
          enabled: false
      },
      exporting: {
          enabled:false
      },
      chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false
      },
      title: {
          text: '日志来源占比'
      },
      tooltip: {
          headerFormat: '{series.name}<br>',
          pointFormat: '{point.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
              },
              showInLegend: true
            }
          },
          series: [{
              type: 'pie',
              name: '用户授权次数占比',
              data: response
        }]
      })
     }
    });
}

window.onload=function(){
    funtimeline();
    funpierate();
  }
</script>
<style>
.div-inline{display:inline;}
</style>
