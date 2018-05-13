<?php
namespace frontend\modules\plugins\shortcodes\content\landingtpmethods;

use frontend\modules\plugins\BaseShortcode;

/**
 * Plugin Name: LandingTpMethods
 * Plugin URI: 
 * Version: 1.0
 * Description: Shows the phone number depending on the location
 * Author: sasha
 */
class LandingtpmethodsShortcodes extends BaseShortcode
{
    /**
     * @return array
     */
    public static function shortcodes()
    {
        return [
            'landing_tp_methods' => [
                'callback' => [LandingtpmethodsWidget::class, 'widget'],
                'config' => [
                    'status' => true,
                ],
                'tooltip' => '[landing_tp_methods]'
            ]
        ];
    }
}

