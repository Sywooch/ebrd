<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogEvent */

$this->title = 'Update Blog Event: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Blog Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="blog-event-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'languages' => $languages,
        'stakeholders' => $stakeholders
    ]) ?>

</div>
