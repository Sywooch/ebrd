<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "partner_bonus".
 *
 * @property int $id
 * @property string $company_name
 * @property string $full_name
 * @property string $position
 * @property string $email
 * @property string $phone
 * @property string $proposition
 * @property int $privacy
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 */
class Form19 extends \yii\db\ActiveRecord
{
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
    public static function tableName()
    {
        return 'form_19';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['full_name', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at','submitted_at'], 'safe'],
            [['company_name', 'full_name', 'position', 'email', 'phone', 'proposition','referrer', 'privacy'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'company_name' => Yii::t('blog', 'COMPANY_NAME'),
            'full_name' => Yii::t('blog', 'FULL_NAME'),
            'position' => Yii::t('blog', 'POSITION'),
            'email' => Yii::t('blog', 'Email'),
            'phone' => Yii::t('blog', 'PHONE'),
            'proposition' => Yii::t('blog', 'PROPOSITION'),
            'privacy' => Yii::t('blog', 'PRIVACY'),
            'user_id' => Yii::t('blog', 'USER'),
            'created_at' => Yii::t('blog', 'CREATED_AT'),
            'updated_at' => Yii::t('blog', 'UPDATED_AT'),
        ];
    }

	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {

			$this->user_id = Yii::$app->user->identity->id;

			return true;
		}
		return false;
	}
}
