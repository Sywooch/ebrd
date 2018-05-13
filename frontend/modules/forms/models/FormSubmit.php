<?php

namespace frontend\modules\forms\models;

use frontend\modules\forms\models\Form;
use frontend\modules\forms\models\FormChain;
use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use SevenShores\Hubspot\Factory;
use common\models\User;
use frontend\modules\user\models\UserAdd;
use frontend\models\HdbkLanguage;
use yii\helpers\ArrayHelper;
use frontend\modules\letter\models\Letter;
use yii\helpers\Url;

/**
 * Description of FormSubmit
 *
 * @author petrovich
 */
class FormSubmit extends Form
{
	
	private $answerWrap = '<div class="answerWrap">%s</div>';
	
	private $uploadPath = '../uploads/' ;

	private $formData;

	private $formModel;
	
	private $model;
	
	public $formFields;

	public function processForm($formData)
	{
		$this->formData = $formData;
		$this->formModel = FormBuild::findOne($this->id)->buildDynamicModel();
		$this->formFields = Json::decode($this->fields);
		$this->dynamicLoad($this->formData);
		
		if ($this->formModel->hasErrors()){
			return sprintf($this->answerWrap, Yii::t('forms', 'YOUR_DATA_IS_NOT_VALID'));
		}
		
		if ($this->saveData($formData)){
			
			if(!empty(FormBuild::findOne($this->id)->attach_file)){
				$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'];
				$linkPath = '/e-book/';
				$link = Html::a($url.$linkPath.Yii::$app->language.'/'.FormBuild::findOne($this->id)->attach_file, $url.$linkPath.Yii::$app->language.'/'.FormBuild::findOne($this->id)->attach_file);
				$this->sendAttachFileLink($formData, $link);
			}
			
			if(!empty($formData['email'])){
				if(empty(User::findByEmailNoStatus($formData['email']))){
					$userAdd = new UserAdd();
					$userAdd->inviteUser($formData['email']);
				}
			}
			
			if (!empty($this->mail_to)){
				$this->sendMails($formData);
			}

			if (!empty($this->hubspot_form_guid)){
				$formId = $this->hubspot_form_guid;
				$this->sendHubspot($formData,$formId);
			}
			
			if (!empty($formData['chain_id'])){
				return  $this->getNextForm();
			} else {
				unset($this->formFields);
			}
			
			$this->extraActions();
			
			return sprintf($this->answerWrap, Yii::t('forms', 'ORDERED_SUCCESSFULLY_WILL_CALL_YOU'));
		}
		return sprintf($this->answerWrap, Yii::t('forms', 'SOMETHING_WENT_WRONG'));
	}
	
	protected function extraActions()
	{
		$extraActions = Json::decode(stripslashes($this->extra_actions));
		if (!empty($extraActions['redirectOnSubmit'])){
			return Yii::$app->controller->redirect(Url::to([$extraActions['redirectOnSubmit']]));
		}
	}

	protected function getNextForm()
	{
		$formChain = FormChain::findOne($this->formData['chain_id']);
		$forms = Json::decode($formChain->steps);
		if ($this->formData['chainStep'] < sizeof($forms) -1){
			$params['chainId'] = $this->formData['chain_id'];
			$params['chainSubmitId'] = $this->formData['chain_submit_id'];
			$params['chainStep'] = ++$this->formData['chainStep'];
			return $params;
		} else {
			$this->formFields = NULL;
			if(!empty($this->extra_actions)){
				$extraActions = Json::decode(stripslashes($this->extra_actions));
				return Yii::$app->controller->redirect(Url::to($extraActions['redirectOnSubmit']));
			}
			return sprintf($this->answerWrap, $formChain->answer);
		}
	}
	
	protected function logFormSubmission()
	{
		$formChainSubModel = FormChain::className() . $this->formData['chain_id'];
		$columnName = 'form_' . $this->formData['formTemplateId'] . '_id';
		$chainSubRow = $formChainSubModel::findOne($this->formData['chain_submit_id']);
		$chainSubRow->{$columnName} = $this->model->id;
		if (empty($chainSubRow->referrer)){
			$chainSubRow->referrer = Yii::$app->request->referrer;
		}
		$chainSubRow->submitted_at = date('Y-m-d H:i:s');
		
		return $chainSubRow->save();
	}

	protected function dynamicLoadRules()
	{	
		$rules = Json::decode($this->rules);
		foreach ($rules as $rule){
			$this->formModel->addRule(array_shift($rule), array_shift($rule), $rule);
		}		
	}

	protected function dynamicLoad($formData)
	{
		foreach ($this->formFields as $field){
			if (isset($formData[$field['name']])){
				if($field['type'] === 'fileInput'){
					$this->formModel->{$field['name']} = \yii\web\UploadedFile::getInstance($this->formModel, $field['name']);
				} else {
					$this->formModel->{$field['name']} = $formData[$field['name']];
				}
			}
		}
		
		$this->dynamicLoadRules();
	}

