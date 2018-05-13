<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use rmrevin\yii\fontawesome\FA;
use frontend\modules\forms\models\Form;
use frontend\modules\blog\components\widgets\shortcodes_info\ClipboardJsWidget;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\forms\models\FormSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('forms', 'Forms');
$this->params['breadcrumbs'][] = $this->title;
$formsProvider = $dataProvider;
$formsProvider->pagination->pageSize = 10;
?>
<div class="form-index">
	<div class="main_block_class">
		<span class="main_action_title"><?= Html::encode($this->title) ?></span>
		<span class="main_action_class"><?= Html::a(Yii::t('forms', 'Create Form'), ['create'], ['class' => 'btn btn-success']) ?></span>
	</div>
	<?php  //echo $this->render('_search', ['model' => $searchModel]); ?>
<?php Pjax::begin();?>
	<?= GridView::widget([
		'dataProvider' => $formsProvider,
		'layout'=>'{pager}<div class="grid_over">{items}</div>{pager}',
        'columns' => [
            'id',
            'name',
            'title',
            [
				'label'=>Yii::t('blog','URL'),
				'contentOptions' => function ($model) {
					return ['id' => 'copy_'.$model->id];
				 },
				'value'=>function ($model) {
					$lang = Yii::$app->language == Yii::$app->params['settings']['defaultLanguage'] ? '' : '/'.Yii::$app->language;
					$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'];
					return $url.$lang.'?showForm='.$model->id;
				 },
			 ],
            // 'mail_to:ntext',
            // 'fields:ntext',
            // 'rules:ntext',
            // 'submit:ntext',
            // 'extra_actions:ntext',
            // 'action',
            // 'method',
            // 'class',
            // 'form_id',

            [
				'class' => 'yii\grid\ActionColumn',
				'header' => Yii::t('forms', 'ACTIONS'),
				'template' => '{copy} {view} {update} {delete} {submits} {constants}',
				'buttons' => [
					'copy' => function ($url,$model){
						return ClipboardJsWidget::widget([
							'inputId' => '#copy_'.$model->id,
							'label' => 'Copy',
							'htmlOptions' => ['class' => 'btn'],
							'tag' => 'button', 
						]);
					},
					'submits' => function ($url, $model, $key){
						$visible = Yii::$app->user->can('editItem');
						$link = Html::a(FA::i('th-list'), $url);
						return ($visible) ? $link : '';
					},
					'constants' => function ($url, $model, $key){
					    $keywords = [];
                        $fields = Form::findOne($model->id)->fields;
                        $fields = json_decode($fields);
                        foreach ($fields as $field) {
                            $keywords[] = $field->label;
                        }
                        return Html::a(FA::i('language'),
                            ['/translation/default/index', 'SearchSourceMessage' => ['category' => 'forms', 'keywords' => $keywords, 'searchText' => '', 'message' => ''  ]],
                            ['title' => Yii::t('plugins', "Constants"), 'target' => '_blank']);
                    }
				]
			],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
