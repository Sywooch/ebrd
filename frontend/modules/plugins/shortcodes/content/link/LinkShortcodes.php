<?php
namespace frontend\modules\plugins\shortcodes\content\link;

use frontend\modules\plugins\BaseShortcode;

/**
 * Plugin Name: Custom Link
 * Plugin URI: 
 * Version: 1.0
 * Description: Shows the phone number depending on the location
 * Author: sasha
 */
class LinkShortcodes extends BaseShortcode
{
    /**
     * @return array
     */
    public static function shortcodes()
    {
        return [
            'link' => [
                'callback' => [LinkWidget::class, 'widget'],
                'config' => [
                    'url' => '/',
					'title' => 'link',
					'src' => 'not_right'
                ],
                'tooltip' => '[link title="*" url="*" src=""]'
            ]
        ];
    }
}

