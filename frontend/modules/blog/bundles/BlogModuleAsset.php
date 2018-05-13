<?php

namespace frontend\modules\blog\bundles;

use yii\web\AssetBundle;

class BlogModuleAsset extends AssetBundle
{
	/**
     * @inheritdoc
     */
	public $sourcePath = '@frontend/modules/blog/assets';  
	
	/**
     * @inheritdoc
     */	
    public $js = [ 
        'js/blog-module.js'
    ];
	
	/**
     * @inheritdoc
     */	
    public $css = [ 
        'css/blog-module.css'
    ];
	
	/**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
