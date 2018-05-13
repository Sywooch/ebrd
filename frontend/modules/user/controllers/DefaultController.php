<?php

namespace frontend\modules\user\controllers;

use common\models\User;
use common\models\AuthAssignment;
use frontend\modules\user\models\HdbkUserStatus;
use frontend\modules\user\models\UserAdd;
use frontend\modules\user\models\UserSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use common\models\Team;
use Yii;
use frontend\components\traits\FilterTrait;
use common\models\Profile;

/**
 * Default controller for the `user` module
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
					'assign-role' => ['POST'],
                    'delete' => ['POST'],
					'revoke-role' => ['POST'],
					'superuser' => ['POST'],
                ],
            ],
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions' => [
							'add-user',
							'assign-role',
							'block',
							'delete',
							'edit-roles',
							'index',
							'revoke-role',
							'unblock',
							'view',
							'reset-filter',
							'seo-club-requests',
							'ajax-change-club-status'
						],
						'roles' => ['manageUsers'],
					],
					[
						'allow' => true,
						'actions' => [
							'superuser'
						],
						'roles' => ['manageSuperusers'],
					],
				],
			],
        ];
    }
	
	public function actionAddUser()
	{
		User::clearExpiredTokens();
		$model = new UserAdd();

		if (($model->load(\Yii::$app->request->post())) && ($model->validate())){
			if ($model->inviteUser()){
				Yii::$app->session->setFlash('success',
					Yii::t('user', 'INVITATION TO USER {name} SENT TO EMAIL {email}', [
						'name' => $model->fullName,
						'email' => $model->email,
					]));
				return $this->redirect('index');
			}
		}
		return $this->render('add-user', [
			'model' => $model,
		]);
	}
	
	public function actionAssignRole($userId, $role)
	{
		if (AuthAssignment::assignRole($userId, $role)){
			Yii::$app->session->setFlash('success', Yii::t('user', 'ROLE_WAS_SUCCESSFULLY_ASSIGNED'));
		} else {
			Yii::$app->session->setFlash('error', Yii::t('user', 'SOMETHING_WENT_WRONG'));
		}
		
		return $this->redirect(['edit-roles', 'id' => $userId]);
	}
	
	/**
	 * Blocks existing user
	 * 
	 * @param integer $id
	 * @return string
	 */
	public function actionBlock($id)
	{
		$user = User::findOne($id);
		if (!empty($user)){
			$user->status_id = User::STATUS_BLOCKED;
			if ($user->save()){
				Yii::$app->session->setFlash('success', Yii::t('user', 'USER_WAS_BLOCKED_SUCCESSFULLY'));
				return $this->redirect(Yii::$app->request->referrer);	
			}
		}
		
		Yii::$app->session->setFlash('error', Yii::t('user', 'FAILED_TO_BLOCK_USER'));
		
		return $this->redirect(Yii::$app->request->referrer);		
	}
	
	public function actionDelete($id)
	{
		if (User::deleteUser($id)){
			Yii::$app->session->setFlash('success', Yii::t('user', 'USER_DELETED_SUCCESSFULLY'));
		} else {
			Yii::$app->session->setFlash('error', Yii::t('user', 'YOU_CAN_NOT_DELETE_THIS_USER'));
		}
		return $this->redirect('index');
	}


	/**
	 * Renders the edit-roles view page
	 * 
	 * @param integer $id
	 * @return string
	 */
	public function actionEditRoles($id)
	{
		$user = User::findOne($id);
		$userRoles = Yii::$app->authManager->getRolesByUser($user->id);
		$allRoles = Yii::$app->authManager->getRoles();
		
		if (!Yii::$app->user->can('manageSuperusers')){
			unset($userRoles['superuser']);
			unset($allRoles['superuser']);
		}
				
		return $this->render('edit-roles', [
				'user' => $user,
				'userRoles' => $userRoles,
				'allRoles' => $allRoles,
				'permissions' => Yii::$app->authManager->getPermissions(),
			]);
	}
	
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
		$searchModel = new UserSearch();
		$params = $this->saveFilter('user', Yii::$app->request->queryParams);
		$dataProvider = $searchModel->search($params);
		$roles = Yii::$app->authManager->roles;
		
        return $this->render('index', [
			'dataProvider'	=> $dataProvider,
			'searchModel'	=> $searchModel,
			'statuses'		=> HdbkUserStatus::getTranslatedStatuses(),
			'roles'			=> $roles,
			'teamSerach'	=> Team::getTeams(),
		]);
    }
	
	public function actionRevokeRole($userId, $role)
	{
		if (AuthAssignment::revokeRole($userId, $role)){
			Yii::$app->session->setFlash('success', Yii::t('user', 'ROLE_WAS_SUCCESSFULLY_REVOKED'));
		} else {
			Yii::$app->session->setFlash('error', Yii::t('user', 'SOMETHING_WENT_WRONG'));
		}
		
		return $this->redirect(['edit-roles', 'id' => $userId]);
	}
	
	public function actionSuperuser($id)
	{
		if (array_key_exists('superuser', Yii::$app->authManager->getRolesByUser($id))){
			if(AuthAssignment::revokeRole($id, 'superuser')){
				Yii::$app->session->setFlash('success', Yii::t('user', 'ROLE_WAS_SUCCESSFULLY_REVOKED'));
			} else {
				Yii::$app->session->setFlash('error', Yii::t('user', 'SOMETHING_WENT_WRONG'));
			}
		} else {
			if (AuthAssignment::assignRole($id, 'superuser')){
				Yii::$app->session->setFlash('success', Yii::t('user', 'ROLE_WAS_SUCCESSFULLY_REVOKED'));
			} else {
				Yii::$app->session->setFlash('error', Yii::t('user', 'SOMETHING_WENT_WRONG'));
			}
		}
		
		return $this->redirect(Yii::$app->request->referrer);
	}

	/**
	 * Blocks existing user
	 * 
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUnblock($id)
	{		
		$user = User::findOne($id);
		if (!empty($user)){
			$user->status_id = User::STATUS_ACTIVE;
			if ($user->save()){
				Yii::$app->session->setFlash('success', Yii::t('user', 'USER_WAS_UNBLOCKED_SUCCESSFULLY'));
				return $this->redirect(Yii::$app->request->referrer);
			}
		}
		
		Yii::$app->session->setFlash('error', Yii::t('user', 'FAILED_TO_UNBLOCK USER'));
		
		return $this->redirect(Yii::$app->request->referrer);
	}
	
	/**
	 * 
	 * @return string
	 */
	public function actionView()
	{
		return $this->render('view');
	}
	
	public function actionSeoClubRequests()
	{
		$searchModel = new UserSearch();
		$searchModel->clubFilter = true;
		$params = $this->saveFilter('user', Yii::$app->request->queryParams);
		$dataProvider = $searchModel->search($params);
		$statuses = \yii\helpers\ArrayHelper::map(
			User::find()->distinct()->all(), 'seo_member_status', 'seo_member_status'
		);
		unset($statuses[Profile::ORDINARY_USER]);

		return $this->render('seo-club-requests', [
			'dataProvider'	=> $dataProvider,
			'searchModel'	=> $searchModel,
			'statuses' => $statuses
		]);
	}
	
	public function actionAjaxChangeClubStatus()
	{
		if(Yii::$app->request->isAjax) {
			$post = Yii::$app->request->post();
			return $this->asJson($post);
		}
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
