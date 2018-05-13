<?php

namespace frontend\modules\blog\components\widgets\get_news;

use Yii;
use yii\base\Widget;
use frontend\modules\blog\models\BlogPost;
use yii\helpers\Url;
use common\models\User;
use drmabuse\slick\SlickWidget;
use frontend\modules\blog\models\BlogCategory;

class GetNews extends Widget
{
	public function run() {
		
		$blogAliases = BlogCategory::getBlogAliases();
		
		$posts = BlogPost::getBlogPostsSlider($blogAliases);
		
		
		if(!empty($posts)){
			
			$html = '<div class="post-title_slider"><div></div><div class="post-title_slider_inside"><span class="colored_numbers">'.Yii::t('blog','LAST').' </span>'.Yii::t('blog','PUBLICATIONS').'</div><div class="slider_controls_widget"></div></div>';
			
			$html .= '<div class="blog_slider_container">';
			
			foreach ($posts as $post){
				$html .= $this->buildPost($post);
			}
                    
			$html .= '</div>';
			
			$html .= '<div class="btn_view_slider_container"><a class="btn_view_slider" href="'.Url::to(['/blog']).'">'.Yii::t('blog','VIEW_ALL_BLOG').'</a></div>';
			
			$html .= SlickWidget::widget([
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
			
            return $html;

		}
                
	}
        protected function buildPost($post)
	{
		$html = '';

		$html .= '<div class="post_container_slider">';
		$html .= '<div class="post_container_slider_inside">';
		$html .= '<div class="post_container_slider_shadow" onclick="window.location.href= \''.Url::to(['/blog/post/front-view', 'id' => $post->id]).'\'">';

		$html .= '<div class="post_slider_img" style="background-image:url('.Yii::$app->imagemanager->getImagePath($post->thumbnail,1920,1080,'inset').');">';
		$html .= '<div class="slider_blog_overlay"></div>';

		$html .= '<div class="post_slider_title">'.$post->name.'</div>';
		$html .= '<div class="post_slider_category"><span class="slider_cat_word">'.Yii::t('blog','CATEGORY') .':</span> <a href="'.Url::to(['/blog/category/front-view', 'id' => $post->main_category_id]).'">'. BlogCategory::getCategory($post->main_category_id)[0]->name.'</a></div>';
		$html .= '</div>';
		$html .= '<div class="post_slider_content_container">';
		$html .= '<div class="post_slider_excerpt">'.(mb_strlen($post->excerpt) > 200) ? mb_substr($post->excerpt, 0, 120) . '...' : $post->excerpt.'</div>';
		$html .= '<div class="post_slider_info"><span class="slider_author">'. User::getUserById($post->author_id)->profile->full_name.', </span><span class="slider_published">'.date('d.m.y', strtotime($post->published_at)).'</span></div>';
		$html .= '</div>';

		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		
		return $html;
	}
}
