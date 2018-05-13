<?php
namespace frontend\modules\plugins\core\helloworld;

use frontend\modules\plugins\BasePlugin;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Response;

/**
 * Plugin Name: Hello World
 * Version: 1
 * Description: hello world plugin
 * Author: Horkavyi Oleksandr
 */
class HelloWorld extends BasePlugin
{
    /**
     * @var array
     */
    public static $config = [
        'search' => 'obligatory',
        'replace' => 'Hello, Yii!',
        'color' => '#FFDB51'
    ];

    /**
     * @return array
     */
    public static function events()
    {
        return [
            Response::class => [
                Response::EVENT_AFTER_PREPARE => ['hello', self::$config]
            ]
        ];
    }

    /**
     * @param $event
     */
    public static function hello($event)
    {
        if (!$content = $event->sender->content) return;

        $search = ArrayHelper::getValue($event->data, 'search', self::$config['search']);
        $replace = ArrayHelper::getValue($event->data, 'replace', self::$config['replace']);
        $color = ArrayHelper::getValue($event->data, 'color', self::$config['color']);

        $event->sender->content = str_replace($search, Html::tag('span', $replace, [
            'style' => "background-color:$color;"
        ]), $content);
    }
}