<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LoginfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ar Loginfos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ar-loginfo-index">

    <h1><?= Html::encode($this->title) ?>
        <?= Html::a('download data', ['download'], ['class' => 'btn btn-success']) ?>
    </h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    </p>
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
