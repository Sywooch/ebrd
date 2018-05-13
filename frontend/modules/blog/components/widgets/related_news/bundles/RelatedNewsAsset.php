<?php

namespace frontend\modules\blog\components\widgets\related_news\bundles;

use yii\web\AssetBundle;

/**
 * LanguagePlugin asset bundle
 * @author Lajos Molnár <lajax.m@gmail.com>
 * @since 1.0
 */
class RelatedNewsAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@frontend/modules/blog/components/widgets/related_news/assets';
	
	
	public $css = [
		'css/related-news.css',
	];

	/**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
