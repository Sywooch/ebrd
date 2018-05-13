<?php

namespace frontend\modules\plugins\shortcodes\content\eventslider;

use frontend\modules\blog\models\BlogEvent;
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
class EventSliderWidget extends ShortcodeWidget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->getBlogStructure();
    }

    private function getBlogStructure()
    {
        Yii::$app->cache->flush();
        $events = BlogEvent::getBlogEventsSlider();

        $html = '<div class="event-title_slider">
                    <div></div>
                        <div class="event-title_slider_inside">
                            <span class="colored_numbers">' . Yii::t('blog', 'UBP') . ' </span>'
            . Yii::t('blog', 'EVENTS') . '
                        </div>
                        <div class="event_slider_controls_widget"></div>
                    </div>';

        $html .= '<div class="event_slider_container">';

        foreach ($events as $event) {
            $html .= '<div class="post_container_slider">';
            $html .= '<div class="post_container_slider_inside">';

            $html .= '<div class="post_slider_img" style="background-image:url(' . Yii::$app->imagemanager->getImagePath($event->picture, 557, 281, 'inset') . ');"></div> ';
            $html .= '<div class="post_slider_title">' . ((mb_strlen($event->title, 'UTF-8') > 70) ? (mb_substr($event->title, 0, 70) . '...') : ($event->title)) . '</div>';

            $html .= '<div class="post_slider_info flex__jcsb">
							<div class="flex">
								<span class="post_slider_text"><nobr>' . date('d', strtotime($event->date_begin)) . '-' . date('d.m.Y', strtotime($event->date_end)) . '</nobr></span>
								<a class="post_slider_link" href=""><nobr></nobr></a>
							</div>

							<div class="flex">
								<span class="post_slider_text"><nobr></nobr>,</span>
								<span class="post_slider_text"><nobr>Country</nobr></span>
							</div>
						    </div>';

            $html .= '<a class="button__white" href="' . Url::to(['/blog/event/front-view', 'id' => $event->id]) . '">' . Yii::t('blog', 'DETAILS') . '</a>';

            $html .= '</div>';
            $html .= '</div>';
        }

        $html .= '</div>';

//        $html .= '<a class="button__ma" href="' . Url::to(['/blog']) . '">' . Yii::t('blog', 'VIEW_ALL_BLOG') . '</a>';

        $html .= SlickWidget::widget([
            'container' => '.event_slider_container',
            'settings' => [
                'slick' => [
                    'arrows' => true,
                    'autoplay' => true,
                    'appendArrows' => '.event_slider_controls_widget',
                    'edgeFriction' => 0,
                    'prevArrow' => '<div class="prew_arrow"><svg><use xlink:href="#prew_arrow"></use></svg></div>',
                    'nextArrow' => '<div class="next_arrow"><svg><use xlink:href="#next_arrow"></use></svg></div>',
                    'infinite' => true,
                    'slidesToShow' => 2,
                    'slidesToScroll' => 2,
                    'dots' => true,
                    'responsive' => [
                        [
                            'breakpoint' => 1100,
                            'settings' => [
                                'arrows' => true,
                                'slidesToShow' => 1,
                                'slidesToScroll' => 1,
                            ]
                        ],
                    ],
                ],
            ],
        ]);

        return $html;
    }
}