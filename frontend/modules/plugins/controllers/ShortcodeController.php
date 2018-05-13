<?php

namespace frontend\modules\plugins\controllers;

use frontend\modules\plugins\models\search\ShortcodeSearch;
use Yii;
use frontend\modules\plugins\models\Shortcode;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\plugins\models\ShortcodeInfo;
use yii\filters\AccessControl;

/**
 * Class ShortcodeController
 * @package frontend\modules\plugins\controllers
 */
class ShortcodeController extends Controller
{
	//public $option = [];
	
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
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
                                            'update',
                                            'delete',
                                            'add',
                                            'shortcode-info-update',
                                            'shortcode-info-delete',
                                            
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
     * Lists all models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShortcodeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
    /**
     * Displays a single Shortcode model.
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
     * Creates a new Shortcode model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Shortcode();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect('index');
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Updates an existing Shortcode model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Shortcode model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionAdd() {
		
		$model = new \frontend\modules\plugins\models\ShortcodeInfo();
		
		 if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $model = new \frontend\modules\plugins\models\ShortcodeInfo();
        }
		$searchModel = new \frontend\modules\plugins\models\ShortcodeInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
 
		return $this->render('add', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
	}

	public function actionShortcodeInfoUpdate($id)
    {
        $model = $this->findShortcodeInfoModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('add');
        } else {
            return $this->render('shortcode-info-update', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionShortcodeInfoDelete($id)
    {
        $this->findShortcodeInfoModel($id)->delete();

        return $this->redirect(['add']);
    }
		/**
     * Finds the Shortcode model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shortcode the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Shortcode::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	protected function findShortcodeInfoModel($id)
    {
		$model = new ShortcodeInfo();
        if (($model = ShortcodeInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
