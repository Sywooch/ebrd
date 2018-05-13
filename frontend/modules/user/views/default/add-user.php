<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

//echo '<pre>';
//\yii\helpers\VarDumper::dump($roles);
//echo '</pre>';

/* @var $model frontend\modules\user\models\UserAdd */
$this->title = Yii::t('user', 'ADD_NEW_USER');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user_add wrap">
	
	<div class="main_block_class">
		<span class="main_action_title"><?= Html::encode($this->title) ?></span>
	</div>
	
	<div>
		<?php $form = ActiveForm::begin();		
		?>
		<div class="blog_post_col-1">
		<?= $form->field($model, 'email') ?>
        </div>
        <div class="blog_post_col-2">
		<?= $form->field($model, 'role')
			->dropDownList($model->roles) ?>
        </div>
        <div class="blog_post_col_submit">
		<div class="form-group">
			<?= Html::submitButton(Yii::t('user', 'ADD_USER'), ['class' => 'btn btn-success']) ?>
		</div>
        </div>
		<?php ActiveForm::end();
		?>
	</div>
</div>
