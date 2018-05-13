<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model frontend\modules\plugins\models\search\ShortcodeSearch
 * @var $form yii\widgets\ActiveForm
 */
?>

<div class="shortcode-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>
    <?= $form->field($model, 'tag') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('plugins', 'SEARCH'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('plugins', 'RESET'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
