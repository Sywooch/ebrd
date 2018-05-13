<?php

namespace frontend\modules\plugins\shortcodes\content\title;

use frontend\modules\plugins\BaseShortcode;

/**
 * Plugin Name: Title
 * Plugin URI: 
 * Version: 1.0
 * Description: Shows title
 * Author: sanja
 */
class TitleShortcodes extends BaseShortcode
{
	
    /**
     * @return array
     */
    public static function shortcodes()
    {
        return [
            'title' => [
                'callback' => [TitleWidget::class, 'widget'],
                'config' => [
                    'hook' => true,
                ],
                'tooltip' => '[title]'
            ]
        ];
    }
}

