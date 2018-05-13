<?php

namespace frontend\modules\blog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\blog\models\BlogStakeholder;
use yii\helpers\ArrayHelper;

/**
 * SearchBlogStakeholder represents the model behind the search form of `frontend\modules\blog\models\BlogStakeholder`.
 */
class SearchBlogStakeholder extends BlogStakeholder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'group_id'], 'integer'],
            [['name', 'logo', 'mail', 'phone', 'description', 'location'], 'safe'],
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
		$filter = Yii::$app->getRequest()->getQueryParam('id');
		if($filter == 375 || $filter == 361) {
			$query = BlogStakeholder::find();
		}
		else {
			$query = BlogStakeholder::findByCategoryId($filter);
		}
//        $query = BlogStakeholder::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 3,
			],
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
            'group_id' => $this->group_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'mail', $this->mail])
            ->andFilterWhere(['like', 'phone', $this->phone])
			->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
	
	public function getRegions()
	{
		$lang = Yii::$app->language;
		if($lang == 'en') {
			return ArrayHelper::map(BlogCategory::find()->where(['parent_category_id' => 361])->asArray()->all(), 'id', 'name');
		}
		else if($lang == 'uk') {
			return ArrayHelper::map(BlogCategory::find()->where(['parent_category_id' => 375])->asArray()->all(), 'id', 'name');
		}
		return false;
	}
	
	public function getLocations()
	{
		return ArrayHelper::map(self::find()->select('location')->asArray()->all(), 'location', 'location');
	}
}
