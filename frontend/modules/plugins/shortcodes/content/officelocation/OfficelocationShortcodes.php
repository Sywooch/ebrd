<?php
namespace frontend\modules\plugins\shortcodes\content\officelocation;

use frontend\modules\plugins\BaseShortcode;

/**
 * Plugin Name: Office location shortcode
 * Plugin URI: 
 * Version: 1.0
 * Description: Display contacts, depending on the location
 * Author: sasha
 */
class OfficelocationShortcodes extends BaseShortcode
{
    /**
     * @return array
     */
    public static function shortcodes()
    {
        return [
            'office_location' => [
                'callback' => [OfficelocationWidget::class, 'widget'],
                'config' => [
                    'office_name' => '',
					'office_country' => '',
					'office_address' => '',
					'email' => '',
					'officeclass' => '',
					'sum' => false
                ],
                'tooltip' => '[office_location sum="*" officeclass="*"]'
            ]
        ];
    }
}
