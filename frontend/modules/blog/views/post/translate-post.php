<?php

use yii\helpers\Html;

frontend\modules\blog\bundles\BlogModuleAsset::register($this);	

$this->title = Yii::t('blog', 'TRANSLATE');
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'POSTS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

/* @var $source frontend\modules\blog\models\BlogPost */
/* @var $target frontend\modules\blog\models\BlogPost */

?>

<div class="trans_wrap" >
	<h1><?= Yii::t('blog', 'POST_TRANSLATION'); ?></h1>
	<div class="trans_status"><?= Yii::t('blog', 'JUST_EDIT_TEXT_IN_RIGHT_COLUMN'); ?></div>
	<?= $this->render('../common/_publish', ['model' => $target]); ?>
	<div class="view_draft"><?= Html::a(
		Yii::t('blog', 'VIEW_IN_FRONTEND'),
		['/blog/post/front-view', 'id' => $target->id],
		[
			'class' => 'btn btn-primary',
			'target' => '_blank',
		]
		) ?></div>
	<div class="row">
		<div class="col-md-6 source_trans_wrap" data-id='<?= $source->id ?>'>
			<div><?= Yii::t('blog', 'SOURCE LANGUAGE - {lang} ({native_name})',
				[
					'lang' => $source->lang->name,
					'native_name' => $source->lang->native_name
				]) ?></div>
			<?php
			 foreach ($transFields as $field){
				echo $this->render('../common/_trans-block', [
					'model'		=> $source,
					'field'		=> $field,
					'target'	=> FALSE
				]); 
			 }?>
		</div>
		<div class="col-md-6 target_trans_wrap" id="trans_target" data-id="<?= $target->id ?>" data-url="/blog/post/save-translation">
			
			<div><?= Yii::t('blog', 'TARGET LANGUAGE - {lang} ({native_name})',
				[
					'lang' => $target->lang->name,
					'native_name' => $target->lang->native_name
				]) ?></div>
			<?php
			 foreach ($transFields as $field){
				echo $this->render('../common/_trans-block', [
					'model'		=> $target,
					'field'		=> $field,
					'target'	=> TRUE
				]); 
			 }?>	
		</div>
	</div>
</div>
<?php
$messageEror = Yii::t('blog', 'SOMETHING WENT WORNG...');
$messageAwaiting = Yii::t('blog', 'WAITING_FOR_SYNCHRONIZATION_WITH_SERVER');

Yii::$app->view->registerJs('var messageError = "'. $messageEror.'"',  \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var messageAwaiting = "'. $messageAwaiting.'"',  \yii\web\View::POS_HEAD);

