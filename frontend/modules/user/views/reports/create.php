<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\user\models\Reports */

$this->title = Yii::t('user', 'Create Reports');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Reports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reports-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'users' => $users,
		'teams' => $teams,
		'types' => $types,
		'usedTeams' => $usedTeams,
		'usedUsers' => $usedUsers,
    ]) ?>

</div>
