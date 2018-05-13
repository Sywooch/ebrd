<?php
use yii\helpers\Url;
use frontend\modules\blog\models\BlogCategory;
use common\models\User;
?>
<div class="post_container_slider_inside">
	<div class="post_slider_img" style="background-image:url(<?=Yii::$app->imagemanager->getImagePath($model->thumbnail,1920,1080,'inset')?>);"></div>
	<!-- <div class="slider_blog_overlay"></div> -->
	<div class="post_slider_title"><?= ((mb_strlen($model->name, 'UTF-8') > 70) ? (mb_substr($model->name, 0, 70).'...') : ($model->name)) ?></div>

	<div class="post_slider_info flex__jcsb">
		<div class="flex flex__fdc">
			<span class="post_slider_text"><?= date('d M y', strtotime($model->published_at)) ?></span>
			<a class="post_slider_link" href="<?= Url::to(['/blog/category/front-view', 'id' => $model->main_category_id]) ?>"><?= BlogCategory::getCategory($model->main_category_id)[0]->name ?></a>
		</div>

		<div class="flex flex__fdc">
			<span class="post_slider_text"><?= User::getUserById($model->author_id)->profile->full_name ?>, </span>
			<span class="post_slider_text"><?= User::getUserById($model->author_id)->profile->city ?></span>
		</div>
	</div>

	<!-- <div class="post_slider_excerpt"><?= (mb_strlen($model->excerpt) > 200) ? mb_substr($model->excerpt, 0, 120) . '...' : $model->excerpt ?></div> -->

	<a href="<?=Url::to(['/blog/post/front-view', 'id' => $model->id]) ?>" class="blog__button button button__white">qq</a>
</div>
