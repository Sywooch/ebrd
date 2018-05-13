<?php

use yii\widgets\ListView;

$this->registerMetaTag(['property' => 'og:image', 'content' => $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].'/og_logo.png']);
$this->registerMetaTag(['property' => 'og:description', 'content' => Yii::t('settings',Yii::$app->params['settings']['mainPageDescription'])]);
$this->registerMetaTag(['name' => 'description', 'content' => Yii::t('settings',Yii::$app->params['settings']['mainPageDescription'])]);
$this->title = Yii::t('settings',Yii::$app->params['settings']['mainPageTitle']);

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogCategory */
$lastPostUpdate = [
	'class' => 'yii\caching\DbDependency',
	'sql' => 'SELECT MAX(up) FROM (SELECT MAX(updated_at) up FROM blog_category UNION SELECT MAX(updated_at) up FROM blog_group) AS test;',
	'reusable' => true,
];
if ($this->beginCache('main_page_cache',[
	'duration' => 7*24*60*60,
	'variations' => [Yii::$app->language],
	'dependency' => $lastPostUpdate,
])){
?>

<div class="main_page_view">
	<div class="main_page_view_container">
		<?=
			ListView::widget([
				'dataProvider' => $dataProvider,
				'itemView' => '_list',
				'summary' => '',
			]);
		?>
	</div>
</div>
<?php
	$this->endCache();
}
// echo \frontend\modules\blog\components\widgets\votes\Votes::widget
// 		([
// 	'postId' => 64000,
// 	'name' => Yii::t('settings',Yii::$app->params['settings']['mainPageTitle']),
// 	'description' => Yii::t('settings',Yii::$app->params['settings']['mainPageDescription'])
// 		]);

if ($openStartProjectForm || $openStartProjectBrief){
	$js = <<<JS
	$("#customModal").removeClass();
	$('#customModal').addClass('myModal');
	$('.myModalContainer').addClass('opened_magick');
	$('#customModal').addClass('$openClassForm');
	$.get({
		url : '/forms/default/form',
		data : {
			formId:'$openStartProjectForm',
			chainId:'$openStartProjectBrief'
		}
	}).done(function(r){
		$('#customModal').html(r);
	});
JS;
		$this->registerJs($js);
}
