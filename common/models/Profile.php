<?php

namespace common\models;

use Yii;
use frontend\models\HdbkLanguage;

/**
 * This is the model class for table "profile".
 *
 * @property integer $user_id
 * @property integer $lang_id
 * @property string $full_name
 * @property string $phone
 * @property string $city
 * @property string $avatar
 * @property integer $current_team_id
 * @property string $created_at
 * @property string $updated_at
 * 
 * @property boolean $seo_club_member
 * @property HdbkLanguage $lang
 * @property Team $currentTeam
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
	const AWAITING_ADD_SEO_CLUB = 'AWAITING_ADD_SEO_CLUB';
	const ADDED_TO_SEO_CLUB = 'ADDED_TO_SEO_CLUB';
	const SEO_CLUB_REJECTED = 'SEO_CLUB_REJECTED';
	const ORDINARY_USER = 'ORDINARY_USER';

	
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'lang_id'], 'required'],
            [['user_id', 'lang_id', 'current_team_id'], 'integer'],
            [['avatar'], 'string'],
			[['seo_club_member'], 'boolean'],
            [['full_name', 'city', 'phone'], 'string', 'max' => 45],
            [['created_at', 'updated_at'], 'safe'],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => HdbkLanguage::className(), 'targetAttribute' => ['lang_id' => 'id']],
            [['current_team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['current_team_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('user', 'User ID'),
            'lang_id' => Yii::t('user', 'Lang ID'),
            'full_name' => Yii::t('user', 'Full Name'),
            'phone' => Yii::t('user', 'Phone'),
            'city' => Yii::t('user', 'City'),
            'avatar' => Yii::t('user', 'Avatar'),
            'current_team_id' => Yii::t('user', 'Current Team ID'),
            'created_at' => Yii::t('user', 'Created At'),
            'updated_at' => Yii::t('user', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(HdbkLanguage::className(), ['id' => 'lang_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrentTeam()
    {
        return $this->hasOne(Team::className(), ['id' => 'current_team_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
	
	public function kickUser($id, $team_kick_id)
    {
		$user = User::getUserById($id);
		$invitations = Invitation::getActiveInvitations($user->id);
		if(sizeof($invitations) > 1){
			$teamsIds = [];
			foreach ($invitations as $invitation){
				if($invitation->team_id != $team_kick_id){
					array_push($teamsIds, $invitation->team_id);
				}
			}
		}
        $profile = self::findOne(['user_id' => $id]);
		if(!empty($teamsIds)){
			$profile->current_team_id = $teamsIds[0];
		}else{
			$profile->current_team_id = NULL;
		}
		$profile->save();
    }
	
	/**
	 * 
	 * @return boolean
	 */
	public static function sendSeoClubRequest($userId = null)
	{
		$user = Yii::$app->user->identity;
		$profile = $user->profile;
		$user->seo_member_status = self::AWAITING_ADD_SEO_CLUB;
		if ($user->update()) {
			return true;
		}
		return false;
	}
}
