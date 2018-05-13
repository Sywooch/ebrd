<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use frontend\modules\letter\models\Letter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status_id' => [User::STATUS_ACTIVE, User::STATUS_AWAITING_EMAIL_CONFIRMATION]],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status_id' => [User::STATUS_ACTIVE, User::STATUS_AWAITING_EMAIL_CONFIRMATION],
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        $languages = ArrayHelper::map(HdbkLanguage::getLanguagesSymbols(), 'code', 'id');
        $language = \Yii::$app->language;
        $langId = $languages[$language];
        $model = Letter::find()->where(['name' => 'passwordReset', 'lang_id' => $langId])->one() ??
                Letter::find()->where(['name' => 'passwordReset', 'lang_id' => $languages['en']])->one();
        $message = self::composerResetPasswordEmail($model->content, $user);
        $subject = $model->title;

        return Yii::$app
            ->mailer
            ->compose()
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setTo($this->email)
            ->setHtmlBody($message)
            ->setSubject($subject)
            ->send();
    }

    private function composerResetPasswordEmail($content, $user)
    {
        $email = Html::encode($user->email);
        $resetLink = \Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
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
}
