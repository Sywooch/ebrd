<?php

namespace frontend\modules\blog\components\widgets\limiter;

use Yii;
use yii\helpers\Html;
use yii\base\Widget;
use frontend\modules\blog\models\BlogMapEntityLang;
use frontend\models\HdbkLanguage;

class Limiter extends Widget
{
	/**
	 * @var string text get content of the necessary post or category
	 */
	public $text;
	
	/**
	 * @var int length of content of the necessary post or category
	 */
	public $textLength = '400';

	public function limiter()
	{	
		$stripText = strip_tags($this->text);

		if (preg_match('/\[/', $stripText) === 1) {
			
			$strLength = strpos($stripText, '[');
		
			$textToView = explode("[", $stripText);
			
			if((int)$this->textLength <= (int)strlen($textToView[0])) {
				$text = mb_strimwidth($textToView[0], 0, $this->textLength, '...');	
			} else {
				$text = $textToView[0];
			}

//			if($limit >  $strLength) {
//				echo 'See more by going to the page';
//			}
			
		} else {
			$text = mb_strimwidth($stripText, 0, $this->textLength, '...');
		}	
		return $text;
	}

	public function init() {
		parent::init();
	}
	
	public function run() {
		parent::run();

		return $this->limiter();
		
	}
}
