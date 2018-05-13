<?php

namespace frontend\modules\blog\bundles;

use yii\web\AssetBundle;

class EventCustom extends AssetBundle
{
	/**
     * @inheritdoc
     */
	public $sourcePath = '@frontend/modules/blog/assets';  
	
	/**
     * @inheritdoc
     */	
    public $js = [ 
        'js/events-custom.js'
    ];
	

	/**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
