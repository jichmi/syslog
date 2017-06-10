<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LoginfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '登录信息详情';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ar-loginfo-index">

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
            
            'datetime',
            'last',
            'status',
            'ip',
            'ter',
            'name',

            [
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['width' => '80'],
            ],
        ],
    ]); ?>
</div>
