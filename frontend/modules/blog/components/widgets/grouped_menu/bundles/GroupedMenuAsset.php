<?php

namespace frontend\modules\blog\components\widgets\grouped_menu\bundles;

use yii\web\AssetBundle;

class GroupedMenuAsset extends AssetBundle
{	
    /**
     * @inheritdoc
     */
    public $sourcePath = '@frontend/modules/blog/components/widgets/grouped_menu/assets';
	
	/**
     * @inheritdoc
     */
	public $css = [
		'css/grouped-menu.css',
	];
}
