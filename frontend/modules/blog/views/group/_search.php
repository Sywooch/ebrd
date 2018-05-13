<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogGroupSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="blog_post_col-1">
    <?= $form->field($model, 'name')->textInput() ?>

    </div>
    <div class="blog_post_col-2">
    <?= $form->field($model, 'lang_id')
		->dropDownList($languageSearch, ['prompt'=>' - '.Yii::t('blog', 'LANGUAGE').' - ']) ?>
			
	<?= $form->field($model, 'status_id')
		->dropDownList($statusSearch, ['prompt'=>' - '.Yii::t('blog', 'ALL_STATUSES').' - '])
		->label(Yii::t('blog', 'STATUS'))?>
    </div>
    <div class="blog_post_col_submit">
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('blog', 'RESET'), ['reset-filter', 'target' => 'group'], ['class' => 'btn btn-default']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
