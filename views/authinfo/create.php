<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ArAuthinfo */

$this->title = 'Create Ar Authinfo';
$this->params['breadcrumbs'][] = ['label' => 'Ar Authinfos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ar-authinfo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
