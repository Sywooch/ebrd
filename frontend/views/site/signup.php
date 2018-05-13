<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\authclient\widgets\AuthChoice;

$this->title = Yii::t('blog','SIGN_UP_LOGIN');
$this->registerMetaTag(['property' => 'og:description', 'content' => Yii::t('blog','SIGN_UP_LOGIN')]);
$this->registerMetaTag(['name' => 'description', 'content' => Yii::t('blog','SIGN_UP_LOGIN')]);
?>

<div class="login__container">
	<?php if(Yii::$app->session->has('seoClubIngoing')):?>
	<div class="alert-info">
		<?= Yii::t('site', 'SIGNUP_PLEASE_AND_WE_ADD_YOU_TO_SEO_CLUB')?>
	</div>
	<h1 class="login__title"><?= Yii::t('blog','SIGN_UP_LOGIN') ?></h1>
	<?php $form = ActiveForm::begin([
		'id' => 'form-signup',
		'options' => [
			'onsubmit' => 'sendYandexSignup()'
		],
	]); ?>

	<div class="login__box">
		<svg><use xlink:href="#svg_login_user"></use></svg>
		<?= $form->field($model, 'email')->textInput([
			'class'=>'login__input', 
			'autofocus' => true, 'placeholder' => 'E-mail'
		])->label(false)  ?>
	</div>

	<div class="login__box">
		<svg><use xlink:href="#svg_login_password"></use></svg>
		<?= $form->field($model, 'password')->passwordInput([
			'class'=>'login__input', 
			'placeholder' => Yii::t('blog','PASSWORD')
		])->label(false) ?>
	</div>
	<!-- fields added through seo club reg form BEGIN -->
	<div>
		<?= $form->field($model, 'personalInfo')->textarea([
			'class'=>'login__input', 
			'placeholder' => Yii::t('blog', 'TO_HAVE_MORE_CHANCES_TO_JOIN_PLEASE_PROVIDE_INFORMATION_ABOUT')
		])->label(false)  ?>
	</div>
	
	<div>
		<?= $form->field($model, 'cashTurnover')->textInput([
			'class'=>'login__input', 
			'placeholder' => Yii::t('blog', 'CASH_TURNOVER')
		])->label(false)  ?>
	</div>
	
	<div>
		<?= $form->field($model, 'firstName')->textInput([
			'class'=>'login__input', 
			'placeholder' => Yii::t('blog', 'FIRST_NAME')
		])->label(false)  ?>
	</div>
	
	<div>
		<?= $form->field($model, 'secondName')->textInput([
			'class'=>'login__input', 
			'placeholder' => Yii::t('blog', 'SECOND_NAME')
		])->label(false)  ?>
	</div>
	
	<div>
		<?= $form->field($model, 'profession')->textInput([
			'class'=>'login__input', 
			'placeholder' => Yii::t('blog', 'YOUR_PROFESSION')
		])->label(false)  ?>
	</div>
		
	<!-- fields added through seo club reg form END -->
	<div class="form-group signup_btn_container">
		<?= Html::submitButton(Yii::t('blog','SIGN_UP_IT_BTN'), [
			'class' => 'button__ma', 
			'name' => 'signup-button'
		]) ?>
	</div>

		<div class="login__reset">
			<?= Yii::t('blog', 'HAVE_ACCOUNT') .' '. Html::a(Yii::t('blog','LOGIN_IT'), ['site/login'], ['class' => 'link']) ?>
		</div>

	<?php ActiveForm::end(); ?>
	
	
	
	
	<?php else:?>
	
	<h1 class="login__title"><?= Yii::t('blog','SIGN_UP_LOGIN') ?></h1>
	<?php $form = ActiveForm::begin([
		'id' => 'form-signup',
		'options' => [
			'onsubmit' => 'sendYandexSignup()'
		],
	]); ?>

	<div class="login__box">
		<svg><use xlink:href="#svg_login_user"></use></svg>
		<?= $form->field($model, 'email')->textInput([
			'class'=>'login__input', 
			'autofocus' => true, 
			'placeholder' => 'E-mail'
		])->label(false)  ?>
	</div>

	<div class="login__box">
		<svg><use xlink:href="#svg_login_password"></use></svg>
		<?= $form->field($model, 'password')->passwordInput(['class'=>'login__input', 'placeholder' => Yii::t('blog','PASSWORD')])->label(false) ?>
	</div>

	<div class="form-group signup_btn_container">
		<?= Html::submitButton(Yii::t('blog','SIGN_UP_IT_BTN'), ['class' => 'button__ma', 'name' => 'signup-button']) ?>
	</div>

		<div class="login__reset">
			<?= Yii::t('blog', 'HAVE_ACCOUNT') .' '. Html::a(Yii::t('blog','LOGIN_IT'), ['site/login'], ['class' => 'link']) ?>
		</div>

		<div class="login__reset">
			<?= Yii::t('blog', 'FORGOT_PASSWORD') .' '. Html::a(Yii::t('blog','RESET_IT'), ['site/request-password-reset'], ['class' => 'link']) ?>
		</div>

	<?php ActiveForm::end(); ?>
	<div class="social_links_auth">
		<div class="auth_text"><?= Yii::t('blog','AUTH_TEXT') ?></div>
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
	<?php endif;?>
</div>
