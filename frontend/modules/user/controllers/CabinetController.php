<?php

namespace frontend\modules\user\controllers;

use frontend\modules\blog\models\BlogEvent;
use frontend\modules\blog\models\BlogEventSearch;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\modules\user\models\Reports;
use frontend\modules\user\models\MapTeamUserReport;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models\UserToken;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class CabinetController extends Controller
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
            ],'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions' => [
						    'index',
                            'reports',
                            'transfer-pricing',
                            'blogs',
                            'contacts',
                            'events',
                        ],
						'roles' => ['@'],
					],
					[
						'allow' => true,
						'actions' => ['my-marketing-strategy'],
						'roles' => ['@','?'],
					],
					[
						'allow' => true,
						'actions' => ['view'],
						'roles' => ['@'],
					],
					[
						'allow' => true,
						'actions' => ['industrial','nps','geomarketing'],
						'roles' => ['@'],
					],
					[
						'allow' => true,
						'actions' => ['market', 'lead-generation', 'submit-calculation', 'manuals', 'documents'],
						'roles' => ['@'],
					],
				],
			],
        ];
    }

    /**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex()
	{
		return $this->render('index');
    }

    /**
    * Lists all Profile models.
    * @return mixed
    */
    public function actionBlogs()
    {
        return $this->render('blogs');
    }

    /**
    * Lists all Profile models.
    * @return mixed
    */
    public function actionEvents()
    {
        $user = Yii::$app->user->identity;
        $searchModel = new BlogEventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$user->id);


