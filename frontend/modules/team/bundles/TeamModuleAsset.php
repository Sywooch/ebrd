<?php

namespace frontend\modules\team\bundles;

use yii\web\AssetBundle;

class TeamModuleAsset extends AssetBundle
{
	/**
     * @inheritdoc
     */
	public $sourcePath = '@frontend/modules/team/assets';  
	
	/**
     * @inheritdoc
     */	
    public $css = [ 
        'css/team-module.css'
    ];
	
	/**
	 * @inheritdoc
	 */
	public $js = [
		'js/team-module_v1.0.js'
	];
	
	/**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
