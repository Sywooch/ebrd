<?php

namespace frontend\modules\blog\components\widgets\related_news;

use Yii;
use yii\base\Widget;
use frontend\modules\blog\models\BlogPost;
use yii\helpers\Url;
use common\models\User;
use drmabuse\slick\SlickWidget;
use frontend\modules\blog\models\BlogCategory;

/**
 * Widget for selecting application language
 */
class RelatedNews extends Widget
{
	public $model;
	
	private $result = '';
	
	public function init() {
		$this->_registerAssets();
		parent::init();
	}
	
	public function run() {
		$this->getLangLinks();
		return $this->result;
	}
	
	private function getLangLinks()
	{
		$posts = BlogPost::getRelatedBlogPostsById($this->model->main_category_id,$this->model->id);
		
		$this->result .= '<div class="blog_slider_container">';
		
		foreach ($posts as $post){
			$this->result .= '<div class="post_container_slider">';
			$this->result .= '<div class="post_container_slider_inside">';
			$this->result .= '<div class="post_container_slider_shadow" onclick="window.location.href= \''.Url::to(['/blog/post/front-view', 'id' => $post->id]).'\'">';

			$this->result .= '<div class="post_slider_img" style="background-image:url('.Yii::$app->imagemanager->getImagePath($post->thumbnail,1920,1080,'inset').');">';
			$this->result .= '<div class="slider_blog_overlay"></div>';

			$this->result .= '<div class="post_slider_title">'.$post->name.'</div>';
			$this->result .= '<div class="post_slider_category"><span class="slider_cat_word">'.Yii::t('blog','CATEGORY') .':</span> <a href="'.Url::to(['/blog/category/front-view', 'id' => $post->main_category_id]).'">'. BlogCategory::getCategory($post->main_category_id)[0]->name.'</a></div>';
			$this->result .= '</div>';
			$this->result .= '<div class="post_slider_content_container">';
			$this->result .= '<div class="post_slider_excerpt">'.(mb_strlen($post->excerpt) > 200) ? mb_substr($post->excerpt, 0, 120) . '...' : $post->excerpt.'</div>';
			$this->result .= '<div class="post_slider_info"><span class="slider_author">'. User::getUserById($post->author_id)->profile->full_name.', </span><span class="slider_published">'.date('d.m.y', strtotime($post->published_at)).'</span></div>';
			$this->result .= '</div>';

			$this->result .= '</div>';
			$this->result .= '</div>';
			$this->result .= '</div>';
		}
		
		$this->result .= '</div>';
		
		$this->result .= SlickWidget::widget([
			'container' => '.blog_slider_container',
			'settings'  => [
				'slick' => [
					'arrows'=> true,
					'autoplay' => true,
					'appendArrows' => '.slider_controls_widget',
					'edgeFriction' => 0,
					'prevArrow' => '<div class="prew_arrow"><svg><use xlink:href="#prew_arrow"></use></svg></div>',
					'nextArrow' => '<div class="next_arrow"><svg><use xlink:href="#next_arrow"></use></svg></div>',
					'infinite'      =>  true,
					'slidesToShow'  =>  4,
					'dots' => false,
					'responsive' => [ 
						[
							'breakpoint'=> 1279,
							'settings'=> [
							  'arrows'=> true,
							  'slidesToShow'=> 3,
							  'slidesToScroll'=> 2,
							]
						],
						[
							'breakpoint'=> 900,
							'settings'=> [
							  'arrows'=> true,
							  'slidesToShow'=> 2,
							  'slidesToScroll'=> 2,
							]
						],
						[
							'breakpoint'=> 600,
							'settings'=> [
							  'arrows'=> true,
							  'slidesToShow'=> 1,
							  'slidesToScroll'=> 1,
							]
						],
					],
				],
			],
		]);
		
	}
	
	private function _registerAssets()
	{
		$this->view->registerAssetBundle('frontend\modules\blog\components\widgets\related_news\bundles\RelatedNewsAsset');
	}
}