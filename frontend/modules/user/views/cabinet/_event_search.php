<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogEventSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'action' => ['events'],
    'method' => 'get',
    'options' => [
        'data-pjax' => 1
    ],
]); ?>

<div class="cabinet-search__container">
    <?= $form->field($model, 'title')->textInput(['maxlength' => 20, 'class' => 'cabinet-search__input'])-> label(false) ?>

    <?php echo Html::submitButton('<svg><use xlink:href="#svg_search"></use></svg>', ['class' => 'cabinet-search__submit']) ?>
    <?php echo Html::a('<svg><use xlink:href="#svg_cross"></use></svg>', ['events'], ['class' => 'cabinet-search__reset']) ?>
</div>

<?php ActiveForm::end(); ?>

