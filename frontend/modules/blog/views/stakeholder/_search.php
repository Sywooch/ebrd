<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\SearchBlogStakeholder */
/* @var $form yii\widgets\ActiveForm */

$url = \yii\helpers\Url::to(['/blog/stakeholder/location-list']);
?>


<?php
	Pjax::begin(['id' => 'stakeholdersearch']);
	$form = ActiveForm::begin([
	'action' => ['/stakeholders'],
	'method' => 'get',
	'options' => [
		'id' => 'searchform',
		'name' => 'stakeholdersearch',
		'class' => 'stakeholders-search__container',
		'data-pjax' => true,
	],
]); ?>


<div class="stakeholders-search__box">
	<?php echo $form->field($model, 'group_id')->dropDownList($model->getRegions(), ['prompt' => Yii::t('blog', 'STAKEHOLDERS_COMPANY_TYPE'), 'id' => 'searchgroup'])->label(false) ?>

	<?php echo $form->field($model, 'location')->label(false)->widget(Select2::classname(), [
			'data' => $model->getLocations(),
			'options' => ['placeholder' => Yii::t('blog', 'STAKEHOLDER_REGION_SEARCH'), 'id' => 'locationselect', 'class' => 'form-control'],
			'pluginOptions' => [
				'allowClear' => true
			],
		]);
	?>
</div>
	<?php $html = '<svg><use xlink:href="#s_glass_icon"></use></svg></div>';?>
	<?= $form->field($model, 'name')->textInput(['placeholder' => Yii::t('blog', 'SEARCH')])->label(false) ?>

<?php // echo $form->field($model, 'description') ?>
<?php
	ActiveForm::end();
	Pjax::end();
	?>

