<?php

namespace frontend\modules\plugins\shortcodes\content\blogslider;

use frontend\modules\plugins\BaseShortcode;

/**
 * Plugin Name: BlogSlider
 * Plugin URI: 
 * Version: 1.0
 * Description: BlogSlider
 * Author: sanja
 */
class BlogSliderShortcode extends BaseShortcode
{
	
    /**
     * @return array
     */
    public static function shortcodes()
    {

        return [
            'blog_slider' => [
                'callback' => [BlogSliderWidget::class, 'widget'],
                'config' => [
                    'hook' => true,
                ],
                'tooltip' => '[blog_slider]'
            ],
        ];
    }
}

