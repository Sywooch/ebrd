<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\letter\models\Letter */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'LETTERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="letter-view">

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
            'content:ntext',
            'title',
            'keywords',
            [
                'label' => Yii::t('blog', 'LANGUAGE'),
                'value' => $model->lang->name
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
