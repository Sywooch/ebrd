<?php

namespace frontend\components\widgets\alt_lang;

use Yii;
use yii\helpers\Html;
use yii\base\Widget;
use yii\helpers\Url;
use frontend\modules\blog\models\BlogMapEntityLang;

class AltLang extends Widget
{
	private $result = '';
	
	public function init() {
		parent::init();
	}
	
	public function run() {
		$this->getAltLinks();
		return $this->result;
	}
	
	private function getAltLinks()
	{

		if(!empty(Yii::$app->controller->actionParams['id'])){
			$translated = BlogMapEntityLang::findOne([Yii::$app->language => Yii::$app->controller->actionParams['id']]);
		}else{
			$translated = array_flip(Yii::$app->params['settings']['supportedLanguages']);
		}
		if (is_Null($translated)){
		    return 0;
        }
		foreach ($translated as $code => $id){
			if(Yii::$app->language !== Yii::$app->params['settings']['defaultLanguage']){
				if($code === Yii::$app->params['settings']['defaultLanguage']){
					$request = substr($_SERVER['REQUEST_URI'], 3);
				}else{
					$request = '/'.$code.substr($_SERVER['REQUEST_URI'], 3);
				}
			}else{
				if($code === Yii::$app->params['settings']['defaultLanguage']){
					$request = $_SERVER['REQUEST_URI'];
				}else{
					$request = '/'.$code.$_SERVER['REQUEST_URI'];
				}
			}
			
			$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . '://' . $_SERVER['HTTP_HOST'] . $request;
			$customCodes = ['uk','en'];
			if(in_array($code, $customCodes) && isset($translated[$code])){
				$this->result .= '<link rel="alternate" hreflang="'.$code.'" href="' . $url . '" />'.PHP_EOL;
			}
		}
	}
	
}