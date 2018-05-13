<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogEvent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-event-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stakeholder_id')->dropDownList($stakeholders) ?>

    <?= $form->field($model, 'lang_id')->dropDownList($languages) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'site_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'place')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'date_begin')->widget(\kartik\date\DatePicker::classname(), [
        'options' => ['placeholder' => Yii::t('blog', 'SELECT_DATE_BEGIN')],
        'pluginOptions' => [
            'language' => Yii::$app->language,
            'autoclose'=>true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd',
        ]
    ]); ?>

    <?= $form->field($model, 'date_end')->widget(\kartik\date\DatePicker::classname(), [
        'options' => ['placeholder' => Yii::t('blog', 'SELECT_DATE_END')],
        'pluginOptions' => [
            'language' => Yii::$app->language,
            'autoclose'=>true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd',
        ]
    ]); ?>

    <?= $form->field($model, 'picture')->widget(\noam148\imagemanager\components\ImageManagerInputWidget::className(), [
        'aspectRatio' => (16/9), //set the aspect ratio
        'cropViewMode' => 1, //crop mode, option info: https://github.com/fengyuanchen/cropper/#viewmode
        'showPreview' => true, //false to hide the preview
        'showDeletePickedImageConfirm' => false, //on true show warning before detach image
    ]);?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
