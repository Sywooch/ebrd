<?php

namespace frontend\modules\user\models;
use common\models\Team;
use common\models\User;

use Yii;

/**
 * This is the model class for table "map_team_user_report".
 *
 * @property integer $report_id
 * @property integer $user_id
 * @property integer $team_id
 * @property string $created_at
 * @property string $updated_at
 * 
 * @property Reports $report
 */
class MapTeamUserReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'map_team_user_report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['report_id'], 'required'],
            [['report_id', 'user_id', 'team_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'report_id' => Yii::t('blog', 'Report ID'),
            'user_id' => Yii::t('blog', 'User ID'),
            'team_id' => Yii::t('blog', 'Team ID'),
            'created_at' => Yii::t('blog', 'Created At'),
            'updated_at' => Yii::t('blog', 'Updated At'),
        ];
    }
	
	public function getReport()
    {
        return $this->hasOne(Reports::className(), ['id' => 'report_id']);
    }
	
	
	public function getUsedTeams($report_id)
    {
        $teamReports = self::find()->where(['report_id' => $report_id])->all();
		$teamArray = [];
	
		foreach ($teamReports as $teamReport){
			if(!empty($teamReport->team_id)){
				$teamArray[$teamReport->team_id] = Team::getTeamName($teamReport->team_id);
			}
		}
		return $teamArray;
    }
	
	public function getUsedUsers($report_id)
    {
        $userReports = self::find()->where(['report_id' => $report_id])->all();
		$userArray = [];
		foreach ($userReports as $userReport){
			if(!empty($userReport->user_id)){
				$userArray[$userReport->user_id] = User::getUserById($userReport->user_id)->email;
			}
		}
		return $userArray;
    }
	
	public function deleteChain($id)
    {
        $userReports = self::find()->where(['report_id' => $id])->all();
		if(is_array($userReports)){
			foreach ($userReports as $userReport){
				$userReport->delete();
			}
		}else{
			$userReports->delete();
		}
		
    }
	
	public function setReportsMap($report_id, $user_id = NULL, $team_id = NULL)
	{
		if(!empty($user_id)){
			foreach ($user_id as $user){
				$mapReport = new self;
				$mapReport->report_id = $report_id;
				$mapReport->user_id = $user;
				$mapReport->save();
			}
		}
		if(!empty($team_id)){
			foreach ($team_id as $team){
				$mapReport = new self;
				$mapReport->report_id = $report_id;
				$mapReport->team_id = $team;
				$mapReport->save();
			}
		}
		return true;
    }
	
	public function deleteMapReport($report_id, $delete = false, $option = false)
    {
		if($option == 'user'){
			$reportMapDelete = self::findOne(['report_id' => $report_id, 'user_id' => $delete]);
		}else{
			$reportMapDelete = self::findOne(['report_id' => $report_id, 'team_id' => $delete]);
		}
		if(!empty($reportMapDelete)){
			$reportMapDelete->delete();
		}
    }
	
	public function getUserReports()
    {
		if(!empty(\Yii::$app->user->identity->id)){
			return self::find()->
				where(['map_team_user_report.user_id' => \Yii::$app->user->identity->id, 'reports.type_id' => 1])
				->joinWith('report')
				->all();
		}else{
			return FALSE;
		}
        
    }
	
	public function getUserTransferReports()
    {
		if(!empty(\Yii::$app->user->identity->id)){
			return self::find()->
				where(['map_team_user_report.user_id' => \Yii::$app->user->identity->id, 'reports.type_id' => 7])
				->joinWith('report')
				->all();
		}else{
			return FALSE;
		}
        
    }
	
	public function getUserDocuments()
    {
		if(!empty(\Yii::$app->user->identity->id)){
			return self::find()->
				where(['map_team_user_report.user_id' => \Yii::$app->user->identity->id, 'reports.type_id' => 8])
				->joinWith('report')
				->all();
		}else{
			return FALSE;
		}
        
    }
	
	public function getTeamReports()
    {
		if(!empty(\Yii::$app->user->identity->profile->currentTeam)){
			return self::find()->
				where(['team_id' => \Yii::$app->user->identity->profile->currentTeam->id, 'reports.type_id' => 1])
				->joinWith('report')
				->all();
		}else{
			return FALSE;
		}
        
    }
	
	public function getTeamTransferReports()
    {
		if(!empty(\Yii::$app->user->identity->profile->currentTeam)){
			return self::find()->
				where(['team_id' => \Yii::$app->user->identity->profile->currentTeam->id, 'reports.type_id' => 7])
				->joinWith('report')
				->all();
		}else{
			return FALSE;
		}
        
    }
	
	public function getTeamDocuments()
    {
		if(!empty(\Yii::$app->user->identity->profile->currentTeam)){
			return self::find()->
				where(['team_id' => \Yii::$app->user->identity->profile->currentTeam->id, 'reports.type_id' => 7])
				->joinWith('report')
				->all();
		}else{
			return FALSE;
		}
        
    }
	
	public function getReportsForUser($id)
    {
		$userEmails = [];
		$usersIds = self::find()->select(['user_id'])->where(['report_id' => $id])->andWhere(['is not', 'user_id', null])->column();
		foreach ($usersIds as $usersId){
			array_push($userEmails, User::getUserById($usersId)->email);
		}
		return implode(', ', $userEmails);
    }
	
	public function getReportsForTeam($id)
    {
		$teamNames = [];
		$teamsIds = self::find()->select(['team_id'])->where(['report_id' => $id])->andWhere(['is not', 'team_id', null])->column();
		foreach ($teamsIds as $teamsId){
			array_push($teamNames, Team::getTeamName($teamsId));
		}
		return implode(', ', $teamNames);
    }
	
	public function addMapReport($report_id, $add = false, $option = false)
    {
		$reportMapDelete = new self;
		$reportMapDelete->report_id = $report_id;
		if($option == 'user'){
			$reportMapDelete->user_id = $add;
		}else{
			$reportMapDelete->team_id = $add;
		}
		$reportMapDelete->save();
    }
	
	public function updateReportsMap($report_id, $user_ids = NULL, $team_ids = NULL)
	{
		$reports = self::find()->where(['report_id' => $report_id])->all();
		$teamIds = [];
		$userIds = [];
		foreach ($reports as $report){
			if(!empty($report->team_id)){
				array_push($teamIds, $report->team_id);
			}
			if(!empty($report->user_id)){
				array_push($userIds, $report->user_id);
			}
		}
		if(!empty($user_ids)){
			$newAssoc = array_combine($user_ids, $user_ids);
			$oldAssoc = array_combine($userIds, $userIds);
			$deleteArray = [];
			$addArray = [];
			foreach ($oldAssoc as $k => $v){
				if (in_array($v, $newAssoc)){
					unset($oldAssoc[$k]);
					unset($newAssoc[$k]);
				} else {
					$deleteArray[] = $v;
				}
			}
			$addArray = array_keys($newAssoc);

			foreach ($deleteArray as $delete){
				self::deleteMapReport($report_id,$delete,$option = 'user');
			}
			foreach ($addArray as $add){
				self::addMapReport($report_id,$add,$option = 'user');
			}
		}else{
			foreach ($userIds as $userId){
				self::deleteMapReport($report_id,$userId,$option = 'user');
			}
		}

		if(!empty($team_ids)){
			$newAssoc = array_combine($team_ids, $team_ids);
			$oldAssoc = array_combine($teamIds, $teamIds);
			$deleteArray = [];
			$addArray = [];
			foreach ($oldAssoc as $k => $v){
				if (in_array($v, $newAssoc)){
					unset($oldAssoc[$k]);
					unset($newAssoc[$k]);
				} else {
					$deleteArray[] = $v;
				}
			}
			$addArray = array_keys($newAssoc);

			foreach ($deleteArray as $delete){
				self::deleteMapReport($report_id,$delete,$option = 'team');
			}
			foreach ($addArray as $add){
				self::addMapReport($report_id,$add,$option = 'team');
			}
		}else{
			foreach ($teamIds as $teamId){
				self::deleteMapReport($report_id,$teamId,$option = 'team');
			}
		}
    }
}
