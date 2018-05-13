<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\modules\blog\models\BlogPost;

frontend\modules\blog\bundles\BlogModuleAsset::register($this);	

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\blog\models\BlogPostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('blog', 'POSTS');
$this->params['breadcrumbs'][] = $this->title;

$canTranslate = [];
foreach (Yii::$app->params['settings']['activeLangsObjs'] as $lang){
	if (Yii::$app->user->can('translate_' . $lang->code)){
			$canTranslate[] = $lang;
	}
}

$transltorColumn = [
	'header' => Yii::t('blog', 'TRANSLATIONS'),
	'value' => function($model) use ($canTranslate) {
		$res = '';
		foreach ($canTranslate as $lang){
			if ($model->lang_id !== $lang->id){
				$res .= Html::a($lang->code, ['translate', 'post' => $model->id, 'lang' => $lang->id], ['class' => 'btn btn-xs btn-primary']);
			}
		}
		return $res;
	},
	'format' => 'raw',
	'visible' => Yii::$app->user->can('translate')
];
?>
<div class="blog-post-index">

    <div class="main_block_class">
		<span class="main_action_title"><?= Html::encode($this->title) ?></span>
		<span class="main_action_class"><?= (Yii::$app->user->can('createItem')) ? Html::a(Yii::t('blog', 'CREATE_POST'), ['create'], ['class' => 'btn btn-success']) : ''?></span>
		<span class="main_search_class"><?= (Yii::$app->user->can('createItem')) ? Html::a(Yii::t('blog', 'SEARCH'), '#', ['class' => 'btn btn-primary blog_search_btn']) : ''?></span>
	</div>
	
	<div class="blog_search">
		<?= $this->render('_search', [
			'model' => $searchModel, 'items' => $items,
			'parent_search' => $parent_search,
			'statusSearch' => $statusSearch,
		]); ?>
	</div>
	
<?php Pjax::begin();?>   
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
		'layout'=>'{pager}<div class="grid_over">{items}</div>{pager}',
        'columns' => [
            'alias',
			'id',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('blog', 'ACTION'),
                'template' => '{view} {front-view} {publish} {delete} {update} {edit-translation}',
                'buttons' => [
                    'delete' => function($url, $model, $key){
                        $visible = Yii::$app->user->can('deleteItem');
                        $link = Html::a(FA::i('trash'), $url,
                            [
                                'title' => Yii::t('blog', 'DELETE ITEM'),
                                'data-confirm' => Yii::t('yii', 'ARE_YOU SHURE YOU WANT TO DELETE THIS ITEM?'),
                                'data-method' => 'post',
                            ]
                        );
                        return ($visible) ? $link : '';
                    },
                    'update' => function($url, $model, $key){
                        $visible = Yii::$app->user->can('editItem');
                        $link = Html::a(FA::i('cog'), $url,
                            [
                                'title' => Yii::t('user', 'UPDATE')
                            ]
                        );
                        return ($visible) ? $link : '';
                    },
                    'edit-translation' => function($url, $model, $key){
                        $visible = (Yii::$app->user->can('translate_' . $model->lang->code));
                        $link = Html::a(FA::i('pencil'), $url,
                            [
                                'title' => Yii::t('blog', 'EDIT TRANSLATION')
                            ]
                        );
                        return ($visible) ? $link : '';
                    },
                    'front-view' => function($url, $model, $key){
                        $visible = TRUE;
                        $link = Html::a(FA::i('eye'),
                            ['/blog/post/front-view', 'id' => $model->id],
                            [
                                'target' => '_blank',
                                'title' => Yii::t('blog', 'VIEW_AS_USER'),
                            ]
                        );
                        return ($visible) ? $link : '';
                    },
                    'view' => function($url, $model, $key){
                        $visible = (Yii::$app->user->can('publishItem'));
                        $link = Html::a(FA::i('th-list'), $url,
                            [
                                'title' => Yii::t('blog', 'VIEW_DETAILS')
                            ]);
                        return ($visible) ? $link : '';
                    },
                    'publish' => function($url, $model, $key){
                        $visible = (Yii::$app->user->can('publishItem'));
                        if ($model->status_id === BlogPost::STATUS_PUBLISHED) {
                            $link = Html::a(FA::i('minus-square', ['class' => 'error']),
                                ['update-status', 'id' => $model->id, 'status' => BlogPost::STATUS_UNPUBLISHED],
                                ['title' => Yii::t('blog', 'UNPUBLISH')]
                            );
                        } elseif($model->status_id === BlogPost::STATUS_FOR_CONFIRMATION){
                            $link = Html::a(FA::i('check', ['class' => 'success']),
                                ['update-status', 'id' => $model->id, 'status' => BlogPost::STATUS_PUBLISHED],
                                ['title' => Yii::t('blog', 'CONFIRM_PUBLICATION')]
                            );
                            $link .= Html::a(FA::i('close', ['class' => 'error']),
                                ['update-status', 'id' => $model->id, 'status' => BlogPost::STATUS_REJECTED_BY_PUBLISHER],
                                ['title' => Yii::t('blog', 'REJECT_PUBLICATION')]
                            );
                        } else {
                            $link = Html::a(FA::i('plus-square', ['class' => 'success']),
                                ['update-status', 'id' => $model->id, 'status' => BlogPost::STATUS_PUBLISHED],
                                ['title' => Yii::t('blog', 'PUBLISH')]
                            );
                        }

                        return ($visible) ? $link : '';
                    }
                ],
            ],
			'title',
			'menu_section',
            [
				'attribute' => 'code',
				'label' => Yii::t('blog', 'LANGUAGE'),
				'value' => function ($model){
								return $model->lang->name;
							}
			],
            [
				'attribute' => 'category',
				'label' => Yii::t('blog', 'MAIN_CATEGORY'),
				'value' => function ($model){
								return $model->category->name;
							}
			],
			[
				'attribute' => 'status',
				'label' => Yii::t('blog', 'STATUS'),
				'value' => function($model){
					if (!empty($model->status)){
						return Yii::t('blog', $model->status->name);							
					} else {
						return '';
					}
				}
			],
			$transltorColumn,
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
