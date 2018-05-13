<?php

use yii\widgets\ListView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogCategory */

$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'];

$this->title = $model->title;
$filterDate = Yii::$app->getRequest()->getQueryParam('date');
?>
<div class="events">

	<div class="events-filters">
		<a href="<?= Url::to(['/events', 'date' => 'future']) ?>" class="events-filters__button <?= ($filterDate != 'past')? 'events-filters__button-active': '' ?>">
			<?= Yii::t('blog', 'FUTURE_EVENTS') ?>
		</a>
		<a href="<?= Url::to(['/events', 'date' => 'past']) ?>" class="events-filters__button <?= ($filterDate == 'past')? 'events-filters__button-active': '' ?>">
			<?= Yii::t('blog', 'PAST_EVENTS') ?>
		</a>
	</div>

	<?=
	ListView::widget([
		'dataProvider' => $dataProvider,
		'itemView' => '_blog_event_list',
		'summary' => '',
		'options' => [
			'tag' => 'div',
			'class' => 'events__container',
		],
		'itemOptions' => [
			'tag' => 'div',
			'class' => 'event-item',
		],
		'pager' => [
			'linkOptions' => [
				'rel' => 'nofollow',
			],
		],
	]);
	?>

</div>
