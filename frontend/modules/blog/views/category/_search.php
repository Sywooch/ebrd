<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogCategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="blog_post_col-1">
    <?= $form->field($model, 'alias') ?>

    <?php // echo $form->field($model, 'name') ?>

	<div>
		<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	</div>
	<div>
	<?= $form->field($model, 'title')->textInput() ?>
	</div>
	<div>
	<?= $form->field($model, 'menu_section')->textInput() ?>
	</div>
    </div>
    <div class="blog_post_col-2">
    <?= $form->field($model, 'lang_id')
		->dropDownList($items, ['prompt'=>' - '.Yii::t('blog', 'LANGUAGE').' - ']) ?>

	<?= $form->field($model, 'parent_category_id')
		->dropDownList($parentSearch, ['prompt'=>' - '.Yii::t('blog', 'CATEGORIES').' - ']) ?>

	<?= $form->field($model, 'group_id')
		->dropDownList($groupSearch, ['prompt'=>' - '.Yii::t('blog', 'GROUPS').' - '])
		->label(Yii::t('blog', 'GROUP'))?>

	<?= $form->field($model, 'status_id')
		->dropDownList($statusSearch, ['prompt'=>' - '.Yii::t('blog', 'ALL_STATUSES').' - '])
		->label(Yii::t('blog', 'STATUS'))?>

    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('blog', 'SEARCH'), ['class' => 'btn btn-primary']) ?>
		<?= Html::a(Yii::t('blog', 'RESET'), ['reset-filter', 'target' => 'category'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
