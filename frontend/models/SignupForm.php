<?php
namespace frontend\models;

use frontend\modules\letter\models\Letter;
use yii\base\Model;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\models\Profile;
use frontend\modules\user\models\ProfileSeoClubInfo;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $email;
    public $password;
	
	public $personalInfo;
	public $profession;
	public $cashTurnover;
	public $firstName;
	public $secondName;

	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
			
			[['personalInfo', 'cashTurnover', 'profession', 'firstName','secondName'], 'string'],
			
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }


		/**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->email = $this->email;
		$user->reg_token = \Yii::$app->security->generateRandomString(40);
		$user->reg_token_expire = date('Y-m-d H:i:s', time() + 30*60);
        $user->setPassword($this->password);
        $user->generateAuthKey();
		if (Yii::$app->session->has('seoClubIngoing')) {
			$user->seo_member_status = Profile::AWAITING_ADD_SEO_CLUB;
		}
		$user->save();
		
		if (Yii::$app->session->has('seoClubIngoing')) {
			$user->seo_member_status = Profile::AWAITING_ADD_SEO_CLUB;
			
			$clubJoiningInfo = new ProfileSeoClubInfo([
				'user_id' => $user->getId(),
				'personal_info' => $this->personalInfo,
				'profession' => $this->profession,
				'cash_turnover' => $this->cashTurnover,
				'first_name' => $this->firstName,
				'second_name' => $this->secondName,
			]);
			if(!$clubJoiningInfo->insert()) {
				throw new Exception('Not save');
			}

			Yii::$app->session->remove('seoClubIngoing');
		}

        // for every registered user assign role "registered"
        $auth = \Yii::$app->authManager;
		$authorRole = $auth->getRole('client');
		$auth->assign($authorRole, $user->getId());
		
		
		
        return ($user->save() AND (self::sendConfirmationEmail($user))) ? $user : null;
    }
    
    /**
    * Sends email to user for email address confirmation
    * 
    * @param User $user the user that tries to register
    * @return bool whether the message has been sent successfully
    */
    private static function sendConfirmationEmail($user)
    {
        $languages = ArrayHelper::map(HdbkLanguage::getLanguagesSymbols(), 'code', 'id');
        $language = \Yii::$app->language;
        $langId = $languages[$language];
        $model = Letter::find()->where(['name' => 'signup', 'lang_id' => $langId])->one() ??
                Letter::find()->where(['name' => 'signup', 'lang_id' => $languages['en']])->one();
        $message = self::composeConfirmEmail($model->content, $user);
        $subject = $model->title;
		
        return \Yii::$app->mailer->compose()
			->setFrom([\Yii::$app->params['adminEmail'] => Yii::$app->name])
			->setTo($user->email)
			->setHtmlBody($message)
			->setSubject($subject)
			->send();
    }

    private static function composeConfirmEmail($content, $user)
    {
        $email = Html::encode($user->email);
        $resetLink = \Yii::$app->urlManager->createAbsoluteUrl(['site/confirm-email', 'token' => $user->reg_token]);
        $resetLink = Html::a(Html::encode($resetLink), $resetLink);
        $content = preg_replace("/{{email}}/ui", $email, $content);
        $content = preg_replace("/{{resetLink}}/ui", $resetLink, $content);
		if(\Yii::$app->language == 'uk'){
			$content .= \Yii::$app->params['settings']['sing_uk'];
		}else{
			$content .= \Yii::$app->params['settings']['sing_en'];
		}

        return $content;
    }
	
	public static function sendConfirmationTco($user)
    {
		$confirmLink = \Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
		
        $languages = ArrayHelper::map(HdbkLanguage::getLanguagesSymbols(), 'code', 'id');
        $language = \Yii::$app->language;
        $langId = $languages[$language];
        $model = Letter::find()->where(['name' => 'signup', 'lang_id' => $langId])->one() ??
                Letter::find()->where(['name' => 'signup', 'lang_id' => $languages['en']])->one();
        $subject = $model->title;

        return \Yii::$app->mailer->compose()
			->setFrom([\Yii::$app->params['adminEmail'] => Yii::$app->name])
			->setTo($user->email)
			->setHtmlBody(self::constructHtmlMessage($user->email, $confirmLink))
			->setSubject($subject)
			->send();
    }
	
	private static function constructHtmlMessage($login, $confirmLink)
	{
		$message = '<div class="confirm_invitation_vrap">';
		$message .= '<p>Вітаю!</p>';
		$message .= '<p>Дякую що користуютесь послугами Agency of Industrial Marketing (AIM).</p>';
		$message .= '<p>Ваш логін: ';
		$message .= "$login</p>";
		$message .= '<p>Дотримуйтесь посилання нижче, щоб задати пароль:</p><p>';
		
		$message .= Html::a(Html::encode($confirmLink), $confirmLink);
		
		$message .= '</p><p>Якщо у вас виникнуть труднощі або ви захочете 
			додати ще користувачів, звертайтесь, я з радістю вам допоможу. 
			Ви можете <a style="font-size: 11px; display: inline-block; 
			background: #ac162c; color: #fff; text-decoration: none;" 
			href="https://app.hubspot.com/meetings/yuriy-shchyrin" target="_blank" 
			rel="noopener"><span style="padding: 6px 6px; display: inline-block;">
			Призначити час</span></a> для відео конференціі</p></div>';

		return $message;

	}
}
