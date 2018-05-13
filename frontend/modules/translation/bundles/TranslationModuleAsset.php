<?php

namespace frontend\modules\translation\bundles;

use yii\web\AssetBundle;

class TranslationModuleAsset extends AssetBundle
{
	/**
     * @inheritdoc
     */
	public $sourcePath = '@frontend/modules/translation/assets';  
	
	/**
     * @inheritdoc
     */	
    public $js = [ 
        'js/translation-module.js'
    ];
	
	/**
     * @inheritdoc
     */	
    public $css = [ 
        'css/translation-module.css'
    ];
	
	/**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
