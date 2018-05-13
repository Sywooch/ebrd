<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $invitation common\models\Invitation */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['/team/default/confirm-invitation', 'token' => $invitation->token_accept]);
$rejectLink = Yii::$app->urlManager->createAbsoluteUrl(['/team/default/reject-invitation', 'token' => $invitation->token_decline]);
?>

<div class="confirm_invitation_vrap">
    <p>Вітаю!</p>
	<p>Дякую що користуютесь послугами Agency of Industrial Marketing (AIM).</p>
	<p>Запрошую вас відвідати ваш персональний кабінет.</p>
	<p>Де вже додано звіт по вашому ринку.</p>
	<p>Ваш логін: <?= $invitation->email ?></p>
	<p>Дотримуйтесь посилання нижче, щоб задати пароль:</p>
    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
	<p>Якщо у вас виникнуть труднощі або ви захочете додати ще користувачів, звертайтесь, я з радістю вам допоможу. Ви можете <a style="font-size: 11px; display: inline-block; background: #ac162c; color: #fff; text-decoration: none;" href="https://app.hubspot.com/meetings/yuriy-shchyrin" target="_blank" rel="noopener"><span style="padding: 6px 6px; display: inline-block;">Призначити час</span></a> для відео конференціі</p>
</div>
