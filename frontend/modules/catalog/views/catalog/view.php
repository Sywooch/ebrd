<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\catalog\models\CatalogDocument */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('catalog', 'Catalog Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-document-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('catalog', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('catalog', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('catalog', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'client_id',
            'country_id',
            'contract_number',
            'contract_date',
            'industry_id',
            'doc_type_id',
            'period_start_date',
            'period_end_date',
            'document_description:ntext',
            'file:ntext',
        ],
    ]) ?>

</div>
