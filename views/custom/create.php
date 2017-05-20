<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ArCustom */

$this->title = 'Create Ar Custom';
$this->params['breadcrumbs'][] = ['label' => 'Ar Customs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ar-custom-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
