<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogContactOfficeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-contact-office-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php // echo $form->field($model, 'id') ?>

    <?= $form->field($model, 'alias') ?>

    <?= $form->field($model, 'office_name') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'menu_section') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'office_country') ?>

    <?php // echo $form->field($model, 'office_address') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'contact_ip') ?>

    <?php // echo $form->field($model, 'lang_name') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('blog', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('blog', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
