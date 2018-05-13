<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use frontend\modules\blog\models\BlogCategory;
use leandrogehlen\treegrid\TreeGrid;
use rmrevin\yii\fontawesome\FA;

frontend\modules\blog\bundles\BlogModuleAsset::register($this);
/* @var $model frontend\modules\blog\models\BlogCategory */
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\blog\models\BlogCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('blog', 'CATEGORIES');
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
		if ($model->parent_category_id > 0 ){
			$res = '';
			foreach ($canTranslate as $lang){
				if ($model->lang_id !== $lang->id){
					$res .= Html::a($lang->code, ['translate', 'cat' => $model->id, 'lang' => $lang->id], ['class' => 'btn btn-xs btn-primary']);
				}
			}
			return $res;
		} else {
			return '';
		}
	},
	'format' => 'raw',
	'visible' => Yii::$app->user->can('translate')
];
?>
<div class="blog-category-index">

	<div class="main_block_class">
		<span class="main_action_title"><?= Html::encode($this->title) ?></span>
		<span class="main_action_class"><?= (Yii::$app->user->can('createItem')) ? Html::a(Yii::t('blog', 'CREATE_CATEGORY'), ['create'], ['class' => 'btn btn-success']) : ''?></span>
		<span class="main_search_class"><?= (Yii::$app->user->can('createItem')) ? Html::a(Yii::t('blog', 'SEARCH'), '#', ['class' => 'btn btn-primary blog_search_btn']) : ''?></span>
	</div>
	
	<div class="blog_search">
		<?= $this->render('_search', [
			'model' => $searchModel,
			'items' => $items,
			'parentSearch' => $parentSearch,
			'groupSearch' => $groupSearch,
			'statusSearch' => $statusSearch,
		]); ?>
	</div>

<?php Pjax::begin(); ?>
	<div class="grid-view ">
		<div class="grid_over_category">
			<?= 	
			TreeGrid::widget([
				'dataProvider' => $dataProvider,
				'keyColumnName' => 'id',
				'parentColumnName' => 'parent_category_id',
				//'parentRootValue' => '0',
				'pluginOptions' => [
					//'initialState' => 'collapsed',
				],
				'columns' => [
					'name',
					'id',
					[
						'class' => 'yii\grid\ActionColumn',
						'header' => Yii::t('blog', 'ACTION'),
						'template' => '{view} {front-view} {publish} {delete} {update} {edit-translation}',
						'buttons' => [
							'delete' => function($url, $model, $key){
								$visible = (!$model->hasSubitems()) &&
									($model->parent_category_id !== 0) &&
									Yii::$app->user->can('deleteItem');
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
								$visible = ($model->parent_category_id > 0) && (Yii::$app->user->can('editItem'));
								$link = Html::a(FA::i('cog'), $url,
									[
										'title' => Yii::t('user', 'UPDATE')
									]
								);
								return ($visible) ? $link : '';
							},
							'edit-translation' => function($url, $model, $key){
								$visible = (Yii::$app->user->can('translate_' . $model->lang->code)) &&
									($model->parent_category_id > 0);
								$link = Html::a(FA::i('pencil'), $url,
									[
										'title' => Yii::t('blog', 'EDIT TRANSLATION')
									]
								);
								return ($visible) ? $link : '';
							},
							'front-view' => function($url, $model, $key){
								$visible = ($model->parent_category_id !== 0);
								$link = Html::a(FA::i('eye'),
									['/blog/category/front-view', 'id' => $model->id],
									[
										'target' => '_blank',
										'title' => Yii::t('blog', 'VIEW_AS_USER'),
									]
								);
								return ($visible) ? $link : '';
							},
							'view' => function($url, $model, $key){
								$visible = (Yii::$app->user->can('publishItem'));
								$link = Html::a(FA::i('th-list'), $url, [
									'title' => Yii::t('blog', 'VIEW_DETAILS')
								]);
								return ($visible) ? $link : '';
							},
							'publish' => function($url, $model, $key){
								$visible = (Yii::$app->user->can('publishItem')) && ($model->parent_category_id > 0);
								if ($model->status_id === BlogCategory::STATUS_PUBLISHED) {
									$link = Html::a(FA::i('minus-square', ['class' => 'error']),
										['update-status', 'id' => $model->id, 'status' => BlogCategory::STATUS_UNPUBLISHED],
										['title' => Yii::t('blog', 'UNPUBLISH')]
									);
								} elseif($model->status_id === BlogCategory::STATUS_FOR_CONFIRMATION){
									$link = Html::a(FA::i('check', ['class' => 'success']),
										['update-status', 'id' => $model->id, 'status' => BlogCategory::STATUS_PUBLISHED],
										['title' => Yii::t('blog', 'CONFIRM_PUBLICATION')]
									);
									$link .= Html::a(FA::i('close', ['class' => 'error']),
										['update-status', 'id' => $model->id, 'status' => BlogCategory::STATUS_REJECTED_BY_PUBLISHER],
										['title' => Yii::t('blog', 'REJECT_PUBLICATION')]
									);
								} else {
									$link = Html::a(FA::i('plus-square', ['class' => 'success']),
										['update-status', 'id' => $model->id, 'status' => BlogCategory::STATUS_PUBLISHED],
										['title' => Yii::t('blog', 'PUBLISH')]
									);
								}

								return ($visible) ? $link : '';
							}
						],
					],
					'alias',
					[
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
						'label' => Yii::t('blog', 'GROUP'),
						'value' => function ($model) {
							return (!empty($model->group->name)) ? $model->group->name : '';
						}
					],
					[
						'label' => Yii::t('blog', 'LANGUAGE'),
						'value' => function ($model) {
							return $model->lang->name;
						}
					],
					[
						'label' => Yii::t('blog', 'PARENT_CATEGORY'),
						'value' => function ($model) {
							return ($model->parent_category_id > 0) ? $model->parent->name : '';
						}
					],
					$transltorColumn,
				]
			]);
			?>
		</div>
	</div>
<?php Pjax::end(); ?></div>	
</div>

