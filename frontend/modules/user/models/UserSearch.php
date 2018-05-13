<?php

namespace frontend\modules\user\models;

use common\models\User;
use common\models\AuthAssignment;
use yii\data\ActiveDataProvider;
use common\models\Profile;

class UserSearch extends User
{   
	public $role;
	
	public $team;
	
	public $clubFilter = null;

	public function rules() {
		return [
			[['id', 'status_id','team'], 'integer'],
			[['email', 'role', 'seo_member_status'], 'string'],
		];
	}

	/**
     * @inheritdoc
     */
//    public function scenarios()
//    {
//        // bypass scenarios() implementation in the parent class
//        return Model::scenarios();
//    }
	
	public function search($params)
	{
		$query = User::find();
		if($this->clubFilter) {
			$query->where(['not', ['seo_member_status' => Profile::ORDINARY_USER]]);
		}
		$query->joinWith('invited')
			->joinWith('status');
		
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'id' => SORT_DESC,
				],
			],
		]);
		
		$dataProvider->sort->attributes['status'] = [
			// The tables are the ones our relation are configured to
			// in my case they are prefixed with "tbl_"
			'asc' => ['hdbk_user_status.name' => SORT_ASC],
			'desc' => ['hdbk_user_status.name' => SORT_DESC],			
		];
		
		$dataProvider->sort->attributes['team'] = [
			// The tables are the ones our relation are configured to
			// in my case they are prefixed with "tbl_"
			'asc' => ['invitation.team_id' => SORT_ASC],
			'desc' => ['invitation.team_id' => SORT_DESC],			
		];
		$this->load($params);
		
		if (!$this->validate()){
			return $dataProvider;
		}
		
		$query->andFilterWhere([
			'invitation.team_id' => $this->team,
			'user.status_id' => $this->status_id,
			'user.seo_member_status' => $this->seo_member_status,
			'user.id' => AuthAssignment::getRoleUserIds($this->role)
		]);
		
		
		$query->andFilterWhere(['like', 'user.email', $this->email])
			->andFilterWhere(['like', 'user.id', $this->id]);
		
		return $dataProvider;
	}
}
