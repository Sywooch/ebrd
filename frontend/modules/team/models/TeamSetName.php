<?php

namespace frontend\modules\team\models;

use frontend\modules\team\models\Team;

/**
 * Description of SetTeamName
 *
 * @author petrovich
 */
class TeamSetName extends \yii\base\Model
{
	public $teamName;
	
	public function __construct() {
		
		if(!empty(\Yii::$app->user->identity->profile->currentTeam)){
			$this->teamName = \Yii::$app->user->identity->profile->currentTeam->name;
		}else{
			throw new \yii\web\HttpException(403);
		}
		
		parent::__construct();
	}
	
	public function rules() 
	{
		return [
			['teamName', 'required'],
			['teamName', 'string', 'max' => 45]
		];
	}
	
	public function save ()
	{
		$team = Team::findOne(['id' => \Yii::$app->user->identity->profile->currentTeam->id]);
		$team->name = $this->teamName;
		return $team->save();
	}
}
