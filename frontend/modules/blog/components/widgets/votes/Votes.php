<?php

namespace frontend\modules\blog\components\widgets\votes;

use yii\base\Widget;
use Yii;


/**
 * Widget for selecting application language
 */
class Votes extends Widget
{	
	public $postId;
	public $name;
	public $description;
	public $isBlogPost;
	
	public function init() {
		$this->_registerAssets();
		parent::init();
		if ($this->postId === null) {
            $this->postId = 0;
        }
		if ($this->isBlogPost === null) {
            $this->isBlogPost = false;
        }
	}
	
	public function run() {
		$rates = $this->getRates($this->postId, $this->isBlogPost);
		$rating = $rates['rating'];
		$votesCount = $rates['votesCount'];
		if ($this->isBlogPost){
			return $this->render('voteView',[
				'postId' => $this->postId,
				'rating' => $rates['rating'],
				'votesCount' => $rates['votesCount'],
				'ratingJson' => '',
				'isBlogPost' => $this->isBlogPost,
				'alreadyVoted' => $this->voteCheck()
			]);
		}		
		return $this->render('voteView',[
			'postId' => $this->postId,
			'description' => $this->description,
			'name' => $this->name,
			'rating' => $rating,
			'votesCount' => $votesCount,
			'ratingJson' => $this->ratingJson($rating,$votesCount),
			'isBlogPost' => $this->isBlogPost,
			'alreadyVoted' => $this->voteCheck()
				]);
	}
	
	private function voteCheck(){
		$id = $this->postId;
		$isBlogPost = $this->isBlogPost;
		$ip = Yii::$app->request->getRemoteIP();
		if ($isBlogPost){
				$entity = model\Vote::findOne([
				'blog_post_id' => $id,
				'ip' => $ip,
				]);
			}else{
				$entity = model\Vote::findOne([
				'category_id' => $id,
				'ip' => $ip,
				]);	
			}
			if ($entity){
				return true;
			}
			return false;
	}
	
	private function ratingJSON($rating,$votesCount){
		$aggregateRating = '';
	if ($votesCount > 0){
	$aggregateRating = <<<JS
		  ,"aggregateRating": {
			"@type": "AggregateRating",
			"ratingValue": "{$rating}",
			"bestRating": "5",
			"ratingCount": "{$votesCount}"
		  }
JS;
	}
	$ratingJson = <<<JS
	<script type="application/ld+json">
	{
	  "@context": "http://schema.org/",
	  "@type": "WebPage",
	  "name": "{$this->name}",
	  "description": "{$this->description}"
	  {$aggregateRating}	  
	}	
	</script>	
JS;
		return $ratingJson;
	}
			
	static public function getRates($id, $isBlogPost = null){
		if ($isBlogPost){
			$votes = \frontend\modules\blog\components\widgets\votes\model\Vote::find()
			->where(['blog_post_id' => $id]);
		} else {
			$votes = \frontend\modules\blog\components\widgets\votes\model\Vote::find()
			->where(['category_id' => $id]);
		}
		$votesCount = $votes->count();
		$rating = 0;
		if ($votesCount > 0){
			$rating = $votes->sum('rating') / $votesCount;	
		}
		return ['votesCount' => $votesCount, 'rating' => $rating];
	}
	
	private function _registerAssets()
	{
		$this->view->registerAssetBundle('frontend\modules\blog\components\widgets\votes\bundles\VotesAsset');
	}
	
	
}