<?php

namespace frontend\modules\user;

/**
 * user module definition class
 */
class User extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\user\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->_registerAssets();
        parent::init();

        // custom initialization code goes here
    }

    private function _registerAssets()
    {
        $this->view->registerAssetBundle('frontend\modules\user\bundles\UserModuleAsset');
    }
}
