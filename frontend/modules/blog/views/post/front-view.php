<?php

use yii\helpers\Url;
use frontend\modules\blog\components\widgets\auto_linker\Autolinker;
use frontend\modules\blog\components\widgets\blog_menu\BlogMenu;
use common\models\User;
use yii\helpers\Html;
use frontend\modules\blog\models\BlogCategory;
use frontend\components\widgets\share_btns_blog\ShareButtonsBlog;
use frontend\modules\blog\components\widgets\related_news\RelatedNews;
use frontend\modules\blog\components\widgets\facebookComments\FacebookComments;
/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogPost */

$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'];

if(!empty($model->thumbnail)){
	$this->registerMetaTag(['property' => 'og:image', 'content' => $url.Yii::$app->imagemanager->getImagePath($model->thumbnail)]);
}else{
	$this->registerMetaTag(['property' => 'og:image', 'content' => $url.'/images/logo/logo.png']);
}
$description = empty($model->description) ? $model->title : $model->description;

$this->registerMetaTag(['property' => 'og:description', 'content' => $description]);
$this->registerMetaTag(['name' => 'description', 'content' => $description]);
$this->title = $model->title;

?>
<div class="news_view">
	<div itemscope itemtype="http://schema.org/BlogPosting" class="blog-post-view">
		<div class="blog_text_inside">
		<link itemprop="mainEntityOfPage" itemscope href="<?= $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'] . Url::to(['/blog/post/front-view', 'id' => $model->id]) ?>" />
		<div class="hide" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
			<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
				<img alt="Logo <?= Yii::$app->name ?>" itemprop="image url" src="<?= $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].'/og_logo.png' ?>"/>
				<meta itemprop="width" content="200">
				<meta itemprop="height" content="200">
			</div>
			<meta itemprop="telephone" content="+380442909435">
			<meta itemprop="address" content="04116 Ukraine, Kyiv, 3 Sholudenka st., office 310">
			<meta itemprop="name" content="<?= Yii::$app->name ?>">
		</div>
		<meta itemprop="datePublished" content="<?= $res = empty($model->published_at) ? date('Y-m-d',strtotime($model->created_at)) : $model->published_at ?>">
		<meta itemprop="dateModified" content="<?= date('Y-m-d',strtotime($model->updated_at)) ?>">
		<span class="hide" itemprop="author" itemscope itemtype="http://schema.org/Organization">
			<span itemprop="name"><?= Yii::$app->name ?></span>
		</span>
		<div class="blog-post" id="scroll">
			<?php if($model->show_author == 1){ ?>
				<div class="blog-post__head">
					<div class="blog-post__head-container">

						<div class="breadcrumbs">
							<?= Html::a(Yii::t('blog','MAIN'), Url::to(['/'])).'<span> > </span>'.Html::a(Yii::t('blog','BLOG'), Url::to(['/blog'])).'<span> > </span>'.Html::a( BlogCategory::getCategory($model->main_category_id)[0]->name, Url::to(['/blog/category/front-view', 'id' => $model->main_category_id])).'<span> > </span>'.'<span class="breadcrumbs__current">'.$model->name.'</span>' ?>
						</div>

						<h1 itemprop="headline" class="blog-post__head-title"><?= $model->name ?></h1>
						<div class="blog-post-author">

							<div class="blog-post-author__container">
								<?php
								if(!empty($model->author_id)){

									if(empty($model->published_at)){
										$myDate = $model->created_at;
									}else{
										$myDate = $model->published_at;
									}
									echo '<div class="blog-post-author__box"><div class="blog-post-author__date"><span class ="blog-post-author__text">'.date('d M Y',strtotime($myDate)).'</span></div>';

									echo '<div class="blog-post-author__category"><span class ="blog-post-author__text">'.Html::a( BlogCategory::getCategory($model->main_category_id)[0]->name, Url::to(['/blog/category/front-view', 'id' => $model->main_category_id])).'</span></div></div>';?>

									<div class="blog-post-author__avatar" style="background-image:url(/images/avatars/<?= $author->profile->avatar; ?>);"></div>

									<?php
									$author = User::getUserById($model->author_id);
									echo '<div class="blog-post-author__user"><span class ="blog-post-author__text">'.Yii::t('blog','AUTHOR').': '.$author->profile->full_name.'</span></div>';

									// if(!empty($model->time_to_read)){
										// echo '<div class="time_to_read_main"><span class="info_class"><svg><use xlink:href="#clock"></use></svg>'.Yii::t('blog', 'MIN_TO_READ').':</span> '.$model->time_to_read.' '.Yii::t('blog', 'MIN').'</div>';
									// }
								}
								?>
							</div>

						</div>
					</div>
				</div>
		<?php } ?>
			<div class="schema" itemprop="articleBody">
			<span class="hide" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
				<img itemprop="image url" alt="Thumbnail" width="200" height="200" src="<?= Yii::$app->imagemanager->getImagePath($model->thumbnail); ?>"/>
				<meta itemprop="width" content="200">
				<meta itemprop="height" content="200">
			</span>
			<?php if (\frontend\modules\blog\components\widgets\votes\Votes::getRates($model->id,true)['votesCount'] > 0){ ?>
				<span class="hide" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
						<meta itemprop="ratingValue" content="<?= \frontend\modules\blog\components\widgets\votes\Votes::getRates($model->id,true)['rating'] ?>">
						<meta itemprop="bestRating" content="5">
						<meta itemprop="ratingCount" content="<?= \frontend\modules\blog\components\widgets\votes\Votes::getRates($model->id,true)['votesCount'] ?>">
				</span>
			<?php }?>
			<?php if($model->show_author == 1){ ?>
				<div class="blog-post__content">
			<?php } ?>

					<?= Autolinker::widget(['content' => $model->content]);?>

			<?php if($model->show_author == 1){ ?>
				</div>
			<?php } ?>
				</div>
			</div>
			<?php if($model->show_author == 1){ ?>
				<div class="footer_main_blog">
					<div class="social_blog_container">
						<div class="blog_share_title"><?= Yii::t('blog', 'MAIN_SOCIAL_TEXT') ?></div>
						<?= ShareButtonsBlog::widget(); ?>
					</div>
					<?php // \frontend\modules\blog\components\widgets\votes\Votes::widget
							// ([
						// 'postId' => $model->id,
						// 'name' => $model->name,
						// 'description' => $model->description,
						// 'isBlogPost' => true
							// ])
					?>
					<?= BlogMenu::widget(['childBlogCategory' => $childBlogCategory, 'model' => $model]);?>
					<!-- <div class="related_news_container_new">
						<?php // RelatedNews::widget(['model' => $model]); ?>
					</div> -->
				</div>
			<?php } ?>
		</div>
		<!--	 FB comments-->
	<?= FacebookComments::widget(); ?>
	</div>
</div>
