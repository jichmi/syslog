<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ArSetting */

$this->title = '添加设定';
$this->params['breadcrumbs'][] = ['label' => '设定', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ar-setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
