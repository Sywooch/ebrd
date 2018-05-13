<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model frontend\modules\user\models\Reports */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reports-form">

    <?php $form = ActiveForm::begin(['id' => 'my_form_js']); ?>
	
	<?= $form->field($model, 'nav')->textInput(['id' => 'json_get','class' => 'hidden'])->label(false); ?>
	
    <div class="blog_post_col-1">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<?php
		if(empty($model->file) || $model->isNewRecord){
			echo $form->field($model, 'report_content')->textInput();
		}
	?>
		
	<?= $form->field($model, 'report_description')->textarea(['rows' => 5]) ?>
		
	<div class="nav_js_report">
		<?php 
			if(!$model->isNewRecord && !empty($model->nav)){
				$inputs = json_decode($model->nav, true);
				$html = '';
				foreach ($inputs as $input){
					$html .= '<div class="input_link_container">';
					$html .= '<div class="link_input">';
					$html .= '<input class="name_report_json" type="text" value="'.$input['name'].'">';
					$html .= '</div>';
					$html .= '<div class="link_input">';
					$html .= '<input class="value_report_json" type="text" value="'.$input['value'].'">';
					$html .= '</div>';
					$html .= '<div class="remove_cross">X</div>';
					$html .= '</div>';
				}
				echo $html;
			}
		?>
	</div>
	<div class="btn_add_link">Add New Link</div>
    </div>
    <div class="blog_post_col-2">
	
	<div class="custom_report_css">
		<?= '<label class="control-label">Users Reports</label>'; ?>
		<?= Select2::widget([
				'name' => 'user_id',
				'value' => array_keys($usedUsers),
				'data' => $users,
				'maintainOrder' => true,
				'options' => ['placeholder' => 'Select User', 'multiple' => true],
				'pluginOptions' => [
					'multiple' => true
				],
			]);?>
	</div>

	<div class="custom_report_css">
	<?= '<label class="control-label">Team Reports</label>'; ?>
	<?= Select2::widget([
			'name' => 'team_id',
			'value' => array_keys($usedTeams),
			'data' => $teams,
			'maintainOrder' => true,
			'options' => ['placeholder' => 'Select Team', 'multiple' => true],
			'pluginOptions' => [
				'multiple' => true
			],
		]);?>
	</div>
		
	<?= $form->field($model, 'type_id')
		->dropDownList($types)
		->label(Yii::t('blog', 'CATEGORY'))
	?>
		
	<?php
		if(empty($model->file)){
			echo $form->field($model, 'file')->widget(FileInput::classname(), [
				'pluginOptions' => [
					'allowedFileExtensions' => ['pdf'],
					'previewFileType' => 'all',
					'showUpload' => false,
					'initialPreview'=> $model->file ? [
						$model->file,
					] : false,
					'initialCaption'=> Yii::t('user', 'PDF'),
				],
			])->label(Yii::t('user', 'PDF'));
		}else{
			echo $model->file;
		}
		
	?>
	</div>
	<div class="blog_post_col_submit">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('user', 'Create') : Yii::t('user', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<?= $model->isNewRecord ? '' : Html::a(Yii::t('blog', 'RESEND_MAILS'), ['resend-mails','id' => $model->id], ['class' => 'btn btn-warning']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
