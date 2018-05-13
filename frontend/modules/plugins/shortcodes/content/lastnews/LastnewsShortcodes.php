<?php

namespace frontend\modules\plugins\shortcodes\content\lastnews;

use frontend\modules\plugins\BaseShortcode;

/**
 * Plugin Name: Last news
 * Plugin URI: 
 * Version: 1.0
 * Description: Shows the last four news
 * Author: Sanya
 */
class LastnewsShortcodes extends BaseShortcode
{
	
    /**
     * @return array
     */
    public static function shortcodes()
    {
        return [
            'lastnews' => [
                'callback' => [LastnewsWidget::class, 'widget'],
                'config' => [
                    'hook' => true,
                ],
                'tooltip' => '[lastnews]'
            ]
        ];
    }
}

