<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_token".
 *
 * @property int $id
 * @property string $email
 * @property string $token
 * @property string $created_at
 * @property string $updated_at
 */
class UserToken extends \yii\db\ActiveRecord
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
        return 'user_token';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'token', 'url'], 'required'],
			['vizit', 'default', 'value' => 0],
            [['created_at', 'updated_at', 'vizit','token'], 'safe'],
            [['email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'email' => Yii::t('blog', 'Email'),
            'token' => Yii::t('blog', 'Token'),
			'vizit' => Yii::t('blog', 'Vizit'),
            'created_at' => Yii::t('blog', 'Created At'),
            'updated_at' => Yii::t('blog', 'Updated At'),
        ];
    }
	
	public function getDemoToken($demoToken)
	{
		return self::findOne(['token' => $demoToken]);
	}
}
