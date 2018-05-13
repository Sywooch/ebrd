<?php

namespace frontend\modules\plugins\shortcodes\content\emailform;

use frontend\modules\plugins\BaseShortcode;

/**
 * Plugin Name: Email form
 * Plugin URI: 
 * Version: 1.0
 * Description: Shows Email form
 * Author: sasha
 */
class EmailformShortcodes extends BaseShortcode
{
    /**
     * @return array
     */
    public static function shortcodes()
    {
        return [
            'emailform' => [
                'callback' => [EmailformWidget::class, 'widget'],
                'config' => [
                    'form_id' => '2',
                ],
                'tooltip' => '[emailform form_id=*]'
            ]
        ];
    }
}

