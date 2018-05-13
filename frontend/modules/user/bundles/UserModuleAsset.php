<?php

namespace frontend\modules\user\bundles;

use yii\web\AssetBundle;

class UserModuleAsset extends AssetBundle
{
	/**
     * @inheritdoc
     */
	public $sourcePath = '@frontend/modules/user/assets';  
	
	/**
     * @inheritdoc
     */	
    public $js = [ 
        'js/user-module.js'
    ];
	
	/**
     * @inheritdoc
     */	
    public $css = [ 
        'css/user-module.css'
    ];
	
	/**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
