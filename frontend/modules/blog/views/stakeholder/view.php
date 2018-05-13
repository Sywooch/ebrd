<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogStakeholder */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Blog Stakeholders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-stakeholder-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'logo',
            'mail',
            'phone',
            'group_id',
            'location',
            'description:ntext',
        ],
    ]) ?>

</div>
