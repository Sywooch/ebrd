<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\modules\blog\models\BlogGroup;
use rmrevin\yii\fontawesome\FA;

frontend\modules\blog\bundles\BlogModuleAsset::register($this);	
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\blog\models\BlogGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('blog', 'GROUPS');
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
					$res .= Html::a($lang->code, ['translate', 'id' => $model->id, 'lang' => $lang->id], ['class' => 'btn btn-xs btn-primary']);
				}
			}
			return $res;
	},
	'format' => 'raw',
	'visible' => Yii::$app->user->can('translate')
];

?>
<div class="blog-group-index">

	<div class="main_block_class">
		<span class="main_action_title"><?= Html::encode($this->title) ?></span>
		<span class="main_action_class"><?= (Yii::$app->user->can('createItem')) ? Html::a(Yii::t('blog', 'CREATE BLOG GROUP'), ['create'], ['class' => 'btn btn-success']) : ''?></span>
		<span class="main_search_class"><?= (Yii::$app->user->can('createItem')) ? Html::a(Yii::t('blog', 'SEARCH'), '#', ['class' => 'btn btn-primary blog_search_btn']) : ''?></span>
	</div>
	
    <?php Pjax::begin(); ?>
	<div class="blog_search">
		<?= $this->render('_search', [
			'model' => $searchModel,
			'statusSearch' => $statusSearch,
			'languageSearch' => $languageSearch
		]); ?>
	</div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'layout'=>'<div class="grid_over">{items}</div>{pager}',
        'columns' => [
            'id',
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('blog', 'ACTION'),
                'template' => '{view} {publish} {delete} {update} {edit-translation}',
                'buttons' => [
                    'delete' => function($url, $model, $key){
                        $visible = Yii::$app->user->can('deleteItem');
                        $en_lang = !empty(Yii::$app->language['value'])?Yii::$app->language['value']:Yii::$app->language;
                        $action_url = $en_lang === Yii::$app->params['settings']['defaultLanguage']?'':'/'.$en_lang;
                        $link = Html::a(FA::i('trash'), $action_url.'/blog/group/delete?id='.$model->id,
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
                        $en_lang = !empty(Yii::$app->language['value'])?Yii::$app->language['value']:Yii::$app->language;
                        $action_url = $en_lang === Yii::$app->params['settings']['defaultLanguage']?'':'/'.$en_lang;
                        $link = Html::a(FA::i('cog'), $action_url.'/blog/group/update?id='.$model->id,
                            [
                                'title' => Yii::t('user', 'UPDATE')
                            ]
                        );
                        return ($visible) ? $link : '';
                    },
                    'edit-translation' => function($url, $model, $key){
                        $visible = (Yii::$app->user->can('translate_' . $model->lang->code));
                        $en_lang = !empty(Yii::$app->language['value'])?Yii::$app->language['value']:Yii::$app->language;
                        $action_url = $en_lang === Yii::$app->params['settings']['defaultLanguage']?'':'/'.$en_lang;
                        $link = Html::a(FA::i('pencil'), $action_url.'/blog/group/edit-translation?id='.$model->id,
                            [
                                'title' => Yii::t('blog', 'EDIT TRANSLATION')
                            ]
                        );
                        return ($visible) ? $link : '';
                    },
                    'view' => function($url, $model, $key){
                        $visible = (Yii::$app->user->can('publishItem'));
                        $en_lang = !empty(Yii::$app->language['value'])?Yii::$app->language['value']:Yii::$app->language;
                        $action_url = $en_lang === Yii::$app->params['settings']['defaultLanguage']?'':'/'.$en_lang;
                        $link = Html::a(FA::i('th-list'), $action_url.'/blog/group/view?id='.$model->id, [
                            'title' => Yii::t('blog', 'VIEW_DETAILS')
                        ]);
                        return ($visible) ? $link : '';
                    },
                    'publish' => function($url, $model, $key){
                        $visible = (Yii::$app->user->can('publishItem'));
                        if ($model->status_id === BlogGroup::STATUS_PUBLISHED) {
                            $link = Html::a(FA::i('minus-square', ['class' => 'error']),
                                ['update-status', 'id' => $model->id, 'status' => BlogGroup::STATUS_UNPUBLISHED],
                                ['title' => Yii::t('blog', 'UNPUBLISH')]
                            );
                        } elseif($model->status_id === BlogGroup::STATUS_FOR_CONFIRMATION){
                            $link = Html::a(FA::i('check', ['class' => 'success']),
                                ['update-status', 'id' => $model->id, 'status' => BlogGroup::STATUS_PUBLISHED],
                                ['title' => Yii::t('blog', 'CONFIRM_PUBLICATION')]
                            );
                            $link .= Html::a(FA::i('close', ['class' => 'error']),
                                ['update-status', 'id' => $model->id, 'status' => BlogGroup::STATUS_REJECTED_BY_PUBLISHER],
                                ['title' => Yii::t('blog', 'REJECT_PUBLICATION')]
                            );
                        } else {
                            $link = Html::a(FA::i('plus-square', ['class' => 'success']),
                                ['update-status', 'id' => $model->id, 'status' => BlogGroup::STATUS_PUBLISHED],
                                ['title' => Yii::t('blog', 'PUBLISH')]
                            );
                        }

                        return ($visible) ? $link : '';
                    }
                ],
            ],
			'title',
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
			[
				'attribute' => 'code',
				'value'		=> 'lang.code'
			],
            'updated_at',
			$transltorColumn,
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
