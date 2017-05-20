<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ArSetting */

$this->title = 'Update Ar Setting: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ar Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ar-setting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
