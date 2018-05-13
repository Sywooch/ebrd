<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lo\plugins\models\Plugin */

$this->title = Yii::t('plugins', 'UPDATE {modelClass}: ', [
    'modelClass' => 'Item',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('plugins', 'ITEMS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('plugins', 'UPDATE');
?>
<div class="item-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
