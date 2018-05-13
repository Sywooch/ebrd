<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\plugins\models\Event */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('plugins', 'EVENTS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-view">
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
            'plugin_id',
            'trigger_class',
            'trigger_event',
            'handler_class',
            'handler_method',
            'data',
            'pos',
            'status',
        ],
    ]) ?>

</div>
