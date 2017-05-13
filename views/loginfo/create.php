<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ArLoginfo */

$this->title = 'Create Ar Loginfo';
$this->params['breadcrumbs'][] = ['label' => 'Ar Loginfos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ar-loginfo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
