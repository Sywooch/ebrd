<?php

namespace frontend\modules\blog\components\widgets\lang_switcher\bundles;

use yii\web\AssetBundle;

/**
 * LanguagePlugin asset bundle
 * @author Lajos Molnár <lajax.m@gmail.com>
 * @since 1.0
 */
class LanguageSwitcherAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@frontend/modules/blog/components/widgets/lang_switcher/assets';

    /**
     * @inheritdoc
     */
    public $js = [
        'javascripts/language-switcher.js',
    ];
	
	public $css = [
		'css/language-switcher.css',
	];

	/**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
