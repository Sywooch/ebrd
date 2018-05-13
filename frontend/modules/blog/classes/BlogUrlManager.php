<?php

namespace frontend\modules\blog\classes;

use frontend\modules\blog\models\BlogEvent;
use Yii;
use yii\web\UrlManager;
use frontend\models\HdbkLanguage;	
use frontend\modules\blog\components\LanguageSelector;
use frontend\modules\blog\models\BlogCategory;
use frontend\modules\blog\models\BlogPost;
use frontend\modules\blog\Blog;
use frontend\models\Redirects;

/**
 * This class extends Yii's UrlManager and adds features to detect the language
 * from the URL or from browser settings transparently. It also adds the
 * language parameter to any created URL. It also builds the user-friendly path 
 * to category or post.
 */
class BlogUrlManager extends UrlManager
{
	/**
	 * @var array of active languages
	 */
	private $languages;
	/**
	 *
	 * @var string Default application language
	 */
	private $defaultLanguage;
	private $path;
	private $url = '';
	/**
	 * @var string Current application language
	 */
	private $currentLanguage;
	/**
	 * @var string Action for creating user-friendly category path
	 */
	private $categoryViewAction = 'blog/category/front-view';
	/**
	 * @var string Action for creating user-friendly post path
	 */
	private $postViewAction = 'blog/post/front-view';

    /**
     * @var string Action for creating user-friendly event path
     */
    private $eventViewAction = 'blog/event/front-view';
	/**
	 *Root categories of all application languages
	 * @var type array
	 */
	private $rootCats; 


	/**
     * @inheritdoc
     */
    public function init()
    {
		$this->rootCats = \yii\helpers\ArrayHelper::map(BlogCategory::getRootCats(), 'id', 'id');
		$this->currentLanguage = \Yii::$app->language;
		
		if (!empty(Yii::$app->params['settings']['supportedLanguages'])){
			$this->languages = Yii::$app->params['settings']['supportedLanguages'];
		} else {
			$this->languages = HdbkLanguage::getLanguagesSymbolsArray();
		}		
		$this->defaultLanguage = HdbkLanguage::getDefaultLanguageCode();

		parent::init();
    }
    /**
     * Parses the user request.
     * @param yii\web\Request $request the request component
     * @return array|bool the route and the associated parameters. The latter is always empty
     * if [[enablePrettyUrl]] is `false`. `false` is returned if the current request cannot be successfully parsed.
     */
    public function parseRequest($request)
    {
		$this->redirectUaUk($request);
		$this->parseLang($request);

        preg_match('/\/events\/[A-z-0-9]+/',$request->url,$matches);
        if ($matches) {
            $route = $this->parseEvent($request->url);
        } else{
            $route = $this->parseBlog($request);
        }

		$redirects = Redirects::findRedirectByUrl('/'.$request->pathInfo);

		if(!empty($redirects)){
			$lang = Yii::$app->language;
			$newUrl = $redirects->new_url;
			if($lang !== Yii::$app->params['settings']['defaultLanguage']){
				$newUrl = '/'.$lang.$redirects->new_url;
			}
			Yii::$app->response->redirect($newUrl, 301);
			Yii::$app->end();
		}
		
		if (!$route) {
			return parent::parseRequest($request);
		}

		if ($route['postId'] !== 0){
			return [
				Blog::$postViewAction,
				[
					'id' => $route['postId']
				]
			];
		} elseif (isset($route['eventId']) && $route['eventId'] !== 0) {
            return [
                Blog::$eventViewAction,
                [
                    'id' => $route['eventId']
                ]
            ];
        } elseif (sizeof ($route['categoryId'])) {
			return [
				Blog::$categoryViewAction,
				['id' => array_pop($route['categoryId'])]
			];
		}
    }
	
	private function redirectUaUk($request)
	{
		$redirect = ['ua', 'uk/ua', 'uk/ua/'];
		if (in_array($request->pathInfo, $redirect)){
			Yii::$app->response->redirect('/uk/', 301);
			Yii::$app->end();
		} elseif (stripos($request->pathInfo, 'ua/') === 0) {
			Yii::$app->response->redirect('/uk/' . substr($request->pathInfo, 3), 301);
			Yii::$app->end();
		}
	}

		/**
	 * Parses language from url and switching to passed language
	 * @param yii\web\Request $request
	 */
	private function parseLang($request)
	{
			$this->path = $request->getPathInfo();
			$blocks = explode('/', $this->path);
			if (in_array($blocks[0], $this->languages)){
				$pathLang = $blocks[0];
				$this->path = substr($this->path, strlen($pathLang));
				if ($pathLang === $this->defaultLanguage){
					Yii::$app->response->redirect($this->path, 301);				
				}
				if ($this->currentLanguage !== $pathLang){
					if (!Yii::$app->request->isAjax){
						LanguageSelector::switchLanguage($pathLang);
					}
				}
				array_shift($blocks);
			} else {
				if (!Yii::$app->request->isAjax){
					LanguageSelector::switchLanguage($this->defaultLanguage);
				}
			}
			Yii::$app->request->setPathInfo($this->path);	
			$request->setPathInfo('/' . $this->path);
	}

