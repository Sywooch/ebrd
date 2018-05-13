<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

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
	
	<?= $form->field($model, 'email') ?>
    </div>
    <div class="blog_post_col-2">
	<?= $form->field($model, 'role')
		->dropDownList(ArrayHelper::map($roles, 'name', 'name'), ['prompt' => ' - ' . Yii::t('user', 'ROLE') . ' - '])?>
	
	<?= $form->field($model, 'status_id')
		->dropDownList($statuses, ['prompt' => ' - ' . Yii::t('user', 'STATUS') . ' - ']) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('user', 'SEARCH'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('user', 'RESET'), ['reset-filter', 'target' => 'user'], ['class' => 'btn btn-default']) ?>
    </div>
	<?php ActiveForm::end(); ?>
</div>

