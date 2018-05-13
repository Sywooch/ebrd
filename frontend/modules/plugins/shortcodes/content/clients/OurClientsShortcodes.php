<?php

namespace frontend\modules\plugins\shortcodes\content\clients;

use frontend\modules\plugins\BaseShortcode;

/**
 * Plugin Name: Our Clients
 * Plugin URI: 
 * Version: 1.1
 * Description: Use as our_clients
 * Author: sasha
 */
class OurClientsShortcodes extends BaseShortcode
{
    /**
     * @return array
     */
    public static function shortcodes()
    {
        return [
            'our_clients' => [
                'callback' => [OurClientsWidget::class, 'widget'],
                'config' => [
                    'hook' => '19',
                ],
                'tooltip' => '[our_clients]'
            ]
        ];
    }
}

