<?php

namespace frontend\modules\blog\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\blog\models\BlogPost;

/**
 * BlogPostSearch represents the model behind the search form about `frontend\modules\blog\models\BlogPost`.
 */
class BlogPostSearch extends BlogPost
{
	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['alias', 'name', 'content', 'title', 'menu_section'], 'filter', 'filter' => 'trim'],
            [['id', 'lang_id', 'main_category_id', 'author_id', 'favorites', 'status_id'], 'integer'],
            [['alias', 'name', 'content', 'description', 'created_at', 'updated_at', 'title', 'menu_section'], 'safe'],
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
		$query = BlogPost::find();
		$query->joinWith('status');
		$query->joinWith('lang');
		$query->joinWith('category');

        // add conditions that should always apply here

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
		$dataProvider->sort->attributes['category'] = [
			// The tables are the ones our relation are configured to
			// in my case they are prefixed with "tbl_"
			'asc' => ['blog_category.name' => SORT_ASC],
			'desc' => ['blog_category.name' => SORT_DESC],
		];
		
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
            'blog_post.id' => $this->id,
            'blog_post.lang_id' => $this->lang_id,
            'main_category_id' => $this->main_category_id,
            'blog_post.status_id' => $this->status_id,
            'author_id' => $this->author_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'favorites' => $this->favorites,
        ]);

        $query->andFilterWhere(['like', 'blog_post.alias', $this->alias])
            ->andFilterWhere(['like', 'blog_post.name', $this->name])
			->andFilterWhere(['like', 'blog_post.content', $this->content])
            ->andFilterWhere(['like', 'blog_post.title', $this->title])
			->andFilterWhere(['like', 'blog_post.menu_section', $this->menu_section])
            ->andFilterWhere(['like', 'blog_post.description', $this->description]);

        return $dataProvider;
    }
}