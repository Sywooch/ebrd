<?php

namespace frontend\modules\forms\components\widgets\form;

use yii\base\Widget;
use frontend\modules\forms\models\FormBuild;
use frontend\modules\forms\models\FormChain;
use Yii;

class Form extends Widget
{
	/**
	 * form id from {{form}} table
	 * 
	 * @var integer
	 */
	public $formId;
	
	/**
	 * chain id if widget have to render form from form-chain
	 * 
	 * @var integer
	 */
	public $chainId;
	
	/**
	 * current step in form-chain
	 * 
	 * @var integer
	 */
	public $chainStep;
	
	/**
	 *  When widget renders first form from chain we create record in table form_chain_ChainNumber
	 * This variable is id of this record.
	 * 
	 * @var integer
	 */
	public $chainSubmitId;

	public $savedFormId;

	/**
	 * @var frontend\modules\forms\models\Form
	 */
	public $commonModel;

	public $ajaxSubmit = true;


	public function init() {
		parent::init();
	}
	
	public function run() {
		if (!empty($this->formId)){
			$this->commonModel = FormBuild::findOne(['id' => $this->formId]);
		} elseif (!empty ($this->chainId)){
			$this->prepareChainModel();
		}
		
		$model = $this->commonModel->buildDynamicModel();
		$model->formTemplateId = $this->commonModel->id;
		if(!empty($this->chainId)){
			$model = $this->setChainExtraFields($model);
		}
		$this->commonModel->form_id .= \Yii::$app->security->generateRandomString(7);
		if ($this->ajaxSubmit){
			$this->registerJs($this->commonModel->form_id);
		}
		
		return $this->render('form', [
			'commonModel' => $this->commonModel,
			'model' => $model,
		]);
	}
	
	protected function setChainExtraFields($model){
			$model->chainStep = $this->chainStep;
			$model->chain_id = $this->chainId;
			$model->chain_submit_id = $this->chainSubmitId;		
			
			return $model;
	}

	protected function prepareChainModel(){
		$modelName = '\\' . \frontend\modules\forms\models\FormChain::className() . $this->chainId;
		if (empty($this->chainStep)){
			$this->chainStep = 0;
			$chainSubmit = new $modelName();
			$chainSubmit->save();
			$this->chainSubmitId = $chainSubmit->id;
		}
		
		$this->commonModel = FormBuild::findOne(FormChain::getFormId($this->chainId, $this->chainStep));		
	}

	protected function registerJs($formId)
	{
		$view = $this->getView();
		$js = <<<JS
$(document).off('beforeSubmit', '#$formId');
$(document).on('beforeSubmit', '#$formId', function(){
	var form = $(this);
	var pageTitle = $(document).find("title").text();
	form.find('#dynamicmodel-pagetitle').val(pageTitle);
	// return false if form still have some validation errors
	
    var formData = new FormData(this);
	if (form.find('.has-error').length) {
		return false;
	}
	form.find('button').prop('disabled', true);
	scriptOnSubmit{$this->commonModel->name}();
	// submit form
	$.ajax({
		url: form.attr('action'),
		type: 'post',
		data: formData,
	
   //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false
	}).done(function (r) {
			if (!$('#myModContId').hasClass('opened_magick')){
				$('#myModContId').addClass('opened_magick');
			}
			$('#customModal').html(r);
			form[0].reset();
			form.find('button').prop('disabled', false);
	});
	return false;
});

$(document).keyup(function(e) {
    if (e.keyCode == 27) {
            $('#myModContId').removeClass('opened_magick');
    }
}); 
       
$('.close_magick_cantainer').on('click',function(event){
    $('#myModContId').removeClass('opened_magick');
})
        
function scriptOnSubmit{$this->commonModel->name}(){
	{$this->commonModel->script_on_submit}
}
JS;
		$view->registerJs($js);
	}
}
