<?php

namespace frontend\modules\user\models;

use yii\base\Model;
use frontend\modules\user\models\Reports;
use yii\data\ActiveDataProvider;

class ReportsSearch extends Reports
{   
	public $team;
	

	public function rules() {
		return [
			[['team'], 'integer'],
			[['name'], 'string'],
			[['type_id'], 'integer'],
		];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

	
	public function search($params)
	{
		$query = Reports::find()
			->joinWith('reports');
		
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]],
		]);
		
		$dataProvider->sort->attributes['team'] = [
			'asc' => ['map_team_user_report.team_id' => SORT_ASC],
			'desc' => ['map_team_user_report.team_id' => SORT_DESC],			
		];
		$this->load($params);
		
		if (!$this->validate()){
			return $dataProvider;
		}
		
		$query->andFilterWhere([
			'map_team_user_report.team_id' => $this->team,
		]);
		
		$query->andFilterWhere([
			'reports.type_id' => $this->type_id,
		]);
		
		
		$query->andFilterWhere(['like', 'map_team_user_report.team_id', $this->team])
				->andFilterWhere(['like', 'reports.name', $this->name])
				->andFilterWhere(['like', 'reports.type_id', $this->type_id]);
		
		return $dataProvider;
	}
}
