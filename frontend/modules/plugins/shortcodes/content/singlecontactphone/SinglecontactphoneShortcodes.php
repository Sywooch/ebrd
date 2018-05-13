<?php
namespace frontend\modules\plugins\shortcodes\content\singlecontactphone;

use frontend\modules\plugins\BaseShortcode;

/**
 * Plugin Name: Single contact phone number
 * Plugin URI: 
 * Version: 1.0
 * Description: Single local phone from the admin/contacts/Separate phones
 * Author: sasha
 */
class SinglecontactphoneShortcodes extends BaseShortcode
{
    /**
     * @return array
     */
    public static function shortcodes()
    {
        return [
            'single_contact_phone' => [
                'callback' => [SinglecontactphoneWidget::class, 'widget'],
                'config' => [
                    'phone' => '+38 (044) 290 94 35',
                ],
                'tooltip' => '[single_contact_phone]'
            ]
        ];
    }
}

