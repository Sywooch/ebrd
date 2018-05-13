<?php

namespace frontend\modules\plugins\shortcodes\bootstrap;

use frontend\modules\plugins\BaseShortcode;
use frontend\modules\plugins\shortcodes\bootstrap\widgets\Collapse;
use frontend\modules\plugins\shortcodes\bootstrap\widgets\Tabs;

/**
 * Plugin Name: Bootstrap 3 JavaScript Shortcodes
 * Version: 1.0
 * Description: A shortcodes pack with Bootstrap 3 JavaScript
 */
class BootstrapJsShortcodes extends BaseShortcode
{
    /**
     * @return array
     */
    public static function shortcodes()
    {
        return [
            'tabs' => [
                'callback' => [Tabs::class, 'widget'],
                'config' => [
                    'type' => 'tabs',
                    'xclass' => false
                ],
                'tooltip' => '[tabs][tab title="*"] ... [/tab][/tabs]'
            ],
            'collapse' => [
                'callback' => [Collapse::class, 'widget'],
                'config' => [
                    'xclass' => 'sh-accordion'
                ],
                'tooltip' => '[collapse][panel title="*"] ... [/panel][/collapse]'
            ],
        ];
    }
}

