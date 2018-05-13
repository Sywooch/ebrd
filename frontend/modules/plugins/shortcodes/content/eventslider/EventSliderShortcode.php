<?php

namespace frontend\modules\plugins\shortcodes\content\eventslider;

use frontend\modules\plugins\BaseShortcode;

/**
 * Plugin Name: BlogSlider
 * Plugin URI: 
 * Version: 1.0
 * Description: BlogSlider
 * Author: sanja
 */
class EventSliderShortcode extends BaseShortcode
{
	
    /**
     * @return array
     */
    public static function shortcodes()
    {

        return [
            'event_slider' => [
                'callback' => [EventSliderWidget::class, 'widget'],
                'config' => [
                    'hook' => true,
                ],
                'tooltip' => '[event_slider]'
            ]

        ];
    }
}

