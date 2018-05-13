<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\plugins\models\PluginsAutolinker */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plugins-autolinker-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="blog_post_col-1">
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords')->textarea(['rows' => 6, 'placeholder' => 'Write the keywords through ","']) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'links_quantity')->textInput() ?>
		
	<?= $form->field($model, 'target')->dropDownList([
		'_blank' => Yii::t('plugins', 'IN_A_NEW_BROWSER_WINDOW'),
		'_self' => Yii::t('plugins', 'CURRENT WINDOW'),
	]);?>

    <?= $form->field($model, 'status')->dropDownList([
        '1' => Yii::t('plugins', 'ENABLE'),
        '0' => Yii::t('plugins', 'DISABLE'),
    ]);?>

    </div>
    <div class="blog_post_col-2">

	<?= $form->field($model, 'lang')->dropDownList([
		'en' => Yii::t('plugins', 'ENGLISH'),
		'uk' => Yii::t('plugins', 'UKRAINIAN'),
		'pl' => Yii::t('plugins', 'POLISH'),
		'zh' => Yii::t('plugins', 'CHINESE'),
		'tr' => Yii::t('plugins', 'TURKISH'),
		'pt' => Yii::t('plugins', 'PORTUGUESE'),
	]);?>
		
    <?= $form->field($model, 'info')->textarea(['rows' => 6]) ?>
    </div>
    <div class="blog_post_col_submit">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('plugins', 'CREATE') : Yii::t('plugins', 'UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
