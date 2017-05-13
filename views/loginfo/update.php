<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ArLoginfo */

$this->title = 'Update Ar Loginfo: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ar Loginfos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ar-loginfo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
