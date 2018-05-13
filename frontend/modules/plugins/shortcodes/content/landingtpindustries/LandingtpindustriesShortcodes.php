<?php
namespace frontend\modules\plugins\shortcodes\content\landingtpindustries;

use frontend\modules\plugins\BaseShortcode;

/**
 * Plugin Name: LandingTpIndustries
 * Plugin URI: 
 * Version: 1.0
 * Description: Shows the phone number depending on the location
 * Author: sasha
 */
class LandingtpindustriesShortcodes extends BaseShortcode
{
    /**
     * @return array
     */
    public static function shortcodes()
    {
        return [
            'landing_tp_industries' => [
                'callback' => [LandingtpindustriesWidget::class, 'widget'],
                'config' => [
                    'status' => true,
                ],
                'tooltip' => '[landing_tp_industries]'
            ]
        ];
    }
}

