<?php

namespace frontend\modules\blog\components\widgets\votes\bundles;

use yii\web\AssetBundle;

/**
 * LanguagePlugin asset bundle
 * @author Lajos Molnár <lajax.m@gmail.com>
 * @since 1.0
 */
class VotesAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@frontend/modules/blog/components/widgets/votes/assets';

    /**
     * @inheritdoc
     */
    public $js = [
        'javascripts/votes.js',
    ];
	
	public $css = [
		'css/votes.css',
	];
		
	/**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
