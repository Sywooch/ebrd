<?php
namespace frontend\modules\plugins\shortcodes\content\landingtpactivities;

use frontend\modules\plugins\BaseShortcode;

/**
 * Plugin Name: LandingTpActivities
 * Plugin URI: 
 * Version: 1.0
 * Description: Shows the phone number depending on the location
 * Author: sasha
 */
class LandingtpactivitiesShortcodes extends BaseShortcode
{
    /**
     * @return array
     */
    public static function shortcodes()
    {
        return [
            'landing_tp_activities' => [
                'callback' => [LandingtpactivitiesWidget::class, 'widget'],
                'config' => [
                    'status' => true,
                ],
                'tooltip' => '[landing_tp_activities]'
            ]
        ];
    }
}

