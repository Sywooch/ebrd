<?php

namespace frontend\modules\blog\components\widgets\lead_generation;

use yii\base\Widget;


/**
 * Widget for selecting application language
 */
class LeadGeneration extends Widget
{	
	public function init() {
		$this->_registerAssets();
		parent::init();
	}
	
	public function run() {
		
		$model = new LeadGenerationForm;
		
		return $this->render('leadGeneration',['model' => $model]);
	}
	
	private function _registerAssets()
	{
		$this->view->registerAssetBundle('frontend\modules\blog\components\widgets\lead_generation\bundles\LeadGenerationAsset');
	}
}