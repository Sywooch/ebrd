<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/ebrd/styles.css',
    ];
    public $js = [
		'js/common_v3.0.js',
		'js/translite.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
		'rmrevin\yii\fontawesome\AssetBundle'
    ];
}
