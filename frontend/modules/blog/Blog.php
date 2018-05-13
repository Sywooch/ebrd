<?php

namespace frontend\modules\blog;

/**
 * blog module definition class
 */
class Blog extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\blog\controllers';
	
	/**
	 * @var string Action for creating user-friendly category path
	 */
	public static $categoryViewAction = 'blog/category/front-view';
	
	/**
	 * @var string Action for creating user-friendly post path
	 */
	public static $postViewAction = 'blog/post/front-view';

	public static $eventViewAction = 'blog/event/front-view';

	public $testConfig = 'default';
	
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
        $this->view->registerAssetBundle('frontend\modules\blog\bundles\GoogleAutoComplete');
    }
}
