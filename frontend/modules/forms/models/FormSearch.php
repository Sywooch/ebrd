<?php

namespace frontend\modules\forms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\forms\models\Form;

/**
 * FormSearch represents the model behind the search form about `frontend\modules\forms\models\Form`.
 */
class FormSearch extends Form
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'title', 'description', 'answer', 'mail_to', 'fields', 'rules', 'submit', 'extra_actions', 'action', 'method', 'class', 'form_id'], 'safe'],
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
        $query = Form::find();

        // add conditions that should always apply here

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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'answer', $this->answer])
            ->andFilterWhere(['like', 'mail_to', $this->mail_to])
            ->andFilterWhere(['like', 'fields', $this->fields])
            ->andFilterWhere(['like', 'rules', $this->rules])
            ->andFilterWhere(['like', 'submit', $this->submit])
            ->andFilterWhere(['like', 'extra_actions', $this->extra_actions])
            ->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'method', $this->method])
            ->andFilterWhere(['like', 'class', $this->class])
            ->andFilterWhere(['like', 'form_id', $this->form_id]);

        return $dataProvider;
    }
}
