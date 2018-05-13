<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm-email', 'token' => $user->reg_token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->email) ?>,</p>

    <p>Follow the link below to confirm your email:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
