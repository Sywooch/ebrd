<?php

namespace frontend\components\widgets\share_btns;

use Yii;
use yii\base\Widget;

class ShareButtons extends Widget
{
	private $result = '';
	
	public function init() {
		parent::init();
	}
	
	public function run() {
		$this->getGeneralLinks();
		return $this->result;
	}
	
	private function getGeneralLinks()
	{
		$this->result .= '<div class="share_buttons_fixed_container">';
		$this->result .= '<div class="share_buttons_container">';
		$this->result .= '<div class="share_button">';
		$this->result .= '<a class="social_tab" href="http://www.facebook.com/sharer.php?u='.Yii::$app->request->absoluteUrl.'&t='.Yii::$app->view->title.'"><svg><use xlink:href="#facebook_icon"></use></svg></a>';
		$this->result .= '</div>';
		$this->result .= '<div class="share_button">';
		$this->result .= '<a class="social_tab" href="https://twitter.com/share?text='.Yii::$app->view->title.'&url='.Yii::$app->request->absoluteUrl.'"><svg><use xlink:href="#twitter_icon"></use></svg></a>';
		$this->result .= '</div>';
		$this->result .= '<div class="share_button">';
		$this->result .= '<a class="social_tab" href="https://plus.google.com/share?url='.Yii::$app->request->absoluteUrl.'"><svg><use xlink:href="#google_plus_icon"></use></svg></a>';
		$this->result .= '</div>';
		$this->result .= '<div class="share_button">';
		$this->result .= '<a class="social_tab" href="http://linkedin.com/shareArticle?mini=true&title='.Yii::$app->view->title.'&url='.Yii::$app->request->absoluteUrl.'"><svg><use xlink:href="#linkedin_icon"></use></svg></a>';
		$this->result .= '</div>';
		$this->result .= '</div>';
		$this->result .= '</div>';
	}
	
}