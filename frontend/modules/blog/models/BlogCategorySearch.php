<?php

namespace frontend\modules\blog\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\blog\models\BlogCategory;

/**
 * BlogCategorySearch represents the model behind the search form about `frontend\modules\blog\models\BlogCategory`.
 */
class BlogCategorySearch extends BlogCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['alias', 'name', 'title', 'menu_section'], 'filter', 'filter' => 'trim'],
            [['lang_id', 'parent_category_id', 'group_id', 'status_id'], 'integer'],
            [['alias', 'name', 'title', 'menu_section'], 'safe'],
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
	
	
	private function findCategoryByAlias()
	{
		$result = [];
		if (!empty($this->alias)){
			$cats = self::find()
					->where(['like', 'alias', $this->alias])
					->all();

			if(empty($cats)) {
				return $result = 0;
			} else {
				foreach ($cats as $el) {
					$result[] = $el->id;
					while ($el->parent_category_id > 0) {
						$result[] = $el->parent_category_id;
						$el = $el->parent;
					}
				}
				return $result;
			}
		} 
		else {
			return null;
		}
	}
	
	private function findCategoryByName()
	{
		$result = [];
		if (!empty($this->name)){
			$cats = self::find()
					->where(['like', 'name', $this->name])
					->all();

			if(empty($cats)) {
				return $result = 0;
			} else {
				foreach ($cats as $el) {
					$result[] = $el->id;
					while ($el->parent_category_id > 0) {
						$result[] = $el->parent_category_id;
						$el = $el->parent;
					}
				}
				return $result;
			}
		} 
		else {
			return null;
		}
	}
	
	private function findCategoryByTitle()
	{
		$result = [];
		if (!empty($this->title)){
			$cats = self::find()
					->where(['like', 'title', $this->title])
					->all();
			if(empty($cats)) {
				return $result = 0;
			} else {			
				foreach ($cats as $el) {
					$result[] = $el->id;
					while ($el->parent_category_id > 0) {
						$result[] = $el->parent_category_id;
						$el = $el->parent;
					}
				}
				return $result;
			}
		} 
		else {
			return null;
		}
	}
	
	private function findCategoryByMenuSection()
	{
		$result = [];	
		if (!empty($this->menu_section)){
			$cats = self::find()
					->where(['like', 'menu_section', $this->menu_section])
					->all();
			if(empty($cats)) {
				return $result = 0;
			} else {			
				foreach ($cats as $el) {
					$result[] = $el->id;
					while ($el->parent_category_id > 0) {
						$result[] = $el->parent_category_id;
						$el = $el->parent;
					}
				}
				return $result;
			}
		} 
		else {
			return null;
		}
		
		}
	
	private function findCategoryByGroupId()
	{
		$result = [];
		if (!empty($this->group_id)){
			$cats = self::find()
					->where(['like', 'group_id', $this->group_id])
					->all();
			if(empty($cats)) {
				return $result = 0;
			} else {			
				foreach ($cats as $el) {
					$result[] = $el->id;
					while ($el->parent_category_id > 0) {
						$result[] = $el->parent_category_id;
						$el = $el->parent;
					}
				}
				return $result;
			}
		}
		else {
			return null;
		}
	}
	
	private function findCategoryByLangId()
	{
		$result = [];
		if (!empty($this->lang_id)){
			$cats = self::find()
					->where(['like', 'lang_id', $this->lang_id])
					->all();
			if(empty($cats)) {
				return $result = 0;
			} else {			
				foreach ($cats as $el) {
					$result[] = $el->id;
					while ($el->parent_category_id > 0) {
						$result[] = $el->parent_category_id;
						$el = $el->parent;
					}
				}
				return $result;
			}
		}
		else {
			return null;
		}
	}
	
	private function findCategoryByParentCategoryId()
	{
		$result = [];
		if (!empty($this->parent_category_id)){
			$cats = self::find()
					->where(['like', 'parent_category_id', $this->parent_category_id])
					->all();
			if(empty($cats)) {
				return $result = 0;
			} else {			
				foreach ($cats as $el) {
					$result[] = $el->id;
					while ($el->parent_category_id > 0) {
						$result[] = $el->parent_category_id;
						$el = $el->parent;
					}
				}
				return $result;
			}
		} 
		else {
			return null;
		}
	}
	
	private function findCategoryByStatusId()
	{
		$result = [];
		if (!empty($this->status_id)){
			$cats = self::find()
					->where(['status_id' => $this->status_id])
					->all();
			if(empty($cats)) {
				return $result = 0;
			} else {			
				foreach ($cats as $el) {
					$result[] = $el->id;
					while ($el->parent_category_id > 0) {
						$result[] = $el->parent_category_id;
						$el = $el->parent;
					}
				}
				return $result;
			}
		} 
		else {
			return null;
		}
	}

	public function search($params)
    {
        $query = BlogCategory::find()
			->joinWith(['group'])
			->joinWith(['status']);

        // add conditions that should always apply here
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [ 
				'pageSize' => 1000, 
			],
        ]);
		
        $this->load($params);

		// grid filtering conditions
		
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

		$query->andFilterWhere(['blog_category.id' => $this->findCategoryByLangId()])
			->andFilterWhere(['blog_category.id' => $this->findCategoryByParentCategoryId()])
			->andFilterWhere(['blog_category.id' => $this->findCategoryByAlias()])
            ->andFilterWhere(['blog_category.id' => $this->findCategoryByName()])
			->andFilterWhere(['blog_category.id' => $this->findCategoryByGroupId()])
			->andFilterWhere(['blog_category.id' => $this->findCategoryByTitle()])
			->andFilterWhere(['blog_category.id' => $this->findCategoryByMenuSection()])
			->andFilterWhere(['blog_category.id' => $this->findCategoryByStatusId()]);
	
        return $dataProvider;
    }
}
