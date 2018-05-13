<?php

use yii\helpers\Html;
use common\widgets\Alert;
use frontend\modules\blog\components\BlogBreadcrumbs;
use frontend\modules\blog\components\widgets\get_another_language_article\GetAnotherLanguageArticle;
?>

<article class="blog-item">
	<h3>
		<?php if ($model->type == 'post'): ?>
			<?= Html::a(Html::encode($model->name), ['/blog/post/front-view', 'id' => $model->id]); ?>
		<?php else: ?>
			<?= Html::a(Html::encode($model->name), ['/blog/category/front-view', 'id' => $model->id]); ?>
		<?php endif; ?>
	</h3> 
	<div class="search_content">
		<?php // echo $model->content ?>
		
	<?php
	echo frontend\modules\blog\components\widgets\limiter\Limiter::widget([
		'text' => $model->content
	])?>
		
	</div>
	<div class="search_time_update">
        <time>
		<?= $model->updated_at ?>
		<?php if (empty($model->updated_at)) echo $model->updated_at = Yii::t('blog', 'TIME OF UPDATE IS NOT SET'); ?>
        </time>
	</div>
	<div class="search_lang">
		<?php echo GetAnotherLanguageArticle::widget([
			'defaultArticleId' => $model->id,
			'defaultArticleLangId' => $model->lang_id,
			'defaultType' => $model->type,
		]);?>
	</div>
	<p>
		<?php echo BlogBreadcrumbs::widget([
			'route' => ['/blog/category/front-view', 'id' => $model->id]
		]);
		?>
	</p>
	<?= Alert::widget() ?>
	<hr />
</article>
