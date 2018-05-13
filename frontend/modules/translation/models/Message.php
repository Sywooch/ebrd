<?php

namespace frontend\modules\translation\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property string $language
 * @property string $translation
 *
 * @property SourceMessage $id0
 */
class Message extends \yii\db\ActiveRecord
{
	public $message;
	
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'language'], 'required'],
            [['id'], 'integer'],
            [['translation'], 'string'],
            [['language'], 'string', 'max' => 16],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => SourceMessage::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'language' => Yii::t('app', 'Language'),
            'translation' => Yii::t('app', 'Translation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(SourceMessage::className(), ['id' => 'id']);
    }
	
	
	/**
	 * Saves new translation or update old one
	 * 
	 * @return bool If new translation saved successfully
	 */
	public static function saveMessageTranslation($args)
	{
		$message = self::findOne([
			'id' => $args['id'], 
			'language' => $args['language']
		]);
		
		if (!$message){
			$message = new self();
			$message->id = $args['id'];
			$message->language = $args['language'];
		}
		$message->translation = $args['translation'];
		
		if ($message->save()){
			return TRUE;
		}
		
		return FALSE;
	}
	
	/**
	 * Searches for keyString in translations
	 * 
	 * @param string $keyStirng string to search for
	 * @param string|array $category the target category, such as 'organization' or 'person', default - all categories
	 * @param string $field in which field perform search
	 * @param string $lang language of translation, default = all languages
	 * 
	 * @return array Array of entity id's, that have keyString in translations
	 */
	public static function getIds($keyStirng, $category = [], $field = '', $lang = '')
	{
		$query = self::find()
			->where(['like', 'translation', $keyStirng])
			->andWhere(['`source_message`.`category`' => [
				'organization'
			]])
			->select(['`source_message`.`message` as message'])
			->joinWith('id0');
		
		if (!empty($category)){
			$query->andWhere([
				'`source_message`.`category`' => $category
			]);
		}
		
		if (!empty($field)){
			$query->andWhere(['like', '`source_message`.`message`', $field]);
		}
		
		if (!empty($lang)){
			$query->andWhere(['language' => $lang]);
		}
		
		$messages = $query->distinct()->column();
		
		$ids = [];
		
		foreach ($messages as $message){
			$ids[] = intval(explode('_', $message)[1]);
		}
		
		if (empty($ids)){
			$ids = 0;
		}
		
		return $ids;
	}
        
        /**
         * Fill translation fields with translations
         * @param type $messages
         * @param type $translation
         */
        public function fillTranslation($messages, &$translation)
        {
            foreach ($messages as $message) {
                $translation->{$message->language} = $message->translation;
            }
        }
}
