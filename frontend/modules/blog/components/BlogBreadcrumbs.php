<?php

namespace frontend\modules\blog\components;

use frontend\modules\blog\Blog;
use frontend\modules\blog\models\BlogCategory;
use frontend\modules\blog\models\BlogPost;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use Yii;

class BlogBreadcrumbs extends Breadcrumbs
{
	/**
	 * set this property if you want to get breadcrumbs for custom route (not current)
	 * 
	 * @var array like ['/blog/category/front-view', 'id' => 3]
	 */
	public $route;
	
	public $homeLink;
	private $actionParams;
	private $requestedRout;
	/**
	 * For these routes will be applied special rules for building breadcrumbs
	 * and they will look like 'main/cat_name/cat_2_name/post_N_name'
	 * 
	 * @var array
	 */
	private $customRouts;
	private $steps = [];


	public function init() 
	{
		$this->setRequestedRoute();
		$this->setHomeLink();
		$this->setCustomRoutes();
		parent::init();
	}
	
	public function run() {
		if (in_array($this->requestedRout, $this->customRouts)){
			$this->getSteps();
			return $this->buildString();			
		} else {
			parent::run();
		}
		
	}
	
	private function setHomeLink()
	{
		if (empty($this->homeLink)){
			if(Yii::$app->user->can('manageUsers')){
				$this->homeLink =  [
					'label' => Yii::t('blog', 'MAIN'),
					'url' => \yii\helpers\Url::to(['/site/admin'])
				];
			}else{
				$this->homeLink =  [
					'label' => Yii::t('blog', 'MAIN'),
					'url' => \yii\helpers\Url::to(['/cabinet'])
				];
			}
		}
	}

		private function setRequestedRoute()
	{
		if (!empty($this->route)){
			$this->requestedRout = ltrim(array_shift($this->route), '/');
			$this->setActionParams($this->route);
		} elseif (!empty(Yii::$app->controller->module->module->requestedRoute)){
			$this->requestedRout = Yii::$app->controller->module->module->requestedRoute;
			$this->setActionParams(Yii::$app->controller->module->module->controller->actionParams);
		}	
	
	}
	
	private function setActionParams($params)
	{
		$this->actionParams = $params;
	}

	private function setCustomRoutes()
	{
		$this->customRouts = [
			Blog::$categoryViewAction,
			Blog::$postViewAction
		];
	}

	private function getSteps()
	{
		if ($this->requestedRout === Blog::$categoryViewAction){
			$this->getCategoryBreadcrumbs($this->actionParams['id']);
		} elseif ($this->requestedRout === Blog::$postViewAction) {
			$this->getPostBreadcrumbs($this->actionParams['id']);
		}
	}
	
	private function getCategoryBreadcrumbs($catId)
	{
		for (;$catId;){
			$category = BlogCategory::findOne($catId);
			if ((is_object($category)) && ($category->parent_category_id !== 0)){
				array_unshift($this->steps, ['/' . Blog::$categoryViewAction, $category->id, $category->menu_section]);
				$catId = ($category->parent_category_id !== 0) ? $category->parent_category_id : FALSE;
			} else {
				$catId = FALSE;
			}
		}
	}
	
	private function getPostBreadcrumbs($postId)
	{
		$post = BlogPost::findOne($postId);
		
		if (is_object($post)){
			$this->getCategoryBreadcrumbs($post->main_category_id);
			array_push($this->steps, ['/' . Blog::$postViewAction, $post->id, $post->menu_section]);
		}
	}

	private function getMain()
	{
		array_unshift($this->steps, ['/', 0, Yii::t('blog', 'MAIN')]);
	}
	
	private function buildString()
	{
		$res = '<ul class="breadcrumb">';
		$res .= '<li>' . Html::a(Yii::t('blog', 'MAIN'), ['/']) . '</li>';
		foreach ($this->steps as $val){
			$res .= '<li>' . Html::a($val[2], [$val[0], 'id' => $val[1]]) . '</li>';
		}
		$res .= '</ul>';
		return $res;
	}
}

