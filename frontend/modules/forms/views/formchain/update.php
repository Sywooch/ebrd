<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\forms\models\FormChain */

$this->title = Yii::t('forms', 'Update {modelClass}: ', [
    'modelClass' => 'Form Chain',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('forms', 'Form Chains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('forms', 'Update');
?>
<div class="form-chain-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
