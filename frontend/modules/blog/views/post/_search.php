<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogPostSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-post-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="blog_post_col-1">
    <?= $form->field($model, 'alias') ?>
	
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
    <?= $form->field($model, 'lang_id')->dropDownList($items, ['prompt'=>'- '.Yii::t('blog', 'LANGUAGE').' -']) ?>
	
	<?= $form->field($model, 'main_category_id')
		->dropDownList($parent_search, ['prompt'=>'- '.Yii::t('blog', 'CATEGORIES').' -']) ?>
					
	<?= $form->field($model, 'status_id')
		->dropDownList($statusSearch, ['prompt'=>' - '.Yii::t('blog', 'ALL_STATUSES').' - '])
		->label(Yii::t('blog', 'STATUS'))?>
		
	<?= $form->field($model, 'id') ?>
    </div>
   

    <?php // echo $form->field($model, 'main_category_id') ?>

    <?php // echo $form->field($model, 'post_content') ?>

    <?php // echo $form->field($model, 'post_description') ?>

    <?php // echo $form->field($model, 'published') ?>

    <?php // echo $form->field($model, 'author_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php  //echo $form->field($model, 'favorites')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('blog', 'SEARCH'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('blog', 'RESET'), ['reset-filter', 'target' => 'post'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
