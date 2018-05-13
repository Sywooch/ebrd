<?php

namespace frontend\modules\translation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SearchSourceMessage extends SourceMessage
{
	public $searchText;
	public $categoriesList;
	public $keywords;

	public function __construct() {
		$this->setCategoriesList();
		parent::__construct();
	}

	public function rules()
    { 
        // only fields in rules() are searchable
        return [
            [['searchText'], 'string'],
            ['keywords', 'each', 'rule' => ['string']],
            [['message'], 'string'],
            [['category'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'category' => Yii::t('main', 'CATEGORY'),
            'message' => Yii::t('main', 'MESSAGE'),
        ];
    }
	
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = SourceMessage::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->orderBy(['id' => SORT_DESC]);
        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
		if ($this->category !== '0'){
			$query->andFilterWhere(['category' => $this->category]);
		}

		if (!empty($this->keywords)) {
            $query->andFilterWhere(['message' => $this->keywords]);
        }

        if (!empty($this->searchText)) {
            $query->andFilterWhere(['id' => $this->getSourceMessagesIds()]);
        }

		$query->andFilterWhere(['like', 'message', $this->message]);
		
        return $dataProvider;
    }
	
	/**
	 * Find all source messages id's, where in translation is present $message text 
	 * 
	 * @return mixed 
	 */
	private function getSourceMessagesIds()
	{
		return Message::find()
			->select(['id'])
			->where(['like', 'translation', $this->searchText])
			->distinct()
			->column();
	}
	
	/**
	 * Gets all translation categories
	 * 
	 * @return mixed array of all available categories
	 */
	private function getTransCategories()
	{
		return SourceMessage::find()
			->select('category')
			->distinct()
			->column();
	}
	
	/**
	 * Builds categories list
	 */
	private function setCategoriesList()
	{
		foreach (SourceMessage::getCategories() as $cat){
			$this->categoriesList[$cat] = $cat;
		}
	}
}