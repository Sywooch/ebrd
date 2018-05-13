<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\catalog\models\CatalogDocument */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="catalog-element">

    <?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
		
	<div class="form-group">
        <?= Html::submitButton(Yii::t('catalog', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
	
</div>