<?php

use frontend\modules\blog\models\BlogCategory;
use frontend\modules\blog\models\BlogHdbkStatus;

/* @var $model frontend\modules\blog\models\BlogCategory */

?>

<div class="cat_status">
	<div id="el_status"><?= Yii::t('blog',
			'CURRENT STATUS OF THIS MATERIAL IS "{status}". TO CHANGE THE STATUS PRESS THE BUTTON BELOW',
			['status' => Yii::t('blog', $model->status->name)]) ?></div>
	
	<?php
	if (($model->status_id === BlogCategory::STATUS_DRAFT) ||
		($model->status_id === BlogCategory::STATUS_REJECTED_BY_PUBLISHER) ||
		($model->status_id === BlogCategory::STATUS_UNPUBLISHED) ){
	?>
	<div><?= BlogHdbkStatus::getButtonForPublication($model); ?></div>
	<?php
	} elseif (($model->status_id === BlogCategory::STATUS_FOR_CONFIRMATION) ||
		($model->status_id === BlogCategory::STATUS_PUBLISHED)){
	?>
		<div><?= BlogHdbkStatus::getButtonToDraft($model); ?></div>
	<?php
	}
	?>
</div>
