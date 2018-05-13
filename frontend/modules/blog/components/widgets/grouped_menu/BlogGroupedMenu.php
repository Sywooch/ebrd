<?php

namespace frontend\modules\blog\components\widgets\grouped_menu;

use yii\base\Widget;
use frontend\modules\blog\models\BlogCategory;
use frontend\modules\blog\models\BlogGroup;
use Yii;
use yii\helpers\Url;


class BlogGroupedMenu extends Widget
{
	/**
	 *	Id of category for building menu
	 *
	 * @var integer
	 */
	public $categoryId;

	public $options;

	/**
	 * Structure of menu
	 *			'items' => [
	 *				[
	 *					'categoryId' => 2,
     *                  'url' => 'some url' // if isset replace alias of category
	 *					'menuColumns' => [
	 *						[2, 3], //groups in column
	 *						[4]
	 *					]
	 *				],
	 *				[
	 *					'categoryId' => 3,
	 *					'menuColumns' => [
	 *						[14, 15],
	 *						[16]
	 *					]
	 *				]
	 *			],
	 *
	 * @var array
	 */
	public $structure;

	/**
	 *
	 * @var string
	 */
	private $result = '';

	/**
	 * Current route, like ['/blog/category/view', 'id' => 7]
	 * @var Array
	 */
	private $currentRoute;

	public function init() {
		$this->_registerAssets();

		$this->setCurrentRoute();
		$this->setStructure();
		$this->setOptions();

		parent::init();
	}

	public function run() {
//		return 'test';
		$this->result = '<ul class="' . $this->options['class'] . '">';
		foreach ($this->structure['items'] as $item){
			$mainCat = BlogCategory::findOne($item['categoryId']);
			if (is_object($mainCat) && $mainCat->status_id === BlogCategory::STATUS_PUBLISHED){

			    if (isset($item['url'])){
			        $route = $item['url'];
                } else{
                    $route = ['/blog/category/front-view', 'id' => $mainCat->id];
                }

				if (empty($this->categoryId)){
					$this->result .= '<li class="parent_block">' . \yii\helpers\Html::a($mainCat->menu_section, $route);
				}

				if (sizeof($item['menuColumns']) > 0){
					$this->buildColumns($item['menuColumns']);
				}
				if (empty($this->categoryId)){
					$this->result .= '</li>';
				}

			}
		}

		$this->result .= '</ul>';

		return $this->result;
	}

	private function _registerAssets()
	{
		$this->view->registerAssetBundle('frontend\modules\blog\components\widgets\grouped_menu\bundles\GroupedMenuAsset');
	}

	private function buildColumns($columns)
	{
		$concat_class = '';
		if((sizeof($columns) === 1) && empty($this->categoryId)){
			$concat_class = '_child';
		}else{
			$concat_class = '';
		}
		$this->result .= '<ul class="menu_block'.$concat_class.'">';
		foreach ($columns as $groups){
			$this->buildGroups($groups,$columns);
		}
		$this->result .= '</ul>';
	}

	private function buildGroups($groups,$columns)
	{
		if (sizeof($groups) > 0){
			$this->result .= '<li class="menu_col">';
			foreach ($groups as $group){
				$this->buildGroup($group, $groups, $columns);
			}
			$this->result .= '</li>';
		}

	}

	private function buildGroup($group, $groups, $columns)
	{
		$groupObj = BlogGroup::find()->where(['status_id' => BlogGroup::STATUS_PUBLISHED, 'id' => $group])->one();

		if(!empty($groupObj)){
			$this->result .= '<ul class="menu_group">';
		}
		$class = '';
		$concat = '';

		if (!empty($groupObj->categories)){
			foreach ($groupObj->categories as $cat){
				$route = ['/blog/category/front-view', 'id' => $cat->id];
				if (($this->currentRoute === $route) || (\yii\helpers\Url::to($this->currentRoute) === $groupObj->url)){
					$class = 'active';
					break;
				} else {
					$class = '';
				}
			}
		}
		if ((sizeof($groups) === 1) && (sizeof($columns) === 1)){
			$this->result .= '';
			$concat = '_special';
		}else{
			if (!empty($groupObj->url)) {
				$this->result .= '<li class="group_name ' . $class . '"><a href="'.$groupObj->url.'">' . $groupObj->name . '</a></li>';
			} elseif (!empty ($groupObj->name)){
				$this->result .= '<li class="group_name ' . $class . '"><span>' . $groupObj->name . '</span></li>';
			}
			$concat = '';
		}
		if (!empty($groupObj->categories)){
		$this->result .= '<ul class="child_menu_group'.$concat.'">';
			foreach ($groupObj->categories as $cat){
				if($cat['status_id'] === BlogCategory::STATUS_PUBLISHED){
					$route = ['/blog/category/front-view', 'id' => $cat->id];

					if ($this->currentRoute === $route){
						$class = 'active';
					} else {
						$class = '';
					}
					if(Url::to(['/blog/category/front-view', 'id' => $cat->id]) !== $groupObj->url){
						$this->result .= '<li class="' . $class . '">' . \yii\helpers\Html::a($cat->menu_section, $route) . '</li>';
					}
				}
			}
		$this->result .= '</ul>';
		}
		if(!empty($groupObj)){
			$this->result .= '</ul>';
		}
	}

