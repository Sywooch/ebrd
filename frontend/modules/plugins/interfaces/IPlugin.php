<?php
namespace frontend\modules\plugins\interfaces;

/**
 * Interface IPlugin
 * @package frontend\modules\plugins\interfaces
 */
interface IPlugin
{
    /**
     *  [
     *      'yii\base\View' => [
     *          'afterRender' => ['hello', self::$config]
     *      ]
     *  ];
     * @return array
     */
    public static function events();
}