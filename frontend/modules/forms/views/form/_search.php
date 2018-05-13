<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\forms\models\FormSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'answer') ?>

    <?php // echo $form->field($model, 'mail_to') ?>

    <?php // echo $form->field($model, 'fields') ?>

    <?php // echo $form->field($model, 'rules') ?>

    <?php // echo $form->field($model, 'submit') ?>

    <?php // echo $form->field($model, 'extra_actions') ?>

    <?php // echo $form->field($model, 'action') ?>

    <?php // echo $form->field($model, 'method') ?>

    <?php // echo $form->field($model, 'class') ?>

    <?php // echo $form->field($model, 'form_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('forms', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('forms', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
