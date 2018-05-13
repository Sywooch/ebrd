<?php

namespace frontend\modules\team\controllers;

use yii\web\Controller;
use frontend\modules\team\models\TeamSetName;
use frontend\modules\team\models\TeamInviteUser;
use frontend\modules\team\models\Invitation;
use frontend\modules\team\models\Team;
use frontend\modules\user\models\Profile;
use common\models\User;
use yii\filters\AccessControl;

use Yii;

/**
 * Default controller for the `team` module
 */
class DefaultController extends Controller
{
	public function behaviors()
    {
        return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions' => [
							'index',
							'team-set-name',
							'team-invite-user',
							'modify-invitation',
							'select-team'
						],
						'roles' => ['clientActions'],
					],
					[
						'allow' => true,
						'actions' => [
							'create'
						],
						'roles' => ['manageUsers'],
					],
					[
						'allow' => true,
						'actions' => [
							'confirm-invitation',
							'reject-invitation'
						],
						'roles' => ['?','@'],
					],
				],
			],
        ];
    }
	
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
		
		$modelTeamName = new TeamSetName();
		$modelIviteUser = new TeamInviteUser();
		$teamTableDP = Invitation::getTeamTableDP(Yii::$app->user->id);
		
		return $this->render('index', [
			'modelTeamName' => $modelTeamName,
			'modelInviteUser' => $modelIviteUser,
			'teamTableDP' => $teamTableDP
		]);
    }
	
	/**
	 * Creates new user's team if necessary and redirects to index
	 * 
	 * @return string
	 */
	public function actionCreate()
	{
		
		if(Yii::$app->user->can('manageUsers')){
			Team::createTeam();
		}elseif(!Team::userHasTeam()){
			Team::createTeam();
		}
		Yii::$app->session->setFlash('success', Yii::t('blog', 'TEAM_CREATED'));
		return $this->redirect(['index']);
		
	}

	public function actionTeamSetName()
	{
		$model = new TeamSetName();

		if ($model->load(Yii::$app->request->post()) && ($model->validate())){
			$model->save();
		}

		return $this->renderPartial('_team-set-name',[
			'model' => $model,
		]);
	}

	public function actionTeamInviteUser()
	{
		$model = new TeamInviteUser();

		if ($model->load(Yii::$app->request->post()) && ($model->validate())){
			$model->sendInvitation(Yii::$app->user->identity);
		}

		return $this->renderPartial('_team-invite-user', ['model' => $model]);
	}
	
	/**
	 * Invitation confirmation
	 * 
	 * @param string $token
	 * @return string
	 * @throws \yii\web\HttpException If user is not allowe to perform this action
	 */
	public function actionConfirmInvitation($token)
	{
		$invitation = Invitation::findOne(['token_accept' => $token]);
		
		if (is_object($invitation)){
			if ($invitation->status_id === Invitation::SENT_AWAITING_ACTION){
				$invitation->status_id = Invitation::CONFIRMED_BY_USER;
				$invitation->token_decline = NULL;
				$invitation->save();
				$invitedUser = $invitation->invited;
				if (($invitedUser->status_id === User::STATUS_ACTIVE) && (Yii::$app->user->isGuest)){			//if user was registered earlier
					Yii::$app->user->login($invitedUser, 3600*24*7);
					Profile::updateProfile($invitedUser);
				} elseif (($invitedUser->status_id === User::STATUS_ACTIVE) && (!Yii::$app->user->isGuest)) {	
					Profile::updateProfile($invitedUser);
					if (Yii::$app->user->id !== $invitedUser->id){												//if user is logged in in another account - log him out
						Yii::$app->user->logout();
						Yii::$app->user->login($invitedUser, 3600*24*7);
					}
				} elseif ($invitedUser->status_id === User::STATUS_AWAITING_EMAIL_CONFIRMATION){
					if (!Yii::$app->user->isGuest){		
						Yii::$app->user->logout();
					}
					$invitedUser->status_id = User::STATUS_ACTIVE;
					$invitedUser->save();
					Profile::createProfile($invitedUser->id,$invitedUser);
					if ($invitedUser->reg_token === NULL){														
						$resetPassToken = Yii::$app->security->generateRandomString() . '_' . time();
						$invitedUser->password_reset_token = $resetPassToken;
						$invitedUser->save();
						Yii::$app->session->setFlash('success', Yii::t('user', 'YOU_HAVE_SUCCESSFULLY_CONFIRMED_INVITATION_NOW_PLEASE_SET_PASSWORD'));
						return $this->redirect(['/site/reset-password', 'token' => $resetPassToken]);
					} else {
						$invitedUser->reg_token = NULL;
						$invitedUser->save();
						Yii::$app->user->login($invitedUser, 3600*24*7);
					}
				} else {
					throw new \yii\web\HttpException(403, Yii::t('user', 'YOU_CAN_NOT_PERFORM_THIS_ACTION'));
				}
				Yii::$app->session->setFlash('success', Yii::t('user', 'YOU_HAVE_SUCCESSFULLY_CONFIRMED_INVITATION'));
			} elseif ($invitation->status_id === Invitation::CONFIRMED_BY_USER) {
				Yii::$app->session->setFlash('success', Yii::t('user', 'YOU_HAVE_ALREADY_ACCEPTED_THIS_INVITATION'));
			} elseif ($invitation->status_id === Invitation::CLOSED_BY_MASTER){
				Yii::$app->session->setFlash('error', Yii::t('user', 'INVITATION_WAS_CLOSED_BY_INVITER'));
			} else {
				Yii::$app->session->setFlash('error', Yii::t('user', 'YOU_CAN_NOT_CONFIRM_THIS_INVITATION'));
			}
		} else {
			Yii::$app->session->setFlash('error', Yii::t('user', 'INVITATION_WAS_NOT_FOUND'));
		}		
		
		return $this->redirect(['/user/cabinet']);
	}
	
	/**
	 * Rejects invitation by token
	 * 
	 * @param string $token
	 * @return string
	 * @throws \yii\web\HttpException if token was not found
	 */
	public function actionRejectInvitation($token)
	{
		$invitation = Invitation::findOne(['token_decline' => $token]);
		if ((is_object($invitation)) && ($invitation->status_id === Invitation::SENT_AWAITING_ACTION)){
			$invitation->token_decline = NULL;
			$invitation->token_accept = NULL;
			$invitation->status_id = Invitation::REJECTED_BY_USER;
			$invitation->save();

			$invitedUser = $invitation->invited;
			if (($invitedUser->status_id === User::STATUS_AWAITING_EMAIL_CONFIRMATION) && ($invitedUser->reg_token === NULL)){
				$invitation->invited_id = NULL;
				$invitation->save();
				$invitedUser->delete();
			}

			return $this->render('rejected');			
		}
		
		throw new \yii\web\HttpException(403, Yii::t('team', 'YOU_CAN_NOT_PERFORM_THIS_ACTION'));
	}
	
	/**
	 * Modifies invitation
	 * 
	 * @return string
	 */
	public function actionModifyInvitation()
	{
		if(Yii::$app->request->isPost){
			if((!empty(Yii::$app->request->post()['invitationId'])) && (!empty(Yii::$app->request->post()['action']))){
				$invitation = Invitation::findOne([
					'id' => Yii::$app->request->post()['invitationId'],
					'team_id' => Yii::$app->user->identity->profile->current_team_id,
				]);
				
				$actions = $invitation->modify(Yii::$app->request->post()['action']);
				
				return json_encode([
					'invitationId' => $invitation->id,
					'statusName' => Yii::t('team', $invitation->invitationStatus->name),
					'updatedAt' => $invitation->updated_at,
					'actions' => $actions,
				]);
			}
		}
		return json_encode(Yii::$app->request->post());
	}
	
	public function actionSelectTeam($id)
	{
		$profile = Yii::$app->user->identity->profile;
		
		if ($id == 0) {
			$profile->current_team_id = NULL;
		} else {
			$profile->current_team_id = $id;
		}
		
		$profile->save();
		
		if ($id == 0) {
			return $this->redirect(Yii::$app->homeUrl);
		} else {
			return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
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