	private function getCategoryStructure()
	{
		$res = BlogCategory::find()
			->select(['group_id'])
			->where([
				'parent_category_id' => $this->categoryId,
				'blog_group.status_id'	=> BlogGroup::STATUS_PUBLISHED,
			])
			->joinWith('group')
			->distinct()
			->column();

		$this->structure = [
			'items' => [
				[
					'categoryId' => $this->categoryId,
					'menuColumns' => [$res]
				]

			]

		];

		$this->options['class'] = 'vert_menu nav';
	}

	private function setCurrentRoute()
	{
		if (!empty(Yii::$app->controller->module->module->requestedRoute)){
			$currentAction = Yii::$app->controller->module->module->requestedRoute;
		} else {
			$currentAction = Yii::$app->controller->module->requestedRoute;
		}

		if (!empty(Yii::$app->controller->module->module->requestedRoute)){
			$currentActionParams = Yii::$app->controller->module->module->controller->actionParams;
		} else {
			$currentActionParams = Yii::$app->controller->module->controller->actionParams;
		}

		$this->currentRoute[] = '/' . $currentAction;
		foreach ($currentActionParams as $key => $val){
			$this->currentRoute[$key] = $val;
		}
	}

	private function setOptions()
	{
		if (empty($this->options['class'])){
			$this->options['class'] = 'top_menu';
		}
	}

	private function setStructure()
	{
		if (empty($this->structure)){
			if (empty($this->categoryId)){
				$this->structure = $this->getMultilangStructure()[Yii::$app->language];
			} else {
				$this->getCategoryStructure();
			}
		}
	}

	public static function getMultilangStructure()
	{
		return [
			'uk' => [
				'items' => [
                    [
                        'categoryId' => 374,
                        'url' => '/uk/',
                        'menuColumns' => []
                    ],
                    [
                        'categoryId' => 375,
                        'menuColumns' => [
							[107]
						]
                    ],
                    [
                        'categoryId' => 376,
                        'menuColumns' => []
                    ],
                    [
                        'categoryId' => 379,
                        'menuColumns' => []
                    ],
                    [
                        'categoryId' => 380,
                        'menuColumns' => []
                    ],
                    [
                        'categoryId' => 377,
                        'menuColumns' => []
                    ],
                    [
                        'categoryId' => 378,
                        'menuColumns' => []
                    ],
				]
			],
			'en' => [
				'items' => [
					[
						'categoryId' => 360,
                        'url' => '/',
						'menuColumns' => [

						]
					],
					[
						'categoryId' => 361,
						'menuColumns' => [
	 						[106]
	 					]
					],
					[
						'categoryId' => 362,
						'menuColumns' => [

						]
					],
					[
						'categoryId' => 363,
						'menuColumns' => [

						]
					],
					[
						'categoryId' => 364,
						'menuColumns' => [

						]
					],
					[
						'categoryId' => 365,
						'menuColumns' => [

						]
					],
                    [
						'categoryId' => 366,
						'menuColumns' => [

						]
					],
				]
			],
			'pl' => [
				'items' => [],
			],
			'pt' => [
				'items' => [],
			],
			'tr' => [
				'items' => [],
			],
			'zh' => [
				'items' => [],
			]
		];
	}

	public static function getMultilangFooterStructure($lang)
	{
		$menu_items = [];
		$links = [];
		foreach (self::getMultilangStructure()[$lang]['items'] as $id){
		    $menu_item = [
                'category' => BlogCategory::getCategory($id['categoryId'])[0],
                'url' => isset($id['url'])?$id['url']:null
            ];
		    $menu_items[] = $menu_item;
//			array_push($cats, BlogCategory::getCategory($id['categoryId']));
		}

		foreach ($menu_items as $menu_item){
			array_push($links,
                [
                    'label' => $menu_item['category']['menu_section'],
                    'url' =>  isset($menu_item['url'])?$menu_item['url']:['/'.$menu_item['category']['alias']]
                ]
            );
		}

		return $links;
	}

