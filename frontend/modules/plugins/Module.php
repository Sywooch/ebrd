<?php

namespace frontend\modules\plugins;

use Yii;
use yii\base\InvalidConfigException;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'frontend\modules\plugins\controllers';
    public $defaultRoute = 'plugin';

    public $pluginsDir;

    public function init()
    {
        parent::init();

        if (!$this->pluginsDir) {
          throw new InvalidConfigException('"pluginsDir" must be set');
        }
    }
}
