<?php

namespace frontend\modules\blog\components\widgets\lang_switcher;

use yii\helpers\Html;
use yii\base\Widget;
use frontend\models\HdbkLanguage;
use frontend\modules\blog\Blog;
use frontend\modules\blog\models\BlogHdbkEntity;
use frontend\modules\blog\models\BlogMapEntityLang;
use Yii;

/**
 * Widget for selecting application language
 */
class LanguageSwitcher extends Widget
{
	public $options;
	
	private $result = '';
	
	public function init() {

	    if (!isset($this->options['class'])) {
            $this->options['class'] = '';
        }
        if (!isset($this->options['simple'])) {
            $this->options['simple'] = false;
        }
		$this->_registerAssets();
		parent::init();
	}

	/**
     * Return a list of languages
     * If widget take parameter 'simple' is true work simple function
     */

	public function run() {
		$this->getLangLinks();
        if ($this->options['simple']){
            $this->getLangLinksSimpleList();
        } else {
            $this->getLangLinks();
        }
		return $this->result;
	}
    /**
     * Get list of languages with drop down menu
     */
	private function getLangLinks()
	{
		$this->result = '<div class="dropdown ' . $this->options['class'] . '">';
		$this->result .= '<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">'  . HdbkLanguage::getLanguageByCode(Yii::$app->language)->code . ' ';
		$this->result .= '<span class="caret"></span></button>';
		$this->result .= '<ul class="dropdown-menu" id="main_ls">';
		$this->getInacLanguagesTrait();
		$this->result .= '</ul></div>';
	}

    /**
     * Get simple list of languages
     */
	private function getLangLinksSimpleList()
    {
        $this->result = '<li>';
        $this->result .= HdbkLanguage::getLanguageByCode(Yii::$app->language)->code;
        $this->getInacLanguagesTrait();
    }

    /**
     * This function get inactive languages to use in 2 functions getLangLinks and getLangLinksSimpleList for not duplicate.
     */
    private function getInacLanguagesTrait(){
        $blogActions = [
            Blog::$categoryViewAction,
            Blog::$postViewAction,
        ];

        if (!empty(Yii::$app->controller->module->module->requestedRoute)){
            $currentAction = Yii::$app->controller->module->module->requestedRoute;
        } else {
            $currentAction = Yii::$app->controller->module->requestedRoute;
        }
        if (in_array($currentAction, $blogActions)){
            $this->getBlogCategorizedLinks($currentAction);
        } else {
            $this->getGeneralLinks();
        }
    }


	private function getBlogCategorizedLinks($currentAction)
	{
		$initialLang = Yii::$app->language;
		$entityName = explode('/', $currentAction)[1];
		$entityId = Yii::$app->controller->module->module->controller->actionParams['id'];
		$entityTypeId = BlogHdbkEntity::findOne(['entity' => $entityName])->id;
		if (!empty($entityId)){
			$translations = BlogMapEntityLang::findOne([
				'entity_type_id' => $entityTypeId,
				Yii::$app->language => $entityId
			]);

			foreach (Yii::$app->params['settings']['activeLangsObjs'] as $language){
				if ($language->code != $initialLang){
					if (!empty($translations->{$language->code})){
						$this->result .= '<li class="lang_inac">' . Html::a($language->code, ['/' . $currentAction , 'id' => $translations->{$language->code}]) . '</li>';
					} else {
						Yii::$app->language = $language->code;
						//uncomment next line if you want to see links to main page and the translation does not exists
//						$this->result .= '<li class="lang_inac">' . Html::a($language->name, ['/']) . '</li>';
					}
				}
				
			}
		}
		Yii::$app->language = $initialLang;
	}
	
	private function getGeneralLinks()
	{
		$basicUrl = Yii::$app->request->getUrl();
		if (Yii::$app->language !== Yii::$app->params['settings']['defaultLanguageId']){
			if (stripos($basicUrl, '/' . Yii::$app->language . '/') === 0){
				$basicUrl = substr($basicUrl, 3);
			}elseif ((Yii::$app->controller->id == 'site') && (Yii::$app->controller->action->id == 'index')) {
				$basicUrl = '/';
			}
		}
		foreach (Yii::$app->params['settings']['activeLangsObjs'] as $language){
			if ($language->code !== Yii::$app->language){
				if ($language->id != Yii::$app->params['settings']['defaultLangObj']->id){	
					$posts = \frontend\modules\blog\models\BlogPost::find()
							->where([
								'blog_category.alias' => 'main-page',
								'blog_category.lang_id' => HdbkLanguage::getLanguageByCode($language->code),
								'blog_post.status_id'	=> \frontend\modules\blog\models\BlogPost::STATUS_PUBLISHED,
							])
							->joinWith('category')
							->count();
					if ($posts > 0){
						$this->result .= '<li class="lang_inac">' . Html::a($language->code, '/' . $language->code . $basicUrl) . '</li>';
					}	
				} else {				
						$this->result .= '<li class="lang_inac">' . Html::a($language->code, $basicUrl) . '</li>';
				}
			}				
		}
	}
	
	private function _registerAssets()
	{
		$this->view->registerAssetBundle('frontend\modules\blog\components\widgets\lang_switcher\bundles\LanguageSwitcherAsset');
	}
}