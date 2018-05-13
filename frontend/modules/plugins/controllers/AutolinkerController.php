<?php

namespace frontend\modules\plugins\controllers;

use Yii;
use frontend\modules\plugins\models\PluginsAutolinker;
use frontend\modules\plugins\models\PluginsAutolinkerSearch;
use frontend\modules\plugins\models\PluginsAutolinkerGlobalSettings;
use frontend\modules\plugins\models\PluginsAutolinkerGlobalSettingsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * AutolinkerController implements the CRUD actions for PluginsAutolinker model.
 */
class AutolinkerController extends Controller
{
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
                                            'index',
                                            'view',
                                            'settings',
                                            'create',
                                            'update',
                                            'delete',
                                            'settings-update',
                                            'status-update',
                                            'global-status-update',
                                    ],
                                    'roles' => ['manageUsers'],
                            ],
                    ],
            ],
        ];
    }

	public function beforeAction($action)
	{
		$publicActions = [
			
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
	
    /**
     * Lists all PluginsAutolinker models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PluginsAutolinkerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'languageSearch' => ArrayHelper::map(Yii::$app->params['settings']['activeLangsObjs'], 'code', 'name'),
        ]);
    }

    /**
     * Displays a single PluginsAutolinker model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

	public function actionSettings()
	{
		
		$searchModel = new PluginsAutolinkerGlobalSettingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('settings', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
		
	}

	/**
     * Updates an existing PluginsAutolinker model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
	public function actionSetup($id)
    {
        $model = $this->findSettingsModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['settings', 'id' => $model->id]);
        } else {
            return $this->render('setup', [
                'model' => $model,
            ]);
        }
    }
	
	/**
     * Creates a new PluginsAutolinker model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PluginsAutolinker();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PluginsAutolinker model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PluginsAutolinker model.
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
     * Update status of single auto-link
     * @param $id
     * @param $status
     * @return \yii\web\Response
     */
    public function actionStatusUpdate($id, $status)
    {
        $model = PluginsAutolinker::findOne($id);
        $model->status = $status;
        $model->save();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Update status of auto-linker
     * @param $status
     * @return \yii\web\Response
     */
    public function actionGlobalStatusUpdate($status)
    {
        $model = PluginsAutolinkerGlobalSettings::findOne(['setting_name' => 'status']);
        $model->settings_value = $status;
        $model->save();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the PluginsAutolinker model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PluginsAutolinker the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PluginsAutolinker::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	protected function findSettingsModel($id)
    {
        if (($model = PluginsAutolinkerGlobalSettings::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
}
