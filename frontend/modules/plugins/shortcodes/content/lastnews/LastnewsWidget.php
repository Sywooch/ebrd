<?php

namespace frontend\modules\plugins\shortcodes\content\lastnews;

use frontend\modules\plugins\shortcodes\ShortcodeWidget;


/**
 * Class YoutubeWidget
 * @package frontend\modules\plugins\shortcodes
 * @author sasha
 */
class LastnewsWidget extends ShortcodeWidget {

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
                    
                $.post({url:'/blog/common/get-news'}).done(function(data){
			$('.last_news').html(data);
		});
JS;
		$view->registerJs($js);
	}

}
