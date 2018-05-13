<?php

namespace frontend\modules\blog\models;

use yii\base\Model;
use yii\db\Expression;
use frontend\modules\blog\models\BlogCategory;

/**
 * This is the model class for table "blog_category" and "blog_post".
 *
 * @property integer  $id
 * @property string $name
 * @property string $content
 * @property string $alias
 * @property integer  $created_at
 * @property integer  $updated_at
 * @property integer  $lang_id
 * @property string $type
 */
class SearchForm extends Model
{
	/*
	 * @var string 
	 */
	public $q;
	
	public function rules()
	{
		return [
			['q', 'string']
		];
	}
	

	/* @param string $paramsName
	 * @param string $paramsContent
	 * @return $queryTwo->union($queryOne)
	 */
	public static function searchData($paramsName, $paramsContent)
	{
		$queryOne = BlogCategory::find()
				->select([
					'id',
					'name',
					'content',
					'parent_category_id',
					'alias',
					'created_at',
					'updated_at',
					'lang_id',
					new Expression('"cat" AS type'),
				])
				->orFilterWhere($paramsName)
				->orFilterWhere($paramsContent)
				->andWhere(['status_id' => BlogCategory::STATUS_PUBLISHED]);
		
		$queryTwo = BlogPost::find()
				->select([
					'id',
					'name',
					'content',
					'alias',
					'main_category_id',
					'created_at',
					'updated_at',
					'lang_id',
					new Expression('"post" AS type'),
				])
				->orFilterWhere($paramsName)
				->orFilterWhere($paramsContent)
				->andFilterWhere(['not', ['main_category_id' => '155']])
				->andFilterWhere(['not', ['main_category_id' => '164']])
				->andFilterWhere(['not', ['main_category_id' => '228']])
				->andFilterWhere(['not', ['main_category_id' => '105']])
				->andFilterWhere(['not', ['main_category_id' => '51']])
				->andFilterWhere(['not', ['main_category_id' => '120']])
				->andFilterWhere(['not', ['main_category_id' => '309']]);
		
		return $queryOne->union($queryTwo);
	}
}