<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Redirects */

$this->title = Yii::t('user', 'Update {modelClass}: ', [
    'modelClass' => 'Redirects',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Redirects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('user', 'Update');
?>
<div class="redirects-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
