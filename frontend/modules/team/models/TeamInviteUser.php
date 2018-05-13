<?php

namespace frontend\modules\team\models;

use frontend\modules\team\models\User;
use frontend\modules\team\models\Invitation;
use yii\helpers\ArrayHelper;
use frontend\models\HdbkLanguage;
use frontend\modules\letter\models\Letter;
use yii\helpers\Html;
use Yii;

/**
 * Description of SetTeamName
 *
 * @author petrovich
 */
class TeamInviteUser extends \yii\base\Model
{
	public $email;
	public $message;


	public function __construct() {
		
		parent::__construct();
	}
	
	public function rules() 
	{
		return [
			['email', 'required'],
			['email', 'email'],
			['email', 'compare', 'compareValue' => Yii::$app->user->identity->email, 'operator' => '!=='],
			['message', 'string'],
		];
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('team', 'EMAIL'),
        ];
    }
	
	public function sendInvitation ($fromUser)
	{
		$toUser = User::findByEmailInvitedUser($this->email);
		
		if (!$toUser) {
			$toUser = User::createInvatationUser($this->email);
		}
		
		$findInvitation = Invitation::getInvitationByTeamId($toUser->id, $fromUser->profile->current_team_id);
		
		if(empty($findInvitation)){
			$invitation = Invitation::createInvitation($fromUser, $toUser, $this->message);
			
			$languages = ArrayHelper::map(HdbkLanguage::getLanguagesSymbols(), 'code', 'id');
			$language = \Yii::$app->language;
			$langId = $languages[$language];
			$model = Letter::find()->where(['name' => 'invite_team', 'lang_id' => $langId])->one() ??
					Letter::find()->where(['name' => 'invite_team', 'lang_id' => $languages['en']])->one();
			$message = self::composeConfirmEmail($model->content,$invitation);
			$subject = $model->title;

			\Yii::$app->mailer->compose()
				->setFrom([\Yii::$app->params['adminEmail'] => Yii::$app->name])
				->setTo($invitation->invited->email)
				->setHtmlBody($message)
				->setSubject($subject)
				->send();

				$invitation->status_id = Invitation::SENT_AWAITING_ACTION;
				$invitation->save();

				return $invitation;
		}else{
			
			$languages = ArrayHelper::map(HdbkLanguage::getLanguagesSymbols(), 'code', 'id');
			$language = \Yii::$app->language;
			$langId = $languages[$language];
			$model = Letter::find()->where(['name' => 'invite_team', 'lang_id' => $langId])->one() ??
					Letter::find()->where(['name' => 'invite_team', 'lang_id' => $languages['en']])->one();
			$message = self::composeConfirmEmail($model->content,$findInvitation[0]);
			$subject = $model->title;

			\Yii::$app->mailer->compose()
				->setFrom([\Yii::$app->params['adminEmail'] => Yii::$app->name])
				->setTo($findInvitation[0]->invited->email)
				->setHtmlBody($message)
				->setSubject($subject)
				->send();
		}
	}
	
	private function composeConfirmEmail($content, $invitation)
    {
        $confirmUrl = Yii::$app->urlManager->createAbsoluteUrl(['/team/default/confirm-invitation', 'token' => $invitation->token_accept]);
		$link = Html::a($confirmUrl,$confirmUrl);
        $content = preg_replace("/{{login}}/ui", $invitation->email, $content);
        $content = preg_replace("/{{confirmLink}}/ui", $link, $content);
		if(\Yii::$app->language == 'uk'){
			$content .= \Yii::$app->params['settings']['sing_uk'];
		}else{
			$content .= \Yii::$app->params['settings']['sing_en'];
		}

        return $content;
    }
}
