<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '系统消息详情';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ar-message-index">

    <h1>
        <?= Html::a('备份', ['download'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('导入', ['upload'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('统计', ['report'], ['class' => 'btn btn-success']) ?>
    </h1>
 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'datetime',
            'creator',
            'content',
            'type',
            'lv',

            [
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['width' => '70'],
            ],
        ],
    ]); ?>
</div>
