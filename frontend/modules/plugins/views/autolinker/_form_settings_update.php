<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\plugins\models\PluginsAutolinker */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plugins-settings-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="blog_post_col-1">
    
	<?= $form->field($model, 'setting_name') ?>

    <?= $form->field($model, 'setting_description') ?>

    <?= $form->field($model, 'settings_value') ?>

    </div>
    <div class="blog_post_col_submit">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('plugins', 'CREATE') : Yii::t('plugins', 'UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>