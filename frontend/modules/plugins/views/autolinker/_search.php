<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\plugins\models\PluginsAutolinkerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-post-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

	<div class="blog_post_col-1">
		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'title') ?>

		<?= $form->field($model, 'keywords') ?>
	</div>
	<div class="blog_post_col-1">
		<?= $form->field($model, 'url') ?>

		<?= $form->field($model, 'links_quantity') ?>
		
		<?= $form->field($model, 'lang')->dropDownList($languageSearch, ['prompt'=>' - '.Yii::t('blog', 'LANGUAGE').' - ']) ?>
	</div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
