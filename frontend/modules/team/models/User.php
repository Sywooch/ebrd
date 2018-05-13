<?php
namespace frontend\modules\team\models;

use Yii;

class User extends \common\models\User
{
	public static function createInvatationUser($email)
	{
		$user = new self();
		$user->email = $email;
		$user->status_id = self::STATUS_AWAITING_EMAIL_CONFIRMATION;
		$user->setPassword(Yii::$app->security->generateRandomString());
		$user->auth_key = Yii::$app->security->generateRandomString();
		$user->save();
		
		$auth = \Yii::$app->authManager;
		$authorRole = $auth->getRole('client');
		$auth->assign($authorRole, $user->id);
		
		return $user;		
	}

	public static function findByEmailInvitedUser($email)
	{
		return static::findOne(['email' => $email]);
	}
}
