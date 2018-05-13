<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\forms\models\Form */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="blog_post_col-1">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'answer')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'mail_to')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fields')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rules')->textarea(['rows' => 6]) ?>
    </div>
    <div class="blog_post_col-2">
    <?= $form->field($model, 'submit')->textarea(['rows' => 6]) ?>
	
    <?= $form->field($model, 'script_on_submit')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'extra_actions')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'action')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'method')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'class')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'form_id')->textInput(['maxlength' => true]) ?>
		
	<?= $form->field($model, 'attach_file')->textInput(['maxlength' => true]) ?>
		
	<?= $form->field($model, 'hubspot_form_guid')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="blog_post_col_submit">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('forms', 'Create') : Yii::t('forms', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
