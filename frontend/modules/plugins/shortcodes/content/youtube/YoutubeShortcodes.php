<?php
namespace frontend\modules\plugins\shortcodes\content\youtube;

use frontend\modules\plugins\BaseShortcode;
use yii\helpers\Html;

/**
 * Plugin Name: Youtube Video
 * Plugin URI: 
 * Version: 1
 * Description: Displays video from YouTube
 * Author: sasha
 */
class YoutubeShortcodes extends BaseShortcode
{
    /**
     * @return array
     */
    public static function shortcodes()
    {
        return [
            'yt' => function ($attrs, $content, $tag) {
                $title = $content ? $content : 'shortcode ' . $tag;
                if (isset($attrs['code'])) {
                    return Html::a($title, 'https://www.youtube.com/embed/' . $attrs['code'], ['target' => '_blank']);
                }
                return null;
            },
            'youtube' => [
                'callback' => [YoutubeWidget::class, 'widget'],
                'config' => [
                    'code' => 'AaKALT50XOE',
                    'w' => 560,
                    'h' => 315,
                    'controls' => 1,
                    'pull' => 'right'
                ],
                'tooltip' => '[youtube code=* w=* h=* pull=left]'
            ]
        ];
    }
}

