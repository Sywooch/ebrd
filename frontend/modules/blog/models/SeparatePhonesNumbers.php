<?php

namespace frontend\modules\blog\models;

use Yii;

/**
 * This is the model class for table "separate_phones_numbers".
 *
 * @property integer $id
 * @property string $country_id
 * @property string $phone_number
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class SeparatePhonesNumbers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'separate_phones_numbers';
    }
	/**
     * @inheritdoc
     */
    public function behaviors()
    {
		return [
				[
				'class' => \yii\behaviors\TimestampBehavior::className(),
				'value' => function($event){
					return date("Y-m-d H:i:s");
				}
			]
		];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['country_id', 'phone_number'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['country_id', 'phone_number'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'country_id' => Yii::t('blog', 'COUNTRY'),
            'phone_number' => Yii::t('blog', 'PHONE NUMBER'),
            'description' => Yii::t('blog', 'DESCRIPTION'),
            'created_at' => Yii::t('blog', 'CREATED AT'),
            'updated_at' => Yii::t('blog', 'UPDATED AT'),
        ];
    }
	
	public static function getPhoneByCode($localionCode) {
		$db = Yii::$app->db;
		return $db->cache(function ($db) use ($localionCode) {
			
			return self::find()
					->select('country_id, phone_number')
					->where(['country_id' => $localionCode])
					->one();
		}, 3600);
	}
}
