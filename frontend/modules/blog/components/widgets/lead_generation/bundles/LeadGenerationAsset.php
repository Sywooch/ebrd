<?php

namespace frontend\modules\blog\components\widgets\lead_generation\bundles;

use yii\web\AssetBundle;

/**
 * LanguagePlugin asset bundle
 * @author Lajos Molnár <lajax.m@gmail.com>
 * @since 1.0
 */
class LeadGenerationAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@frontend/modules/blog/components/widgets/lead_generation/assets';

    /**
     * @inheritdoc
     */
    public $js = [
        'javascripts/lead-generation.js',
    ];
	
	public $css = [
		'css/lead-generation_1.css',
	];

	/**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
