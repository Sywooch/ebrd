<?php

namespace frontend\modules\blog\components\widgets\blog_menu\bundles;

use yii\web\AssetBundle;

/**
 * LanguagePlugin asset bundle
 * @author Lajos Molnár <lajax.m@gmail.com>
 * @since 1.0
 */
class BlogMenuAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@frontend/modules/blog/components/widgets/blog_menu/assets';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/blog_menu.js',
    ];
	
	public $css = [
		'css/blog_menu.css',
	];

	/**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
