<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogGroup */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'GROUPS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-group-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('blog', 'EDIT'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('blog', 'DELETE'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
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
			'url',
            [
				'label' => Yii::t('blog', 'LANGUAGE'),
				'value' => function ($model){
								return $model->lang->name;
							}
			],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
