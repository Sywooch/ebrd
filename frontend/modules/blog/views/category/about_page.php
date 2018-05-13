<?php

use frontend\modules\blog\components\widgets\grouped_menu\BlogGroupedMenu;
use frontend\modules\blog\models\BlogCategory;
use yii\widgets\ListView;

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
?>
<div class="about_view">
	<div class="about_view_container">
		<div class="about_header">
			<div class="nav_menu_about">
				<?= BlogGroupedMenu::widget([
					'categoryId' => BlogCategory::getSubRootCat($model->id)->id
				]); ?>
			</div>
			<div class="about_name_post">
				<?= $model->menu_section ?>
			</div>
		</div>
		<div class="about_container">
			<?= frontend\modules\blog\components\widgets\auto_linker\Autolinker::widget([
				'content' => $model->content
			]);?>
		<div class="about_list_container">
			<div class="js_shortcodes"></div>
		</div>
		</div>
	</div>
</div>