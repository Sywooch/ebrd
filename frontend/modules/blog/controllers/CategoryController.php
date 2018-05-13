<?php

namespace frontend\modules\blog\controllers;

use frontend\modules\blog\models\BlogEvent;
use Yii;
use frontend\modules\blog\models\BlogCategory;
use frontend\models\HdbkLanguage;
use frontend\modules\blog\models\BlogCategorySearch;
use yii\web\Controller;
use frontend\modules\blog\models\BlogMapEntityLang;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use frontend\modules\blog\models\BlogHdbkStatus;
use frontend\modules\blog\models\BlogPost;
use frontend\modules\blog\models\BlogGroup;
use yii\data\ActiveDataProvider;
use frontend\components\traits\FilterTrait;
use frontend\modules\blog\models\BlogHdbkLayout;
use frontend\modules\blog\models\SearchBlogStakeholder;
use yii\helpers\Url;


/**
 * CategoryController implements the CRUD actions for BlogCategory model.
 */
class CategoryController extends Controller
{
	use FilterTrait;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions' => ['front-view'],
						'roles' => ['@', '?'],
					],
					[
						'allow' => true,
						'actions' => [
							'create-translation',
							'group-by-lang',
							'list-by-lang',
							'update',
							'view',
							'update-post-in-category',
						],
						'roles' => ['editItem'],
					],
					[
						'allow' => true,
						'actions' => ['create'],
						'roles' => ['createItem']
					],
					[
						'allow' => true,
						'actions' => ['delete'],
						'roles' => ['deleteItem'],
					],
					[
						'allow' => true,
						'actions' => ['translate', 'save-translation','edit-translation'],
						'roles' => ['translate'],
					],
					[
						'allow' => true,
						'actions' => ['index', 'reset-filter'],
						'roles' => ['translate', 'publishItem', 'editItem'],
					],
					[
						'allow' => true,
						'actions' => ['update-status'],
						'roles' => ['publishItem']
					],
					[
						'allow' => true,
						'actions' => ['news'],
						'roles' => ['@', '?']
					],
				],
			],
        ];
    }

    public function actionListByLang($id)
    {

        $cats = BlogCategory::find()
                ->where(['lang_id' => $id])
                ->orderBy('name')
                ->all();

        if(sizeof($cats)>0){
            foreach($cats as $cat){
                echo "<option value='".$cat->id."'>".$cat->name."</option>";
            }
        }
        else{
            echo "<option> - ".Yii::t('blog', 'Categories with such language do not exist')." - </option>";
        }

    }

    public function actionGroupByLang($id)
    {
        $groups = BlogGroup::find()
            ->where(['lang_id' => $id])
            ->orderBy('name')
            ->all();

        if(sizeof($groups)>0){
            foreach($groups as $group){
                echo "<option value='".$group->id."'>".$group->name."</option>";
            }
        }else{
            echo "<option> - ". Yii::t('blog', 'Grops with such language do not exist') ." - </option>";
        }
    }

    /**
     * Lists all BlogCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
		$model = new BlogCategory();

        $searchModel = new BlogCategorySearch();
		$params = $this->saveFilter('category', Yii::$app->request->queryParams);
		$dataProvider = $searchModel->search($params);

		$parent_search = BlogCategory::getParentSearch();

		$languages = HdbkLanguage::getLanguagesSymbols();
		$items = ArrayHelper::map($languages,'id','name');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'parentSearch' => $parent_search,
			'groupSearch' => ArrayHelper::map(BlogGroup::getGroups(), 'id', 'name'),
			'statusSearch' => BlogHdbkStatus::getTranslatedStatuses(),
			'items' => $items,
        ]);
    }

    /**
     * Displays a single BlogCategory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
		$translateRow = BlogMapEntityLang::getTranslationCatRow($id,$model->lang->code);
		$usedCodes = BlogMapEntityLang::getUsedCodes($translateRow);
		$languages = HdbkLanguage::getLanguagesSymbols();
        return $this->render('view', [
            'model' => $this->findModel($id),
			'translationBtns' => BlogMapEntityLang::getTranslationBtns($languages, $translateRow, $usedCodes),
			'emptyColTranslationArray' => BlogMapEntityLang::getEmptyColTranslationArray($translateRow),
        ]);
    }


    /**
     * Displays a single BlogCategory model in user's frontend.
     * @param integer $id
     * @return mixed
     */
    public function actionFrontView($id)
    {
		Yii::$app->cache->flush();
		Url::remember();
			
		$category = $this->findModel($id);
		$dataProvider = '';
		$childBlogCategory = '';
		$mainBlogCategory = '';

		if(!empty($category->layout)){
			$layout = '/'.$category->layout['layout_file'];
			$view = $category->layout['view_file'];
			if($category->layout['id'] === 2){
				$blogAliases = BlogCategory::getBlogAliases();
				$mainBlogCategory = [];
				$childBlogCategory = [];
				foreach ($blogAliases as $blogAlias){
					$blogObj = BlogCategory::getCategoryByAlias($blogAlias);
					if(!empty($blogObj)){
						$parentBlogObj = BlogCategory::getCategory($blogObj->parent_category_id);
						foreach ($parentBlogObj as $parentBlog){
							if(!in_array($parentBlogObj[0]->alias, $blogAliases)){
								array_push($mainBlogCategory, $blogAlias);
							}else{
								array_push($childBlogCategory, $blogAlias);
							}
						}
					}
				}
				if(in_array($category->alias, $mainBlogCategory)){
					$filter = array_merge($mainBlogCategory, $childBlogCategory);
				}else{
					$filter = $category->alias;
				}
				$query = BlogPost::findBlogPosts($filter);

				$dataProvider = new ActiveDataProvider([
					'query' => $query,
					'pagination' => [
					'pageSize' => ($category->layout['id'] == 2) ? 2 : 12,
					],
				]);
			}
			if($category->layout['id'] === 6){
				$searchModel = new SearchBlogStakeholder();
				$params = $this->saveFilter('post', Yii::$app->request->queryParams);
                $dataProvider = $searchModel->search($params);
            }
			
			if($category->layout['id'] === 5){
                $filter = Yii::$app->getRequest()->getQueryParam('date');
                $query = BlogEvent::findBlogEvents($filter);
                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [
                        'pageSize' => 4,
                    ],
                ]);
            }
		}else{
			$view = 'front-view';
			$layout = '/main_new';
		}

		$this->layout = $layout;

		if($category->status_id === 11){
			return $this->render($view, [
					'model' => $this->findModel($id),
					'showForm' => !empty(Yii::$app->request->get()['showForm']) ? Yii::$app->request->get()['showForm'] : '',
					'dataProvider' => $dataProvider,
					'childBlogCategory' => $childBlogCategory,
					'mainBlogCategory' => $mainBlogCategory,
				]);
		}else{
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

    /**
     * Creates a new BlogCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BlogCategory();

        $languages = HdbkLanguage::getLanguagesSymbols();
        $items = ArrayHelper::map($languages,'id','name');
        $defaultLang = [Yii::$app->params['settings']['defaultLangObj']['id'] => Yii::$app->params['settings']['defaultLangObj']['name']];
        unset($items[Yii::$app->params['settings']['defaultLangObj']['id']]);
        $items = $defaultLang + $items;

        $parent_category = BlogCategory::getParentName();
        $parent = ArrayHelper::map($parent_category,'id','name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'items' => $items,
                'parent' => $parent,
                'groups' => ArrayHelper::map(BlogGroup::getGroupsCreate(), 'id', 'name'),
				'layouts' => ArrayHelper::map(BlogHdbkLayout::getLayouts(), 'id', 'name'),
            ]);
        }
    }

	/**
     * Creates a new BlogPost model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateTranslation($id, $translate_to)
    {
		$old_model = $this->findModel($id);

        $oldCategory = ArrayHelper::map(BlogCategory::getCategory($old_model->parent_category_id),'id','name');
        $oldGroup = ArrayHelper::map(BlogGroup::getGroup($old_model->group_id),'id','name');

		$oldLayoutObj = BlogHdbkLayout::getLayoutById($old_model['layout_id']);

		if(!empty($oldLayoutObj)){
			$oldLayout = [$oldLayoutObj[0]['id'] => $oldLayoutObj[0]['name']];
		}else{
			$oldLayout = ['' => Yii::t('blog', 'DEFAULT_LAYOUT')];
		}

		$lang = HdbkLanguage::getLanguageByCode($translate_to);
		$newLangCode = [$lang->id => $lang->name];

		$model = new BlogCategory();
		$translateRow = BlogMapEntityLang::getTranslationCatRow($id,$old_model->lang->code);
		$languages = HdbkLanguage::getLanguagesSymbols();

		$parent_category = BlogCategory::getParentName();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create-translation', [
                'model' => $model,
                'items' => ArrayHelper::map($languages,'id','name'),
                'parent' => ArrayHelper::map($parent_category,'id','name'),
                'newLangCode' => $newLangCode,
                'old_model' => $old_model,
                'translateRow' => $translateRow,
                'categoryList' => BlogCategory::getTranslatedCategory($old_model, $translate_to),
                'oldCategory' => $oldCategory,
                'oldGroup' => $oldGroup,
                'groups' => BlogGroup::getTranslatedGroup($old_model, $translate_to),
				'layouts' => ArrayHelper::map(BlogHdbkLayout::getLayouts(), 'id', 'name'),
				'oldLayout' => $oldLayout,
				'flag' => BlogGroup::getTranslationFlag($old_model, $translate_to),
				'catFlag' => BlogCategory::getTranslationCatFlag($old_model, $translate_to),
            ]);
        }
	}

    /**
     * Deletes an existing BlogCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		$posts = BlogPost::find()
				->select(['main_category_id'])
				->where(['main_category_id' => $id])
				->all();

		$children = BlogCategory::findAll(['parent_category_id' => $id]);

		$model = $this->findModel($id);

		if((empty($posts)) && (empty($children)) && ($model->parent_category_id > 0)){
			$model->delete();
			Yii::$app->session->setFlash('success', Yii::t('blog', 'THE_CATEGORY_DELETED_SUCCESSFULLY'));
		}else{
			Yii::$app->session->setFlash('error', Yii::t('blog', 'THE_CATEGORY_YOU_TRY_TO_DELETE_IS_NOT_EMPTY'));
		}

		return $this->redirect(['index']);
    }

	/**
	 * Renders view for limited translator editing
	 *
	 * @return string
	 */
	public function actionEditTranslation($id)
	{
		$model = BlogCategory::findOne($id);
		return $this->render('edit-translation', [
			'model' => $model,
			'transFields' => BlogCategory::TRANS_FIELDS
		]);
	}

    /**
     * Finds the BlogCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BlogCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {

        if (($model = BlogCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	/**
	 *
	 * @param integer $cat
	 * @param integer $lang
	 * @return string
	 */
	public function actionTranslate($cat, $lang)
	{
		$language = HdbkLanguage::findOne($lang);
		$source = BlogCategory::findOne($cat);

		$transFields = BlogCategory::TRANS_FIELDS;

		if (is_object($language)){
			$translationRow = BlogMapEntityLang::findOne([
				$source->lang->code => $source->id,
				'entity_type_id' => 2
			]);

			if (!empty($translationRow->{$language->code})){
				$target = BlogCategory::findOne($translationRow->{$language->code});
			} else {
				$target = $source->getTranslationTemplate($lang);

				$translationRow->{$target->lang->code} = $target->id;
				$translationRow->save();
			}
		}

		return $this->render('translate', [
			'transFields'		=> $transFields,
			'source'	=> $source,
			'target'	=> $target
		]);
	}

	/**
	 * Ajax action
	 *
	 * @return string JSON-object
	 */
	public function actionSaveTranslation()
	{
		$message = Yii::t('blog', 'SOMETHING WENT WORNG...');
		if (!empty(Yii::$app->request->post())){
			$post = Yii::$app->request->post();

			$category = BlogCategory::findOne($post['entity']['id']);
			$category->setAttributes($post['entity']);
			$category->prepareForSaving();
			if (!empty($post['sourceEntId'])){
				$validation = $category->validateContent($post['sourceEntId']);
			} else {
				$validation = $category->validateContent();
			}

			if (($validation['status']) && ($category->save())){
				return json_encode([
					'status' => 'success',
					'message' => Yii::t('blog', 'TRANSLATION SAVED SUCCESSFULLY')
				]);
			} else {
				$message = $validation['message'];
			}

		}
		return json_encode([
			'status' => 'error',
			'message' => $message
		]);
	}

	/**
     * Updates an existing BlogCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		$languages = HdbkLanguage::getLanguagesSymbols();

		$translateRow = BlogMapEntityLang::getTranslationCatRow($id,$model->lang->code);

		$usedCodes = BlogMapEntityLang::getUsedCodes($translateRow);

		$layouts = BlogHdbkLayout::getLayouts();

		$defaultLanguage = HdbkLanguage::getLanguageByCode($model->lang->code);

		$parent_category = BlogCategory::getParentLangName($model->lang_id);

        if ($model->load(Yii::$app->request->post()) && $model->saveUpdatedCaregory()) {
			if(!empty($model->postsearch)) {
				if(!empty($model->shortcodes)) {
					$hook = $model->addHookID($model->postsearch, $model->shortcodes);
				}
				else {
					if($model->getHookFromContent()) {
						$hook = $model->addHookID($model->postsearch, $model->getHookFromContent());
					}
					else {
						$hook = '[displaying hook='.$model->postsearch.']';
					}
				}
				return $this->redirect(['update-post-in-category', 'id' => $model->id, 'hook' => $hook]);
			}	
			return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
				'items' => HdbkLanguage::getOptionLanguages($languages, $defaultLanguage, $usedCodes),
				'parent' => ArrayHelper::map($parent_category,'id','name'),
				'translationBtns' => BlogMapEntityLang::getTranslationBtns($languages, $translateRow, $usedCodes),
				'translateRow' => $translateRow,
				'groups' => ArrayHelper::map(BlogGroup::getGroups(['lang_id' => $model->lang_id]), 'id', 'name'),
				'emptyColTranslationArray' => BlogMapEntityLang::getEmptyColTranslationArray($translateRow),
				'layouts' => ArrayHelper::map(BlogHdbkLayout::getLayouts(), 'id', 'name'),
            ]);
        }
    }
	
	public function actionUpdatePostInCategory($id, $hook = NULL) 
	{
		BlogCategory::updateHook($id, $hook);
		return $this->redirect(['update', 'id' => $id]);
	}
	
	public function actionUpdateStatus($id, $status)
	{
		$cat = BlogCategory::findOne($id);
		$cat->status_id = $status;
		if ($cat->parentSave()){
			return $this->redirect(Yii::$app->request->referrer);
		}
	}
	
	public function beforeAction($action)
	{
		$publicActions = [
			'front-view',
		];

		if (!in_array($action->id, $publicActions)){
			$this->layout = '/../../views/layouts/administrator.php';
		}

		if (!parent::beforeAction($action)) {
			return false;
		}
		
		// other custom code here

		return true; // or false to not run the action
	}
}
