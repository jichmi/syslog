<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ArMessage */

$this->title = 'Create Ar Message';
$this->params['breadcrumbs'][] = ['label' => 'Ar Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ar-message-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
