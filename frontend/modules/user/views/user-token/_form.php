<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserToken */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-token-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="blog_post_col-1">
		<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
		
		<?= $form->field($model, 'url')->textInput() ?>
		
		<?= $form->field($model, 'token')->textInput(['readonly' => true]) ?>
		
		<div class="form-group">
			<?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-success']) ?>
		</div>
	</div>

    <?php ActiveForm::end(); ?>

</div>
