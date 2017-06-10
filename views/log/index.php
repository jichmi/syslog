<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '操作日志';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ar-log-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ar Log', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'datetime',
            'action',
            'para',
            'username.name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
