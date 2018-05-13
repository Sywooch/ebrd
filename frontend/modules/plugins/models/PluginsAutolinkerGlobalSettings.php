<?php

namespace frontend\modules\plugins\models;

use Yii;

/**
 * This is the model class for table "plugins__autolinker_global_settings".
 *
 * @property integer $id
 * @property string $setting_name
 * @property string $setting_description
 * @property string $settings_value
 * @property integer $lang_id
 * @property string $created_at
 * @property string $updated_at
 */
class PluginsAutolinkerGlobalSettings extends \yii\db\ActiveRecord
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
        return 'plugins__autolinker_global_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['setting_name', 'setting_description', 'settings_value'], 'required'],
            [['lang_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['setting_name', 'setting_description', 'settings_value'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('plugins', 'ID'),
            'setting_name' => Yii::t('plugins', 'Setting Name'),
            'setting_description' => Yii::t('plugins', 'Setting Description'),
            'settings_value' => Yii::t('plugins', 'Settings Value'),
            'lang_id' => Yii::t('plugins', 'Lang ID'),
            'created_at' => Yii::t('plugins', 'Created At'),
            'updated_at' => Yii::t('plugins', 'Updated At'),
        ];
    }
	
	
	public static function getGlobalSettings()
	{
		return self::find()->one();
	}
	
	public static function getGlobalSettingStatusByName()
	{		
		return self::findOne(['setting_name' => 'status']);
	}
	
//	public static function getGlobalSettingStatusByName()
//	{
//		$db = Yii::$app->db;
//		return $db->cache(function ($db) {
//			
//			return self::findOne(['setting_name' => 'status']);
//		}, 3600);
//	}
}
