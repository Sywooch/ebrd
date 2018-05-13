<?php

namespace frontend\modules\plugins\shortcodes\content\emailform;

use frontend\modules\plugins\shortcodes\ShortcodeWidget;
use frontend\modules\forms\components\widgets\form\Form;

/**
 * Class YoutubeWidget
 * @package frontend\modules\plugins\shortcodes
 * @author sasha
 */
class EmailformWidget extends ShortcodeWidget
{

	public $form_id;
	
	public function init() {
		parent::init();
	}

	public function run() {
		
		echo Form::widget([
				'formId' => $this->form_id,
			]);
	}
}
