<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
?>
<div class="report-mail">
    <p>Вітаю <?= Html::encode($userObj->email) ?>,</p>

    <p>У вас новий звіт на aimarketing.info</p>
	
	<p><?= Html::a('https://aimarketing.info/uk/cabinet/reports', 'https://aimarketing.info/uk/cabinet/reports') ?></p>
</div>
