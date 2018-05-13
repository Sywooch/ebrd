<?php

namespace frontend\modules\translation\models;

use yii\base\Model;
use frontend\modules\translation\models\Message;
use frontend\modules\translation\models\SourceMessage;

/**
 * @property integer $id
 * @property string $language
 * @property string $message
 * @property string $translation Translation of the message
 */
class SaveTranslation extends Model
{
	public $id;
	public $language;
	public $message;
	public $category;
	public $translation;
	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'language'], 'required'],
            [['id'], 'integer'],
            [['translation', 'message', 'category'], 'string'],
            [['language'], 'string', 'max' => 16],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => SourceMessage::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }
	
	/**
	 * Saves new translation or update old one
	 * 
	 * @return bool If new translation saved successfully
	 */
	public function save()
	{
		return Message::saveMessageTranslation([			
			'id' => $this->id, 
			'language' => $this->language,
			'translation' => $this->translation
		]);
	}
	
	public function setMessageId()
	{
		$this->id = SourceMessage::find()
			->where([
				'message' => $this->message,
				'category' => $this->category
			])
			->select('id')
			->scalar();
	}
}

