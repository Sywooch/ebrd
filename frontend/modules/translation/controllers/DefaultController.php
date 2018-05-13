<?php

namespace frontend\modules\translation\controllers;

use frontend\models\HdbkLanguage;
use frontend\modules\translation\models\CreateTranslation;
use frontend\modules\translation\models\SaveTranslation;
use frontend\modules\translation\models\SearchSourceMessage;
use frontend\modules\translation\models\SourceMessage;
use frontend\modules\translation\models\Message;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use Yii;
use frontend\components\traits\FilterTrait;

/**
 * Default controller for the `translations` module
 */
class DefaultController extends Controller
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
						'actions' => [
							'create',
							'delete',
							'get-translations',
							'index',
							'save',
							'reset-filter',
							'update',
							'view',
						],
						'roles' => ['editItem', 'translate'],
					],
				],
			],
        ];
    }

	/**
	 * Create new translation
	 */
	public function actionCreate()
	{
		$model = new CreateTranslation();
		if (Yii::$app->request->isPost){
			$request = Yii::$app->request->post();
			if ($model->saveTranslations($request)){
				$this->redirect(['/translation/default/index', 'message' => $model->message]);
			}
		}
		return $this->render('create', ['model' => $model]);
	}
	
	public function actionDelete($id)
	{
		$sourceMessage = SourceMessage::findOne($id)->delete();
		$messages = Message::find()
			->where(['id' => $id])
			->all();
		
		foreach ($messages as $message){
			$message->delete();
		}
		
		return $this->redirect(Yii::$app->request->referrer);
	}

		/**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
		$searchModel = new SearchSourceMessage();
		$params = $this->saveFilter('translation', Yii::$app->request->queryParams);
		$dataProvider = $searchModel->search($params);
		$languages = Yii::$app->params['settings']['activeLangsObjs'];

        return $this->render('index',[
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
			'languages' => $languages,
		]);
    }
    
    public function actionView($id)
    {
        $messageModel = new Message();
        $messages = $messageModel->find()
                            ->where(['id' => $id])
                            ->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'messages' => $messages
        ]);
    }

    protected function findModel($id)
    {
        if (($model = SourceMessage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * Updates an existing SourceMessage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $translationModel = new CreateTranslation();
        $model = $this->findModel($id);
        $request = Yii::$app->request->post();
        $messageModel = new Message();
        $messages = $messageModel->find()
                            ->where(['id' => $id])
                            ->all();
        $messageModel->fillTranslation($messages, $translationModel->translations);

        if ($model->load($request) && $model->save()) {
            foreach ($request['messageTranslations'] as $language => $message) {
                if ($message == "") continue;
                $args = [
                        'id' => $id,
                        'language' => $language,
                        'translation' => $message   
                ];
                Message::saveMessageTranslation($args);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        return $this->render('update', [
            'model' => $model,
            'translationModel' => $translationModel
        ]);
    }
    
    /**
     * Saves translation string
     * @return string
     */
	public function actionSave()
	{
		$model = new SaveTranslation();
		$model->setAttributes(Yii::$app->request->post());
		
		if ((empty($model->id)) && (!empty($model->message))){
			$model->setMessageId();
		}
		
		if (($model->validate()) && ($model->save())){
			return Html::encode($model->translation);
		}
		
		return $model->validate();
	}
	
	public function actionGetTranslations()
	{
		if (Yii::$app->request->isPost){
			$request = Yii::$app->request->post();
			if (!empty($request['id'])){
				$model = SourceMessage::findOne(['id' => $request['id']]);
			} elseif ((!empty ($request['category'])) && (!empty ($request['message']))) {
				$model = SourceMessage::findOne([
					'category' => $request['category'],
					'message' => $request['message'],
				]);
			}
		}
		return $this->renderPartial('_message-translations', [
			'model' => $model,
			'languages' => HdbkLanguage::getLanguagesSymbols()	
		]);
	}
	
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
