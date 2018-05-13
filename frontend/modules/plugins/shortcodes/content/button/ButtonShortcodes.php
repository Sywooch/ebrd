<?php
namespace frontend\modules\plugins\shortcodes\content\button;

use frontend\modules\plugins\BaseShortcode;

/**
 * Plugin Name: Button
 * Plugin URI: 
 * Version: 0.1
 * Description: Displays the form button
 * Author: petrovich
 */
class ButtonShortcodes extends BaseShortcode
{
    /**
     * @return array
     */
    public static function shortcodes()
    {
        return [
            'button' => [
                'callback' => [ButtonWidget::class, 'widget'],
                'config' => [
					'title' => 'button',
					'extraclass' => 'btn btn-primary',
					'formid' => NULL,
					'formname' => NULL,
					'chainname' => NULL,
					'id' => NULL
                ],
                'tooltip' => '[button title=* formname=* formid=* extraclass=* id=someId] or [button title=* chainname=*]'
            ]
        ];
    }
}

