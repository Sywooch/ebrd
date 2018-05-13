<?php

namespace frontend\modules\blog\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\blog\models\BlogGroup;

/**
 * BlogGroupSearch represents the model behind the search form of `frontend\modules\blog\models\BlogGroup`.
 */
class BlogGroupSearch extends BlogGroup
{
	public $code;
	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['name'], 'filter', 'filter' => 'trim'],
            [['id', 'lang_id', 'status_id'], 'integer'],
            [['name', 'code', 'created_at', 'updated_at'], 'safe'],
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
        $query = BlogGroup::find();

        // add conditions that should always apply here
		$query->joinWith(['lang']);
		$query->joinWith(['status']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		// Important: here is how we set up the sorting
		// The key is the attribute name on our "TourSearch" instance
		$dataProvider->sort->attributes['code'] = [
			// The tables are the ones our relation are configured to
			// in my case they are prefixed with "tbl_"
			'asc' => ['hdbk_language.code' => SORT_ASC],
			'desc' => ['hdbk_language.code' => SORT_DESC],
		];
        $this->load($params);
		
		$dataProvider->sort->attributes['status'] = [
			// The tables are the ones our relation are configured to
			// in my case they are prefixed with "tbl_"
			'asc' => ['blog_hdbk_status.name' => SORT_ASC],
			'desc' => ['blog_hdbk_status.name' => SORT_DESC],
		];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'lang_id' => $this->lang_id,
            'status_id' => $this->status_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'blog_group.name', $this->name])
			->andFilterWhere(['like', 'hdbk_language.code', $this->code]);

        return $dataProvider;
    }
}
