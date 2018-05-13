<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lo\plugins\models\Plugin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="blog_post_col-1">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
        </div>
        <div class="blog_post_col-2">
            <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'author_url')->textInput(['maxlength' => true]) ?>



            <?= $form->field($model, 'version')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'status')->dropDownList([
                $model::STATUS_INACTIVE => Yii::t('plugins', 'DISABLED'),
                $model::STATUS_ACTIVE => Yii::t('plugins', 'ENABLED')
            ]) ?>
        </div>

    <div class="blog_post_col_submit">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('plugins', 'CREATE') : Yii::t('plugins', 'UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
