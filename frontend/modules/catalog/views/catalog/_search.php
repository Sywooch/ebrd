<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\catalog\models\CatalogDocumentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catalog-document-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?php // $form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'client_id') ?>

    <?php // $form->field($model, 'country_id') ?>

    <?php // $form->field($model, 'contract_number') ?>

    <?php // $form->field($model, 'contract_date') ?>

    <?php // echo $form->field($model, 'industry_id') ?>

    <?php // echo $form->field($model, 'doc_type_id') ?>

    <?php // echo $form->field($model, 'period_start_date') ?>

    <?php // echo $form->field($model, 'period_end_date') ?>

    <?php echo $form->field($model, 'document_description') ?>

    <?php // echo $form->field($model, 'file') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('catalog', 'Search'), ['class' => 'btn btn-primary']) ?>
		<?= Html::a('Reset', ['index'], ['class' => 'btn btn-default']) ?>
        
    </div>

    <?php ActiveForm::end(); ?>

</div>
