<?php

namespace frontend\components;

class Functions {
	
	/**
	 * Returns quantity of each html element in the string
	 * 
	 * @param string $str
	 * @return array
	 */
	public static function countElements($str)
	{
		$dom = new \DOMDocument;
		$elementDistribution = [];
		
		if (!empty($str)){
			$dom->loadHTML($str);
			$allElements = $dom->getElementsByTagName('*');

			foreach($allElements as $element) {
				if(array_key_exists($element->tagName, $elementDistribution)) {
					$elementDistribution[$element->tagName] += 1;
				} else {
					$elementDistribution[$element->tagName] = 1;
				}
			}		
			unset($dom);			
		}
		
		return $elementDistribution;
	}
}
