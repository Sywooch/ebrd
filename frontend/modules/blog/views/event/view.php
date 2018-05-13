<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogEvent */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Blog Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-event-view">

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
            'stakeholder_id',
            'lang_id',
            'alias',
            'title',
            'description:ntext',
            'site_url:url',
            'place',
            'date_begin',
            'date_end',
            'picture',
        ],
    ]) ?>

</div>