//      $event_list = BlogEvent::getEventsByUser($user->id);

        return $this->render('events',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
    * Lists all Profile models.
    * @return mixed
    */
    public function actionContacts()
    {
        return $this->render('contacts');
    }

	/**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionReports()
	{
		$curentUser = Yii::$app->user->identity;
		
		$reports = FALSE;
		$teamReports = FALSE;
		
		
		if(!empty(MapTeamUserReport::getUserReports())){
			$reports = TRUE;
		}
		
		if(!empty(MapTeamUserReport::getTeamReports())){
			$teamReports = TRUE;
		}
		
		if($reports && $teamReports){
			$query = MapTeamUserReport::find()->where(['map_team_user_report.user_id' => $curentUser,'reports.type_id' => 1])
				->orWhere(['map_team_user_report.team_id' => Yii::$app->user->identity->profile->current_team_id,'reports.type_id' => 1])
				->joinWith('report')
				->orderBy(['reports.created_at' => SORT_DESC]);
			$dataProvider = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 10,
				],
			]);
		}elseif($reports){
			$query = MapTeamUserReport::find()->where(['map_team_user_report.user_id' => $curentUser,'reports.type_id' => 1])
				->joinWith('report')
				->orderBy(['reports.created_at' => SORT_DESC]);
			$dataProvider = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 10,
				],
			]);
		}elseif($teamReports){
			$query = MapTeamUserReport::find()->where(['map_team_user_report.team_id' => Yii::$app->user->identity->profile->current_team_id,'reports.type_id' => 1])
				->joinWith('report')
				->orderBy(['reports.created_at' => SORT_DESC]);
			$dataProvider = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 10,
				],
			]);
		}else{
			$dataProvider = new ActiveDataProvider([
				'query' => MapTeamUserReport::find()
					->where([
						'`reports`.`id`' => 53
					])
					->joinWith('report')
					->limit(1),
				'pagination' => false,
			]);
		}

        return $this->render('reports', [
			'curentUser' => $curentUser,
			'reports' => $reports,
			'teamReports' => $teamReports,
			'dataProvider' => $dataProvider,
        ]);
    }
	
	
	public function actionTransferPricing()
	{
		$curentUser = Yii::$app->user->identity;
		
		$reports = FALSE;
		$teamReports = FALSE;
		
		
		if(!empty(MapTeamUserReport::getUserTransferReports())){
			$reports = TRUE;
		}
		
		if(!empty(MapTeamUserReport::getTeamTransferReports())){
			$teamReports = TRUE;
		}
		
		if($reports && $teamReports){
			$query = MapTeamUserReport::find()->where(['map_team_user_report.user_id' => $curentUser,'reports.type_id' => 7])
				->orWhere(['map_team_user_report.team_id' => Yii::$app->user->identity->profile->current_team_id,'reports.type_id' => 7])
				->joinWith('report')
				->orderBy(['reports.created_at' => SORT_DESC]);
			$dataProvider = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 10,
				],
			]);
		}elseif($reports){
			$query = MapTeamUserReport::find()->where(['map_team_user_report.user_id' => $curentUser,'reports.type_id' => 7])
				->joinWith('report')
				->orderBy(['reports.created_at' => SORT_DESC]);
			$dataProvider = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 10,
				],
			]);
		}elseif($teamReports){
			$query = MapTeamUserReport::find()->where(['map_team_user_report.team_id' => Yii::$app->user->identity->profile->current_team_id,'reports.type_id' => 7])
				->joinWith('report')
				->orderBy(['reports.created_at' => SORT_DESC]);
			$dataProvider = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 10,
				],
			]);
		}

		if($reports || $teamReports){
			return $this->render('transfer-pricing', [
				'curentUser' => $curentUser,
				'reports' => $reports,
				'teamReports' => $teamReports,
				'dataProvider' => $dataProvider,
			]);
		}else{
			return $this->render('transfer-pricing-landing');
		}
        
    }
	
	public function actionDocuments()
	{

		$curentUser = Yii::$app->user->identity;
		
		$documents = FALSE;
		$teamDocuments = FALSE;
		
		
		if(!empty(MapTeamUserReport::getUserDocuments())){
			$documents = TRUE;
		}
		
		if(!empty(MapTeamUserReport::getTeamDocuments())){
			$teamDocuments = TRUE;
		}
		
		if($documents && $teamDocuments){
			$query = MapTeamUserReport::find()->where(['map_team_user_report.user_id' => $curentUser,'reports.type_id' => 8])
				->orWhere(['map_team_user_report.team_id' => Yii::$app->user->identity->profile->current_team_id,'reports.type_id' => 8])
				->joinWith('report')
				->orderBy(['reports.created_at' => SORT_DESC]);
			$dataProvider = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 10,
				],
			]);
		}elseif($documents){
			$query = MapTeamUserReport::find()->where(['map_team_user_report.user_id' => $curentUser,'reports.type_id' => 8])
				->joinWith('report')
				->orderBy(['reports.created_at' => SORT_DESC]);
			$dataProvider = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 10,
				],
			]);
		}elseif($teamDocuments){
			$query = MapTeamUserReport::find()->where(['map_team_user_report.team_id' => Yii::$app->user->identity->profile->current_team_id,'reports.type_id' => 8])
				->joinWith('report')
				->orderBy(['reports.created_at' => SORT_DESC]);
			$dataProvider = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 10,
				],
			]);
		}

		if($documents || $teamDocuments){
			return $this->render('documents', [
				'curentUser' => $curentUser,
				'reports' => $documents,
				'teamReports' => $teamDocuments,
				'dataProvider' => $dataProvider,
			]);
		}else{
			return $this->render('transfer-pricing-landing');
		}
        
    }
	
	
	public function actionMyMarketingStrategy()
	{
		if(Yii::$app->user->isGuest || empty(Reports::userHasResults())){
			return $this->render('@frontend/modules/forms/views/inquirer/test');
		}else{
			return $this->render('result', [
				'dataProvider' => Reports::getResults(),
			]);
		}
    }
	
	public function actionIndustrial()
	{
        return $this->render('industrial',[
			'dataProvider' => Reports::getIndustrialStatistic(),
		]);
    }
	
	public function actionNps()
	{
        return $this->render('nps',[
			'dataProvider' => Reports::getNps(),
		]);
    }
	
	public function actionGeomarketing()
	{
        return $this->render('geomarketing',[
			'dataProvider' => Reports::getGeomarketing(),
		]);
    }
	
	public function actionManuals()
	{
        return $this->render('manuals',[
			'dataProvider' => Reports::getManuals(),
		]);
    }
	
	public function actionMarket()
	{
        return $this->render('market');
    }
	
	
	public function actionSubmitCalculation()
	{
		if($this->sendMails(Yii::$app->request->post())){
			return true;
		}else{
			return false;
		} 
    }
	
	public function actionLeadGeneration()
	{
		return $this->render('lead');  
    }
	
	/**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionView($id)
	{
		$model = $this->findModel($id);
	
		$accsessReports = Reports::getAllUserReports();
		
		if((!empty(Yii::$app->user->id) && in_array($id, $accsessReports)) || $model->id == 53 || $model->id == 51 || Yii::$app->user->can('manageUsers') || ($model->type_id != 8 && $model->type_id != 1 && $model->type_id != 6 && $model->type_id != 7)){
			return $this->render('view_report', [
				'model' => $model,
			]);
		}else{
			throw new \yii\web\HttpException(403);
		}
		
    }
	
	protected function findModel($id)
    {
        if (($model = Reports::findOne($id)) !== null) {
            return $model;
        } else {
            throw new \yii\web\HttpException(403);
        }
    }
	
	public function beforeAction($action)
	{
		$requestGet = Yii::$app->request->get();
		if(!empty($requestGet)){
			if(!empty($requestGet['token'])){
				$demoToken = UserToken::getDemoToken($requestGet['token']);
				if(!empty($demoToken)){
					$demoUser = User::getDemoUser();
					Yii::$app->user->login($demoUser);
					if (!Yii::$app->request->cookies->has('vizited')) {
						Yii::$app->response->cookies->add(new \yii\web\Cookie([
							'name' => 'vizited',
							'value' => $demoToken->token,
						]));
						$demoToken->vizit = $demoToken->vizit + 1;
						$demoToken->save();
					}else{
						if(Yii::$app->request->cookies->getValue('vizited') != $demoToken->token){
							$demoToken->vizit = $demoToken->vizit + 1;
							$demoToken->save();
						}
					}
					$url = Yii::$app->request->url;
					$pos = strpos($url, "?");
					$url = substr($url, 0, $pos);
					return $this->redirect($url, 302);
				}elseif($requestGet['token'] == 'U_4DeLQobvwAE'){
					$demoUser = User::getDemoUser();
					Yii::$app->user->login($demoUser);
					$url = Yii::$app->request->url;
					$pos = strpos($url, "?");
					$url = substr($url, 0, $pos);
					return $this->redirect($url, 302);
				}
			}
		}

		
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
	
	protected function sendMails($formData)
	{
		$addresses = ['Boris.Volkov@aimarketing.info','Yuriy.Timonin@aimarketing.info','Yuriy.Shchyrin@aimarketing.info'];
		$mail =  Yii::$app->mailer->compose();
		$mail->setFrom([\Yii::$app->params['adminEmail'] => Yii::$app->name])
			->setTo($addresses)
			->setSubject(Yii::t('forms', 'FORM_{form_name}_SUBMITTED', ['form_name' => 'lead_generation']) . ' at ' . date('Y-m-d H:i'))
			->setHtmlBody($this->buildMailBody($formData));
		
		return $mail->send();
	}
	
	private function buildMailBody($formData)
	{
		if(Yii::$app->user->isGuest){
			$email = $formData['LeadGenerationForm']['email'];
		}else{
			$email = $formData['email'];
		}
		$string = '<p>' . Yii::t('forms', 'FORM_<b>{form_name}</b>_WAS_SUBMITTED_ON_NEW.AIMARKETING.INFO', ['form_name' => 'lead_generation']) . '</p>';
		$string .= '<p>' . Yii::t('forms', 'EMAIL_LEAD') . ': ' .$email.'</p>';
		$string .= '<p>' . Yii::t('forms', 'COMP_LEVEL') . ': ' .$formData['LeadGenerationForm']['complexity'].'</p>';
		$string .= '<p>' . Yii::t('forms', 'RANGE') . ': ' .$formData['LeadGenerationForm']['range'].'</p>';
		$string .= '<p>' . Yii::t('forms', 'SUMM') . ': ' .$formData['sum'].'</p>';
		
		return $string;
	}
}
