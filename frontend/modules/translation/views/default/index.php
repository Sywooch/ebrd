<?php

use frontend\modules\translation\bundles\TranslationModuleAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = Yii::t('translation', 'TRANSLATIONS_MANAGER');
$this->params['breadcrumbs'][] = $this->title;
TranslationModuleAsset::register($this);
?>
<div class="traslations_wrapp">
	<div class="main_block_class">
		<span class="main_action_title"><?= Html::encode($this->title) ?></span>
		<span class="main_action_class"><?= Html::a(Yii::t('translation', 'ADD_TRANSLATION'),['/translation/default/create'] , ['class' => 'btn btn-success']); ?></span>
		<span class="main_search_class"><?= (Yii::$app->user->can('createItem')) ? Html::a(Yii::t('blog', 'SEARCH'), '#', ['class' => 'btn btn-primary blog_search_btn']) : ''?></span>
	</div>
	<div class="simple_lang_filter hide">
		<?php
		 foreach ($languages as $lang){
		?>
			<?= Html::button($lang->code, [
				'class' => 'btn btn-success hide_lang',
				'data-lang' => $lang->code
				]) ?>
		<?php
		 }
		?>		
	</div>
	<div class="translations_search">
		<div class="blog_search">
			<?php $form = ActiveForm::begin([
				'action' => ['index'],
				'method' => 'get',
				'layout' => 'inline',
				'options' => ['id' => 'trans_search_form']
			]); ?>

			<?= $form->field($searchModel, 'category')->dropDownList($searchModel->categoriesList, ['prompt' => Yii::t('translation', 'ALL_CATEGORIES')]); ?>
			<?= $form->field($searchModel, 'message')->textInput(['placeholder' => Yii::t('translation', 'MESSAGE')]); ?>
			<?= $form->field($searchModel, 'searchText')->textInput(['placeholder' => Yii::t('translation', 'TRANSLATION_TEXT')]); ?>


			<div class="form-group">
				<?= Html::submitButton(Yii::t('translation', 'SEARCH'), ['class' => 'btn btn-primary']) ?>
				<?= Html::a(Yii::t('translation', 'RESET'), ['reset-filter', 'target' => 'translation'], [
						'class' => 'btn btn-default',
						'id' => 'trans_search_reset'
					]) ?>
			</div>

			<?php ActiveForm::end(); ?>
		</div>
	</div>
	<div class="translations_head">
		<div class="trh_numb">#</div>
		<div class="trh_cat"><?= Yii::t('translation', 'CATEGORY'); ?></div>
		<div class="trh_const"><?= Yii::t('translation', 'MESSAGE'); ?></div>
		<div class="trh_trans"><?= Yii::t('translation', 'TRANSLATION'); ?></div>
		<div class="trh_acts"><?= Yii::t('translation', 'ACTIONS'); ?></div>
	</div>
	<?php
	echo ListView::widget([
		'dataProvider' => $dataProvider,
		'layout'=>'<div class="grid_over_translation">{items}</div>{pager}',
		'itemView' => '_line',
		'summary' => FALSE,
		'viewParams' => ['languages' => $languages],
		'options' => ['class' => 'trans_lv_block'],
	]);
?>
</div>