	/**
     * @inheritdoc
     */
    public function createUrl($params)
    {

		$this->currentLanguage = Yii::$app->language;
		if ($params[0] === Blog::$categoryViewAction){
			$this->url = $this->buildCategoryChain($params['id']);
		
		if (sizeof($params) > 2){
			unset($params['id']);
			unset($params['0']);
			$this->url .= '?' . http_build_query($params);
		}
		
		} elseif ($params[0] === Blog::$postViewAction){

			$this->url = $this->buildPostChain($params['id']);

		} elseif ($params[0] === Blog::$eventViewAction){
            $this->url = $this->buildEventUrl($params['id']);
        } else {
			$this->url = parent::createUrl($params);
		}
		
		$this->addLangToUrl();
		return $this->url;
    }
	
	/**
	 * Adds current application language to the beginning of the url
	 * or leave as is if the language is application default
	 * Examples:
	 * /uk/cat/post - if the 'post' is in ukrainian language
	 * /cat/post - if the 'post' is in default application language
	 *  
	 */
	private function addLangToUrl()
	{
		if ($this->currentLanguage !== $this->defaultLanguage){
			$this->url = '/' . $this->currentLanguage . $this->url;
		}
	}
	
	/**
	 * Builds array with all categories chain and postId if the route points to post
	 * @return array
	 */
	private function parseBlog()
	{

		$steps = explode('/', trim($this->path, '/'));
		$route = [
			'categoryId' => [],
			'postId' => 0
		];
		$parentCatId = $this->rootCats;

		for ($i = 0; $i < sizeof($steps) - 1; $i++){
			$child = $this->findChildren($steps[$i], \Yii::$app->language, $parentCatId);
			if (!$child){
				return FALSE;
			} elseif ($child['type'] === 'category'){
				$route['categoryId'][] = $child['id'];
				$parentCatId = $child['id'];
			}
		}
		
		$child = $this->findChildren($steps[$i], \Yii::$app->language, $parentCatId);
		if (!$child){
			return FALSE;
		} elseif ($child['type'] === 'category'){
			$route['categoryId'][] = $child['id'];
		} elseif ($child['type'] === 'post'){
			$route['postId'] = $child['id'];
		}

		return $route;
	}


	private function parseEvent($url){
	    preg_match('/\/events\/([A-z-0-9]+)/', $url, $matches);
        $route = [
            'categoryId' => [],
            'postId' => 0,
            'eventId' => 0
        ];
	    if (isset($matches[1])){
            $event = BlogEvent::getEventByAlias($matches[1]);
            if (is_null($event)){
                return 0;
            }
            $route['eventId'] = $event->id;
            return $route;
        }
        return $route;
    }
	
	/**
	 * Finds child by parent category id, language and alias
	 * 
	 * @param string $alias
	 * @param string $lang
	 * @param integer|array $parentCatId
	 * @return boolean|array False is the child was not found
	 */
	private function findChildren($alias, $lang, $parentCatId)
	{
	
		$flippedLangArray = array_flip(Yii::$app->params['settings']['activeLangsKeyValue']);
		
		$category = BlogCategory::findOne([
				'alias' => $alias,
				'parent_category_id' => $parentCatId,
				'lang_id' => $flippedLangArray[$lang],
			]);
		
		if (is_object($category)){
			return [
				'type' => 'category',
				'id' => $category->id
			];
		}
		
		$post = BlogPost::findOne([
				'alias' => $alias,
				'main_category_id' => $parentCatId,
				'lang_id' => $flippedLangArray[$lang],
			]);

				
		if (is_object($post)){			
			return [
				'type' => 'post',
				'id' => $post->id
			];
		}
		return FALSE;
	}
	
	/**
	 * Builds user-friendly rout to category with subcategories included
	 * Example:
	 * /cat1/cat2/cat3
	 * 
	 * @param integer $catId
	 * @return string
	 */
	private function buildCategoryChain($catId)
	{
		$str = '';
		for (;$catId;){
			$cat = BlogCategory::getCategoryById([$catId]);
			if ((is_object($cat)) && ($cat->id > 1) && (!in_array($cat->id, $this->rootCats))){
				if ($cat->id === $catId){
					$this->currentLanguage = Yii::$app->params['settings']['activeLangsKeyValue'][$cat->lang_id];
				}
				$str = $cat->alias . '/' . $str;
				$catId = $cat->parent_category_id;
			} else {
				$catId = FALSE;
			}
		}
		
		$str = trim($str, '/');

		return '/' . $str;
	}
	
	/**
	 * Builds user-friendly way to post with subcategories included
	 * Example:
	 * /cat1/cat2/cat3/post3
	 * 
	 * @param integer $postId
	 * @return boolean|string if the post vith postId was found
	 */
	private function buildPostChain($postId)
	{
		$str = '';
		$post = BlogPost::getPostById($postId);
		if (is_object($post)){
			$this->currentLanguage = HdbkLanguage::getLangCodeById($post->lang_id);
			$str = self::buildCategoryChain($post->main_category_id);
			$str = rtrim($str, '/');
			$str .= '/' . $post->alias;
			
			return $str;
		}
		
		return FALSE;
	}


    /**
     * Builds user-friendly way to events with subcategories included
     * Example:
     * /event-alias
     *
     * @param integer $eventId
     * @return boolean|string if the post vith postId was found
     */
    private function buildEventUrl($eventId)
    {
        $str = '';
        $event = BlogEvent::getEventById($eventId);
        if (is_object($event)){
            $this->currentLanguage = HdbkLanguage::getLangCodeById($event->lang_id);
            $str .= '/events/' . $event->alias;
            return $str;
        }

        return FALSE;
    }

}