	protected function saveData($formData)
	{
		$modelName = '\\' . \frontend\modules\forms\models\Form::className() . $this->id;
		$this->model = new $modelName();
		
		foreach ($this->formFields as $field){
			if(isset($formData[$field['name']])){
				if($field['type'] === 'fileInput'){
					$security = new \yii\base\Security();
					$newFileName = date('Ymd_His') . $security->generateRandomString(17) . '.'. $this->formModel->{$field['name']}->getExtension();
					$this->model->{$field['name']} = $newFileName;
					$this->formModel->{$field['name']}->saveAs($this->uploadPath . $newFileName);
				} else {
					$this->model->{$field['name']} = $this->formModel->{$field['name']};
				}
			}
		}
		$this->model->referrer = Yii::$app->request->referrer;
		if (!empty($this->formData['chain_id'])){
			return ($this->model->save()) && ($this->logFormSubmission());
		} else {
			return ($this->model->save());
		}
		
	}
	
	protected function sendMails($formData)
	{
		$addresses = array_map('trim', explode(',', $this->mail_to));
		$mail =  Yii::$app->mailer->compose();
		$mail->setFrom([\Yii::$app->params['adminEmail'] => Yii::$app->name])
			->setTo($addresses)
			->setSubject(Yii::t('forms', 'FORM_{form_name}_SUBMITTED', ['form_name' => $this->name]) . ' at ' . date('Y-m-d H:i'))
			->setHtmlBody($this->buildMailBody($formData));
		
			foreach ($this->formFields as $field){
				if ($field['type'] === 'fileInput'){
					$mail->attach($this->uploadPath . $this->model->{$field['name']});
				}
			}
		
		return $mail->send();
	}
	
	protected function sendAttachFileLink($formData, $link)
	{
		
		$languages = ArrayHelper::map(HdbkLanguage::getLanguagesSymbols(), 'code', 'id');
		$language = \Yii::$app->language;
		$langId = $languages[$language];
		$model = Letter::find()->where(['name' => 'ebook', 'lang_id' => $langId])->one() ??
				Letter::find()->where(['name' => 'ebook', 'lang_id' => $languages['en']])->one();
		$message = self::buildAttachFileLinkBody($model->content, $formData, $link);
		$subject = $formData['pageTitle'];
		return \Yii::$app->mailer->compose()
						->setFrom([\Yii::$app->params['adminEmail'] => Yii::$app->name])
						->setTo($formData['email'])
						->setHtmlBody($message)
						->setSubject($subject)
						->send();
	}
	
	protected function buildAttachFileLinkBody($content,$formData,$link)
	{
		unset($formData['formTemplateId']);
        $content = preg_replace("/{{user_name}}/ui", $formData['full_name'], $content);
		$content = preg_replace("/{{theme}}/ui", $formData['pageTitle'], $content);
        $content = preg_replace("/{{e_book_link}}/ui", $link, $content);
		if(\Yii::$app->language == 'uk'){
			$content .= \Yii::$app->params['settings']['sing_uk'];
		}else{
			$content .= \Yii::$app->params['settings']['sing_en'];
		}
		
		return $content;
	}
	
	protected function buildMailBody($formData)
	{
		unset($formData['formTemplateId']);
		$string = '<p>' . Yii::t('forms', 'FORM_<b>{form_name}</b>_WAS_SUBMITTED_ON_NEW.AIMARKETING.INFO', ['form_name' => $this->name]) . '</p>';
		$string .= '<p>' . Yii::t('forms', 'FORM_WAS_ON_PAGE') . ': ' . Html::a(Yii::$app->request->referrer, Yii::$app->request->referrer) . '</p>';
		$string .= '<p>' . Yii::t('forms', 'FORM_DATA') . ':' . '</p>';
		foreach ($formData as $field => $value){
			$string .= $field . ': ' . $value . '<br>';
		}
		
		return $string;
	}
	
	protected function sendHubspot($formData, $formId)
	{
		$hubspot = new Factory([
			'key' => '10658b0e-1d8f-4615-8974-26ee1e44bd9d',
			'oauth' => FALSE,
			'base_url' => 'https://api.hubapi.com'
		]);

		$portal_id = 4009075;
		
		unset($formData['formTemplateId']);
		
		$pageTitle = $formData['pageTitle'];
		
		unset($formData['pageTitle']);
		
		$sendData = $formData + [
			'hs_context' => json_encode([
				'pageName' => $pageTitle,
				'pageUrl'=> Yii::$app->request->referrer]
			)];
		$form = $hubspot->forms()->submit($portal_id, $formId, $sendData);
	}
}
