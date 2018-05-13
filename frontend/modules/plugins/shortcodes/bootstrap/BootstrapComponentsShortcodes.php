<?php
namespace frontend\modules\plugins\shortcodes\bootstrap;

use frontend\modules\plugins\BaseShortcode;
use frontend\modules\plugins\shortcodes\bootstrap\widgets\Alert;
use frontend\modules\plugins\shortcodes\bootstrap\widgets\Label;

/**
 * Plugin Name: Bootstrap 3 Components Shortcodes
 * Version: 1.0
 * Description: A shortcodes pack with Bootstrap 3 components
 * Author: My shrtcd
 */
class BootstrapComponentsShortcodes extends BaseShortcode
{
    /**
     * @return array
     */
    public static function shortcodes()
    {
        return [
            'alert' => [
                'callback' => [Alert::class, 'widget'],
                'config' => [
                    'type' => Alert::TYPE_INFO,
                    'close' => false
                ],
                'tooltip' => '[alert close=1] ... [/alert]'
            ],
            'label' => [
                'callback' => [Label::class, 'widget'],
                'config' => [
                    'type' => Label::TYPE_PRIMARY,
                    'text' => 'label'
                ],
                'tooltip' => '[label text="*"]'
            ],
        ];
    }
}

