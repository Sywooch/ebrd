<?php

namespace frontend\modules\team;

use Yii;
/**
 * team module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\team\controllers';
	
	/**
	 * Limit teams per user
	 * 
	 * @var integer
	 */
	public $teamsPerUser = 1;

	/**
     * @inheritdoc
     */
    public function init()
    {
		bundles\TeamModuleAsset::register(Yii::$app->view);
		
        parent::init();

        // custom initialization code goes here
    }
}
