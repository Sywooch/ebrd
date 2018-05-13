<?php

namespace frontend\modules\blog\bundles;

use yii\web\AssetBundle;

class GoogleAutoComplete extends AssetBundle
{
	/**
     * @inheritdoc
     */
	public $sourcePath = '@frontend/modules/blog/assets';  
	
	/**
     * @inheritdoc
     */	
    public $js = [ 
        'js/google-autocomplete.js'
    ];
	

	/**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
