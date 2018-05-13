<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Redirects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="redirects-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'old_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'new_url')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('user', 'Create') : Yii::t('user', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
