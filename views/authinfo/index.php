<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AuthinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '授权信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ar-authinfo-index">

    <h1><?= Html::encode($this->title) ?>        
    <?= Html::a('download', ['download'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('统计', ['report'], ['class' => 'btn btn-success']) ?>
    </h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'datetime',
            'user',
            'grantor',
            'order',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
