<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "new post";
$form = ActiveForm::begin([
	'id' => 'login-form',
	    'options' => ['class' => 'form-horizontal'],
	    ]) ?>
	    <?= $form->field($model, 'title') ?>
	    <?= $form->field($model, 'summary') ?>
      <?= $form->field($model, 'content')->widget('\pjkui\kindeditor\KindEditor',['clientOptions'=>['allowFileManager'=>'true','allowUpload'=>'true']]) ?>
	    <?= $form->field($model, 'tags') ?>
<?//=$id;?>
	<div class="form-group">
	  <div class="col-lg-offset-1 col-lg-11">
	  <?= Html::submitButton('add-post', ['class' => 'btn btn-primary']);?>
    </div>
	</div>
	<?php ActiveForm::end() ?>
