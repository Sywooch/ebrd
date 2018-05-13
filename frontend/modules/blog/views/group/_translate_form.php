<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogPost */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-post-form blog-post-form-c-translate">

    <?php $form = ActiveForm::begin(); ?>
    <div class="blog_post_col-1">
    <?= $form->field($old_model, 'name')->textInput(['maxlength' => true, 'readonly' => true]) ?>

	<?= $form->field($old_model, 'url')->textInput(['maxlength' => true, 'readonly' => true]) ?>
	
    <?= $form->field($old_model, 'lang_id')->dropDownList($items,
			['prompt'=>' - '.Yii::t('blog', 'LANGUAGE').' - ',
              'onchange'=>'
                $.post( "'.Yii::$app->urlManager->createUrl('/blog/category/list-by-lang?id=').'"+$(this).val(), function( data ) {
                  $( "select#blogpost-main_category_id" ).html( data );
                });
            ','disabled' => true]); ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>


<div class="blog-post-form blog-post-form-c-translate">

	
	
    <?php $form = ActiveForm::begin(); ?>
	
	<?php
		if(!empty($translateRow)){
			echo Html::hiddenInput('BlogMapEntityLang[id]', $translateRow->id);
		}
	?>
    <div class="blog_post_col-1">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'url')->textInput() ?>

    <?= $form->field($model, 'lang_id')->dropDownList($newLangCode);?>
    </div>
    <div class="blog_post_col_submit">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('blog', 'CREATE') : Yii::t('blog', 'UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
