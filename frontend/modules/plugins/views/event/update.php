<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\plugins\models\Event */

$this->title = Yii::t('plugins', 'UPDATE {modelClass}: ', [
    'modelClass' => 'Event',
]) . ' ' . $model->plugin->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('plugins', 'EVENTS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('plugins', 'UPDATE');
?>
<div class="event-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
