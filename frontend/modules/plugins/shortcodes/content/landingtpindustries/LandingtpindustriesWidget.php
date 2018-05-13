<?php

namespace frontend\modules\plugins\shortcodes\content\landingtpindustries;

use frontend\modules\plugins\shortcodes\ShortcodeWidget;
use Yii;

/**
 * Class LandingTpMethodsWidget
 * @package frontend\modules\plugins\shortcodes
 * @author sasha
 */
class LandingtpindustriesWidget extends ShortcodeWidget {

	public $status;

	public function init() {
		parent::init();
	}

	public function run()
	{
		return $this->render('_layout');
	}
}
