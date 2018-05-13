<?php

namespace frontend\modules\plugins\shortcodes\content\clients;

use frontend\modules\plugins\shortcodes\ShortcodeWidget;
use yii\helpers\Html;


/**
 * Class YoutubeWidget
 * @package frontend\modules\plugins\shortcodes
 * @author sasha
 */
class OurClientsWidget extends ShortcodeWidget {

	public $hook;

	public function init() {
		parent::init();
	}

	public function run() {

		$ourClientsPost = new \frontend\modules\blog\models\BlogPost();
		
		$img = $ourClientsPost->findOne(['id' => $this->hook]);
				
		echo $f = Html::decode($img->content);
		
	}

}