<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogEventSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-event-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'stakeholder_id') ?>

    <?= $form->field($model, 'lang_id') ?>

    <?= $form->field($model, 'alias') ?>

    <?= $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'site_url') ?>

    <?php // echo $form->field($model, 'place') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'picture') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
