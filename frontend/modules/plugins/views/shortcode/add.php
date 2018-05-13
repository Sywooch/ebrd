<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\notes\models\NotesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Add');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shortcode-add">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_add_form',[
        'model' => $model,
    ]) ?>

<?php Pjax::begin(['id' => 'add-container']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

			'shortcode_id',
			[
                'attribute' => 'tag',
                'label' => Yii::t('plugins', 'TAG'),
                'content' => function($model) {
                    return '<pre>' . $model->tag . '</pre>';
                },
            ],
            'description',
            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {delete}',
				'buttons'  => [
				
					'delete' => function ($url, $model) {
						$url = Url::to(['/plugins/shortcode/shortcode-info-delete', 'id' => $model->id]);
						return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => 'delete']);
					},
					'update' => function ($url, $model) {
						$url = Url::to(['/plugins/shortcode/shortcode-info-update', 'id' => $model->id]);
						return Html::a('<span class="fa fa-cog"></span>', $url, ['title' => 'update']);
					},
				],
			],
        ],
    ]); ?>
<?php Pjax::end() ?>

</div>