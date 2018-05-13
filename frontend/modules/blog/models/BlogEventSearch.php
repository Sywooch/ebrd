<?php

namespace frontend\modules\blog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\blog\models\BlogEvent;

/**
 * BlogEventSearch represents the model behind the search form of `frontend\modules\blog\models\BlogEvent`.
 */
class BlogEventSearch extends BlogEvent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'stakeholder_id', 'lang_id'], 'integer'],
            [['alias', 'title', 'description', 'site_url', 'place', 'date', 'date_begin', 'date_end', 'picture'], 'safe'],
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
    public function search($params, $userId = null)
    {
        $query = BlogEvent::find();
        // Work in user cabinet events
        if (!is_null($userId)){
            $query->join(
                'INNER JOIN',
                'blog_map_event_user',
                'blog_map_event_user.event_id = id');
            $query->where(['user_id' => $userId] );
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        // add fields to sort
        $sort_attributes = $dataProvider->getSort()->attributes;
        $sort_attributes['date'] = '';
        $sort_attributes['status']= '';
        $dataProvider->setSort(['attributes' => $sort_attributes]);

        // custom sort filters
        $dataProvider->sort->attributes['date'] = [
            'asc' => ['date_begin' => SORT_ASC, 'date_end' => SORT_ASC],
            'desc' => ['date_begin' => SORT_DESC, 'date_end' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['status'] = [
            'asc' => ['date_begin' => SORT_ASC, 'date_end' => SORT_ASC],
            'desc' => ['date_begin' => SORT_DESC, 'date_end' => SORT_DESC],
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
            'stakeholder_id' => $this->stakeholder_id,
            'lang_id' => $this->lang_id,
            'date_begin' => $this->date_begin,
            'date_end' => $this->date_end,
        ]);

        if ( ! is_null($this->date) && strpos($this->date, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->period_date);
            $query->andFilterWhere(['between', 'period_start_date', $start_date, $end_date]);
            $query->andFilterWhere(['between', 'period_end_date', $start_date, $end_date]);
        }

        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'site_url', $this->site_url])
            ->andFilterWhere(['like', 'place', $this->place])
            ->andFilterWhere(['like', 'picture', $this->picture]);
        return $dataProvider;
    }
}
