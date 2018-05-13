<?php
namespace frontend\modules\plugins\interfaces;

/**
 * Interface IPlugin
 * @package frontend\modules\plugins\interfaces
 */
interface IShortcode
{
    /**
     *  [
     *      'code' => ['lo\plugins\plugins\code\Code', 'widget'],
     *      'anothershortcode'=>function($attrs, $content, $tag){
     *          .....
     *      },
     *  ];
     * @return array
     */
    public static function shortcodes();
}