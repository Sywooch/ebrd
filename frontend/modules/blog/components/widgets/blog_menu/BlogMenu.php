<?php

namespace frontend\modules\blog\components\widgets\blog_menu;

use yii\base\Widget;
use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use frontend\modules\blog\models\BlogCategory;

class BlogMenu extends Widget
{
	public $childBlogCategory;
	public $model;

	public function init() {
		$this->_registerAssets();
		parent::init();
	}

	public function run()
	{
		$html = '<div class="blog_menu_widget">';
		$html .= '<div class="blog_menu_widget_container">';
		$html .= '<div class="blog_menu_widget_col">';
		$html .= $this->getButtons();
		$html .= '</div>';
		$html .= '</div>';
		$html .= '<div class="progress_bar_container">';
		$html .= '<div class="progress_bar"></div>';
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}

	public function getButtons()
	{
		$html = '';
		$filterLinks = BlogCategory::getFilteredLinks($this->childBlogCategory);
		$html .= '<div class="link_blog_container">';
		foreach ($filterLinks as $filterLink){
			if($this->model->main_category_id == $filterLink->id){
				$html .= '<div class="link_blog active">';
			}else{
				$html .= '<div class="link_blog">';
			}
			$html .= Html::tag('a', Html::encode($filterLink->name), ['href' => Url::to(['/blog/category/front-view', 'id' => $filterLink->id])]);
			$html .= '</div>';
		}
		$html .= '</div>';
		return $html;
	}

	private function _registerAssets()
	{
		$this->view->registerAssetBundle('frontend\modules\blog\components\widgets\blog_menu\bundles\BlogMenuAsset');
	}
}
