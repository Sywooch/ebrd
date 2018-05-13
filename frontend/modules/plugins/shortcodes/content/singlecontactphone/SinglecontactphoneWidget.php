<?php

namespace frontend\modules\plugins\shortcodes\content\singlecontactphone;

use Yii;
use frontend\modules\plugins\shortcodes\ShortcodeWidget;
use frontend\modules\blog\models\SeparatePhonesNumbers;

/**
 * Class SinglecontactphoneWidget
 * @package frontend\modules\plugins\shortcodes\content
 * @author Sasha
 */
class SinglecontactphoneWidget extends ShortcodeWidget {

	public $phone = '+38 (044) 290 94 35';
	
	public $telephony;

	public function init() {
		parent::init();
	}

	public function run()
	{
		$localionCode = Yii::$app->userDbIp->run();
		
		$phonesModel = SeparatePhonesNumbers::getPhoneByCode($localionCode);
		
		if (!empty($phonesModel->phone_number)) {
			
			if($this->telephony == true) {
				echo str_replace(' ', '', $phonesModel->phone_number);
			} else {
				echo $phonesModel->phone_number;
			}
		} else {
			if($this->telephony == true) {
				echo str_replace(' ', '', $this->phone);
			} else {
				echo $this->phone;
			}
		}
	}
}
