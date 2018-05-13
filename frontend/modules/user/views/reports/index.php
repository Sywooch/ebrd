<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use frontend\modules\user\models\MapTeamUserReport;
use common\models\CabinetHdbkReportType;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('user', 'REPORTS');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reports-index">
	<div class="main_block_class">
		<span class="main_action_title"><?= Html::encode($this->title) ?></span>
		<span class="main_action_class"><?= Html::a(Yii::t('blog', 'CREATE_REPORT'), ['create'], ['class' => 'btn btn-success']) ?></span>
		<span class="main_search_class"><?= (Yii::$app->user->can('createItem')) ? Html::a(Yii::t('blog', 'SEARCH'), '#', ['class' => 'btn btn-primary blog_search_btn']) : ''?></span>
	</div>
	
<?php Pjax::begin(); ?>   
	<div class="blog_search">
		<?= $this->render('_search', [
				'model'		=> $searchModel,
				'teamSerach'=> $teamSerach,
				'typeSearch'=> $typeSearch,
			]);
		?>
	</div>
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
		'layout'=>'<div class="grid_over">{items}</div>{pager}',
        'columns' => [
            'id',
            [
				'label'=>Yii::t('blog','NAME'),
				'format' => 'raw',
				'value'=>function ($model, $url) {
					 return Html::a($model->name, Url::to(['/user/reports/view', 'id' => $url]));
				 },
			 ],
			[
				'header' => Yii::t('blog', 'User Mail'),
				'value' => function($model) {
					if(!empty(MapTeamUserReport::getReportsForUser($model->id))){
						return MapTeamUserReport::getReportsForUser($model->id);
					}elseif(empty(MapTeamUserReport::getReportsForTeam($model->id)) && empty(MapTeamUserReport::getReportsForUser($model->id))){
						return Yii::t('blog', 'OPEN_ACCESS');
					}else{
						return '------>';
					}
				}
			],
			[
				'attribute' => 'team',
				'header' => Yii::t('blog', 'TEAM'),
				'value' => function($model) {
					if(!empty(MapTeamUserReport::getReportsForTeam($model->id))){
						return MapTeamUserReport::getReportsForTeam($model->id);
					}elseif(empty(MapTeamUserReport::getReportsForTeam($model->id)) && empty(MapTeamUserReport::getReportsForUser($model->id))){
						return Yii::t('blog', 'OPEN_ACCESS');
					}else{
						return '<------';
					}
				}
			],	
			[
				'attribute' => 'type',
				'header' => Yii::t('blog', 'TYPE'),
				'value' => function($model) {
					return Yii::t('blog', CabinetHdbkReportType::getEmailNameByType($model->type_id)->name);
				}
			],
            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
