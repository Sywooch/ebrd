<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\letter\models\LetterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('blog', 'LETTERS');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="letter-index">
	<div class="main_block_class">
		<span class="main_action_title"><?= Html::encode($this->title) ?></span>
		<span class="main_action_class"><?= Html::a('Create Letter', ['create'], ['class' => 'btn btn-success']) ?></span>
	</div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'layout'=>'<div class="grid_over">{items}</div>{pager}',
        'columns' => [
            'id',
            'name',
            ['class' => 'yii\grid\ActionColumn'],
            'content:ntext',
            'title',
            'keywords',
            [
                'label' => Yii::t('blog', 'LANGUAGE'),
                'value' => function ($model){
                    return $model->lang->name;
                }
            ],
            'created_at',
            // 'updated_at',
        ],
    ]); ?>
</div>
