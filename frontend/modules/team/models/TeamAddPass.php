<?php

namespace frontend\modules\team\models;

/**
 * Description of SetTeamName
 *
 * @author petrovich
 */
class TeamAddPass extends \yii\base\Model
{
	public $invitationId;
	public $password;
	public $retypePassword;
		
	public function rules() 
	{
		return [
			['password', 'required'],
            ['password', 'string', 'min' => 6],
			
            ['retypePassword', 'required'],
            ['retypePassword', 'compare', 'compareAttribute' => 'password'],
			
			['invitationId', 'integer']
		];
	}
	
	public function loginWorker()
	{
		$invitation = \common\models\Invitation::findOne($this->invitationId);
		$invitation->worker->reg_token = '';
		$invitation->worker->setPassword($this->password);
		$invitation->worker->status = \common\models\User::STATUS_ACTIVE;
		$invitation->worker->save();
		
		$profile = new \common\models\Profile();
		$profile->user_id = $invitation->worker->id;
		$profile->language = \Yii::$app->language;
		$profile->active_project = $invitation->project_id;
		$profile->save();
		
		\Yii::$app->user->login($invitation->worker);
	}
}
