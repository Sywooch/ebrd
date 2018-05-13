<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\modules\blog\components\widgets\shortcodes_info\ClipboardJsWidget;
use rmrevin\yii\fontawesome\FA;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\forms\models\FormChainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('forms', 'Form Chains');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-chain-index">
	<div class="main_block_class">
		<span class="main_action_title"><?= Html::encode($this->title) ?></span>
		<span class="main_action_class"><?= Html::a(Yii::t('forms', 'Create Form Chain'), ['create'], ['class' => 'btn btn-success']) ?></span>
	</div>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>
<?php Pjax::begin(); ?>   
<?= GridView::widget([
        'dataProvider' => $dataProvider,
		'layout'=>'<div class="grid_over">{items}</div>{pager}',
        'columns' => [
            'id',
            'name',
			'title',
			[
				'label' => Yii::t('blog', 'Forms'),
				'format' => 'raw',
				'value' => function($model) {
					$steps = $model::find()
					->select("steps")
					->where(['id' => $model->id])
					->asArray()
					->all();
					$steps = substr($steps[0]['steps'], (stripos($steps[0]['steps'],'['))+1);
					$steps = substr($steps, 0, stripos($steps,']'));
					$formsId = str_getcsv($steps, ',');
					$currentForms = frontend\modules\forms\models\Form::find()
					->select("id, name")
					->where(['id' => $formsId])
					->asArray()
					->all();
					$value = '';
					foreach ($currentForms as $forms) {
						$value .= Html::a($forms['name'],['/forms/form/update', 'id' => $forms['id']],['target' => '_blank', 'data-pjax'=>'0']). "<br> ";
					}
					return $value;
				},	
			],
            [
				'label'=>Yii::t('blog','URL'),
				'contentOptions' => function ($model) {
					return ['id' => 'copy_'.$model->id];
				 },
				'value'=>function ($model) {
					$lang = Yii::$app->language == Yii::$app->params['settings']['defaultLanguage'] ? '' : '/'.Yii::$app->language;
					$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'];
					return $url.$lang.'?showBrief='.$model->id.'&class=openBrief';
				 },
			 ],
            // 'created_at',
            // 'updated_at',

            [
				'class' => 'yii\grid\ActionColumn',
				'class' => 'yii\grid\ActionColumn',
				'header' => Yii::t('forms', 'ACTIONS'),
				'template' => '{copy} {view} {update} {delete}',
				'buttons' => [
					'copy' => function ($url,$model){
						return ClipboardJsWidget::widget([
							'inputId' => '#copy_'.$model->id,
							'label' => 'Copy',
							'htmlOptions' => ['class' => 'btn'],
							'tag' => 'button', 
						]);
					}
				]
			],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
