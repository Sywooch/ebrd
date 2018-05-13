<?php

namespace frontend\modules\plugins\shortcodes\content\button;

use frontend\modules\plugins\shortcodes\ShortcodeWidget;
use frontend\modules\forms\models\FormBuild;
use frontend\modules\forms\models\FormChain;
use yii\helpers\Html;
use Yii;



/**
 * Class YoutubeWidget
 * @package frontend\modules\plugins\shortcodes
 * @author sasha
 */
class ButtonWidget extends ShortcodeWidget
{
	/**
	 * @var string
	 */
	public $title = 'basic title';
	
	/**
	 * @var string
	 */
	public $extraclass;

	/**
	 * @var string
	 */
	public $formid;
	
	/**
	 * @var string
	 */
	public $formname;
	
	/**
	 * @var string
	 */
	public $chainname;


	/**
	 * @var string
	 */
	public $id;


	/**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

		
        $this->registerCss();
    }

    public function run()
    {
		if (empty($this->formid)){
			$form = FormBuild::getFormByName($this->formname);
			if (is_object($form)){
				$this->formid = $form->id;
			} else {
//				return Yii::t('forms', 'FORM_NOT_FOUND');
			}			
		}
		
		$res = Html::button(Yii::t('plugins', $this->title), [
			'id' => $this->id,
			'class' => 'formBtn open_popup ' . $this->extraclass,
			'data-formid' => $this->formid,
			'data-chainid' => FormChain::getChainIdByName($this->chainname)
		]);
		
		$this->registerJs();
		
		return $res;
    }

    protected function registerCss()
    {
        $view = $this->getView();
        $css = <<<CSS
.yt.pull-left {
    margin-right:15px;
}
.yt.pull-right {
    margin-left:15px;
}
CSS;

        $view->registerCss($css);
    }
	
	protected function registerJs()
	{
		$view = $this->getView();
		$js = <<<JS
$(document).on('click', '.formBtn', function(event){
	$("#customModal").removeClass();
	$('#customModal').addClass('myModal');
	$('#customModal').addClass($(event.target).attr('id'));
	$.get({
		url : '/forms/default/form',
		data : {
			formId:$(event.target).attr('data-formid'),
			chainId:$(event.target).attr('data-chainid')
		}
	}).done(function(r){
		$('#customModal').html(r);
	});
});
JS;
		$view->registerJs($js);
	}
}