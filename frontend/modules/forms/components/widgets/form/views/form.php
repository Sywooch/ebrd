<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use frontend\modules\forms\components\widgets\yandex_goal\YandexGoal;
/* @var $commonModel frontend\modules\forms\models\FormBuild */

$submit = yii\helpers\Json::decode($commonModel->submit);
?>
	<h2><?= Yii::t('forms', $commonModel->title) ?></h2>
	<div><?= Yii::t('forms', $commonModel->description) ?></div>
	
<?php
$form = ActiveForm::begin([
	'action' => ($commonModel->action) ? $commonModel->action : '/forms/default/form',
	'options' => [
		'class' => ($commonModel->class) ? $commonModel->class : "formWidget",
		'id' => $commonModel->form_id,
		'enctype' => 'multipart/form-data'
	]
]);
?>
	<div class="hidenFields">
	<?php
	echo $form->field($model, 'formTemplateId')->hiddenInput(['class' => 'hiddenInp'])->label(FALSE);
	echo $form->field($model, 'pageTitle')->hiddenInput(['class' => 'hiddenIp'])->label(FALSE);
	
	if (!empty($model->chain_id)){
		echo $form->field($model, 'chainStep')->hiddenInput(['class' => 'hiddenIp'])->label(FALSE);
		echo $form->field($model, 'chain_id')->hiddenInput(['class' => 'hiddenIp'])->label(FALSE);
		echo $form->field($model, 'chain_submit_id')->hiddenInput(['class' => 'hiddenIp'])->label(FALSE);
	}
	?>		
	</div>	
	
	<?php
		foreach (yii\helpers\Json::decode($commonModel->fields) as $field){
			if ($field['type'] == 'textInput'){			
				$tmpRes = $commonModel->buildTextInput($form, $model, $field);
			} elseif ($field['type'] == 'fileInput'){
				if (isset($field['label'])){
					$tmpRes = $form->field($model, $field['name'], ['options' => ['class' => 'form-send-cv__attach']])->{$field['type']}()->label(Yii::t('forms', $field['label']));
				} else {
					$tmpRes = $form->field($model, $field['name'], ['options' => ['class' => 'form-send-cv__attach']])->{$field['type']}();
				}
			} else {
				if (isset($field['label'])){
					$tmpRes = $form->field($model, $field['name'])->{$field['type']}()->label(Yii::t('forms', $field['label']));
				} else {
					$tmpRes = $form->field($model, $field['name'])->{$field['type']}();
				}
			}
			
			echo $tmpRes;
		}
	?>
	
	<div class="form-group">
		<?= Html::submitButton(Yii::t('forms', $submit['label']), ['class' => $submit['class']]) ?>
	</div>
<?php ActiveForm::end();?>
		
<?= YandexGoal::widget([
	'formId' => $commonModel->id,
	'submittedFormId' => $commonModel->form_id
	]);?>

