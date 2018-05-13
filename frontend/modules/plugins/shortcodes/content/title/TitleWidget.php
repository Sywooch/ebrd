<?php

namespace frontend\modules\plugins\shortcodes\content\title;

use frontend\modules\plugins\shortcodes\ShortcodeWidget;
use frontend\modules\blog\models\BlogCategory;
use frontend\models\HdbkLanguage;
use Yii;


/**
 * Class TitleWidget
 * @package frontend\modules\plugins\shortcodes
 * @author sanja
 */
class TitleWidget extends ShortcodeWidget {

	public function init() {
		parent::init();
	}
	
    public function run() {
		$url = explode('/', trim(Yii::$app->request->referrer, '/'));
		if(!empty($url)){
			$category = BlogCategory::getCategoryByAlias(end($url), HdbkLanguage::getDefaultLanguageCode(Yii::$app->language));
			if(!empty($category)){
				return $category->name;
			}
		}
	}
}
