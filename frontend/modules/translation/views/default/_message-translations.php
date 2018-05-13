<?php

use yii\helpers\Html;

/* @var $model common\models\SourceMessage */
/* @var $languages array */

//echo '<pre>';
//var_dump($model);
//echo '</pre>';
//die();

?>

<div class="mess_trans_wrap">
	<div class="subheader"><?= Yii::t('main', 'EDIT_TRANSLATIONS'); ?></div>
	<div class="item">
		<div class="lab"><?= Yii::t('main', 'ID'); ?></div>
		<div class="val"><?= $model->id ?></div>
	</div>
	<div class="item">
		<div class="lab"><?= Yii::t('main', 'CATEGORY'); ?></div>
		<div class="val"><?= $model->category ?></div>
	</div>
	<div class="item">
		<div class="lab"><?= Yii::t('main', 'CATEGORY'); ?></div>
		<div class="val"><?= $model->message ?></div>
	</div>
	<div class="item">
		<div class="lab"><?= Yii::t('main', 'TRANSLATIONS'); ?></div>
		<div class="trans">
			<?php
			foreach ($languages as $lang){
			?>
			<div class="lang"><?= $lang ?></div>
			<div class="trble trans_line" data-lang='<?= $lang ?>' data-message='<?= $model->message ?>' data-category='<?= $model->category ?>'>
				<div class="trline"><?= Html::encode(Yii::t($model->category, $model->message, [], $lang)) ?></div>
			</div>
			<?php	
			 }
			?>
		</div>		
	</div>
	<?= Html::button(Yii::t('main', 'CLOSE'), ['class' => 'btn btn-default close_pet_pop']) ?>
</div>
