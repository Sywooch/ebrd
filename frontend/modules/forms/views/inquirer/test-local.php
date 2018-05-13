
<?php

use yii\bootstrap\ActiveForm;
use drmabuse\slick\SlickWidget;
use yii\helpers\Html;
/* @var $this yii\web\View */
?>




<div class="slider_main_container">
	
	
	<?php $form = ActiveForm::begin([
					'id' => 'inquirer_1',
					'options' => [
						'class' => 'single-item'
					]
				]); ?>

	
	
	<?= $form->field($model, 'importance_1', ['template' => "<div class=\"radio\">\n{input}\n{label}\n</div>"])->input('checkbox'); ?>
	
	
		<div class="slide" style="width:10000px;">
			<div class="slide_title">
				asdasd
			</div>

			<?= $form->field($model, 'importance_1')->radioList(
						[
							'1'=>'1',
							'2'=>'2',
							'3'=>'3',
							'4'=>'4',
							'5'=>'5'
						],
						[
							'item' => function($index, $label, $name, $checked, $value) {
								$return = '<input id="'.$name.'_'.$index.'" type="radio" name="' . $name . '" value="' . $value . '">';
								$return .= '<label for="'.$name.'_'.$index.'" class="modal-radio">'.$label.'</label>';
								return $return;
							},
							'class' => 'radiolist_custom',
						]
					)->label(false) ?>

			<?= $form->field($model, 'realization_1')->radioList(
						[
							'1'=>'1',
							'2'=>'2',
							'3'=>'3',
							'4'=>'4',
							'5'=>'5'
						],
						[
							'item' => function($index, $label, $name, $checked, $value) {
								$return = '<input id="'.$name.'_'.$index.'" type="radio" name="' . $name . '" value="' . $value . '">';
								$return .= '<label for="'.$name.'_'.$index.'" class="modal-radio">'.$label.'</label>';
								return $return;
							},
							'class' => 'radiolist_custom',
						]
					)->label(false) ?>

			<?= $form->field($model, 'message_1')->textarea(['rows' => '6'])->label(false) ?>
		</div>

		<div class="slide" style="width:10000px;">
			<div class="slide_title">
				asdasd
			</div>

			<?= $form->field($model, 'importance_2')->radioList(
						[
							'1'=>'1',
							'2'=>'2',
							'3'=>'3',
							'4'=>'4',
							'5'=>'5'
						],
						[
							'item' => function($index, $label, $name, $checked, $value) {
								$return = '<input id="'.$name.'_'.$index.'" type="radio" name="' . $name . '" value="' . $value . '">';
								$return .= '<label for="'.$name.'_'.$index.'" class="modal-radio">'.$label.'</label>';
								return $return;
							},
							'class' => 'radiolist_custom',
						]
					)->label(false) ?>

			<?= $form->field($model, 'realization_2')->radioList(
						[
							'1'=>'1',
							'2'=>'2',
							'3'=>'3',
							'4'=>'4',
							'5'=>'5'
						],
						[
							'item' => function($index, $label, $name, $checked, $value) {
								$return = '<input id="'.$name.'_'.$index.'" type="radio" name="' . $name . '" value="' . $value . '">';
								$return .= '<label for="'.$name.'_'.$index.'" class="modal-radio">'.$label.'</label>';
								return $return;
							},
							'class' => 'radiolist_custom',
						]
					)->label(false) ?>

			<?= $form->field($model, 'message_2')->textarea(['rows' => '6'])->label(false) ?>
		</div>
	
		<?= Html::submitButton(Yii::t('user', 'SEARCH'), ['class' => 'btn btn-primary']) ?>
	
	<?php ActiveForm::end(); ?>
	<div class="nav_arrows">
		<div class="progress_bar_slider"></div>
		<div class="arrows_online"></div>
	</div>
	<div class="slider_preloader">
		<div class="spinner"></div>
	</div>
</div>

<?= SlickWidget::widget([
	'container' => '.single-item',
	'settings'  => [
			'slick' => [
				'dots' => true,
				'swipe' => false,
				'infinite' =>  false,
				'appendDots' => '.arrows_online',
				'appendArrows' => '.arrows_online',
				'slide' => '.slide',
				'slidesToShow'  =>  1,
			],
		]
	])
?>







