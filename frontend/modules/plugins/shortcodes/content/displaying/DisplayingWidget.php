<?php

namespace frontend\modules\plugins\shortcodes\content\displaying;

use frontend\modules\plugins\shortcodes\ShortcodeWidget;


/**
 * Class YoutubeWidget
 * @package frontend\modules\plugins\shortcodes
 * @author sasha
 */
class DisplayingWidget extends ShortcodeWidget {

	public $hook;

	public function init() {
		parent::init();
	}

	public function run() {
		
		$this->registerJs();
	}
	
	protected function registerJs()
	{
		$view = $this->getView();
		$js = <<<JS
		$.post({
			url:'/blog/common/get-hooks',
			data:{hook:'$this->hook'}
		}).done(function(r){
			$('.js_shortcodes').html(r);
		});
JS;
		$view->registerJs($js);
	}

}
