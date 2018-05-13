<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\bootstrap\ActiveForm;
use kartik\range\RangeInput;
use yii\helpers\Html;

$model->complexity = 1;
$model->range = 20;
$model->sum = 1;
?>
<div class="lead_generation_form_container">
	<div class="lead_generation_title"><?= Yii::t('blog', 'LEAD_GENERATION_TITLE') ?></div>
	<?php $form = ActiveForm::begin(['id' => 'lead_generation_form', 'action' => '/user/cabinet/submit-calculation']); ?>

		<?php
			$html = '<div class="lead_generation_overlay">';
			$html .= '<div class="lead_generation_popup">';
			$html .= '<div class="lead_generation_thanks">'.Yii::t('blog', 'LEAD_THANKS').'</div>';
			if(Yii::$app->user->isGuest){
				$html .= $form->field($model, 'email')->textInput(['class' => 'form-control js_clear']);
				$html .= '<button id="extra_smt" type="submit">'.Yii::t('blog', 'RESULT_SEND').'</button>';
			}else{
				$model->email = Yii::$app->user->identity->email;
				$html .= Html::hiddenInput('email', $model->email);
			}
			$html .= '</div>';
			$html .= '</div>';
			echo $html;
		?>
	
		<?= Html::hiddenInput('sum', $model->sum, ['id' => 'result_generation']); ?>

		<div class="comp_container">
			<div class="comp_title"><?= Yii::t('blog', 'COMP_TITLE') ?></div>
			<div class="comp_calc">
				<div class="my_grade grade_visible grade_1"><?= Yii::t('blog', 'EASY') ?></div>
				<div class="my_grade grade_2"><?= Yii::t('blog', 'EASY_TO_MODERATE') ?></div>
				<div class="my_grade grade_3"><?= Yii::t('blog', 'MODERATE') ?></div>
				<div class="my_grade grade_4"><?= Yii::t('blog', 'DIFFICULT') ?></div>
			</div>
			<?= $form->field($model, 'complexity')->widget(RangeInput::classname(), [
					'html5Options' => ['min' => 1, 'max' => 4, 'step' => 1],
				])->label(false);
			?>
			<div class="description_lead">
				<div class="my_grade grade_visible grade_1"><?= Yii::t('blog', 'EASY_DESCRIPTION') ?></div>
				<div class="my_grade grade_2"><?= Yii::t('blog', 'EASY_TO_MODERATE_DESCRIPTION') ?></div>
				<div class="my_grade grade_3"><?= Yii::t('blog', 'MODERATE_DESCRIPTION') ?></div>
				<div class="my_grade grade_4"><?= Yii::t('blog', 'DIFFICULT_DESCRIPTION') ?></div>
			</div>
		</div>
		<div class="range_container">
			<div class="lead_generation_col_first">
				<div class="range_title"><?= Yii::t('blog', 'RANGE_TITLE').' ' ?><span class="range_calc"></span></div>
				<?= $form->field($model, 'range')->widget(RangeInput::classname(), [
						'html5Options' => ['min' => 20, 'max' => 200, 'step' => 1],
					])->label(false);
				?>
				<div class="little_bit"><?= Yii::t('blog','LITTLE_LEAD') ?></div>
			</div>
			<div class="lead_generation_col_second">
				<div class="result_title"><?= Yii::t('blog', 'RESULT_TITLE') ?></div>
				<div class="front_result"><span class="display_result"></span><?= ' '.Yii::t('blog', 'UAH') ?></div>
				<?= Html::submitButton(Yii::t('blog','RESULT_SEND'), ['id' => 'submit_first', 'class' => 'lead_btn_gen']) ?>
			</div>
		</div>

	<?php ActiveForm::end(); ?>
</div>
<?php
if(Yii::$app->user->isGuest){
	$extraJS = 'event.preventDefault();';
}else{
	$extraJS = '';
}
$js = <<<JS
	$('#submit_first').on('click',function(event){
		$extraJS
		$('.lead_generation_overlay').addClass('lead_generation_overlay_open');
	}); 
	$(document).keyup(function(e) {
		if (e.keyCode == 27) {
			$('.lead_generation_overlay').removeClass('lead_generation_overlay_open');
		}	
	});
	$(document).click(function(event) {
		if ($(event.target).closest("#submit_first,.lead_generation_popup").length) return;
	  	$('.lead_generation_overlay').removeClass('lead_generation_overlay_open');
		event.stopPropagation();
	});
		
JS;
$this->registerJs($js);
?>