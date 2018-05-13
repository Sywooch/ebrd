<?php

namespace frontend\modules\user\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "hdbk_user_status".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 */
class HdbkUserStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hdbk_user_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user', 'ID'),
            'name' => Yii::t('user', 'Name'),
            'description' => Yii::t('user', 'Description'),
        ];
    }
	
	/**
	 * Returns all available user statuses in the system
	 * 
	 * @return frontend\modules\user\models\HdbkUserStatus
	 */
	public static function getTranslatedStatuses()
	{
		$statuses = self::find()->all();
		$translatedStatuses = [];
		foreach ($statuses as $status){
			$translatedStatuses[$status->id] = Yii::t('user', $status->name);
		}
		
		return $translatedStatuses;
	}
}
