<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use frontend\modules\catalog\models\CatalogIndustry;
use frontend\modules\catalog\models\CatalogMethodAnalysisData;
use frontend\modules\catalog\models\CatalogMethodCollectingData;
use frontend\modules\plugins\models\PluginsCountryLocationCode; 
use frontend\modules\catalog\models\CatalogDocType;
use frontend\modules\catalog\models\CatalogProjectType;
use frontend\modules\catalog\models\CatalogDocument;
use frontend\modules\catalog\models\CatalogDocumentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use \frontend\modules\catalog\models\CatalogDocumentToProject;
use \frontend\modules\catalog\models\CatalogDocumentToMethodAnalisis;
use \frontend\modules\catalog\models\CatalogDocumentToMethodCollecting;

Yii::$app->params['uploadCatalogPath'] = Yii::$app->basePath.'/../catalog_documents/';


/**
 * DocumentController implements the CRUD actions for CatalogDocument model.
 */
class CatalogController extends Controller
{
    /**
     * @inheritdoc
     */
	public $enableCsrfValidation = false;
	
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
						'actions' => [
							'view', 
							'create',
							'create-element',
							'download',
//							'delete-element',
//							'update-element', 
							'index',
							'index-elements',
							'delete',
							'update',
							'ajax-project-type-render',
							'ajax-method-analisis-render',
							'ajax-method-collecting-render',
							'ajax-fileinput-render',
							'ajax-isperiod'
							],
						'roles' => ['editItem'],
					],
				],
			]
        ];
    }

    /**
     * Lists all CatalogDocument models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatalogDocumentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	/**
     * Lists all CatalogDocument's elements models.
     * @return mixed
     */
    public function actionIndexElements()
    {	
		$dataProviders = [
			'CatalogIndustry' => 
				[
					'data' => new ActiveDataProvider(
							[
								'query' => CatalogIndustry::find(),
								'pagination' => [ 'pageSize' => 5 ]
							]
					),
					'columns' => ['id', 'name']
				],
			'CatalogMethodAnalysisData' =>
				[
					'data' => new ActiveDataProvider(
							[
								'query' => CatalogMethodAnalysisData::find(),
								'pagination' => [ 'pageSize' => 5 ]
							]
					), 
					'columns' => ['id', 'name']
				],
			'CatalogMethodCollectingData' =>
				[
					'data' => new ActiveDataProvider(
							[
								'query' => CatalogMethodCollectingData::find(),
								'pagination' => [ 'pageSize' => 5 ]
							]
					), 
					'columns' => ['id', 'name']
				],
			'CatalogProjectType' =>
				[
					'data' => new ActiveDataProvider(
							[
								'query' => CatalogProjectType::find(),
								'pagination' => [ 'pageSize' => 5 ]
							]
					), 
					'columns' => ['id', 'name']
				],
			'CatalogDocType' =>
				[
					'data' => new ActiveDataProvider(
							[
								'query' => CatalogDocType::find(),
								'pagination' => [ 'pageSize' => 5 ]
							]
					), 
					'columns' => [
						'id', 
						'name', 
						[
							'attribute' => 'period',
							'content' => function ($model) {
								return ($model->period)?
										Yii::t('catalog', 'DOCUMENT_НAS_PERIOD'):
										Yii::t('catalog', 'DOCUMENT_HAS_NO_PERIOD');
							}
						]
					]
				],			
		];
		return $this->render('indexElements', [
               'dataProviders' => $dataProviders,
        ]);
    }

    /**
     * Displays a single CatalogDocument model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CatalogDocument model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
		$post = Yii::$app->request->post();
		$model = new CatalogDocument();
		
		if (!empty($post) && !empty($_FILES)) {
			$fileindex = 1;
			foreach ($post['CatalogDocument']['file_collection'] as $file_collection){
				if($fileindex > 1) {
					$model = new CatalogDocument();
				}
				if(!empty(UploadedFile::getInstanceByName('file-'.$fileindex))){
					$file = UploadedFile::getInstanceByName('file-'.$fileindex);
					$model->filename = $file->name;
					$ext = $file->getExtension();
					$securityFilename = Yii::$app->security->generateRandomString().".{$ext}";
					$path = Yii::$app->params['uploadCatalogPath'].$securityFilename;
					$file->saveAs($path);
					$model->file = $securityFilename;
					$model->doc_type_id = $file_collection['doc_type_id'];
					if(!empty($file_collection['period_start_date']) && !empty($file_collection['period_end_date'])){
						$model->period_start_date = date('Y-m-d', strtotime($file_collection['period_start_date']));
						$model->period_end_date = date('Y-m-d', strtotime($file_collection['period_end_date']));
					}
					$model->contract_number = $post['CatalogDocument']['contract_number'];
					$date = date('Y-m-d', strtotime($post['CatalogDocument']['contract_date']));
					$model->contract_date = $date;
					$model->client_id = $post['CatalogDocument']['client_id'];
					$model->country_id = $post['CatalogDocument']['country_id'];
					$model->industry_id = $post['CatalogDocument']['industry_id'];
					if(!empty($post['CatalogDocument']['document_description'])){
						$model->document_description = $post['CatalogDocument']['document_description'];
					}
					$model->save();
					foreach($post['CatalogDocument']['method_analisis'] as $method_analisis){
						if(!empty($method_analisis)){
							$analisis = new CatalogDocumentToMethodAnalisis();
							$analisis->document_id = $model->id;
							$analisis->method_analisis_id = $method_analisis;
							$analisis->save();
						}
					}
					foreach($post['CatalogDocument']['project_type'] as $project_type){
						if(!empty($project_type)){
							$project = new CatalogDocumentToProject();
							$project->document_id = $model->id;
							$project->project_type_id = $project_type;
							$project->save();
						}
					}
					foreach($post['CatalogDocument']['method_collecting'] as $method_collecting){
						if(!empty($method_collecting)){
							$collecting = new CatalogDocumentToMethodCollecting();
							$collecting->document_id = $model->id;
							$collecting->method_collecting_id = $method_collecting;
							$collecting->save();
						}
					}
				}
				$fileindex++;
			}
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
	
	
	 /**
     * Creates a new Catalog Element like (Industry, MethodAnalysisData,
	 * CatalogMethodCollectingData, CatalogProjectType, CatalogDocType) model .
     * If creation is successful, the browser will be redirected to the 'indexElement' page.
     * @return mixed
     */
	public function actionCreateElement($class)
    {
		$classFullName = 'frontend\\modules\\catalog\\models\\' . $class;
		$model = new $classFullName();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index-elements', 'id' => $model->id]);
        }

        return $this->render('createElement', [
            'model' => $model,
			'class' => $class
        ]);
    }

    /**
     * Updates an existing CatalogDocument model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

	/**
     * Updates an existing CatalogDocument model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateElement($id, $class)
    {
	
		$classFullName = 'frontend\\modules\\catalog\\models\\' . $class;
		$model = $classFullName::findOne(['id'=>$id]);	
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index-elements']);
        }
        return $this->render('updateElement', [
            'model' => $model,
			'class' => $class,
        ]);
    }

    /**
     * Deletes an existing CatalogDocument model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionAjaxProjectTypeRender()
	{
		$request = Yii::$app->request->post();
		return $this->renderAjax('_project-type-render',[
			'project_type_id' => $request['project_type_id'],
			'ptindex' => $request['ptindex']
			]);
	}
	
	public function actionAjaxMethodAnalisisRender()
	{
		$request = Yii::$app->request->post();
		return $this->renderAjax('_method-analisis-render',[
			'method_analisis_id' => $request['method_analisis_id'],
			'maindex' => $request['maindex']
			]);
	}
	
	public function  actionAjaxMethodCollectingRender()
	{
		$request = Yii::$app->request->post();
		return $this->renderAjax('_method-collecting-render',[
			'method_collecting_id' => $request['method_collecting_id'],
			'mcindex' => $request['mcindex']
			]);
	}
	
	public function actionAjaxFileinputRender()
	{
		$request = Yii::$app->request->post();
		return $this->renderAjax('_fileinput-render',[
			'fileinputIndex' => $request['fileinputIndex'],
			'doctypeIndex' => $request['doctypeIndex'],
			'psdIndex' => $request['psdIndex'],
			'pedIndex' => $request['pedIndex'],
			'periodIndex' => $request['periodIndex']
			]);
	}
	
	public function actionAjaxIsperiod()
	{
		$doctypeIndex = Yii::$app->request->post('doctypeIndex');
		$period = CatalogDocType::findOne($doctypeIndex);
		return $this->asJson($period->period);
	}

	/**


	/**
     * Deletes an existing CatalogDocument Element.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteElement($id, $class)
    {
		$class = 'frontend\\modules\\catalog\\models\\' . $class;
		$class::findOne(['id'=>$id])->delete();
        return $this->redirect(['index-elements']);
    }
	
    /**

     * Finds the CatalogDocument model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CatalogDocument the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CatalogDocument::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('catalog', 'The requested page does not exist.'));
    }
	
	public function actionDownload($file, $name)
    {
		$catalogDirPath = Yii::$app->basePath.'/../catalog_documents/';
		$downloadFile = $catalogDirPath.$file;
		if(file_exists($downloadFile)){
            return Yii::$app->response->sendFile($downloadFile, $name); 
        }else{
            throw new NotFoundHttpException('FILE_DOES_NOT_EXIST');
        }	
    }
}
