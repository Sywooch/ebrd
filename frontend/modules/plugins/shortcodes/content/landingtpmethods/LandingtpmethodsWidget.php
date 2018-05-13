<?php

namespace frontend\modules\plugins\shortcodes\content\landingtpmethods;

use frontend\modules\plugins\shortcodes\ShortcodeWidget;
use Yii;

/**
 * Class LandingTpMethodsWidget
 * @package frontend\modules\plugins\shortcodes
 * @author sasha
 */
class LandingtpmethodsWidget extends ShortcodeWidget {

	public $status;

	public function init() {
		parent::init();
	}

	public function run()
	{
		return $this->render('_layout');
	}
}
