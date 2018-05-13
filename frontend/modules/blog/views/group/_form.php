<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogGroup */
/* @var $form yii\widgets\ActiveForm */
/* @var $languages array */

?>

<div class="blog-group-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?php
		if(!empty($translateRow)){
			echo Html::hiddenInput('BlogMapEntityLang[id]', $translateRow->id);
		}
	?>
    <div class="blog_post_col-1">
	<div id="name">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	</div>
    </div>
    <div class="blog_post_col-2">
	<?= $form->field($model, 'url')->textInput() ?>

    <?= $form->field($model, 'lang_id')->dropDownList($items) ?>
    </div>
    <div class="blog_post_col_submit">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('blog', 'CREATE') : Yii::t('blog', 'UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
