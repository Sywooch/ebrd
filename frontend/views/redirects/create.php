<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Redirects */

$this->title = Yii::t('user', 'Create Redirects');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Redirects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="redirects-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
