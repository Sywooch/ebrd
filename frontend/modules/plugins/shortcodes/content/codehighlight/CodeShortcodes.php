<?php
namespace frontend\modules\plugins\shortcodes\content\codehighlight;

use frontend\modules\plugins\BaseShortcode;

/**
 * Plugin Name: Code Highlighting
 * Version: 1.12
 * Description: A shortcode for code highlighting in view. Use as [code lang="php"]...content...[/code]
 */
class CodeShortcodes extends BaseShortcode
{
    /**
     * @return array
     */
    public static function shortcodes()
    {
        return [
            'code' => [
                'callback' => [CodeWidget::class, 'widget'],
                'tooltip' => '[code style="*" lang="*"] ... [/code]',
                'config' => [
                    'style' => 'github',
                    'lang' => 'php'
                ]
            ],
        ];
    }
}