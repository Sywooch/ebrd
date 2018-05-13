<?php

namespace frontend\modules\plugins\shortcodes\content\link;

use frontend\modules\plugins\shortcodes\ShortcodeWidget;

/**
 * Class LinkWidget
 * @package frontend\modules\plugins\shortcodes
 * @author sasha
 */
class LinkWidget extends ShortcodeWidget {

	public $url = '/';
	
	public $title = 'link';
	
	public $src;

	public function init() {
		parent::init();
	}

	public function run()
	{
		return $this->render('_link_view', [
			'url' => $this->url,
			'title' => $this->title,
			'src' => $this->src
		]);
	}

}
