<?php

namespace frontend\modules\blog\components\widgets\get_another_language_article;

use Yii;
use yii\helpers\Html;
use yii\base\Widget;
use frontend\modules\blog\models\BlogMapEntityLang;
use frontend\models\HdbkLanguage;

class GetAnotherLanguageArticle extends Widget
{
	/**
	 * @var int get id of the necessary post or category
	 */
	public $defaultArticleId;
	
	/**
	 * @var int get lang_id of the necessary post or category
	 */
	public $defaultArticleLangId;
	
	/**
	 * @var string get type of post or category
	 */
	public $defaultType;

	public function init() {
		parent::init();
	}
	
	public function run() {
		parent::run();

		Widget::begin();
		
		if($this->defaultType == 'post') {
			$this->defaultType = '1';
		} elseif ($this->defaultType == 'cat') {
			$this->defaultType = '2';
		}

		$lang_name = HdbkLanguage::find()
				->where(['id' => $this->defaultArticleLangId])
				->one();
	
		$lang = BlogMapEntityLang::find()
				->where([
					'entity_type_id' => $this->defaultType,
					"$lang_name->code" => $this->defaultArticleId,
				])
				->all();
		
		//echo Yii::t('blog', 'LANGUAGE') . ': ' . $lang_name->native_name . '<br />';
		
		echo Yii::t('blog', 'AVAILABLE VIEWING LANGUAGES') . ': ';
				
		foreach ($lang as $row) {
			
			if($row->entity_type_id == '1') {
			$article_route = '/blog/post/front-view';
		
			} elseif($row->entity_type_id == '2') {
				$article_route = '/blog/category/front-view';
			}
			
			//$nameOfLanguage = $lang_name->name;

			$res = Yii::$app->params['settings']['supportedLanguages'];
			
			$availableTrans = [];
			foreach ($res as $key => $val){
				if (!empty($row->{$val})){
					//$availableTrans[$val] = $row->{$val};
					echo Html::a(Html::encode(HdbkLanguage::findOne(['code' => $val])->native_name), ["$article_route", 'id' => $row->{$val}]) . ' ';
				}
			}
		}
		Widget::end();
	}
}
