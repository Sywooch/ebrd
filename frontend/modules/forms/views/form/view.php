<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\forms\models\Form */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('forms', 'Forms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-view">

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
            'answer:ntext',
            'mail_to:ntext',
            'fields:ntext',
            'rules:ntext',
            'submit:ntext',
			'script_on_submit:ntext',
            'extra_actions:ntext',
            'action',
            'method',
            'class',
            'form_id',
			'hubspot_form_guid',
        ],
    ]) ?>

</div>
