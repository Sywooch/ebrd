<?php

namespace frontend\modules\plugins\shortcodes\content\competence;

use frontend\modules\plugins\BaseShortcode;

/**
 * Plugin Name: Competence shortcode
 * Plugin URI: 
 * Version: 1.0
 * Description: Use as our_clients
 * Author: sasha
 */
class CompetenceShortcodes extends BaseShortcode
{
    /**
     * @return array
     */
    public static function shortcodes()
    {
        return [
            'competence' => [
                'callback' => [CompetenceWidget::class, 'widget'],
                'config' => [
                    'hook' => '20',
                ],
                'tooltip' => '[competence]'
            ]
        ];
    }
}

