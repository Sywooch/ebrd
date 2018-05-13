<?php

namespace frontend\modules\blog\controllers;

use Yii;
use frontend\modules\blog\models\BlogContactOffice;
use frontend\modules\blog\models\BlogContactOfficeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\modules\blog\models\SeparatePhonesNumbers;
use frontend\modules\blog\models\SeparatePhonesNumbersSearch;

/**
 * ContactsController implements the CRUD actions for BlogContactOffice model.
 */
class ContactsController extends Controller
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
							'phones',
							'_phones_form',
							'phones-update',
							'phones-delete',
							'front-view'
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
						'actions' => [
							'delete',
							'phones-delete',
						],
						'roles' => ['deleteItem'],
					],
					[
						'allow' => true,
						'actions' => ['translate', 'save-translation','edit-translation'],
						'roles' => ['translate'],
					],
					[
						'allow' => true,
						'actions' => ['index'],
						'roles' => ['translate', 'publishItem', 'editItem'],
					],
					[
						'allow' => true,
						'actions' => ['update-status'],
						'roles' => ['publishItem']
					],
					[
						'allow' => true,
						'actions' => ['phones'],
						'roles' => ['translate', 'publishItem', 'editItem'],
					],
				],
			],
        ];
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
    /**
     * Lists all BlogContactOffice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlogContactOfficeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BlogContactOffice model.
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
     * Displays a single BlogContactOffice model in user's frontend.
     * @param integer $id
     * @return mixed
     */
    public function actionFrontView()
    {
        return $this->render('front-view');      
    }
    /**
     * Creates a new BlogContactOffice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BlogContactOffice();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BlogContactOffice model.
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
     * Deletes an existing BlogContactOffice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionPhones()
    {
		$model = new SeparatePhonesNumbers();
		
		if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $model = new SeparatePhonesNumbers();
        }
		$searchModel = new SeparatePhonesNumbersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
		return $this->render('phones', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
	
	public function actionPhonesUpdate($id)
    {
        $model = $this->findPhonesModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('phones');
        } else {
            return $this->render('phones-update', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionPhonesDelete($id)
    {
        $this->findPhonesModel($id)->delete();

        return $this->redirect(['phones']);
    }
		/**
     * Finds the Shortcode model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shortcode the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
   	
	protected function findPhonesModel($id)
    {
		$model = new SeparatePhonesNumbers();
        if (($model = SeparatePhonesNumbers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * Finds the BlogContactOffice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BlogContactOffice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BlogContactOffice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
