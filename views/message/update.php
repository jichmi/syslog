<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ArMessage */

$this->title = '修改系统消息';
$this->params['breadcrumbs'][] = ['label' => '系统消息', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="ar-message-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
