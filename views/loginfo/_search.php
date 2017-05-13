<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LoginfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ar-loginfo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'datetime') ?>

    <?= $form->field($model, 'last') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'ter') ?>

    <?php // echo $form->field($model, 'name') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
