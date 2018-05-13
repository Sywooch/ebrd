<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\user\models\Reports */

$this->title = Yii::t('user', 'Update {modelClass}: ', [
    'modelClass' => 'Reports',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Reports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('user', 'Update');
?>
<div class="reports-update">

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
