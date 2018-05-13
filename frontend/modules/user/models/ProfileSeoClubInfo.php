<?php

namespace frontend\modules\user\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "profile_seo_club_info".
 *
 * @property int $id
 * @property int $user_id
 * @property string $personal_info
 * @property string $profession
 * @property string $cash_turnover
 * @property string $created_at
 * @property string $first_name 
 * @property string $second_name 
 */
class ProfileSeoClubInfo extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile_seo_club_info';
    }

	public function behaviors() {
		return [
			'timestamp' => [
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
				],
				'value' => function($event){
					return date("Y-m-d H:i:s");
				},
			],
		];
	}

		/**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['personal_info', 'first_name', 'second_name'], 'string'],
            [['created_at'], 'safe'],
            [['profession', 'cash_turnover'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'user_id' => Yii::t('blog', 'User ID'),
            'personal_info' => Yii::t('blog', 'Personal Info'),
			'first_name' => Yii::t('blog', 'First Name'),
			'second_name' => Yii::t('blog', 'Second Name'),
            'profession' => Yii::t('blog', 'Profession'),
            'cash_turnover' => Yii::t('blog', 'Cash Turnover'),
            'created_at' => Yii::t('blog', 'Created At'),
        ];
    }
	
	public function addToClub($id)
	{
		$profile = \common\models\Profile::findOne(['user_id' => $id]);
		$profile->seo_club_member = true;
		
		$user = \common\models\User::findOne($id);
		$user->seo_member_status = $profile::ADDED_TO_SEO_CLUB;
		
		if ($profile->update() && $user->update()) {
			return true;
		}
		return false;
	}
}
