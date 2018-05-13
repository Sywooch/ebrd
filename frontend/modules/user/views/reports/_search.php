<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="user_search_wrap">
	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get'
	]);
	?>
	<div class="blog_post_col-1">

	<?= $form->field($model, 'team')
		->dropDownList($teamSerach, ['prompt'=>' - '.Yii::t('blog', 'ALL_TEAMS').' - '])
		->label(Yii::t('blog', 'TEAM'))
	?>
		
	<?= $form->field($model, 'type_id')
		->dropDownList($typeSearch, ['prompt'=>' - '.Yii::t('blog', 'ALL_TYPES').' - '])
		->label(Yii::t('blog', 'TYPE'))
	?>
		
	<?= $form->field($model, 'name')->textInput() ?>
	
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('user', 'SEARCH'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('user', 'RESET'), ['reset-filter', 'target' => 'reports'], ['class' => 'btn btn-default']) ?>
    </div>
	<?php ActiveForm::end(); ?>
</div>

