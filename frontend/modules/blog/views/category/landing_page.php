<?php

use frontend\modules\blog\components\widgets\grouped_menu\BlogGroupedMenu;
use frontend\modules\blog\models\BlogCategory;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogCategory */

$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'];

if(!empty($model->thumbnail)){
	$this->registerMetaTag(['property' => 'og:image', 'content' => $url.Yii::$app->imagemanager->getImagePath($model->thumbnail)]);
}else{
	$this->registerMetaTag(['property' => 'og:image', 'content' => $url.'/og_logo.png']);
}
$this->registerMetaTag(['property' => 'og:description', 'content' => $model->description]);
$this->registerMetaTag(['name' => 'description', 'content' => $model->description]);
$this->title = $model->title;

$lastMenuUpdate = [
	'class' => 'yii\caching\DbDependency',
	'sql' => 'SELECT MAX(up) FROM (SELECT MAX(updated_at) up FROM blog_category UNION SELECT MAX(updated_at) up FROM blog_group) AS test;',
];

if ($this->beginCache('category',[
	'duration' => 7*24*60*60,
	'variations' => [$model->id],
	'dependency' => $lastMenuUpdate
])){ ?>

	<?= frontend\modules\blog\components\widgets\auto_linker\Autolinker::widget([
		'content' => $model->content
	]);
	?>
	<div class="js_shortcodes"></div>	
<?php
	$this->endCache();
}
?>
