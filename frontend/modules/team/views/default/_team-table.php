<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use frontend\modules\team\models\Team;
use yii\helpers\Url;


rmrevin\yii\fontawesome\AssetBundle::register($this);

/* @var $data frontend\modules\team\models\Invitation */

Pjax::begin([	
	'enablePushState' => FALSE,
	'id' => 'pj_team_table'
]);

echo '<div class="team_table_flexing">';

echo '<div class="lab_ry">'.Yii::t('user', 'TEAM_MEMBERS').'</div>';

echo Html::a('<i class="fa fa-refresh"></i>'.Yii::t('blog','REFRESH'), '', [
			'class' => 'btn btn-primary btn-xs refresh_btn',
			'id'	=> 'refresh_table_btn',
			'title' => Yii::t('user', 'REFRESH_TABLE'),
			]);
echo '</div>';
$model->pagination->pageSize = 10;
if ($model->totalCount > 0) {
echo '<div class="users_report_important">';
	echo GridView::widget([
		'dataProvider' => $model,
		'summary' => FALSE,
		'layout'=>'<div class="grid_over_team">{items}</div>{pager}',
		'options' => [
			'id' => 'team_table_grid'
		],
		'columns' => [
			[
				'label'=>Yii::t('blog','Email'),
				'attribute' => 'invited.email',
				'format' => 'raw',
				'value'=>function ($model) {
					if(!empty($model->invited->profile)){
						return Html::a($model->email, Url::to(['/user/profile', 'id' => $model->invited_id]),['class' => 'link_report']);
					}else{
						return '<span>'.$model->email.'</span>';
					}
				 },
			],
			[
				'label'=>Yii::t('blog','FULL_NAME'),
				'attribute' => 'profile.full_name',
				'format' => 'raw',
				'value'=>function ($model) {
					$name = Yii::t('blog','NO_PROFILE');
					if(!empty($model->invited->profile)){
						if(!empty($name = $model->invited->profile->full_name)){
							$name = $model->invited->profile->full_name;
						}else{
							$name = Yii::t('blog','NOT_SET');
						}
					}
					return $name;
				},
			],
			[
				'label'=>Yii::t('blog','STATUS'),
				'attribute' => 'invitationStatus.name',
				'headerOptions' => [
					'class' => 'column_status',
				],
				'value' => function($data){
					return Yii::t('blog', $data->invitationStatus->name);
				},
				'contentOptions' => function($data){return ['id' => 'status_name_' . $data->id, 'class' => 'column_status'];},
			],
			[
				'attribute' => 'created_at',
				'label'=>Yii::t('blog','CREATED_AT'),
				'value'=>function ($model) {
					return date('d.m.Y',strtotime($model->created_at));
				 },
			 ],
			[
				'label' => Yii::t('blog', 'ACTION'),
				'headerOptions' => [
					'class' => 'column_action',
				],
				'visible' => $vis = (empty(Team::userIsAdmin())) ? FALSE : TRUE,
				'value' => function ($data){
					$act = $data->getActionButtons();

					return $act;
				},
				'format' => 'raw',
				'contentOptions' => function($data){
					return [
						'class' => 'team_tbl_act_col',
						'id' => 'action_' . $data->id,
						'class' => 'column_action',
						];
				},
			],
		],
	]);
echo '</div>';
} else { ?>
	<div><?= Yii::t('user', 'YOU_HAVE_NO_MEMBERS_IN_YOUR_TEAM') ?></div>
<?php }

Pjax::end();