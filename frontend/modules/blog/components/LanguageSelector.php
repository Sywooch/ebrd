<?php

namespace frontend\modules\blog\components;

use yii\base\BootstrapInterface;
use Yii;
use yii\web\Cookie;
use frontend\models\HdbkLanguage;


/**
 * Provides autoselecting language on application bootstrap
 */
class LanguageSelector implements BootstrapInterface
{
    public $supportedLanguages = [];
	public $defaultLanguage = '';

	public function __construct() {
		$this->supportedLanguages = HdbkLanguage::getLanguagesSymbolsArray();
		$this->defaultLanguage = HdbkLanguage::getDefaultLanguageCode();
	}

	public function bootstrap($app)
    {
		if (isset($app->request->cookies['language'])){
			if (in_array($app->request->cookies['language'], $this->supportedLanguages)){
				$prefferedLanguage = $app->request->cookies['language']->value;
			} else {
				$prefferedLanguage = $this->defaultLanguage;
			}
		} elseif (!empty(Yii::$app->session->get('language'))){
			if (in_array(Yii::$app->session->get('language'), $this->supportedLanguages)){
				$prefferedLanguage = Yii::$app->session->get('language');
			} else {
				$prefferedLanguage = $this->defaultLanguage;
			}
		}
		
		

        if (empty($prefferedLanguage)) {
            $prefferedLanguage = $app->request->getPreferredLanguage($this->supportedLanguages);
        }

        $app->language = $prefferedLanguage;
	}
	
	public static function switchLanguage($language)
	{		
		Yii::$app->language = $language;
		
		$languageCookie = new Cookie([
			'name' => 'language',
			'value' => $language,
			'expire' => time() + 60 * 60 * 24 * 30, // 30 days
		]);
		
		Yii::$app->response->cookies->add($languageCookie);
		
		$session = Yii::$app->session;
		$session->set('language', $language);
	}
}