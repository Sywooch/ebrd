<?php

namespace frontend\modules\plugins\shortcodes\content\initialize;

use frontend\modules\plugins\BaseShortcode;

/**
 * Plugin Name: Initialize
 * Plugin URI:
 * Version: 1.0
 * Description: Initialize
 * Author: sanja
 */
class InitializeShortcode extends BaseShortcode
{

    /**
     * @return array
     */
    public static function shortcodes()
    {
        return [
            'initialize' => [
                'callback' => [InitializeWidget::class, 'widget'],
                'config' => [
                    'slider_class' => 'body',
					'slide_to_show' => 1,
					'dots' => true,
					'arrows' => true,
					'append_arrows' => '',
					'append_dots' => '',
					'desktop' => 1,
                    'tablet' => 1,
					'tabletsm' => 1,
					'mobile' => 1,
					'as_nav' => '',
					'fading' => false,
                ],
                'tooltip' => '[initialize slider_class=* slide_to_show=* dots=* append_arrows=* append_dots=* desktop=* tablet=* tabletsm=* mobile=* as_nav=* arrows=* fading=*]'
            ]
        ];
    }
}

