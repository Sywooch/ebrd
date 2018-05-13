<?php

namespace frontend\modules\blog\controllers;

use Yii;
use frontend\modules\blog\models\BlogStakeholder;
use frontend\modules\blog\models\SearchBlogStakeholder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\db\Query;

Yii::$app->params['uploadLogoPath'] = Yii::$app->basePath.'/web/images/stakeholders_logo/';

/**
 * StakeholderController implements the CRUD actions for BlogStakeholder model.
 */
class StakeholderController extends Controller
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
        ];
    }

    /**
     * Lists all BlogStakeholder models.
     * @return mixed
     */
    public function actionIndex()
    {
		$this->layout = '/../../views/layouts/administrator.php';
		$searchModel = new SearchBlogStakeholder();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BlogStakeholder model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$this->layout = '/../../views/layouts/administrator.php';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BlogStakeholder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$this->layout = '/../../views/layouts/administrator.php';
        $model = new BlogStakeholder();

        if ($model->load(Yii::$app->request->post())) {
			$file = UploadedFile::getInstance($model, 'logo');
			$ext = $file->getExtension();
			$securityFilename = Yii::$app->security->generateRandomString().".{$ext}";
			$path = Yii::$app->params['uploadLogoPath'].$securityFilename;
			$file->saveAs($path);
			$model->logo = $securityFilename;
			$model->save();
			return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
	
    /**
     * Updates an existing BlogStakeholder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		$this->layout = '/../../views/layouts/administrator.php';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			if(UploadedFile::getInstance($model, 'logo')) {
				$file = UploadedFile::getInstance($model, 'logo');
				$ext = $file->getExtension();
				$securityFilename = Yii::$app->security->generateRandomString().".{$ext}";
				$path = Yii::$app->params['uploadLogoPath'].$securityFilename;
				$file->saveAs($path);
				$model->logo = $securityFilename;
			}
			if (!$model->logo && $model->oldAttributes['logo']){
				$model->logo = $model->oldAttributes['logo'];
			}
			$model->save();
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BlogStakeholder model.
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

    /**
     * Finds the BlogStakeholder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BlogStakeholder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BlogStakeholder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionFrontView($id)
	{
		$this->layout = '/../../views/layouts/fullscreen.php';
		$model = $this->findModel($id);
		return $this->render('front-view',['model' => $model]);
	}
	
	public function actionLocationList($q = null, $id = null)
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$out = ['results' => ['id' => '', 'text' => '']];
		if (!is_null($q)) {
			$query = new Query;
			$query->select('id, location AS text')
				->from('blog_stakeholder')
				->where(['like', 'location', $q])
				->limit(10);
			$command = $query->createCommand();
			$data = $command->queryAll();
			$out['results'] = array_values($data);
		}
		elseif ($id > 0) {
			$out['results'] = ['id' => $id, 'text' => Stakeholder::find($id)->location];
		}
		return $out;
	}
	
}
