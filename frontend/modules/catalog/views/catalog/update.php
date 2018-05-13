<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\catalog\models\CatalogDocument */

$this->title = Yii::t('catalog', 'Update Catalog Document: {nameAttribute}', [
    'nameAttribute' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('catalog', 'Catalog Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('catalog', 'Update');
?>
<div class="catalog-document-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
