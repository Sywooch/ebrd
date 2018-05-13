<?php

namespace frontend\modules\blog\components\widgets\get_hooks;

use yii\base\Widget;
use frontend\modules\blog\components\widgets\auto_linker\Autolinker;
use frontend\modules\blog\models\BlogPost;

class GetHooks extends Widget
{
	public $hook;
	
	public function run()
	{
		$ourClientsPost = new \frontend\modules\blog\models\BlogPost();
		
		$postIds = explode(',', $this->hook);

		$contentArray = [];
		
		foreach ($postIds as $postId){
			$postObj = $ourClientsPost->find()->where(['id' => $postId, 'status_id' => BlogPost::STATUS_PUBLISHED])->one();
			if(!empty($postObj)){
				array_push($contentArray, $postObj->content);
			}
		}

		$content = implode($contentArray);
		
		$content = trim(preg_replace('/\s+/', ' ', $content));
		
		return $content;
	}
}
