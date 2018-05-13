<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lo\plugins\models\Plugin */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('plugins', 'ITEMS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-view">

    <p>
        <?= Html::a(Yii::t('plugins', 'UPDATE'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('plugins', 'DELETE'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('plugins', 'ARE YOU SURE YOU WANT TO DELETE THIS ITEM?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'url:url',
            'version',
            'text:ntext',
            'author',
            'author_url:url',
            'status',
        ],
    ]) ?>

</div>
