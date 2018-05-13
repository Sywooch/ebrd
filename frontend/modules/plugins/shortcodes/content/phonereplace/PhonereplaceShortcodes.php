<?php
namespace frontend\modules\plugins\shortcodes\content\phonereplace;

use frontend\modules\plugins\BaseShortcode;

/**
 * Plugin Name: Phone Number
 * Plugin URI: 
 * Version: 1.1
 * Description: Shows the phone number depending on the location
 * Author: sasha
 */
class PhonereplaceShortcodes extends BaseShortcode
{
    /**
     * @return array
     */
    public static function shortcodes()
    {
        return [
            'phone_number' => [
                'callback' => [PhonereplaceWidget::class, 'widget'],
                'config' => [
                    'phone' => '+380 44 290 94 35',
                ],
                'tooltip' => '[phone_number phone="*" ]'
            ]
        ];
    }
}

