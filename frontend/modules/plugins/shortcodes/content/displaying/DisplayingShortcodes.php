<?php

namespace frontend\modules\plugins\shortcodes\content\displaying;

use frontend\modules\plugins\BaseShortcode;

/**
 * Plugin Name: Displaying
 * Plugin URI: 
 * Version: 1.0
 * Description: Shows a static block by id
 * Author: sasha
 */
class DisplayingShortcodes extends BaseShortcode
{
    /**
     * @return array
     */
    public static function shortcodes()
    {
        return [
            'displaying' => [
                'callback' => [DisplayingWidget::class, 'widget'],
                'config' => [
                    'hook' => '19',
                ],
                'tooltip' => '[displaying hook=*]'
            ]
        ];
    }
}

