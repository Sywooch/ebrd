<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RedirectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('blog', 'REDIRECTS');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="redirects-index">

    <div class="main_block_class">
		<span class="main_action_title"><?= Html::encode($this->title) ?></span>
		<span class="main_action_class"><?= (Yii::$app->user->can('createItem')) ? Html::a(Yii::t('blog', 'Create Redirects'), ['create'], ['class' => 'btn btn-success']) : ''?></span>
	</div>
	
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'layout'=>'<div class="grid_over">{items}</div>{pager}',
        'columns' => [
            'id',
			'old_url',
            'new_url',
            'created_at',
            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
