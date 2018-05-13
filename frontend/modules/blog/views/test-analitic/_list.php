<?php

use common\models\User;
use yii\helpers\Html;

?>

<div class="admin-test-analytic__id"><?= $model->id; ?></div>
<div class="admin-test-analytic__email">
	<?php
	$user = User::findOne($model->user_id);
	echo $user->email;
	?>
</div>
<div class="admin-test-analytic__mark"><?= $model->getMark(); ?></div>
<div class="admin-test-analytic__view">
	<?= Html::a('VIEW', ['view-result', 'userid' => $model->user_id], ['target' => '_blank']); ?>
</div>

