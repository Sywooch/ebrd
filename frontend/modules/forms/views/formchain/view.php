<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\forms\models\FormChain */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('forms', 'Form Chains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-chain-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('forms', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('forms', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('forms', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'title',
            'description:ntext',
            'steps:ntext',
            'answer:ntext',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
