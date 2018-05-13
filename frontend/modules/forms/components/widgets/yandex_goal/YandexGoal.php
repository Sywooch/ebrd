<?php

namespace frontend\modules\forms\components\widgets\yandex_goal;

use yii\base\Widget;

class YandexGoal extends Widget
{
	public $formId = null;
	
	public $submittedFormId = null;

	public $yandexFormId = '';

	public function init() {

		$this->setFormIdFromYandex();
		parent::init();
	}
	
	public function run() 
	{
		$this->getJS();		
	}
	
	private function setFormIdFromYandex()
	{
		$form = \frontend\modules\forms\models\Form::findOne(['id' => $this->formId]);
		
		$this->yandexFormId = $form->name;
		
//		return $form->name;
	}

	
	
	private function getJS()
	{
//		echo '<pre>';
//		var_dump($this->formId);
//		var_dump($this->yandexFormId);
//		echo '</pre>';
		
		$js = <<<JS
			
		var formId = '#'+"$this->submittedFormId";	
		var form = "$this->yandexFormId";

		$(formId).submit(function(event) {
				console.log("$this->yandexFormId");
				yaCounter47926829.reachGoal(form);
				return true;
		});

		console.log('yandex app started');
JS;
		$view = $this->getView();
		$view->registerJs($js);
	}
}
