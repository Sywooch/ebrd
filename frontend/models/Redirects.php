<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "redirects".
 *
 * @property integer $id
 * @property string $old_url
 * @property string $new_url
 */
class Redirects extends \yii\db\ActiveRecord
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
        return 'redirects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old_url', 'new_url'], 'string', 'max' => 255],
			[['old_url', 'new_url'], 'filter', 'filter'=>'trim']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'old_url' => Yii::t('blog', 'Old Url'),
            'new_url' => Yii::t('blog', 'New Url'),
        ];
    }
	
	public function findRedirectByUrl($url)
    {
        return self::findOne(['old_url' => $url]);
    }
	
	
}
