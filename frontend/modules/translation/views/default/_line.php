<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use rmrevin\yii\fontawesome\FA;

?>
<div class="trans_block">
	<div class="trans_numb">
		<?= $model->id ?>
	</div>
	<div class="trans_cat">
		<?= $model->category ?>
	</div>
	<div class="trans_message">
		<?= $model->message ?>
	</div>
	<div class="trans_translations">
		<?php
		 foreach ($languages as $lang){
			$translation = FALSE;
			foreach ($model->messages as $k => $m){
				if ($m->language === $lang->code){
					$translation = $m;
				}		
			}
		?>
		<div class="trans_line trble <?= $lang->code ?>" data-lang="<?= $lang->code ?>" data-id="<?= $model->id ?>">
			<div class="trans_lang"><?= $lang->code ?> => </div>
			<div class="trans_item trline"><?= ($translation) ? $translation->translation : Yii::t('app', 'NO_TRANSLATION'); ?></div>
			<div class="edit_translation">
				<i class="glyphicon glyphicon-pencil edit_ico"></i>
				<i class="glyphicon glyphicon-floppy-disk save_ico"></i>
			</div>
		</div>
		<?php	
		 }
		?>
	</div>
	<div class="trans_actions">
                <?= Html::a(FA::i('trash'), ['delete', 'id' => $model->id], ['data-method' => 'post']) ?>
                <?= Html::a(FA::i('cog'), ['update', 'id' => $model->id]) ?>
                <?= Html::a(FA::i('eye'), ['view', 'id' => $model->id]) ?>
        </div>
</div>