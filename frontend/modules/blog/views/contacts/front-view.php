<?php

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogCategory */

$this->title = Yii::t('blog', 'CONTACTS');

$this->registerMetaTag(['property' => 'og:description', 'content' => Yii::t('blog', 'CONTACTS')]);
$this->registerMetaTag(['name' => 'description', 'content' => Yii::t('blog', 'CONTACTS')]);

?>
<div class="blog-contact-office-view">
	[office_location sum=all]
	
</div>

