<?php
namespace frontend\modules\plugins;

use frontend\modules\plugins\interfaces\IPlugin;

/**
 * Class BasePlugin
 * @package frontend\modules\plugins
 */
abstract class BasePlugin implements IPlugin
{
    const APP_FRONTEND = 1;
    const APP_BACKEND = 2;
    const APP_COMMON = 3;
    const APP_API = 4;
    const APP_CONSOLE = 5;

    /**
     * Application id, where plugin will be worked.
     * Support values: frontend, backend, common, api
     * Default: frontend
     * @var string $appId
     */
    public static $appId = self::APP_FRONTEND;

    /**
     * Default configuration for plugin.
     * @var array $config
     */
    public static $config = [];

}