<?php

namespace frontend\modules\plugins\models;

use Yii;

/**
 * This is the model class for table "user_location_ip".
 *
 * @property integer $id
 * @property string $user_ip
 * @property string $created_at
 * @property string $updated_at
 */
class UserLocationIp extends \yii\db\ActiveRecord
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_location_ip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_ip'], 'string', 'max' => 255],
			[['time_counter'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('plugins', 'ID'),
            'user_ip' => Yii::t('plugins', 'User Ip'),
            'time_counter' => Yii::t('plugins', 'Time Counter'),
        ];
    }
	
	public static function getUserIp($ip) {
		$db = Yii::$app->db;
		return $db->cache(function ($db) use ($ip) {
			
			return self::findOne(['user_ip' => $ip]);
		}, 3600);
	}
}
