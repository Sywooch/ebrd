<?php
/* @var $model frontend\modules\blog\udels\BlogCategory */
/* @var $field string */

if (empty($target)){
	$target = FALSE;
	$prefix = 'source_';
} else {
	$prefix = 'target_';
}
?>

<div class="<?= $prefix ?>trans_block">
	<div class="<?= $prefix ?>trans_lable" contenteditable="false"><?= Yii::t('blog', strtoupper($field)) ?></div>
	<div class="<?= $prefix ?>trans_cont" contenteditable="true"  data-field="<?= $field ?>"><?= $model->{$field} ?></div>
</div>

