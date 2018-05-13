<?php

namespace frontend\modules\plugins\shortcodes\content\blogsliderbycategory;

use frontend\modules\plugins\BaseShortcode;

/**
 * Plugin Name: BlogSliderByCategory
 * Plugin URI: 
 * Version: 1.0
 * Description: BlogSlider
 * Author: Sasha
 */
class BlogSliderByCategoryShortcode extends BaseShortcode
{
	
    /**
     * @return array
     */
    public static function shortcodes()
    {
        return [
            'blog_slider_by_category' => [
                'callback' => [BlogSliderByCategoryWidget::class, 'widget'],
                'config' => [
                    'hook' => true,
					'category' => 'all',
                ],
                'tooltip' => '[blog_slider_by_category category="all"]'
            ]
        ];
    }
}

