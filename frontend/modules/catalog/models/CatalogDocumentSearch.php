<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\catalog\models\CatalogDocument;

/**
 * CatalogDocumentSearch represents the model behind the search form of `frontend\modules\catalog\models\CatalogDocument`.
 */
class CatalogDocumentSearch extends CatalogDocument
{
	public $projects;
	public $method_collecting_id;
	public $method_analisis_id;
	public $period_date;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'country_id', 'industry_id', 'doc_type_id', 'projects', 'method_collecting_id' , 'method_analisis_id'], 'integer'],
            [['contract_number', 'contract_date', 'period_start_date', 'period_end_date', 'document_description', 'period_date'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CatalogDocument::find()
				->joinWith('catalogDocumentToProjects')
				->joinWith('catalogDocumentToMethodCollectings')
				->joinWith('catalogDocumentToMethodAnalises')
				->distinct();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'client_id' => $this->client_id,
            'country_id' => $this->country_id,
            'industry_id' => $this->industry_id,
            'doc_type_id' => $this->doc_type_id,
            'period_start_date' => $this->period_start_date,
            'period_end_date' => $this->period_end_date,
        ]);
		
		// Three filters for date (contract_date, period_start_date, period_end_date)
		if ( ! is_null($this->contract_date) && strpos($this->contract_date, ' to ') !== false ) { 
		list($start_date, $end_date) = explode(' to ', $this->contract_date);
		$query->andFilterWhere(['between', 'contract_date', $start_date, $end_date]);
		}
		
//		if ( ! is_null($this->period_date) && strpos($this->period_date, ' to ') !== false ) {
//		list($start_date, $end_date) = explode(' to ', $this->period_date);
//		$query->andFilterWhere(['between', 'period_start_date', $start_date, $end_date]);
//		$query->andFilterWhere(['between', 'period_end_date', $start_date, $end_date]);
//		}
		
//		if ( ! is_null($this->period_start_date) && strpos($this->period_start_date, ' to ') !== false ) { 
//		list($start_date, $end_date) = explode(' to ', $this->period_start_date);
//		$query->andFilterWhere(['between', 'period_start_date', $start_date, $end_date]);
//		}
//		
//		if ( ! is_null($this->period_end_date) && strpos($this->period_end_date, ' to ') !== false ) { 
//		list($start_date, $end_date) = explode(' to ', $this->period_end_date);
//		$query->andFilterWhere(['between', 'period_end_date', $start_date, $end_date]);
//		}
					
		$query->andFilterWhere(['project_type_id' =>  $this->projects]);
		$query->andFilterWhere(['method_collecting_id' =>  $this->method_collecting_id]);
		$query->andFilterWhere(['method_analisis_id' =>  $this->method_analisis_id]);
		
        $query->andFilterWhere(['like', 'contract_number', $this->contract_number])
            ->andFilterWhere(['like', 'document_description', $this->document_description])
            ->andFilterWhere(['like', 'file', $this->file]);

        return $dataProvider;
    }
}
