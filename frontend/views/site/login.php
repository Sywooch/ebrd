<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\authclient\widgets\AuthChoice;

$this->title = Yii::t('blog','LOGIN_LOGIN');
$this->registerMetaTag(['property' => 'og:description', 'content' => Yii::t('blog','LOGIN_LOGIN')]);
$this->registerMetaTag(['name' => 'description', 'content' => Yii::t('blog','LOGIN_LOGIN')]);
?>
<div class="login__container">
		<h1 class="login__title"><?= Yii::t('blog','LOGIN_LOGIN') ?></h1>
		<?php $form = ActiveForm::begin([
			'id' => 'login-form',
			'options' => [
				'onsubmit' => 'sendYandexLogin()'
			],
			]); ?>

			<div class="login__box">
				<svg><use xlink:href="#svg_login_user"></use></svg>
				<?= $form->field($model, 'email')->textInput(['class'=>'login__input', 'placeholder' => 'E-mail'])->label(false) ?>
			</div>

			<div class="login__box">
				<svg><use xlink:href="#svg_login_password"></use></svg>
				<?= $form->field($model, 'password')->passwordInput(['class'=>'login__input', 'placeholder' => Yii::t('blog','PASSWORD')])->label(false) ?>
			</div>

			<div class="flex__jcsb flex__aic">
				<?= Html::submitButton(Yii::t('blog','LOGIN'), ['class' => 'button', 'name' => 'login-button']) ?>

				<?= $form->field($model, 'rememberMe')->checkbox(['class'=>'login_checkbox','label'=>Yii::t('blog','REMEMBER_ME')]) ?>
			</div>

				<div class="login__reset">
					<?= Yii::t('blog', 'DONT_HAVE_ACCOUNT') .' '. Html::a(Yii::t('blog','SIGN_UP_IT'), ['site/signup'], ['class' => 'link']) ?>
				</div>

				<div class="login__reset">
					<?= Yii::t('blog', 'FORGOT_PASSWORD') .' '. Html::a(Yii::t('blog','RESET_IT'), ['site/request-password-reset'], ['class' => 'link']) ?>
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
