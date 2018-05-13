<?php

namespace frontend\modules\team\models;

use Yii;
use common\models\Invitation;

/**
 * Description of Team
 *
 * @author petrovich
 */
class Team extends \common\models\Team
{
	/**
	 * Creates new team where owner is current user
	 * 
	 * @return bool
	 */
	public static function createTeam()
	{
		$team = new Team();
		$team->owner_id = Yii::$app->user->id;
		$team->name = Yii::$app->user->identity->email . ' ' . Yii::t('team', 'TEAM');
		$team->save();
		
		return (($team->save()) && (self::setCurrentTeam($team->id)));
	}
	
	/**
	 * Check if user is already is team owner
	 * 
	 * @return bool 
	 */
	public static function userHasTeam()
	{
		$team = self::findOne(['owner_id' => Yii::$app->user->id]);
		
		return (is_object($team));
	}
	
	private static function setCurrentTeam($teamId)
	{
		$profile = Yii::$app->user->identity->profile;
		$profile->current_team_id = $teamId;
		return $profile->save();
	}
	
	public static function userIsAdmin()
	{
		$currentTeam = Yii::$app->user->identity->profile->currentTeam;

		if(Yii::$app->user->can('manageUsers')){
			return TRUE;
		}elseif($currentTeam->owner_id === Yii::$app->user->id){
			return TRUE;
		}elseif(Invitation::getCurrentTeam()->invited_is_admin === 1){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	/**
	 * Select teams, where user has admin privileges
	 * 
	 * @param integer $id
	 * @return frontend\modules\team\models\Team
	 */
	public static function userAdmin($id = false)
	{
		$id = $id ?: Yii::$app->user->id;
		$teams = self::find()
			->select([
				'`team`.`id`',
				'`team`.`name`'
			])
			->where([
				'`team`.`owner_id`' => $id,
				'`invitation`.`status_id`' => Invitation::CONFIRMED_BY_USER,
			])
			->orWhere([
				'`invitation`.`invited_id`' => $id,
				'`invitation`.`status_id`' => Invitation::CONFIRMED_BY_USER,
			])
			->joinWith('invitations')
			->orderBy('name')
			->all();
		
		return $teams;	
	}
	
	public static function userSuperAdmin($id = false)
	{
		$id = $id ?: Yii::$app->user->id;
		$teams = self::find()
			->select([
				'`team`.`id`',
				'`team`.`name`'
			])
			->joinWith('invitations')
			->orderBy('name')
			->all();
		
		return $teams;	
	}
}
