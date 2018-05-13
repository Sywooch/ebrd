<?php

namespace frontend\modules\plugins\shortcodes\content\officelocation;

use yii\web\AssetBundle;

/**
 * Class GoogleMapsAsset
 */
class OfficelocationAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $basePath = '@frontend/modules/plugins/shortcodes/content/officelocation';

    /**
     * @var array
     */
    public $css = [
        'css/officelocation.css',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
