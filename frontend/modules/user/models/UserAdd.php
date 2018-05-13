<?php

namespace frontend\modules\user\models;

use common\models\User;
use frontend\models\HdbkLanguage;
use frontend\modules\letter\models\Letter;
use yii\helpers\ArrayHelper;
use Yii;
use yii\helpers\Html;

Class UserAdd extends User
{
	public $fullName;
	public $newPassword;
	public $role;
	public $roles;


	public function rules() {
		return [
			[['email', 'role'], 'required'],
			[['email'], 'email'],
			[
				'email',
				'unique',
				'targetClass' => User::className(),
				'message' => Yii::t('user', 'THIS EMAIL HAVE ALREADY BEEN TAKEN')
			],
			[['role'], 'string'],
		];
	}
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fullName' => Yii::t('user', 'FULLNAME'),
            'role' => Yii::t('user', 'ROLE'),
            'email' => Yii::t('user', 'EMAIL'),
            'newPassword' => Yii::t('user', 'PASSWORD'),
       ];
    }
	
	public function init() {
		$this->newPassword = Yii::$app->getSecurity()->generateRandomString(17);
		$this->role = 'registered';
		$this->roles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name');
		if (!Yii::$app->user->can('manageSuperusers')){
			unset($this->roles['superuser']);			
		}
		parent::init();
	}
	
	public function inviteUser($email = false)
	{
        $user = new User();
		if($email){
			$user->email = $email;
		}else{
			$user->email = $this->email;
		}
		$user->reg_token = \Yii::$app->security->generateRandomString(40);
		$user->reg_token_expire = date('Y-m-d H:i:s', time() + 365*24*60*60);
		$resetPassToken = Yii::$app->security->generateRandomString(40);
        $user->password_reset_token = $resetPassToken;
        $user->generateAuthKey();
		$user->save();

        // for every registered user assign role "registered"
        $auth = \Yii::$app->authManager;
		$authorRole = $auth->getRole(['client']);
		$auth->assign($authorRole, $user->id);
		
        return ($user->save() AND ($this->sendInvitationEmail($user)));
	}    
	
    /**
    * Sends email to user for email address confirmation
    * 
    * @param User $user the user that tries to register
    * @return bool whether the message has been sent successfully
    */
    private function sendInvitationEmail($user)
    {
        $languages = ArrayHelper::map(HdbkLanguage::getLanguagesSymbols(), 'code', 'id');
        $language = \Yii::$app->language;
        $langId = $languages[$language];
        $model = Letter::find()->where(['name' => 'invite', 'lang_id' => $langId])->one() ??
                Letter::find()->where(['name' => 'invite', 'lang_id' => $languages['en']])->one();
        $message = self::composeConfirmEmail($model->content, $user);
        $subject = $model->title;

        return \Yii::$app->mailer->compose()
            ->setFrom([\Yii::$app->params['adminEmail'] => Yii::$app->name])
            ->setTo($user->email)
            ->setHtmlBody($message)
            ->setSubject($subject)
            ->send();
    }

    private function composeConfirmEmail($content, $user)
    {
        $email = Html::encode($user->email);
        $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
        $resetLink = Html::a(Html::encode($resetLink), $resetLink);
        $newPassword = $this->newPassword;
        $content = preg_replace("/{{email}}/ui", $email, $content);
        $content = preg_replace("/{{resetLink}}/ui", $resetLink, $content);
        $content = preg_replace("/{{newPassword}}/ui", $newPassword, $content);
		if(\Yii::$app->language == 'uk'){
			$content .= \Yii::$app->params['settings']['sing_uk'];
		}else{
			$content .= \Yii::$app->params['settings']['sing_en'];
		}

        return $content;
    }
}
