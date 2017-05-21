<?php

/* @var $this yii\web\View */
use miloschuman\highcharts\HighchartsAsset;

HighchartsAsset::register($this)->withScripts(['highstock', 'modules/exporting', 'modules/drilldown']);

$this->title = 'overview';
?>
<div class="site-index">
    <h2>文件备份</h2>
    <h2>系统配置</h2>
    <h2>用户配置</h2>
    <h2>……</h2>
</div>
<script>
</script>
