<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ArCustom */

$this->title = 'Update Ar Custom: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ar Customs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ar-custom-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
