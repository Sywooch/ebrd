<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use rmrevin\yii\fontawesome\FA;
use common\models\User;
use common\models\Invitation;
use yii\helpers\ArrayHelper;

frontend\modules\user\bundles\UserModuleAsset::register($this);
/* @var $model frontend\models\User */
/* @var $searchModel frontend\modules\user\models\UserSearch */
/* @var $statuses array */
/* @var $roles array */
$this->title = Yii::t('user', 'USER_MANAGER');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Yii::$app->cache->flush(); ?>
<div class="user-default-index">
	
	<div class="main_block_class">
		<span class="main_action_title"><?= Html::encode($this->title) ?></span>
		<span class="main_action_class"><?= Html::a(Yii::t('user', 'ADD_NEW_USER'), ['add-user'], ['class' => 'btn btn-success']) ?></span>
		<span class="main_search_class"><?= (Yii::$app->user->can('createItem')) ? Html::a(Yii::t('blog', 'SEARCH'), '#', ['class' => 'btn btn-primary blog_search_btn']) : ''?></span>
	</div>
	
	<?php Pjax::begin(); ?>
	<div class="blog_search">
		<?= $this->render('_search', [
			'model'		=> $searchModel,
			'statuses'	=> $statuses,
			'roles'		=> $roles,
			'teamSerach'=> $teamSerach,
		]); ?>
	</div>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'layout'=>'<div class="grid_over">{items}</div>{pager}',
		'columns' => [
			'id',
			'email',
			[
				'attribute' => 'team',
				'label'=>Yii::t('blog','TEAM'),
				'format' => 'raw',
				'value'=>function ($model) {
					$result = Yii::t('blog','NO_TEAM');
					if(!empty(Invitation::getUserTeamsById($model->id))){
						if(sizeof(Invitation::getUserTeamsById($model->id)) > 1){
							$result = '';
							foreach (Invitation::getUserTeamsById($model->id) as $team_obj){
								$result .= $team_obj->team->name.', ';
							}
						}else{
							$result = Invitation::getUserTeamsById($model->id)[0]->team->name;
						}
					}
					return $result;
				},
				'filter' => Html::activeDropDownList($searchModel, 'team', $teamSerach, ['prompt' => 'All'])
			],
			[
				'label'=>Yii::t('blog','FULL_NAME'),
				'format' => 'raw',
				'value'=>function ($model) {
					$name = Yii::t('blog','NO_PROFILE');
					if(!empty($model->profile)){
						if(!empty($name = $model->profile->full_name)){
							$name = $model->profile->full_name;
						}else{
							$name = Yii::t('blog','NOT_SET');
						}
					}
					return $name;
				},
			],		
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {edit-roles} {delete} {block} {unblock} {superuser}',
                'header' => Yii::t('blog', 'ACTION'),
                'buttons' => [
                    'edit-roles' => function($url, $model, $key){
                        if (($model->status_id === User::STATUS_ACTIVE) || ($model->status_id === User::STATUS_AWAITING_EMAIL_CONFIRMATION)){
                            return Html::a(FA::i('group'), $url,
                                [
                                    'title' => Yii::t('user', 'EDIT_MEMBERSHIP_IN_GROUPS'),
                                    'data' => [
                                        'method' => 'post'
                                    ]
                                ]);
                        } else {
                            return '';
                        }

                    },
                    'block' => function ($url, $model, $key){
                        if (($model->status_id !== User::STATUS_BLOCKED) && ($model->status_id !== User::STATUS_DELETED)) {
                            $icon = '<i class="fa fa-lock" aria-hidden="true"></i>';
                            return Html::a($icon, $url, [
                                'title' => Yii::t('user', 'BLOCK'),
                            ]);
                        }
                    },
                    'unblock' => function ($url, $model, $key){
                        if ($model->status_id === User::STATUS_BLOCKED) {
                            $icon = '<i class="fa fa-unlock" aria-hidden="true"></i>';
                            return Html::a($icon, $url, [
                                'title' => Yii::t('user', 'UNBLOCK'),
                            ]);
                        }
                        return '';
                    },
                    'delete' => function ($url, $model, $key){
                        if ($model->status_id !== common\models\User::STATUS_DELETED){
                            return Html::a(
                                FA::i('trash'),
                                $url,
                                [
                                    'title' => Yii::t('user', 'DELETE USER'),
                                    'data' => [
                                        'confirm' => Yii::t('user', 'ARE YOU SHURE YOU WANT TO DELETE PROFILE'),
                                        'method' => 'post',
                                    ]
                                ]);
                        }
                        return '';
                    },
                    'superuser' => function($url, $model, $key){
                        if ((Yii::$app->user->can('manageSuperusers')) && ($model->status_id !== common\models\User::STATUS_DELETED)){
                            $userRoles = \yii\helpers\ArrayHelper::map($model->roles, 'item_name', 'item_name');
                            if (array_key_exists('superuser', $userRoles)){
                                return Html::a(FA::i('arrow-circle-down'), $url,
                                    [
                                        'title' => Yii::t('user', 'REVOKE ROLE SUPERUSER'),
                                        'data' => [
                                            'method' => 'post'
                                        ]
                                    ]);
                            } else {
                                return Html::a(FA::i('arrow-circle-up'), $url,
                                    [
                                        'title' => Yii::t('user', 'ADD ROLE SUPERUSER'),
                                        'data' => [
                                            'method' => 'post'
                                        ]
                                    ]);
                            }
                        }

                        return '';

                    },
                    'view' => function ($model, $key){
						if(!empty($key->profile)){
							return Html::a(FA::i('pencil'), ['/user/profile/settings','id' => $key->id], ['title' => Yii::t('user', 'VIEW USER')]);
						}else{
							return false;
						}
                    }
                ]
            ],
			[
				'attribute' => 'role',
				'value' => function($model){
					$str = '';
					foreach ($model->roles as $role){
						$str .= "<span class='us_group'>$role->item_name</span>";
					}
					return $str;
				},
				'format' => 'raw',
				'filter' => Html::activeDropDownList($searchModel, 'role', ArrayHelper::map($roles, 'name', 'name'), ['prompt' => 'All'])
			],
			[
				'attribute' => 'status',
				'value' => function($model){
					return '<span id="us_status_' . $model->id . '">' . Yii::t('user', $model->status->name) .'</span>';
				},
				'format' => 'raw',
				'filter' => Html::activeDropDownList($searchModel, 'status_id', $statuses, ['prompt' => 'All'])
			],
			//'last_login',
		]
	]); ?>
	<?php Pjax::end(); ?>
</div>