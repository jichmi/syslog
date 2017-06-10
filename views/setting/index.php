<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\AppConst;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '设定';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ar-setting-index">

    <h1><?= Html::encode($this->title) ?>
        <?= Html::a('添加设定', ['create'], ['class' => 'btn btn-success']) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'stype',
            'name',
            'value',
            'user.name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
