<?php

namespace frontend\components\widgets\id_category;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use \frontend\modules\blog\models\BlogPost;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use rmrevin\yii\fontawesome\FA;
use \frontend\modules\blog\models\BlogCategory;
use \yii\helpers\ArrayHelper;
/*
 * Обробка шорткоду Displaying, та відображення категорій згідно ID у шорткоді.
 */

class PostsInCategory extends Widget {

	public $content = '';
	public $categoryID = '';
	private $hook = '';

	public function init() {
		parent::init();
	}
	
	public function run() {
		return $this->buildHTML();
	}
	
	private function getPostsID($hookstring)
	{
		$result = substr($hookstring, (stripos($hookstring,'='))+1);
		$result = substr($result, 0, stripos($result,']'));
		$postsId = str_getcsv($result, ',');
		return $postsId;
	}
	
	private function getHookFromContent () {
		if(strstr($this->content, '[displaying')) {
			$result = strstr($this->content, '[displaying');
			$this->hook = substr($result, 0, stripos($result,']')+1);
			return true;
		}
		else {
			return false;
		}
	}
	
	public function buildHTML()
	{
		$items = [];
		$category = BlogCategory::findOne($this->categoryID);
		if(!empty($category) && $category->shortcodes != null) {
			$this->hook = $category->shortcodes;
		}
		else {
			$this->getHookFromContent();
		}
		if($this->hook != '') {
			$items = $this->getPostsID($this->hook);
		}
		if($items) {
			$query = BlogPost::find()->where(['id' => $items]);
			$gridView = GridView::widget([
				'dataProvider' => new ActiveDataProvider([
					'query' => $query,
					'pagination' => [
					'pageSize' => 5,
					],
				]),
				'layout'=>'<div class="grid_over">{items}</div>{pager}',
				'columns' => [
					'id',
					[
						'label' => 'Posts',
						'format' => 'raw',
						'value' => function($data) {
							$value = '';
							$value .= Html::a($data['name'],['/blog/post/update', 'id' => $data['id']],['target' => '_blank']);
							return $value;
						},
					],
					[
						'class' => 'yii\grid\ActionColumn',
						'header' => 'Delete post',
						'template' => '{delete}',
						'buttons' => [
							'delete' => function($url, $model, $key){
								$header = '/blog/category/update-post-in-category';
								$link = Html::a(FA::i('trash'),[
									$header,
									'id' => $this->categoryID,
									'hook' => $this->deleteHookID($model->id, $this->hook)
								],
								[
									'title' => Yii::t('blog', 'DELETE ITEM'),
									'data' => [
												'confirm' => Yii::t('yii', 'ARE_YOU SHURE YOU WANT TO DELETE THIS ITEM?'),
												'method' => 'post',
										]
								]);
								return $link;
							}
						]
					],
				],
			]);
			return $gridView;
		}
		else {
			return false;
		}
	}
	
	private function deleteHookID($id, $hook) {
		$items = $this->getPostsID($hook);
		if(count($items) > 1) {
			$replacehook = '[displaying hook=';
			for($index=0; $index<count($items); ++$index) {
				if($items[$index]!= $id) {
					$replacehook .= $items[$index];
					if($index != (count($items))-1 && !(($index+1 == (count($items))-1) && $items[$index+1] == $id)) {
						$replacehook .= ',';
					}
				}
			}
			$replacehook .= ']';
		} else {
			$replacehook = '';
		}
		return $replacehook;
	}		
}