	public function getMultilangCategoryStructure($lang, $currentId)
	{
		$rootCats = BlogCategory::getRootCatsIds();
		$curentCategory = BlogCategory::getCategory($currentId)[0];

		$groups = [];
		$categories = [];

		foreach (self::getMultilangStructure()[$lang]['items'] as $item){
			if($item['categoryId'] == $currentId){
				foreach ($item['menuColumns'] as $colums){
					foreach ($colums as $groupId){
						$groupObj = BlogGroup::getGroupPublished($groupId);
						if(!empty($groupObj)){
							$groups[] = $groupObj;
						}
					}
				}
			}
		}

		if(empty($curentCategory->group_id)){
			if(sizeof($groups) == 1){
				$cats = BlogCategory::getCategoriesByGroup($groups[0]->id);
				foreach ($cats as $cat){
						if($groups[0]->url != Url::to(['/blog/category/front-view', 'id' => $cat->id])){
							$categories[] = $cat;
						}
					}
				$html = self::buildStructure($categories, 1);
			}else{
				$html = self::buildStructure($groups, 0);
			}
		}else{
			if($curentCategory->group->url == Url::to(['/blog/category/front-view', 'id' => $curentCategory->id])){
				$cats = BlogCategory::getCategoriesByGroup($curentCategory->group_id);
				foreach ($cats as $cat){
						if($curentCategory->group->url != Url::to(['/blog/category/front-view', 'id' => $cat->id])){
							$categories[] = $cat;
						}
					}
				if(!empty($categories)){
					$html = self::buildStructure($categories, 1);
				}else{
					$html = self::buildLatsStructure();
				}
			}else{
				$html = self::buildLatsStructure();
			}
		}

		return $html;

	}


	private function buildStructure($items, $type)
	{
		if($type == 0){
			foreach ($items as $item){
				$position = strripos($item->url, "/");
				$alias = substr($item->url, $position + 1, strlen($item->url));
				$item->thumbnail = BlogCategory::getThumbnails($alias, 43)->thumbnail;
			}
		}

		$html = '<div class="blog_category_content">';
		$html .= '<div class="blog_category_content_flex_container">';
		foreach ($items as $item){
			if(empty($item->thumbnail)){
				$image = '/images/cat_back.jpg';
			}else{
				$image = Yii::$app->imagemanager->getImagePath($item->thumbnail,1920,1080,'inset');
			}
			$html .= '<div class="blog_category_flex_item_container">';
			$html .= '<div class="blog_category_flex_item" style="background-image: url('.$image.')">';
			$html .= '<div class="blog_category_overlay"></div>';
			$html .= '<div class="blog_category_overlay_hover"></div>';
			$html .= '<div class="blog_category_flex_item_content">';
			$html .= '<div class="blog_category_item_name" >';
			if($type == 0){
				$html .= $item->name;
			}else{
				$html .= $item->menu_section;
			}
			$html .= '</div>';
			$html .= '<hr class="blog_category_item_hr">';
			$html .= '<div class="blog_category_item_btn">';
			if($type == 0){
				$html .= '<a class="link_cating" href="'.$item->url.'">';
			}else{
				$html .= '<a class="link_cating" href="'.Url::to(['/blog/category/front-view', 'id' => $item->id]).'">';
			}
			$html .= Yii::t('blog', 'DETAIL');
			$html .= '</a>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
		}
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}

	private function buildLatsStructure()
	{
// 		$html = '<div class="blog_category_content">';
// //		$html .= 'dfgf';

// 		$html .= '<div class="blog_category_last_container">';
// 		$html .= '<div class="blog_category_last_container_title">'.Yii::t('blog','LAST_FRAZE').' <span class="colored_numbers">'.Yii::t('blog','LAST_FRAZE_TWO').'</span> '.Yii::t('blog','LAST_FRAZE_THREE').'</div>';
// 		$html .= '<div class="blog_category_last_flex_container">';
// 		$html .= '<div class="item_last_flexing"><div class="number_my">1</div><img src="/images/market/market-1.jpg" alt="last_fraze_image" class="last_fraze_image"><div class="last_fraze_text">'.Yii::t('blog','FRAZE_TEXT_ONE').'</div></div>';
// 		$html .= '<div class="item_last_flexing"><div class="number_my">2</div><img src="/images/market/market-2.jpg" alt="last_fraze_image" class="last_fraze_image"><div class="last_fraze_text">'.Yii::t('blog','FRAZE_TEXT_TWO').'</div></div>';
// 		$html .= '<div class="item_last_flexing"><div class="number_my">3</div><img src="/images/market/market-3.jpg" alt="last_fraze_image" class="last_fraze_image"><div class="last_fraze_text">'.Yii::t('blog','FRAZE_TEXT_THREE').'</div></div>';
// 		$html .= '<div class="item_last_flexing"><div class="number_my">4</div><img src="/images/market/market-4.jpg" alt="last_fraze_image" class="last_fraze_image"><div class="last_fraze_text">'.Yii::t('blog','FRAZE_TEXT_FOUR').'</div></div>';
// 		$html .= '<div class="item_last_flexing"><div class="number_my">5</div><img src="/images/market/market-5.jpg" alt="last_fraze_image" class="last_fraze_image"><div class="last_fraze_text">'.Yii::t('blog','FRAZE_TEXT_FIVE').'</div></div>';
// 		$html .= '</div>';
// 		$html .= '</div>';

// 		$html .= '</div>';
		return '';
	}
}

