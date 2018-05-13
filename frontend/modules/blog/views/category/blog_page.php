<?php

use frontend\modules\blog\models\BlogCategory;
use yii\widgets\ListView;
use frontend\models\HdbkLanguage;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogCategory */

$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'];

if(!empty($model->thumbnail)){
	$this->registerMetaTag(['property' => 'og:image', 'content' => $url.Yii::$app->imagemanager->getImagePath($model->thumbnail)]);
}else{
	$this->registerMetaTag(['property' => 'og:image', 'content' => $url.'/og_logo.png']);
}
$description = empty($model->description) ? $model->title : $model->description;

$this->registerMetaTag(['property' => 'og:description', 'content' => $description]);
$this->registerMetaTag(['name' => 'description', 'content' => $description]);
$this->title = $model->title;

?>
<div class="news_view">

	<div class="filter_container">
		<?php
		$html = '';
		$filterLinks = BlogCategory::find()
		->where([
			'blog_category.alias' => $childBlogCategory,
			'blog_category.lang_id' => HdbkLanguage::getLanguageByCode(Yii::$app->language)
		])
		->orderBy('name')
		->all();
		foreach ($filterLinks as $filterLink){
			if(Url::to(['/blog/category/front-view', 'id' => $filterLink->id]) === Url::to(['/blog/category/front-view', 'id' => $model->id])){
				$concatClass = ' current_filter';
			}else{
				$concatClass = '';
			}
			$html .= '<div class="filter_inside'.$concatClass.'">';
			$html .= '<a href="'.Url::to(['/blog/category/front-view', 'id' => $filterLink->id]).'">'.$filterLink->name.'</a>';
			if(Url::to(['/blog/category/front-view', 'id' => $filterLink->id]) === Url::to(['/blog/category/front-view', 'id' => $model->id])){
				$res = (Yii::$app->language === Yii::$app->params['settings']['defaultLanguage']) ? '' : '/'.Yii::$app->language;
			}else{
				$html .= '';
			}
			$html .= '</div>';
		}
		echo $html;
		?>
	</div>

	<div class="posts_container">
		<?=
		ListView::widget([
			'dataProvider' => $dataProvider,
			'itemView' => '_blog_list',
			'summary' => '',
			'options' => [
				'tag' => 'div',
				'class' => 'list_news_wrapper',
			],
			'itemOptions' => [
				'tag' => 'div',
				'class' => 'post',
			],
			'pager' => [
				'linkOptions' => [
					'rel' => 'nofollow',
				],
			],
			
		]);
		?>
	</div>
</div>