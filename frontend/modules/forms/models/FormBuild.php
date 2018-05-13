<?php

namespace frontend\modules\forms\models;

use frontend\modules\forms\models\Form;
use yii\base\DynamicModel;
use Yii;

/**
 * Description of FormBuild
 *
 * @author petrovich
 */
class FormBuild extends Form
{
	public static function buildFields($fields)
	{
		$res = [];
		$res[] = 'formTemplateId'; // id from table {{form}}
		$res[] = 'pageTitle';
		$res[] = 'chainStep';
		$res[] = 'chain_id';
		$res[] = 'chain_submit_id';
		
		foreach ($fields as $field){
			$res[] = $field['name'];
		}
		
		return $res;
	}
	
	private function getRules()
	{
		return \yii\helpers\Json::decode($this->rules);
	}

	public function buildDynamicModel()
	{
		$fields = \yii\helpers\Json::decode($this->fields);
		$model = new \yii\base\DynamicModel(FormBuild::buildFields($fields));
		$rules = $this->getRules();
		if (!empty($rules)){
			foreach ($rules as $rule){
				$attr = array_shift($rule);
				$validator = array_shift($rule);
				$model->addRule($attr, $validator, $rule);
			}			
		}
		return $model;
	}
	
	public static function getFormByName($formName)
	{
		return self::findOne(['name' => $formName]);
	}
	
	public function buildTextInput($form, $model, $field)
	{
		if(!empty($field['options'])){
			$options = $field['options'];
			$optionsTranslated = [];
			foreach ($options as $key => $value){
				if($key === 'placeholder'){
					$options[$key] = Yii::t('forms',$value);
				}
			}
		}else{
			$options = [];
		}
		$label = (!empty($field['label'])) ? $field['label'] : '';
		
		return $form->field($model, $field['name'])->textInput($options)->label(Yii::t('forms', $label));
	}
}
