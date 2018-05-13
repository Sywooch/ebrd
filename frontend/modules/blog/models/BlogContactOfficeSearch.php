<?php

namespace frontend\modules\blog\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\blog\models\BlogContactOffice;

/**
 * BlogContactOfficeSearch represents the model behind the search form about `frontend\modules\blog\models\BlogContactOffice`.
 */
class BlogContactOfficeSearch extends BlogContactOffice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['office_name', 'office_country', 'office_address', 'email', 'phone', 'lang_name'], 'safe'],
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
        $query = BlogContactOffice::find();

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
        

        $query->andFilterWhere(['like', 'office_name', $this->office_name])
            ->andFilterWhere(['like', 'office_country', $this->office_country])
            ->andFilterWhere(['like', 'office_address', $this->office_address])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'lang_name', $this->lang_name]);

        return $dataProvider;
    }
}
