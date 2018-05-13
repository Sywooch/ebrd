<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "invitation".
 *
 * @property integer $id
 * @property integer $team_id
 * @property integer $admin_id
 * @property string $message
 * @property string $email
 * @property integer $status_id
 * @property string $token_accept
 * @property string $token_decline
 * @property integer $invited_id
 * @property boolean $invited_is_admin
 * @property string $created_at
 * @property string $updated_at
 *
 * @property HdbkInvitationStatus $invitationStatus
 * @property Team $team
 * @property User $admin
 * @property User $invited
 */
class Invitation extends \yii\db\ActiveRecord
{
	const JUST_CREATED = 0;
	const SENT_AWAITING_ACTION = 2;
	const CONFIRMED_BY_USER = 4;
	const REJECTED_BY_USER = 6;
	const CLOSED_BY_MASTER = 8;
	const USER_LEFT_THE_PROJECT = 10;
	const MASTER_KICKED_OUT_WORKER = 12;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invitation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['team_id', 'admin_id', 'status_id'], 'required'],
            [['team_id', 'admin_id', 'status_id', 'invited_id'], 'integer'],
            [['message'], 'string'],
            [['invited_is_admin'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['token_accept', 'token_decline', 'email'], 'string', 'max' => 45],
            [['token_accept'], 'unique'],
            [['token_decline'], 'unique'],
			['email', 'unique', 'targetAttribute' => ['email', 'team_id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => HdbkInvitationStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['team_id' => 'id']],
            [['admin_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['admin_id' => 'id']],
            [['invited_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['invited_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('team', 'ID'),
            'team_id' => Yii::t('team', 'Team ID'),
            'admin_id' => Yii::t('team', 'Admin ID'),
            'email' => Yii::t('team', 'EMAIL'),
            'message' => Yii::t('team', 'Message'),
            'status_id' => Yii::t('team', 'Invitation Status ID'),
            'token_accept' => Yii::t('team', 'Token Accept'),
            'token_decline' => Yii::t('team', 'Token Decline'),
            'invited_id' => Yii::t('team', 'Invited ID'),
            'invited_is_admin' => Yii::t('team', 'Invited Is Admin'),
            'created_at' => Yii::t('team', 'Created At'),
            'updated_at' => Yii::t('team', 'Updated At'),
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
		return [
				[
				'class' => TimestampBehavior::className(),
				'value' => function($event){
					return date("Y-m-d H:i:s");
				}
			]
		];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvitationStatus()
    {
        return $this->hasOne(HdbkInvitationStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
    }

	public function getActiveInvitations($id)
    {
        return self::find()
				->where(['invited_id' => $id, 'status_id' => self::CONFIRMED_BY_USER])
				->all();
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(User::className(), ['id' => 'admin_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvited()
    {
        return $this->hasOne(User::className(), ['id' => 'invited_id']);
    }
	
	public static function getUserTeams()
	{
		return self::find()->where(['invited_id' => Yii::$app->user->id])->andWhere(['!=', 'status_id', Invitation::MASTER_KICKED_OUT_WORKER])->all();
	}
	
	public static function getUserTeamsById($id)
	{
		return self::find()->where(['invited_id' => $id])->all();
	}
	
	public static function getCurrentTeam()
	{
		return self::find()->where(['invited_id' => Yii::$app->user->id,'team_id' => Yii::$app->user->identity->profile->currentTeam->id])->one();
	}
	
	public static function getActiveUsersInTeam($id)
	{
		return self::find()->where(['team_id' => $id ,'status_id' => self::CONFIRMED_BY_USER])->all();
	}
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getInvitationTeam($id)
    {
        return self::find()
				->select(['team_id'])
				->where(['invited_id' => $id])
				->scalar();
    }
	
	public static function getInvitationByTeamId($userId, $teamId)
	{
		return self::find()->where(['team_id' => $teamId ,'invited_id' => $userId])->all();
	}
}
