<?php

namespace frontend\modules\team\models;

use common\models\HdbkInvitationStatus;
use common\models\User;
use Yii;
use yii\helpers\Html;
use rmrevin\yii\fontawesome\FA;
use common\models\Profile;

class Invitation extends \common\models\Invitation
{
	/**
	 * @param integer $userId
	 * @return \yii\data\ActiveDataProvider
	 */
	public static function getTeamTableDP($userId)
	{
		$query = self::find()
				->select([
					'`invitation`.`email`',
					'`invitation`.`id`',
					'`invitation`.`created_at`',
					'`invitation`.`updated_at`',
					'`invitation`.`invited_id`',
					'`invitation`.`status_id`',
					'`invitation`.`invited_is_admin`',
					'`hdbk_invitation_status`.`name` AS "statusName"',
				])
				->joinWith('invited')
				->joinWith('invited.profile')
				->joinWith('invitationStatus')
				->where([
					'`invitation`.`team_id`' => Yii::$app->user->identity->profile->currentTeam->id
				]);
		
		$sort = [
			'defaultOrder' => [
				'updated_at' => SORT_DESC
			]
		];
		
		$dataProvider = new \yii\data\ActiveDataProvider([
			'query' => $query,
			'sort' => $sort,
			'pagination' => [
				'pageSize' => 5
			]
		]);
		
		$dataProvider->sort->attributes['invited.email']=[			
			'asc' => [User::tableName() . '.email' => SORT_ASC],
			'desc' => [User::tableName() . '.email' => SORT_DESC]
		];
		
		$dataProvider->sort->attributes['profile.full_name']=[			
			'asc' => [Profile::tableName() . '.full_name' => SORT_ASC],
			'desc' => [Profile::tableName() . '.full_name' => SORT_DESC]
		];
		
		$dataProvider->sort->attributes['invitationStatus.name']=[			
			'asc' => [HdbkInvitationStatus::tableName() . '.name' => SORT_ASC],
			'desc' => [HdbkInvitationStatus::tableName() . '.name' => SORT_DESC]
		];
		
		return $dataProvider;
	}

	/**
	 * 
	 * @param \common\models\User $fromUser
	 * @param \common\models\User $toUser
	 * @return \frontend\modules\team\models\Invitation
	 */
	public static function createInvitation($fromUser, $toUser, $message = '')
	{
		$invitation = new Invitation();
		$invitation->admin_id = $fromUser->id;
		$invitation->team_id = $fromUser->profile->current_team_id;
		$invitation->invited_id = $toUser->id;
		$invitation->email = $toUser->email;
		$invitation->message = $message;
		$invitation->token_accept = Yii::$app->security->generateRandomString(40);
		$invitation->token_decline = Yii::$app->security->generateRandomString(40);
		$invitation->status_id = self::JUST_CREATED;
		$invitation->save();
		
		return $invitation;
	}
	
	public function modify($action)
	{						
		if ($action === 'kickout'){
			$this->status_id = Invitation::MASTER_KICKED_OUT_WORKER;
			Profile::kickUser($this->invited_id,$this->team_id);
		} elseif ($action === 'cancel'){
			$this->status_id = Invitation::CLOSED_BY_MASTER;
		} elseif ($action === 'upgrade') {
			$this->invited_is_admin = 1;
		} elseif ($action === 'downgrade') {
			$this->invited_is_admin = 0;
		}

		$this->save();
		
		return $this->getActionButtons();
	
	}
	
	public function getActionButtons()
	{

		$act = '';
		if ($this->invitationStatus->id == self::CONFIRMED_BY_USER){
			if ($this->invited_id !== Yii::$app->user->id){
				$act = Html::a(FA::i('user-times'), '', [
					'class' => 'btn btn-primary btn-xs kickout_btn',
					'title' => Yii::t('team', 'KICK_OUT_USER'),
					'onclick' => "return modifyInvitation($this->id, 'kickout')"
					]);
				if ($this->invited_is_admin) {
					$act .= Html::a(FA::i('level-down'), '', [
						'class' => 'btn btn-primary btn-xs upgrade_btn',
						'title' => Yii::t('team', 'DOWNGRADE_TO_NORMAL_USER'),
						'onclick' => "return modifyInvitation($this->id, 'downgrade')"
						]);							
				} else {
					$act .= Html::a(FA::i('level-up'), '', [
						'class' => 'btn btn-primary btn-xs downgrade_btn',
						'title' => Yii::t('team', 'UPGRADE_TO_ADMIN'),
						'onclick' => "return modifyInvitation($this->id, 'upgrade')"
						]);
				}				
			}
		}

		if ($this->invitationStatus->id == self::SENT_AWAITING_ACTION){
			$act = Html::a(FA::i('times'), '', [
				'class' => 'btn btn-primary btn-xs cansel_invite_btn',
				'title' => Yii::t('team', 'CANCEL_INVITATION'),
				'onclick' => "return modifyInvitation($this->id, 'cancel')"
				]);						
		}

		return $act;
	}
	
}
