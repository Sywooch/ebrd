<?php

namespace frontend\modules\plugins\shortcodes\content\blogslider;

use frontend\modules\plugins\shortcodes\ShortcodeWidget;
use frontend\modules\blog\models\BlogCategory;
use frontend\modules\blog\models\BlogPost;
use common\models\User;
use yii\helpers\Url;
use frontend\modules\user\models\Profile;
use drmabuse\slick\SlickWidget;
use Yii;

/**
 * Class BlogSlider
 * @package frontend\modules\plugins\shortcodes
 * @author sanja
 */
class BlogSliderWidget extends ShortcodeWidget {

	public function init() {
		parent::init();
	}

    public function run() {
		return $this->getBlogStructure();
	}

	private function getBlogStructure()
	{
		$blogAliases = BlogCategory::getBlogAliases();

		$posts = BlogPost::getBlogPostsSlider($blogAliases);

		$html = '<div class="post-title_slider">
                    <div></div>
                        <div class="post-title_slider_inside">
                            <span class="colored_numbers">'.Yii::t('blog','UBP').' </span>'
                            .Yii::t('blog','BLOG').'
                        </div>
                        <div class="slider_controls_widget"></div>
                    </div>';

		$html .= '<div class="blog_slider_container">';

		foreach ($posts as $post){
			$html .= '<div class="post">';
			$html .= '<div class="post_container_slider">';
				$html .= '<div class="post_container_slider_inside">';

						$html .= '<div class="post_slider_img" style="background-image:url('.Yii::$app->imagemanager->getImagePath($post->thumbnail,557,281,'inset').');"></div> ';
						$html .= '<div class="post_slider_title">'.((mb_strlen($post->name, 'UTF-8') > 70) ? (mb_substr($post->name, 0, 70).'...') : ($post->name)).'</div>';
						$html .= '<div class="post_slider_info flex__jcsb">
							<div class="flex flex__fdc">
								<span class="post_slider_text"><nobr>'.date('d F Y', strtotime($post->published_at)).'</nobr></span>
								<a class="post_slider_link" href="'.Url::to(['/blog/category/front-view', 'id' => $post->main_category_id]).'"><nobr>'. BlogCategory::getCategoryById($post->main_category_id)->name.'</nobr></a>
							</div>

							<div class="flex flex__fdc">
								<span class="post_slider_text"><nobr>'. Profile::findProfileByUserId($post->author_id)->full_name.'	</nobr>,</span>
								<span class="post_slider_text"><nobr>'. Profile::findProfileByUserId($post->author_id)->city .'</nobr></span>
							</div>

						</div>';

						$html .= '<a class="button__white" href="'.Url::to(['/blog/post/front-view', 'id' => $post->id]).'">'.Yii::t('blog','DETAILS').'</a>';

				$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
		}

		$html .= '</div>';

		$html .= '<a class="button__ma" href="'.Url::to(['/blog']).'">'.Yii::t('blog','VIEW_ALL_BLOG').'</a>';

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
					'slidesToShow'  =>  2,
					'slidesToScroll'=> 2,
					'dots' => true,
					'responsive' => [
						[
							'breakpoint'=> 1100,
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
