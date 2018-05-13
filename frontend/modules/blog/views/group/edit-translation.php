<?php

frontend\modules\blog\bundles\BlogModuleAsset::register($this);	

$this->title = Yii::t('blog', 'EDIT_TRANSLATION');
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'GROUPS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="trans_wrap target_trans_wrap" data-id='<?= $model->id ?>' data-url="/blog/group/save-translation">
	<h1><?= Yii::t('blog', 'EDIT_TRANSLATION'); ?></h1>
	<div class="trans_status"><?= Yii::t('blog', 'JUST_EDIT_TEXT_IN_RIGHT_COLUMN'); ?></div>
	<?= $this->render('../common/_publish', ['model' => $model]); ?>
	<div><?= Yii::t('blog', 'TARGET LANGUAGE - {lang} ({native_name})',
				[
					'lang' => $model->lang->name,
					'native_name' => $model->lang->native_name
				]) ?></div>
	<div class="row">
		<?php
		foreach ($transFields as $field){
			echo $this->render('../common/_trans-block', [
			'model'		=> $model,
			'field'		=> $field,
			'target'	=> TRUE
			]); 
		}?>	
	</div>
</div>
<?php
$messageEror = Yii::t('blog', 'SOMETHING WENT WORNG...');
$messageAwaiting = Yii::t('blog', 'WAITING_FOR_SYNCHRONIZATION_WITH_SERVER');

Yii::$app->view->registerJs('var messageError = "'. $messageEror.'"',  \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var messageAwaiting = "'. $messageAwaiting.'"',  \yii\web\View::POS_HEAD);

