<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\modules\blog\components\widgets\shortcodes_info\ClipboardJsWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserTokenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('user', 'User Tokens');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-token-index">

    <div class="main_block_class">
		<span class="main_action_title"><?= Html::encode($this->title) ?></span>
		<span class="main_action_class"><?= (Yii::$app->user->can('createItem')) ? Html::a(Yii::t('blog', 'CREATE_POST'), ['create'], ['class' => 'btn btn-success']) : ''?></span>
	</div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'layout'=>'<div class="grid_over">{items}</div>{pager}',
        'columns' => [
            'email',
			'vizit',
            'created_at',
            'updated_at',
			[
				'label'=>Yii::t('blog','TOKEN'),
				'contentOptions' => function ($model) {
					return ['id' => 'copy_'.$model->id];
				 },
				'value'=>function ($model) {
					 return $model->url.'?token='.$model->token;
				 },
			 ],
            [
				'class' => 'yii\grid\ActionColumn',
				'header' => Yii::t('forms', 'ACTIONS'),
				'template' => '{copy} {view} {update} {delete}',
				'buttons' => [
					'copy' => function ($url,$model){
						return ClipboardJsWidget::widget([
							'inputId' => '#copy_'.$model->id,
							'label' => 'Copy',
							'htmlOptions' => ['class' => 'btn'],
							'tag' => 'button', 
						]);
					},
				]
			],
        ],
    ]); ?>
</div>
