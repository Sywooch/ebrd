<?php

namespace frontend\modules\user\controllers;

use Yii;
use frontend\modules\user\models\Reports;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use common\models\Team;
use yii\filters\AccessControl;
use frontend\modules\user\models\MapTeamUserReport;
use frontend\modules\user\models\ReportsSearch;
use frontend\components\traits\FilterTrait;
use common\models\CabinetHdbkReportType;


/**
 * ReportsController implements the CRUD actions for Reports model.
 */
class ReportsController extends Controller
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
            ],'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions' => ['index','view', 'update', 'create', 'delete', 'resend-mails'],
						'roles' => ['manageUsers'],
					],
				],
			],
        ];
    }

    /**
     * Lists all Reports models.
     * @return mixed
     */
    public function actionIndex()
    {
		$searchModel = new ReportsSearch();
		$params = $this->saveFilter('reports', Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
			'searchModel'  => $searchModel,
			'teamSerach'   => Team::getTeams(),
			'typeSearch'   => CabinetHdbkReportType::getTypes(),
        ]);
    }

    /**
     * Displays a single Reports model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
		
        return $this->render('view', [
            'model' => $model,
        ]);
    }
	
	
	public function actionResendMails($id)
    {
		$model = Reports::findOne($id);

		if(!empty($model->reports)){
			$userIds = [];
			$teamIds = [];
			foreach ($model->reports as $report){
				if(!empty($report->user_id)){
					$userIds[] = $report->user_id;
				}
				if(!empty($report->team_id)){
					$teamIds[] = $report->team_id;
				}
			}
			if(!empty($userIds) || !empty($teamIds)){
				Reports::sendReportEmail($userIds,$teamIds,$model,$resend = true);
			}
		}

		Yii::$app->session->setFlash('success', Yii::t('blog', 'MAILS_RESENDED'));
        return $this->redirect(['index']);
    }

    /**
     * Creates a new Reports model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Reports();
		
		$users = User::getUsersEmails();
		
		$teams = Team::getTeams();

		$usedTeams = MapTeamUserReport::getUsedTeams($model->id);
		
		$usedUsers = MapTeamUserReport::getUsedUsers($model->id);
		
		$types = CabinetHdbkReportType::getTypes();

        if ($model->load(Yii::$app->request->post()) && $model->updateSettings()) {
			
			$userId = '';
			$teamId = '';
			if(!empty(Yii::$app->request->post()['user_id'])){
				$userId = Yii::$app->request->post()['user_id'];
			}
			if(!empty(Yii::$app->request->post()['team_id'])){
				$teamId = Yii::$app->request->post()['team_id'];
			}
			MapTeamUserReport::setReportsMap($model->id, $userId, $teamId);
			
			if(!empty($userId) || !empty($teamId)){
				Reports::sendReportEmail($userId,$teamId,$model);
			}
			
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
				'users' => $users,
				'teams' => $teams,
				'types' => $types,
				'usedTeams' => $usedTeams,
				'usedUsers' => $usedUsers,
            ]);
        }
    }
	
	
    /**
     * Updates an existing Reports model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {	
        $model = $this->findModel($id);
		
		$users = User::getUsersEmails();
		
		$teams = Team::getTeams();
		
		$usedTeams = MapTeamUserReport::getUsedTeams($model->id);
		
		$usedUsers = MapTeamUserReport::getUsedUsers($model->id);
		
		$types = CabinetHdbkReportType::getTypes();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			
			$userId = '';
			$teamId = '';
			if(!empty(Yii::$app->request->post()['user_id'])){
				$userId = array_map('intval', Yii::$app->request->post()['user_id']);
			}
			if(!empty(Yii::$app->request->post()['team_id'])){
				$teamId = array_map('intval', Yii::$app->request->post()['team_id']);
			}
			MapTeamUserReport::updateReportsMap($model->id, $userId, $teamId);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
				'users' => $users,
				'teams' => $teams,
				'types' => $types,
				'usedTeams' => $usedTeams,
				'usedUsers'=> $usedUsers,
            ]);
        }
    }

    /**
     * Deletes an existing Reports model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		if($this->findModel($id)->delete()){
			MapTeamUserReport::deleteChain($id);
		}
        return $this->redirect(['index']);
    }

    /**
     * Finds the Reports model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reports the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reports::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
	
}
