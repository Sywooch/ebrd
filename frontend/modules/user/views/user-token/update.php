<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserToken */

$this->title = Yii::t('user', 'Update User Token: {nameAttribute}', [
    'nameAttribute' => $model->email,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'User Tokens'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->email, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('user', 'Update');
?>
<div class="user-token-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
