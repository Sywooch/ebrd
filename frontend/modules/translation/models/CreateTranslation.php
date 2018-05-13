<?php

namespace frontend\modules\translation\models;

use yii\base\Model;
use frontend\models\HdbkLanguage;
use frontend\modules\translation\models\Message;
use frontend\modules\translation\models\SourceMessage;
use yii\helpers\Html;   
use Yii;

/**
 * CreateTranslation model
 * 
 * @property integer $id
 * @property string $category Translations category
 * @property string $message Language constant
 * @property mixed $languages Array of languages
 * @property mixed $translations 
 */
class CreateTranslation extends Model
{
	public $category;
	public $categoriesList;
	public $id;
	public $languages;
	public $message;
	public $translations;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'message'], 'required'],
            [['message'], 'string'],
            ['message', 'checkRepeat'],
            [['category'], 'string'],
        ];
    }
    
    /**
     * Check repeats
     * @param type $attribute
     * @param type $params
     */
    public function checkRepeat($attribute, $params)
    {
        if ($this->message && $this->category) {
            $check = SourceMessage::find()
                        ->where( [ 'message' => $this->message ] )
                        ->andWhere( ['category' => $this->category] )
                        ->one(); 
            if ($check){
                $linkName = Yii::t('translation', 'CONSTANT_EXISTS');
                $this->addError($attribute, Html::a($linkName, ['view', 'id' => $check->id]));
            }
        }
    }
	
	public function __construct() {
		$this->languages = Yii::$app->params['settings']['supportedLanguages'];
		$this->setTranslations();
		$this->setCategoriesList();
		parent::__construct();
	}
	
	private function setTranslations()
	{
		$this->translations = new \stdClass();
		
		foreach ($this->languages as $lang){
			$this->translations->{$lang} = '';
		}
	}
	
	private function setCategoriesList()
	{
		foreach (SourceMessage::getCategories() as $cat){
			$this->categoriesList[$cat] = $cat;
		}
	}

		/**
	 * Saves sourceMessage and all translations
	 * 
	 * @param mixed $request 
	 * @return boolean
	 */
	public function saveTranslations($request)
	{
		if (($this->load($request)) && ($this->validate())){
			if ($this->saveSourceMessage()){
				$this->translations = $request['messageTranslations'];
				if ($this->saveMessageTranslations()){
					return TRUE;
				}
			}
		}
		
		return FALSE;
	}
	
	/**
	 * Saves source message
	 * set id equal to sourceMessage id
	 * 
	 * @return boolean
	 */
	private function saveSourceMessage()
	{
		$sourceMessage = new SourceMessage();
		$sourceMessage->category = $this->category;
		$sourceMessage->message = $this->message;
		
		if ($sourceMessage->save()){
			$this->id = $sourceMessage->id;
			return TRUE;
		}
		
		return FALSE;
	}
	
	private function saveMessageTranslations()
	{
		foreach ($this->translations as $language => $translation){
			if (!empty($translation)){
				$args = [
					'id' => $this->id,
					'language' => $language,
					'translation' => $translation
				];
				if (!Message::saveMessageTranslation($args)){
					return FALSE;
				}
			}
		}
		
		return TRUE;
	}
}
