<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\modules\plugins\models\PluginsCountryLocationCode;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogContactOffice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-contact-office-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="blog_post_col-1">
    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'menu_section')->textInput(['maxlength' => true, 'value' => 'contacts']) ?>
    </div>
    <div class="blog_post_col-2">
    <?= $form->field($model, 'office_name')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'office_country')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'office_address')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
		<?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'lang_name')->dropDownList(ArrayHelper::map(
			PluginsCountryLocationCode::find()->with('countrycode')->all(), 'cc_iso', function($items) {
			return $items->country_name;
		}));	
	?>	
    </div>
    
    <div class="blog_post_col_submit">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('blog', 'CREATE') : Yii::t('blog', 'UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
