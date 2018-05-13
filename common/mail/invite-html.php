<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$inviteLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm-email', 'token' => $user->reg_token]);
?>
<div class="password-reset">
    <p>Вітаю, вас запросили на ubb.og.ua,</p>
	
	<p>Ваш логін : <?= $user->email ?></p>
	<p>Ваш пароль : <?= $model->newPassword ?></p>

    <p>Дотримуйтесь посилання нижче, щоб підтвердити запрошення:</p>

    <p><?= Html::a(Html::encode($inviteLink), $inviteLink) ?></p>
</div>
