<?php

use frontend\modules\blog\components\widgets\grouped_menu\BlogGroupedMenu;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\modules\blog\models\BlogCategory;
use frontend\modules\blog\models\BlogGroup;

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

$lastMenuUpdate = [
	'class' => 'yii\caching\DbDependency',
	'sql' => 'SELECT MAX(up) FROM (SELECT MAX(updated_at) up FROM blog_category UNION SELECT MAX(updated_at) up FROM blog_group) AS test;',
];


if ($this->beginCache('category',[
	'duration' => 7*24*60*60,
	'variations' => [$model->id],
	'dependency' => $lastMenuUpdate
])){

?>
<div class="blog-category-view">
	<div class="blog_category_first_container">
		<?php
			if(!empty($model->thumbnail)){
				$image = 'style="background-image: url('.Yii::$app->imagemanager->getImagePath($model->thumbnail,1920,1080,'inset').');"';
			}else{
				$image = 'style="background-image: url(/images/cat_back.jpg);"';
			}
		?>
		<div class="blog_category_first_right_col" role="img" aria-label="<?= $model->thumbnail_alt ?>" <?= $image ?>>
			<div class="cat_real_overlay"></div>
			<div class="bread_container">
				<div class="breadcrumbs_blog">
					<?php

                        if(!empty($model->group_id)) {
							$currentGroup = BlogGroup::getGroupPublished($model->group_id);
							if($currentGroup->url != Url::to(['/blog/category/front-view', 'id' => $model->id]) && !empty($currentGroup->url)){
								$groupHtml = Html::a($currentGroup->name, $currentGroup->url).'<span> > </span>';
							}else{
								$groupHtml = '';
							}
						}

						if(BlogCategory::getCategory($model->parent_category_id)[0]->parent_category_id != 0){
							echo Html::a(Yii::t('blog','MAIN'),
                                Url::to(['/'])).'<span> > </span>'
                                .Html::a(
                                        BlogCategory::getCategory($model->parent_category_id)[0]->menu_section,
                                        Url::to(['/blog/category/front-view', 'id' => $model->parent_category_id])
                                )
                                .'<span> > </span>'.$groupHtml.'<span>'.$model->menu_section.'</span>';
						}else{
							echo Html::a(Yii::t('blog','MAIN'), Url::to(['/'])).'<span> > </span><span>'.$model->menu_section.'</span>';
						}
					?>
				</div>
				<div class="my_custom_new_category">
					<h1><?= Html::encode($model->name) ?></h1>
						<!-- <hr class="main_cat_hr"> -->
						<?= frontend\modules\blog\components\widgets\auto_linker\Autolinker::widget([
							'content' => $model->content
						]);
						?>
						<?php
							if(!empty($model->shortcodes)){
								echo $model->shortcodes;
							}
							if(!empty($model->last_news)){
								echo '[lastnews]';
							}
						?>
				</div>
			</div>
		</div>
		<?= BlogGroupedMenu::getMultilangCategoryStructure(Yii::$app->language, $model->id); ?>
	</div>
	<div class="js_shortcodes"></div>
	<div class="last_news"></div>
	
</div>
<?php
	$this->endCache();
}
?>
<?php
if ($showForm){
	$this->registerJs("setTimeout(function(){ $('#" . $showForm . "').click();}, 100);");
}