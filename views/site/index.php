<?php

/* @var $this yii\web\View */
use miloschuman\highcharts\HighchartsAsset;

HighchartsAsset::register($this)->withScripts(['highstock', 'modules/exporting', 'modules/drilldown']);

$this->title = 'overview';
?>
<div class="site-index">
    <div id = "loginfo" style="min-width:800px;height:400px;border:1px solid #F00" onclick = "fnLogin();">loginfo</div>
    <div id = "authinfo" style="min-width:800px;height:400px;border:1px solid #F00" onclick = "fnAuth();">authinfo</div>
    <div id = "message" style="min-width:800px;height:400px;border:1px solid #F00" onclick = "fnMessage();">hello</div>
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
      credits: {
             enabled: false
      },
      exporting: {
                    enabled:false
      },
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
      plotOptions: {
        series: {
          cursor: 'pointer',
          events: {
            click: function(event) {
              /*
              alert(this.name +' clicked\n'+'highcharts 交流群294191384');
              alert(event.point.category); // X轴值
              alert(this.data[event.point.x].y); // Y轴值
              */
              window.location.href="http://syslog.hust.edu.jcm/index.php?LoginfoSearch%5Bdatetime%5D="+event.point.category+"&LoginfoSearch%5Blast%5D=&LoginfoSearch%5Bstatus%5D=&LoginfoSearch%5Bip%5D=&LoginfoSearch%5Bter%5D=&LoginfoSearch%5Bname%5D="+this.name+"&r=loginfo%2F";
            }
          }
        }
      },
        series:response.user
        });
      }
     });
}
function fnAuth(){
  $.ajax({
    url:"<?= Yii::$app->urlManager->createUrl('authinfo/count')?>",
    success:function(result){
      response = JSON.parse(result);
      console.log(response.date);
      console.log(response.user);
      var chart = new Highcharts.Chart('authinfo', {// 图表初始化函数，其中 container 为图表的容器 div 
      credits: {
             enabled: false
      },
      exporting: {
                    enabled:false
      },
      chart: {
        type: 'line'   //指定图表的类型，默认是折线图（line）
        },
        title: {
      text: 'authinfo' //指定图表标题
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
function fnMessage(name){
  $.ajax({
    url:"<?= Yii::$app->urlManager->createUrl('message/count')?>&name="+name,
    success:function(result){
      response = JSON.parse(result);
      console.log(response.date);
      console.log(response.user);
      var chart = new Highcharts.Chart('message', {// 图表初始化函数，其中 container 为图表的容器 div 
      credits: {
             enabled: false
      },
      exporting: {
                    enabled:false
      },
      chart: {
        type: 'line'   //指定图表的类型，默认是折线图（line）
        },
        title: {
      text: 'message' //指定图表标题
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
          cursor: 'line',
          events: {
            click: function(event) {
              fnMessage(this.name);
            }
          }
        }
      },
        series:response.user
        });
      }
     });
}
window.onload=function(){
    fnLogin();
    fnAuth();
    fnMessage();
  }
</script>
