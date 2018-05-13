<?php

namespace frontend\modules\plugins\widgets;

use yii\base\Widget;
/**
 * Description of Autolinker
 *
 * @author sasha
 */
class Autolinker extends Widget
{
	public $receivedContent;
	
	public function init() {
		parent::init();
	}
	
	public function run() {
		parent::run();
	
		Widget::begin();
		
		
		
		$text = $this->receivedContent;
		
		$pattern = '/380 44 290 94 35/';
		
		$text = preg_replace($pattern, '6666666666', $text); 
		
		echo $text;
  
		//echo $this->receivedContent . 'FFFFFFFFFFFFFFFFFFFFFFFFFFF';
		
		Widget::end();
	}
}
