<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

Pjax::begin([
	'enablePushState' => FALSE,
	'id' => 'team_name'
]); ?>
<div class="h_inline">	
	<div id="new_name_form">
		<?php $form = ActiveForm::begin([
			'id' => 'team_name_form',
			'action' => '/team/default/team-set-name',
			'validateOnBlur' => FALSE,
			'options' => [
				'data-pjax' => TRUE
			]
		]); ?>

		<div class="team_name_flexing">
			<div class="ultra_team_name">
				<?= $form->field($model, 'teamName')->label(FALSE) ?>
			</div>

			<div class="ultra_team_name_active">
				<?= $model->teamName ?>
			</div>
			
			<div class="edit_full">
				<?= '<span class="glyphicon glyphicon-pencil"></span>'.Yii::t('blog', 'EDIT_NAME') ?>
			</div>
			
			<?= Html::submitButton(Yii::t('team', 'UPDATE'), [
				'id' => 'newNameSubmit',
				'class' => 'btn btn-primary', 
				'style' => "display:none"
			]) ?>
		</div>

		<?php ActiveForm::end();  ?>
	</div>
</div>
<?php Pjax::end();?>