<?php

namespace frontend\modules\blog\controllers;

use frontend\modules\blog\models\BlogHdbkStatus;
use frontend\modules\blog\models\BlogPost;
use frontend\modules\blog\models\BlogPostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\HdbkLanguage;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use frontend\modules\blog\models\BlogCategory;
use frontend\modules\blog\models\BlogMapEntityLang;
use Yii;
use frontend\components\traits\FilterTrait;
use common\models\User;

/**
 * PostController implements the CRUD actions for BlogPost model.
 */
class PostController extends Controller
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
							'update',
							'view'
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
						'actions' => ['index', 'reset-filter'],
						'roles' => ['editItem', 'translate', 'publishItem'],
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
						'actions' => ['update-status'],
						'roles' => ['publishItem']
					],
				],
			],
        ];
    }

    /**
     * Lists all BlogPost models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlogPostSearch();
		$params = $this->saveFilter('post', Yii::$app->request->queryParams);
		$dataProvider = $searchModel->search($params);

		$parent_search = BlogPost::getParentSearch();
		
		$languages = HdbkLanguage::getLanguagesSymbols();
		$items = ArrayHelper::map($languages,'id','name');
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'parent_search' => $parent_search,
			'statusSearch' => BlogHdbkStatus::getTranslatedStatuses(),
			'items' => $items,
        ]);
    }

    /**
     * Displays a single BlogPost model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
		$languages = HdbkLanguage::getLanguagesSymbols();
		$translateRow = BlogMapEntityLang::getTranslationRow($id,$model->lang->code);
		$usedCodes = BlogMapEntityLang::getUsedCodes($translateRow);
        return $this->render('view', [
            'model' => $this->findModel($id),
			'translationBtns' => BlogMapEntityLang::getTranslationBtns($languages, $translateRow, $usedCodes),
			'emptyColTranslationArray' => BlogMapEntityLang::getEmptyColTranslationArray($translateRow),
        ]);
    }
	
	/**
	 * Renders view for limited translator editing
	 * 
	 * @return string
	 */
	public function actionEditTranslation($id)
	{
		$model = BlogPost::findOne($id);
		return $this->render('edit-translation', [
			'model' => $model,
			'transFields' => BlogPost::TRANS_FIELDS
		]);
	}
	
    /**
     * Displays a single BlogPost model in user's frontend.
     * @param integer $id
     * @return mixed
     */
    public function actionFrontView($id)
    {
		Yii::$app->cache->flush();

		$this->layout = '/../../views/layouts/fullscreen.php';
		
		$post = $this->findModel($id);
		
		$author = User::getUserById($post->author_id);

		$blogAliases = BlogCategory::getBlogAliases();
		$childBlogCategory = [];
		foreach ($blogAliases as $blogAlias){
			$blogObj = BlogCategory::getCategoryByAlias($blogAlias);
			if(!empty($blogObj)){
				$parentBlogObj = BlogCategory::getCategory($blogObj->parent_category_id);
				foreach ($parentBlogObj as $parentBlog){
					if(in_array($parentBlogObj[0]->alias, $blogAliases)){
						array_push($childBlogCategory, $blogAlias);
					}
				}
			}
		}
		if(Yii::$app->user->getIsGuest() && $post->category->alias === 'standart-blocks'){
			throw new \yii\web\HttpException(404);
		}else{
			return $this->render('front-view', [
				'model' => $post,
				'author' => $author,
				'childBlogCategory' => $childBlogCategory,
			]);
		}
		
    }
    /**
     * Creates a new BlogPost model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BlogPost();

        $languages = HdbkLanguage::getLanguagesSymbols();
        $items = ArrayHelper::map($languages,'id','name');
        $defaultLang = [Yii::$app->params['settings']['defaultLangObj']['id'] => Yii::$app->params['settings']['defaultLangObj']['name']];
        unset($items[Yii::$app->params['settings']['defaultLangObj']['id']]);
        $items = $defaultLang + $items;
		$authors = User::getActiveUsersEmails();

        $parent_category = BlogCategory::getParentName();
        $parent = ArrayHelper::map($parent_category,'id','name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'items' => $items,
                'parent' => $parent,
				'authors' => $authors,
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
		
		$lang = HdbkLanguage::getLanguageByCode($translate_to);
		$newLangCode = [$lang->id => $lang->name];
		
		$translatedParentCategories = BlogCategory::getListCategoryByCode($lang->id);
		
		$authors = User::getActiveUsersEmails();
		
		$categoryList = [];
		foreach ($translatedParentCategories as $translatedParentCategory){
				$categoryList[$translatedParentCategory->id] = $translatedParentCategory->name;
		}
		$model = new BlogPost();
		$translateRow = BlogMapEntityLang::getTranslationRow($id,$old_model->lang->code);
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
				'categoryList' => BlogPost::getTranslatedCategory($old_model, $translate_to),
				'catFlag' => BlogPost::getTranslationCatFlag($old_model, $translate_to),
				'authors' => $authors,
				
            ]);
        }
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
			$request = Yii::$app->request->post();
			
			$post = BlogPost::findOne($request['entity']['id']);
			$post->setAttributes($request['entity']);
			$post->prepareForSaving();
			if (!empty($post['sourceEntId'])){
				$validation = $post->validateContent($request['sourceEntId']);
			} else {
				$validation = $post->validateContent();
			}
			
			if (($validation['status']) && ($post->save())){
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
	 * 
	 * @param integer $post
	 * @param integer $lang
	 * @return string
	 */
	public function actionTranslate($post, $lang)
	{
		$language = HdbkLanguage::findOne($lang);
		$source = BlogPost::findOne($post);
		
		$transFields = BlogPost::TRANS_FIELDS;

		if (is_object($language)){
			$translationRow = BlogMapEntityLang::findOne([
				$source->lang->code => $source->id,
				'entity_type_id' => 1
			]);
			
			if (!empty($translationRow->{$language->code})){
				$target = BlogPost::findOne($translationRow->{$language->code});
			} else {
				$target = $source->getTranslationTemplate($lang);
				
				$translationRow->{$target->lang->code} = $target->id;
				$translationRow->save();
			}
		}

		return $this->render('translate-post', [
			'transFields'		=> $transFields,
			'source'	=> $source,
			'target'	=> $target
		]);
	}
	
	/**
     * Updates an existing BlogPost model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		

		$model = $this->findModel($id);
	
		$languages = HdbkLanguage::getLanguagesSymbols();
		
		$translateRow = BlogMapEntityLang::getTranslationRow($id,$model->lang->code);

		$usedCodes = BlogMapEntityLang::getUsedCodes($translateRow);
		
		$defaultLanguage = HdbkLanguage::getLanguageByCode($model->lang->code);
		
		$parent_category = BlogCategory::getParentLangName($model->lang_id);

		$authors = User::getActiveUsersEmails();
		
		if ($model->load(Yii::$app->request->post()) && $model->saveUpdatedPost()) {
			return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
				'items' => HdbkLanguage::getOptionLanguages($languages, $defaultLanguage, $usedCodes),
				'parent' => ArrayHelper::map($parent_category,'id','name'),
				'translationBtns' => BlogMapEntityLang::getTranslationBtns($languages, $translateRow, $usedCodes),
				'translateRow' => $translateRow,
				'emptyColTranslationArray' => BlogMapEntityLang::getEmptyColTranslationArray($translateRow),
				'authors' => $authors,
            ]);
        }
    }
	
	public function actionUpdateStatus($id, $status)
	{
		$post = BlogPost::findOne($id);
		$post->status_id = $status;
		if ($post->parentSave()){
			return $this->redirect(Yii::$app->request->referrer);
		}
	}
	
    /**
     * Deletes an existing BlogPost model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BlogPost model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BlogPost the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BlogPost::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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
