<?php

namespace frontend\modules\plugins\shortcodes\content\phonereplace;

use frontend\modules\plugins\shortcodes\ShortcodeWidget;
use frontend\modules\blog\models\BlogContactOffice;
use Yii;

/**
 * Class YoutubeWidget
 * @package frontend\modules\plugins\shortcodes
 * @author sasha
 */
class PhonereplaceWidget extends ShortcodeWidget {

	public $phone;

	public function init() {
		parent::init();
	}

	public function run()
	{
		$localionCode = Yii::$app->userDbIp->run();

		$contactsLang = BlogContactOffice::find()
				->select('lang_name, phone')
				->where(['lang_name' => $localionCode])
				->one();
		
		if (!empty($contactsLang->phone)) {
			echo $contactsLang->phone;
		} else {
			echo $this->phone;
		}
	}

}
