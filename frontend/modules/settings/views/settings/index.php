<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\settings\models\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('blog', 'SETTINGS');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-index">
	<div class="main_block_class">
		<span class="main_action_title"><?= Html::encode($this->title) ?></span>
		<span class="main_action_class"><?= Html::a('Create Settings', ['create'], ['class' => 'btn btn-success']) ?></span>
	</div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'layout'=>'<div class="grid_over">{items}</div>{pager}',
        'columns' => [
            'id',
            'name',
            'value',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
