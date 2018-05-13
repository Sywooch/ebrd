<?php

namespace frontend\modules\plugins\bundles;

use yii\web\AssetBundle;

class PluginsModuleAsset extends AssetBundle
{
	/**
     * @inheritdoc
     */
	public $sourcePath = '@frontend/modules/plugins/assets';  
	
	/**
     * @inheritdoc
     */	
    public $js = [ 
        'js/plugins-module.js'
    ];
	
	/**
     * @inheritdoc
     */	
    public $css = [ 
        'css/plugins-module.css'
    ];
	
	/**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
