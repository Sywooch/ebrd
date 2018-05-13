<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\modules\blog\components\widgets\shortcodes_info\ClipboardJsWidget;

/* @var $this yii\web\View */
/* @var $model common\models\UserToken */

$this->title = $model->email;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'User Tokens'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-token-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('user', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('user', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('user', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
		<?=
			ClipboardJsWidget::widget([
				'inputId' => '#copy_'.$model->id,
				'label' => 'Copy',
				'htmlOptions' => ['class' => 'btn'],
				'tag' => 'button', 
			]);
		?>
    </p>

    <?= DetailView::widget([
        'model' => $model, 
        'attributes' => [
            'email',
            [
				'label'=>Yii::t('blog','TOKEN'),
				'value'=>function ($model) {
					 return $model->url.'?token='.$model->token;
				 },
				'contentOptions' => ['id' => 'copy_'.$model->id],
			 ],
			'vizit',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
