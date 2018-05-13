<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\authclient\widgets\AuthChoice;

$this->title = Yii::t('blog', 'RESET_PASSWORD_LOGIN');
$this->registerMetaTag(['property' => 'og:description', 'content' => Yii::t('blog', 'RESET_PASSWORD_LOGIN')]);
$this->registerMetaTag(['name' => 'description', 'content' => Yii::t('blog', 'RESET_PASSWORD_LOGIN')]);
?>
<div class="login__container">
	<h1 class="login__title"><?= Yii::t('blog','RESET_PASSWORD_LOGIN') ?></h1>
	<?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

	<div class="login__box">
		<svg><use xlink:href="#svg_login_user"></use></svg>
		<?= $form->field($model, 'email')->textInput(['class'=>'login__input', 'autofocus' => true, 'placeholder' => Yii::t('blog','ENTER_EMAIL')])->label(false) ?>
	</div>

	<div class="form-group signup_btn_container">
		<?= Html::submitButton(Yii::t('blog','SAVE'), ['class' => 'button__ma']) ?>
	</div>

	<div class="login__reset">
		<?= Yii::t('blog', 'HAVE_ACCOUNT') .' '. Html::a(Yii::t('blog','LOGIN_IT'), ['site/login'], ['class' => 'link']) ?>
	</div>

	<div class="login__reset">
		<?= Yii::t('blog', 'DONT_HAVE_ACCOUNT') .' '. Html::a(Yii::t('blog','SIGN_UP_IT'), ['site/signup'], ['class' => 'link']) ?>
	</div>
	<?php ActiveForm::end(); ?>

	<div class="social_links_auth">
		<div class="auth_text"><?= Yii::t('blog','AUTH_TEXT_LOGIN') ?></div>
		<div class="auth_icons_container">
			<?php
			$authAuthChoice = AuthChoice::begin([
				'baseAuthUrl' => ['/site/auth'],
				'autoRender' => false
			]);
			foreach ($authAuthChoice->getClients() as $client){
				echo Html::a('<svg><use xlink:href="#'.$client->name.'"></use></svg>', ['/site/auth', 'authclient' => $client->name],['class' => 'auth_'.$client->name]);
			}
			AuthChoice::end();
			?>
		</div>
	</div>
</div>
