<?php

namespace frontend\modules\blog\controllers;

use Yii;
use frontend\modules\blog\models\BlogGroup;
use frontend\modules\blog\models\BlogGroupSearch;
use frontend\modules\blog\models\BlogHdbkStatus;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use frontend\models\HdbkLanguage;
use frontend\modules\blog\models\BlogMapEntityLang;
use frontend\components\traits\FilterTrait;

/**
 * GroupController implements the CRUD actions for BlogGroup model.
 */
class GroupController extends Controller
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
     * Lists all BlogGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlogGroupSearch();
		$params = $this->saveFilter('group', Yii::$app->request->queryParams);
		$dataProvider = $searchModel->search($params);
		
		$languages = HdbkLanguage::getLanguagesSymbols();
		$items = ArrayHelper::map($languages,'id','name');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'items' => $items,
			'statusSearch' => BlogHdbkStatus::getTranslatedStatuses(),
			'languageSearch' => ArrayHelper::map(Yii::$app->params['settings']['activeLangsObjs'], 'id', 'name'),
        ]);
    }

    /**
     * Displays a single BlogGroup model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
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
		
		$model = new BlogGroup();
		$translateRow = BlogMapEntityLang::getTranslationGroupRow($id,$old_model->lang->code);
		$languages = HdbkLanguage::getLanguagesSymbols();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create-translation', [
                'model' => $model,
				'items' => ArrayHelper::map($languages,'id','name'),
				'newLangCode' => $newLangCode,
				'old_model' => $old_model,
				'translateRow' => $translateRow,
            ]);
        }
	}
	
    /**
     * Creates a new BlogGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BlogGroup();

		$items = ArrayHelper::map(HdbkLanguage::getLanguagesSymbols(),'id','name');

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
			'items' => $items
        ]);
    }

	/**
	 * 
	 * @param integer $id
	 * @param integer $lang
	 * @return string
	 */
	public function actionTranslate($id, $lang)
	{
		$language = HdbkLanguage::findOne($lang);
		$source = BlogGroup::findOne($id);
		
		$transFields = BlogGroup::TRANS_FIELDS;

		if (is_object($language)){
			$translationRow = BlogMapEntityLang::findOne([
				$source->lang->code => $source->id,
				'entity_type_id' => 3
			]);
			
			if (!empty($translationRow->{$language->code})){
				$target = BlogGroup::findOne($translationRow->{$language->code});
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
     * Updates an existing BlogGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
	
		$languages = HdbkLanguage::getLanguagesSymbols();
		
		$translateRow = BlogMapEntityLang::getTranslationGroupRow($id,$model->lang->code);

		$usedCodes = BlogMapEntityLang::getUsedCodes($translateRow);
//		echo '<pre>';
//		var_dump($translateRow);
//		echo '</pre>';
//		die();

		$defaultLanguage = HdbkLanguage::getLanguageByCode($model->lang->code);
		
		
        if ($model->load(Yii::$app->request->post()) && $model->saveUpdatedGroup()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
			'items' => HdbkLanguage::getOptionLanguages($languages, $defaultLanguage, $usedCodes),
			'translationBtns' => BlogMapEntityLang::getTranslationBtns($languages, $translateRow, $usedCodes),
			'translateRow' => $translateRow,
			'emptyColTranslationArray' => BlogMapEntityLang::getEmptyColTranslationArray($translateRow),
        ]);
    }
	
	public function actionUpdateStatus($id, $status)
	{
		$post = BlogGroup::findOne($id);
		$post->status_id = $status;
		if ($post->parentSave()){
			return $this->redirect(Yii::$app->request->referrer);
		}
	}
	
    /**
     * Deletes an existing BlogGroup model.
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
	 * Renders view for limited translator editing
	 * 
	 * @return string
	 */
	public function actionEditTranslation($id)
	{
		$model = BlogGroup::findOne($id);
		return $this->render('edit-translation', [
			'model' => $model,
			'transFields' => BlogGroup::TRANS_FIELDS
		]);
	}
	
	/**
	 * Ajax action
	 * 
	 * @return string JSON-object
	 */
	public function actionSaveTranslation()
	{
		$message = Yii::t('blog', 'SOMETHING WENT WRONG...');
		if (!empty(Yii::$app->request->post())){
			$request = Yii::$app->request->post();
			
			$group = BlogGroup::findOne($request['entity']['id']);
			$group->setAttributes($request['entity']);
			$group->prepareForSaving();
			
			if ($group->parentSave()){
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
     * Finds the BlogGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BlogGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BlogGroup::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
	
//	public function actionFrontView($id)
//    {
//        return $this->render('front-view', [
//            'model' => $this->findModel($id),
//        ]);
//    }
//	
//	protected function findUrlModel($url)
//    {
//        if (($modelUrl = BlogGroup::findOne($url)) !== null) {
//            return $modelUrl;
//        }
//
//        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
//    }
//	
	public function beforeAction($action)
	{
		$this->layout = '/../../views/layouts/administrator.php';

		if (!parent::beforeAction($action)) {
			return false;
		}

		// other custom code here

		return true; // or false to not run the action
	}
}
